<?php
class Model_beli_sparepart extends CI_Model{
    function list_data(){
        $data = $this->db->query("Select bsp.*, 
                usr.realname,
                aprv.realname As approve_name,
                (Select count(id)As jumlah_item From beli_sparepart_detail bspd Where bspd.beli_sparepart_id = bsp.id)As jumlah_item,
                (Select Count(bspd.id)As ready_to_create From beli_sparepart_detail bspd Where 
                    bspd.beli_sparepart_id = bsp.id And bspd.flag_po=0)As ready_to_create
                From beli_sparepart bsp
                    Left Join users usr On (bsp.created_by = usr.id) 
                    Left Join users aprv On (bsp.approved_by = aprv.id) 
                Order By tgl_pengajuan Desc");
        return $data;
    }
    
    function show_data($id){
        $data = $this->db->query("Select bsp.*, 
                crt.realname As created_name,
                aprv.realname As approve_name
                From beli_sparepart bsp
                    Left Join users crt On (bsp.created_by = crt.id) 
                    Left Join users aprv On (bsp.rejected_by = aprv.id) 
                Where bsp.id=".$id);        
        return $data;
    }
    
    function load_detail($id){
        $data = $this->db->query("Select bsd.*, part.nama_item, part.uom From beli_sparepart_detail bsd 
                Left Join sparepart part On(bsd.sparepart_id = part.id) 
                Where bsd.beli_sparepart_id=".$id);
        return $data;
    }
    
    function supplier_list(){
        $data = $this->db->query("Select * From supplier Order By nama_supplier");
        return $data;
    }
    
    function get_contact_name($id){
        $data = $this->db->query("Select * From supplier Where id=".$id);
        return $data;
    }
    
    function load_detail_pp($id){
        $data = $this->db->query("Select bsd.*, part.nama_item, part.uom From beli_sparepart_detail bsd 
                Left Join sparepart part On(bsd.sparepart_id = part.id) 
                Where bsd.beli_sparepart_id=".$id." And bsd.flag_po=0");
        return $data;
    }
    
    function po_list(){
        $data = $this->db->query("Select po.*, 
                    bsp.no_pengajuan, bsp.tgl_pengajuan,
                    usr.realname As created_name,
                    spl.nama_supplier,
                (Select count(id)As jumlah_item From po_detail pd Where pd.po_id = po.id)As jumlah_item,
                (Select Count(pd.id)As ready_to_lpb From po_detail pd Where 
                    pd.po_id = po.id And pd.flag_lpb=0)As ready_to_lpb
                From po 
                    Left Join beli_sparepart bsp On (po.beli_sparepart_id = bsp.id) 
                    Left Join supplier spl On (po.supplier_id = spl.id) 
                    Left Join users usr On (bsp.created_by = usr.id) 
                Where po.jenis_po='Sparepart' 
                Order By po.id Desc");
        return $data;
    }

    function po_list_outdated(){
        $data = $this->db->query("Select po.*, 
                    bsp.no_pengajuan, bsp.tgl_pengajuan,
                    usr.realname As created_name,
                    spl.nama_supplier,
                (Select count(id)As jumlah_item From po_detail pd Where pd.po_id = po.id)As jumlah_item,
                (Select Count(pd.id)As ready_to_lpb From po_detail pd Where 
                    pd.po_id = po.id And pd.flag_lpb=0)As ready_to_lpb
                From po 
                    Left Join beli_sparepart bsp On (po.beli_sparepart_id = bsp.id) 
                    Left Join supplier spl On (po.supplier_id = spl.id) 
                    Left Join users usr On (bsp.created_by = usr.id) 
                Where po.jenis_po='Sparepart' and po.tanggal < DATE_ADD(NOW(), INTERVAL -5 DAY)
                Order By po.id Desc");
        return $data;
    }
    
    function show_header_po($id){
        $data = $this->db->query("Select po.*, bsp.no_pengajuan, bsp.tgl_pengajuan, bsp.approved,
                    spl.nama_supplier, spl.pic,
                    usr.realname As approved_name,
                    crt.realname As pemohon
                    From po 
                        Left Join beli_sparepart bsp On (po.beli_sparepart_id = bsp.id) 
                        Left Join supplier spl On (po.supplier_id = spl.id) 
                        Left Join users usr On (bsp.approved_by = usr.id) 
                        Left Join users crt On (bsp.created_by = crt.id)
                    Where po.id=".$id);
        return $data;
    }
    
    function show_detail_po($id){
        $data = $this->db->query("Select pod.*, spr.nama_item, spr.uom
                    From po_detail pod 
                        Left Join sparepart spr On (pod.sparepart_id = spr.id) 
                    Where pod.po_id=".$id);
        return $data;
    }

    function show_detail_po_create_lpb($id){
        $data = $this->db->query("Select pod.*, spr.nama_item, spr.uom
                    From po_detail pod 
                        Left Join sparepart spr On (pod.sparepart_id = spr.id) 
                    Where pod.po_id=".$id." and pod.flag_lpb=0");
        return $data;
    }

    function show_cek_qty($id){
        /*$data = $this->db->query("Select pd.* from lpb_detail ld
                    left join po_detail pd on pd.id = ld.po_detail_id
                    where pd.po_id =".$id);*/
        $data = $this->db->query("select ld.*, sum(ld.qty) as total from lpb_detail ld 
            left join po_detail pd on pd.id = ld.po_detail_id 
            where ld.po_detail_id =".$id);
        return $data;
    }
    
    function bpb_list(){
        $data = $this->db->query("Select lpb.*, 
                    po.no_po, 
                    spl.nama_supplier,
                    usr.realname As penerima,
                (Select count(lpbd.id)As jumlah_item From lpb_detail lpbd Where lpbd.lpb_id = lpb.id)As jumlah_item
                From lpb 
                    Left Join po On (lpb.po_id = po.id) 
                    Left Join supplier spl On (po.supplier_id = spl.id) 
                    Left Join users usr On (lpb.created_by = usr.id) 
                Order By lpb.id Desc");
        return $data;
    }
    
    function show_header_bpb($id){
        $data = $this->db->query("Select lpb.*, 
                    po.no_po,
                    spl.nama_supplier,
                    usr.realname As penerima
                    From lpb
                        Left Join po On (lpb.po_id = po.id)
                        Left Join supplier spl On (po.supplier_id = spl.id) 
                        Left Join users usr On (lpb.created_by = usr.id) 
                    Where lpb.id=".$id);
        return $data;
    }
    
    function show_detail_bpb($id){
        $data = $this->db->query("Select lpbd.*, spr.nama_item, spr.uom
                    From lpb_detail lpbd 
                        Left Join sparepart spr On (lpbd.sparepart_id = spr.id) 
                    Where lpbd.lpb_id=".$id);
        return $data;
    }
    
    function get_data_pembayaran($id){
        $data = $this->db->query("Select po.*,
                    supplier.nama_supplier,
                    (Select Sum(po_detail.total_amount) From po_detail Where po_detail.po_id = po.id)As nilai_po,
                    (Select Sum(voucher.amount) From voucher Where voucher.po_id = po.id And jenis_voucher='Parsial')As jumlah_dibayar
                From po
                    Left Join supplier On (po.supplier_id = supplier.id)
                Where po.id=".$id);
        return $data;
    }
    
    function voucher_list(){
        $data = $this->db->query("Select voucher.*, 
                po.no_po, po.tanggal As tanggal_po
                From voucher 
                    Left Join po On (voucher.po_id = po.id) 
                Where voucher.jenis_barang='SPARE PART'
                Order By voucher.no_voucher");
        return $data;
    }

    function spb_list(){
        $data = $this->db->query("Select tss.*,
                    usr.realname As pic,
                    aprv.realname As approved_name,
                    rjt.realname As rejected_name,
                    rcv.realname As receiver_name,
                (Select count(tssd.id)As jumlah_item From t_spb_sparepart_detail tssd Where tssd.t_spb_sparepart_id = tss.id)As jumlah_item
                From t_spb_sparepart tss
                    Left Join users usr On (tss.created_by = usr.id)
                    Left Join users aprv On (tss.approved_by = aprv.id)
                    Left Join users rjt On (tss.rejected_by = rjt.id)
                    Left join users rcv on (tss.received_by = rcv.id) 
                Order By tss.id Desc");
        return $data;
    }

    function show_header_spb($id){
        $data = $this->db->query("Select tss.*, 
                    usr.realname As pic,
                    appr.realname As approved_name,
                    rjct.realname As reject_name
                    From t_spb_sparepart tss
                        Left Join users usr On (tss.created_by = usr.id) 
                        Left Join users appr On (tss.approved_by = appr.id)
                        Left Join users rjct On (tss.rejected_by = rjct.id)
                    Where tss.id=".$id);
        return $data;
    }

    function show_detail_spb($id){
        $data = $this->db->query("Select tssd.*, ti.nama_produk,
                    (select total_bruto_masuk from stok_sparepart ss where ss.id= tssd.jenis_inventory_id)as total_bruto_masuk,
                    (select total_netto_masuk from stok_sparepart ss where ss.id= tssd.jenis_inventory_id)as total_netto_masuk,
                    (select total_bruto_keluar from stok_sparepart ss where ss.id= tssd.jenis_inventory_id)as total_bruto_keluar,
                    (select total_netto_keluar from stok_sparepart ss where ss.id= tssd.jenis_inventory_id)as total_netto_keluar,
                    (select stok_bruto from stok_sparepart ss where ss.id= tssd.jenis_inventory_id) as stok_bruto,
                    (select stok_netto from stok_sparepart ss where ss.id= tssd.jenis_inventory_id) as stok_netto
                    From t_spb_sparepart_detail tssd 
                        Left Join t_inventory ti On (ti.id = tssd.jenis_inventory_id)
                    Where tssd.t_spb_sparepart_id=".$id);
        return $data;
    }

    function show_detail_spb_fulfilment($id){
        $data = $this->db->query("select tsdk.*, ti.nama_produk from t_spb_sparepart_detail_keluar tsdk left join t_inventory ti on ti.id = tsdk.jenis_inventory_id
            where tsdk.t_spb_sparepart_id = ".$id);
        return $data;
    }

    function jenis_barang_spb(){
        $data = $this->db->query("select * from t_inventory where jenis_item = 'SPARE PART'"
                );
        return $data;
    }

    function load_detail_spb($id){
        $data = $this->db->query("Select tssd.*, ti.nama_produk
                From t_spb_sparepart_detail tssd 
                Left Join t_inventory ti On(ti.id = tssd.jenis_inventory_id) 
                Where tssd.t_spb_sparepart_id=".$id);
        return $data;
    }

    function show_data_barang($id){
        $data = $this->db->query("select sp.uom
                from sparepart sp 
                where sp.nama_item = '".$id."'"
                );
        return $data;
    }

    function jenis_barang_list_by_spb($id){
        $data = $this->db->query("select ti.id, ti.nama_produk
                from t_spb_sparepart_detail tssd
                left join t_inventory ti on (ti.id = tssd.jenis_inventory_id )
                where t_spb_sparepart_id =".$id
                );
        return $data;
    }

    function show_data_barang_spb($id){
        $data = $this->db->query("select jb.uom,tswd.id
                from t_spb_wip_detail tswd
                left join jenis_barang jb on (jb.id = tswd.jenis_barang_id)
                where tswd.jenis_barang_id = ".$id
                );
        return $data;
    }

    function load_detail_saved_item($id){
        $data = $this->db->query("select tsdk.*, ti.nama_produk from t_spb_sparepart_detail_keluar tsdk
            left join t_inventory ti on ti.id = tsdk.jenis_inventory_id
            where t_spb_sparepart_id =".$id);
        return $data;
    }

    function get_stok($iv_id){
        $data = $this->db->query("select * from t_inventory where id =".$iv_id);
        return $data;
    }

    function show_laporan(){
        $data = $this->db->query("select DATE_FORMAT(tid.tanggal,'%M %Y') as showdate, 
            EXTRACT(YEAR_MONTH from tid.tanggal) as tanggal, 
            count(tid.t_inventory_id) as jumlah, 
            sum(tid.bruto_masuk) as bruto_masuk, 
            sum(tid.netto_masuk) as netto_masuk, 
            sum(tid.bruto_keluar) as bruto_keluar, 
            sum(tid.netto_keluar) as netto_keluar from t_inventory_detail tid
            left join t_inventory ti on ti.id = tid.t_inventory_id 
            where ti.jenis_item = 'SPARE PART'
            group by month(tanggal)");
        return $data;
    }

    function show_laporan_after($tahun,$bulan){
        $data = $this->db->query("select count(tid.t_inventory_id) as jumlah, 
            sum(tid.bruto_masuk) as bruto_masuk, 
            sum(tid.netto_masuk) as netto_masuk, 
            sum(tid.bruto_keluar) as bruto_keluar, 
            sum(tid.netto_keluar) as netto_keluar from t_inventory_detail tid
            left join t_inventory ti on ti.id = tid.t_inventory_id 
            where ti.jenis_item = 'SPARE PART' and tid.tanggal < '".$tahun."-".$bulan."-01'");
        return $data;
    }

    function show_view_laporan($bulan, $tahun){
        $data = $this->db->query("select ti.id, ti.nama_produk, DATE_FORMAT(tid.tanggal,'%M %Y') as showdate, 
            EXTRACT(YEAR_MONTH from tid.tanggal) as tanggal,
            count(tid.t_inventory_id) as jumlah, 
            sum(tid.bruto_masuk) as bruto_masuk, 
            sum(tid.netto_masuk) as netto_masuk, 
            sum(tid.bruto_keluar) as bruto_keluar, 
            sum(tid.netto_keluar) as netto_keluar from t_inventory_detail tid
            left join t_inventory ti on ti.id = tid.t_inventory_id 
            where ti.jenis_item = 'SPARE PART' and month(tid.tanggal) =".$bulan." and year(tid.tanggal) =".$tahun."
            group by ti.id");
        return $data;
    }

    function show_laporan_detail($bulan,$tahun,$id_barang){
        $data = $this->db->query("select tid.*, ti.nama_produk from t_inventory_detail tid
            left join t_inventory ti on ti.id = tid.t_inventory_id 
            where ti.jenis_item = 'SPARE PART' and 
            month(tid.tanggal) =".$bulan." and year(tid.tanggal) =".$tahun." and ti.id =".$id_barang."
            order by tid.tanggal asc");
        return $data;
    }
}

    /*
    cara membuat view stok sparepart
    CREATE OR REPLACE VIEW stok_sparepart (id, nama_produk, total_bruto_masuk, total_netto_masuk, total_bruto_keluar, total_netto_keluar) 
    AS SELECT ti.id, ti.nama_produk, 
    SUM(tid.bruto_masuk),
    SUM(tid.netto_masuk),
    SUM(tid.bruto_keluar), 
    SUM(tid.netto_keluar)
    from t_inventory ti
    LEFT join t_inventory_detail tid on (tid.t_inventory_id = ti.id)
    WHERE ti.jenis_item = "SPARE PART"
    GROUP BY ti.id
    */