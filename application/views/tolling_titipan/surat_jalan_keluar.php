<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h5 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Tolling Titipan 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/surat_jalan_keluar'); ?>"> Surat Jalan Keluar </a> 
        </h5>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12"> 
        <?php
            if( ($group_id==1)||($hak_akses['surat_jalan']==1) ){
        ?>
        
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
                    <i class="fa fa-truck"></i>List Surat Jalan Keluar
                </div>  
                <div class="tools">    
                <?php
                    if( ($group_id==1)||($hak_akses['add_surat_jalan']==1) ){
                        echo '<a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" href="'.base_url('index.php/Tolling/add_surat_jalan_keluar').'"> '
                        .'<i class="fa fa-plus"></i> Input Surat Jalan Keluar</a>';
                    }
                ?>                    
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>No. Surat Jalan</th>
                    <th>Tanggal</th>
                    <th>No. PO</th>
                    <th>Jenis<br>Barang</th>                     
                    <th>Supplier</th> 
                    <th>Alamat</th> 
                    <th>Jumlah<br>Item</th>
                    <th>Kendaraan</th>
                    <th>Supir</th>
                    <th>Status<br>Surat Jalan</th>
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
                        <td style="text-align:center;"><?php echo $no; ?></td>
                        <td><?php echo $data->no_surat_jalan; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>
                        <td><?php echo $data->no_po;?></td>
                        <td><?php echo $data->jenis_barang; ?></td>
                        <td><?php echo $data->nama_supplier; ?></td>
                        <td><?php echo substr($data->alamat, 0, 10).' ...'; ?></td>  
                        <td><?php echo $data->jumlah_item; ?></td>  
                        <td><?php echo $data->no_kendaraan; ?></td>                         
                        <td><?php echo $data->supir; ?></td>
                        <td style="text-align:center">
                            <?php
                                if($data->status==0){
                                    echo '<div style="background-color:darkkhaki; padding:3px">Waiting Approval</div>';
                                }else if($data->status==1){
                                    echo '<div style="background-color:green; padding:3px; color:white">Approved</div>';
                                }else if($data->status==2){
                                    echo '<div style="background-color:green; color:#fff; padding:3px">Finished</div>';
                                }else if($data->status==9){
                                    echo '<div style="background-color:red; color:#fff; padding:3px">Rejected</div>';
                                }
                            ?>
                        </td>  
                        <td style="text-align:center"> 
                            <?php
                                if($group_id==1 || $hak_akses['print_surat_jalan']==1){
                                    if(($group_id==1 || $hak_akses['edit_surat_jalan']==1) && $data->status==9){
                            ?>
                            <a class="btn btn-circle btn-xs blue" href="<?php echo base_url(); ?>index.php/Tolling/edit_surat_jalan_keluar/<?php echo $data->id; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa  fa-pencil"></i> Edit &nbsp; </a>
                            <a class="btn btn-circle btn-xs red" href="<?php echo base_url(); ?>index.php/Tolling/delete_surat_jalan_keluar/<?php echo $data->id; ?>" onclick="return confirm('Anda yakin menghapus transaksi ini?');"
                                style="margin-bottom:4px"> &nbsp; <i class="fa fa-trash"></i> Delete &nbsp; </a>
                            <?php
                                }
                                if(($group_id==1 || $hak_akses['view_surat_jalan']==1) && $data->status != 9){
                            ?>
                            <a class="btn btn-circle btn-xs green" href="<?php echo base_url(); ?>index.php/Tolling/view_surat_jalan_keluar/<?php echo $data->id; ?>" 
                                style="margin-bottom:4px"> &nbsp; <i class="fa fa-book"></i> View &nbsp; </a>
                            <a class="btn btn-circle btn-xs blue-ebonyclay" href="<?php echo base_url(); ?>index.php/Tolling/print_surat_jalan/<?php echo $data->id; ?>" style="margin-bottom:4px" target="_blank"> &nbsp; <i class="fa fa-print"></i> Print &nbsp; </a>
                            <a class="btn btn-circle btn-xs red" href="<?php echo base_url(); ?>index.php/SalesOrder/revisi_surat_jalan/<?php echo $data->id; ?>" 
                                style="margin-bottom:4px"> &nbsp; <i class="fa fa-pencil"></i> Revisi &nbsp; </a>
                            <?php
                                    }
                                }
                            ?>
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
    window.setTimeout(function() { $(".alert-success").hide(); }, 4000);
});
</script>         