<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h5 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Pengiriman
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/PengirimanSample'); ?>"> Pengiriman Sample </a> 
        </h5>          
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
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-truck"></i>Request Sample List
                </div>  
                <div class="tools">    
                <?php
                    if( ($group_id==1)||($hak_akses['add']==1) ){
                        echo '<a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" href="'.base_url('index.php/PengirimanSample/add').'"> '
                        .'<i class="fa fa-plus"></i> Input Request Sample </a>';
                    }
                ?>                    
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>No. Request</th>
                    <th>Tanggal</th>
                    <th>Customer</th> 
                    <th>PIC</th> 
                    <th>Marketing</th>
                    <th>Jumlah <br>Items</th>
                    <th>Status</th>
                    <th>Disetujui/<br>Direject Oleh</th>
                    <th>SKB</th>
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
                        <td><?php echo $data->no_request; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>
                        <td><?php echo $data->nama_customer; ?></td>
                        <td><?php echo $data->pic; ?></td>
                        <td><?php echo $data->nama_marketing; ?></td>
                        <td style="text-align:center"><?php echo $data->jumlah_item; ?></td>   
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
                                if($data->status<9){
                                    echo $data->approved_name; 
                                }else{
                                    echo $data->reject_name;
                                }
                            ?> 
                        </td>
                        <td style="text-align:center">
                            <?php
                                if( ($group_id==1 || $hak_akses['create_dtr']==1) && $data->ready_to_skb>0 && $data->status==1){
                                    echo '<a class="btn btn-circle btn-xs green-seagreen" href="'.base_url().'index.php/PengirimanSample/create_skb/'.$data->id.'" 
                                        style="margin-bottom:4px"> &nbsp; <i class="fa fa-pencil-square-o"></i> Create &nbsp; </a>';
                                }
                            ?>
                        </td>
                        <td style="text-align:center"> 
                            <?php
                                if(($group_id==1 || $hak_akses['edit']==1) && ($data->status==0 || $data->status==9)){
                            ?>
                            <a class="btn btn-circle btn-xs green" href="<?php echo base_url(); ?>index.php/PengirimanSample/edit/<?php echo $data->id; ?>" 
                               style="margin-bottom:4px"> &nbsp; <i class="fa  fa-pencil"></i> Edit &nbsp; </a>
                            <?php
                                }
                                if($group_id==1 || $hak_akses['view_rs']==1){
                            ?>
                            <a class="btn btn-circle btn-xs blue-ebonyclay" href="<?php echo base_url(); ?>index.php/PengirimanSample/view_rs/<?php echo $data->id; ?>" 
                               style="margin-bottom:4px"> &nbsp; <i class="fa  fa-file-text-o"></i> View &nbsp; </a>
                            <?php   
                                }
                                if($group_id==1 || $hak_akses['print_rs']==1){
                            ?>
                            <a class="btn btn-circle btn-xs blue-ebonyclay" href="<?php echo base_url(); ?>index.php/PengirimanSample/print_rs/<?php echo $data->id; ?>" 
                                style="margin-bottom:4px" target="_blank"> &nbsp; <i class="fa fa-print"></i> Print &nbsp; </a>
                                
                            <?php
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