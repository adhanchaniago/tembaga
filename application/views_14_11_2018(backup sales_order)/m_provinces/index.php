<div class="row">                            
    <div class="col-md-12"> 
        <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Add Province</h4>
                    </div>
                    <div class="modal-body">
                        <form class="eventInsForm" method="post" target="_self" name="formku" 
                              id="formku">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger display-hide">
                                        <button class="close" data-close="alert"></button>
                                        <span id="message">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Kode Provinsi <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="province_code" name="province_code" 
                                        class="form-control myline" style="margin-bottom:5px" maxlength="15" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nama Provinsi <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="province_name" name="province_name" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
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
        
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Master Provinsi
                </div>
                <div class="tools">                                            
                    <a style="height:28px" class="btn btn-circle btn-sm default" onclick="newData()">
                        <i class="fa fa-plus"></i> Tambah</a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Provinsi</th>   
                    <th>Nama Provinsi</th> 
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
                        <td style="width:50px; text-align:center"><?php echo $no; ?></td>
                        <td><?php echo $data->province_code; ?></td>
                        <td><?php echo $data->province_name; ?></td>
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
                            <a href="<?php echo base_url(); ?>index.php/MProvinces/delete/<?php echo $data->id; ?>" 
                               class="btn btn-xs btn-circle red" style="margin-bottom:4px" onclick="return confirm('Anda yakin menghapus data ini?');">
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
    $('#province_code').val('');
    $('#province_name').val('');
    $('#id').val('');
    dsState = "Input";
    
    $("#myModal").find('.modal-title').text('Tambah Provinsi');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){
    if($.trim($("#province_code").val()) == ""){
        $('#message').html("Kode provinsi tidak boleh kosong!");
        $('.alert-danger').show();       
    }else if($.trim($("#province_name").val()) == ""){
        $('#message').html("Nama provinsi tidak boleh kosong!");
        $('.alert-danger').show();
    }else{  
        if(dsState=="Input"){
            $.ajax({
                type:"POST",
                url:'<?php echo base_url('index.php/MProvinces/cek_code'); ?>',
                data:"data="+$("#province_code").val(),
                success:function(result){
                    //console.log(result);
                    if(result=="ADA"){
                        $('#message').html("Kode provinsi sudah digunakan! Silahkan ganti dengan kode lain.");
                        $('.alert-danger').show();
                    }else{
                        $('#message').html("");
                        $('.alert-danger').hide();
                        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MProvinces/save");
                        $('#formku').submit();                    
                    }
                }
            });
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MProvinces/update");
            $('#formku').submit(); 
        }
    };
};

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/MProvinces/edit'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
           console.log(result);
           $('#province_code').val(result['province_code']);
           $('#province_name').val(result['province_name']);
           $('#id').val(result['id']);
           
           $("#myModal").find('.modal-title').text('Edit Provinsi');
           $("#myModal").modal('show',{backdrop: 'true'});           
        }
    });
}

$(function(){    
    window.setTimeout(function() { $(".alert-success").hide(); }, 4000);
});
</script>        