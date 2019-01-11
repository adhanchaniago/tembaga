<?php
class Model_voucher_cost extends CI_Model{
    function list_data(){
        $data = $this->db->query("Select voucher.*, 
                gc.nama_group_cost,
                cost.nama_cost,
                mc.nama_customer,
                supp.nama_supplier,
                COALESCE(cost.nama_cost, mc.nama_customer, supp.nama_supplier) as nama_trx
                From voucher 
                    Left Join group_cost gc On (voucher.group_cost_id = gc.id) 
                    Left Join cost On (voucher.cost_id = cost.id)
                    LEFT JOIN m_customers mc ON (voucher.customer_id = mc.id)
                    left join supplier supp on (voucher.supplier_id = supp.id)
                Where voucher.jenis_voucher='Manual'
                Order By voucher.no_voucher");
        return $data;
    }
    
    function get_cost_list($id){
        $data = $this->db->query("Select * From cost Where group_cost_id=".$id);
        return $data;
    }
            
    function show_data($id){
        $data = $this->db->query("Select * From cost Where id=".$id);        
        return $data;
    }
    
    function list_group_cost(){
        $data = $this->db->query("Select * From group_cost Order By nama_group_cost");
        return $data;
    }

    function get_customer(){
        $data = $this->db->query("select id, nama_customer as nama_cost from m_customers order by nama_customer");
        return $data;
    }

    function get_supplier(){
        $data = $this->db->query("select id, nama_supplier as nama_cost from supplier order by nama_supplier");
        return $data;
    }

    function customer_list(){
        $data = $this->db->query("Select voucher.*, 
                gc.nama_group_cost,
                mc.nama_customer as nama_cost
                From voucher 
                    Left Join group_cost gc On (voucher.group_cost_id = gc.id)
                    Left Join m_customers mc on (voucher.cost_id = mc.id) 
                Where voucher.jenis_voucher='Manual'
                Order By voucher.no_voucher");
        return $data;
    }
}