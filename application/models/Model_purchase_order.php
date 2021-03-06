<?php
class Model_purchase_order extends CI_Model{
	
	function po_list($s,$e){
		$data = $this->db->query("select rpo.*, coalesce(cs.nama_customer,c.nama_cv) as nama_cv, coalesce(cs.pic, c.pic) as pic, (select count(tpd.id) from r_t_po_detail tpd where tpd.po_id = rpo.id)as jumlah_item
			from r_t_po rpo
			left join m_customers_cv cs on (rpo.customer_id = cs.id)
			left join m_cv c on (rpo.cv_id = c.id)
			where rpo.tanggal between '".$s."' and '".$e."'
			order by rpo.tanggal desc, rpo.no_po desc");
		return $data;
	}

	function po_list_for_cv($reff_cv,$s,$e){
		$data = $this->db->query("select rpo.*, coalesce(cs.nama_customer,c.nama_cv) as nama_cv, coalesce(cs.pic, c.pic) as pic, (select count(tpd.id) from r_t_po_detail tpd where tpd.po_id = rpo.id)as jumlah_item
			from r_t_po rpo
			left join m_customers_cv cs on (rpo.customer_id = cs.id)
			left join m_cv c on (rpo.cv_id = c.id)
			where rpo.tanggal between '".$s."' and '".$e."' and rpo.reff_cv = ".$reff_cv." 
			order by rpo.tanggal desc, rpo.no_po desc");
		return $data;
	}

	function po_list_for_cv_new($reff_cv, $jenis,$s,$e){
		if ($jenis == 'Supplier') {
			$data = $this->db->query("select rpo.*, coalesce(cs.nama_customer,c.nama_cv) as nama_cv, coalesce(cs.pic, c.pic) as pic, (select count(tpd.id) from r_t_po_detail tpd where tpd.po_id = rpo.id)as jumlah_item
			from r_t_po rpo
			left join m_customers_cv cs on (rpo.customer_id = cs.id)
			left join m_cv c on (rpo.cv_id = c.id)
			where rpo.tanggal between '".$s."' and '".$e."' and rpo.reff_cv = ".$reff_cv." and rpo.jenis_po = 'PO CV KE KMP'
			order by rpo.tanggal desc, rpo.no_po desc");
		} else if ($jenis == 'Customer') {
			$data = $this->db->query("select rpo.*, coalesce(cs.nama_customer,c.nama_cv) as nama_cv, coalesce(cs.pic, c.pic) as pic, (select count(tpd.id) from r_t_po_detail tpd where tpd.po_id = rpo.id)as jumlah_item
			from r_t_po rpo
			left join m_customers_cv cs on (rpo.customer_id = cs.id)
			left join m_cv c on (rpo.cv_id = c.id)
			where rpo.tanggal between '".$s."' and '".$e."' and rpo.reff_cv = ".$reff_cv." and rpo.jenis_po = 'PO CUSTOMER KE CV'
			order by rpo.tanggal desc, rpo.no_po desc");
		} else {
			$data = $this->db->query("select rpo.*, coalesce(cs.nama_customer,c.nama_cv) as nama_cv, coalesce(cs.pic, c.pic) as pic, (select count(tpd.id) from r_t_po_detail tpd where tpd.po_id = rpo.id)as jumlah_item
			from r_t_po rpo
			left join m_customers_cv cs on (rpo.customer_id = cs.id)
			left join m_cv c on (rpo.cv_id = c.id)
			where rpo.reff_cv = ".$reff_cv." and rpo.tanggal between '".$s."' and '".$e."' 
			order by rpo.tanggal desc, rpo.no_po desc");
		}
		
		return $data;
	}

	function po_list_for_kmp($s,$e){
		$data = $this->db->query("select rpo.*, coalesce(cs.nama_customer,c.nama_cv) as nama_cv, coalesce(cs.pic, c.pic) as pic, (select count(tpd.id) from r_t_po_detail tpd where tpd.po_id = rpo.id)as jumlah_item
			from r_t_po rpo
			left join m_customers_cv cs on (rpo.customer_id = cs.id)
			left join m_cv c on (rpo.cv_id = c.id)
			where rpo.cv_id != 0 and rpo.tanggal between '".$s."' and '".$e."'
			order by rpo.tanggal desc");
		return $data;
	}

	function invoice_list($id){
		$data = $this->db->query("select ti.id, ti.invoice_id, ti.no_invoice_resmi, fi.no_invoice, mc.id as customer_id, mc.nama_cv, mc.pic from r_t_invoice ti
			left join f_invoice fi on fi.id = ti.invoice_id
		    left join m_cv mc on mc.id = fi.id_customer
		    where ti.id =".$id);
		return $data;
	}

	function get_po_customer($id){
		$data = $this->db->query("select rpo.*, cv.nama_cv from r_t_po rpo left join m_cv cv on cv.id = rpo.reff_cv where rpo.id=".$id);
		return $data;
	}

	function invoice_detail($id){
		$data = $this->db->query("select fid.id, fid.id_invoice, fid.sj_detail_id, fid.jenis_barang_id, sum(fid.qty) as qty, sum(fid.netto) as netto, fid.harga, sum(fid.total_harga) as total_harga from f_invoice_detail fid 
		where fid.id_invoice =".$id." group by fid.jenis_barang_id");
		return $data;
	}

	function po_detail($id){
		$data = $this->db->query("select *from r_t_po_detail where po_id=".$id);
		return $data;
	}

	function customer_list($reff_cv){
		$this->db->order_by('nama_customer','ASC');
		$data = $this->db->get_where('m_customers_cv', ['reff_cv' => $reff_cv]);
		return $data;
	}

	function cv_list(){
		$data = $this->db->query("select id, nama_cv, pic from m_cv");
		return $data;
	}

	function get_contact_name($id){
		$this->db->select('pic');
		$this->db->where('id', $id);
		$data = $this->db->get('m_cv');
		return $data;
	}

	function get_contact_name_customer($id){
		$this->db->select('pic');
		$this->db->where('id', $id);
		$data = $this->db->get('m_customers_cv');
		return $data;
	}

	function show_header_po($id){
		$data = $this->db->query("select rpo.*, c.nama_cv, c.pic, c.alamat, rso.id as so_id, rso.no_so, c.idkmp
			from r_t_po rpo
			left join m_cv c on (rpo.cv_id = c.id)
			left join r_t_so  rso on (rso.po_id = rpo.id)
			where rpo.id = ".$id);
		return $data;
	}

	function load_detail_po($id){
		$data = $this->db->query("select rpod.*, jb.jenis_barang, jb.uom, jb.kode
			from r_t_po_detail rpod
			left join jenis_barang jb on (rpod.jenis_barang_id = jb.id)
			where rpod.po_id =".$id);
		return $data;
	}

	function load_detail_po_sj($id){
		$data = $this->db->query("select rpod.*, tsjd.bruto as bruto_tsjd, tsjd.netto as netto_tsjd, tsjd.no_packing, jb.jenis_barang, jb.uom, jb.kode
			from r_t_po_detail rpod
            left join r_t_po rpo on (rpo.id = rpod.po_id)
			left join f_invoice fi on (rpo.f_invoice_id = fi.id)
			left join t_surat_jalan_detail tsjd on (fi.id_surat_jalan = tsjd.t_sj_id)
			left join jenis_barang jb on jb.id=(case when tsjd.jenis_barang_alias > 0 then tsjd.jenis_barang_alias else tsjd.jenis_barang_id end)
			where rpod.po_id =".$id);

		// $data = $this->db->query("select rpod.*, tsjd.bruto as bruto_tsjd, tsjd.netto as netto_tsjd, tsjd.no_packing, jb.jenis_barang, jb.uom, jb.kode
		// 	from r_t_po_detail rpod
  //           left join r_t_po rpo on (rpo.id = rpod.po_id)
		// 	left join f_invoice fi on (rpo.f_invoice_id = fi.id)
		// 	left join t_surat_jalan_detail tsjd on (fi.id_surat_jalan = tsjd.t_sj_id)
		// 	left join jenis_barang jb on jb.id=(case when tsjd.jenis_barang_alias > 0 then tsjd.jenis_barang_alias else tsjd.jenis_barang_id end)
		// 	where rpod.po_id =".$id);
		// $data = $this->db->query("select fid.*, tsjd.bruto, tsjd.no_packing, tsjd.nomor_bobbin,
		// (select id from r_t_po_detail rtpd where rtpd.po_id = rtp.id and rtpd.jenis_barang_id = fid.jenis_barang_id) as po_detail_id
		// from f_invoice_detail fid 
		// left join t_surat_jalan_detail tsjd on tsjd.id = fid.sj_detail_id
  //       left join r_t_po rtp on rtp.f_invoice_id = fid.id_invoice
		// where rtp.id =".$id);
		return $data;
	}

	function show_header_print_po($id){
		$data = $this->db->query("select rpo.*, cv.nama_cv, cs.nama_customer as nama, cs.pic, cv.pic as pic_cv, cs.alamat, cv.alamat as alamat_cv
			from r_t_po rpo
            left join r_t_surat_jalan rtsj on rtsj.id = rpo.flag_sj
			left join m_customers_cv cs on (rpo.customer_id = cs.id)
            left join m_cv cv on (rpo.reff_cv = cv.id)
			where rpo.id = ".$id);
		return $data;
	}

	function get_no_po($id){
		return $this->db->get_where('r_t_po', ['id' => $id]);
	}

	function get_po_detail_only($id){
		return $this->db->query('select id, po_id, jenis_barang_id, qty, netto, amount, total_amount from r_t_po_detail where po_id = '.$id);
	}
}