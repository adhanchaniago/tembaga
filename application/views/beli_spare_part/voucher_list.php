<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h4 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Pembelian 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/BeliSparePart'); ?>"> Pembelian Spare Part </a> 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/BeliRongsok/voucher_list'); ?>"> Voucher List </a> 
        </h4>
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
    <div class="col-md-12">
        <?php
            if( ($group_id==1)||($hak_akses['voucher_list']==1) ){
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
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-beer"></i>Voucher List
                </div>
                <div class="tools">
                <a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" href="#form_filter" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="form_filter"><i class="fa fa-search"></i> Filter Tanggal</a>    
                <a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" href="<?=base_url();?>index.php/BeliSparePart/add_matching"> <i class="fa fa-plus"></i> Add Matching</a>
                </div>  
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Nomor Bukti</th> 
                    <th>Tanggal</th> 
                    <th>Jenis Voucher</th>  
                    <th>No. VK</th>
                    <th>Nama Supplier</th>
                    <th>Keterangan</th>
                    <th>Actions</th>
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
                        <td><?php echo ($this->session->userdata('user_ppn')==1) ? $data->nomor : $data->no_voucher; ?></td>
                        <td style="text-align:center"><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>
                        <td><?php echo $data->jenis_voucher; ?></td>
                        <td><?php echo $data->no_vk; ?></td>
                        <td><?php echo $data->nama_supplier; ?></td>
                        <td><?php echo $data->keterangan; ?></td>                        
                        <td style="text-align:center">     
                        <?php if($this->session->userdata('user_ppn')==1){
                            if(!isset($data->nomor)){
                            echo '<a class="btn btn-circle btn-xs blue" href="'.base_url().'index.php/BeliSparePart/matching_voucher/'.$data->id.'" style="margin-bottom:4px"> &nbsp; <i class="fa fa-pencil"></i> Edit &nbsp; </a>';
                            echo '<a class="btn btn-circle btn-xs red" href="'.base_url().'index.php/BeliSparePart/delete_matching_voucher/'.$data->id.'" style="margin-bottom:4px" onclick="return confirm(\'Anda yakin menghapus transaksi ini?\');"> &nbsp; <i class="fa fa-trash"></i> Hapus &nbsp; </a>';
                            }else{
                            echo '<a class="btn btn-circle btn-xs red" href="'.base_url().'index.php/BeliSparePart/delete_vk/'.$data->id.'" style="margin-bottom:4px" onclick="return confirm(\'Anda yakin menghapus transaksi ini?\');"> &nbsp; <i class="fa fa-trash"></i> Hapus &nbsp; </a>';
                            echo '<a class="btn btn-circle btn-xs blue-ebonyclay" target="_blank" href="'.base_url().'index.php/BeliSparePart/print_voucher/'.$data->id_fk.'" style="margin-bottom:4px"> &nbsp; <i class="fa fa-print"></i> Print &nbsp; </a>';
                            }
                        }else{
                        ?>
                        <a class="btn btn-circle btn-xs blue-ebonyclay" target="_blank" href="<?php echo base_url(); ?>index.php/BeliSparePart/print_voucher/<?php echo $data->id; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa fa-print"></i> Print &nbsp; </a>  <?php } ?>
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
    window.location = '<?=base_url();?>index.php/BeliSparePart/voucher_list/'+s+'/'+e;
}
</script>
       