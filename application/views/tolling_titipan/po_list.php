<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h5 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Tolling 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/Tolling/po_list'); ?>"> PO List Tolling </a> 
        </h5>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12"> 
        <?php
            if( ($group_id==1)||($hak_akses['po_list']==1) ){
        
        if($this->session->userdata('user_ppn')==1){?>
        <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">&nbsp;</h4>
                    </div>
                    <div class="modal-body">
                        <form class="eventInsForm" method="post" target="_self" name="formku" 
                              id="formku">                            
                            <input type="hidden" id="status_vc" name="status_vc">
                            <div class="row">
                                <div class="col-md-5">
                                    No. Voucher <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_voucher" name="no_voucher" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly" value="Auto Generate">
                                    
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>                             
                            <div class="row">
                                <div class="col-md-5">
                                    Tanggal <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="tanggal" name="tanggal" 
                                        class="form-control myline input-small" style="margin-bottom:5px;float:left;" 
                                        value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Jenis Barang
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="jenis_barang" name="jenis_barang" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly" value="RONGSOK">                                                                       
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    No. PO
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_po" name="no_po" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">                                                                       
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Tanggal PO
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="tanggal_po" name="tanggal_po" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">                                                                       
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Supplier
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_supplier" name="nama_supplier" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">         
                                    <input type="hidden" name="supplier_id" id="supplier_id">                                                 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Diskon(Rp)
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="diskon" name="diskon" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">      
                                </div>
                                <div class="col-md-3">
                                    Materai(Rp)
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="materai" name="materai" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">      
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nilai Sebelum PPN (Rp) <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nilai_before_ppn" name="nilai_before_ppn" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">                                                                       
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nilai PPN
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nilai_ppn" name="nilai_ppn" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">      
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nilai PO (Rp) <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nilai_po" name="nilai_po" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">                                                                       
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Currency <font color="#f00">*</font>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="currency_po" name="currency_po" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">                                                                       
                                </div>
                                <div class="col-md-2">
                                    Kurs <font color="#f00">*</font>     
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="kurs_po" name="kurs_po" class="form-control myline" style="margin-bottom:5px" readonly="readonly">           
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-5">
                                    Terbilang
                                </div>
                                <div class="col-md-7">
                                    <textarea id="terbilang" name="terbilang" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly"></textarea>                                                 
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-md-5">
                                    Total Pembayaran Sebelumnya (Rp) <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nilai_dp" name="jumlah_dibayar" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">                                                                       
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger display-hide" id="box_error_voucher">
                                        <button class="close" data-close="alert"></button>
                                        <span id="msg_voucher">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            <div style="width: 100%; margin-bottom: 5px;text-align: center">
                              <span>
                                Data Uang Keluar <!--Padding is optional-->
                              </span>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nomor Uang Keluar
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_uk" name="no_uk" class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nomor Giro
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nomor_giro" name="nomor_giro" 
                                        class="form-control myline" style="margin-bottom:5px">   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Bank
                                </div>
                                <div class="col-md-7">
                                    <select id="bank_id" name="bank_id" class="form-control myline select2me"
                                    data-placeholder="Silahkan pilih..." style="margin-bottom:5px" onchange="get_currency(this.value)">
                                    <option value=""></option>
                                    <?php
                                        foreach ($bank_list as $row){
                                            echo '<option value="'.$row->id.'">'.$row->kode_bank.' ('.$row->nomor_rekening.')</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Tanggal Jatuh Tempo
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="tanggal_jatuh" name="tanggal_jatuh" 
                                        class="form-control myline input-small" style="margin-bottom:5px;float:left;" 
                                        value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-3">
                                    Currency
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="currency" name="currency" class="form-control myline" style="margin-bottom:5px" readonly="readonly">           
                                </div>
                                <div class="col-md-3">
                                    Kurs
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="kurs" name="kurs" class="form-control myline" style="margin-bottom:5px" readonly="readonly">           
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Jumlah Bayar (Rp) <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="amount" name="amount" 
                                        class="form-control myline" style="margin-bottom:5px" onkeyup="getComa(this.value, this.id);">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Keterangan
                                </div>
                                <div class="col-md-7">
                                    <textarea id="keterangan" name="keterangan" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()" rows="3"></textarea>           
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" id="prosesVoucher" onClick="prosesVoucher();">Simpan</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <?php }else{ ?>
        <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">&nbsp;</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button>
                                    <span id="message">&nbsp;</span>
                                </div>
                            </div>
                        </div>
                        <form class="eventInsForm" method="post" target="_self" name="formku" 
                              id="formku">                      
                            <input type="hidden" id="status_vc" name="status_vc">      
                            <div class="row">
                                <div class="col-md-5">
                                    No. Voucher <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_voucher" name="no_voucher" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly" value="Auto Generate">
                                    
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>                             
                            <div class="row">
                                <div class="col-md-5">
                                    Tanggal <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="tanggal" name="tanggal" class="form-control myline input-small" style="margin-bottom:5px;float:left;" value="<?php echo date('d-m-Y'); ?>">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Jenis Barang
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="jenis_barang" name="jenis_barang" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly" value="RONGSOK">                                                                       
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    No. PO
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_po" name="no_po" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">                                                                       
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Tanggal PO
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="tanggal_po" name="tanggal_po" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">                                                                       
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Supplier
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_supplier" name="nama_supplier" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">  
                                    <input type="hidden" name="supplier_id" id="supplier_id">                                                                 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Total Nilai PO (Rp) <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input id="nilai_po" name="nilai_po" class="form-control myline" style="margin-bottom:5px" readonly="readonly" type="text">                                                                       
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Terbilang
                                </div>
                                <div class="col-md-7">
                                    <textarea id="terbilang" name="terbilang" class="form-control myline" style="margin-bottom: 5px;" readonly></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Total Voucher DP (Rp) <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input id="nilai_dp" name="nilai_dp" class="form-control myline" style="margin-bottom:5px" readonly="readonly" type="text"> 
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Amount <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="amount" name="amount" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeydown="return myCurrency(event);" onkeyup="getComa(this.value, this.id);">           
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Keterangan
                                </div>
                                <div class="col-md-7">
                                    <textarea id="keterangan" name="keterangan" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()" rows="3"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" id="saveVoucher" onClick="saveVoucher();">Simpan</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div> 
        <?php } ?>      
        
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success <?php echo (empty($this->session->flashdata('flash_msg'))? "display-hide": ""); ?>" id="box_msg_sukses">
                    <button class="close" data-close="alert"></button>
                    <span id="msg_sukses"><?php echo $this->session->flashdata('flash_msg'); ?></span>
                </div>
            </div>
        </div>
        <div class="collapse well" id="form_filter" border="1">
            <form class="eventInsForm" method="post" target="_self" name="filter" 
            id="filter">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                Dari Tanggal
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="tgl_start" name="tgl_start" class="form-control myline input-small" style="margin-bottom:5px;float:left;" value="<?= date('d-m-Y');?>">  
                            </div>
                            <div class="col-md-1" style="margin-bottom: 5px;">S/D</div>
                            <div class="col-md-3">
                                <input type="text" id="tgl_end" name="tgl_end" class="form-control myline input-small" style="margin-bottom:5px;float:left;" value="<?= date('d-m-Y');?>">  
                            </div>
                            <div class="col-md-3">
                                &nbsp; &nbsp; <a href="javascript:;" onclick="filterData()" class="btn green"><i class="fa fa-search-plus"></i> Filter</a>        
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-beer"></i>Purchase Order List
                </div>
                <div class="tools">
                <!-- <a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" href="#form_filter" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="form_filter"><i class="fa fa-search"></i> Filter Tanggal</a> -->
                <!-- <a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" href="<?=base_url();?>index.php/BeliRongsok/po_list_outdated"> <i class="fa fa-minus"></i> PO LIST OUTDATED</a> -->
                <?php
                    if( ($group_id==1)||($hak_akses['add']==1) ){
                        echo '<a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" href="'.base_url('index.php/Tolling/add_po').'"><i class="fa fa-plus"></i> Input PO </a>';
                    }
                ?>                    
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>No. PO</th>
                    <th>Tanggal</th>
                    <th>Supplier</th> 
                    <th>Jenis PO</th>
                    <th>PPN</th> 
                    <th>Jumlah <br>Items</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Voucher<br>Pembayaran</th>
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
                        <td><?php echo $data->no_po; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>
                        <td><?php echo $data->nama_supplier; ?></td>
                        <td><?php echo $data->jenis_po; ?></td>
                        <?php 
                           echo (($data->ppn==1)? '<td><i class="fa fa-check"></i> Yes</td>': '<td><i class="fa fa-times"></i> No</td>');
                        ?>
                        <td style="text-align:center"><?php echo $data->jumlah_item; ?></td>
                        <td style="text-align:center">
                            <?php 
                                if($data->status==0){ 
                                    echo '<div style="background-color:bisque; padding:4px">Draft</div>';
                                }else if($data->status==1){ 
                                    echo '<div style="background-color:green; color:white; padding:4px">Closed</div>';
                                }else if($data->status==2){ 
                                    echo '<div style="background-color:yellow; padding:4px;">Processing</div>';
                                }else if($data->status==3){
                                    echo '<div style="background-color:powderblue; padding:4px;">Waiting Voucher</div>';
                                }else if($data->status==4){
                                    echo '<div style="background-color:limegreen; padding:4px; font-weight: bold;">Sudah Dibayar</div>';
                                }
                            ?>
                        </td>
                        <td><?php echo $data->remarks; ?></td>
                        <td style="text-align:center">
                            <?php
                                if($data->tot_voucher>0){print('Ada <b>'.$data->tot_voucher.'</b> Voucher<br/>');}
                                if( ($group_id==1 || $hak_akses['create_voucher_dp']==1) && $data->flag_pelunasan==0 && ($data->status!=1 || $data->status!=4)){
                                    if($data->jenis_po=='Rongsok'){
                                        echo '<a class="btn btn-circle btn-xs green" href="javascript:;" onclick="createVoucherRsk('.$data->id.');" style="margin-bottom:4px"> &nbsp; <i class="fa fa-pencil-square-o"></i> Create &nbsp; </a>';
                                    }else{
                                        echo '<a class="btn btn-circle btn-xs green" href="javascript:;" onclick="createVoucher('.$data->id.');"
                                        style="margin-bottom:4px"> &nbsp; <i class="fa fa-pencil-square-o"></i> Create &nbsp; </a>';
                                    }
                                }
                                if($data->status==4 || $data->status==1){
                                    echo '<small style="color:green"><i>Sudah Lunas</i></small>';
                                }
                            ?>
                        </td>
                        <td style="text-align:center"> 
                            <?php
                                if( ($group_id==1 || $hak_akses['edit']==1) && $data->status != 1 ){
                            ?>
                            <a class="btn btn-circle btn-xs green" href="<?php echo base_url(); ?>index.php/Tolling/edit_po/<?php echo $data->id; ?>" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                            <?php
                                }
                                if(($group_id==1 || $hak_akses['delete_so']==1) && $data->status == 0){
                            ?>
                            <a class="btn btn-circle btn-xs red" href="<?php echo base_url(); ?>index.php/Tolling/delete_po/<?php echo $data->id; ?>" style="margin-bottom:4px" onclick="return confirm('Anda yakin menghapus transaksi ini?');">&nbsp; <i class="fa fa-trash"></i> Delete &nbsp; </a>
                            <?php
                                }
                                if($group_id==1 || $hak_akses['print_po']==1){
                                    if($data->jenis_po=='Rongsok'){
                            ?>
                            <a class="btn btn-circle btn-xs blue-ebonyclay" href="<?php echo base_url(); ?>index.php/BeliRongsok/print_po/<?php echo $data->id; ?>" style="margin-bottom:4px" target="_blank"> &nbsp; <i class="fa fa-print"></i> Print &nbsp; </a>
                                <?php }else{ ?>
                            <a class="btn btn-circle btn-xs blue-ebonyclay" href="<?php echo base_url(); ?>index.php/BeliFinishGood/print_po/<?php echo $data->id; ?>" style="margin-bottom:4px" target="_blank"> &nbsp; <i class="fa fa-print"></i> Print &nbsp; </a>
                            <?php
                                    }
                                }
                                echo '<a class="btn btn-circle btn-xs red" href="'.base_url().'index.php/Tolling/print_balance_sp/'.$data->id.'" target="_blank" style="margin-bottom:4px"> &nbsp; <i class="fa fa-arrows-h"></i> Cek Balance &nbsp; </a>'
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
function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 95 || charCode > 105))
        return false;
    return true;
}

function getComa(value, id){
    angka = value.toString().replace(/\,/g, "");
    $('#'+id).val(angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}

function get_currency(id){
    if(id > 0){
        $.ajax({
            url: "<?php echo base_url('index.php/Finance/get_currency'); ?>",
            type: "POST",
            data: "id="+id,
            dataType: "json",
            success: function(result) {
                $('#currency').val(result['currency']);
                if(result['currency']=='IDR'){
                    $('#kurs').prop('readonly', true);
                    $('#kurs').val(1);
                }else{
                    $('#kurs').prop('readonly', false);
                    $('#kurs').val(1);
                }
            }
        });
    }else{
        $('#currency').val('IDR');
    }
}

function createVoucherRsk(id){
    $.ajax({
        url: "<?php echo base_url('index.php/BeliRongsok/create_voucher'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            $('#no_po').val(result['no_po']);
            $('#tanggal_po').val(result['tanggal']);
            $('#nama_supplier').val(result['nama_supplier']);
            $('#supplier_id').val(result['supplier_id']);
            $('#diskon').val(result['diskon']);
            $('#materai').val(result['materai']);
            $('#amount').val('0');
            $('#nilai_po').val(result['nilai_po']);
            // $('#terbilang').val(result['terbilang']);
            $('#jenis_barang').val(result['jenis_po']);
            $('#nilai_dp').val(result['nilai_dp']);
            $('#nilai_ppn').val(result['nilai_ppn']);
            $('#nilai_before_ppn').val(result['nilai_before_ppn']);
            $('#currency_po').val(result['currency']);
            $('#kurs_po').val(result['kurs']);
            $('#amount').val(result['sisa']);
            $('#keterangan').val('');
            $('#status_vc').val(result['status']);
            $('#id').val(result['id']);
            
            $('#message').html("");
            $('.alert-danger').hide(); 
            
            $("#myModal").find('.modal-title').text('Create Voucher');
            $("#myModal").modal('show',{backdrop: 'true'});
        }
    });
}

function createVoucher(id){
    $.ajax({
        url: "<?php echo base_url('index.php/Tolling/create_voucher'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            $('#no_po').val(result['no_po']);
            $('#tanggal_po').val(result['tanggal']);
            $('#nama_supplier').val(result['nama_supplier']);
            $('#supplier_id').val(result['supplier_id']);
            $('#diskon').val(result['diskon']);
            $('#materai').val(result['materai']);
            $('#amount').val('0');
            $('#nilai_po').val(result['nilai_po']);
            // $('#terbilang').val(result['terbilang']);
            $('#jenis_barang').val(result['jenis_po']);
            $('#nilai_dp').val(result['nilai_dp']);
            $('#nilai_ppn').val(result['nilai_ppn']);
            $('#nilai_before_ppn').val(result['nilai_before_ppn']);
            $('#currency_po').val(result['currency']);
            $('#kurs_po').val(result['kurs']);
            $('#amount').val(result['sisa']);
            $('#keterangan').val('');
            $('#status_vc').val(result['status']);
            $('#id').val(result['id']);
            
            $('#message').html("");
            $('.alert-danger').hide(); 
            
            $("#myModal").find('.modal-title').text('Create Voucher');
            $("#myModal").modal('show',{backdrop: 'true'});
        }
    });
}

function saveVoucher(){
    if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show(); 
    }else if($.trim($("#amount").val()) == "" || $("#amount").val()=="0"){
        $('#message').html("Amount harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();
    }else{    
        $('#message').html("");
        $('.alert-danger').hide();
        $('#saveVoucher').text('Please Wait ...').prop("onclick", null).off("click");
        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Tolling/save_voucher");
        $('#formku').submit(); 
    };
};

function prosesVoucher(){
    if($.trim($("#no_uk").val()) == ""){
        $('#msg_voucher').html("Nomor Uang Keluar harus diisi, tidak boleh kosong!");
        $('#box_error_voucher').show(); 
    }else if($.trim($("#tanggal").val()) == ""){
        $('#msg_voucher').html("Tanggal harus diisi, tidak boleh kosong!");
        $('#box_error_voucher').show(); 
    }else if($.trim($("#amount").val()) == "" || $("#amount").val()=="0"){
        $('#msg_voucher').html("Amount harus diisi, tidak boleh kosong!");
        $('#box_error_voucher').show();
    }else if($.trim($("#bank_id").val()) == ""){
        $('#msg_voucher').html("Bank harus dipilih!");
        $('#box_error_voucher').show();
    }else{    
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('index.php/BeliRongsok/get_no_uang_keluar'); ?>",
            data: {
                no_uk: $('#no_uk').val(),
                tanggal: $('#tanggal').val(),
                bank_id: $('#bank_id').val()
            },
            cache: false,
            success: function(result) {
                var res = result['type'];
                if(res=='duplicate'){
                    $('#msg_voucher').html("Nomor Uang Keluar sudah ada, tolong coba lagi!");
                    $('#box_error_voucher').show();
                }else{
                    $('#prosesVoucher').text('Please Wait ...').prop("onclick", null).off("click");
                    $('#msg_voucher').html("");
                    $('#box_error_voucher').hide();
                    $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Tolling/save_voucher_pembayaran");
                    $('#formku').submit(); 
                }
            }
        });
    };
};
</script>
<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$(function(){   
    $("#tanggal").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url(); ?>img/Kalender.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    }); 
    
    $("#tanggal_jatuh").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url(); ?>img/Kalender.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    }); 

    $("#tgl_start").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url(); ?>img/Kalender.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy'
    }); 
    
    $("#tgl_end").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url(); ?>img/Kalender.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy'
    }); 

    window.setTimeout(function() { $(".alert-success").hide(); }, 4000);
});
</script>