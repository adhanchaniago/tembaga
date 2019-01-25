<?php
class Model_tolling_resmi extends CI_Model{

	function list_tolling(){
		$data = $this->db->query("select rd.id, rd.no_dtr_resmi, rd.tanggal, mc.nama_customer,t.no_ttr_resmi, tsj.no_sj_resmi, ti.no_invoice_resmi from r_dtr rd
		left join r_t_surat_jalan tsj on tsj.id = rd.sj_id
        left join r_ttr t on t.r_dtr_id = rd.id
        left join r_t_invoice ti on ti.id = tsj.r_invoice_id
        left join m_customers mc on mc.id = rd.customer_id
        order by id asc");
		return $data;
	}

	function list_sj(){
		$data = $this->db->query("select * from r_t_surat_jalan where flag_tolling = 0");
		return $data;
	}

	function get_customer_sj($id){
		$data = $this->db->query("select tsj.m_customer_id, mc.nama_customer from r_t_surat_jalan tsj 
			left join m_customers mc on mc.id=tsj.m_customer_id
			where tsj.id=".$id);
		return $data;
	}

	function list_sj_detail($id){
        $data = $this->db->query("select ird.*, dtrd.no_pallete, dtrd.qty, r.nama_item, dtr.id as dtr_id
            from r_t_invoice_detail ird
            left join dtr_detail dtrd on (ird.dtr_detail_id = dtrd.id)
            left join dtr on (dtrd.dtr_id = dtr.id)
            left join rongsok r on (dtrd.rongsok_id = r.id)
            where ird.invoice_resmi_id = ".$id);
        return $data;
    }
}