<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h4 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/Bobin'); ?>"> Kelola Bobin </a>
        </h4>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12"> 

        <!-- AWAL MODAL EDIT -->
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
                            <div class="row">
                                <div class="col-md-5">
                                    Nomor Bobbin <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nomor_bobin" name="nomor_bobbin" readonly="readonly" 
                                        class="form-control myline" style="margin-bottom:5px">
                                    
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Tipe <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select class="form-control myline" name="tipe" onchange="get_packing(this.value)" id="tipe_edit" placeholder="Silahkan pilih" style="margin-bottom: 5px;">
                                        <option value=""></option>
                                        <?php foreach ($size_list as $v) {
                                            echo '<option value="'.$v->id.'">'.$v->bobbin_size.' ('.$v->jenis_packing.')</option>';
                                        }?>
                                    </select>

                                    
                                    
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Milik <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select class="form-control myline" name="owner" id="milik_edit" placeholder="Silahkan pilih" style="margin-bottom:5px">
                                        <option value=""></option>
                                        <!-- FOREACH OWNER -->

                                        <!-- AKHIR FOREACH -->
                                    </select>
                                    <input type="hidden" name="id_packing" class="id_packing" value="">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Berat (Kg) <font color="#f00">*</font><br/>
                                    <a href="javascript:;" class="btn btn-circle btn-xs blue" onclick="hitung_berat()"><i class="fa fa-dashboard"></i> Hitung </a>

                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="berat_edit" name="berat" maxlength="10"
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeydown="return myCurrency(event);" onkeyup="getComa(this.value, this.id);">
                                </div>
                            </div>                            
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" onClick="simpandata();">Simpan</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- AKHIR MODAL EDIT -->


        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success <?php echo (empty($this->session->flashdata('flash_msg'))? "display-hide": ""); ?>" id="box_msg_sukses">
                    <button class="close" data-close="alert"></button>
                    <span id="msg_sukses"><?php echo $this->session->flashdata('flash_msg'); ?></span>
                </div>
            </div>
        </div>
        <div id="form_add" class="collapse well">
        <form class="eventInsForm" method="post" target="_self" name="formbobbin" 
              id="formbobbin">  
            <div class="row">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            Tanggal <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="tanggal" name="tanggal" 
                                class="form-control myline input-small" style="margin-bottom:5px;float:left;" 
                                value="<?php echo date('d-m-Y'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Tipe <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <select required="required" class="form-control myline select2me" name="tipe" onchange="get_packing(this.value)" placeholder="Silahkan pilih">
                                <option value=""></option>
                                <!-- Foreach Size Bobin -->

                                <!-- Sampai Sini -->
                            </select>
                            <input type="hidden" name="id_packing" class="id_packing" value="">
                        </div>
                    </div>
                                       
                    
                </div>
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-5"> 
                    <div class="row">
                        <div class="col-md-4">
                            Milik <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <select required="required" class="form-control myline select2me" name="owner" placeholder="Silahkan pilih" style="margin-bottom:5px">
                                <!-- Foreach Data Owner -->

                                <!-- Sampai sini -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Berat <font color="#f00">*</font>
                            <a href="javascript:;" class="btn btn-circle btn-sm blue" onclick="hitung_berat()"><i class="fa fa-dashboard"></i> Hitung </a>
                        </div>
                        <div class="col-md-8">
                            <input required="required" type="text" id="berat" name="berat" placeholder="Berat Bobbin/Keranjang" 
                                class="form-control myline" style="margin-bottom:5px" 
                                value="">
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="javascript:;" class="btn green" onclick="simpanBobbin();"> 
                                <i class="fa fa-floppy-o"></i> Simpan Bobbin </a>
                        </div>    
                    </div> 
                </div>
            </div>
        </form>
        <hr class="divider"/>
        </div>
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-beer"></i>Data Bobin
                </div>
                <div class="tools">    
                    <a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" href="#form_add" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="form_add">
                        <i class="fa fa-plus"></i> Tambah</a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Nomor Bobin</th>   
                    <th>Ukuran</th>
                    <th>Berat (Kg)</th>
                    <th>Pemilik</th>
                    <th>Status</th> 
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                        <!-- echo data dari controller disini -->

                        <!-- sampai sini -->
                        <td style="text-align:center"> 
                            <a class="btn btn-circle btn-xs green" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a> <!-- Kasih function untuk buka function editData -->
                        </td>
                    </tr>
                    <?php
                        //} // TUTUP FOREACH DISINI
                    ?>                                                                                    
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
var dsState;


function getComa(value, id){
    angka = value.toString().replace(/\./g, "");
    $('#'+id).val(angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}

function newData(){
    $('#nama_bobin').val('');
    $('#ukuran').val('');
    $('#berat').val('0');

    $('#id').val('');
    dsState = "Input";
    
    $('#message').html("");
    $('.alert-danger').hide(); 
    
    $("#myModal").find('.modal-title').text('Input Data Bobin');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function get_packing(id){
     $.ajax({
        url: "<?php echo base_url('index.php/Bobbin/get_packing'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            $('.id_packing').val(result['id_packing']);    
        }
    });
}

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/Bobbin/edit'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            $('#nomor_bobin').val(result['nomor_bobbin']);
            $('#tipe_edit').val(result['m_bobbin_size_id']);
            $('#milik_edit').val(result['owner_id']);
            $('#berat_edit').val(result['berat']);
            $('#id').val(result['id']);
            
            //Cara Buka Modal EDIT           
        }
    });
}

$(function(){    
    window.setTimeout(function() { $(".alert-success").hide(); }, 4000);
});



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