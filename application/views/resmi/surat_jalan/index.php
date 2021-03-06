<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h4 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Surat Jalan 
        </h4>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12"> 

        <?php
            if( ($group_id==9)||($hak_akses['index']==1) ){
        ?>
    <div class="collapse well" id="form_filter" >
        <form class="eventInsForm" method="post" target="_self" name="formku" 
        id="formku">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <input type="text" id="tgl_start" name="tgl_start" 
                                    class="form-control myline input-small" style="margin-bottom:5px;float:left;" 
                                    value="<?php echo date('Y-m-01'); ?>">
                            </div>
                            <div class="col-md-1">
                                S/D
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="tgl_end" name="tgl_end" 
                                    class="form-control myline input-small" style="margin-bottom:5px;float:left;" 
                                    value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-2">
                                &nbsp; &nbsp; <a href="javascript:;" onclick="filterData()" class="btn green"><i class="fa fa-search-plus"></i> Filter</a>        
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </form>
    </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success <?php echo (empty($this->session->flashdata('flash_msg'))? "display-hide": ""); ?>" id="box_msg_sukses">
                    <button class="close" data-close="alert"></button>
                    <span id="msg_sukses"><?php echo $this->session->flashdata('flash_msg'); ?></span>
                </div>
            </div>
        </div>
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-beer"></i>List Surat Jalan
                </div>
                <div class="tools">
                    <a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" href="#form_filter" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="form_filter"><i class="fa fa-search"></i> Filter Tanggal</a>  
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>No. Surat Jalan</th>
                    <th>No. SO / No. PO</th>
                    <th>Tanggal</th>
                    <th>Jenis<br>Barang</th>                     
                    <th>Customer</th>
                    <th>Jumlah<br>Item</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 1;
                        foreach ($list_sj as $row) {
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $no; ?></td>
                        <td><?php echo $row->no_sj_resmi; ?></td>
                        <td><?php echo $row->no_reff; ?></td>
                        <td><?php echo $row->tanggal; ?></td>
                        <td><?php echo $row->jenis_barang; ?></td>
                        <td><?php echo $row->nama_customer; ?></td>
                        <td><?php echo $row->jumlah_item; ?></td>
                        <td style="text-align: center;">
                            
                            <?php if($this->session->userdata('cv_id') != 0){ 
                                    if(($group_id==9)||($hak_akses['edit_surat_jalan']==1) && $row->reff_cv != 0){
                                ?>
                            <a class="btn btn-circle btn-xs green" href="<?php echo base_url(); ?>index.php/R_SuratJalan/edit_surat_jalan/<?php echo $row->id; ?>" 
                               style="margin-bottom:4px"> &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                            <?php } 
                            }else {
                                    if(($group_id==9)||($hak_akses['edit_surat_jalan']==1) && $row->reff_cv == 0){
                             ?>
                            <a class="btn btn-circle btn-xs green" href="<?php echo base_url(); ?>index.php/R_SuratJalan/edit_surat_jalan/<?php echo $row->id; ?>" 
                               style="margin-bottom:4px"> &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>

                            
                            <?php
                                } 
                            }if( ($group_id==9)||($hak_akses['view_surat_jalan']==1)){
                            ?>
                            <a class="btn btn-circle btn-xs blue" href="<?php echo base_url(); ?>index.php/R_SuratJalan/view_surat_jalan/<?php echo $row->id; ?>" 
                               style="margin-bottom:4px"> &nbsp; <i class="fa fa-file-text-o"></i> View &nbsp; </a>
                            <?php 
                                }if($group_id==9 || $hak_akses['print']==1){
                            ?><br>
                            <a class="btn btn-circle btn-xs blue-ebonyclay" href="<?php echo base_url(); ?>index.php/R_SuratJalan/print_surat_jalan/<?php echo $row->id; ?>" 
                                style="margin-bottom:4px" target="_blank"> &nbsp; <i class="fa fa-print"></i> Print &nbsp; </a>
                            <?php
                                }

                                if((($group_id==9) || ($group_id == 16 || $hak_akses['create_tolling']==1)) && ($row->flag_tolling==0 && $row->r_invoice_id > 0)){
                                    if(!empty($row->check_so_kmp)){
                            ?>
                                    <a class="btn btn-circle btn-xs red" href="<?php echo base_url(); ?>index.php/R_TollingResmi/add/<?php echo $row->id; ?>" 
                                        style="margin-bottom:4px"> &nbsp; <i class="fa fa-truck"></i> Create Tolling &nbsp; </a>
                            <?php }else{
                                    echo '*SO KMP belum dibuat';
                                }
                            }
                            if(($group_id==9 || $hak_akses['create_invoice_jasa']) && ($row->flag_tolling==0 && ($row->r_so_id == 0 || $row->r_po_id == 0) && $row->r_inv_jasa_id == 0) && $row->jenis_barang == 'FG' && $row->r_sj_id == 0){ ?>
                            <a class="btn btn-circle btn-xs red" href="<?php echo base_url(); ?>index.php/R_InvoiceJasa/add/<?php echo $row->id; ?>" 
                                style="margin-bottom:4px"> &nbsp; <i class="fa fa-truck"></i> Create Invoice Jasa &nbsp; </a>
                            <?php }if(($group_id==9 || $hak_akses['create_invoice_jasa']) && ($row->flag_tolling==0 && ($row->r_so_id > 0 && $row->r_po_id > 0) && $row->r_inv_jasa_id == 0) && $row->jenis_barang == 'FG' && $row->r_sj_id != 0){ ?>
                            <a class="btn btn-circle btn-xs red" href="<?php echo base_url(); ?>index.php/R_InvoiceJasa/add_inv_cust/<?php echo $row->id; ?>" 
                                style="margin-bottom:4px"> &nbsp; <i class="fa fa-truck"></i> Create Invoice Jasa&nbsp; </a>
                            <a href="<?php echo base_url(); ?>index.php/R_SuratJalan/delete_inv_cust/<?php echo $row->id; ?>" class="btn btn-circle btn-xs red" style="margin-bottom:4px" onclick="return confirm('Anda yakin menghapus transaksi ini?');">
                                <i class="fa fa-trash-o"></i> Delete 
                            </a>
                            <?php }if($group_id==9 && ($row->jenis_surat_jalan == 'SURAT JALAN CUSTOMER KE CV' && $row->r_invoice_id > 0 && $row->flag_sj_cv == 0)){
                            ?>
                            <a class="btn btn-circle btn-xs red" href="<?php echo base_url(); ?>index.php/R_SuratJalan/add_surat_jalan/sj_cv/<?php echo $row->id; ?>" 
                                style="margin-bottom:4px"> &nbsp; <i class="fa fa-truck"></i> Create Surat Jalan CV &nbsp; </a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                            $no++;
                        }
                    ?>                                                                            
                </tbody>
                </table>
            </div>
        </div>
        <?php
            }else{
        ?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span id="message">Anda tidak memiliki hak akses ke halaman ini!</span>
        </div>
        <?php
            }
        ?>
    </div>
</div> 
<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script> 
<script>
$(function(){
    $("#tgl_start").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url(); ?>img/Kalender.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });        
    $("#tgl_end").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url(); ?>img/Kalender.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });    
  window.setTimeout(function() { $(".alert-success").hide(); }, 4000);
});
function filterData(){
    var s=$('#tgl_start').val();
    var e=$('#tgl_end').val();
    <?php if($this->uri->segment(2)=='fg'){ 
        echo "window.location = '".base_url()."index.php/R_SuratJalan/fg/'+s+'/'+e;";
    }else{
        echo "window.location = '".base_url()."index.php/R_SuratJalan/index/'+s+'/'+e;";     
    }?>
}
</script>