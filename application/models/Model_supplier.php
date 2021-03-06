<?php
class Model_supplier extends CI_Model{
    function list_data(){
        $data = $this->db->query("Select spl.*, 
                    prov.province_name, cty.city_name,
                    bank.kode_bank
                From supplier spl 
                    Left Join m_provinces prov On (spl.m_province_id = prov.id) 
                    Left Join m_cities cty On (spl.m_city_id = cty.id)
                    Left Join bank On (spl.m_bank_id = bank.id) 
                Order By spl.nama_supplier");
        return $data;
    }
    
    function show_data($id){
        $data = $this->db->query("Select spl.*, 
                    prov.province_name, cty.city_name,
                    bank.kode_bank
                From supplier spl 
                    Left Join m_provinces prov On (spl.m_province_id = prov.id) 
                    Left Join m_cities cty On (spl.m_city_id = cty.id)
                    Left Join bank On (spl.m_bank_id = bank.id) Where spl.id=".$id);        
        return $data;
    }
    
    function list_provinsi(){
        $data = $this->db->query("Select * From m_provinces Order By province_name");
        return $data;
    }
    
    function list_kota($id){
        $data = $this->db->query("Select * From m_cities Where m_province_id=".$id." Order By city_name");
        return $data;
    }
    
    function list_bank(){
        $data = $this->db->query("Select * From bank Order By kode_bank");
        return $data;
    }
}