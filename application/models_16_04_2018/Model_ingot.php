<?php
class Model_ingot extends CI_Model{
    function list_data(){
        $data = $this->db->query("Select pi.*, 
                    usr.realname As pic,
                    (Select count(pid.id)As jumlah_item From produksi_ingot_detail pid Where pid.produksi_ingot_id = pi.id)As jumlah_item,
                    (Select Count(pid.id)As ready_to_spb From produksi_ingot_detail pid Where 
                    pid.produksi_ingot_id = pi.id And pid.flag_spb=0)As ready_to_spb
                From produksi_ingot pi
                    Left Join users usr On (pi.created_by = usr.id) 
                Order By pi.id Desc");
        return $data;
    }
    
    function show_header_pi($id){
        $data = $this->db->query("Select pi.*, 
                    usr.realname As pic
                From produksi_ingot pi
                    Left Join users usr On (pi.created_by = usr.id) 
                Where pi.id=".$id);
        return $data;
    }
    
    function list_pallete(){
        $data = $this->db->query("Select distinct no_pallete From dtr_detail Order By no_pallete");
        return $data;
    }        
    
    function load_detail($id){
        $data = $this->db->query("Select pid.*, rsk.nama_item, rsk.uom From produksi_ingot_detail pid 
                Left Join rongsok rsk On(pid.rongsok_id = rsk.id) 
                Where pid.produksi_ingot_id=".$id);
        return $data;
    }
    
    function show_detail_pi($id){
        $data = $this->db->query("Select pid.*, rsk.nama_item, rsk.uom
                    From produksi_ingot_detail pid 
                        Left Join rongsok rsk On (pid.rongsok_id = rsk.id) 
                    Where pid.produksi_ingot_id=".$id);
        return $data;
    }

    function spb_list(){
        $data = $this->db->query("Select spb.*, 
                    pi.no_produksi, 
                    usr.realname As pic,
                (Select count(spbd.id)As jumlah_item From spb_detail spbd Where spbd.spb_id = spb.id)As jumlah_item,
                (Select Count(spbd.id)As ready_to_skb From spb_detail spbd Where 
                    spbd.spb_id = spb.id And spbd.flag_skb=0)As ready_to_skb
                From spb
                    Left Join produksi_ingot pi On (spb.produksi_ingot_id = pi.id) 
                    Left Join users usr On (spb.created_by = usr.id) 
                Where spb.jenis_barang='INGOT'
                Order By spb.id Desc");
        return $data;
    }
    
    function show_header_spb($id){
        $data = $this->db->query("Select spb.*, 
                    pi.no_produksi,
                    usr.realname As pic
                    From spb
                        Left Join produksi_ingot pi On (spb.produksi_ingot_id = pi.id) 
                        Left Join users usr On (spb.created_by = usr.id) 
                    Where spb.id=".$id);
        return $data;
    }
    
    function show_detail_spb($id){
        $data = $this->db->query("Select spbd.*, rsk.nama_item, rsk.uom,
                        pid.no_pallete
                    From spb_detail spbd 
                        Left Join rongsok rsk On (spbd.rongsok_id = rsk.id) 
                        Left Join produksi_ingot_detail pid On (spbd.produksi_ingot_detail_id = pid.id)
                    Where spbd.spb_id=".$id);
        return $data;
    }
    
    function skb_list(){
        $data = $this->db->query("Select skb.*, 
                    spb.no_spb,
                    pi.no_produksi, 
                    pmh.realname As pemohon,
                    usr.realname As pic,
                (Select count(skbd.id)As jumlah_item From skb_detail skbd Where skbd.skb_id = skb.id)As jumlah_item
                From skb 
                    Left Join spb On (skb.spb_id = spb.id)
                    Left Join produksi_ingot pi On (spb.produksi_ingot_id = pi.id) 
                    Left Join users pmh On (spb.created_by = pmh.id) 
                    Left Join users usr On (skb.created_by = usr.id) 
                Where skb.jenis_barang='INGOT'
                Order By skb.id Desc");
        return $data;
    }
    
    function show_header_skb($id){
        $data = $this->db->query("Select skb.*, 
                    spb.no_spb,
                    pi.no_produksi, 
                    pmh.realname As pemohon,
                    usr.realname As pic
                From skb
                    Left Join spb On (skb.spb_id = spb.id)
                    Left Join produksi_ingot pi On (spb.produksi_ingot_id = pi.id) 
                    Left Join users pmh On (spb.created_by = pmh.id) 
                    Left Join users usr On (skb.created_by = usr.id) 
                Where skb.id=".$id);
        return $data;
    }
    
    function show_detail_skb($id){
        $data = $this->db->query("Select skbd.*, rsk.nama_item, rsk.uom,                        
                        pid.no_pallete
                    From skb_detail skbd 
                        Left Join rongsok rsk On (skbd.rongsok_id = rsk.id) 
                        Left Join spb_detail spbd On (skbd.spb_detail_id = spbd.id)
                        Left Join produksi_ingot_detail pid On (spbd.produksi_ingot_detail_id = pid.id)
                    Where skbd.skb_id=".$id);
        return $data;
    }    
        
    function hasil_produksi(){
        $data = $this->db->query("Select pa.*, 
                    usr.realname As pic,
                    skb.no_skb,
                (Select count(pad.id)As jumlah_item From produksi_ampas_detail pad Where pad.produksi_ampas_id = pa.id)As jumlah_item
                From produksi_ampas pa
                    Left Join skb On (pa.skb_id = skb.id)
                    Left Join users usr On (pa.created_by = usr.id) 
                Where pa.jenis_barang='Ingot' And pa.skb_id>0
                Order By pa.id Desc");
        return $data;
    }
    
    function get_skb_list(){
        $data = $this->db->query("Select id, no_skb From skb 
                Where flag_produksi=0 And skb.jenis_barang='INGOT'
                Order By no_skb");
        return $data;
    }
    
    function jenis_barang_list(){
        $data = $this->db->query("Select * From jenis_barang Order By jenis_barang");
        return $data;
    }

   
    
    function show_header_pa($id){
        $data = $this->db->query("Select pa.*, 
                    skb.no_skb,
                    usr.realname As pic
                    From produksi_ampas pa
                        Left Join skb On (pa.skb_id = skb.id) 
                        Left Join users usr On (pa.created_by = usr.id)
                    Where pa.id=".$id);
        return $data;
    }
    
    function load_detail_produksi($id){
        $data = $this->db->query("Select pad.*, rsk.nama_item, rsk.uom From produksi_ampas_detail pad 
                Left Join rongsok rsk On(pad.rongsok_id = rsk.id) 
                Where pad.produksi_ampas_id=".$id);
        return $data;
    }

    
    
}