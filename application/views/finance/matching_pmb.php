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
            if( ($group_id==1)||($hak_akses['add_pmb']==1) ){
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
                            <input type="text" id="no_pmb" name="no_pmb" class="form-control myline" style="margin-bottom:5px" 
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
                                class="form-control input-small myline" style="margin-bottom:5px; float:left;" value="<?php echo date('d-m-Y', strtotime($header['tanggal'])); ?>">
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
                            <textarea id="remarks" name="remarks" rows="2" onkeyup="this.value = this.value.toUpperCase()"
                                class="form-control myline" style="margin-bottom:5px"><?php echo $header['keterangan']; ?></textarea>                           
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
                                }
                        ?>
                        </div>
                    </div>
                </div>
                <?php if($header['status']==3){ ?>
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            Reject Remarks
                        </div>
                        <div class="col-md-8">
                            <textarea id="reject_remarks" name="reject_remarks" rows="2" onkeyup="this.value = this.value.toUpperCase()" class="form-control myline" style="margin-bottom:5px" readonly="readonly"><?php echo $header['reject_remarks']; ?></textarea>                           
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span id="message">&nbsp;</span>
                </div>
            </div>
        </div>
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
                                <th>Amount</th>
                                <th>Keterangan</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                <tbody id="boxDetailVoucher">

                                </tbody>
                            <tr>
                                <td style="text-align:center"><i class="fa fa-plus"></i></td>
                                <td colspan="2">
                                    <select id="vc_id" name="vc_id" class="form-control select2me myline"  style="margin-bottom:5px;" onchange="get_data_vc(this.value);">
                                    </select>
                                </td>
                                <td><input type="text" id="jenis_voucher" name="jenis_voucher" class="form-control myline" readonly="readonly"></td>
                                <td><input type="text" id="jenis_barang" name="jenis_barang" class="form-control myline" readonly="readonly"></td>
                                <td><input type="text" id="amount_vc" name="amount_vc" class="form-control myline" readonly="readonly"/></td>    
                                <td style="text-align:center"><a href="javascript:;" class="btn btn-xs btn-circle yellow-gold" onclick="saveDetail_vc();" style="margin-top:5px" id="btnSaveDetail"><i class="fa fa-plus"></i> Tambah </a></td>
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
                    <h4 align="center" style="font-weight: bold;">Detail Voucher Cek Masuk</h4>
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <th>No</th>
                                <th width="25%">No. Cek Masuk</th>
                                <th>Jenis Pembayaran</th>
                                <th>Bank Pembayaran</th>
                                <th>Nomor Cek/Rekening</th>
                                <th>Status UM</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </thead>
                            <tbody id="boxDetailUm">

                            </tbody>
                            <tr>
                                <td style="text-align:center"><i class="fa fa-plus"></i></td>
                                <td>
                                    <select id="um_id" name="um_id" class="form-control select2me myline"  style="margin-bottom:5px;" onchange="get_data_um(this.value);">
                                    </select>
                                    <input type="hidden" id="id_um" name="id_um">
                                </td>
                                <td><input type="text" id="jenis_pembayaran" name="jenis_voucher" class="form-control myline" readonly="readonly"></td>
                                <td><input type="text" id="bank_pembayaran" name="bank_pembayaran" class="form-control myline" readonly="readonly"></td>
                                <td><input type="text" id="nomor" name="nomor" class="form-control myline" readonly="readonly"></td>
                                <td colspan="2"><input type="text" id="amount_um" name="amount_um" class="form-control myline" readonly="readonly"/></td>
                                <td style="text-align:center"><a href="javascript:;" class="btn btn-xs btn-circle yellow-gold" onclick="saveDetail_um();" style="margin-top:7px" id="btnSaveDetail_um"> <i class="fa fa-plus"></i> Tambah </a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
    <!-- BANK -->
            <div class="row">
                <div class="col-md-12">
                    <h4 align="center" style="font-weight: bold;">Detail Uang Keluar</h4>
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <th>No</th>
                                <th>No. Uang Keluar</th>
                                <th>Bank</th>
                                <th>Nomor Giro</th>
                                <th>Currency</th>
                                <th>Nominal</th>
                                <th>Actions</th>
                            </thead>
                            <tbody id="boxDetailUK">

                            </tbody>
                            <div id="add_uk">
                            <tr>
                                <td style="text-align:center"><i class="fa fa-plus"></i></td>
                                <td><input type="text" id="no_uk" name="no_uk" class="form-control myline" placeholder="Nomor Uang Keluar ..."></td>
                                <td>
                                    <select id="bank_id" name="bank_id" class="form-control myline select2me" 
                                    data-placeholder="Silahkan pilih..." style="margin-bottom:5px" onchange="get_currency(this.value);">
                                    <option></option>
                                    <?php
                                        foreach ($bank_list as $row){
                                            echo '<option value="'.$row->id.'">'.$row->kode_bank.' ('.$row->nomor_rekening.')'.'</option>';
                                        }
                                    ?>
                                    </select>
                                </td>
                                <td><input type="text" id="nomor_giro" name="nomor_giro" class="form-control myline"></td>
                                <td><input type="type" id="currency" name="currency" class="form-control myline" readonly="readonly"></td>
                                <td><input type="text" id="nominal" name="nominal" class="form-control myline" style="margin-bottom:5px" 
                                        onkeydown="return myCurrency(event);" onkeyup="getComa(this.value, this.id);"></td>
                                <td style="text-align:center"><a href="javascript:;" class="btn btn-xs btn-circle yellow-gold" onclick="saveDetail_uk();" style="margin-top:7px" id="btnSaveDetail_uk"> <i class="fa fa-plus"></i> Tambah </a></td>
                            </tr>
                            </div>
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
                                <th><input type="text" id="slip_setoran" name="slip_setoran" class="form-control" readonly="readonly"></th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col-md-12">
                    <a href="javascript:;" class="btn green" onclick="simpanData();"> 
                        <i class="fa fa-floppy-o"></i> Simpan </a>
                <?php if($header['status']==3){ ?>
                    <a href="javascript:;" class="btn green" onclick="approveAgain();"> 
                        <i class="fa fa-check"></i> Approve Again </a>
                    <a href="javascript:;" class="btn red" onclick="showRejectBox();">
                        <i class="fa fa-ban"></i> Reject All </a>
                <?php } ?>
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
var myRequest;
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 95 || charCode > 105))
        return false;
    return true;
}

function getComa(value, id){
    angka = value.toString().replace(/\./g, "");
    $('#'+id).val(angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}

function approveAgain(){
    var r=confirm("Anda yakin meng-approve kembali permintaan barang ini?");
    if (r==true){
        if($("#tag").length){
            $('#message').html("Masih ada uang masuk yang harus di ganti !");
            $('.alert-danger').show();
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Finance/approveagain");
            $('#formku').submit();
        };
    }
}

function simpanData(){
    const slip =($('#slip_setoran').val().toString().replace(/\./g, ''));
    if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();
    }else if(Number(slip) < 0){
        $('#message').html("Slip setoran tidak boleh minus!");
        $('.alert-danger').show();
    }else{
        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Finance/save_pmb");  
        $('#formku').submit(); 
    };
};
function slipSetoran(){
    var total_vc = $('#total_vc').data("myvalue");
    var total_um = $('#total_um').data("myvalue");
    var total_uk = $('#total_uk').data("myvalue");
    var total = ((total_um + total_uk) - total_vc);
    $('#slip_setoran').val(numberWithCommas(total));
}

function load_vc(){
    $.ajax({
        url: "<?php echo base_url('index.php/Finance/get_vc_list'); ?>",
        async: false,
        type: "POST",
        dataType: "html",
        success: function(result) {
            $('#vc_id').html(result);
        }
    })
}

function get_data_vc(id){
    if(''!=id){
        $.ajax({
            url: "<?php echo base_url('index.php/Finance/get_data_voucher'); ?>",
            async: false,
            type: "POST",
            data: "id="+id,
            dataType: "json",
            success: function(result) {
                $('#jenis_voucher').val(result['jenis_voucher']);
                $('#jenis_barang').val(result['jenis_barang']);
                $('#amount_vc').val(numberWithCommas(result['amount']));
                $('#keterangan_vc').val(result['nm_cost']+result['keterangan']);
            }
        });
    }
}

function loadDetail_vc(id){
    $.ajax({
        type:"POST",
        url:'<?php echo base_url('index.php/Finance/load_detail_pembayaran'); ?>',
        data:"id="+ id,
        success:function(result){
            $('#boxDetailVoucher').html(result);
            slipSetoran();
        }
    });
}

function saveDetail_vc(){
    if($.trim($("#vc_id").val()) == ""){
        $('#message').html("Silahkan pilih jenis barang!");
        $('.alert-danger').show();
    }else{
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/Finance/save_detail_pembayaran'); ?>',
            data:{
                id:$('#id').val(),
                vc_id:$('#vc_id').val(),
                amount:$('#amount').val()
            },
            success:function(result){
                if(result['message_type']=="sukses"){
                    loadDetail_vc(<?php echo $header['id'];?>);
                    $("#vc_id").select2("val", "");
                    $("#jenis_voucher").val('');
                    $("#jenis_barang").val('');
                    $("#amount_vc").val('');
                    $("#keterangan_vc").val('');
                    $('#message').html("");
                    $('.alert-danger').hide();
                    load_vc();
                }else{
                    $('#message').html(result['message']);
                    $('.alert-danger').show(); 
                }            
            }
        });
    }
}

function hapusDetail_vc(id){
    var r=confirm("Anda yakin menghapus item barang ini?");
    if (r==true){
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/Finance/delete_detail_pembayaran'); ?>',
            data:"id="+ id,
            success:function(result){
                if(result['message_type']=="sukses"){
                    loadDetail_vc(<?php echo $header['id'];?>);
                    load_vc();
                }else{
                    alert(result['message']);
                }     
            }
        });
    }
}

// DIBAWAH CODINGAN UANG MASUK
function load_um(){
    $.ajax({
        url: "<?php echo base_url('index.php/Finance/get_um_list_pmb'); ?>",
        async: false,
        type: "POST",
        dataType: "html",
        success: function(result) {
            $('#um_id').html(result);
        }
    })
}

function get_data_um(id){
    if(''!=id){
    $.ajax({
        url: "<?php echo base_url('index.php/Finance/get_data_um'); ?>",
        type: "POST",
        data: "id="+id,
        dataType: "json",
        success: function(result) {
            $('#id_um').val(result['id']);
            $('#jenis_pembayaran').val(result['jenis_pembayaran']);
            $('#bank_pembayaran').val(result['bank_pembayaran']);
            $('#nomor').val(result['nomor_cek']+result['rekening_pembayaran']);
            $('#amount_um').val(result['currency']+' '+numberWithCommas(result['nominal']));
            myRequest=null;
        }
    });
    }
}

function loadDetail_um(id){
    $.ajax({
        type:"POST",
        url:'<?php echo base_url('index.php/Finance/load_detail_um'); ?>',
        data:{
                id:id,
                um_id:$('#id').val()
            },
        success:function(result){
            $('#boxDetailUm').html(result);
            load_um();
            slipSetoran();
        }
    });
}

function saveDetail_um(){
    if(myRequest){
        console.log('here');
        return;
    }else if($.trim($("#id_um").val()) == ""){
        $('#message').html("Silahkan pilih Cek Masuk!");
        $('.alert-danger').show();
    }else{
        myRequest = $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/Finance/save_detail_um'); ?>',
            data:{
                id:$('#id').val(),
                um_id:$('#um_id').val()
            },
            success:function(result){
                if(result['message_type']=="sukses"){
                    loadDetail_um(<?php echo $header['id'];?>);
                    $('#um_id').select2("val", "");
                    $('#jenis_pembayaran').val('');
                    $('#bank_pembayaran').val('');
                    $('#nomor').val('');
                    $('#amount_um').val('');
                    $('#message').html("");
                    $('.alert-danger').hide();
                    myRequest=null;
                }else{
                    $('#message').html(result['message']);
                    $('.alert-danger').show(); 
                    myRequest=null;
                }            
            }
        });
    }
}

function hapusDetail_um(id){
    var r=confirm("Anda yakin menghapus item barang ini?");
    if (r==true){
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/Finance/delete_detail_um'); ?>',
            data:"id="+ id,
            success:function(result){
                if(result['message_type']=="sukses"){
                    loadDetail_um(<?php echo $header['id'];?>);
                }else{
                    alert(result['message']);
                }     
            }
        });
    }
}

//DIBAWAH CODINGAN UANG KELUAR
function loadDetail_uk(id){
    $.ajax({
        type:"POST",
        url:'<?php echo base_url('index.php/Finance/load_detail_uk'); ?>',
        data:{
                id:id,
                um_id:$('#id').val()
            },
        success:function(result){
            $('#boxDetailUK').html(result);
            slipSetoran();
        }
    });
}

function saveDetail_uk(){
    if($.trim($("#no_uk").val()) == ""){
        $('#message').html("Silahkan isi Nomor Uang Keluar!");
        $('.alert-danger').show();
    }else if($.trim($("#bank_id").val()) == ""){
        $('#message').html("Silahkan pilih bank!");
        $('.alert-danger').show();
    }else if($.trim($("#nominal").val()) == ""){
        $('#message').html("Silahkan pilih jenis barang!");
        $('.alert-danger').show();
    }else{
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/Finance/save_detail_uk'); ?>',
            data:{
                id:$('#id').val(),
                no_uk:$('#no_uk').val(),
                bank_id:$('#bank_id').val(),
                nomor_giro:$('#nomor_giro').val(),
                currency:$('#currency').val(),
                nominal:$('#nominal').val(),
                tanggal:$('#tanggal').val()
            },
            success:function(result){
                if(result['message_type']=="sukses"){
                    loadDetail_uk(<?php echo $header['id'];?>);
                    $('#no_uk').val('');
                    $('#bank_id').select2("val", "");
                    $('#nomor_giro').val('');
                    $('#currency').val('');
                    $('#nominal').val('');
                    $('#message').html("");
                    $('.alert-danger').hide(); 
                }else{
                    $('#message').html(result['message']);
                    $('.alert-danger').show(); 
                }            
            }
        });
    }
}

function delete_uk(id){
    $.ajax({
        type:"POST",
        url:'<?php echo base_url('index.php/Finance/delete_detail_uk'); ?>',
        data:{
            id:id
        },
        success:function(result){
            if(result['message_type']=="sukses"){
                loadDetail_uk(<?php echo $header['id'];?>);
                $('.alert-danger').hide(); 
            }else{
                $('#message').html(result['message']);
                $('.alert-danger').show(); 
            }            
        }
    });
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
            }
        });
    }else{
        $('#currency').val('IDR');
    }
}

function get_currency_a(id,no){
    if(id > 0){
        $.ajax({
            url: "<?php echo base_url('index.php/Finance/get_currency'); ?>",
            type: "POST",
            data: "id="+id,
            dataType: "json",
            success: function(result) {
                $('#currency_'+no).val(result['currency']);
            }
        });
    }else{
        $('#currency_'+no).val('IDR');
    }
}

function updateDetail(id){
    if($.trim($("#bank_id_"+id).val()) == ""){
        $('#message').html("Silahkan pilih bank!");
        $('.alert-danger').show(); 
    }else if($.trim($("#nominal_"+id).val()) == ""){
        $('#message').html("Jumlah  tidak boleh kosong!");
        $('.alert-danger').show(); 
    }else{
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/Finance/update_detail_uk'); ?>',
            data:{
                detail_id:$('#detail_id_'+id).val(),
                no_giro:$('#no_giro_'+id).val(),
                bank_id:$('#bank_id_'+id).val(),
                currency:$('#currency_'+id).val(),
                nominal:$('#nominal_'+id).val()
            },
            success:function(result){
                if(result['message_type']=="sukses"){
                    loadDetail_uk($('#id').val());
                    $('#message').html("");
                    $('.alert-danger').hide(); 
                }else{
                    $('#message').html(result['message']);
                    $('.alert-danger').show(); 
                }            
            }
        });
    }
}

function editDetail(id){
    $('#btnEdit_'+id).hide();
    $('#lbl_bank_id_'+id).hide();
    $('#lbl_no_giro_'+id).hide();
    $('#lbl_currency_'+id).hide();
    $('#lbl_nominal_'+id).hide();
    
    $('#btnUpdate_'+id).show();
    $('#bank_id_'+id).show();
    $('#no_giro_'+id).show();
    $('#currency_'+id).show();
    $('#nominal_'+id).show();
}

//DIBAWAH CODINGAN FORM REJECT
function showRejectBox(){
    var r=confirm("Anda yakin me-reject semua permintaan pembayaran ini?");
    if (r==true){
        $('#header_id').val($('#id').val());
        $('#message').html("");
        $('.alert-danger').hide();
        
        $("#myModal").find('.modal-title').text('Reject Pembayaran Sepenuhnya');
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
        $('#frmReject').attr("action", "<?php echo base_url(); ?>index.php/Finance/reject_all_pmb");
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
    loadDetail_vc(<?php echo $header['id']; ?>);
    loadDetail_um(<?php echo $header['id']; ?>);
    loadDetail_uk(<?php echo $header['id']; ?>);
    load_vc();
    load_um();
});
</script>
      