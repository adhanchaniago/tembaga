<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SalesOrder extends CI_Controller{
    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    
    function index(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');    
        $ppn         = $this->session->userdata('user_ppn');
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "sales_order/index";
        $this->load->model('Model_sales_order');
        $data['list_data'] = $this->Model_sales_order->so_list($ppn)->result();

        $this->load->view('layout', $data);
    }

    function filter_so(){
        $surat_jalan = $this->input->post('surat_jalan');
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "sales_order/index";
        $this->load->model('Model_sales_order');
        $data['list_data'] = $this->Model_sales_order->filter_so_list($surat_jalan)->result();

        $this->load->view('layout', $data);
    }

    function get_penomoran_so(){
        $tgl_so = date('Ym', strtotime($this->input->post('tanggal')));
        
        $code = 'SO-KMP.'.$tgl_so.'.'.$this->input->post('no_so');
        
        $count = $this->db->query("Select count(id) as count from sales_order where no_sales_order = '".$code."'")->row_array();
        if($count['count']>0){
            $data['type'] = 'duplicate';
        }else{
            $data['type'] = 'sukses';
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    function add(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        $ppn = $this->session->userdata('user_ppn');
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        $data['content']= "sales_order/add";
        
        $this->load->model('Model_sales_order');
        $data['customer_list'] = $this->Model_sales_order->customer_list()->result();
        $data['marketing_list'] = $this->Model_sales_order->marketing_list()->result();
        $data['no_so_kmp'] = $this->Model_sales_order->get_last_so($ppn)->row_array();
        if($ppn == 1){
            $data['no_so_cv'] = $this->Model_sales_order->get_last_so_cv()->row_array();
        }
        // $data['option_jenis_barang'] = $this->Model_sales_order->jenis_barang_list()->result();
        $this->load->view('layout', $data);
    }

    function view_so(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        $data['content']= "sales_order/view_so";
        
            $this->load->model('Model_sales_order');
            $data['header']  = $this->Model_sales_order->show_header_so($id)->row_array();
            if($data['header']['jenis_barang'] == 'RONGSOK' || $data['header']['jenis_barang'] == 'AMPAS'){
            $data['detailSPB'] = $this->Model_sales_order->show_detail_spb_fulfilment_rsk($id)->result();
            $data['details'] = $this->Model_sales_order->show_detail_so_rsk($id)->result();
            // $data['detailSJ'] = $this->Model_sales_order->load_detail_view_sj_rsk($id)->result();
            }else if($data['header']['jenis_barang'] == 'LAIN'){
            $data['details'] = $this->Model_sales_order->show_detail_so_sp($id)->result();
            // $data['detailSJ'] = $this->Model_sales_order->load_detail_view_sj_sp($id)->result();
            }else{
            $data['detailSPB'] = $this->Model_sales_order->show_detail_spb_fulfilment($id)->result();
            $data['details'] = $this->Model_sales_order->show_detail_so($id)->result();
            // $data['detailSJ'] = $this->Model_sales_order->load_detail_view_sj($id)->result();
            }

            $this->load->view('layout', $data);
    }
    
    function get_contact_name(){
        $id = $this->input->post('id');
        $this->load->model('Model_sales_order');
        $data = $this->Model_sales_order->get_contact_name($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data); 
    }
    
    function get_uom(){
        $id = $this->input->post('id');
        $this->load->model('Model_sales_order');
        $rongsok= $this->Model_sales_order->show_data($id)->row_array();
        
        header('Content-Type: application/json');
        echo json_encode($rongsok); 
    }

    function get_uom_so(){
        $id = $this->input->post('id');
        $jenis = $this->input->post('jenis');
        $this->load->model('Model_sales_order');
        
        if($jenis == 'RONGSOK'){
            $jenis_barang= $this->Model_sales_order->get_uom_so($id)->row_array();
        }else if($jenis == 'LAIN'){
            $jenis_barang= $this->Model_sales_order->get_uom_sp($id)->row_array();
        }else{
            $jenis_barang= $this->Model_sales_order->show_data($id)->row_array();
        }
        
        header('Content-Type: application/json');
        echo json_encode($jenis_barang); 
    }

    function print_so(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_sales_order');
            $data['header']  = $this->Model_sales_order->show_header_so($id)->row_array();
            if($data['header']['jenis_barang']=='RONGSOK' || $data['header']['jenis_barang']=='AMPAS'){
                $data['details'] = $this->Model_sales_order->show_detail_so_rsk($id)->result();
            }else if($data['header']['jenis_barang']=='LAIN'){
                $data['details'] = $this->Model_sales_order->show_detail_so_sp($id)->result();
            }else{
                $data['details'] = $this->Model_sales_order->show_detail_so($id)->result();
            }

            $this->load->view('sales_order/print_so', $data);
        }else{
            redirect('index.php'); 
        }
    }    

    function load_detail_so(){
        $id = $this->input->post('id');
        $jenis = $this->input->post('jenis');
        
        $tabel = "";
        $no    = 1;
        $total_qty = 0;
        $total = 0;
        $bruto = 0;
        $netto = 0;
        
        $this->load->model('Model_sales_order');  
        if($jenis == 'RONGSOK' || $jenis == 'AMPAS'){
        $myDetail = $this->Model_sales_order->load_detail_so_rongsok($id)->result();
        }else if($jenis == 'LAIN'){
        $myDetail = $this->Model_sales_order->load_detail_so_sp($id)->result();
        }else{
        $myDetail = $this->Model_sales_order->load_detail_so($id)->result();
        }
        foreach ($myDetail as $row){
            $tabel .= '<tr>';
            $tabel .= '<td style="text-align:center">'.$no.'</td>';
            $tabel .= '<td>('.$row->kode.') '.$row->nama_barang.'</td>';
            $tabel .= '<td>'.$row->nama_barang_alias.'</td>';
            $tabel .= '<td style="text-align:right">'.number_format($row->amount,3,',','.').'</td>';
            if($jenis == 'WIP'){
            $tabel .= '<td style="text-align:right">'.number_format($row->qty,0,',','.').'</td>';
            $tabel .= '<td style="text-align:right">'.number_format($row->netto,2,',','.').'</td>';
            }else if($jenis == 'FG' || $jenis == 'AMPAS'){
            $tabel .= '<td style="text-align:right">'.number_format($row->netto,2,',','.').'</td>';
            }else{
            $tabel .= '<td style="text-align:right">'.number_format($row->qty,2,',','.').'</td>';
            }
            $tabel .= '<td style="text-align:right">'.number_format($row->total_amount,2,',','.').'</td>';
            $tabel .= '<td style="text-align:center"><a href="javascript:;" class="btn btn-xs btn-circle '
                    . 'red" onclick="hapusDetail('.$row->id.');" style="margin-top:5px"> '
                    . '<i class="fa fa-trash"></i> Delete </a></td>';
            $tabel .= '</tr>';
            $total_qty += $row->qty;
            $total += $row->total_amount;
            $bruto += $row->bruto;
            $netto += $row->netto;
            
            $no++;
        }
        $tabel .= '<tr>';
        if($jenis == 'WIP'){
        $tabel .= '<td colspan="4" style="text-align:right"><strong>Total </strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($total_qty,0,',','.').'</strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($netto,2,',','.').'</strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($total,0,',','.').'</strong></td>';
        }else if($jenis == 'FG'){
        $tabel .= '<td colspan="4" style="text-align:right"><strong>Total </strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($netto,2,',','.').'</strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($total,2,',','.').'</strong></td>';
        }else {
        $tabel .= '<td colspan="5" style="text-align:right"><strong>Total </strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($total,2,',','.').'</strong></td>';
        }
        $tabel .= '<td></td>';
        $tabel .= '</tr>';
        
        header('Content-Type: application/json');
        echo json_encode($tabel); 
    }

    function load_detail_so_edit(){
        $id = $this->input->post('id');
        $jenis = $this->input->post('jenis');

        $no = 1;
        $total = 0;
        $qty = 0;
        $amount = 0;
        $netto = 0;
        $tabel = "";
        $this->load->model('Model_sales_order'); 
        if($jenis == 'RONGSOK' || $jenis == 'AMPAS'){
            $myDetail = $this->Model_sales_order->load_detail_so_rongsok($id)->result();
        }else{
            $myDetail = $this->Model_sales_order->load_detail_so($id)->result();
        }
        foreach ($myDetail as $row) {
            $tabel .= '<tr>';
            $tabel .= '<td style="text-align: center;">'.$no.'</td>';
            $tabel .= '<td><label id="lbl_jenis_barang_'.$no.'">('.$row->kode.') '.$row->nama_barang.'</label>';
            $tabel .= '<input typed="text" id="jenis_barang_id_'.$no.'" name="jenis_barang_id_'.$no.'" class="form-control select2me myline" readonly="readonly" value="('.$row->kode.') '.$row->nama_barang.'"';
            $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none">';
            $tabel .= '<input type="hidden" id="detail_id_'.$no.'" name="detail_id_'.$no.'" value="'.$row->id.'">';
            $tabel .= '<input type="hidden" id="spb_detail_id_'.$no.'" name="spb_detail_id_'.$no.'" value="'.$row->no_spb_detail.'">';
            $tabel .= '</td>';
            $tabel .= '<td><label id="lbl_nama_barang_alias_'.$no.'">'.$row->nama_barang_alias.'</label>';
            $tabel .= '<input type="text" id="nama_barang_alias_'.$no.'" name="nama_barang_alias_'.$no.'" class="form-control myline" value="'.$row->nama_barang_alias.'" style="display:none;"/></td>';
            $tabel .= '<td><label id="lbl_uom_'.$no.'">'.$row->uom.'</label>';
            $tabel .= '<input type="text" id="uom_'.$no.'" name="uom_'.$no.'" class="form-control myline" value="'.$row->uom.'" readonly  style="display:none;"/></td>';
            $tabel .= '<td style="text-align:right;"><label id="lbl_amount_'.$no.'">'.number_format($row->amount,2,',','.').'</label>';
            $tabel .= '<input type="text" id="amount_'.$no.'" name="amount_'.$no.'" class="form-control myline" value="'.number_format($row->amount,2,'.',',').'" maxlength="10" value="0" onkeyup="getComa_a(this.value, this.id,'.$no.');"  style="display:none;"/></td>';
            if($jenis=='RONGSOK'){
            $tabel .= '<td style="text-align:right;"><label id="lbl_netto_'.$no.'">'.number_format($row->qty,2,',','.').'</label>';
            $tabel .= '<input type="text" id="netto_'.$no.'" name="netto_'.$no.'" class="form-control myline" value="'.number_format($row->qty,0,'.',',').'" onkeyup="getComa_a(this.value, this.id,'.$no.');" style="display:none;" maxlength="10" value="0"/></td>';
            $netto += $row->qty;
            }else if($jenis=='WIP'){
            $tabel .= '<td style="text-align:right;"><label id="lbl_qty_'.$no.'">'.number_format($row->qty,2,',','.').'</label>';
            $tabel .= '<input type="text" id="qty_'.$no.'" name="qty_'.$no.'" class="form-control myline" value="'.number_format($row->qty,2,'.',',').'"  style="display:none;" maxlength="10" value="0" readonly="readonly"/></td>';
            $tabel .= '<td style="text-align:right;"><label id="lbl_netto_'.$no.'">'.number_format($row->netto,2,',','.').'</label>';
            $tabel .= '<input type="text" id="netto_'.$no.'" name="netto_'.$no.'" class="form-control myline" value="'.number_format($row->netto,2,'.',',').'" onkeyup="getComa_a(this.value, this.id,'.$no.');" style="display:none;" maxlength="10" value="0"/></td>';
            $qty += $row->qty;
            $netto += $row->netto;
            }else{
            $tabel .= '<td style="text-align:right;"><label id="lbl_netto_'.$no.'">'.number_format($row->netto,2,',','.').'</label>';
            $tabel .= '<input type="text" id="netto_'.$no.'" name="netto_'.$no.'" class="form-control myline" value="'.number_format($row->netto,2,'.',',').'" onkeyup="getComa_a(this.value, this.id,'.$no.');" style="display:none;" maxlength="10" value="0"/></td>';
            $netto += $row->netto;
            }
            $tabel .= '<td style="text-align:right;"><label id="lbl_total_amount_'.$no.'">'.number_format($row->total_amount,2,',','.').'</label>';
            $tabel .= '<input type="text" id="total_amount_'.$no.'" name="total_amount_'.$no.'" class="form-control myline" value="'.number_format($row->total_amount,2,',','.').'" style="display:none;" readonly /></td>';
            $tabel .= '<td style="text-align:center;"><a id="btnEdit_'.$no.'" href="javascript:;" class="btn btn-xs btn-circle '
                    . 'green" onclick="editDetail('.$no.');" style="margin-top:5px"> '
                    . '<i class="fa fa-pencil"></i> Edit </a>';
            $tabel .= '<a id="btnUpdate_'.$no.'" href="javascript:;" class="btn btn-xs btn-circle '
                    . 'green-seagreen" onclick="updateDetail('.$no.');" style="margin-top:5px; display:none;"> '
                    . '<i class="fa fa-save"></i> Update </a>';
            $tabel .= '</tr>';
            $amount += $row->amount;
            $total += $row->total_amount;
            $no++;
        }
        $tabel .= '<tr>';
        $tabel .= '<td colspan="4" style="text-align:right"><strong>Total </strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($amount,0,',','.').'</strong></td>';
        if($jenis == 'WIP'){
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($qty,0,',','.').'</strong></td>';
        }
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($netto,0,',','.').'</strong></td>';
        $tabel .= '<td style="text-align:right; background-color:green; color:white"><strong>'.number_format($total,0,',','.').'</strong></td>';
        $tabel .= '<td></td>';
        $tabel .= '</tr>';

        header('Content-Type: application/json');
        echo json_encode($tabel); 
    }

    function update_detail_so(){
        $return_data = array();
        $tanggal  = date('Y-m-d h:m:s');
        $user_id  = $this->session->userdata('user_id');
        $jenis = $this->input->post('jenis');
        
        $this->db->trans_start();

        //update so
        if($jenis == 'RONGSOK'){
            $data = array(
                'nama_barang_alias'=>$this->input->post('nama_barang_alias'),
                'amount'=>str_replace(',', '', $this->input->post('amount')),
                'total_amount'=>str_replace(',', '', $this->input->post('total_amount')),
                'qty'=>str_replace(',', '', $this->input->post('netto'))
            );
        }else{
            $data = array(
                'nama_barang_alias'=>$this->input->post('nama_barang_alias'),
                'amount'=>str_replace(',', '', $this->input->post('amount')),
                'total_amount'=>str_replace(',', '', $this->input->post('total_amount')),
                'netto'=>str_replace(',', '', $this->input->post('netto'))
            );
        }
        $this->db->where('id', $this->input->post('detail_id'));
        $this->db->update('t_sales_order_detail', $data);

        // update spb
        if($jenis == 'FG'){
            $this->db->where('id',$this->input->post('spb_detail_id'));
            $dataC = array(
                'netto'=>str_replace(',', '', $this->input->post('netto'))
            );
            $this->db->update('t_spb_fg_detail', $dataC);

        }else if($jenis == 'AMPAS'){
            $this->db->where('id',$this->input->post('spb_detail_id'));
            $dataC = array(
                'netto' =>str_replace(',', '', $this->input->post('netto'))
            );
            $this->db->update('t_spb_ampas_detail', $dataC);

        }else if($jenis == 'WIP'){
            $this->db->where('id',$this->input->post('spb_detail_id'));
            $dataC = array(
                'berat'=>str_replace(',', '', $this->input->post('netto'))
            );
            $this->db->update('t_spb_wip_detail', $dataC);

        }else if($jenis == 'RONGSOK'){
            $this->db->where('id',$this->input->post('spb_detail_id'));
            $dataC = array(
                'qty'=>str_replace(',', '', $this->input->post('netto'))
            );
            $this->db->update('spb_detail', $dataC);
        }

        if($this->db->trans_complete()){
            $return_data['message_type']= "sukses";
        }else{
            $return_data['message_type']= "error";
            $return_data['message']= "Gagal meng-update item finish good! Silahkan coba kembali";
        }
        header('Content-Type: application/json');
        echo json_encode($return_data);     
    }

    function save(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $tgl_so = date('Ym', strtotime($this->input->post('tanggal')));
        $tgl_po = date('Y-m-d', strtotime($this->input->post('tanggal_po')));
        $user_ppn  = $this->session->userdata('user_ppn');
        
        $this->db->trans_start();
        $this->load->model('Model_m_numberings');
        if($user_ppn == 1){
            $code = 'SO-KMP.'.$tgl_so.'.'.$this->input->post('no_so');
        }else{
            $code = $this->Model_m_numberings->getNumbering('SO', $tgl_input); 
        }

        if($code){
            $category = $this->input->post('jenis_barang');
            
            if($category == 'FG'){
                if($user_ppn==1){
                    $num = 'SPB-SO.'.$tgl_so.'.'.$this->input->post('no_so');
                }else{
                    $num = $this->Model_m_numberings->getNumbering('SPB-FG', $tgl_input); 
                }
                $dataC = array(
                    'no_spb'=> $num,
                    'jenis_spb'=> 6,//JENIS SPB SO
                    'tanggal'=> $tgl_input,
                    'keterangan'=> $code.' | '.$this->input->post('keterangan'),
                    'created_at'=> $tanggal,
                    'created_by'=> $user_id
                );
                $this->db->insert('t_spb_fg', $dataC);
                $insert_id = $this->db->insert_id();

            }else if($category == 'WIP'){
                if($user_ppn==1){
                    $num = 'SPB-SO.'.$tgl_so.'.'.$this->input->post('no_so');
                }else{
                    $num = $this->Model_m_numberings->getNumbering('SPB-WIP', $tgl_input); 
                }
                $dataC = array(
                    'no_spb_wip'=> $num,
                    'tanggal'=> $tgl_input,
                    'flag_produksi'=> 6,//JENIS SPB SO
                    'keterangan'=> $code.' | '.$this->input->post('keterangan'),
                    'created'=> $tanggal,
                    'created_by'=> $user_id
                );
                $this->db->insert('t_spb_wip', $dataC);
                $insert_id = $this->db->insert_id();

            }else if($category == 'RONGSOK'){
                if($user_ppn==1){
                    $num = 'SPB-SO.'.$tgl_so.'.'.$this->input->post('no_so');
                }else{
                    $num = $this->Model_m_numberings->getNumbering('SPB-RSK', $tgl_input);
                }
                $dataC = array(
                    'no_spb'=> $num,
                    'jenis_spb'=> 6,//JENIS SPB SO
                    'jenis_barang'=> 1,
                    'tanggal'=> $tgl_input,
                    'remarks'=> $code.' | '.$this->input->post('keterangan'),
                    'created'=> $tanggal,
                    'created_by'=> $user_id
                );
                $this->db->insert('spb', $dataC);
                $insert_id = $this->db->insert_id();
            }else if($category == 'AMPAS'){
                if($user_ppn==1){
                    $num = 'SPB-SO.'.$tgl_so.'.'.$this->input->post('no_so');
                }else{
                    $num = $this->Model_m_numberings->getNumbering('SPB-AMP', $tgl_input);
                }
                $dataC = array(
                    'no_spb_ampas' => $num,
                    'jenis_spb'=> 6,//JENIS SPB SO
                    'tanggal' => $tgl_input,
                    'keterangan'=> $code.' | '.$this->input->post('keterangan'),
                    'created_by' => $user_id,
                    'created_at' => $tanggal
                );
                $this->db->insert('t_spb_ampas', $dataC);
                $insert_id = $this->db->insert_id();
            }else if($category == 'LAIN'){
                $dataC = null;
                $reff_spb = null;
                $insert_id = '0';
                $tgl_po = '0000-00-00';
            }

            $data = array(
                'no_sales_order'=> $code,
                'tanggal'=> $tgl_input,
                'flag_tolling'=> 0,
                'flag_ppn'=>$user_ppn,
                'm_customer_id'=>$this->input->post('m_customer_id'),
                'marketing_id'=>$this->input->post('marketing_id'),
                'keterangan' => $this->input->post('keterangan'),
                'created'=> $tanggal,
                'created_by'=> $user_id
            );

            $this->db->insert('sales_order', $data);
            $so_id = $this->db->insert_id();

            $t_data = array(
                'id'=>$so_id,
                'alias'=>$this->input->post('alias'),
                'so_id'=>$so_id,
                'no_po'=>$this->input->post('no_po'),
                'term_of_payment'=>$this->input->post('term_of_payment'),
                'no_spb'=>$insert_id,
                'tgl_po'=>$tgl_po,
                'jenis_so'=>$this->input->post('jenis_so'),
                'jenis_barang'=>$this->input->post('jenis_barang'),
                'currency'=>$this->input->post('currency'),
                'kurs'=>$this->input->post('kurs')
            );
            $this->db->insert('t_sales_order', $t_data);
            $tso_id = $this->db->insert_id();

            if($user_ppn == 1){
                $this->load->helper('target_url');

                $reff_so = array('reff1' => $so_id);
                $reff_tso = array('reff1' => $tso_id);
                $reff_spb = array('reff1' => $insert_id);
                $data_post['category'] = $category;
                $data_post['so'] = array_merge($data, $reff_so);
                $data_post['tso'] = array_merge($t_data, $reff_tso);
                if($category!='LAIN'){
                    $data_post['spb'] = array_merge($dataC, $reff_spb);
                }

                $post = json_encode($data_post);

                // print_r($post);
                // die();
                $ch = curl_init(target_url().'api/SalesOrderAPI/so');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-KEY: 34a75f5a9c54076036e7ca27807208b8'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $result = json_decode($response, true);
                curl_close($ch);
                // print_r($response);
                // die();

                if($result['status']==true){
                    $this->db->where('id',$so_id);
                    $this->db->update('sales_order', array('api'=>1));
                }
            }

            if($this->db->trans_complete()){
                redirect('index.php/SalesOrder/edit/'.$tso_id);  
            }else{
                $this->session->set_flashdata('flash_msg', 'Sales order gagal disimpan, silahkan dicoba kembali!');
                redirect('index.php/SalesOrder');  
            }            
        }else{
            $this->session->set_flashdata('flash_msg', 'Sales order gagal disimpan, penomoran belum disetup!');
            redirect('index.php/SalesOrder');
        }
    }    

    function delete(){
        $user_id  = $this->session->userdata('user_id');
        $user_ppn = $this->session->userdata('user_ppn');
        $tanggal  = date('Y-m-d h:m:s');
        $id = $this->uri->segment(3);

        $this->db->trans_start();

        $get = $this->db->query("select so_id, no_spb, jenis_barang from t_sales_order
                where id =".$id)->row_array();

        $this->db->where('id', $id);
        $this->db->delete('t_sales_order');

        $this->db->where('id', $get['so_id']);
        $this->db->delete('sales_order');

        if($get['jenis_barang'] == 'FG'){
            $this->db->where('id', $get['no_spb']);
            $this->db->delete('t_spb_fg');
        }else if($get['jenis_barang'] == 'WIP'){
            $this->db->where('id', $get['no_spb']);
            $this->db->delete('t_spb_wip');
        }else if($get['jenis_barang'] == 'RONGSOK'){
            $this->db->where('id', $get['no_spb']);
            $this->db->delete('spb');
        }else if($get['jenis_barang'] == 'AMPAS'){
            $this->db->where('id', $get['no_spb']);
            $this->db->delete('t_spb_ampas');
        }

            if($user_ppn == 1){
                $this->load->helper('target_url');
                $url = target_url().'api/SalesOrderAPI/so_del/id/'.$id;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                // curl_setopt($ch, CURLOPT_POSTFIELDS, "group=3&group_2=1");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-KEY: 34a75f5a9c54076036e7ca27807208b8'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                $result = curl_exec($ch);
                $response = json_decode($result);
                curl_close($ch);
            }

        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Sales Order berhasil di hapus');
            redirect('index.php/SalesOrder');
        }else{
            $this->session->set_flashdata('flash_msg', 'Sales order gagal dihapus');
            redirect('index.php/SalesOrder');
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

            $data['content']= "sales_order/edit";
            $this->load->model('Model_sales_order');
            $data['header'] = $this->Model_sales_order->show_header_so($id)->row_array();  
            $data['customer_list'] = $this->Model_sales_order->customer_list()->result();
            // $data['marketing_list'] = $this->Model_sales_order->marketing_list()->result();
            $jenis = $data['header']['jenis_barang'];
            // echo $jenis;die();
            if($jenis == 'RONGSOK' || $jenis == 'AMPAS'){
            $data['list_barang'] = $this->Model_sales_order->list_barang_so_rongsok()->result();
            }else if($jenis == 'LAIN'){
            $data['list_barang'] =  $this->Model_sales_order->list_barang_sp()->result();
            }else{
            $data['list_barang'] = $this->Model_sales_order->list_barang_so($jenis)->result();
            // print_r($data['list_barang']);die();
            }
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/SalesOrder');
        }
    }

    function save_detail_so(){
        $return_data = array();
        $tanggal  = date('Y-m-d h:m:s');
        $user_id  = $this->session->userdata('user_id');
        $spb = $this->input->post('no_spb');
        $jenis = $this->input->post('jenis');
        // $netto = str_replace('.', '',$this->input->post('netto'));
        $netto = str_replace(',', '',$this->input->post('netto'));

        $this->db->trans_start();
        if($jenis == 'FG'){
            $dataC = array(
                't_spb_fg_id'=>$spb,
                'tanggal'=>$tanggal,
                'jenis_barang_id'=>$this->input->post('barang_id'),
                'uom'=>$this->input->post('uom'),
                'netto'=>$netto,
                'keterangan'=>'SALES ORDER'
            );
            $this->db->insert('t_spb_fg_detail', $dataC);
            $insert_id = $this->db->insert_id();
        }else if($jenis == 'AMPAS'){
            $dataC = array(
                't_spb_ampas_id' => $spb,
                'tanggal' => $tanggal,
                'jenis_barang_id' => $this->input->post('barang_id'),
                'uom' => $this->input->post('uom'),
                'netto' => $this->input->post('netto'),
                'keterangan' => 'SALES ORDER'
            );
            $this->db->insert('t_spb_ampas_detail', $dataC);
            $insert_id = $this->db->insert_id();
        }else if($jenis == 'WIP'){
            $dataC = array(
                't_spb_wip_id'=>$spb,
                'tanggal'=>$tanggal,
                'jenis_barang_id'=>$this->input->post('barang_id'),
                'qty'=> $this->input->post('qty'),
                'uom'=> $this->input->post('uom'),
                'berat'=> $this->input->post('netto'),
                'keterangan'=> 'SALES ORDER'
            );
            $this->db->insert('t_spb_wip_detail', $dataC);
            $insert_id = $this->db->insert_id();
        }else if($jenis == 'RONGSOK'){
            $dataC = array(
                'spb_id'=> $spb,
                'rongsok_id'=> $this->input->post('barang_id'),
                'qty'=> $this->input->post('netto'),
                'line_remarks'=> 'SALES ORDER',
                'created'=> $tanggal,
                'created_by'=> $user_id
            );

            $this->db->insert('spb_detail', $dataC);
            $insert_id = $this->db->insert_id();
        }else if($jenis == 'LAIN'){
            $insert_id = 0;
        }

        if($jenis == 'RONGSOK' || $jenis == 'LAIN'){
            $data_so_detail = array(
                't_so_id'=>$this->input->post('id'),
                'no_spb_detail'=>$insert_id,
                'jenis_barang_id'=>$this->input->post('barang_id'),
                'nama_barang_alias'=>$this->input->post('nama_barang'),
                'amount'=>str_replace(',', '', $this->input->post('harga')),
                'qty'=>$this->input->post('netto'),
                'total_amount'=>str_replace(',', '', $this->input->post('total_harga'))
            );
        }else {
            $data_so_detail = array(
                't_so_id'=>$this->input->post('id'),
                'no_spb_detail'=>$insert_id,
                'jenis_barang_id'=>$this->input->post('barang_id'),
                'nama_barang_alias'=>$this->input->post('nama_barang'),
                'amount'=>str_replace(',', '', $this->input->post('harga')),
                'qty'=>str_replace('.', '', $this->input->post('qty')),
                'total_amount'=>str_replace(',', '', $this->input->post('total_harga')),
                'bruto'=>str_replace('.', '', $this->input->post('bruto')),
                'netto'=>$this->input->post('netto')
            );
        }
        $this->db->insert('t_sales_order_detail',$data_so_detail);
        // print_r($data_so_detail);
        // die();
        if($this->db->trans_complete()){
            $return_data['message_type']= "sukses";
        }else{
            $return_data['message_type']= "error";
            $return_data['message']= "Gagal menambahkan item rongsok! Silahkan coba kembali";
        }
        header('Content-Type: application/json');
        echo json_encode($return_data); 
    }
    
    function delete_detail_so(){
        $id = $this->input->post('id');// t_sales_order_detail id
        $jenis = $this->input->post('jenis');// jenis barang FG/WIP/RONGSOK

        $this->db->trans_start();
        $this->load->model('Model_sales_order');
        $no_spb = $this->Model_sales_order->get_no_spb($id)->row_array();// t_sales_order_detail no_spb

        if($jenis == 'FG'){
            $this->db->where('id',$no_spb['no_spb_detail']);
            $this->db->delete('t_spb_fg_detail');
        }else if($jenis == 'WIP'){
            $this->db->where('id',$no_spb['no_spb_detail']);
            $this->db->delete('t_spb_wip_detail');
        }else if($jenis == 'RONGSOK'){
            $this->db->where('id',$no_spb['no_spb_detail']);
            $this->db->delete('spb_detail');
        }else if($jenis == 'AMPAS'){
            $this->db->where('id',$no_spb['no_spb_detail']);
            $this->db->delete('t_spb_ampas_detail');
        }

        $return_data = array();
        $this->db->where('id', $id);
        $this->db->delete('t_sales_order_detail');
        if($this->db->trans_complete()){
            $return_data['message_type']= "sukses";
        }else{
            $return_data['message_type']= "error";
            $return_data['message']= "Gagal menghapus item rongsok! Silahkan coba kembali";
        }           
        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    function update_so(){
        $user_id  = $this->session->userdata('user_id');
        $user_ppn = $this->session->userdata('user_ppn');
        $tanggal  = date('Y-m-d h:m:s');
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $tanggal_po = date('Y-m-d', strtotime($this->input->post('tanggal_po')));
        
        $this->db->trans_start();
        $data = array(
                'tanggal'=> $tgl_input,
                'm_customer_id'=>$this->input->post('m_customer_id'),
                'marketing_id'=>$this->input->post('marketing_id'),
                'keterangan'=>$this->input->post('keterangan'),
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        $this->db->where('id', $this->input->post('so_id'));
        $this->db->update('sales_order', $data);

        $t_data = array(
                'term_of_payment'=> $this->input->post('term_of_payment'),
                'alias'=> $this->input->post('alias'),
                'no_po'=> $this->input->post('no_po'),
                'tgl_po'=> $tanggal_po,
                'jenis_so'=> $this->input->post('jenis_so'),
                'modified_at'=> $tanggal,
                'modified_by'=> $user_id
            );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('t_sales_order', $t_data);

            if($user_ppn == 1){
                $this->load->helper('target_url');
                $this->load->model('Model_sales_order');
                $jenis = $this->input->post('jenis_barang');
                // if($jenis == 'FG'){
                //     $data_post['detail_spb'] =$this->Model_sales_order->spb_fg_detail_only($this->input->post('no_spb'))->result();
                // }else if($jenis == 'WIP'){
                //     $data_post['detail_spb'] =$this->Model_sales_order->spb_wip_detail_only($this->input->post('no_spb'))->result();
                // }else if($jenis == 'RONGSOK'){
                //     $data_post['detail_spb'] =$this->Model_sales_order->spb_rsk_detail_only($this->input->post('no_spb'))->result();
                // }else if($jenis == 'AMPAS'){
                //     $data_post['detail_spb'] =$this->Model_sales_order->spb_ampas_detail_only($this->input->post('no_spb'))->result();
                // }

                $data_post['category'] = $jenis;
                $data_post['so_id'] = $this->input->post('so_id');
                $data_post['tso_id'] = $this->input->post('id');
                $data_post['so'] = $data;
                $data_post['tso'] = $t_data;
                $data_post['details'] =$this->Model_sales_order->load_detail_only($this->input->post('id'))->result();

                $post = json_encode($data_post);

                // print_r($post);
                // die();

                $ch = curl_init(target_url().'api/SalesOrderAPI/so_detail');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-KEY: 34a75f5a9c54076036e7ca27807208b8'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $result = json_decode($response, true);
                curl_close($ch);
                // print_r($response);die();
            }

        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Data sales order berhasil disimpan');
            redirect('index.php/SalesOrder');
        }else{
            $this->session->set_flashdata('flash_msg', 'Data sales order gagal disimpan');
            redirect('index.php/SalesOrder/edit/'.$this->input->post('id'));
        }
    }

    function close_so(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $jenis    = $this->input->post('jenis_barang');
        
        #Update status t_surat_jalan
        $data = array(
                'flag_invoice'=>1,
                'flag_sj'=>1,
                'modified'=>$tanggal,
                'modified_by'=>$user_id
            );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('sales_order', $data);

        if($jenis=='FG'){
            $this->db->where('id', $this->input->post('id_spb'));
            $this->db->update('t_spb_fg', array(
                'status'=>1,
            ));
        }elseif($jenis=='WIP'){
            $this->db->where('id', $this->input->post('id_spb'));
            $this->db->update('t_spb_wip', array(
                'status'=>1,
            ));
        }elseif($jenis=='RONGSOK'){
            $this->db->where('id', $this->input->post('id_spb'));
            $this->db->update('spb', array(
                'status'=>1,
            ));
        }elseif($jenis=='AMPAS'){
            $this->db->where('id', $this->input->post('id_spb'));
            $this->db->update('t_spb_ampas', array(
                'status'=>1,
            ));
        }
        
        $this->session->set_flashdata('flash_msg', 'Sales Order berhasil di close');
        redirect('index.php/SalesOrder/');
    }

    function open_so(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $jenis    = $this->input->post('jenis_barang');
        
        #Update status t_surat_jalan
        $data = array(
                'flag_invoice'=>0,
                'flag_sj'=>0,
                'modified'=>$tanggal,
                'modified_by'=>$user_id
            );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('sales_order', $data);

        if($jenis=='FG'){
            $this->db->where('id', $this->input->post('id_spb'));
            $this->db->update('t_spb_fg', array(
                'status'=>4,
            ));
        }elseif($jenis=='WIP'){
            $this->db->where('id', $this->input->post('id_spb'));
            $this->db->update('t_spb_wip', array(
                'status'=>4,
            ));
        }elseif($jenis=='RONGSOK'){
            $this->db->where('id', $this->input->post('id_spb'));
            $this->db->update('spb', array(
                'status'=>4,
            ));
        }elseif($jenis=='AMPAS'){
            $this->db->where('id', $this->input->post('id_spb'));
            $this->db->update('t_spb_ampas', array(
                'status'=>4,
            ));
        }
        
        $this->session->set_flashdata('flash_msg', 'Sales Order berhasil di open');
        redirect('index.php/SalesOrder/');
    }

    function open_inv(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $jenis    = $this->input->post('jenis_barang');
        
        #Update status t_surat_jalan
        $data = array(
                'flag_invoice'=>0,
                'modified'=>$tanggal,
                'modified_by'=>$user_id
            );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('sales_order', $data);
        
        $this->session->set_flashdata('flash_msg', 'Invoice berhasil di open');
        redirect('index.php/Finance/add_invoice');
    }

    function open_sj(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $jenis    = $this->input->post('jenis_barang');
        
        #Update status t_surat_jalan
        $data = array(
                'flag_sj'=>0,
                'flag_invoice'=>0,
                'modified'=>$tanggal,
                'modified_by'=>$user_id
            );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('sales_order', $data);
        
        $this->session->set_flashdata('flash_msg', 'Surat Jalan berhasil di open');
        redirect('index.php/SalesOrder/add_surat_jalan');
    }

    function spb_list(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');       
        $user_ppn = $this->session->userdata('user_ppn');      
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "sales_order/spb_list";
        $this->load->model('Model_sales_order');
        $data['list_data'] = $this->Model_sales_order->spb_list($user_ppn)->result();

        $this->load->view('layout', $data);
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

            $data['content']= "sales_order/view_spb";

            $this->load->model('Model_sales_order');
            $data['myData'] = $this->Model_sales_order->show_view_header_so($id)->row_array();
            if($data['myData']['jenis_barang'] == 'RONGSOK'){
            $data['myDetail'] = $this->Model_sales_order->show_view_detail_so_rsk($id)->result(); 
            $data['detailSPB'] = $this->Model_sales_order->show_detail_spb_fulfilment_rsk($id)->result();
            }else{
            $data['myDetail'] = $this->Model_sales_order->show_view_detail_so($id)->result(); 
            $data['detailSPB'] = $this->Model_sales_order->show_detail_spb_fulfilment($id)->result();
            }
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/GudangFG/spb_list');
        }
    }

    function print_spb(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_sales_order');
            $data['header']  = $this->Model_sales_order->show_view_header_so($id)->row_array();
            $data['details'] = $this->Model_sales_order->show_view_detail_so($id)->result();

            $this->load->view('sales_order/print_spb', $data);
        }else{
            redirect('index.php'); 
        }
    }

/** SURAT JALAN  */
    function surat_jalan(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');        
        $user_ppn = $this->session->userdata('user_ppn');
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;

        $data['content']= "sales_order/surat_jalan";
        $this->load->model('Model_sales_order');
        $data['list_data'] = $this->Model_sales_order->surat_jalan($user_ppn)->result();

        $this->load->view('layout', $data);
    }
    
    function add_surat_jalan(){
        $module_name = $this->uri->segment(1);
        $group_id    = $this->session->userdata('group_id');    
        $user_ppn    = $this->session->userdata('user_ppn');    
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        $data['content']= "sales_order/add_surat_jalan";
        
        $this->load->model('Model_sales_order');
        $data['sj'] = $this->Model_sales_order->get_last_sj($user_ppn)->row_array();
        $data['sjr'] = $this->Model_sales_order->get_last_sj_cv()->row_array();
        $data['customer_list'] = $this->Model_sales_order->customer_list()->result();
        //$data['jenis_barang_list'] = $this->Model_sales_order->jenis_barang_list()->result();
        $data['type_kendaraan_list'] = $this->Model_sales_order->type_kendaraan_list()->result();
        $this->load->view('layout', $data);
    }

    function get_alamat(){
        $id = $this->input->post('id');
        $this->load->model('Model_sales_order');
        $customer = $this->Model_sales_order->get_alamat($id)->row_array();

        header('Content-Type: application/json');
        echo json_encode($customer); 
    }

    function get_so_list(){ 
        $user_ppn = $this->session->userdata('user_ppn');
        $id = $this->input->post('id');
        $this->load->model('Model_sales_order');
        $data = $this->Model_sales_order->get_so_list($id, $user_ppn)->result();
        $arr_so[] = "Silahkan pilih....";
        foreach ($data as $row) {
            $arr_so[$row->id] = $row->no_sales_order;
        } 
        print form_dropdown('sales_order_id', $arr_so);
    }

    function get_type_kendaraan(){
        $id = $this->input->post('id');
        $this->load->model('Model_sales_order');
        $type_kendaraan = $this->Model_sales_order->get_type_kendaraan($id)->row_array();
        
        header('Content-Type: application/json');
        echo json_encode($type_kendaraan); 
    }

    function get_jenis_barang(){
        $id = $this->input->post('id');
        $this->load->model('Model_sales_order');
        $jenis_barang = $this->Model_sales_order->get_jenis_barang($id)->row_array();
        
        header('Content-Type: application/json');
        echo json_encode($jenis_barang); 
    }

    function get_penomoran_sj(){
        $tgl_sj = date('Ym', strtotime($this->input->post('tanggal')));
        $tahun_sj = date('Y', strtotime($this->input->post('tanggal')));
        $no_sj = $this->input->post('no_sj');
        $user_ppn = $this->session->userdata('user_ppn');
        if ($user_ppn == 0) {
            // $code = 'SJ.'.$tgl_sj.'.'.$this->input->post('no_sj');
            #cek tahun dan 4 digit terakhir
            $prefix = 'SJ.'.$tahun_sj;
            #end
        } else {
            // $code = 'SJ-KMP.'.$tgl_sj.'.'.$this->input->post('no_sj');
            $prefix = 'SJ-KMP.'.$tahun_sj;
        }

        $count = $this->db->query("Select count(id) as count from t_surat_jalan where no_surat_jalan LIKE '".$prefix."%' AND no_surat_jalan LIKE '%.".$no_sj."'")->row_array();
        if($count['count']>0){
            $data['type'] = 'duplicate';
        }else{
            $data['type'] = 'sukses';
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function save_surat_jalan(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $tgl_sj = date('Ym', strtotime($this->input->post('tanggal')));
        $user_ppn = $this->session->userdata('user_ppn');
        
        if($user_ppn == 1){
            $code = 'SJ-KMP.'.$tgl_sj.'.'.$this->input->post('no_surat_jalan');
        }else{
            $this->load->model('Model_m_numberings');
            // $code = $this->Model_m_numberings->getNumbering('SJ', $tgl_input); 
            $code = 'SJ.'.$tgl_sj.'.'.$this->input->post('no_surat_jalan');
        }
        
        if($code){        
            $data = array(
                'no_surat_jalan'=> $code,
                'sales_order_id'=>$this->input->post('sales_order_id'),
                'tanggal'=> $tgl_input,
                'jenis_barang'=>$this->input->post('jenis_barang'),
                'm_customer_id'=>$this->input->post('m_customer_id'),
                'm_type_kendaraan_id'=>$this->input->post('m_type_kendaraan_id'),
                'no_kendaraan'=>$this->input->post('no_kendaraan'),
                'supir'=>$this->input->post('supir'),
                'remarks'=>$this->input->post('remarks'),
                'status'=>0,
                'created_at'=> $tanggal,
                'created_by'=> $user_id,
                'modified_at'=> $tanggal,
                'modified_by'=> $user_id
            );

            if($this->db->insert('t_surat_jalan', $data)){
                redirect('index.php/SalesOrder/edit_surat_jalan/'.$this->db->insert_id());  
            }else{
                $this->session->set_flashdata('flash_msg', 'Data surat jalan gagal disimpan, silahkan dicoba kembali!');
                redirect('index.php/SalesOrder/surat_jalan');  
            }            
        }else{
            $this->session->set_flashdata('flash_msg', 'Data surat jalan gagal disimpan, penomoran belum disetup!');
            redirect('index.php/SalesOrder/surat_jalan');
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

            $this->load->model('Model_sales_order');
            $data['header'] = $this->Model_sales_order->show_header_sj($id)->row_array();  
            $data['customer_list'] = $this->Model_sales_order->customer_list()->result();
            $data['type_kendaraan_list'] = $this->Model_sales_order->type_kendaraan_list()->result();

            $jenis = $data['header']['jenis_barang'];
            $soid = $data['header']['sales_order_id'];
            if($jenis == 'FG'){
                $data['list_produksi'] = $this->Model_sales_order->list_item_sj_fg($soid)->result();
                $data['jenis_barang'] = $this->Model_sales_order->jenis_barang_in_so($soid)->result();
                $data['content']= "sales_order/edit_surat_jalan_test";
            }else if($jenis == 'WIP'){
                $data['list_produksi'] = $this->Model_sales_order->list_item_sj_wip($soid)->result();
                $data['jenis_barang'] = $this->Model_sales_order->jenis_barang_in_so($soid)->result();
                $data['content']= "sales_order/edit_surat_jalan_test";
            }else if($jenis == 'LAIN'){
                $data['list_produksi'] = $this->Model_sales_order->list_item_sj_lain($soid)->result();
                $data['jenis_barang'] = $this->Model_sales_order->list_barang_sp()->result();
                $data['content']= "sales_order/edit_surat_jalan_lain";
            }else if($jenis == 'AMPAS'){
                $data['list_produksi'] = $this->Model_sales_order->list_item_sj_ampas($soid)->result();
                $data['jenis_barang'] = $this->Model_sales_order->rongsok_in_so($soid)->result();
                $data['content'] = "sales_order/edit_surat_jalan_ampas";
            }else{
                $data['list_produksi'] = $this->Model_sales_order->list_item_sj_rsk($soid)->result();
                $data['jenis_barang'] = $this->Model_sales_order->rongsok_in_so($soid)->result();
                $data['content']= "sales_order/edit_surat_jalan_test";
            }
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/SalesOrder/surat_jalan');
        }
    }

    function delete_surat_jalan(){
        $id = $this->uri->segment(3);
        $this->db->trans_start();

        $this->db->where('id', $id);
        $this->db->delete('t_surat_jalan');

        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Surat Jalan berhasil di hapus');
            redirect('index.php/SalesOrder/surat_jalan');
        }else{
            $this->session->set_flashdata('flash_msg', 'Surat Jalan gagal dihapus');
            redirect('index.php/SalesOrder/surat_jalan');
        }
    }

    function get_data_sj(){
        $id = $this->input->post('id');
        $jb = $this->input->post('jenis_barang');
        $this->load->model('Model_sales_order');
        if($jb=='FG'){
        $sj_detail= $this->Model_sales_order->list_item_sj_fg_detail($id)->row_array();
        }else if($jb=='WIP'){
        $sj_detail= $this->Model_sales_order->list_item_sj_wip_detail($id)->row_array();
        }else{
        $sj_detail= $this->Model_sales_order->list_item_sj_rsk_detail($id)->row_array();
        }
        
        header('Content-Type: application/json');
        echo json_encode($sj_detail); 
    }
    
    function update_surat_jalan(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');        
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $jenis = $this->input->post('jenis_barang');
        $soid = $this->input->post('so_id');

        #Insert Surat Jalan
        $details = $this->input->post('details');

        foreach ($details as $v) {
            if($v['id_barang']!=''){
                if($jenis=='FG'){// BARANG FINISH GOOD
                    $this->db->insert('t_surat_jalan_detail', array(
                        't_sj_id'=>$this->input->post('id'),
                        'gudang_id'=>$v['id_barang'],
                        'jenis_barang_id'=>$v['jenis_barang_id'],
                        'jenis_barang_alias'=>$v['barang_alias_id'],
                        'no_packing'=>$v['no_packing'],
                        'qty'=>'1',
                        'bruto'=>$v['bruto'],
                        'berat'=>$v['berat'],
                        'netto'=>$v['netto'],
                        'nomor_bobbin'=>$v['bobbin'],
                        'created_by'=>$user_id,
                        'created_at'=>$tanggal
                    ));
                }else if($jenis=='WIP'){//BARANG WIP
                    $this->db->insert('t_surat_jalan_detail', array(
                        't_sj_id'=>$this->input->post('id'),
                        'gudang_id'=>$v['id_barang'],
                        'jenis_barang_id'=>$v['jenis_barang_id'],
                        'no_packing'=>0,
                        'qty'=>$v['qty'],
                        'bruto'=>0,
                        'berat'=>0,
                        'netto'=>$v['netto'],
                        'nomor_bobbin'=>0,
                        'created_by'=>$user_id,
                        'created_at'=>$tanggal
                    ));
                }else if($jenis=='RONGSOK'){
                    $this->db->insert('t_surat_jalan_detail', array(
                        't_sj_id'=>$this->input->post('id'),
                        'gudang_id'=>$v['id_barang'],
                        'jenis_barang_id'=>$v['jenis_barang_id'],
                        'jenis_barang_alias'=>$v['barang_alias_id'],
                        'no_packing'=>$v['no_palette'],
                        'qty'=>'1',
                        'bruto'=>$v['bruto'],
                        'berat'=>$v['berat_palette'],
                        'netto'=>$v['netto'],
                        'nomor_bobbin'=>0,
                        'created_by'=>$user_id,
                        'created_at'=>$tanggal
                    ));
                }else if($jenis=='AMPAS'){
                    $this->db->insert('t_surat_jalan_detail', array(
                        't_sj_id'=>$this->input->post('id'),
                        'gudang_id'=>$v['id_barang'],
                        'jenis_barang_id'=>$v['jenis_barang_id'],
                        'jenis_barang_alias'=>$v['barang_alias_id'],
                        'no_packing'=>'',
                        'qty'=>'1',
                        'bruto'=>str_replace('.', '', $v['bruto']),
                        'berat'=>0,
                        'netto'=>str_replace('.', '', $v['netto']),
                        'nomor_bobbin'=>0,
                        'created_by'=>$user_id,
                        'created_at'=>$tanggal
                    ));
                }else if($jenis=='LAIN'){
                    $this->db->insert('t_surat_jalan_detail', array(
                        't_sj_id'=>$this->input->post('id'),
                        'gudang_id'=>0,
                        'jenis_barang_id'=>$v['jenis_barang_id'],
                        'jenis_barang_alias'=>0,
                        'no_packing'=>'',
                        'qty'=>1,
                        'bruto'=>str_replace('.', '', $v['bruto']),
                        'berat'=>0,
                        'netto'=>str_replace('.', '', $v['netto']),
                        'nomor_bobbin'=>0,
                        'created_by'=>$user_id,
                        'created_at'=>$tanggal
                    ));
                }
            }
        }

        $data = array(
                'tanggal'=> $tgl_input,
                'status'=> 0,
                'm_type_kendaraan_id'=>$this->input->post('m_type_kendaraan_id'),
                'no_kendaraan'=>$this->input->post('no_kendaraan'),
                'supir'=>$this->input->post('supir'),
                'remarks'=>$this->input->post('remarks'),
                'modified_at'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('t_surat_jalan', $data);

        
        $this->session->set_flashdata('flash_msg', 'Data surat jalan berhasil disimpan');
        redirect('index.php/SalesOrder/surat_jalan');
    }
    
    function view_surat_jalan(){
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

            $data['content']= "sales_order/view_sj";
            $this->load->model('Model_sales_order');
            $data['header'] = $this->Model_sales_order->show_header_sj($id)->row_array();  
            $data['customer_list'] = $this->Model_sales_order->customer_list()->result();
            $data['type_kendaraan_list'] = $this->Model_sales_order->type_kendaraan_list()->result();

            $jenis = $data['header']['jenis_barang'];
            $soid = $data['header']['sales_order_id'];
            if($jenis == 'FG'){
                $data['list_sj'] = $this->Model_sales_order->load_view_sjd($id)->result();
                $data['jenis_barang'] = $this->Model_sales_order->jenis_barang_in_so($soid)->result();
            }else if($jenis == 'WIP'){
                $data['list_sj'] = $this->Model_sales_order->load_detail_surat_jalan_wip($id)->result();
                $data['jenis_barang'] = $this->Model_sales_order->jenis_barang_in_so($soid)->result();
            }else if($jenis == 'LAIN'){
                $data['list_sj'] = $this->Model_sales_order->load_detail_surat_jalan_lain($id)->result();
                $data['jenis_barang'] = $this->Model_sales_order->rongsok_in_so($soid)->result();
            }else{
                $data['list_sj'] = $this->Model_sales_order->load_detail_surat_jalan_rsk($id,$soid)->result();
                $data['jenis_barang'] = $this->Model_sales_order->rongsok_in_so($soid)->result();
            }
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/SalesOrder/surat_jalan');
        }
    }

    function update_surat_jalan_existing(){
        $user_id  = $this->session->userdata('user_id');
        $user_ppn  = $this->session->userdata('user_ppn');
        $tanggal  = date('Y-m-d h:m:s');        
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $jenis = $this->input->post('jenis_barang');
        $soid = $this->input->post('so_id');

        #Insert Surat Jalan
        $details = $this->input->post('details');

        // print_r($details);
        // die();
        foreach ($details as $v) {
            if($v['id_tsj_detail']!=''){
                $this->db->where('id',$v['id_tsj_detail']);
                $this->db->update('t_surat_jalan_detail', array(
                    'jenis_barang_alias'=>$v['barang_alias_id'],
                    'modified_by'=>$user_id,
                    'modified_at'=>$tanggal
                ));
            }
        }

        $data = array(
                'no_surat_jalan'=> $this->input->post('no_surat_jalan'),
                'tanggal'=> $tgl_input,
                'no_kendaraan'=>$this->input->post('no_kendaraan'),
                'supir'=>$this->input->post('supir'),
                'remarks'=>$this->input->post('remarks'),
                'modified_at'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('t_surat_jalan', $data);

            if($user_ppn == 1 && $this->input->post('status_sj') == 1){
                $this->load->helper('target_url');

                    $data_post['id_sj'] = $this->input->post('id');
                    $data_post['header'] = $data;
                    $data_post['details'] = $details;
                    $post = json_encode($data_post);
                // print_r($post);
                // die();
                $ch = curl_init(target_url().'api/SalesOrderAPI/sj_update');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-KEY: 34a75f5a9c54076036e7ca27807208b8'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $result = json_decode($response, true);
                curl_close($ch);
                // print_r($response);
                // die();
            }
        
        $this->session->set_flashdata('flash_msg', 'Data surat jalan berhasil disimpan');
        redirect('index.php/SalesOrder/view_surat_jalan/'.$this->input->post('id'));
    }

    function approve_surat_jalan(){
        $sjid = $this->input->post('id');
        $user_id  = $this->session->userdata('user_id');
        $user_ppn = $this->session->userdata('user_ppn');
        $flag_sj = 0;
        $tanggal  = date('Y-m-d h:m:s');
        $tgl_input = date('Y-m-d');
        $so_id = $this->input->post('so_id');
        $custid = $this->input->post('id_customer');
        $jenis = $this->input->post('jenis_barang');

        $this->db->trans_start();
        
        $this->load->model('Model_sales_order');
        #set flag taken
        $loop = $this->Model_sales_order->tsj_detail_only($sjid)->result();
        if ($jenis == 'FG') {
            foreach ($loop as $row) {
                $this->db->where('id', $row->gudang_id);
                $this->db->update('t_gudang_fg', array('flag_taken' => 1, 't_sj_id'=> $sjid));
            }
        } else if ($jenis == 'WIP') {
            foreach ($loop as $row) {
                $this->db->where('id', $row->gudang_id);
                $this->db->update('t_gudang_wip', array('flag_taken' => 1));
            }
        } else if ($jenis == 'RONGSOK'){
            foreach ($loop as $row) {
                $this->db->where('id', $row->gudang_id);
                $this->db->update('dtr_detail', array('so_id' => $so_id, 'flag_sj' => $sjid));
            }
        } else if ($jenis == 'AMPAS'){
            foreach ($loop as $row) {
                $this->db->where('id', $row->gudang_id);
                $this->db->update('t_spb_ampas_fulfilment', array('flag_taken' => 1));
            }
        }

        #cek jika surat jalan sudah di kirim semua atau belum
        if($jenis == 'FG'){
            $list_produksi = $this->Model_sales_order->list_item_sj_fg($so_id)->result();
        }else if($jenis == 'WIP'){
            $list_produksi = $this->Model_sales_order->list_item_sj_wip($so_id)->result();
        }else{
            $list_produksi = $this->Model_sales_order->list_item_sj_rsk($so_id)->result();
        }

        $this->db->where('id',$so_id);
        $this->db->update('sales_order', array(
            'flag_invoice'=>0
        ));

        if($jenis == 'LAIN'){
            $flag_sj = 1;
        }else{
            if(empty($list_produksi) && $this->input->post('status_spb') == 1){
                $flag_sj = 1;
            }
        }
            $this->db->where('id',$so_id);
            $this->db->update('sales_order', array(
                'flag_sj'=>$flag_sj
            ));

        if($jenis=='FG'){
            #insert bobbin_peminjaman
            $this->load->model('Model_m_numberings');
            $code = $this->Model_m_numberings->getNumbering('BB-BR', $tgl_input);

            $this->db->insert('m_bobbin_peminjaman', array(
                'no_surat_peminjaman' => $code,
                'id_surat_jalan' => $sjid,
                'id_customer' => $custid,
                'status' => 0,
                'created_by' => $user_id,
                'created_at' => $tanggal
            ));
            $insert_id = $this->db->insert_id();

            $query = $this->db->query('select * from t_surat_jalan_detail where t_sj_id = '.$sjid)->result();
            foreach ($query as $row) {
                if($row->nomor_bobbin!=''){
                    $this->db->where('nomor_bobbin', $row->nomor_bobbin);
                    $this->db->update('m_bobbin', array(
                        'borrowed_by' => $custid,
                        'status' => 2
                    ));

                    $this->db->insert('m_bobbin_peminjaman_detail', array(
                        'id_peminjaman' => $insert_id,
                        'nomor_bobbin' => $row->nomor_bobbin
                    ));
                }
            }
        }
        
        $data = array(
                'status' => 1,
                'approved_at'=> $tanggal,
                'approved_by'=> $user_id
            );
        
        $this->db->where('id', $sjid);
        $this->db->update('t_surat_jalan', $data);

            if($user_ppn == 1){
                $this->load->helper('target_url');
                    $data_post['flag_sj'] = $flag_sj;
                    $data_post['tsj'] = $this->Model_sales_order->tsj_header_only($sjid)->row_array();

                if($jenis == 'FG'){
                    $data_post['gudang'] = $this->Model_sales_order->tsjd_get_gudang($sjid)->result();
                }elseif($jenis == 'WIP'){
                    $data_post['gudang'] = $this->Model_sales_order->tsjd_get_gudang_wip($sjid)->result();
                }elseif($jenis == 'RONGSOK'){
                    $data_post['gudang'] = $this->Model_sales_order->tsjd_get_gudang_rsk($sjid)->result();
                }elseif ($jenis == 'LAIN'){
                    $data_post['gudang'] = $this->Model_sales_order->tsjd_get_gudang_lain($sjid)->result();
                }
                    $post = json_encode($data_post);
                // print_r($post);
                // die();
                $ch = curl_init(target_url().'api/SalesOrderAPI/sj');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-KEY: 34a75f5a9c54076036e7ca27807208b8'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $result = json_decode($response, true);
                curl_close($ch);
                // print_r($response);
                // die();
                if($result['status']==true){
                    $this->db->where('id',$this->input->post('id'));
                    $this->db->update('t_surat_jalan', array('api'=>1));
                }
            }

        if($this->db->trans_complete()){    
            $this->session->set_flashdata('flash_msg', 'Surat jalan sudah di-approve. Detail Surat jalan sudah disimpan');            
        }else{
            $this->session->set_flashdata('flash_msg', 'Terjadi kesalahan saat pembuatan Surat Jalan, silahkan coba kembali!');
        }             
        
       redirect('index.php/SalesOrder/surat_jalan');
    }

    function delete_approved_surat_jalan(){
        $id = $this->uri->segment(3);
        $this->db->trans_start();

        $this->load->model('Model_sales_order');

        $header = $this->Model_sales_order->t_sj_only($id)->row_array();
        $data = $this->Model_sales_order->t_sj_detail_only($id)->result();
        foreach ($data as $v) {
            if ($header['jenis_barang'] == 'FG') {
                $this->db->where('id', $v->gudang_id);
                $this->db->update('t_gudang_fg', array(
                    't_spb_fg_id'=>NULL,
                    'nomor_SPB'=>NULL,
                    'jenis_trx'=>0,
                    'flag_taken'=>0,
                    'tanggal_keluar'=>'0000-00-00'
                ));

                $this->db->where('nomor_bobbin', $v->nomor_bobbin);
                $this->db->update('m_bobbin', array(
                    'borrowed_by' => 0,
                    'status' => 1
                ));
            } else if ($header['jenis_barang'] == 'RONGSOK'){
                $this->db->where('id', $v->gudang_id);
                $this->db->update('dtr_detail', array(
                    'so_id' => 0,
                    'flag_taken' => 0,
                    'flag_sj' => 0,
                    'tanggal_keluar' => NULL
                ));

                $this->db->where('dtr_detail_id', $v->gudang_id);
                $this->db->delete('spb_detail_fulfilment');
            }
        }

        if($header['jenis_barang']=='FG'){
            #delete bobbin_peminjaman

            $this->db->where('id_surat_jalan', $id);
            $this->db->delete('m_bobbin_peminjaman');

            $this->db->where('id_peminjaman',  $header['id_bobbin_peminjaman']);
            $this->db->delete('m_bobbin_peminjaman_detail');
        }

        $this->db->where('id',$header['sales_order_id']);
        $this->db->update('sales_order', array(
            'flag_sj'=>0,
            'flag_invoice'=>0
        ));

        $this->db->where('id',$header['no_spb']);
        if($header['jenis_barang']=='FG'){
            $this->db->update('t_spb_fg', array(
                'status'=>4
            ));
        }elseif($header['jenis_barang']=='RONGSOK'){
            $this->db->update('spb', array(
                'status'=>4
            ));
        }

        $this->db->where('t_sj_id', $id);
        $this->db->delete('t_surat_jalan_detail');

        $this->db->where('id', $id);
        $this->db->delete('t_surat_jalan');

        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Surat Jalan berhasil di hapus');
            redirect('index.php/SalesOrder/surat_jalan');
        }else{
            $this->session->set_flashdata('flash_msg', 'Surat Jalan gagal dihapus');
            redirect('index.php/SalesOrder/surat_jalan');
        }
    }

    function reject_surat_jalan(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        $sjid = $this->input->post('sj_id');
        
        #Update status t_surat_jalan
        $data = array(
                'status'=> 9,
                'rejected_at'=> $tanggal,
                'rejected_by'=>$user_id,
                'reject_remarks'=>$this->input->post('reject_remarks')
            );
        
        $this->db->where('id', $sjid);
        $this->db->update('t_surat_jalan', $data);
        
        $this->db->where('t_sj_id', $sjid);
        $this->db->delete('t_surat_jalan_detail');
        
        $this->session->set_flashdata('flash_msg', 'Surat jalan berhasil direject');
        redirect('index.php/SalesOrder/surat_jalan');
    }

    function print_surat_jalan(){
        $id = $this->uri->segment(3);
        if($id){        
            $this->load->model('Model_sales_order');
            $this->load->helper('tanggal_indo');
            $data['header']  = $this->Model_sales_order->show_header_sj($id)->row_array();
            $soid = $data['header']['sales_order_id'];
            $jenis = $data['header']['jenis_barang'];
            if($jenis=='FG'){
                $data['details'] = $this->Model_sales_order->load_detail_surat_jalan_fg($id)->result();
                if($data['header']['status'] == 1){
                    $this->load->view('sales_order/print_sj_approve', $data);
                }else{
                    $this->load->view('sales_order/print_sj', $data);
                }
                    // $header = $this->load->view("sales_order/print_sj/headerpdf", $data, true);
                    // $body = $this->load->view("sales_order/print_sj/bodypdf", $data, true);
                    // $footer = $this->load->view("sales_order/print_sj/footerpdf", $data, true);

                    // $this->load->library('vendor/autoload');
                    // $pdf = new \Mpdf\Mpdf(['utf-8','A4']); 

                    // $pdf->SetHTMLHeader($header);
                    // $pdf->SetHTMLFooter($footer);
                    // $pdf->AddPage('P', // L - landscape, P - portrait 
                    //     '', '', '', '',
                    //     10, // margin_left
                    //     10, // margin right
                    //    55, // margin top
                    //    40, // margin bottom
                    //     5, // margin header
                    //     5); // margin footer
                    // // $pdf->AddPage('P');
                    // $pdf->writeHTML($body);
                    // $pdf->Output('sj.pdf', 'I');  
            }else if($jenis=='WIP'){
                $data['details'] = $this->Model_sales_order->load_detail_surat_jalan_wip($id)->result();
                $this->load->view('sales_order/print_sj_wip', $data);
            }else if($jenis=='LAIN'){
                $data['details'] = $this->Model_sales_order->load_detail_surat_jalan_lain($id)->result();
                $this->load->view('sales_order/print_sj_lain', $data);
            }else if($jenis=='AMPAS'){
                $data['details'] = $this->Model_sales_order->load_detail_surat_jalan_rsk($id,$soid)->result();
                $this->load->view('sales_order/print_sj_ampas', $data);
            }else{
                $data['details'] = $this->Model_sales_order->load_detail_surat_jalan_rsk($id,$soid)->result();
                $this->load->view('sales_order/print_sj_rsk', $data);
            }
        }else{
            redirect('index.php'); 
        }
    }

    function revisi_surat_jalan(){
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

            $data['content']= "sales_order/revisi_surat_jalan";
            $this->load->model('Model_sales_order');
            $data['header'] = $this->Model_sales_order->show_header_sj($id)->row_array();
            $soid = $data['header']['sales_order_id'];

            $jenis = $data['header']['jenis_barang'];
            if($jenis == 'FG'){
                $data['details'] = $this->Model_sales_order->load_detail_surat_jalan_fg($id)->result();
            }else if($jenis == 'WIP'){
                $data['details'] = $this->Model_sales_order->load_detail_surat_jalan_wip($id)->result();
            }else{
                $data['details'] = $this->Model_sales_order->load_detail_surat_jalan_rsk($id,$soid)->result();
            }
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/SalesOrder/surat_jalan');
        }
    }

    function save_revisi_sj(){
        $user_id  = $this->session->userdata('user_id');
        $user_ppn = $this->session->userdata('user_ppn');
        $tanggal  = date('Y-m-d h:m:s');        
        $tgl_input = date('Y-m-d', strtotime($this->input->post('tanggal')));

        $this->db->trans_start();
        
        $data_post = [];
        $details = $this->input->post('details');
        foreach ($details as $key => $v) {
            if($v['netto_r']>0){
                $bruto = $v['netto_r'] + $v['berat'];
                $data = array(
                        'bruto'=> $bruto,
                        'netto_r'=> $v['netto_r'],
                        'modified_at'=> $tanggal,
                        'modified_by'=> $user_id
                    );
                $this->db->where('id', $v['id']);
                $this->db->update('t_surat_jalan_detail', $data);
                $data_post[$key] = array_merge($v, array('bruto' => $bruto));
            }
        }

        if($user_ppn == 1){
            $this->load->helper('target_url');

            $post = json_encode($data_post);
            // print_r($post);
            // die();
            $ch = curl_init(target_url().'api/SalesOrderAPI/sj_revisi');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-KEY: 34a75f5a9c54076036e7ca27807208b8'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $result = json_decode($response, true);
            curl_close($ch);
            // print_r($response);
            // die();
        }

        if($this->db->trans_complete()){
            $this->session->set_flashdata('flash_msg', 'Data surat jalan berhasil disimpan');
            redirect('index.php/SalesOrder/surat_jalan');
        }else{
            $this->session->set_flashdata('flash_msg', 'Data surat jalan gagal disimpan');
            redirect('index.php/SalesOrder/surat_jalan');
        }
    }

    function print_barcode_fg(){
        $fg_id = $_GET['fg'];
        $bruto = $_GET['b'];
        $berat_bobbin = $_GET['bb'];
        $netto = $_GET['n'];
        $no_packing = $_GET['np'];
        if($netto){

        $this->load->model('Model_sales_order');
        $data = $this->Model_sales_order->get_jb($fg_id)->row_array();

        $current = '';
        $data_printer = $this->db->query("select * from m_print_barcode_line where m_print_barcode_id = 1")->result_array();
        $data_printer[17]['string1'] = 'BARCODE 488,335,"39",41,0,180,2,6,"'.$data['kode'].'"';
        $data_printer[18]['string1'] = 'TEXT 386,289,"ROMAN.TTF",180,1,8,"'.$data['kode'].'"';
        $data_printer[22]['string1'] = 'BARCODE 612,101,"39",41,0,180,2,6,"'.$no_packing.'"';
        $data_printer[23]['string1'] = 'TEXT 426,55,"ROMAN.TTF",180,1,8,"'.$no_packing.'"';
        $data_printer[24]['string1'] = 'TEXT 499,260,"4",180,1,1,"'.$no_packing.'"';
        $data_printer[25]['string1'] = 'TEXT 495,226,"ROMAN.TTF",180,1,14,"'.$bruto.'"';
        $data_printer[26]['string1'] = 'TEXT 495,188,"ROMAN.TTF",180,1,14,"'.$berat_bobbin.'"';
        $data_printer[27]['string1'] = 'TEXT 495,147,"0",180,14,14,"'.$netto.'"';
        $data_printer[31]['string1'] = 'TEXT 496,373,"2",180,1,1,"'.$data['jenis_barang'].'"';
        $data_printer[32]['string1'] = 'TEXT 497,407,"4",180,1,1,"'.$data['kode'].'"';
        $jumlah = count($data_printer);
        for($i=0;$i<$jumlah;$i++){
        $current .= $data_printer[$i]['string1']."\n";
        }
        echo "<form method='post' id=\"coba\" action=\"http://localhost/print/print.php\">";
        echo "<input type='hidden' id='nospb' name='nospb' value='".$current."'>";
        echo "</form>";
        echo '<script type="text/javascript">document.getElementById(\'coba\').submit();</script>';
        }else{
            'GAGAL';
        }
    }

    function print_barcode_rsk(){
        $rsk_id = $_GET['rsk'];
        $bruto = $_GET['b'];
        $berat_bobbin = $_GET['bb'];
        $netto = $_GET['n'];
        $no_packing = $_GET['np'];
        if($netto){

        $this->load->model('Model_sales_order');
        $data = $this->Model_sales_order->get_rsk($rsk_id)->row_array();

        $current = '';
        $data_printer = $this->db->query("select * from m_print_barcode_line where m_print_barcode_id = 1")->result_array();
        $data_printer[17]['string1'] = 'BARCODE 488,335,"39",41,0,180,2,6,"'.$data['kode_rongsok'].'"';
        $data_printer[18]['string1'] = 'TEXT 386,289,"ROMAN.TTF",180,1,8,"'.$data['kode_rongsok'].'"';
        $data_printer[22]['string1'] = 'BARCODE 612,101,"39",41,0,180,2,6,"'.$no_packing.'"';
        $data_printer[23]['string1'] = 'TEXT 426,55,"ROMAN.TTF",180,1,8,"'.$no_packing.'"';
        $data_printer[24]['string1'] = 'TEXT 499,260,"4",180,1,1,"'.$no_packing.'"';
        $data_printer[25]['string1'] = 'TEXT 495,226,"ROMAN.TTF",180,1,14,"'.$bruto.'"';
        $data_printer[26]['string1'] = 'TEXT 495,188,"ROMAN.TTF",180,1,14,"'.$berat_bobbin.'"';
        $data_printer[27]['string1'] = 'TEXT 495,147,"0",180,14,14,"'.$netto.'"';
        $data_printer[31]['string1'] = 'TEXT 496,373,"2",180,1,1,"'.$data['nama_item'].'"';
        $data_printer[32]['string1'] = 'TEXT 497,407,"4",180,1,1,"'.$data['kode_rongsok'].'"';
        $jumlah = count($data_printer);
        for($i=0;$i<$jumlah;$i++){
        $current .= $data_printer[$i]['string1']."\n";
        }
        echo "<form method='post' id=\"coba\" action=\"http://localhost/print/print.php\">";
        echo "<input type='hidden' id='nospb' name='nospb' value='".$current."'>";
        echo "</form>";
        echo '<script type="text/javascript">document.getElementById(\'coba\').submit();</script>';
        }else{
            'GAGAL';
        }
    }

    function print_barcode_sj(){
        $id = $_GET['id'];
        $jb = $_GET['jb'];
        if($id){

        $this->load->model('Model_sales_order');
        $data = $this->Model_sales_order->get_sj_detail($id,$jb)->row_array();
        $berat = $data['bruto'] - $data['netto'];

        $current = '';
        $data_printer = $this->db->query("select * from m_print_barcode_line where m_print_barcode_id = 3")->result_array();
        // print("<pre>".print_r($data_printer,true)."</pre>");
        // die();
        $data_printer[19]['string1'] = 'BARCODE 621,218,"39",144,0,180,2,6,"'.$data['no_packing'].'"';
        $data_printer[20]['string1'] = 'TEXT 560,64,"2",180,2,2,"'.$data['no_packing'].'"';
        $data_printer[21]['string1'] = 'TEXT 384,348,"1",180,2,2,"'.$data['nomor_bobbin'].'"';
        $data_printer[22]['string1'] = 'TEXT 426,316,"1",180,2,2,"'.$data['bruto'].'"';
        $data_printer[23]['string1'] = 'TEXT 405,282,"1",180,2,2,"'.$berat.'"';
        $data_printer[24]['string1'] = 'TEXT 423,249,"1",180,2,2,"'.$data['netto'].'"';
        $data_printer[28]['string1'] = 'TEXT 513,440,"1",180,2,2,"'.$data['kode'].'"';
        $data_printer[29]['string1'] = 'TEXT 665,403,"3",180,1,1,"'.$data['jenis_barang'].'"';
        // $data_printer[31]['string1'] = 'TEXT 496,373,"2",180,1,1,"'.$data['jenis_barang'].'"';
        // $data_printer[32]['string1'] = 'TEXT 497,407,"4",180,1,1,"'.$data['kode'].'"';
        $jumlah = count($data_printer);
        for($i=0;$i<$jumlah;$i++){
        $current .= $data_printer[$i]['string1']."\n";
        }

        echo "<form method='post' id=\"coba\" action=\"http://localhost:8080/print/print.php\">";
        echo "<input type='hidden' id='nospb' name='nospb' value='".$current."'>";
        echo "</form>";
        echo '<script type="text/javascript">document.getElementById(\'coba\').submit();</script>';
        }else{
            'GAGAL';
        }
    }

    function laporan_so_bulan(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        $data['content']= "sales_order/laporan_so_bulan";
        $this->load->model('Model_sales_order');

        $this->load->view('layout', $data);   
    }

    function laporan_so(){
        $module_name = $this->uri->segment(1);
        $id = $this->uri->segment(3);
        $group_id    = $this->session->userdata('group_id');        
        if($group_id != 1){
            $this->load->model('Model_modules');
            $roles = $this->Model_modules->get_akses($module_name, $group_id);
            $data['hak_akses'] = $roles;
        }
        $data['group_id']  = $group_id;
        $data['content']= "sales_order/laporan_so";
        $this->load->model('Model_sales_order');
        $data['summary'] = $this->Model_sales_order->summery_report_so()->result();

        $this->load->view('layout', $data);   
    }

    function view_laporan_so(){
        $module_name = $this->uri->segment(1);
        $tanggal = $this->uri->segment(3);
        if($tanggal){
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            // $items = strval($id);
            // $tgl=str_split($id,2);
            // $tahun=$tgl[1];
            // $bulan=$tgl[0];

            // $data['tgl'] = array(
            //     'tahun' => $tahun,
            //     'bulan' => $bulan
            // );

            $data['content']= "sales_order/view_laporan_so";
            $this->load->model('Model_sales_order');
            $data['detailLaporan'] = $this->Model_sales_order->show_view_laporan($tanggal)->result();
            // print_r($data['detailLaporan']);die();
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/SalesOrder/laporan_list_so');
        }
    }

    // function print_laporan_so(){
    //     $module_name = $this->uri->segment(1);
    //     $tanggal = $this->uri->segment(3);
    //     if($tanggal){
    //         $group_id    = $this->session->userdata('group_id');        
    //         if($group_id != 1){
    //             $this->load->model('Model_modules');
    //             $roles = $this->Model_modules->get_akses($module_name, $group_id);
    //             $data['hak_akses'] = $roles;
    //         }
    //         $data['group_id']  = $group_id;

    //         // $items = strval($id);
    //         // $tgl=str_split($id,2);
    //         // $tahun=$tgl[1];
    //         // $bulan=$tgl[0];

    //         // $data['tgl'] = array(
    //         //     'tahun' => $tahun,
    //         //     'bulan' => $bulan
    //         // );

    //         // $data['content']= "sales_order/view_laporan_so";
    //         $this->load->model('Model_sales_order');
    //         $data['detailLaporan'] = $this->Model_sales_order->show_view_laporan($tanggal)->result();
    //         // print_r($data['detailLaporan']);die();
    //         $this->load->view('sales_order/print_laporan_so', $data);   
    //     }else{
    //         redirect('index.php/SalesOrder/laporan_list_so');
    //     }
    // }

    function view_laporan_so_by_sj(){
        $module_name = $this->uri->segment(1);
        $tanggal = $this->uri->segment(3);
        if($tanggal){
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            // $items = strval($id);
            // $tgl=str_split($id,2);
            // $tahun=$tgl[1];
            // $bulan=$tgl[0];

            // $data['tgl'] = array(
            //     'tahun' => $tahun,
            //     'bulan' => $bulan
            // );

            $data['content']= "sales_order/laporan_so_by_sj";
            $this->load->model('Model_sales_order');
            // print_r($data['detailLaporan']);die();
            $this->load->view('layout', $data);   
        }else{
            redirect('index.php/SalesOrder/laporan_list_so');
        }
    }

    function print_laporan_so_by_sj(){
        $module_name = $this->uri->segment(1);
        $tanggal = $this->uri->segment(3);
        $ppn = $this->session->userdata('user_ppn');
            $start = date('Y-m-d', strtotime($_GET['ts']));
            $end = date('Y-m-d', strtotime($_GET['te']));
        if($start){
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;
            $this->load->helper('tanggal_indo');

            // $items = strval($id);
            // $tgl=str_split($id,2);
            // $tahun=$tgl[1];
            // $bulan=$tgl[0];

            // $data['tgl'] = array(
            //     'tahun' => $tahun,
            //     'bulan' => $bulan
            // );

            // $data['content']= "sales_order/view_laporan_so";
            $this->load->model('Model_sales_order');
            $data['detailLaporan'] = $this->Model_sales_order->show_view_laporan_by_sj($start,$end,$ppn)->result();
            // print_r($data['detailLaporan']);die();
            $this->load->view('sales_order/print_laporan_so_by_sj', $data);   
        }else{
            redirect('index.php/SalesOrder/index');
        }
    }

    function print_laporan_so_by_jb(){
        $module_name = $this->uri->segment(1);
        $tanggal = $this->uri->segment(3);
        $ppn = $this->session->userdata('user_ppn');
        $start = date('Y-m-d', strtotime($_GET['ts']));
        $end = date('Y-m-d', strtotime($_GET['te']));

        if($start){
            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;
            $this->load->helper('tanggal_indo');

            // $items = strval($id);
            // $tgl=str_split($id,2);
            // $tahun=$tgl[1];
            // $bulan=$tgl[0];

            // $data['tgl'] = array(
            //     'tahun' => $tahun,
            //     'bulan' => $bulan
            // );

            // $data['content']= "sales_order/view_laporan_so";
            $this->load->model('Model_sales_order');
            $data['detailLaporan'] = $this->Model_sales_order->show_view_laporan_by_jb($start,$end,$ppn)->result();
            // print_r($data['detailLaporan']);die();
            $this->load->view('sales_order/print_laporan_so_by_jb', $data);   
        }else{
            redirect('index.php/SalesOrder/index');
        }
    }

    function print_sisa_so(){
            $module_name = $this->uri->segment(1);
            $ppn = $this->session->userdata('user_ppn');
            $this->load->helper('tanggal_indo');

            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $this->load->model('Model_sales_order');
            $data['detailHarian'] = $this->Model_sales_order->detail_harian_so($ppn)->row_array();
            $data['detailBulanan'] = $this->Model_sales_order->detail_bulanan_so($ppn)->row_array();
            $data['detailLaporan'] = $this->Model_sales_order->sisa_so($ppn)->result();
            $this->load->view('sales_order/print_sisa_so', $data);
    }

    function print_sisa_so_gabungan(){
            $module_name = $this->uri->segment(1);
            $this->load->helper('tanggal_indo');

            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $this->load->model('Model_sales_order');
            $data['detailHarian'] = $this->Model_sales_order->detail_harian_sog()->row_array();
            $data['detailBulanan'] = $this->Model_sales_order->detail_bulanan_sog()->row_array();
            $data['detailLaporan'] = $this->Model_sales_order->sisa_so_gabungan()->result();
            $this->load->view('sales_order/print_sisa_so', $data);
    }

    function print_sisa_so_gabungan_jb(){
            $module_name = $this->uri->segment(1);
            $this->load->helper('tanggal_indo');

            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $this->load->model('Model_sales_order');
            $data['detailHarian'] = $this->Model_sales_order->detail_harian_sog()->row_array();
            $data['detailBulanan'] = $this->Model_sales_order->detail_bulanan_sog()->row_array();
            $data['detailLaporan'] = $this->Model_sales_order->sisa_so_gabungan_jb()->result();
            $this->load->view('sales_order/print_sisa_so_gabungan_jb', $data);
    }

    function print_so_bulan(){
            $module_name = $this->uri->segment(1);
            $ppn = $this->session->userdata('user_ppn');
            $this->load->helper('tanggal_indo');

            $start = date('Y-m-d', strtotime($_GET['ts']));
            $end = date('Y-m-d', strtotime($_GET['te']));

            $group_id    = $this->session->userdata('group_id');        
            if($group_id != 1){
                $this->load->model('Model_modules');
                $roles = $this->Model_modules->get_akses($module_name, $group_id);
                $data['hak_akses'] = $roles;
            }
            $data['group_id']  = $group_id;

            $this->load->model('Model_sales_order');
            $data['detailLaporan'] = $this->Model_sales_order->laporan_per_sj_bulan($start,$end,$ppn)->result();
            $this->load->view('sales_order/print_sisa_so_bulan', $data);
    }
}