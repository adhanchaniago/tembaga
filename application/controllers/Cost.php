<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cost extends CI_Controller{
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

        $data['content']= "cost/index";
        $this->load->model('Model_cost');
        $data['list_data'] = $this->Model_cost->list_data()->result();
        $data['list_group_cost'] = $this->Model_cost->list_group_cost()->result();

        $this->load->view('layout', $data);
    }
    
    function cek_code(){
        $code = $this->input->post('data');
        $this->load->model('Model_cost');
        $cek_data = $this->Model_cost->cek_data($code)->row_array();
        $return_data = ($cek_data)? "ADA": "TIDAK ADA";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }
    
    function save(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                    'nama_cost'=> $this->input->post('nama_cost'),
                    'group_cost_id'=> $this->input->post('group_cost_id'),
                    'remarks'=> $this->input->post('remarks'),
                    'created'=> $tanggal,
                    'created_by'=> $user_id,
                    'modified'=> $tanggal,
                    'modified_by'=> $user_id
                );
       
        $this->db->insert('cost', $data); 
        $this->session->set_flashdata('flash_msg', 'Data berhasil disimpan');
        redirect('index.php/Cost');       
    }
    
    function delete(){
        $id = $this->uri->segment(3);
        if(!empty($id)){
            $this->db->where('id', $id);
            $this->db->delete('cost');            
        }
        $this->session->set_flashdata('flash_msg', 'Data berhasil dihapus');
        redirect('index.php/Cost');
    }
    
    function edit(){
        $id = $this->input->post('id');
        $this->load->model('Model_cost');
        $data = $this->Model_cost->show_data($id)->row_array(); 
        
        header('Content-Type: application/json');
        echo json_encode($data);       
    }
    
    function update(){
        $user_id  = $this->session->userdata('user_id');
        $tanggal  = date('Y-m-d h:m:s');
        
        $data = array(
                'nama_cost'=> $this->input->post('nama_cost'),
                'group_cost_id'=> $this->input->post('group_cost_id'),
                'remarks'=> $this->input->post('remarks'),
                'modified'=> $tanggal,
                'modified_by'=> $user_id
            );
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('cost', $data);
        
        $this->session->set_flashdata('flash_msg', 'Data berhasil disimpan');
        redirect('index.php/Cost');
    }
    
}