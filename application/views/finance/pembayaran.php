<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h4 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Finance
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/Finance/pembayaran'); ?>"> Data Pembayaran </a>
        </h4>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12"> 
        <?php
            if( ($group_id==1)||($hak_akses['index']==1) ){
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success <?php echo (empty($this->session->flashdata('flash_msg'))? "display-hide": ""); ?>" id="box_msg_sukses">
                    <button class="close" data-close="alert"></button>
                    <span id="msg_sukses"><?php echo $this->session->flashdata('flash_msg'); ?></span>
                </div>
            </div>
        </div>
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
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-word-o"></i>Data Pembayaran
                </div> 
                <div class="tools">
                <a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" href="#form_filter" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="form_filter"><i class="fa fa-search"></i> Filter Tanggal</a> 
                <?php
                    if( ($group_id==1)||($hak_akses['add_pmb']==1) ){
                ?>
                <a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" href="<?=base_url();?>index.php/Finance/add_pembayaran"> <i class="fa fa-plus"></i> Input Pembayaran</a>
                <?php } ?>      
                </div>        
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>No. Pembayaran</th> 
                    <th>Tanggal</th> 
                    <th>Jmlh Voucher</th>
                    <th>Jmlh Cek</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 0;
                        foreach ($list_data as $data){
                            $no++;
                    ?>
                    <tr>
                        <td style="text-align:center"><?php echo $no; ?></td>
                        <td><?php echo $data->no_pembayaran; ?></td>
                        <td style="text-align:center"><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>
                        <td style="text-align:center"><?php echo $data->jumlah_voucher; ?></td>
                        <td style="text-align:center"><?php echo $data->jumlah_um; ?></td>
                        <td style="text-align:center">
                            <?php
                                if($data->status==0){
                                    echo '<div style="background-color:darkkhaki; padding:3px">Waiting Approval</div>';
                                }else if($data->status==1){
                                    echo '<div style="background-color:green; padding:3px; color:white">Approved</div>';
                                }else if($data->status==2){
                                    echo '<div style="background-color:blue; padding:3px; color:white">Dijalankan</div>';
                                }else if($data->status==3){
                                    echo '<div style="background-color:orange; padding:3px; color:white">Butuh Revisi</div>';
                                }else if($data->status==9){
                                    echo '<div style="background-color:red; color:#fff; padding:3px">Rejected</div>';
                                }
                            ?>
                        </td>
                        <td>
                        <?php
                            if( ($group_id==1)||($hak_akses['view_pmb']==1) ){
                        ?>
                            <a class="btn btn-circle btn-xs blue" href="<?php echo base_url(); ?>index.php/Finance/view_pmb/<?php echo $data->id; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa  fa-file-text-o"></i> View &nbsp; </a>
                        <?php } if($data->status==0 || $data->status==3){ ?>
                            <a class="btn btn-circle btn-xs green" href="<?php echo base_url(); ?>index.php/Finance/matching_pmb/<?php echo $data->id; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                            <?php if($data->jumlah_voucher == 0 && $data->jumlah_um == 0){ ?>
                            <a href="<?php echo base_url(); ?>index.php/Finance/delete_pmb/<?php echo $data->id; ?>" class="btn btn-circle btn-xs red" style="margin-bottom:4px" onclick="return confirm('Anda yakin menghapus transaksi ini?');"><i class="fa fa-trash-o"></i> Delete </a>
                            <?php } ?>
                        <?php } 
                                if( ($data->status == 1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/Finance/print_matching_pmb/<?php echo $data->id; ?>" 
                               class="btn btn-circle btn-xs blue-ebonyclay" style="margin-bottom:4px" target="_blank"><i class="fa fa-print"></i> Print &nbsp; </a> 
                            <?php }?>
                        </td>
                    </tr>
                    <?php
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
    window.location = '<?=base_url();?>index.php/Finance/pembayaran/'+s+'/'+e;
}
</script>         