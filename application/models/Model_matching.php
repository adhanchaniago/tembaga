<?php
class Model_matching extends CI_Model{

    function list_invoice(){
        $data = $this->db->query("Select ir.*, (select count(tid.id) from r_t_invoice_detail tid where tid.invoice_resmi_id = ir.id) as jumlah_item
            from r_t_invoice ir");
        return $data;
    }

    function list_invoice_fg(){
        $data = $this->db->query("select fi.*,tso.jenis_barang from f_invoice fi
            left join sales_order so on so.id = fi.id_sales_order
            left join t_sales_order tso on tso.so_id = so.id
            where tso.jenis_barang ='FG' and flag_resmi = 0");
        return $data;
    }

    function get_jumlah($id){
        $data = $this->db->query("select fi.id, (select sum(fid.netto) from f_invoice_detail fid where fid.id_invoice = fi.id) as netto_invoice from f_invoice fi
            where fi.id =".$id);
        return $data;
    }

    function show_header_invoice($id){
        $data = $this->db->query("Select ir.*, fi.no_invoice, u.realname as pic
            from r_t_invoice ir
            left join f_invoice fi on fi.id = ir.invoice_id
            left join users u on (ir.created_by = u.id)
            where ir.id =".$id);
        return $data;
    }

    function list_dtr(){
        $data = $this->db->query("select dtr.*, r.nama_item, (select SUM(netto) from dtr_detail where dtr_detail.dtr_id = dtr.id and flag_resmi = 0) as netto, dtrd.berat_palette, dtrd.no_pallete, dtrd.line_remarks
            from dtr 
            left join dtr_detail dtrd on (dtr.id = dtrd.dtr_id)
            left join rongsok r on (dtrd.rongsok_id = r.id)
            where dtr.status = 1 and dtr.flag_taken = 0 group by dtr.no_dtr
            order by dtr.tanggal asc");
        return $data;
    }

    function list_invoice_detail($id){
        $data = $this->db->query("select ird.*, dtrd.no_pallete, dtrd.qty, r.nama_item, dtr.id as dtr_id
            from r_t_invoice_detail ird
            left join dtr_detail dtrd on (ird.dtr_detail_id = dtrd.id)
            left join dtr on (dtrd.dtr_id = dtr.id)
            left join rongsok r on (dtrd.rongsok_id = r.id)
            where ird.invoice_resmi_id = ".$id);
        return $data;
    }

    function load_detail_dtr($id){
        $data = $this->db->query("select dtrd.*, r.nama_item, (select sum(netto) from dtr_detail where dtr_id = dtrd.id) as total_netto
            from dtr_detail dtrd
            left join rongsok r on (dtrd.rongsok_id = r.id)
            where dtrd.flag_resmi = 0 and dtrd.dtr_id = ".$id);
        return $data;
    }

    function load_invoice_detail($id){
        $data = $this->db->query("select ird.*, dtrd.no_pallete, r.nama_item, dtr.id as dtr_id
            from r_t_invoice_detail ird
            left join dtr_detail dtrd on (ird.dtr_detail_id = dtrd.id)
            left join dtr on (dtrd.dtr_id = dtr.id)
            left join rongsok r on (dtrd.rongsok_id = r.id)
            where ird.invoice_resmi_id = ".$id);
        return $data;
    }
}