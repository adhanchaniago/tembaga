<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h4 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Master 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/Supplier'); ?>"> Data Supplier </a>
        </h4>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12"> 
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
                                    Nama Supplier <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_supplier" name="nama_supplier" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                    
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Penanggung Jawab (PIC)<font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="pic" name="pic" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    No. Telepon
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="telepon" name="telepon" 
                                        class="form-control myline" style="margin-bottom:5px">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Handphone (HP)
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="hp" name="hp" 
                                        class="form-control myline" style="margin-bottom:5px">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Alamat <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <textarea id="alamat" name="alamat" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()" rows="3"></textarea>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-5">
                                    Provinsi <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="m_province_id" name="m_province_id" class="form-control select2me myline" 
                                        data-placeholder="Pilih..." style="margin-bottom:5px" onclick="get_city_list(this.value);">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_provinsi as $value){
                                                echo "<option value='".$value->id."'>".$value->province_name."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Kota <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="m_city_id" name="m_city_id" class="form-control select2me myline" 
                                        data-placeholder="Pilih..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_city as $value){
                                                echo "<option value='".$value->id."'>".$value->city_name."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Kode Pos
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="kode_pos" name="kode_pos" style="margin-bottom:5px"
                                        onkeydown="return myCurrency(event);" maxlength="5" class="form-control myline">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Nama Bank 
                                </div>
                                <div class="col-md-7">
                                    <select id="m_bank_id" name="m_bank_id" class="form-control select2me myline" 
                                        data-placeholder="Pilih..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_bank as $value){
                                                echo "<option value='".$value->id."'>".$value->kode_bank."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    KCP
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="kcp" name="kcp" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Bank Account
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_rekening" name="no_rekening" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeydown="return myCurrency(event);">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Catatan
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
                        <button type="button" class="btn blue" onClick="simpandata();">Simpan</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

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
                    <i class="fa fa-truck"></i>Data Supplier
                </div>
                <div class="tools">    
                    <a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" onclick="newData()">
                        <i class="fa fa-plus"></i> Tambah</a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th style="width:35px;">No</th>
                    <th>Nama Supplier</th>                     
                    <th>PIC</th>
                    <th>Telepon</th>
                    <th>Kota</th>
                    <th>Provinsi</th>
                    <th>Bank</th> 
                    <th>KCP</th> 
                    <th>Bank Account</th> 
                    <th style="width:60px;">Actions</th>
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
                        <td><?php echo $data->nama_supplier; ?></td>
                        <td><?php echo $data->pic; ?></td>
                        <td><?php echo $data->telepon; ?></td>
                        <td><?php echo $data->city_name; ?></td>
                        <td><?php echo $data->province_name; ?></td>
                        <td><?php echo $data->kode_bank; ?></td> 
                        <td><?php echo $data->kcp; ?></td>
                        <td><?php echo $data->no_rekening; ?></td>
                        <td style="text-align:center"> 
                            <?php
                                if( ($group_id==1)||($hak_akses['edit']==1) ){
                            ?>
                            <a class="btn btn-circle btn-xs green" onclick="editData(<?php echo $data->id; ?>)" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                            <?php 
                                }
                                if( ($group_id==1)||($hak_akses['delete']==1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/Supplier/delete/<?php echo $data->id; ?>" 
                               class="btn btn-circle btn-xs red" style="margin-bottom:4px" onclick="return confirm('Anda yakin menghapus data ini?');">
                                <i class="fa fa-trash-o"></i> Hapus </a>
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
var dsState;

function newData(){
    $('#nama_supplier').val('');    
    $('#pic').val('');
    $('#telepon').val('');
    $('#hp').val('');
    $('#alamat').val('');
    $('#m_province_id').select2('val', '');
    $('#m_city_id').select2('val', '');
    $('#kode_pos').val('');
    $('#m_bank_id').select2('val', '');
    $('#kcp').val('');
    $('#no_rekening').val('');
    $('#keterangan').val('');
    $('#id').val('');
    dsState = "Input";
    
    $('#message').html("");
    $('.alert-danger').hide(); 
    
    $("#myModal").find('.modal-title').text('Input Data Supplier');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){
    if($.trim($("#nama_supplier").val()) == ""){
        $('#message').html("Nama supplier harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#pic").val()) == ""){
        $('#message').html("Nama penanggung jawab harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#alamat").val()) == ""){
        $('#message').html("Alamat harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#m_province_id").val()) == ""){
        $('#message').html("Silahkan pilih provinsi!");
        $('.alert-danger').show();
    }else if($.trim($("#m_city_id").val()) == ""){
        $('#message').html("Silahkan pilih kota!");
        $('.alert-danger').show();
    }else{     
        $('#message').html("");
        $('.alert-danger').hide();
        if(dsState=="Input"){                                   
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Supplier/save");                                               
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Supplier/update");
        }
        $('#formku').submit();  
    };
};

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/Supplier/edit'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            $('#nama_supplier').val(result['nama_supplier']);            
            $('#pic').val(result['pic']);
            $('#telepon').val(result['telepon']);
            $('#hp').val(result['hp']);
            $('#alamat').val(result['alamat']);
            $('#m_province_id').select2('val',result['m_province_id']);
            get_city_list(result['m_province_id']);
            
            $('#m_city_id').select2('val',result['m_city_id']);
            $('#kode_pos').val(result['kode_pos']);
            $('#keterangan').val(result['keterangan']);
            $('#m_bank_id').select2('val',result['m_bank_id']);
            $('#kcp').val(result['kcp']);
            $('#no_rekening').val(result['no_rekening']);
            $('#id').val(result['id']);
            
            $("#myModal").find('.modal-title').text('Edit Supplier');
            $("#myModal").modal('show',{backdrop: 'true'});           
        }
    });
}

function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function get_city_list(id){
    $.ajax({
        url: "<?php echo base_url('index.php/Supplier/get_city_list'); ?>",
        async: false,
        type: "POST",
        data: "id="+id,
        dataType: "html",
        success: function(result) {
            $('#m_city_id').html(result);
        }
    })
}

$(function(){    
    window.setTimeout(function() { $(".alert-success").hide(); }, 4000);
});
</script>         