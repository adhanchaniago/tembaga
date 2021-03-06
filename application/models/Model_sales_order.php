<?php
class Model_sales_order extends CI_Model{
    function so_list($ppn){
        $data = $this->db->query("Select tso.*, so.no_sales_order, so.tanggal, so.m_customer_id, so.marketing_id, so.flag_ppn, so.flag_sj, so.flag_invoice, usr.realname As nama_marketing, cust.nama_customer, cust.pic, COALESCE(tsf.status,tsw.status,spb.status,tsa.status,1) as status_spb,
            (Select count(fi.id) from f_invoice fi where fi.id_sales_order = so.id) as invoice,
            (Select count(tsod.id)As jumlah_item From t_sales_order_detail tsod Where tsod.t_so_id = tso.id)As jumlah_item From t_sales_order tso
            Left Join sales_order so on (so.id = tso.so_id)
            Left Join m_customers cust On (so.m_customer_id = cust.id) 
            Left Join t_spb_fg tsf on (tso.jenis_barang='FG') and (tsf.id=tso.no_spb)
            Left Join t_spb_wip tsw on (tso.jenis_barang='WIP') and (tsw.id=tso.no_spb)
            Left Join spb on (tso.jenis_barang='RONGSOK') and (spb.id=tso.no_spb)
            Left Join t_spb_ampas tsa on (tso.jenis_barang='AMPAS') and (tsa.id=tso.no_spb)
            Left Join users usr On (so.marketing_id = usr.id)
            Where so.flag_tolling = 0 and so.flag_ppn =".$ppn."
            Order by so.id desc");
        return $data;
    }

    function filter_so_list($id){
        $data = $this->db->query("Select tso.*, so.no_sales_order, so.tanggal, so.m_customer_id, so.marketing_id, so.flag_ppn, so.flag_sj, so.flag_invoice, usr.realname As nama_marketing, cust.nama_customer, cust.pic, COALESCE(tsf.status,tsw.status,spb.status) as status_spb,
            (Select count(fi.id) from f_invoice fi where fi.id_sales_order = so.id) as invoice,
            (Select count(tsod.id)As jumlah_item From t_sales_order_detail tsod Where tsod.t_so_id = tso.id)As jumlah_item From t_sales_order tso
            Left Join sales_order so on (so.id = tso.so_id)
            Left Join m_customers cust On (so.m_customer_id = cust.id) 
            Left Join t_spb_fg tsf on (tso.jenis_barang='FG') and (tsf.id=tso.no_spb)
            Left Join t_spb_wip tsw on (tso.jenis_barang='WIP') and (tsw.id=tso.no_spb)
            Left Join spb on (tso.jenis_barang='RONGSOK') and (spb.id=tso.no_spb)
            Left Join users usr On (so.marketing_id = usr.id)
            Where so.flag_sj = ".$id." Order by so.id desc");
        return $data;
    }

    function customer_list(){
        $data = $this->db->query("Select * From m_customers Order By nama_customer");
        return $data;
    }
    
    function marketing_list(){
        $data = $this->db->query("Select * From users Order By realname");
        return $data;
    }
    
    function get_contact_name($id){
        $data = $this->db->query("Select * From m_customers Where id=".$id);
        return $data;
    }

    function load_detail($id){
        $data = $this->db->query("Select sod.*, jb.jenis_barang, jb.category, jb.uom From sales_order_detail sod 
                Left Join jenis_barang jb On(jb.id = sod.id) 
                Where sod.sales_order_id=".$id);
        return $data;
    }

    function show_header_so($id){
        $data = $this->db->query("Select tso.*, so.no_sales_order, so.tanggal, so.m_customer_id, so.marketing_id, so.flag_invoice, so.flag_sj, so.keterangan, u.realname, cust.nama_customer, cust.pic, cust.alamat, cust.telepon, cust.nama_customer_kh, cust.pic_kh, cust.alamat_kh, cust.telepon_kh, COALESCE(tsf.no_spb, tsw.no_spb_wip, spb.no_spb,tsa.no_spb_ampas) as no_spb_barang, COALESCE(tsf.status,tsw.status,spb.status,0) as status_spb
                    From t_sales_order tso
                        Left join sales_order so on (so.id = tso.so_id)
                        Left join m_customers cust On (so.m_customer_id = cust.id)
                        Left join t_spb_fg tsf on tso.jenis_barang = 'FG' and tsf.id = tso.no_spb
                        Left join t_spb_wip tsw on tso.jenis_barang = 'WIP' and tsw.id = tso.no_spb
                        Left join spb on tso.jenis_barang = 'RONGSOK' and spb.id = tso.no_spb
                        Left join t_spb_ampas tsa on tso.jenis_barang = 'AMPAS' and tso.no_spb
                        Left join users u on u.id = so.marketing_id
                    Where tso.id=".$id);
        return $data;
    }
    
    function show_detail_so($id){
        $data = $this->db->query("Select tsod.*, jb.jenis_barang, jb.uom, jb.kode
                    From t_sales_order_detail tsod 
                        Left Join jenis_barang jb On (tsod.jenis_barang_id = jb.id) 
                    Where tsod.t_so_id=".$id);
        return $data;
    }

    function show_detail_so_rsk($id){
        $data = $this->db->query("Select tsod.*, COALESCE(NULLIF(nama_barang_alias,''),r.nama_item) as jenis_barang, r.kode_rongsok as kode, r.uom
                    From t_sales_order_detail tsod 
                        Left Join rongsok r On (tsod.jenis_barang_id = r.id) 
                    Where tsod.t_so_id=".$id);
        return $data;
    }

    function show_detail_so_sp($id){
        $data = $this->db->query("Select tsod.*, s.nama_item as jenis_barang, s.alias as kode, s.uom
                    From t_sales_order_detail tsod
                        Left Join sparepart s On (tsod.jenis_barang_id = s.id)
                    Where tsod.t_so_id=".$id);
        return $data;
    }

    function load_detail_view_sj($id){
        $data = $this->db->query("select tsjd.*, jb.jenis_barang, jb.uom, jb.kode
                from t_surat_jalan_detail tsjd
                left join t_surat_jalan tsj on tsj.id= tsjd.t_sj_id
                left join t_sales_order tso on tso.so_id = tsj.sales_order_id
                left join jenis_barang jb on jb.id = tsjd.jenis_barang_id
                where tso.id =".$id);
        return $data;
    }

    function load_detail_view_sj_rsk($id){
        $data = $this->db->query("select tsjd.*, r.nama_item as jenis_barang, r.uom, r.kode_rongsok as kode
                from t_surat_jalan_detail tsjd
                left join t_surat_jalan tsj on tsj.id= tsjd.t_sj_id
                left join t_sales_order tso on tso.so_id = tsj.sales_order_id
                left join rongsok r on r.id = tsjd.jenis_barang_id
                where tso.id =".$id);
        return $data;
    }

    function load_detail_view_sj_sp($id){
        $data = $this->db->query("Select tsjd.*, s.nama_item as jenis_barang, s.uom, s.alias as kode
                from t_surat_jalan_detail tsjd
                left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id
                left join t_sales_order tso on tso.so_id = tsj.sales_order_id
                left join sparepart s on s.id = tsjd.jenis_barang_id
                where tso.id =".$id);
        return $data;
    }
    // function show_view_sj($id){
    //     $data = $this->db->query("select tsj.* from t_surat_jalan tsj
    //                 left join t_sales_order tso on tso.so_id = tsj.sales_order_id
    //                 where tso.id = ".$id);
    //     return $data;
    // }

    function jenis_barang_list(){
        $data = $this->db->query("Select category From jenis_barang where category <> '' group by category");
        return $data;
    }
    
    function type_kendaraan_list(){
        $data = $this->db->query("select *from m_type_kendaraan order by type_kendaraan");
        return $data;
    }
    function kendaraan_list(){
        $data = $this->db->query("Select * From m_kendaraan Order By no_kendaraan");
        return $data;
    }
    
    function get_type_kendaraan($id){
        $data = $this->db->query("Select kdr.*, tkdr.type_kendaraan From m_kendaraan kdr 
                    Left Join m_type_kendaraan tkdr On (kdr.m_type_kendaraan_id = tkdr.id) 
                    Where kdr.id=".$id);
        return $data;
    }
    
    function get_alamat($id){
        $data = $this->db->query("Select * From m_customers Where id=".$id);
        return $data;
    }
    
    function get_so_list($id, $user_ppn){
        $data = $this->db->query("Select so.id, so.no_sales_order From sales_order so
                left join t_sales_order tso on tso.so_id = so.id
                left join t_spb_fg tsf on tso.jenis_barang = 'FG' and tsf.id = tso.no_spb
                left join t_spb_wip tsw on tso.jenis_barang = 'wip' and tsw.id = tso.no_spb
                left join spb s on tso.jenis_barang = 'RONGSOK' and s.id = tso.no_spb
                Left join t_spb_ampas tsa on tso.jenis_barang = 'AMPAS' and tso.no_spb
                Where so.m_customer_id=".$id." and so.flag_tolling = 0 and so.flag_sj = 0 and COALESCE(tsf.status,tsw.status,s.status,tsa.status,1) not in (0,3) and so.flag_ppn = ".$user_ppn);
        return $data;
    }

    function get_jenis_barang($id){
        $data = $this->db->query("Select jenis_barang from t_sales_order where so_id=".$id);
        return $data;
    }

    // function list_item_sj_fg($soid){
    //     $data = $this->db->query("select tgf.id, tgf.no_packing, jb.jenis_barang, jb.uom, jb.ukuran from t_sales_order tso
    //             left join t_gudang_fg tgf on tgf.t_spb_fg_id = tso.no_spb
    //             left join jenis_barang jb on jb.id = tgf.jenis_barang_id
    //             where tso.so_id = ".$soid." and flag_taken = 0");
    //     return $data;
    // }

    function list_item_sj_fg($soid){
        $data = $this->db->query("select tgf.*, jb.jenis_barang, jb.kode, jb.uom, jb.ukuran from t_sales_order tso
                left join t_gudang_fg tgf on tgf.t_spb_fg_id = tso.no_spb
                left join jenis_barang jb on jb.id = tgf.jenis_barang_id
                where tso.so_id = ".$soid." and jenis_trx = 1 and flag_taken = 0 order by tgf.jenis_barang_id");
        return $data;
    }

    function list_item_sj_fg_detail($id){
        $data = $this->db->query("select tgf.*, jb.jenis_barang, jb.kode, jb.uom from sales_order so
                left join t_sales_order tso on tso.so_id = so.id
                left join t_gudang_fg tgf on tgf.t_spb_fg_id = tso.no_spb
                left join jenis_barang jb on jb.id = tgf.jenis_barang_id
                where tgf.id=".$id);
        return $data;
    }

    function jenis_barang_fg(){
        $data = $this->db->query("select id, jenis_barang, kode from jenis_barang 
                where category ='FG'");
        return $data;
    }

    function list_item_sj_wip($soid){
        $data = $this->db->query("select tgw.*, jb.jenis_barang, jb.kode, jb.uom  from sales_order so
                left join t_sales_order tso on tso.so_id = so.id
                left join t_spb_wip_detail tswd on tswd.t_spb_wip_id = tso.no_spb
                left join t_gudang_wip tgw on tgw.t_spb_wip_detail_id = tswd.id
                left join jenis_barang jb on jb.id = tswd.jenis_barang_id
                where so.id = ".$soid." and tgw.flag_taken = 0");
        return $data;
    }

    function list_item_sj_wip_detail($id){
        $data = $this->db->query("select tgw.*, jb.jenis_barang, jb.kode, jb.uom from t_gudang_wip tgw
                left join jenis_barang jb on jb.id = tgw.jenis_barang_id
                where tgw.id=".$id);
        return $data;
    }

    function jenis_barang_wip(){
        $data = $this->db->query("select id, jenis_barang, kode from jenis_barang 
                where category ='WIP'");
        return $data;
    }

    function list_item_sj_rsk($soid){
        $data = $this->db->query("select dd.*, r.nama_item as jenis_barang, r.kode_rongsok as kode
            from sales_order so 
            left join t_sales_order tso on tso.so_id = so.id 
            left join spb_detail_fulfilment sdf on sdf.spb_id = tso.no_spb 
            left join dtr_detail dd on dd.id = sdf.dtr_detail_id 
            left join rongsok r on r.id = dd.rongsok_id 
            where so.id =".$soid." and dd.so_id=0");
        return $data;
    }
    
    function list_item_sj_rsk_detail($id){
        $data = $this->db->query("select dd.*, r.nama_item as jenis_barang, r.uom
            from dtr_detail dd left join rongsok r on r.id = dd.rongsok_id 
            where dd.id =".$id);
        return $data;
    }

    function list_item_sj_lain($soid){
        $data = $this->db->query("select tsod.*, s.nama_item as jenis_barang, s.uom from t_sales_order_detail tsod
            left join t_sales_order tso on tso.id = tsod.t_so_id
            left join sparepart s on s.id = tsod.jenis_barang_id
            where tso.so_id=".$soid);
        return $data;
    }

    function list_item_sj_ampas($soid){
        $data = $this->db->query("select tsa.*, r.nama_item as jenis_barang, r.uom from t_sales_order tso
            left join t_spb_ampas_fulfilment tsa on tsa.t_spb_ampas_id = tso.no_spb
            left join rongsok r on r.id = tsa.jenis_barang_id
            where tso.so_id=".$soid." and tsa.flag_taken = 0");
        return $data;
    }

    function jenis_barang_rsk(){
        $data = $this->db->query("select id, kode_rongsok, nama_item from rongsok 
                where type_barang ='Rongsok'");
        return $data;
    }

    function load_detail_only($id){
        $data = $this->db->query("select tsod.*, COALESCE(jb.uom, jb2.uom, jb3.uom, r.uom, r2.uom) as uom from t_sales_order_detail tsod
            left join t_sales_order tso on tso.id = tsod.t_so_id
            left join jenis_barang jb on tso.jenis_barang = 'FG' and jb.id = tsod.jenis_barang_id
            left join jenis_barang jb2 on tso.jenis_barang = 'WIP' and jb2.id = tsod.jenis_barang_id
            left join sparepart jb3 on tso.jenis_barang = 'LAIN' and jb3.id = tsod.jenis_barang_id
            left join rongsok r on  tso.jenis_barang = 'RONGSOK' and r.id = tsod.jenis_barang_id
            left join rongsok r2 on  tso.jenis_barang = 'AMPAS' and r2.id = tsod.jenis_barang_id
            where t_so_id =".$id);
        return $data;
    }

    // function load_detail_only($id){
    //     $data = $this->db->query("select * from t_sales_order_detail tsod
    //         left join t_sales_order tso on tso.id =  tsod.t_so_id
    //         left join t_spb_fg_detail tsfd on tso.jenis_barang = 'FG' and tsfd.id = tsod.no_spb_detail
    //         left join t_spb_wip_detail tswd on tso.jenis_barang = 'WIP' and tswd.id = tsod.no_spb_detail
    //         left join t_spb_ampas_detail tsad on tso.jenis_barang = 'AMPAS' and tsad.id = tsod.no_spb_detail
    //         left join spb on tso.jenis_barang = 'RONGSOK' and spb.id = tsod.no_spb_detail
    //         where t_so_id =".$id);
    //     return $data;
    // }

    function spb_fg_detail_only($id){
        $data = $this->db->query("select * from t_spb_fg_detail where t_spb_fg_id =".$id);
        return $data;
    }

    function spb_wip_detail_only($id){
        $data = $this->db->query("select * from t_spb_wip_detail where t_spb_wip_id =".$id);
        return $data;
    }

    function spb_ampas_detail_only($id){
        $data = $this->db->query("select * from t_spb_ampas_detail where t_spb_ampas_id =".$id);
        return $data;
    }

    function spb_rsk_detail_only($id){
        $data = $this->db->query("select * from spb_detail where spb_id =".$id);
        return $data;
    }

    function load_detail_so($id){
        $data = $this->db->query("Select tsod.*, jb.jenis_barang as nama_barang, jb.category, jb.uom, jb.kode From t_sales_order_detail tsod 
                Left Join jenis_barang jb On(jb.id = tsod.jenis_barang_id) 
                Where tsod.t_so_id= ".$id);
        return $data;
    }

    function load_detail_so_rongsok($id){
        $data = $this->db->query("Select tsod.*, rsk.nama_item as nama_barang, rsk.type_barang, rsk.uom, rsk.kode_rongsok as kode From t_sales_order_detail tsod 
                Left Join rongsok rsk On(rsk.id = tsod.jenis_barang_id) 
                Where tsod.t_so_id= ".$id);
        return $data;
    }

    function load_detail_so_sp($id){
        $data = $this->db->query("Select tsod.*, s.nama_item as nama_barang, s.uom, s.alias as kode from t_sales_order_detail tsod
                Left join sparepart s On(s.id = tsod.jenis_barang_id)
                Where tsod.t_so_id= ".$id);
        return $data;
    }

    function show_data($id){
        $data = $this->db->query("Select uom From jenis_barang Where id=".$id);        
        return $data;
    }

    function get_uom_so($id){
        $data = $this->db->query("Select uom From rongsok Where id=".$id);        
        return $data;
    }

    function get_uom_sp($id){
        $data = $this->db->query("Select uom From sparepart Where id=".$id);
        return $data;
    }
    
    function list_barang_so($jenis){
        $data = $this->db->query("Select id, jenis_barang, kode, uom from jenis_barang where category = '".$jenis."'");
        return $data;
    }

    function list_barang_sp(){
        $data = $this->db->query("Select id, nama_item as jenis_barang, alias as kode, uom from sparepart order by nama_item asc");
        return $data;
    }

    function list_barang_so_rongsok(){
        $data = $this->db->query("Select id, nama_item as jenis_barang, kode_rongsok as kode, uom from rongsok where type_barang = 'Rongsok'");
        return $data;
    }

    function get_no_spb($id){
        $data = $this->db->query("select no_spb_detail from t_sales_order_detail where id=".$id);
        return $data;
    }

    function spb_list($user_ppn,$s,$e){
        $data = $this->db->query("select tso.*, mc.nama_customer, so.no_sales_order, so.tanggal, coalesce(tsf.no_spb, tsw.no_spb_wip, spb.no_spb) as no_spb_detail , 
            coalesce(tsf.status, tsw.status, spb.status) as status, coalesce(tsf.keterangan, tsw.keterangan, spb.remarks) as keterangan,
            (Select count(tsod.id)As jumlah_item From t_sales_order_detail tsod Where tsod.t_so_id = tso.id)As jumlah_item from t_sales_order tso 
            left join sales_order so on so.id = tso.so_id
            left join t_spb_fg tsf on tso.jenis_barang='FG' and tsf.id = tso.no_spb
            left join t_spb_wip tsw on tso.jenis_barang='WIP' and tsw.id = tso.no_spb
            left join spb on tso.jenis_barang='RONGSOK' and spb.id = tso.no_spb
            left join m_customers mc on mc.id = so.m_customer_id
            Where so.flag_tolling = 0 and so.tanggal between '".$s."' and '".$e."' And so.flag_ppn = ".$user_ppn." And tso.no_spb > 0
            order by so.no_sales_order desc");
        return $data;
    }

    function show_view_header_so($id){
        $data = $this->db->query("select tso.*, so.no_sales_order, so.tanggal,
            usr.realname As nama_marketing, 
            cust.nama_customer, cust.pic, 
            coalesce(tsf.no_spb, tsw.no_spb_wip, spb.no_spb) as no_spb_detail, 
            coalesce(tsf.status, tsw.status, spb.status) as status, 
            coalesce(tsf.keterangan, tsw.keterangan, spb.remarks) as keterangan, 
            coalesce(tsf.reject_remarks, tsw.reject_remarks, spb.reject_remarks) as reject_remarks,
            (Select count(tsod.id)As jumlah_item From t_sales_order_detail tsod Where tsod.t_so_id = tso.id)As jumlah_item from t_sales_order tso 
            left join sales_order so on so.id = tso.so_id
            left join t_spb_fg tsf on tso.jenis_barang='FG' and tsf.id = tso.no_spb
            left join t_spb_wip tsw on tso.jenis_barang='WIP' and tsw.id = tso.no_spb
            left join spb on tso.jenis_barang='RONGSOK' and spb.id= tso.no_spb
            Left Join m_customers cust On (so.m_customer_id = cust.id) 
            Left Join users usr On (so.marketing_id = usr.id)
            where tso.id =".$id);
        return $data;
    }

    function show_view_detail_so($id){
        $data = $this->db->query("select tsod.*, jb.jenis_barang as nama_barang, jb.uom from t_sales_order_detail tsod
            left join jenis_barang jb on jb.id = tsod.jenis_barang_id
            where tsod.t_so_id =".$id);
        return $data;
    }

    function show_view_detail_so_rsk($id){
        $data = $this->db->query("select tsod.*, rsk.nama_item as nama_barang, rsk.uom from t_sales_order_detail tsod
            left join rongsok rsk on rsk.id = tsod.jenis_barang_id
            where tsod.t_so_id =".$id);
        return $data;
    }

    function show_detail_spb_fulfilment_fg($id){
        $data = $this->db->query("select  jb.jenis_barang as nama_barang,jb.uom,jb.kode, 
            COALESCE(tsj.no_surat_jalan,'Belum ada SJ') as no_surat_jalan, COALESCE(tsj.tanggal, '-') as tgl_sj,
        tgf.no_packing, tgf.bruto, tgf.netto as berat, 1 as qty, '' as uom, tgf.keterangan, tgf.flag_taken
        from t_sales_order tso
        left join t_gudang_fg tgf on tso.jenis_barang = 'FG' and tgf.t_spb_fg_id = tso.no_spb
        left join t_surat_jalan tsj on tgf.t_sj_id = tsj.id
        left join jenis_barang jb on jb.id = tgf.jenis_barang_id
        where tso.id =".$id." order by t_sj_id");
        return $data;
    }

    // function show_detail_spb_fulfilment_wip($id){
    //     $data = $this->db->query("select  jb.jenis_barang as nama_barang,jb.uom,jb.kode,
    //     0 as no_packing, 0 as bruto, tgw.berat, 1 as qty, tgw.uom as uom, tgw.keterangan, tgw.flag_taken,
    //         COALESCE(tsj.no_surat_jalan,'Belum ada SJ') as no_surat_jalan, COALESCE(tsj.tanggal, '-') as tgl_sj,
    //     from t_sales_order tso
    //     left join t_gudang_wip tgw on tso.jenis_barang = 'WIP' and tgw.t_spb_wip_id = tso.no_spb
    //     left join jenis_barang jb on jb.id = tgw.jenis_barang_id
    //     where tso.id =".$id);
    //     return $data;
    // }

    function show_detail_spb_fulfilment($id){
        $data = $this->db->query("select  jb.jenis_barang as nama_barang,jb.uom,jb.kode,
        coalesce(tgf.no_packing, 0) as no_packing,
        coalesce(tgf.bruto, 0) as bruto,
        coalesce(tgf.netto, tgw.berat) as berat,
        coalesce(tgw.qty, 1) as qty,
        coalesce(tgw.uom, NULL) as uom,
        coalesce(tgf.keterangan, tgw.keterangan) as keterangan,
        coalesce(tgf.flag_taken, tgw.flag_taken) as flag_taken
        from t_sales_order tso
        left join t_gudang_fg tgf on tso.jenis_barang = 'FG' and tgf.t_spb_fg_id = tso.no_spb
        left join t_gudang_wip tgw on tso.jenis_barang = 'WIP' and tgw.t_spb_wip_id = tso.no_spb
        left join jenis_barang jb on jb.id = (case when tso.jenis_barang='FG' then tgf.jenis_barang_id else tgw.jenis_barang_id end)
        where tso.id =".$id);
        return $data;
    }

    function total_so($id){
        $data = $this->db->query("select jb.jenis_barang as nama_barang, sum(coalesce(tgf.netto, tgw.berat)) as netto
        from t_sales_order tso
        left join t_gudang_fg tgf on tso.jenis_barang = 'FG' and tgf.t_spb_fg_id = tso.no_spb
        left join t_gudang_wip tgw on tso.jenis_barang = 'WIP' and tgw.t_spb_wip_id = tso.no_spb
        left join jenis_barang jb on jb.id = (case when tso.jenis_barang='FG' then tgf.jenis_barang_id else tgw.jenis_barang_id end)
        where tso.id =".$id." group by jb.id");
        return $data;
    }

    function show_detail_spb_fulfilment_rsk($id){
        $data = $this->db->query("Select rsk.nama_item as nama_barang, rsk.uom, rsk.kode_rongsok as kode, dtrd.no_pallete as no_packing,dtrd.bruto, dtrd.netto as berat, dtrd.qty, dtrd.line_remarks as keterangan, dtrd.so_id, dtrd.flag_taken
            From spb_detail_fulfilment spdf 
            Left Join dtr_detail dtrd on (dtrd.id = spdf.dtr_detail_id) 
            Left Join rongsok rsk On (dtrd.rongsok_id = rsk.id)
            Left Join t_sales_order tso on (tso.no_spb = spdf.spb_id)
            Where tso.id=".$id);
        return $data;
    }

    function total_so_rsk($id){
        return $this->db->query("Select rsk.nama_item as nama_barang, sum(dtrd.netto) as netto From spb_detail_fulfilment spdf 
            Left Join dtr_detail dtrd on (dtrd.id = spdf.dtr_detail_id) 
            Left Join rongsok rsk On (dtrd.rongsok_id = rsk.id)
            Left Join t_sales_order tso on (tso.no_spb = spdf.spb_id)
            Where tso.id=".$id." group by dtrd.rongsok_id");
    }

    function show_detail_spb_fulfilment_rsk2($id){
        $data = $this->db->query("Select rsk.nama_item as nama_barang, rsk.uom, rsk.kode_rongsok as kode, dtrd.no_pallete as no_packing,dtrd.bruto, dtrd.netto as berat, dtrd.qty, dtrd.line_remarks as keterangan, dtrd.so_id, dtrd.flag_taken,
            COALESCE(tsj.no_surat_jalan,'Belum ada SJ') as no_surat_jalan, COALESCE(tsj.tanggal, '-') as tgl_sj
            From spb_detail_fulfilment spdf 
            Left Join dtr_detail dtrd on (dtrd.id = spdf.dtr_detail_id) 
            Left Join rongsok rsk On (dtrd.rongsok_id = rsk.id)
            Left Join t_sales_order tso on (tso.no_spb = spdf.spb_id)
            Left Join t_surat_jalan tsj on (dtrd.flag_sj = tsj.id)
            Where tso.id=".$id." order by tsj.id");
        return $data;
    }

    function surat_jalan($user_ppn,$s,$e){
        $data = $this->db->query("Select tsj.*, (select count(tsjd.id) from t_surat_jalan_detail tsjd where tsjd.t_sj_id = tsj.id) as jumlah_item,
                    cust.nama_customer, cust.alamat,
                    so.no_sales_order, fi.id as inv
                From t_surat_jalan tsj
                    Left Join m_customers cust On (tsj.m_customer_id = cust.id)
                    Left Join sales_order so On (tsj.sales_order_id = so.id) 
                    Left Join f_invoice fi on (fi.id_surat_jalan = tsj.id)
                Where so.flag_tolling = 0  And so.flag_ppn = ".$user_ppn." and tsj.tanggal between '".$s."' and '".$e."'
                Order By tsj.no_surat_jalan Desc");
        return $data;
    }

    function show_header_sj($id){
        $data = $this->db->query("Select tsj.*, cust.id as id_customer, COALESCE(NULLIF(tso.alias,''), cust.nama_customer) as nama_customer, cust.alamat, cust.pic, COALESCE(NULLIF(tso.alias,''), cust.nama_customer_kh) as nama_customer_kh, cust.alamat_kh, so.tanggal as tanggal_so, 
                    COALESCE(tsf.no_spb, tsw.no_spb_wip, s.no_spb, tsa.no_spb_ampas) as nomor_spb,
                    COALESCE(tsf.status, tsw.status, s.status, tsa.status) as status_spb,
                    tso.no_spb, so.no_sales_order, tso.no_po, 
                    tkdr.type_kendaraan,
                    usr.realname,
                    aprv.realname as approved_name,
                    rjct.realname as rejected_name
                From t_surat_jalan tsj
                    Left Join m_customers cust On (tsj.m_customer_id = cust.id)
                    Left Join t_sales_order tso On (tsj.sales_order_id = tso.so_id) 
                    Left Join t_spb_fg tsf On (tso.jenis_barang = 'FG' and tsf.id = tso.no_spb)
                    Left Join t_spb_wip tsw On (tso.jenis_barang = 'WIP' and tsw.id = tso.no_spb)
                    Left Join spb s On (tso.jenis_barang = 'RONGSOK' and s.id = tso.no_spb)
                    Left Join t_spb_ampas tsa on (tso.jenis_barang = 'AMPAS' and tsa.id = tso.no_spb)
                    Left Join sales_order so On (so.id = tso.so_id)
                    Left Join m_type_kendaraan tkdr On (tsj.m_type_kendaraan_id = tkdr.id) 
                    Left Join users usr On (tsj.created_by = usr.id)
                    Left Join users aprv On (tsj.approved_by = aprv.id)
                    Left Join users rjct On (tsj.rejected_by = rjct.id)
                    Where tsj.id=".$id);
        return $data;
    }

    function jenis_barang_in_so($id){
        $data = $this->db->query("select jb.id,jb.jenis_barang, jb.ukuran, jb.kode from t_sales_order_detail tsod 
            left join t_sales_order tso on tso.id = tsod.t_so_id
            left join jenis_barang jb on jb.id = tsod.jenis_barang_id
            where tso.so_id =".$id);
        return $data;
    }

    function rongsok_in_so($id){
        $data = $this->db->query("select r.id, r.nama_item as jenis_barang, r.kode_rongsok from t_sales_order_detail tsod 
            left join t_sales_order tso on tso.id = tsod.t_so_id
            left join rongsok r on r.id = tsod.jenis_barang_id
            where tso.so_id =".$id);
        return $data;
    }

    function load_detail_surat_jalan_fg($id){
        $data = $this->db->query("select tsjd.id, tsjd.t_sj_id, tsjd.jenis_barang_id, tsjd.jenis_barang_alias, tsjd.no_packing, tsjd.qty, tsjd.bruto, (case when tsjd.netto_r > 0 then tsjd.netto_r else tsjd.netto end) as netto, tsjd.netto_r, tsjd.berat, tsjd.nomor_bobbin, tsjd.line_remarks, COALESCE(NULLIF((select tsod.nama_barang_alias from t_sales_order_detail tsod where tsod.jenis_barang_id =(case when tsjd.jenis_barang_alias > 0 then tsjd.jenis_barang_alias else tsjd.jenis_barang_id end) and tsod.t_so_id = tsj.sales_order_id ),''),jb.jenis_barang)as jenis_barang, jb.uom, tgf.no_produksi, jb1.kode as kode_lama, coalesce(jb2.kode, 0) as kode_baru
                from t_surat_jalan_detail tsjd
                left join jenis_barang jb on jb.id=(case when tsjd.jenis_barang_alias > 0 then tsjd.jenis_barang_alias else tsjd.jenis_barang_id end)
                left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id
                left join t_gudang_fg tgf on tgf.id = tsjd.gudang_id
                left join m_bobbin mb on tgf.bobbin_id>0 and mb.id = tgf.bobbin_id
                left join jenis_barang jb1 on jb1.id = tsjd.jenis_barang_id
                left join jenis_barang jb2 on jb2.id = tsjd.jenis_barang_alias
                where tsjd.t_sj_id =".$id." order by jenis_barang");
        return $data;
    }

    function print_sj_ekspedisi($id,$cust_id,$soid){
        if($cust_id==128){
            return $this->db->query("select count(tsjd.id) as jumlah, (CASE WHEN tsjd.nomor_bobbin = '' THEN 'DUS' ELSE 'BOBBIN' END) as uom_ekspedisi, jb.jenis_barang, jb.uom, sum(tsjd.bruto) as bruto, sum(tsjd.netto) as netto from t_surat_jalan_detail tsjd
                left join t_surat_jalan tsj on tsjd.t_sj_id = tsj.id
                left join jenis_barang jb on tsj.jenis_barang != 'RONGSOK' and jb.id =(case when tsjd.jenis_barang_alias > 0 then tsjd.jenis_barang_alias else tsjd.jenis_barang_id end)
                where tsjd.t_sj_id =".$id." group by tsjd.jenis_barang_id, uom_ekspedisi");
        }else if($cust_id==67){
            return $this->db->query("select tsjd.*, 'KG' as uom_ekspedisi, COALESCE((select tsod.nama_barang_alias from t_sales_order_detail tsod left join t_sales_order tso on tso.so_id =".$soid." where tsod.t_so_id = tso.id and tsod.jenis_barang_id = tsjd.jenis_barang_id),r.nama_item) as jenis_barang, r.uom from t_surat_jalan_detail tsjd
                left join t_surat_jalan tsj on tsjd.t_sj_id = tsj.id
                left join rongsok r on tsj.jenis_barang = 'RONGSOK' and r.id =(case when tsjd.jenis_barang_alias > 0 then tsjd.jenis_barang_alias else tsjd.jenis_barang_id end)
                where tsjd.t_sj_id =".$id);
        }
    }

    function load_detail_surat_jalan_wip($id){
        $data = $this->db->query("select tsjd.*, jb.jenis_barang, jb.uom, jb.kode
                from t_surat_jalan_detail tsjd
                left join jenis_barang jb on jb.id = tsjd.jenis_barang_id
                where tsjd.t_sj_id =".$id);
        return $data;
    }

    // function load_detail_surat_jalan_rsk($id){
    //     $data = $this->db->query("select tsjd.*, rsk.nama_item as jenis_barang, rsk.uom 
    //             from t_surat_jalan_detail tsjd
    //             left join rongsok rsk on rsk.id = tsjd.jenis_barang_id
    //             where tsjd.t_sj_id =".$id);
    //     return $data;
    // }

    function load_detail_surat_jalan_rsk($id,$soid){
        $data =  $this->db->query("select tsjd.*,(case when tsjd.netto_r > 0 then tsjd.netto_r else tsjd.netto end) as netto, rsk.nama_item as jenis_barang, rsk.uom, rsk.kode_rongsok as kode,
            (select tsod.nama_barang_alias from t_sales_order_detail tsod left join t_sales_order tso on tso.so_id =".$soid." where tsod.t_so_id = tso.id and tsod.jenis_barang_id = tsjd.jenis_barang_id) as nama_barang_alias
                from t_surat_jalan_detail tsjd
                left join rongsok rsk on rsk.id = tsjd.jenis_barang_id
                where tsjd.t_sj_id =".$id);
        return $data;
    }

    function load_detail_surat_jalan_lain($id){
        $data = $this->db->query("select tsjd.*, s.nama_item as jenis_barang, s.uom, s.alias as kode
                from t_surat_jalan_detail tsjd
                left join sparepart s on s.id = tsjd.jenis_barang_id
                where tsjd.t_sj_id =".$id);
        return $data;
    }

    function get_data_gudang_fg($id){
        $data = $this->db->query("select id_gudang from t_surat_jalan_detail where id =".$id);
        return $data;
    }

    function load_view_sjd($id){
        $data = $this->db->query("select tsjd.id, tsjd.t_sj_id, tsjd.jenis_barang_id, tsjd.jenis_barang_alias, tsjd.no_packing, tsjd.qty, tsjd.bruto, (case when tsjd.netto_r > 0 then tsjd.netto_r else tsjd.netto end) as netto, tsjd.berat, tsjd.netto_r, tsjd.nomor_bobbin, tsjd.line_remarks, jb.jenis_barang, jba.jenis_barang as jenis_barang_a, jb.uom, jb.kode, jba.kode as kode_alias, 
            (select tsod.amount from t_sales_order_detail tsod 
            where tsod.t_so_id = tsj.sales_order_id and tsod.jenis_barang_id = case when tsjd.jenis_barang_alias > 0 then tsjd.jenis_barang_alias else tsjd.jenis_barang_id end)as amount 
                from t_surat_jalan_detail tsjd
                left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id
                left join jenis_barang jb on jb.id= tsjd.jenis_barang_id
                left join jenis_barang jba on tsjd.jenis_barang_alias != 0 and jba.id = tsjd.jenis_barang_alias
                where tsjd.t_sj_id = ".$id);
        return $data;
    }

    function get_jb($id){
        $data = $this->db->query("select id, jenis_barang, kode from jenis_barang where id =".$id);
        return $data;
    }

    function get_rsk($id){
        $data = $this->db->query("Select * from rongsok where id =".$id);
        return $data;
    }

    function tsj_header_only($id){
        $data = $this->db->query("Select tsj.*, COALESCE(tsf.status, tsw.status, spb.status, tsa.status, 0) as status_spb, so.flag_sj, so.flag_invoice from t_surat_jalan tsj
            left join t_sales_order tso on tso.id =tsj.sales_order_id
            left join sales_order so on so.id = tso.so_id
            left join t_spb_fg tsf on tso.jenis_barang = 'FG' and tsf.id = tso.no_spb
            left join t_spb_wip tsw on tso.jenis_barang = 'WIP' and tsw.id = tso.no_spb
            left join spb on tso.jenis_barang = 'RONGSOK' and spb.id = tso.no_spb
            left join t_spb_ampas tsa on tso.jenis_barang = 'AMPAS' and tsa.id = tso.no_spb
            where tsj.id =".$id);
        return $data;
    }

    function tsj_detail_only($id){
        $data = $this->db->query("Select * from t_surat_jalan_detail where t_sj_id =".$id);
        return $data;
    }

    function tsjd_get_gudang($id){
        $data = $this->db->query("Select 
                tsjd.id as id_sj_d, tsjd.t_sj_id, (case when tsjd.jenis_barang_alias = 0 then tsjd.jenis_barang_id else tsjd.jenis_barang_alias end) as sj_jb, tsjd.jenis_barang_alias, tsjd.qty as jb_qty, tsjd.netto_r, tsjd.nomor_bobbin, tsjd.line_remarks,
                tgf.*, 
                tbf.no_bpb_fg, tbf.tanggal as tgl_bpb, tbf.jenis_barang_id as jb_bpb, tbf.keterangan as ket_bpb,
                tbfd.id as id_bpb_d, tbfd.jenis_barang_id as jbd, tbfd.no_produksi, tgf.berat_bobbin,
                pf.id as id_prd, pf.no_laporan_produksi, pf.tanggal as tgl_prd, pf.flag_result, pf.remarks as remarks_prd, pf.jenis_barang_id as jb_prd, pf.jenis_packing_id
                from t_surat_jalan_detail tsjd
                left join t_gudang_fg tgf on tgf.id = tsjd.gudang_id
                left join t_bpb_fg tbf on tbf.id = tgf.t_bpb_fg_id
                left join t_bpb_fg_detail tbfd on tbfd.id = tgf.t_bpb_fg_detail_id
                left join produksi_fg pf on pf.id = tbf.produksi_fg_id
                where tsjd.t_sj_id =".$id);
        return $data;
    }

    function tsjd_get_gudang_wip($id){
        return $this->db->query("select tsjd.id as id_sj_d, tsjd.t_sj_id, tsjd.jenis_barang_id as sj_jb, tsjd.jenis_barang_alias, tsjd.qty as jb_qty, tsjd.netto_r, tsjd.nomor_bobbin, tsjd.line_remarks, tgw.*, jb.uom
            from t_surat_jalan_detail tsjd
            left join t_gudang_wip tgw on tgw.id = tsjd.gudang_id
            left join jenis_barang jb on jb.id = tsjd.jenis_barang_id
            where tsjd.t_sj_id=".$id);
    }

    function tsjd_get_gudang_rsk($id){
        return $this->db->query("select tsjd.id as id_sj_d, tsjd.t_sj_id, tsjd.jenis_barang_id as sj_jb, tsjd.jenis_barang_alias, tsjd.qty as jb_qty, tsjd.netto_r, tsjd.nomor_bobbin, tsjd.line_remarks, dd.*, td.id as id_ttr_detail from t_surat_jalan_detail tsjd
            left join dtr_detail dd on dd.id = tsjd.gudang_id
            left join ttr_detail td on td.dtr_detail_id = dd.id
            where tsjd.t_sj_id=".$id);
    }

    function tsjd_get_gudang_ampas($id){
        return $this->db->query("select tsjd.id as id_sj_d, tsjd.t_sj_id, tsjd.jenis_barang_id as sj_jb, tsjd.jenis_barang_alias, tsjd.no_packing, tsjd.qty as jb_qty, tsjd.bruto, tsjd.berat, tsjd.netto, tsjd.netto_r, tsjd.nomor_bobbin, tsjd.line_remarks from t_surat_jalan_detail tsjd
            where tsjd.t_sj_id=".$id);
    }

    function tsjd_get_gudang_lain($id){
        return $this->db->query("select tsjd.id as id_sj_d, tsjd.t_sj_id, tsjd.jenis_barang_id as sj_jb, tsjd.jenis_barang_alias, tsjd.no_packing, tsjd.qty as jb_qty, tsjd.bruto, tsjd.berat, tsjd.netto, tsjd.netto_r, tsjd.nomor_bobbin, tsjd.line_remarks from t_surat_jalan_detail tsjd
            where tsjd.t_sj_id=".$id);
    }

    function get_sj_detail($id,$jb){
        $data = $this->db->query("Select tsj.*, COALESCE(tsod.nama_barang_alias, jb.jenis_barang,r.nama_item) as jenis_barang , COALESCE(jb.kode,r.kode_rongsok) as kode from t_surat_jalan_detail tsjd
            left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id
            left join t_sales_order_detail tsod on tsod.t_so_id = tsj.sales_order_id and (case when tsjd.jenis_barang_alias = 0 then tsod.jenis_barang_id = tsjd.jenis_barang_id else tsod.jenis_barang_id = tsjd.jenis_barang_alias end)
            left join jenis_barang jb on tsj.jenis_barang='FG' and (case when tsjd.jenis_barang_alias = 0 then jb.id = tsjd.jenis_barang_id else jb.id = tsjd.jenis_barang_alias end)
            left join rongsok r on tsj.jenis_barang='RONGSOK' and (case when tsjd.jenis_barang_alias = 0 then r.id = tsjd.jenis_barang_id else r.id = tsjd.jenis_barang_alias end)
            where tsj.jenis_barang='".$jb."' and tsjd.id=".$id);
        return $data;
    }

    function load_detail_surat_jalan_rs2k($id,$soid){
        $data =  $this->db->query("select tsjd.*, rsk.nama_item as jenis_barang, rsk.uom,
            (select tsod.nama_barang_alias from t_sales_order_detail tsod left join t_sales_order tso on tso.so_id =".$soid." where tsod.t_so_id = tso.id and tsod.jenis_barang_id = tsjd.jenis_barang_id) as nama_barang_alias
                from t_surat_jalan_detail tsjd
                left join rongsok rsk on rsk.id = tsjd.jenis_barang_id
                where tsjd.t_sj_id =".$id);
        return $data;
    }

    function get_last_sj($ppn){
        $data = $this->db->query("select no_surat_jalan from t_surat_jalan tsj
            left join sales_order so on so.id = tsj.sales_order_id 
            where so.flag_ppn =".$ppn."
            order by no_surat_jalan desc limit 1
            ");
        return $data;
    }

    function get_last_sj_cv(){
        $data = $this->db->query("select no_sj_resmi from r_t_surat_jalan tsj where tsj.jenis_surat_jalan = 'SURAT JALAN KMP KE CV' order by no_sj_resmi desc limit 1");
        return $data;
    }

    function summery_report_so(){
        $data = $this->db->query("SELECT so.tanggal, tso.*, SUM(tsod.bruto) AS jumlah_bruto, SUM(tsod.netto) AS jumlah_netto, COUNT(tsod.id) AS jumlah_item
            FROM t_sales_order tso
            INNER JOIN t_sales_order_detail tsod ON tsod.t_so_id = tso.id
            INNER JOIN sales_order so ON so.id = tso.so_id
            GROUP BY MONTH(so.tanggal)");
        return $data;
    }

    function show_view_laporan($tanggal){
        $data = $this->db->query("select tsjd.t_sj_id, tsj.no_surat_jalan, tsj.tanggal, sum(tsjd.qty) as qty, sum(tsjd.bruto) as bruto, 
            (case when tsjd.jenis_barang_alias = 0 then tsjd.jenis_barang_id else tsjd.jenis_barang_alias end) as jbid,
           round(sum(case when tsjd.netto_r > 0 then tsjd.netto_r else tsjd.netto end),3)as netto,
            COALESCE(jb.jenis_barang,r.nama_item) as jenis_barang, COALESCE(jb.uom,r.uom) as uom,
            (select tsod.amount from t_sales_order_detail tsod left join t_sales_order tso on tso.id = tsod.t_so_id where tso.so_id = tsj.sales_order_id and tsod.jenis_barang_id = case when tsjd.jenis_barang_alias > 0 then tsjd.jenis_barang_alias else tsjd.jenis_barang_id end)as amount 
            from t_surat_jalan_detail tsjd 
            left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id 
            left join t_sales_order tso on tso.so_id = tsj.sales_order_id
            left join jenis_barang jb on tso.jenis_barang != 'RONGSOK' and jb.id = (case when tsjd.jenis_barang_alias > 0 then tsjd.jenis_barang_alias else tsjd.jenis_barang_id end)
            left join rongsok r on tso.jenis_barang = 'RONGSOK' and r.id=tsjd.jenis_barang_id
                        where tsj.tanggal 
                         between '".$tanggal."-01' and '".$tanggal."-30'
                        group by jb.id
                        order by jb.jenis_barang;");
        return $data;
    }

    function show_view_laporan_by_sj($s,$e,$ppn){
        if($ppn==2){
            $data = $this->db->query("select tsjd.t_sj_id, tsj.no_surat_jalan, so.flag_ppn, tsj.tanggal, sum(tsjd.qty) as qty, sum(tsjd.bruto) as bruto, 
            COALESCE(NULLIF(tso.alias,''),(case when tsjd.jenis_barang_alias = 0 then tsjd.jenis_barang_id else tsjd.jenis_barang_alias end)) as jbid, (case when so.flag_ppn = 1 then mc.nama_customer else mc.nama_customer_kh end) as nama_customer,
            round(sum(case when tsjd.netto_r > 0 then tsjd.netto_r else tsjd.netto end),3) as netto,
            COALESCE(r.nama_item,r2.nama_item,sp.nama_item,jb.jenis_barang) as jenis_barang, COALESCE(r.uom,r2.uom,sp.uom,jb.uom) as uom,
            (select tsod.amount from t_sales_order_detail tsod left join t_sales_order tso on tso.id = tsod.t_so_id where tso.so_id = tsj.sales_order_id and tsod.jenis_barang_id = case when tsjd.jenis_barang_alias > 0 then tsjd.jenis_barang_alias else tsjd.jenis_barang_id end)as amount 
            from t_surat_jalan_detail tsjd 
            left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id 
            left join t_sales_order tso on tso.so_id = tsj.sales_order_id
            left join sales_order so on so.id = tso.so_id
            left join m_customers mc on mc.id = tsj.m_customer_id
            left join rongsok r on (tsj.jenis_barang = 'RONGSOK' and r.id = tsjd.jenis_barang_id)
            left join rongsok r2 on (tsj.jenis_barang = 'AMPAS' and r2.id = tsjd.jenis_barang_id)
            left join sparepart sp on (tsj.jenis_barang = 'LAIN' and sp.id = tsjd.jenis_barang_id)
            left join jenis_barang jb on (jb.id = tsjd.jenis_barang_id)
                        where tsj.tanggal 
                        between '".$s."' and '".$e."'
                        group by jbid, tsj.no_surat_jalan
                        order by tsj.tanggal, tsj.no_surat_jalan, jenis_barang;");
        }else{
            $data = $this->db->query("select tsjd.t_sj_id, tsj.no_surat_jalan, so.flag_ppn, tsj.tanggal, sum(tsjd.qty) as qty, sum(tsjd.bruto) as bruto, 
            COALESCE(NULLIF(tso.alias,''),(case when tsjd.jenis_barang_alias = 0 then tsjd.jenis_barang_id else tsjd.jenis_barang_alias end)) as jbid, (case when so.flag_ppn = 1 then mc.nama_customer else mc.nama_customer_kh end) as nama_customer,
            round(sum(case when tsjd.netto_r > 0 then tsjd.netto_r else tsjd.netto end),3) as netto,
            COALESCE(r.nama_item,r2.nama_item,sp.nama_item,jb.jenis_barang) as jenis_barang, COALESCE(r.uom,r2.uom,sp.uom,jb.uom) as uom,
            (select tsod.amount from t_sales_order_detail tsod left join t_sales_order tso on tso.id = tsod.t_so_id where tso.so_id = tsj.sales_order_id and tsod.jenis_barang_id = case when tsjd.jenis_barang_alias > 0 then tsjd.jenis_barang_alias else tsjd.jenis_barang_id end)as amount 
            from t_surat_jalan_detail tsjd 
            left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id 
            left join t_sales_order tso on tso.so_id = tsj.sales_order_id
            left join sales_order so on so.id = tso.so_id
            left join m_customers mc on mc.id = tsj.m_customer_id
            left join rongsok r on (tsj.jenis_barang = 'RONGSOK' and r.id = tsjd.jenis_barang_id)
            left join rongsok r2 on (tsj.jenis_barang = 'AMPAS' and r2.id = tsjd.jenis_barang_id)
            left join sparepart sp on (tsj.jenis_barang = 'LAIN' and sp.id = tsjd.jenis_barang_id)
            left join jenis_barang jb on (jb.id = tsjd.jenis_barang_id)
                        where tsj.tanggal 
                        between '".$s."' and '".$e."' and so.flag_ppn=".$ppn."
                        group by jbid, tsj.no_surat_jalan
                        order by tsj.tanggal, tsj.no_surat_jalan, jenis_barang;");
        }
        return $data;
    }

    function show_view_laporan_by_jb($s,$e,$ppn){
        $data = $this->db->query("select tsjd.t_sj_id, tsj.no_surat_jalan, so.flag_ppn, tsj.tanggal, sum(tsjd.qty) as qty, sum(tsjd.bruto) as bruto, (case when so.flag_ppn = 1 then mc.nama_customer else mc.nama_customer_kh end) as nama_customer,
            (case when tsjd.jenis_barang_alias = 0 then tsjd.jenis_barang_id else tsjd.jenis_barang_alias end) as jbid,
            round(sum(case when tsjd.netto_r > 0 then tsjd.netto_r else tsjd.netto end),3) as netto, COALESCE(r.kode_rongsok,r2.kode_rongsok,sp.alias,jb.kode) as kode,
            COALESCE(r.nama_item,r2.nama_item,sp.nama_item,jb.jenis_barang) as jenis_barang, COALESCE(r.uom,r2.uom,sp.uom,jb.uom) as uom,
            (select tsod.amount from t_sales_order_detail tsod 
            left join t_sales_order tso on tso.id = tsod.t_so_id 
            where tso.so_id = tsj.sales_order_id and tsod.jenis_barang_id = case when tsjd.jenis_barang_alias > 0 then tsjd.jenis_barang_alias else tsjd.jenis_barang_id end)as amount 
            from t_surat_jalan_detail tsjd 
            left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id 
            left join t_sales_order tso on tso.so_id = tsj.sales_order_id
            left join sales_order so on so.id = tso.so_id
            left join m_customers mc on mc.id = tsj.m_customer_id
            left join rongsok r on (tsj.jenis_barang = 'RONGSOK' and r.id = tsjd.jenis_barang_id)
            left join rongsok r2 on (tsj.jenis_barang = 'AMPAS' and r2.id = tsjd.jenis_barang_id)
            left join sparepart sp on (tsj.jenis_barang = 'LAIN' and sp.id = tsjd.jenis_barang_id)
            left join jenis_barang jb on (jb.id = tsjd.jenis_barang_id)
                        where tsj.tanggal 
                        between '".$s."' and '".$e."' and so.flag_ppn = ".$ppn."
                        group by jbid
                        order by so.flag_ppn, tsjd.jenis_barang_id");
        return $data;
    }

    function query_pak_yo(){
        return $this->db->query('
        select
        so2.no_sales_order,  so2.tanggal as tgl_so, so2.kode_barang, so2.nama_barang, so2.customer, so2.netto netto_order, soc.netto nettto_kirim, 
        so2.netto - soc.netto as sisa_order, 
        round((so2.netto - soc.netto)/so2.netto*100,1) pct
        from
        (
        select x.* ,
        case when x.jenis_barang = "FG" then jb.kode else r.kode_rongsok end kode_barang,
        case when x.jenis_barang = "FG" then jb.jenis_barang else r.nama_item end nama_barang,
        case when x.flag_ppn = 0 then mc.nama_customer else mc.nama_customer end customer
        from
        (select so.id idso, so.no_sales_order, so.tanggal, so.m_customer_id, so.flag_ppn, tso.jenis_barang, tsod.jenis_barang_id, tsod.netto, tsod.amount from 
        sales_order so,
        t_sales_order tso,
        t_sales_order_detail tsod
        where
        tsod.t_so_id = tso.id
        and tso.so_id = so.id
        ) x
        left join jenis_barang jb on x.jenis_barang = "FG" and jb.id = x.jenis_barang_id
        left join rongsok r on x.jenis_barang = "RONGSOK" and  r.id = x.jenis_barang_id
        left join m_customers mc on mc.id = x.m_customer_id
        ) so2,
        (select 
        s1.id idso, tsjd.jenis_barang_id, sum(tsjd.netto) netto
        from
        t_surat_jalan_detail tsjd,
        t_surat_jalan tsj 
        left join sales_order s1 on s1.id = tsj.sales_order_id
        where 
        tsjd.t_sj_id = tsj.id
        group by s1.id,  tsjd.jenis_barang_id) soc
        where
        so2.idso = soc.idso
        and so2.jenis_barang_id = soc.jenis_barang_id
        order by 1,2
        ');
    }

    function sisa_so_gabungan(){
        return $this->db->query("
            select so.no_sales_order, COALESCE(NULLIF(tso.alias,''),(case when so.flag_ppn = 1 then mc.nama_customer else mc.nama_customer_kh end)) as nama_customer, so.flag_ppn, so.tanggal as tgl_so, tso.tgl_po, IF(so.flag_tolling = 2,1,so.flag_tolling) as flag_tolling, tso.no_po, tsod.jenis_barang_id, tsod.amount, COALESCE(NULLIF(tsod.nama_barang_alias,''),r.nama_item,r2.nama_item,sp.nama_item,jb.jenis_barang) as nama_barang, COALESCE(r.kode_rongsok,r2.kode_rongsok,sp.alias,jb.kode) as kode_barang, IF(tso.jenis_barang = 'RONGSOK', tsod.qty, tsod.netto)as netto, tsod.amount,
             (select sum(tsjd.netto) from t_surat_jalan_detail tsjd
             left join t_surat_jalan tsj on tsjd.t_sj_id = tsj.id and tsjd.t_sj_id
             where tsj.sales_order_id = so.id and CASE WHEN tsjd.jenis_barang_alias = 0 THEN tsjd.jenis_barang_id=tsod.jenis_barang_id ELSE tsjd.jenis_barang_alias=tsod.jenis_barang_id END) as netto_kirim, tso.no_po
            from t_sales_order_detail tsod
            left join t_sales_order tso on tso.id = tsod.t_so_id
            left join sales_order so on so.id = tso.so_id
            left join m_customers mc on mc.id = so.m_customer_id
            left join rongsok r on (tso.jenis_barang = 'RONGSOK' and r.id = tsod.jenis_barang_id)
            left join rongsok r2 on (tso.jenis_barang = 'AMPAS' and r2.id = tsod.jenis_barang_id)
            left join sparepart sp on (tso.jenis_barang = 'LAIN' and sp.id = tsod.jenis_barang_id)
            left join jenis_barang jb on (jb.id = tsod.jenis_barang_id)
            where so.flag_sj = 0
            order by so.flag_ppn, so.flag_tolling, mc.nama_customer asc, so.no_sales_order, so.tanggal asc, kode_barang asc
            ");
    }

    function sisa_so_gabungan_jb(){
        return $this->db->query("
            select so.no_sales_order, COALESCE(NULLIF(tso.alias,''),(case when so.flag_ppn = 1 then mc.nama_customer else mc.nama_customer_kh end)) as nama_customer, so.flag_ppn, so.tanggal as tgl_so, tso.tgl_po, IF(so.flag_tolling = 2,1,so.flag_tolling) as flag_tolling, tso.no_po, tsod.jenis_barang_id, tsod.amount, COALESCE(NULLIF(tsod.nama_barang_alias,''),r.nama_item,r2.nama_item,sp.nama_item,jb.jenis_barang) as nama_barang, COALESCE(r.kode_rongsok,r2.kode_rongsok,sp.alias,jb.kode) as kode_barang, IF(tso.jenis_barang = 'RONGSOK', tsod.qty, tsod.netto)as netto, tsod.amount,
             (select sum(tsjd.netto) from t_surat_jalan_detail tsjd
             left join t_surat_jalan tsj on tsjd.t_sj_id = tsj.id and tsjd.t_sj_id
             where tsj.sales_order_id = so.id and CASE WHEN tsjd.jenis_barang_alias = 0 THEN tsjd.jenis_barang_id=tsod.jenis_barang_id ELSE tsjd.jenis_barang_alias=tsod.jenis_barang_id END) as netto_kirim, tso.no_po
            from t_sales_order_detail tsod
            left join t_sales_order tso on tso.id = tsod.t_so_id
            left join sales_order so on so.id = tso.so_id
            left join m_customers mc on mc.id = so.m_customer_id
            left join rongsok r on (tso.jenis_barang = 'RONGSOK' and r.id = tsod.jenis_barang_id)
            left join rongsok r2 on (tso.jenis_barang = 'AMPAS' and r2.id = tsod.jenis_barang_id)
            left join sparepart sp on (tso.jenis_barang = 'LAIN' and sp.id = tsod.jenis_barang_id)
            left join jenis_barang jb on (jb.id = tsod.jenis_barang_id)
            where so.flag_sj = 0
            order by kode asc, so.tanggal asc, kode_barang asc
            ");
    }

    function print_laporan_sisa_so_jb(){
        return $this->db->query("SELECT jenis, nama_barang, flag_tolling, jenis_barang_id, sum(netto) as netto, sum(netto_kirim) as netto_kirim from (
            select
            (CASE WHEN tso.jenis_barang = 'FG' THEN
                CASE WHEN jb.ukuran < 1000 THEN 0 ELSE 1 END
            ELSE 2 END) as jenis,
            IF(so.flag_tolling = 2,1,so.flag_tolling) as flag_tolling, tsod.jenis_barang_id, COALESCE(r.nama_item,r2.nama_item,sp.nama_item,jb.jenis_barang) as nama_barang, IF(tso.jenis_barang = 'RONGSOK', tsod.qty, tsod.netto) as netto,
             coalesce((select sum(tsjd.netto) from t_surat_jalan_detail tsjd
             left join t_surat_jalan tsj on tsjd.t_sj_id = tsj.id and tsjd.t_sj_id
             where tsj.sales_order_id = so.id and CASE WHEN tsjd.jenis_barang_alias = 0 THEN tsjd.jenis_barang_id=tsod.jenis_barang_id ELSE tsjd.jenis_barang_alias=tsod.jenis_barang_id END),0) as netto_kirim
            from t_sales_order_detail tsod
            left join t_sales_order tso on tso.id = tsod.t_so_id
            left join sales_order so on so.id = tso.so_id
            left join rongsok r on (tso.jenis_barang = 'RONGSOK' and r.id = tsod.jenis_barang_id)
            left join rongsok r2 on (tso.jenis_barang = 'AMPAS' and r2.id = tsod.jenis_barang_id)
            left join sparepart sp on (tso.jenis_barang = 'LAIN' and sp.id = tsod.jenis_barang_id)
            left join jenis_barang jb on (jb.id = tsod.jenis_barang_id)
            where so.flag_sj = 0
            ) as a
            where (netto- netto_kirim) > 0
            group by nama_barang, flag_tolling
            order by jenis, nama_barang asc
            ");
    }

    // function print_laporan_sisa_so_jb(){
    //     return $this->db->query("SELECT jenis, nama_barang, flag_tolling, jenis_barang_id, sum(netto) as netto, sum(netto_kirim) as netto_kirim from (
    //         select
    //         (CASE WHEN tso.jenis_barang = 'FG' THEN
    //             CASE WHEN jb.ukuran < 1000 THEN 0 ELSE 1 END
    //         ELSE 2 END) as jenis,
    //         IF(so.flag_tolling = 2,1,so.flag_tolling) as flag_tolling, tsod.jenis_barang_id, COALESCE(r.nama_item,r2.nama_item,sp.nama_item,jb.jenis_barang) as nama_barang, IF(tso.jenis_barang = 'RONGSOK', tsod.qty, tsod.netto) as netto,
    //          coalesce((select sum(tsjd.netto) from t_surat_jalan_detail tsjd
    //          left join t_surat_jalan tsj on tsjd.t_sj_id = tsj.id and tsjd.t_sj_id
    //          where tsj.sales_order_id = so.id and CASE WHEN tsjd.jenis_barang_alias = 0 THEN tsjd.jenis_barang_id=tsod.jenis_barang_id ELSE tsjd.jenis_barang_alias=tsod.jenis_barang_id END),0) as netto_kirim
    //         from t_sales_order_detail tsod
    //         left join t_sales_order tso on tso.id = tsod.t_so_id
    //         left join sales_order so on so.id = tso.so_id
    //         left join rongsok r on (tso.jenis_barang = 'RONGSOK' and r.id = tsod.jenis_barang_id)
    //         left join rongsok r2 on (tso.jenis_barang = 'AMPAS' and r2.id = tsod.jenis_barang_id)
    //         left join sparepart sp on (tso.jenis_barang = 'LAIN' and sp.id = tsod.jenis_barang_id)
    //         left join jenis_barang jb on (jb.id = tsod.jenis_barang_id)
    //         where so.flag_sj = 0
    //         ) as a
    //         group by nama_barang, flag_tolling
    //         order by jenis, nama_barang asc
    //         ");
    // }

    function sisa_so_jb($id){
        return $this->db->query("
            select so.no_sales_order, COALESCE(NULLIF(tso.alias,''),(case when so.flag_ppn = 1 then mc.nama_customer else mc.nama_customer_kh end)) as nama_customer, so.flag_ppn, so.tanggal as tgl_so, tso.tgl_po, IF(so.flag_tolling = 2,1,so.flag_tolling) as flag_tolling, tso.no_po, tsod.jenis_barang_id, tsod.amount, COALESCE(NULLIF(tsod.nama_barang_alias,''),r.nama_item,r2.nama_item,sp.nama_item,jb.jenis_barang) as nama_barang, COALESCE(r.kode_rongsok,r2.kode_rongsok,sp.alias,jb.kode) as kode_barang, IF(tso.jenis_barang = 'RONGSOK', tsod.qty, tsod.netto)as netto, tsod.amount,
             (select sum(tsjd.netto) from t_surat_jalan_detail tsjd
             left join t_surat_jalan tsj on tsjd.t_sj_id = tsj.id and tsjd.t_sj_id
             where tsj.sales_order_id = so.id and CASE WHEN tsjd.jenis_barang_alias = 0 THEN tsjd.jenis_barang_id=tsod.jenis_barang_id ELSE tsjd.jenis_barang_alias=tsod.jenis_barang_id END) as netto_kirim, tso.no_po
            from t_sales_order_detail tsod
            left join t_sales_order tso on tso.id = tsod.t_so_id
            left join sales_order so on so.id = tso.so_id
            left join m_customers mc on mc.id = so.m_customer_id
            left join rongsok r on (tso.jenis_barang = 'RONGSOK' and r.id = tsod.jenis_barang_id)
            left join rongsok r2 on (tso.jenis_barang = 'AMPAS' and r2.id = tsod.jenis_barang_id)
            left join sparepart sp on (tso.jenis_barang = 'LAIN' and sp.id = tsod.jenis_barang_id)
            left join jenis_barang jb on (jb.id = tsod.jenis_barang_id)
            where so.flag_sj = 0 and so.flag_ppn =".$id."
            order by kode asc, so.tanggal asc, kode_barang asc
            ");
    }

    function sisa_so($ppn){
        return $this->db->query("
            select so.no_sales_order, so.flag_ppn, COALESCE(NULLIF(tso.alias,''),(case when so.flag_ppn = 1 then mc.nama_customer else mc.nama_customer_kh end)) as nama_customer, so.tanggal as tgl_so, tso.tgl_po, IF(so.flag_tolling = 2,1,so.flag_tolling) as flag_tolling, tso.no_po, tsod.jenis_barang_id, tsod.amount, COALESCE(NULLIF(tsod.nama_barang_alias,''),r.nama_item,r2.nama_item,sp.nama_item,jb.jenis_barang) as nama_barang, COALESCE(r.kode_rongsok,r2.kode_rongsok,sp.alias,jb.kode) as kode_barang, IF(tso.jenis_barang = 'RONGSOK', tsod.qty, tsod.netto)as netto, tsod.amount,
             (select sum(tsjd.netto) from t_surat_jalan_detail tsjd
             left join t_surat_jalan tsj on tsjd.t_sj_id = tsj.id and tsjd.t_sj_id
             where tsj.sales_order_id = so.id and CASE WHEN tsjd.jenis_barang_alias = 0 THEN tsjd.jenis_barang_id=tsod.jenis_barang_id ELSE tsjd.jenis_barang_alias=tsod.jenis_barang_id END) as netto_kirim, tso.no_po
            from t_sales_order_detail tsod
            left join t_sales_order tso on tso.id = tsod.t_so_id
            left join sales_order so on so.id = tso.so_id
            left join m_customers mc on mc.id = so.m_customer_id
            left join rongsok r on (tso.jenis_barang = 'RONGSOK' and r.id = tsod.jenis_barang_id)
            left join rongsok r2 on (tso.jenis_barang = 'AMPAS' and r2.id = tsod.jenis_barang_id)
            left join sparepart sp on (tso.jenis_barang = 'LAIN' and sp.id = tsod.jenis_barang_id)
            left join jenis_barang jb on (jb.id = tsod.jenis_barang_id)
            where so.flag_ppn =".$ppn." and so.flag_sj = 0
            order by so.flag_tolling, mc.nama_customer asc, so.no_sales_order, so.tanggal asc, kode_barang asc
            ");
    }

    function laporan_so_bulan($s,$e,$ppn){
        return $this->db->query("
            select so.no_sales_order, (case when so.flag_ppn = 1 then mc.nama_customer else mc.nama_customer_kh end) as nama_customer, so.tanggal as tgl_so, tso.tgl_po, IF(so.flag_tolling = 2,1,so.flag_tolling) as flag_tolling, tso.no_po, tsod.jenis_barang_id, tsod.amount, COALESCE(NULLIF(tsod.nama_barang_alias,''),r.nama_item,r2.nama_item,sp.nama_item,jb.jenis_barang) as nama_barang, COALESCE(r.kode_rongsok,r2.kode_rongsok,sp.alias,jb.kode) as kode_barang, IF(tso.jenis_barang = 'RONGSOK', tsod.qty, tsod.netto)as netto, tsod.amount,
             (select sum(tsjd.netto) from t_surat_jalan_detail tsjd
             left join t_surat_jalan tsj on tsjd.t_sj_id = tsj.id and tsjd.t_sj_id
             where tsj.sales_order_id = so.id and CASE WHEN tsjd.jenis_barang_alias = 0 THEN tsjd.jenis_barang_id=tsod.jenis_barang_id ELSE tsjd.jenis_barang_alias=tsod.jenis_barang_id END) as netto_kirim, tso.no_po
            from t_sales_order_detail tsod
            left join t_sales_order tso on tso.id = tsod.t_so_id
            left join sales_order so on so.id = tso.so_id
            left join m_customers mc on mc.id = so.m_customer_id
            left join rongsok r on (tso.jenis_barang = 'RONGSOK' and r.id = tsod.jenis_barang_id)
            left join rongsok r2 on (tso.jenis_barang = 'AMPAS' and r2.id = tsod.jenis_barang_id)
            left join sparepart sp on (tso.jenis_barang = 'LAIN' and sp.id = tsod.jenis_barang_id)
            left join jenis_barang jb on (jb.id = tsod.jenis_barang_id)
            where so.flag_ppn =".$ppn." and (so.tanggal BETWEEN '".$s."' AND '".$e."')
            order by so.flag_tolling, mc.nama_customer asc, so.tanggal asc, kode_barang asc
            ");
    }

    function laporan_per_sj_bulan($s,$e,$ppn){
        return $this->db->query("
            select so.no_sales_order, so.flag_ppn, (case when so.flag_ppn = 1 then mc.nama_customer else mc.nama_customer_kh end) as nama_customer, so.tanggal as tgl_so, tso.tgl_po, IF(so.flag_tolling = 2,1,so.flag_tolling) as flag_tolling, tso.no_po, tsod.jenis_barang_id, tsod.amount, COALESCE(NULLIF(tsod.nama_barang_alias,''),r.nama_item,r2.nama_item,sp.nama_item,jb.jenis_barang) as nama_barang, COALESCE(r.kode_rongsok,r2.kode_rongsok,sp.alias,jb.kode) as kode_barang, IF(tso.jenis_barang = 'RONGSOK', tsod.qty, tsod.netto)as netto, tsod.amount,
             (select sum(tsjd.netto) from t_surat_jalan_detail tsjd
             left join t_surat_jalan tsj on tsjd.t_sj_id = tsj.id and tsjd.t_sj_id
             where tsj.sales_order_id = so.id and CASE WHEN tsjd.jenis_barang_alias = 0 THEN tsjd.jenis_barang_id=tsod.jenis_barang_id ELSE tsjd.jenis_barang_alias=tsod.jenis_barang_id END) as netto_kirim, tso.no_po
            from t_sales_order_detail tsod
            left join t_sales_order tso on tso.id = tsod.t_so_id
            left join sales_order so on so.id = tso.so_id
            left join m_customers mc on mc.id = so.m_customer_id
            left join rongsok r on (tso.jenis_barang = 'RONGSOK' and r.id = tsod.jenis_barang_id)
            left join rongsok r2 on (tso.jenis_barang = 'AMPAS' and r2.id = tsod.jenis_barang_id)
            left join sparepart sp on (tso.jenis_barang = 'LAIN' and sp.id = tsod.jenis_barang_id)
            left join jenis_barang jb on (jb.id = tsod.jenis_barang_id)
            where so.flag_ppn =".$ppn." and (so.tanggal BETWEEN '".$s."' AND '".$e."')
            order by so.flag_tolling, mc.nama_customer asc, so.tanggal asc, kode_barang asc
            ");
    }

    function t_sj_only($id){
        return $this->db->query("select tsj.*, mbj.id as id_bobbin_peminjaman, tso.no_spb from t_surat_jalan tsj
            left join t_sales_order tso on tso.id = tsj.sales_order_id
            left join m_bobbin_peminjaman mbj on mbj.id_surat_jalan = tsj.id
            where tsj.id =".$id);
    }

    function t_sj_detail_only($id){
        return $this->db->query("select * from t_surat_jalan_detail where t_sj_id =".$id);
    }

    function detail_bulanan_so($ppn){
        return $this->db->query("select sum(tsjd.netto) as netto from t_surat_jalan_detail tsjd
            left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id
            left join sales_order so on so.id = tsj.sales_order_id
            WHERE MONTH(tsj.tanggal) = MONTH(CURRENT_DATE())
            AND YEAR(tsj.tanggal) = YEAR(CURRENT_DATE()) and so.flag_ppn = ".$ppn."
            ");
    }

    function detail_harian_so($ppn){
        return $this->db->query("select sum(tsjd.netto) as netto from t_surat_jalan_detail tsjd
            left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id
            left join sales_order so on so.id = tsj.sales_order_id
            WHERE tsj.tanggal = CURRENT_DATE() and so.flag_ppn = ".$ppn."
            ");
    }

    function detail_bulanan_sog(){
        return $this->db->query("select sum(tsjd.netto) as netto from t_surat_jalan_detail tsjd
            left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id
            WHERE MONTH(tsj.tanggal) = MONTH(CURRENT_DATE())
            AND YEAR(tsj.tanggal) = YEAR(CURRENT_DATE())
            ");
    }

    function detail_harian_sog(){
        return $this->db->query("select sum(tsjd.netto) as netto from t_surat_jalan_detail tsjd
            left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id
            WHERE tsj.tanggal = CURRENT_DATE()
            ");
    }

    function get_last_so($ppn){
        return $this->db->query("select no_sales_order from sales_order where flag_ppn =".$ppn." order by no_sales_order desc limit 1");
    }

    function get_last_so_cv(){
        return $this->db->query("select no_so from r_t_so where jenis_so = 'SO KMP' order by no_so desc limit 1");
    }

    function so_hari_ini($date){
        return $this->db->query("select COALESCE(jb.jenis_barang, jb2.jenis_barang, jb3.nama_item, r.nama_item, r2.nama_item) as jenis_barang, COALESCE(NULLIF(d.netto,0),d.qty) as netto, so.no_sales_order from t_sales_order_detail d
                left join t_sales_order tso on d.t_so_id = tso.id
                left join sales_order so on tso.so_id = so.id
                left join jenis_barang jb on tso.jenis_barang = 'FG' and jb.id = d.jenis_barang_id
                left join jenis_barang jb2 on tso.jenis_barang = 'WIP' and jb2.id = d.jenis_barang_id
                left join sparepart jb3 on tso.jenis_barang = 'LAIN' and jb3.id = d.jenis_barang_id
                left join rongsok r on  tso.jenis_barang = 'RONGSOK' and r.id = d.jenis_barang_id
                left join rongsok r2 on  tso.jenis_barang = 'AMPAS' and r2.id = d.jenis_barang_id
                where CAST(so.created AS DATE) ='".$date."'
                group by jenis_barang_id");
    }

    function get_bp_kardus($id){//3 kardus, 5 bp, 0 yg lain
        return $this->db->query("select jenis_packing, count(id) as jumlah, ket from (select id, CASE
        WHEN substr(tsjd.no_packing,7,2) IN ('A0','B0','C0', 'A1','B1','C1') THEN 3
        WHEN substr(tsjd.no_packing,7,2) IN ('BP', 'BV', 'BH') THEN 5
        ELSE 0 END as jenis_packing,  CASE WHEN substr(tsjd.no_packing,7,2) IN ('BH') THEN 2 ELSE 1 END as ket
        from t_surat_jalan_detail tsjd
            where tsjd.t_sj_id =".$id."
        ) as a where jenis_packing != 0 group by jenis_packing, ket");
    }
    // Select tsjd.*, tsod.nama_barang_alias, COALESCE(tsod.nama_barang_alias, jb.jenis_barang,r.nama_item) as jenis_barang , COALESCE(jb.kode,r.kode_rongsok) as kode from t_surat_jalan_detail tsjd
    //         left join t_surat_jalan tsj on tsj.id = tsjd.t_sj_id
    //         left join t_sales_order_detail tsod on tsod.t_so_id = tsj.sales_order_id and (case when tsjd.jenis_barang_alias = 0 then tsod.jenis_barang_id = tsjd.jenis_barang_id else tsod.jenis_barang_id = tsjd.jenis_barang_alias end)
    //         left join jenis_barang jb on tsj.jenis_barang='FG' and (case when tsjd.jenis_barang_alias = 0 then jb.id = tsjd.jenis_barang_id else jb.id = tsjd.jenis_barang_alias end)
    //         left join rongsok r on tsj.jenis_barang='RONGSOK' and (case when tsjd.jenis_barang_alias = 0 then r.id = tsjd.jenis_barang_id else r.id = tsjd.jenis_barang_alias end)
    //         where tsj.jenis_barang='RONGSOK' and tsjd.id=149

}