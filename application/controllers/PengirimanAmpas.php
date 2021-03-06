<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PengirimanAmpas extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    
    function index(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "pengiriman_ampas/index";
        $this->load->model('Model_pengiriman_ampas');
        $data['list_data'] = $this->Model_pengiriman_ampas->po_list()->result();

        $this->load->view('layout', $data);
    }
    
    function add(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        $data['content']= "pengiriman_ampas/add";
        
        $this->load->model('Model_beli_sparepart');
        $data['supplier_list'] = $this->Model_beli_sparepart->supplier_list()->result();
        $this->load->view('layout', $data);
    }
    
    function save(){
        $user_id   = $this->session->userdata('user_id');
        $tanggal   = date('Y-m-d H:i:s');
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $tgl_po = date('Ym', strtotime($this->input->post('tanggal')));
        $user_ppn  = $this->session->userdata('user_ppn');
        
        $this->db->trans_start();
        if($user_ppn == 0){
            $this->load->model('Model_m_numberings');
            $code = $this->Model_m_numberings->getNumbering('PO', $tgl_input); 
        }else{
            $code = 'PO-KMP.'.$tgl_po.'.'.$this->input->post('no_po');
            $count = $this->db->query("Select count(id) as count from po where no_po = '".$code."'")->row_array();
            if($count['count']){
                $this->session->set_flashdata('flash_msg', 'Nomor PO sudah Ada. Please try again!');
                redirect('index.php/BeliRongsok/add');
            }
        }

        $data = array(
            'no_po'=> $code,
            'tanggal'=> $tgl_input,
            'flag_ppn'=> $user_ppn,
            'ppn'=> $this->input->post('ppn'),
            'diskon'=>str_replace('.', '', $this->input->post('diskon')),
            'materai'=>$this->input->post('materai'),
            'currency'=> $this->input->post('currency'),
            'kurs'=> $this->input->post('kurs'),
            'supplier_id'=>$this->input->post('supplier_id'),
            'remarks'=> $this->input->post('remarks'),
            'term_of_payment'=>$this->input->post('term_of_payment'),
            'jenis_po'=>'Ampas',
            'created'=> $tanggal,
            'created_by'=> $user_id,
            'modified'=> $tanggal,
            'modified_by'=> $user_id
        );
        $this->db->insert('po', $data);
        $po_id = $this->db->insert_id();

            if($user_ppn == 1){
                $this->load->helper('target_url');

                $data_id = array('reff1' => $po_id);
                $data_post = array_merge($data, $data_id);

                $data_post = http_build_query($data_post);

                $ch = curl_init(target_url().'api/BeliRongsokAPI/po');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-KEY: 34a75f5a9c54076036e7ca27807208b8'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $result = json_decode($response, true);
                curl_close($ch);
            }

            if($this->db->trans_complete()){
                redirect('index.php/PengirimanAmpas/edit/'.$po_id);  
            }else{
                $this->session->set_flashdata('flash_msg', 'PO ampas gagal disimpan, silahkan dicoba kembali!');
                redirect('index.php/PengirimanAmpas');  
            }
    }    
    
    function edit(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        if($id){
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $data['content']= "pengiriman_ampas/edit";
            $this->load->model('Model_pengiriman_ampas');
            $data['header'] = $this->Model_pengiriman_ampas->show_header_po($id)->row_array();  
            
            $this->load->model('Model_beli_rongsok');
            $data['list_ampas'] = $this->Model_beli_rongsok->show_data_rongsok()->result();
            
            $this->load->model('Model_beli_sparepart');
            $data['supplier_list'] = $this->Model_beli_sparepart->supplier_list()->result();
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/PengirimanAmpas');
        }
    }
    
    function update(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        
        $data = array(
                'tanggal'=> $tgl_input,
                'supplier_id'=>$this->input->post('supplier_id'),
                'term_of_payment'=>$this->input->post('term_of_payment'),
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('po', $data);
        
        $this->session->set_flashdata('flash_msg', 'Data PO ampas berhasil disimpan');
        redirect('index.php/PengirimanAmpas');
    }
    
    function load_detail(){
        $id = $this->input->post('id');
        
        $tabel = "";
        $no    = 1;
        $total = 0;
        $netto = 0;
        
        $this->load->model('Model_pengiriman_ampas'); 
        // $list_ampas = $this->Model_pengiriman_ampas->ampas()->result();
        $myDetail = $this->Model_pengiriman_ampas->load_detail($id)->result(); 
        foreach ($myDetail as $row){
            $tabel .= '<tr>';
            $tabel .= '<td style="text-align:center">'.$no.'</td>';
            $tabel .= '<td>'.$row->nama_item.'</td>';
            $tabel .= '<td>'.$row->uom.'</td>';
            $tabel .= '<td style="text-align:right">'.number_format($row->amount,0,',','.').'</td>';
            $tabel .= '<td style="text-align:right">'.number_format($row->netto,0,',','.').'</td>';
            $tabel .= '<td style="text-align:right">'.number_format($row->total_amount,0,',','.').'</td>';
            $tabel .= '<td style="text-align:center"><a href="javascript:;" class="btn btn-xs btn-circle '
                    . 'red" onclick="hapusDetail('.$row->id.');" style="margin-top:5px"> '
                    . '<i class="fa fa-trash"></i> Delete </a></td>';
            $tabel .= '</tr>';
            $total += $row->total_amount;
            $netto += $row->netto;
            $no++;
        }

        $tabel .= '<tr>';
        $tabel .= '<td colspan="4" style="text-align:right"><strong>Total (Rp) </strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($netto,0,',','.').'</strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($total,0,',','.').'</strong></td>';
        $tabel .= '</tr>';
        
        header('Content-Type: application/json');
        echo json_encode($tabel); 
    }

    function load_detail_spb(){
        $id = $this->input->post('id');
        
        $tabel = "";
        $no    = 1;
        $total = 0;
        $netto = 0;
        
        $this->load->model('Model_pengiriman_ampas'); 
        // $list_ampas = $this->Model_pengiriman_ampas->ampas()->result();
        $myDetail = $this->Model_pengiriman_ampas->load_detail_spb($id)->result(); 
        foreach ($myDetail as $row){
            $tabel .= '<tr>';
            $tabel .= '<td style="text-align:center">'.$no.'</td>';
            $tabel .= '<td>('.$row->kode_rongsok.') '.$row->nama_item.'</td>';
            $tabel .= '<td>'.$row->uom.'</td>';
            $tabel .= '<td style="text-align:right">'.number_format($row->netto,2,',','.').'</td>';
            $tabel .= '<td style="text-align:right">'.$row->keterangan.'</td>';
            $tabel .= '<td style="text-align:center"><a href="javascript:;" class="btn btn-xs btn-circle '
                    . 'red" onclick="hapusDetail('.$row->id.');" style="margin-top:5px"> '
                    . '<i class="fa fa-trash"></i> Delete </a></td>';
            $tabel .= '</tr>';
            $netto += $row->netto;
            $no++;
        }

        $tabel .= '<tr>';
        $tabel .= '<td colspan="3" style="text-align:right"><strong>Total (Rp) </strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($netto,2,',','.').'</strong></td>';
        $tabel .= '<td colspan="2"></td>';
        $tabel .= '</tr>';
        
        header('Content-Type: application/json');
        echo json_encode($tabel); 
    }

    function save_detail_spb(){
        $return_data = array();
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        
        if($this->db->insert('t_spb_ampas_detail', array(
            't_spb_ampas_id'=>$this->input->post('id'),
            'tanggal'=>$tgl_input,
            'jenis_barang_id'=>$this->input->post('barang_id'),
            'uom'=>$this->input->post('uom'),
            'netto'=> $this->input->post('berat'),
            'keterangan'=>$this->input->post('keterangan')
        ))){
            $return_data['message_type']= "sukses";
        }else{
            $return_data['message_type']= "error";
            $return_data['message']= "Gagal menambahkan item ampas! Silahkan coba kembali";
        }
        header('Content-Type: application/json');
        echo json_encode($return_data); 
    }
    
    function delete_detail_spb(){
        $id = $this->input->post('id');
        $return_data = array();
        $this->db->where('id', $id);
        if($this->db->delete('t_spb_ampas_detail')){
            $return_data['message_type']= "sukses";
        }else{
            $return_data['message_type']= "error";
            $return_data['message']= "Gagal menghapus item ampas! Silahkan coba kembali";
        }           
        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function get_uom(){
        $id = $this->input->post('id');
        $this->load->model('Model_ampas');
        $ampas = $this->Model_ampas->show_data($id)->row_array();
        
        header('Content-Type: application/json');
        echo json_encode($ampas); 
    }
    
    function save_detail(){
        $return_data = array();
        
        if($this->db->insert('po_detail', array(
            'po_id'=>$this->input->post('id'),
            'ampas_id'=>$this->input->post('ampas_id'),
            'amount'=>str_replace('.', '', $this->input->post('harga')),
            'qty'=>str_replace('.', '', $this->input->post('qty')),
            'total_amount'=>str_replace('.', '', $this->input->post('total_harga')),
            'bruto'=>str_replace('.', '', $this->input->post('bruto')),
            'netto'=>str_replace('.', '', $this->input->post('netto'))
        ))){
            $return_data['message_type']= "sukses";
        }else{
            $return_data['message_type']= "error";
            $return_data['message']= "Gagal menambahkan item ampas! Silahkan coba kembali";
        }
        header('Content-Type: application/json');
        echo json_encode($return_data); 
    }
    
    function delete_detail(){
        $id = $this->input->post('id');
        $return_data = array();
        $this->db->where('id', $id);
        if($this->db->delete('po_detail')){
            $return_data['message_type']= "sukses";
        }else{
            $return_data['message_type']= "error";
            $return_data['message']= "Gagal menghapus item ampas! Silahkan coba kembali";
        }           
        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    function print_po(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_pengiriman_ampas');
            $data['header']  = $this->Model_pengiriman_ampas->show_header_po($id)->row_array();
            $data['details'] = $this->Model_pengiriman_ampas->show_detail_po($id)->result();

            $this->load->view('print_po_ampas', $data);
        }else{
            redirect('index.php'); 
        }
    }    
        
    function create_dtr(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "pengiriman_ampas/create_dtr";
        $this->load->model('Model_pengiriman_ampas');
        // $data['header'] = $this->Model_pengiriman_ampas->show_header_po($id)->row_array();           
        $data['list_bs'] = $this->Model_pengiriman_ampas->list_bs()->result(); 
        $data['rongsok'] = $this->Model_pengiriman_ampas->rongsok()->result();
        
        $this->load->view('layout', $data); 
    }

    function get_data_bs(){
        $id = $this->input->post('id');
        $this->load->model('Model_pengiriman_ampas');
        $bs_detail= $this->Model_pengiriman_ampas->get_data_bs($id)->row_array();
        
        header('Content-Type: application/json');
        echo json_encode($bs_detail); 
    }
    
    function dtr_list(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "pengiriman_ampas/dtr_list";
        $this->load->model('Model_pengiriman_ampas');
        $data['list_data'] = $this->Model_pengiriman_ampas->dtr_list()->result();

        $this->load->view('layout', $data);
    }
    
    function print_dtr(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_pengiriman_ampas');
            $data['header']  = $this->Model_pengiriman_ampas->show_header_dtr($id)->row_array();
            $data['details'] = $this->Model_pengiriman_ampas->show_detail_dtr($id)->result();

            $this->load->view('print_dtr_ampas', $data);
        }else{
            redirect('index.php'); 
        }
    }
    
    function surat_jalan(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "pengiriman_ampas/surat_jalan";
        $this->load->model('Model_pengiriman_ampas');
        $data['list_data'] = $this->Model_pengiriman_ampas->surat_jalan()->result();

        $this->load->view('layout', $data);
    }
    
    function add_surat_jalan(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        $data['content']= "pengiriman_ampas/add_surat_jalan";
        
        $this->load->model('Model_pengiriman_ampas');
        $data['po_list'] = $this->Model_pengiriman_ampas->get_po_list()->result();
        
        $this->load->model('Model_tolling_titipan');
        $this->load->model('Model_beli_sparepart');
        $data['supplier_list'] = $this->Model_beli_sparepart->supplier_list()->result();

        $data['list_spb'] = $this->Model_pengiriman_ampas->list_spb_kirim()->result();
        $data['kendaraan_list'] = $this->Model_tolling_titipan->kendaraan_list()->result();
        $this->load->view('layout', $data);
    }
    
    function save_surat_jalan(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('SJ', $tgl_input); 
        
        if($code){        
            $data = array(
                'no_surat_jalan'=> $code,
                'tanggal'=> $tgl_input,
                'jenis_barang'=>$this->input->post('jenis_barang'),
                'm_customer_id'=>$this->input->post('m_customer_id'),
                'po_id'=>$this->input->post('po_id'),
                'm_kendaraan_id'=>$this->input->post('m_kendaraan_id'),
                'supir'=>$this->input->post('supir'),
                'remarks'=>$this->input->post('remarks'),
                'created'=> $tanggal,
                'created_by'=> $user_id,
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );

            if($this->db->insert('surat_jalan', $data)){
                redirect('index.php/PengirimanAmpas/edit_surat_jalan/'.$this->db->insert_id());  
            }else{
                $this->session->set_flashdata('flash_msg', 'Data surat jalan gagal disimpan, silahkan dicoba kembali!');
                redirect('index.php/PengirimanAmpas/surat_jalan');  
            }            
        }else{
            $this->session->set_flashdata('flash_msg', 'Data surat jalan gagal disimpan, penomoran belum disetup!');
            redirect('index.php/PengirimanAmpas/surat_jalan');
        }
    }
    
    function edit_surat_jalan(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        if($id){
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $data['content']= "pengiriman_ampas/edit_surat_jalan";
            $this->load->model('Model_pengiriman_ampas');
            $data['header'] = $this->Model_pengiriman_ampas->show_header_sj($id)->row_array();              
            $data['po_list'] = $this->Model_pengiriman_ampas->get_po_list()->result();
        
            $this->load->model('Model_tolling_titipan');            
            $data['customer_list'] = $this->Model_tolling_titipan->customer_list()->result();

            $data['jenis_barang_list'] = $this->Model_tolling_titipan->jenis_barang_list()->result();
            $data['kendaraan_list'] = $this->Model_tolling_titipan->kendaraan_list()->result();
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/PengirimanAmpas/surat_jalan');
        }
    }
    
    function load_detail_surat_jalan(){
        $id = $this->input->post('id');
        
        $tabel = "";
        $no    = 1;
        $bruto = 0;
        $bobin = 0;
        $netto = 0;

        $this->load->model('Model_ampas');
        $list_ampas = $this->Model_ampas->list_data()->result();
        $this->load->model('Model_tolling_titipan'); 
        $list_produksi = $this->Model_tolling_titipan->list_no_produksi()->result();
        
        $this->load->model('Model_pengiriman_ampas'); 
        $myDetail = $this->Model_pengiriman_ampas->load_detail_surat_jalan($id)->result(); 
        foreach ($myDetail as $row){
            $tabel .= '<tr>';
            $tabel .= '<td style="text-align:center">'.$no.'</td>';
            $tabel .= '<td>'.$row->nama_item.'</td>';
            $tabel .= '<td>'.$row->uom.'</td>';
            $tabel .= '<td>'.$row->no_produksi.'</td>';
            $tabel .= '<td>'.$row->no_packing.'</td>';
            $tabel .= '<td style="text-align:right">'.number_format($row->bruto,0,',','.').'</td>';
            $tabel .= '<td style="text-align:right">'.number_format($row->bobin,0,',','.').'</td>';
            $tabel .= '<td style="text-align:right">'.number_format($row->netto,0,',','.').'</td>';
            $tabel .= '<td>'.$row->line_remarks.'</td>';            
            $tabel .= '<td style="text-align:center"><a href="javascript:;" class="btn btn-xs btn-circle '
                    . 'red" onclick="hapusDetail('.$row->id.');" style="margin-top:5px"> '
                    . '<i class="fa fa-trash"></i> Delete </a></td>';
            $tabel .= '</tr>';
            $bruto += $row->bruto;
            $bobin += $row->bobin;
            $netto += $row->netto;
            
            $no++;
        }
            
        $tabel .= '<tr>';
        $tabel .= '<td style="text-align:center">'.$no.'</td>';
        $tabel .= '<td>';
        $tabel .= '<select id="ampas_id" name="ampas_id" class="form-control select2me myline" ';
            $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px" onclick="get_uom(this.value);">';
            $tabel .= '<option value=""></option>';
            foreach ($list_ampas as $value){
                $tabel .= "<option value='".$value->id."'>".$value->nama_item."</option>";
            }
        $tabel .= '</select>';
        $tabel .= '</td>';
        $tabel .= '<td><input type="text" id="uom" name="uom" class="form-control myline" readonly="readonly"></td>';
        
        $tabel .= '<td>';
        $tabel .= '<select id="produksi_ampas_id" name="produksi_ampas_id" class="form-control select2me myline" ';
            $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px">';
            $tabel .= '<option value=""></option>';
            foreach ($list_produksi as $value){
                $tabel .= "<option value='".$value->id."'>".$value->no_produksi."</option>";
            }
        $tabel .= '</select>';
        $tabel .= '</td>';
        
        $tabel .= '<td><input type="text" id="no_packing" name="no_packing" class="form-control myline" '
                . 'onkeyup="this.value = this.value.toUpperCase()"></td>';
        $tabel .= '<td><input type="text" id="bruto" name="bruto" class="form-control myline" '
                . 'onkeydown="return myCurrency(event);" maxlength="10" value="0" onkeyup="getComa(this.value, this.id);"></td>';
        $tabel .= '<td><input type="text" id="bobin" name="bobin" class="form-control myline" '
                . 'onkeydown="return myCurrency(event);" maxlength="10" value="0" onkeyup="getComa(this.value, this.id);"></td>';
        $tabel .= '<td><input type="text" id="netto" name="netto" class="form-control myline" '
                . 'onkeydown="return myCurrency(event);" maxlength="10" value="0" onkeyup="getComa(this.value, this.id);"></td>';
        
        $tabel .= '<td><input type="text" id="line_remarks" name="line_remarks" class="form-control myline" onkeyup="this.value = this.value.toUpperCase()"></td>';        
        $tabel .= '<td style="text-align:center"><a href="javascript:;" class="btn btn-xs btn-circle '
                . 'yellow-gold" onclick="saveDetail();" style="margin-top:5px" id="btnSaveDetail"> '
                . '<i class="fa fa-plus"></i> Tambah </a></td>';
        $tabel .= '</tr>';
        
        $tabel .= '<tr>';
        $tabel .= '<td colspan="5" style="text-align:right"><strong>Total </strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($bruto,0,',','.').'</strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($bobin,0,',','.').'</strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($netto,0,',','.').'</strong></td>';
        $tabel .= '<td></td>';
        $tabel .= '<td></td>';
        $tabel .= '</tr>';
       
        
        header('Content-Type: application/json');
        echo json_encode($tabel); 
    }
    
    function delete_detail_surat_jalan(){
        $id = $this->input->post('id');
        $return_data = array();
        $this->db->where('id', $id);
        if($this->db->delete('surat_jalan_detail')){
            $return_data['message_type']= "sukses";
        }else{
            $return_data['message_type']= "error";
            $return_data['message']= "Gagal menghapus item ampas! Silahkan coba kembali";
        }           
        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function save_detail_surat_jalan(){
        $return_data = array();
        
        if($this->db->insert('surat_jalan_detail', array(
            'surat_jalan_id'=>$this->input->post('id'),
            'ampas_id'=>$this->input->post('ampas_id'),
            'produksi_ampas_id'=>$this->input->post('produksi_ampas_id'),
            'no_packing'=>$this->input->post('no_packing'),
            'bruto'=>str_replace('.', '', $this->input->post('bruto')),
            'bobin'=>str_replace('.', '', $this->input->post('bobin')),
            'netto'=>str_replace('.', '', $this->input->post('netto')),
            'line_remarks'=>str_replace('.', '', $this->input->post('line_remarks'))
        ))){
            $return_data['message_type']= "sukses";
        }else{
            $return_data['message_type']= "error";
            $return_data['message']= "Gagal menambahkan item ampas! Silahkan coba kembali";
        }
        header('Content-Type: application/json');
        echo json_encode($return_data); 
    }
    
    function update_surat_jalan(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');        
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        
        $data = array(
                'tanggal'=> $tgl_input,
                'jenis_barang'=>$this->input->post('jenis_barang'),
                'm_customer_id'=>$this->input->post('m_customer_id'),
                'po_id'=>$this->input->post('po_id'),
                'm_kendaraan_id'=>$this->input->post('m_kendaraan_id'),
                'supir'=>$this->input->post('supir'),
                'remarks'=>$this->input->post('remarks'),
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('surat_jalan', $data);
        
        $this->session->set_flashdata('flash_msg', 'Data surat jalan berhasil disimpan');
        redirect('index.php/PengirimanAmpas/surat_jalan');
    }
    
    function print_surat_jalan(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_pengiriman_ampas');
            $data['header']  = $this->Model_pengiriman_ampas->show_header_sj($id)->row_array();
            $data['details'] = $this->Model_pengiriman_ampas->load_detail_surat_jalan($id)->result();

            $this->load->view('print_sj_ampas', $data);
        }else{
            redirect('index.php'); 
        }
    } 
    
    function spb_list(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "pengiriman_ampas/spb_list";
        $this->load->model('Model_pengiriman_ampas');
        $data['list_data'] = $this->Model_pengiriman_ampas->spb_list()->result();

        $this->load->view('layout', $data);
    }

    function add_spb(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "pengiriman_ampas/add_spb";
        
        $this->load->view('layout', $data);
    }

    function save_spb(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('SPB-AMP', $tgl_input); 
        
        if($code){
            $data = array(
                'tanggal'=> $tgl_input,
                'no_spb_ampas'=> $code,
                'status'=>0,
                'keterangan'=>$remarks,
                'created_at'=> $tanggal,
                'created_by'=> $user_id
            );

            if($this->db->insert('t_spb_ampas', $data)){
                redirect('index.php/PengirimanAmpas/edit_spb/'.$this->db->insert_id());  
            }else{
                $this->session->set_flashdata('flash_msg', 'Data SPB WIP gagal disimpan, silahkan dicoba kembali!');
                redirect('index.php/PengirimanAmpas/add_spb');  
            }            
        }else{
            $this->session->set_flashdata('flash_msg', 'Data SPB WIP gagal disimpan, penomoran belum disetup!');
            redirect('index.php/PengirimanAmpas/spb_list');
        }
    }

    function edit_spb(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        if($id){
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $data['content']= "pengiriman_ampas/edit_spb";
            $this->load->model('Model_pengiriman_ampas');
            $data['header'] = $this->Model_pengiriman_ampas->show_header_spb($id)->row_array();
            $this->load->model('Model_beli_rongsok');
            $data['list_barang'] = $this->Model_beli_rongsok->show_data_rongsok()->result();

            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/PengirimanAmpas/spb_list');
        }
    }

    function update_spb(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));

            $data = array(
                'tanggal'=> $tgl_input,
                'keterangan'=>$this->input->post('remarks')
            );
            $this->db->where('id',$this->input->post('id'));
            if($this->db->update('t_spb_ampas', $data)){
                redirect('index.php/PengirimanAmpas/spb_list');  
            }else{
                $this->session->set_flashdata('flash_msg', 'Data SPB WIP gagal disimpan, silahkan dicoba kembali!');
                redirect('index.php/PengirimanAmpas/edit_spb/'.$this->input->post('id'));
            }
    }

    function view_spb(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        if($id){
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $data['content']= "pengiriman_ampas/view_spb";

            // $this->load->model('Model_gudang_fg');
            // $data['list_barang'] = $this->Model_gudang_fg->jenis_barang_list_by_spb($id)->result();
            // $data['myData'] = $this->Model_gudang_fg->show_header_spb($id)->row_array();           
            // $data['myDetail'] = $this->Model_gudang_fg->show_detail_spb($id)->result(); 
            // $data['detailSPB'] = $this->Model_gudang_fg->show_detail_spb_fulfilment($id)->result();
            $this->load->model('Model_pengiriman_ampas');
            $data['list_barang'] = $this->Model_pengiriman_ampas->jenis_barang_stok()->result();

            $data['myData'] = $this->Model_pengiriman_ampas->show_header_spb($id)->row_array();
            $data['myDetail'] = $this->Model_pengiriman_ampas->show_detail_spb($id)->result();
            $data['detailSPB'] = $this->Model_pengiriman_ampas->show_detail_spb_fulfilment($id)->result();
            $data['detailFulfilment'] = $this->Model_pengiriman_ampas->show_spb_fulfilment($id)->result();
            
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/PengirimanAmpas/spb_list');
        }
    }

    function print_spb_fulfilment(){
        $id = $this->uri->segment(3);
        if($id){
            $this->load->helper('tanggal_indo_helper');
            $this->load->model('Model_pengiriman_ampas');
            $data['header']  = $this->Model_pengiriman_ampas->show_header_spb($id)->row_array();
            $data['details'] = $this->Model_pengiriman_ampas->show_detail_spb_fulfilment($id)->result();

            $this->load->view('pengiriman_ampas/print_spb_fulfilment', $data);
        }else{
            redirect('index.php'); 
        }
    }

    function print_spb(){
        $id = $this->uri->segment(3);
        if($id){
            $this->load->helper('tanggal_indo_helper');
            $this->load->model('Model_pengiriman_ampas');
            $data['header']  = $this->Model_pengiriman_ampas->show_header_spb($id)->row_array();
            $data['details'] = $this->Model_pengiriman_ampas->show_detail_spb($id)->result();

            $this->load->view('pengiriman_ampas/print_spb', $data);
        }else{
            redirect('index.php'); 
        }
    }

    function save_detail_spb_fulfilment(){
        $return_data = array();
        
        if($this->db->insert('t_spb_ampas_fulfilment', array(
            't_spb_ampas_id'=>$this->input->post('spb_id'),
            'jenis_barang_id'=>$this->input->post('jenis_barang_id'),
            'berat'=>str_replace(',', '', $this->input->post('berat')),
            'keterangan'=> $this->input->post('keterangan')
        ))){
            $return_data['message_type']= "sukses";
        }else{
            $return_data['message_type']= "error";
            $return_data['message']= "Gagal menambahkan item ampas! Silahkan coba kembali";
        }
        header('Content-Type: application/json');
        echo json_encode($return_data); 
    }

    function delete_detail_spb_fulfilment(){
        $id = $this->input->post('id');

        $this->db->where('id', $id);
        if($this->db->delete('t_spb_ampas_fulfilment')){
            $return_data['message_type']= "sukses";
        }else{
            $return_data['message_type']= "error";
            $return_data['message']= "Gagal menghapus item barang! Silahkan coba kembali";
        }           
        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    function save_spb_fulfilment(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $tgl_input = date('Y-m-d');
        $spb_id = $this->input->post('id');
        
        $this->db->trans_start();
        
        #Update status SPB
        $this->db->where('id', $spb_id);
        $this->db->update('t_spb_ampas', array(
                        'status'=> 3,
                        'keterangan' => $this->input->post('remarks'),
                        'modified_at'=> $tanggal,
                        'modified_by'=>$user_id
        ));

            if($this->db->trans_complete()){    
                $this->session->set_flashdata('flash_msg', 'Detail SPB sudah disimpan');            
            }else{
                $this->session->set_flashdata('flash_msg', 'Terjadi kesalahan saat pembuatan Balasan SPB, silahkan coba kembali!');
            }             
        
       redirect('index.php/PengirimanAmpas/spb_list');
    }

    function load_detail_saved_item(){
        $id = $this->input->post('id');
        
        $tabel = "";
        $no    = 1;
        $total = 0;
        
        $this->load->model('Model_pengiriman_ampas'); 
        $myDetail = $this->Model_pengiriman_ampas->load_detail_saved_item($id)->result(); 
        foreach ($myDetail as $row){
            $tabel .= '<tr>';
            $tabel .= '<td style="text-align:center">'.$no.'</td>';
            $tabel .= '<td>'.$row->nama_item.'</td>';
            $tabel .= '<td>'.$row->uom.'</td>';
            $tabel .= '<td>'.number_format($row->berat,2,',','.').'</td>';
            $tabel .= '<td>'.$row->keterangan.'</td>';
            $tabel .= '<td style="text-align:center"><a href="javascript:;" class="btn btn-xs btn-circle '
                    . 'red" onclick="hapusDetail('.$row->id.');" style="margin-top:5px"> '
                    . '<i class="fa fa-trash"></i> Delete </a></td>';
            $tabel .= '</tr>';
            $total += $row->berat;
            $no++;
        }

        $tabel .= '<tr>';
        $tabel .= '<td colspan="3" style="text-align:right"><strong>Total (Kg) </strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($total,2,',','.').'</strong></td>';
        $tabel .= '<td colspan="2"></td>';
        $tabel .= '</tr>';

        header('Content-Type: application/json');
        echo json_encode($tabel);
    }

    function approve_spb(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $tgl_input = date('Y-m-d');
        $spb_id = $this->input->post('id');
        
        $this->db->trans_start();
        $this->load->model('Model_pengiriman_ampas');
        $data['check'] = $this->Model_pengiriman_ampas->check_spb($spb_id)->row_array();
        if(((int)$data['check']['fulfilment']) >= (0.9*((int)$data['check']['spb']))){
            $status = 1;
        }else{
            $status = 4;
        }
        
        #Update status SPB
        $this->db->where('id', $spb_id);
        $this->db->update('t_spb_ampas', array(
                        'status'=> $status,
                        'keterangan' => $this->input->post('remarks'),
                        'approved_at'=> $tanggal,
                        'approved_by'=>$user_id
        ));

        $details = $this->Model_pengiriman_ampas->show_detail_spb_fulfilment($spb_id)->result();
        foreach ($details as $v) {
            $this->db->where('id', $v->id);
            $this->db->update('t_spb_ampas_fulfilment', array(
                            'approved_at'=> $tanggal,
                            'approved_by'=> $user_id
            ));

            $this->db->insert('t_gudang_ampas', array(
                'jenis_trx' => 1,
                'id_spb' => $spb_id,
                'tanggal' => $tgl_input,
                'jenis_barang_id' => 3,
                'rongsok_id' => $v->jenis_barang_id,
                'berat' => $v->berat,
                'created_by' => $user_id,
                'created_at' => $tanggal
            ));
        }
            
            if($this->db->trans_complete()){    
                $this->session->set_flashdata('flash_msg', 'SPB sudah di-approve. Detail SPB sudah disimpan');            
            }else{
                $this->session->set_flashdata('flash_msg', 'Terjadi kesalahan saat pembuatan Balasan SPB, silahkan coba kembali!');
            }             
        
       redirect('index.php/PengirimanAmpas/spb_list');
    }

    function get_stok(){
        $id = $this->input->post('id');
        $this->load->model('Model_pengiriman_ampas');
        $barang= $this->Model_pengiriman_ampas->get_stok($id)->row_array();

        header('Content-Type: application/json');
        echo json_encode($barang);
    }

    function bpb_list(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "pengiriman_ampas/bpb_list";
        $this->load->model('Model_pengiriman_ampas');
        $data['list_data'] = $this->Model_pengiriman_ampas->bpb_list()->result();

        $this->load->view('layout', $data);
    }    

    function view_bpb(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        if($id){
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $data['content']= "pengiriman_ampas/view_bpb";
            $this->load->model('Model_pengiriman_ampas');
            $data['header'] = $this->Model_pengiriman_ampas->show_header_bpb($id)->row_array();
            $data['myDetail'] = $this->Model_pengiriman_ampas->show_detail_bpb($id)->result(); 
    
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/PengirimanAmpas/bpb_list');
        }
    }

    function print_bpb(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_pengiriman_ampas');
            $data['header'] = $this->Model_pengiriman_ampas->show_header_bpb($id)->row_array();
            $data['myDetail'] = $this->Model_pengiriman_ampas->show_detail_bpb($id)->result();

            $this->load->view('pengiriman_ampas/print_bpb', $data);
        }else{
            redirect('index.php/PengirimanAmpas/bpb_list');
        }
    }

    function approve_bpb(){
        $bpb_id = $this->input->post('id');
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $return_data = array();
        
        $this->db->trans_start();       
         
            #Update status BPB
            $this->db->where('id', $bpb_id);
            $this->db->update('t_bpb_ampas', array(
                    'status'=>1,
                    'keterangan' => $this->input->post('remarks'),
                    'approved_date'=>$tanggal,
                    'approved_by'=>$user_id));
            
            #Insert Gudang Ampas
            $key = $this->db->query("select tbad.*, thm.id_produksi
                from t_bpb_ampas_detail tbad
                left join t_bpb_ampas tba on (tbad.bpb_ampas_id = tba.id)
                left join t_hasil_masak thm on (tba.hasil_masak_id = thm.id)
                where tbad.bpb_ampas_id = ".$bpb_id)->result();
            foreach ($key as $row) {
                $this->db->insert('t_gudang_ampas', array(
                    'tanggal' => $tgl_input,
                    'jenis_trx' => 0,
                    'jenis_barang_id' => 3,
                    'rongsok_id' => $row->jenis_barang_id,
                    'berat' => $row->berat,
                    'id_produksi' => $row->id_produksi,
                    'created_by' => $user_id,
                    'created_at' => $tanggal
                ));
            }
            
            if($this->db->trans_complete()){  
                $this->session->set_flashdata("message", "Penerimaan Ampas sudah dibuat dan masuk gudang");
            }else{
                $this->session->set_flashdata("message","Penerimaan Ampas gagal, silahkan coba lagi!");
            }                  
        redirect("index.php/PengirimanAmpas/bpb_list");
    }

    function reject_bpb(){
        $bpb_id = $this->input->post('id');
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $tgl_input = date('Y-m-d');      
         
            #Update status BPB
            $this->db->where('id', $this->input->post('header_id'));
            $this->db->update('t_bpb_ampas', array(
                    'status'=>9,
                    'keterangan' => $this->input->post('reject_remarks'),
                    'rejected_at'=>$tanggal,
                    'rejected_by'=>$user_id));
            
            $this->session->set_flashdata("message", "Reject Ampas sudah dibuat dan masuk gudang");
      
      redirect("index.php/PengirimanAmpas/bpb_list");   
    }

    function reject_spb(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $id_spb = $this->input->post('header_id');
        
        #Update status t_spb_fg
        $data = array(
                'status'=> 0,
                'rejected_at'=> $tanggal,
                'rejected_by'=>$user_id,
                'reject_remarks'=>$this->input->post('reject_remarks')
            );
        
        $this->db->where('id', $id_spb);
        $this->db->update('t_spb_ampas', $data);

        #Update NULL di t_gudang_fg
        // $this->db->where('t_spb_fg_id', $id_spb);
        // $this->db->update('t_gudang_fg', array(
        //                 'jenis_trx'=>0,
        //                 't_spb_fg_id'=> NULL,
        //                 't_spb_fg_detail_id'=> NULL,
        //                 'nomor_SPB'=> NULL,
        //                 'keterangan'=> NULL,
        //                 'modified_date'=> $tanggal,
        //                 'modified_by'=>$user_id
        // ));
        
        $this->session->set_flashdata('flash_msg', 'Data SPB FG berhasil direject');
        redirect('index.php/PengirimanAmpas/spb_list');
    }

    function tambah_spb(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $id_spb = $this->input->post('id');
        
        #Update status t_spb_fg
        $data = array(
                'status'=> 0
            );
        
        $this->db->where('id', $id_spb);
        $this->db->update('t_spb_ampas', $data);

        #Update NULL di t_gudang_fg
        // $this->db->where('t_spb_fg_id', $id_spb);
        // $this->db->update('t_gudang_fg', array(
        //                 'jenis_trx'=>0,
        //                 't_spb_fg_id'=> NULL,
        //                 't_spb_fg_detail_id'=> NULL,
        //                 'nomor_SPB'=> NULL,
        //                 'keterangan'=> NULL,
        //                 'modified_date'=> $tanggal,
        //                 'modified_by'=>$user_id
        // ));
        
        $this->session->set_flashdata('flash_msg', 'Data SPB FG berhasil direject');
        redirect('index.php/PengirimanAmpas/view_spb/'.$id_spb);
    }

    function gudang_ampas(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "pengiriman_ampas/gudang_ampas";
        $this->load->model('Model_pengiriman_ampas');
        $data['list_data'] = $this->Model_pengiriman_ampas->gudang_ampas()->result();

        $this->load->view('layout', $data);
    }

    function gudang_bs(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "pengiriman_ampas/gudang_bs";
        $this->load->model('Model_pengiriman_ampas');
        $data['list_data'] = $this->Model_pengiriman_ampas->gudang_bs()->result();

        $this->load->view('layout', $data);
    }

    function kirim_bs(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "pengiriman_ampas/kirim_bs";
        $this->load->model('Model_pengiriman_ampas');
        $data['list_data'] = $this->Model_pengiriman_ampas->gudang_bs()->result();

        $this->load->view('layout', $data);
    }

    /*function matching(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "beli_rongsok/matching";
        $this->load->model('Model_beli_rongsok');
        $data['po_list'] = $this->Model_beli_rongsok->get_po_list()->result();

        $this->load->view('layout', $data);
    }
    
    function proses_matching(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $po_id = $this->uri->segment(3);
        
        $data['content']= "beli_rongsok/proses_matching";
        $this->load->model('Model_beli_rongsok');
        $data['header_po']  = $this->Model_beli_rongsok->show_header_po($po_id)->row_array();
        $data['details_po'] = $this->Model_beli_rongsok->show_detail_po($po_id)->result();
        
        $dtr = $this->Model_beli_rongsok->get_dtr($po_id)->result();
        foreach ($dtr as $index=>$row){
            $dtr[$index]->details = $this->Model_beli_rongsok->show_detail_dtr($row->id)->result();
        }
        $data['dtr'] = $dtr;
        $this->load->view('layout', $data);
    }
    
    function approve(){
        $dtr_id = $this->input->post('dtr_id');
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $return_data = array();
        
        $this->db->where('id', $dtr_id);
        if($this->db->update('dtr', array(
                    'status'=>1,
                    'approved'=>$tanggal,
                    'approved_by'=>$user_id
        ))){
            $return_data['type_message']= "sukses";
        }else{
            $return_data['type_message']= "error";
            $return_data['message']= "Terjadi kesalahan saat meng-update data DTR, silahkan coba kembali...";
        }
        
        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function reject(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        
        $data = array(
                'status'=> 9,
                'rejected'=> $tanggal,
                'rejected_by'=>$user_id,
                'reject_remarks'=>$this->input->post('reject_remarks')
            );
        
        $this->db->where('id', $this->input->post('dtr_id'));
        $this->db->update('dtr', $data);

        redirect('index.php/BeliRongsok/proses_matching/'.$this->input->post('po_id'));
    }
    
    function edit_dtr(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        if($id){
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $data['content']= "beli_rongsok/edit_dtr";
            $this->load->model('Model_beli_rongsok');
            $data['header']  = $this->Model_beli_rongsok->show_header_dtr($id)->row_array(); 
            $data['details'] = $this->Model_beli_rongsok->show_detail_dtr($id)->result();
            
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/BeliRongsok');
        }
    }
    
    function update_dtr(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        
        $this->db->trans_start();
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('dtr', array(
                    'status'=>0,
                    'remarks'=>$this->input->post('remarks'),
                    'modified'=>$tanggal,
                    'modified_by'=>$user_id
        ));
        
        $details = $this->input->post('myDetails');
        foreach($details as $row){
            $this->db->where('id', $row['id']);
            $this->db->update('dtr_detail', array(
                'bruto'=>str_replace('.','', $row['bruto']),
                'netto'=>str_replace('.','', $row['netto']),
                'line_remarks'=>$row['line_remarks'],
                'no_pallete'=>$row['no_pallete'],
                'modified'=>$tanggal,
                'modified_by'=>$user_id
            ));
        }
        
        if($this->db->trans_complete()){    
            $this->session->set_flashdata('flash_msg', 'DTR dengan nomor : '.$this->input->post('no_dtr').' berhasil diupdate...');                 
        }else{
            $this->session->set_flashdata('flash_msg', 'Terjadi kesalahan saat updates DTR, silahkan coba kembali!');
        }
        redirect('index.php/BeliRongsok/dtr_list');
    }
    
    function create_ttr(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        if($id){
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $data['content']= "beli_rongsok/create_ttr";
            $this->load->model('Model_beli_rongsok');
            $data['header'] = $this->Model_beli_rongsok->show_header_dtr($id)->row_array();           
            $data['details'] = $this->Model_beli_rongsok->show_detail_dtr($id)->result(); 
            
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/BeliRongsok');
        }
    }
    
    function save_ttr(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));

        $this->db->trans_start();
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('TTR', $tgl_input); 
        
        if($code){        
            $data = array(
                        'no_ttr'=> $code,
                        'tanggal'=> $tgl_input,
                        'dtr_id'=> $this->input->post('dtr_id'),
                        'jmlh_afkiran'=>str_replace('.','', $this->input->post('jmlh_afkiran')),
                        'jmlh_pengepakan'=>str_replace('.','', $this->input->post('jmlh_pengepakan')),
                        'jmlh_lain'=>str_replace('.','', $this->input->post('jmlh_lain')),
                        'remarks'=> $this->input->post('remarks'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id
                    );
            $this->db->insert('ttr', $data);
            $dtr_id = $this->db->insert_id();
            $details = $this->input->post('myDetails');
            foreach ($details as $row){
                if(isset($row['check']) && $row['check']==1){
                    $this->db->insert('ttr_detail', array(
                        'ttr_id'=>$dtr_id,
                        'dtr_detail_id'=>$row['dtr_detail_id'],
                        'rongsok_id'=>$row['rongsok_id'],
                        'qty'=>$row['qty'],
                        'bruto'=>$row['bruto'],
                        'netto'=>$row['netto'],
                        'line_remarks'=>$row['line_remarks']
                    ));
                    
                    $this->db->where('id', $row['dtr_detail_id']);
                    $this->db->update('dtr_detail', array('flag_ttr'=>1));
                }
            }
            
            if($this->db->trans_complete()){    
                $this->session->set_flashdata('flash_msg', 'TTR berhasil di-create dengan nomor : '.$code);                 
            }else{
                $this->session->set_flashdata('flash_msg', 'Terjadi kesalahan saat create TTR, silahkan coba kembali!');
            }
            redirect('index.php/BeliRongsok/dtr_list');           
        }else{
            $this->session->set_flashdata('flash_msg', 'Pembuatan TTR gagal, penomoran belum disetup!');
            redirect('index.php/BeliRongsok/dtr_list');
        }
    }
    
    function ttr_list(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "beli_rongsok/ttr_list";
        $this->load->model('Model_beli_rongsok');
        $data['list_data'] = $this->Model_beli_rongsok->ttr_list()->result();

        $this->load->view('layout', $data);
    }
    
    function print_ttr(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_beli_rongsok');
            $data['header']  = $this->Model_beli_rongsok->show_header_ttr($id)->row_array();
            $data['details'] = $this->Model_beli_rongsok->show_detail_ttr($id)->result();

            $this->load->view('print_ttr', $data);
        }else{
            redirect('index.php'); 
        }
    }
    
    function create_voucher_pelunasan(){
        $id = $this->input->post('id');
        $this->load->model('Model_beli_rongsok');
        $data = $this->Model_beli_rongsok->get_data_pelunasan($id)->row_array(); 
        $sisa = $data['nilai_po']- $data['nilai_dp'];
        $data['nilai_po'] = number_format($data['nilai_po'],0,',','.');
        $data['nilai_dp'] = number_format($data['nilai_dp'],0,',','.');
        $data['sisa']     = number_format($sisa,0,',','.');
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function save_voucher_pelunasan(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        
        $this->db->trans_start();
        $this->load->model('Model_m_numberings');
        $code = $this->Model_m_numberings->getNumbering('VRSK', $tgl_input); 
        if($code){ 
            $this->db->insert('voucher', array(
                'no_voucher'=>$code,
                'tanggal'=>$tgl_input,
                'jenis_voucher'=>'Pelunasan',
                'po_id'=>$this->input->post('po_id'),
                'ttr_id'=>$this->input->post('id'),
                'jenis_barang'=>$this->input->post('jenis_barang'),
                'amount'=>str_replace('.', '', $this->input->post('amount')),
                'keterangan'=>$this->input->post('keterangan'),
                'created'=> $tanggal,
                'created_by'=> $user_id,
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            ));
            
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('ttr', array('flag_bayar'=>1));
            
            if($this->db->trans_complete()){    
                $this->session->set_flashdata('flash_msg', 'Voucher Pelunasan rongsok berhasil di-create dengan nomor : '.$code);                 
            }else{
                $this->session->set_flashdata('flash_msg', 'Terjadi kesalahan saat create voucher Pelunasan rongsok, silahkan coba kembali!');
            }
            redirect('index.php/BeliRongsok/ttr_list');  
        }else{
            $this->session->set_flashdata('flash_msg', 'Pembuatan voucher rongsok gagal, penomoran belum disetup!');
            redirect('index.php/BeliRongsok/ttr_list');
        }
    }*/
    function create_dta(){
        $module_name = $this->uri->segment(1);
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $data['content']= "pengiriman_ampas/create_dta";
            $this->load->model('Model_beli_rongsok');
            $data['rongsok'] = $this->Model_beli_rongsok->show_data_rongsok()->result();
            $data['supplier_list'] = $this->Model_beli_rongsok->supplier_list()->result();
            $this->load->view('layout', $data);
    }

    function save_dta(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));

        $this->db->trans_start();
        $this->load->model('Model_m_numberings');

        $code = $this->Model_m_numberings->getNumbering('BPB-AMP', $tgl_input);

        if($code){        
            $data = array(
                        'no_bpb'=> $code,
                        'tanggal'=> $tgl_input,
                        'status'=> 0,
                        'hasil_masak_id'=> 0,
                        'keterangan'=> $this->input->post('remarks'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id
                    );
            $this->db->insert('t_bpb_ampas', $data);
            $insert_id = $this->db->insert_id();
            $details = $this->input->post('details');
            foreach ($details as $row){
                if($row['jenis_barang_id']!=0){
                    $this->db->insert('t_bpb_ampas_detail', array(
                        'bpb_ampas_id'=>$insert_id,
                        'jenis_barang_id'=>$row['jenis_barang_id'],
                        'qty'=>0,
                        'berat'=>$row['berat'],
                        'keterangan'=>$row['ket']
                    ));
                }
            }
                    
            if($this->db->trans_complete()){    
                $this->session->set_flashdata('flash_msg', 'DTWIP berhasil di-create dengan nomor : '.$code);                 
            }else{
                $this->session->set_flashdata('flash_msg', 'Terjadi kesalahan saat create DTWIP, silahkan coba kembali!');
            }
            redirect('index.php/PengirimanAmpas/bpb_list');           
        }else{
            $this->session->set_flashdata('flash_msg', 'Pembuatan DTWIP gagal, penomoran belum disetup!');
            redirect('index.php/PengirimanAmpas/bpb_list');
        }
    }
    
    // function dtr_list(){
    //     $module_name = $this->uri->segment(1);
    //     $group_id    = $this->session->userdata('group_id');        
    //     if($group_id != 1){
    //         $this->load->model('Model_modules');
    //         $roles = $this->Model_modules->get_akses($module_name, $group_id);
    //         $data['hak_akses'] = $roles;
    //     }
    //     $data['group_id']  = $group_id;

    //     $data['content']= "pengiriman_ampas/dtr_list";
    //     $this->load->model('Model_pengiriman_ampas');
    //     $data['list_data'] = $this->Model_pengiriman_ampas->dtr_list()->result();

    //     $this->load->view('layout', $data);
    // }
    
    // function print_dtr(){
    //     $id = $this->uri->segment(3);
    //     if($id){        
    //         $this->load->model('Model_pengiriman_ampas');
    //         $data['header']  = $this->Model_pengiriman_ampas->show_header_dtr($id)->row_array();
    //         $data['details'] = $this->Model_pengiriman_ampas->show_detail_dtr($id)->result();

    //         $this->load->view('print_dtr_ampas', $data);
    //     }else{
    //         redirect('index.php'); 
    //     }
    // }
}