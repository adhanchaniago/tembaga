<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MCities extends CI_Controller{
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
        
        $data['judul']  = "MCities";
        $data['content']= "m_cities/index";
        
        $this->load->model('Model_m_cities');
        $data['list_data']    = $this->Model_m_cities->list_data()->result();
        $data['province_list'] = $this->Model_m_cities->get_province()->result();

        $this->load->view('layout', $data);
    }
    
    function cek_code(){
        $code = $this->input->post('data');
        $this->load->model('Model_m_cities');
        $cek_data = $this->Model_m_cities->cek_data($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function save(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        
        $data = array(
                        'city_code'=> $this->input->post('city_code'),
                        'city_name'=> $this->input->post('city_name'),
                        'm_province_id'=> $this->input->post('m_province_id'),
                        'created'=> $tanggal,
                        'created_by'=> $user_id,
                        'modified'=> $tanggal,
                        'modified_by'=> $user_id,
                    );

        $this->db->insert('m_cities', $data);  
        $this->session->set_flashdata('flash_msg', 'Data kota berhasil disimpan');
        redirect('index.php/MCities');   
    }
    
    function delete(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('m_cities');            
        }
        $this->session->set_flashdata('flash_msg', 'Data kota berhasil dihapus');
        redirect('index.php/MCities');
    }
    
    function edit(){
        $id = $this->input->post('id');
        $this->load->model('Model_m_cities');
        $data = $this->Model_m_cities->show_data($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function update(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d H:i:s');
        
        $data = array(
                'city_code'=> $this->input->post('city_code'),
                'city_name'=> $this->input->post('city_name'),
                'm_province_id'=> $this->input->post('m_province_id'),
                'flag_sinkronisasi'=>0,
                'flag_action'=>'U',
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('m_cities', $data);
        
        $this->session->set_flashdata('flash_msg', 'Data kota berhasil disimpan');
        redirect('index.php/MCities');
    }
}