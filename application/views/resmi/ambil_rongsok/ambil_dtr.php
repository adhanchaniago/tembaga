<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h5 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <a href="<?php echo base_url('index.php/R_Matching'); ?>"><i class="fa fa-angle-right"></i> Create DTR</a>
            <i class="fa fa-angle-right"></i> 
            Edit DTR 
        </h5>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12">
        <h3 align="center"><b> Create DTR</b></h3>
        <hr class="divider" />
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger <?php echo (empty($this->session->flashdata('flash_msg'))? "display-hide": ""); ?>" id="box_msg_sukses">
                    <button class="close" data-close="alert"></button>
                    <span id="msg_sukses"><?php echo $this->session->flashdata('flash_msg'); ?></span>
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
                                <div class="alert alert-danger display-hide" id="box_error_modal">
                                    <button class="close" data-close="alert"></button>
                                    <span id="msg_modal">&nbsp;</span>
                                </div>
                            </div>
                        </div>
                        <!-- <form class="eventInsForm" method="post" target="_self" name="formku" 
                              id="formku">                             -->
                            <!-- <input type="hidden" id="status_vc" name="status_vc"> -->
                            <div class="row">
                                <div class="col-md-5">
                                    Netto
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="netto" name="netto" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        readonly="readonly">
                                    
                                    <input type="hidden" id="id_dtr_detail" name="id_dtr_detail" class="form-control">
                                    <input type="hidden" id="id_dtr" name="id_dtr">
                                    <input type="hidden" id="id_barang" name="id_barang">
                                    <input type="hidden" id="nama_item" name="nama_item">
                                    <input type="hidden" id="bruto" name="bruto">
                                    <input type="hidden" id="berat_palette" name="berat_palette">
                                    <input type="hidden" id="no_pallete" name="no_pallete">
                                    <input type="hidden" id="line_remarks" name="line_remarks">
                                    <input type="hidden" id="tanggal_p" name="tanggal_p">
                                    
                                </div>
                            </div>                  
                            <div class="row">
                                <div class="col-md-5">
                                    Netto diambil <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="number" id="netto_ambil" name="netto_ambil" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        >                                                                       
                                </div>
                            </div> 
                            
                        <!-- </form> -->
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" onClick="saveDetailParsial();">Simpan</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if( ($group_id==16)||($hak_akses['view']==1) ){
        ?>
        <form class="eventInsForm" method="post" target="_self" name="formku" 
              id="formku">  
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            No. DTR<font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_dtr" name="no_dtr" class="form-control myline" style="margin-bottom:5px" value="<?php echo $header['no_dtr']; ?>" onkeyup="this.value = this.value.toUpperCase()">

                            <input type="hidden" id="id" name="id" value="<?php echo $header['id']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Tanggal <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="tanggal" name="tanggal"
                                class="form-control myline input-small" style="margin-bottom:5px; float: left;" 
                                value="<?php echo date('d-m-Y', strtotime($header['tanggal'])); ?>">
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                </div>
                <div class="col-md-1">&nbsp;</div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            Supplier <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <select id="supplier_id" name="supplier_id" class="form-control myline select2me" 
                                data-placeholder="Silahkan pilih..." onclick="get_contact(this.value);" style="margin-bottom:5px">
                                <option value=""></option>
                                <?php
                                    foreach ($supplier_list as $row){
                                        echo '<option value="'.$row->id.'" '.(($row->id==$header['supplier_id'])? 'selected="selected"': '').'>'.$row->nama_supplier.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Catatan
                        </div>
                        <div class="col-md-8">
                            <textarea id="remarks" name="remarks" rows="2" onkeyup="this.value = this.value.toUpperCase()"
                                class="form-control myline" style="margin-bottom:5px"><?php echo $header['remarks']; ?></textarea>                           
                        </div>
                    </div>
                </div>              
            </div>
            
            <!-- <div class="portlet box yellow-gold">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-file-word-o"></i>Data DTR
                    </div> 
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <th style="width:40px">No</th>
                            <th>No. DTR</th>
                            <th>Netto (Kg)</th>
                        </thead>
                        <tbody id="boxDetail0">
                        
                        </tbody>
                    </table>
                </div>
            </div> -->
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger display-hide" id="alert-danger2">
                        <button class="close" data-close="alert"></button>
                        <span id="message2">&nbsp;</span>
                    </div>
                </div>
            </div>
            <div class="portlet box green-seagreen">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-file-word-o"></i>Input Jenis Barang
                    </div>
                    <div class="tools">    
                    
                    </div>    
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4">
                            Pilih Jenis Barang
                            <select class="form-control select2me myline" id="dtr_id" name="dtr_id" onchange="loadDetailJb(this.value);">
                                <!-- <?php foreach ($list_dtr as $row) {
                                ?>
                                <option value="<?php echo $row->id ?>"><?php echo $row->no_dtr ?></option>
                                <?php
                                } ?> -->
                            </select>
                        </div>    
                        <div class="col-md-2">
                        </div>                    
                    </div>
                    <div>
                        <br>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <th style="width:40px">No</th>
                                <th>Nama Item</th>
                                <th>Bruto (Kg)</th>
                                <th>Netto (Kg)</th>
                                <th>Berat Pallete (Kg)</th>
                                <th>Nomor Pallete</th>
                                <th style="text-align: center;">Action</th>
                            </thead>
                            <tbody id="boxDetail">
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="portlet box blue-ebonyclay">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-file-word-o"></i>Invoice DTR
                    </div>
                    <div class="tools">    
                    
                    </div>    
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <th style="width:40px">No</th>
                                <th>Nama Item</th>
                                <th>Bruto (Kg)</th>
                                <th>Netto (Kg)</th>
                                <th>Berat Pallete (Kg)</th>
                                <th>Nomor Pallete</th>
                                <th>Keterangan</th>
                                <th style="text-align: center;">Action</th>
                            </thead>
                            <tbody id="boxDetail2">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

                </div>
            </div>
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col-md-12">
                    <!-- <?php
                        if( ($group_id==16 || $hak_akses['approve_spb']==1) && $header['status']=="0"){
                            echo '<a href="javascript:;" class="btn green" onclick="approveData();"> '
                                .'<i class="fa fa-check"></i> Approve </a> ';
                        }
                        if( ($group_id==16 || $hak_akses['reject_spb']==1) && $header['status']=="0"){
                            echo '<a href="javascript:;" class="btn red" onclick="showRejectBox();"> '
                                .'<i class="fa fa-ban"></i> Reject </a>';
                        }
                    ?> -->
                    <?php
                        if( ($group_id==16 || $hak_akses['update']==1)){
                            echo '<a href="javascript:;" class="btn green" onclick="saveData();"> '
                                .'<i class="fa fa-save"></i> Simpan </a> ';
                        }
                    ?>
                    <a href="<?php echo base_url('index.php/R_Matching/'); ?>" class="btn blue-hoki"> 
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
function hitungTotal(){
    var jumlah = $("#qty").val();
    var persentase = $("#persentase").val();
    var x = 1-(persentase/100);
    var total = 0;

    total = ((Number(jumlah) / Number(x))).toFixed(0);

    $("#total").val(total);
}

function saveParsial(no,jb) {
    var netto = $('#netto_'+no).val();
    var id_dtr_detail = $('#dtr_detail_id_'+no).val();
    var id_dtr = $('#dtr_id_'+no).val();
    var id_barang = $('#id_barang_'+no).val();
    var nama_item = $('#nama_item_'+no).val();
    var bruto = $('#bruto_'+no).val();
    var berat_palette = $('#berat_palette_'+no).val();
    var no_pallete = $('#no_pallete_'+no).val();
    var line_remarks = $('#line_remarks_'+no).val();
    var tanggal = $('#tanggal').val();
    // console.log(id_dtr_detail);

    $("#netto").val(netto);
    $("#id_dtr_detail").val(id_dtr_detail);
    $("#id_dtr").val(id_dtr);
    $("#id_barang").val(id_barang);
    $("#nama_item").val(nama_item);
    $("#bruto").val(bruto);
    $("#berat_palette").val(berat_palette);
    $("#no_pallete").val(no_pallete);
    $("#line_remarks").val(line_remarks);
    $("#tanggal_p").val(tanggal);

    $("#netto_ambil").attr({
        "min" : 0,
        "max" : netto
    });

    $("#myModal").find('.modal-title').text(jb);
    $("#myModal").modal('show',{backdrop: 'true'});
}

function saveDetailParsial(){
    var dtr_id = $('#id_dtr').val();
    var netto = $('#netto').val();
    var u_netto = $('#netto_ambil').val();
    var id_barang = $('#id_barang').val();
    var id_dtr_detail = $('#id_dtr_detail').val();

    var nama_item = $("#nama_item").val();
    var bruto = $("#bruto").val();
    var berat_palette= $("#berat_palette").val();
    var no_pallete = $("#no_pallete").val();
    var line_remarks = $("#line_remarks").val();
    // console.log(u_netto+" > "+netto);

    if(Number(u_netto) > Number(netto)){
        $('#msg_modal').html("Jumlah netto diambil tidak boleh lebih dari netto!");
        $('#box_error_modal').show();
    } else {
        $.ajax({
        type:"POST",
        url:'<?php echo base_url('index.php/R_Rongsok/save_dtr_detail_parsial'); ?>',
        data:{
            id_dtr : dtr_id,
            dtr_asli_id : $('#id').val(),
            id_barang: id_barang,
            dtr_detail_id: id_dtr_detail,
            bruto : bruto,
            netto : netto,
            u_netto : u_netto,
            berat_pallete: berat_palette,
            keterangan: line_remarks,
            tanggal: $('#tanggal_p').val()
        },
        success:function(result){
            if(result['message_type']=="sukses"){
                if (result['flag_taken'] == 1) {
                    $('#dtr_id').select2('val', '');  
                } else {
                    $('#dtr_id').select2('val', result['jenis_barang']);
                }
                load_list_dtr();
                // load_dtr();
                loadDetailJb(result['jenis_barang']);
                loadDetailInvoice($('#id').val());
                $('#message').html("");
                $('.alert-danger').hide(); 
                $('#myModal').modal('hide');
                $('#netto_ambil').val('');
            }else{
                $('#message').html(result['message']);
                $('.alert-danger').show(); 
            }            
        }
    });
    }
}

function load_list_dtr(){
    $.ajax({
        url:'<?php echo base_url('index.php/R_Matching/load_list_dtr'); ?>',
        success:function(result){
            $('#boxDetail0').html(result);     
        }
    });
}

// function load_dtr(){
//     $.ajax({
//         url: "<?php echo base_url('index.php/R_Matching/get_dtr_list'); ?>",
//         async: false,
//         type: "POST",
//         dataType: "html",
//         success: function(result) {
//             $('#dtr_id').html(result);
//         }
//     })
// }

function load_jenis_barang(){
    $.ajax({
        url: "<?= base_url('index.php/R_Matching/get_jenis_barang_list'); ?>",
        async: false,
        type: "POST",
        dataType: "html",
        success: function(result){
            $('#dtr_id').html(result);
        }
    });
}

function loadDetail(id){
    $.ajax({
        type:"POST",
        url:'<?php echo base_url('index.php/R_Matching/load_detail_dtr'); ?>',
        data:"id="+ id,
        success:function(result){
            $('#boxDetail').html(result);     
        }
    });
}

function loadDetailJb(id){
    $.ajax({
        type: "POST",
        url: "<?= base_url('index.php/R_Matching/load_detail_jb'); ?>",
        data:"id="+ id,
        success:function(result){
            $('#boxDetail').html(result);
        }
    });
}

function saveData(){
    $('#message2').html("");
    $('#alert-danger2').hide(); 
    $('#formku').attr('action','<?php echo base_url(); ?>index.php/R_Rongsok/update_dtr');
    $('#formku').submit(); 
    
}

function saveDetail(id){
    $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/R_Rongsok/save_detail_rsk'); ?>',
            data:{
                id_dtr:$('#dtr_id_'+id).val(),
                dtr_asli_id:$('#id').val(),
                id_barang:$('#id_barang_'+id).val(),
                dtr_detail_id:$('#dtr_detail_id_'+id).val(),
                bruto:$('#bruto_'+id).val(),
                netto: $('#netto_'+id).val(),
                berat_pallete: $('#berat_palette_'+id).val(),
                keterangan: $('#line_remarks_'+id).val(),
                tanggal: $('#tanggal').val()
            },
            success:function(result){
                if(result['message_type']=="sukses"){
                    if (result['flag_taken'] == 1) {
                        $('#dtr_id').select2('val', '');  
                    } else {
                        $('#dtr_id').select2('val', result['jenis_barang']);
                    }
                    load_list_dtr();
                    // load_dtr();
                    loadDetailJb(result['jenis_barang']);
                    loadDetailInvoice($('#id').val());
                    $('#message').html("");
                    $('.alert-danger').hide(); 
                }else{
                    $('#message').html(result['message']);
                    $('.alert-danger').show(); 
                }            
            }
        });
}

function hapusDetail(id,jb,netto, detail_id_matching){
    //$row->dtr_asli_id.','.$row->rongsok_id.','.$row->netto.','.$row->id
    var dtr_id = $('#dtr_id_'+id).val();
    console.log(detail_id_matching);
    var r=confirm("Anda yakin menghapus item Rongsok ini?");
    if (r==true){
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/R_Rongsok/delete_dtr_detail'); ?>',
            data:{
                id_dtr: dtr_id,
                id_dtr_detail:id,
                id_barang: jb,
                netto: netto,
                detail_id_matching: detail_id_matching
            },
            success:function(result){
                if(result['message_type']=="sukses"){
                    if (result['check'] == 0) {
                        $('#dtr_id').select2('val', result['jenis_barang']);
                    }
                    load_list_dtr();
                    // load_dtr();
                    loadDetailJb(result['jenis_barang']);
                    loadDetailInvoice($('#id').val());
                }else{
                    alert(result['message']);
                }     
            }
        });
    }
}


function loadDetailInvoice(id){
    $.ajax({
        type:"POST",
        url:'<?php echo base_url('index.php/R_Rongsok/load_detail_dtr'); ?>',
        data:{
            id: id
        },
        success:function(result){
            $('#boxDetail2').html(result);     
        }
    });
}
</script>
<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script type="text/javascript">
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
    load_list_dtr();
    // load_dtr();
    load_jenis_barang();
    loadDetailInvoice(<?php echo $header['id']; ?>);
});
</script>