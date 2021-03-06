<?php
class Model_ingot extends CI_Model{
    function list_data(){
        $data = $this->db->query("Select pi.*, jb.jenis_barang,
                    usr.realname As pic,
                    (Select count(pid.id)As jumlah_item From produksi_ingot_detail pid Where pid.produksi_ingot_id = pi.id)As jumlah_item,
                    (Select Count(pid.id)As ready_to_spb From produksi_ingot_detail pid Where 
                    pid.produksi_ingot_id = pi.id And pid.flag_spb=0)As ready_to_spb
                From produksi_ingot pi
                    Left Join users usr On (pi.created_by = usr.id) 
                    Left Join jenis_barang jb On (pi.jenis_barang_id = jb.id)
                Order By pi.id Desc");
        return $data;
    }
    
    function show_header_pi($id){
        $data = $this->db->query("Select pi.*, jb.jenis_barang,
                    usr.realname As pic
                From produksi_ingot pi
                    Left Join users usr On (pi.created_by = usr.id) 
                    left join jenis_barang jb on (jb.id = pi.jenis_barang_id)
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
                    aprv.realname As approved_name,
                    rjt.realname As rejected_name,
                (Select count(spbd.id)As jumlah_item From spb_detail spbd Where spbd.spb_id = spb.id)As jumlah_item
                From spb
                    Left Join produksi_ingot pi On (spb.produksi_ingot_id = pi.id) 
                    Left Join users usr On (spb.created_by = usr.id) 
                    Left Join users aprv On (spb.approved_by = aprv.id) 
                    Left Join users rjt On (spb.rejected_by = rjt.id) 
                Where spb.jenis_barang=2
                Order By spb.id Desc");
        return $data;
    }
    
    function show_header_spb($id){
        $data = $this->db->query("Select spb.*, 
                    pi.no_produksi,
                    usr.realname As pic,
                    appr.realname As approved_name,
                    rjct.realname As reject_name
                    From spb
                        Left Join produksi_ingot pi On (spb.produksi_ingot_id = pi.id) 
                        Left Join users usr On (spb.created_by = usr.id) 
                        Left Join users appr On (spb.approved_by = appr.id)
                        Left Join users rjct On (spb.rejected_by = rjct.id)
                    Where spb.id=".$id);
        return $data;
    }
    
    function show_detail_spb($id){
        $data = $this->db->query("Select spbd.*, rsk.nama_item, rsk.uom, rsk.stok
                    From spb_detail spbd 
                        Left Join rongsok rsk On (spbd.rongsok_id = rsk.id) 
                        Left Join produksi_ingot_detail pid On (spbd.produksi_ingot_detail_id = pid.id)
                    Where spbd.spb_id=".$id);
        return $data;
    }
    
    function show_detail_spb_fulfilment($id){
        $data = $this->db->query("Select rsk.nama_item, rsk.uom, rsk.stok,dtrd.no_pallete,dtrd.netto, dtrd.line_remarks
                    From spb_detail_fulfilment spdf 
                        left join dtr_detail dtrd on (dtrd.id = spdf.dtr_detail_id) 
                        Left Join rongsok rsk On (dtrd.rongsok_id = rsk.id)
                    Where spdf.spb_id=".$id.
                    " ");
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
        $data = $this->db->query("Select thm.*,  pi.no_produksi,
                    usr.realname As pic
                From t_hasil_masak thm
                    
                    Left Join users usr On (thm.created_by = usr.id)
                    Left Join produksi_ingot pi On (pi.id = thm.no_masak) 
                
                Order By thm.id Desc");
        return $data;
    }
    
    function get_skb_list(){
        $data = $this->db->query("Select id, no_skb From skb 
                Where flag_produksi=0 And skb.jenis_barang='INGOT'
                Order By no_skb");
        return $data;
    }
    
    function get_no_produksi_list(){
        $data = $this->db->query("Select pi.id, pi.no_produksi From spb
                inner join produksi_ingot pi on (pi.id = spb.produksi_ingot_id)
                where spb.status = 1 and flag_result=0
                Order By no_produksi");
        return $data;
    }

    function get_detail_produksi($id){
        $data = $this->db->query("Select no_spb,
                (Select sum(dtrd.netto) From dtr_detail dtrd
                left join spb_detail_fulfilment spbf on spbf.dtr_detail_id = dtrd.id
                Where spbf.spb_id = spb.id)As total_rongsok
                From spb 
                Left Join produksi_ingot pi On (spb.produksi_ingot_id = pi.id) 
                where pi.id = ".$id."
                Order By no_produksi");
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

    function show_related_stok($id){

    }

    function get_dtr_detail_by_no_pallete($no_pallete){
        $data = $this->db->query(
                "select dtr_detail.id,(ttr.id)as 'ttr_id' ,bruto, netto,no_pallete,line_remarks, (rongsok.nama_item)as rongsokname,rongsok.uom
                from dtr_detail
                left join rongsok on rongsok.id = dtr_detail.rongsok_id
                left join ttr on ttr.dtr_id = dtr_detail.dtr_id
                where no_pallete='".$no_pallete."' and flag_taken=0"
                );
        return $data;
    }    
    
}