<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h4 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Finance
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/Finance'); ?>"> Data Uang Masuk </a>
        </h4>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12"> 
        <?php
            if( ($group_id==1)||($hak_akses['view_pmb']==1) ){
        ?>
        <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">&nbsp;</h4>
                    </div>
                    <div class="modal-body">
                        <form class="eventInsForm" method="post" target="_self" name="frmReject" 
                              id="frmReject">                            
                            <div class="row">
                                <div class="col-md-4">
                                    Reject Remarks <font color="#f00">*</font>
                                </div>
                                <div class="col-md-8">
                                    <textarea id="reject_remarks" name="reject_remarks" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()" rows="3"></textarea>
                                    
                                    <input type="hidden" id="header_id" name="header_id">
                                </div>
                            </div>                           
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" onClick="rejectData();">Simpan</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <form class="eventInsForm" method="post" target="_self" name="formku" 
              id="formku">
            <div class="row">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            Nomor Pembayaran<font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_pmb" name="no_pmb" readonly="readonly"
                                class="form-control myline" style="margin-bottom:5px" 
                                value="<?php echo $header['no_pembayaran']; ?>">
                            <input type="hidden" id="id" name="id" value="<?php echo $header['id']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Tanggal <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="tanggal" name="tanggal" 
                                class="form-control input-small myline" style="margin-bottom:5px; float:left;" value="<?php echo date('d-m-Y', strtotime($header['tanggal'])); ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            PIC
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="nama_penimbang" name="nama_penimbang" 
                                class="form-control myline" style="margin-bottom:5px" readonly="readonly" 
                                value="<?php echo $header['realname']; ?>">
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                </div>
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            Catatan
                        </div>
                        <div class="col-md-8">
                            <textarea id="remarks" name="remarks" rows="2" onkeyup="this.value = this.value.toUpperCase()" class="form-control myline" style="margin-bottom:5px" readonly="readonly"><?php echo $header['keterangan'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            Status
                        </div>
                        <div class="col-md-8">
                        <?php if($header['status']==0){
                                    echo '<div style="background-color:darkkhaki; padding:3px;">Waiting Approval</div>';
                                }else if($header['status']==1){
                                    echo '<div style="background-color:green; padding:3px; color:white">Approved</div>';
                                }else if($header['status']==2){
                                    echo '<div style="background-color:blue; padding:3px; color:white">Dijalankan</div>';
                                }else if($header['status']==3){
                                    echo '<div style="background-color:orange; padding:3px; color:white">Butuh Revisi</div>';
                                }else if($header['status']==9){
                                    echo '<div style="background-color:red; color:#fff; padding:3px">Rejected</div>';
                                    echo '<textarea id="remarks" name="remarks" rows="2" onkeyup="this.value = this.value.toUpperCase()" class="form-control myline" style="margin-bottom:5px" readonly="readonly">'.$header['reject_remarks'].'</textarea>';
                                }
                        ?>
                        </div>
                    </div>    
                </div>       
            </div>
        <?php if($header['status']==1){ ?>
            <div class="row">
                <div class="col-md-12">
                    <a href="javascript:;" style="display: none;" class="btn blue" id="simpan_update" onclick="simpan_update();"> 
                        <i class="fa fa-check"></i> Simpan </a>
                    <a href="javascript:;" class="btn blue" id="edit_update" onclick="edit();"> 
                        <i class="fa fa-pencil"></i> Edit </a>
                </div>    
            </div>
        <?php } ?>
            <hr class="divider"/>
    <!-- VOUCHER -->
            <div class="row">
                <div class="col-md-12">
                    <h4 align="center" style="font-weight: bold;">Detail Voucher Pembayaran</h4>
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <th>No</th>
                                <th style="width: 20%;">Voucher ID</th>
                                <th>Jenis Voucher</th>
                                <th>Jenis Barang</th>
                                <th>Keterangan</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            <?php 
                                $no = 0;
                                $total_vc = 0;
                                foreach ($detailVC as $data){
                                    $no++;
                            ?>
                            <tr>
                                <td style="text-align:center"><?php echo $no; ?></td>
                                <td><?php echo $data->no_voucher; ?></td>
                                <td><?php echo $data->jenis_voucher; ?></td>
                                <td><?php echo $data->jenis_barang; ?></td>
                                <td><?php echo $data->keterangan; ?></td>
                                <td style="text-align:right"><?php echo number_format($data->amount,0,',','.'); ?></td>
                                <td>
                                <?php 
                                if($data->jenis_barang=='RONGSOK'){ ?>
                                    <a class="btn btn-circle btn-xs blue-ebonyclay" target="_blank" href="<?php echo base_url(); ?>index.php/BeliRongsok/print_voucher/<?php echo $data->id; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa  fa-print"></i> Print &nbsp; </a>
                                <?php }elseif($data->jenis_barang=='WIP'){ ?>
                                    <a class="btn btn-circle btn-xs blue-ebonyclay" target="_blank" href="<?php echo base_url(); ?>index.php/BeliWIP/print_voucher/<?php echo $data->id; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa  fa-print"></i> Print &nbsp; </a>
                                <?php }elseif($data->jenis_barang=='FG'){ ?>
                                    <a class="btn btn-circle btn-xs blue-ebonyclay" target="_blank" href="<?php echo base_url(); ?>index.php/BeliFinishGood/print_voucher/<?php echo $data->id; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa  fa-print"></i> Print &nbsp; </a>
                                <?php }else{ ?>
                                    <a class="btn btn-circle btn-xs blue-ebonyclay" target="_blank" href="<?php echo base_url(); ?>index.php/VoucherCost/print_voucher_kh/<?php echo $data->id; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa  fa-print"></i> Print &nbsp; </a>
                                <?php } ?>
                                </td>
                            </tr>
                            <?php
                                $total_vc += $data->amount;
                                }
                            ?>
                            <tr>
                                <td colspan="5" style="text-align: right; font-weight: bold;"> Total</td>
                                <td style="background-color: red; color: white;"><?php echo number_format($total_vc,0,',','.');?></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr class="divider"/>
    <!-- UANG MASUK -->
            <div class="row">
                <div class="col-md-12">
                    <h4 align="center" style="font-weight: bold;">Detail Voucher Uang Masuk</h4>
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <th>No</th>
                                <th>Jenis Pembayaran</th>
                                <th>Bank Pembayaran</th>
                                <th>Rekening Pembayaran / Nomor Cek</th>
                                <th>Keterangan</th>
                                <th>Amount</th>
                            </thead>
                            <tbody>
                            <?php 
                                $no = 0;
                                $total_um = 0;
                                foreach ($detailUM as $data){
                                    $no++;
                            ?>
                            <tr>
                                <td style="text-align:center"><?php echo $no; ?></td>
                                <td><?php echo $data->jenis_pembayaran; ?></td>
                                <td><?php echo $data->bank_pembayaran; ?></td>
                                <td><?php echo $data->rekening_pembayaran.$data->nomor_cek;?></td>
                                <td><?php echo $data->keterangan; ?></td>
                                <td style="text-align:right"><?php echo $data->currency.' '.number_format($data->nominal,0,',','.'); ?></td>
                            </tr>
                            <?php
                                $total_um += $data->nominal;
                                }
                            ?>
                            <tr>
                                <td colspan="5" style="text-align: right; font-weight: bold;"> Total</td>
                                <td style="background-color: green; color: white;"><?php echo number_format($total_um,0,',','.');?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    <!-- UANG KELUAR -->
            <div class="row">
                <div class="col-md-12">
                    <h4 align="center" style="font-weight: bold;">Detail Uang Keluar</h4>
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <th>No</th>
                                <th>Jenis Pembayaran</th>
                                <th>Bank Pembayaran</th>
                                <th>Rekening Pembayaran / Nomor Cek</th>
                                <th>Keterangan</th>
                                <th>Amount</th>
                            </thead>
                            <tbody>
                            <?php 
                                $no = 0;
                                $total_uk = 0;
                                foreach ($detailUK as $data){
                                    $no++;
                            ?>
                            <tr>
                                <td style="text-align:center"><?php echo $no; ?></td>
                                <td><?php echo $data->nomor; ?></td>
                                <td><?php echo $data->nama_bank; ?></td>
                                <td><?php echo $data->no_giro;?></td>
                                <td><?php echo $data->currency; ?></td>
                                <td style="text-align:right"><?php echo number_format($data->nominal,0,',','.'); ?></td>
                            </tr>
                            <?php
                                $total_uk += $data->nominal;
                                }
                            ?>
                            <tr>
                                <td colspan="5" style="text-align: right; font-weight: bold;"> Total</td>
                                <td style="background-color: green; color: white;"><?php echo number_format($total_uk,0,',','.');?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    <!-- SLIP SETORAN -->
            <hr class="divider"/>
            <div class="row">
                <div class="col-md-12">
                    <h4 align="center" style="font-weight: bold;">Slip Setoran</h4>
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <th><strong>Slip Setoran</strong></th>
                            <?php $slip_setoran = ($total_um + $total_uk) - $total_vc;?>
                                <th><?php echo number_format($slip_setoran,0,',','.');?></th>
                                <input type="hidden" id="nominal_slip" name="nominal_slip" value="<?php echo $slip_setoran;?>">
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span id="message">&nbsp;</span>
                    </div>
                </div>
            </div>
            <input type="hidden" id="total_voucher" value="<?=$total_vc;?>">
            <input type="hidden" id="total_um" value="<?=$total_um+$total_uk;?>">
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col-md-12">
            <?php if($header['status'] == 0){ ?>
                    <a href="javascript:;" class="btn green" onclick="jalankan();"> 
                        <i class="fa fa-check"></i> Jalankan </a>
            <?php } else if($header['status'] == 2) { ?>
                    <a href="javascript:;" class="btn green" id="approve" onclick="approveData();"> 
                        <i class="fa fa-check"></i> Approve </a>
                    <a href="javascript:;" class="btn red" onclick="showRejectBox();">
                        <i class="fa fa-ban"></i> Reject </a>
            <?php } else if($header['status'] == 1) { 
                if($cek_slip['id_kas']==0){?>
                    <a href="javascript:;" class="btn blue" onclick="open_pembayaran();">
                        <i class="fa fa-refresh"></i> Open Pembayaran </a>
            <?php 
                }
            } ?>
                    <a href="<?php echo base_url('index.php/Finance/pembayaran'); ?>" class="btn blue-hoki">
                        <i class="fa fa-angle-left"></i> Kembali </a>
                </div>    
            </div>
        </form>
        
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
<script>
function simpan_update(){
    if($.trim($("#no_pmb").val()) == ""){
        $('#message').html("Nomor harus diisi, tidak boleh kosong!");
        $('.alert-danger').show(); 
    }else if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show(); 
    }else{
        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Finance/save_pmb");
        $('#formku').submit(); 
    };
}

function edit(){
    $('#edit_update').hide();
    $('#no_pmb').prop('readonly', false);
    $('#tanggal').prop('readonly', false);
    $('#remarks').prop('readonly', false);
    $('#simpan_update').show();
}

function approveData(){
    var r=confirm("Anda yakin meng-approve permintaan barang ini?");
    if (r==true){
        $('#approve').text('Please Wait...');
        $('#approve').prop('disabled', true);
        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Finance/approve_pmb");    
        $('#formku').submit(); 
    }
}

function open_pembayaran(){
    var r=confirm("Anda yakin mem- buka kembali pembayaran ini?");
    if (r==true){
        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Finance/open_pmb");    
        $('#formku').submit(); 
    }
}

function jalankan(){
    if($('#total_voucher').val() == 0){
        $('#message').html("Voucher tidak Boleh Kosong");
        $('.alert-danger').show();
    }else if($('#total_um').val() == 0 && $('')){
        $('#message').html("Cek Masuk tidak Boleh Kosong");
        $('.alert-danger').show();
    }else if($('#nominal_slip').val() < 0){
        $('#message').html("Slip Setoran tidak boleh minus");
        $('.alert-danger').show();
    }else{
        var r=confirm("Anda yakin ingin menjalankan permintaan pembayaran ini?");
        if (r==true){
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Finance/jalankan_pmb");    
            $('#formku').submit(); 
        }
    }
}
//DIBAWAH CODINGAN FORM REJECT
function showRejectBox(){
    var r=confirm("Anda yakin me-reject permintaan pembayaran ini?");
    if (r==true){
        $('#header_id').val($('#id').val());
        $('#message').html("");
        $('.alert-danger').hide();
        
        $("#myModal").find('.modal-title').text('Reject Permintaan Pembayaran');
        $("#myModal").modal('show',{backdrop: 'true'}); 
    }
}

function rejectData(){
    if($.trim($("#reject_remarks").val()) == ""){
        $('#message').html("Reject remarks harus diisi, tidak boleh kosong!");
        $('.alert-danger').show(); 
    }else{
        $('#message').html("");
        $('.alert-danger').hide();
        $('#frmReject').attr("action", "<?php echo base_url(); ?>index.php/Finance/reject_pmb");
        $('#frmReject').submit(); 
    }
}
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
        dateFormat: 'dd-mm-yy'
    });
});
</script>