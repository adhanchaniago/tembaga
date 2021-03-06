<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h5 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/R_BPB/'); ?>"> BPB </a> 
            <i class="fa fa-angle-right"></i> Input BPB
        </h5>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12"> 
        <?php
            if( ($group_id==9 || $group_id == 14) ){
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span id="message">&nbsp;</span>
                </div>
            </div>
        </div>
        <form class="eventInsForm" method="post" target="_self" name="formku" 
              id="formku" action="<?php echo base_url('index.php/R_BPB/save_bpb'); ?>">
            <div class="row">
                <input type="hidden" name="jenis" value="<?php echo $jenis;?>">
                <div class="col-md-6">
                    <div class="row">
                            <?php if($jenis == 'matching'){ ?>
                        <div class="col-md-4">
                            No. BPB <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_surat_jalan" name="no_surat_jalan" maxlength="25"
                                class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()">
                        </div>
                            <?php } else { ?>
                        <div class="col-md-4">
                            No. Surat Jalan <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_surat_jalan" name="no_surat_jalan" maxlength="25"
                                class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()">
                        </div>
                            <?php } ?>
                    </div>
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
                    <?php if($jenis == 'matching'){?>
                    <div class="row">
                        <div class="col-md-4">
                            No. Invoice Resmi <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_invoice_resmi" name="no_invoice_resmi" 
                                class="form-control myline" style="margin-bottom:5px" value="<?php echo $header['no_invoice_resmi'];?>" readonly="readonly">
                            <input type="hidden" name="id_invoice_resmi" value="<?php echo $header['id'];?>">
                            <input type="hidden" name="so_id" value="0">
                            <input type="hidden" name="po_id" value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            No. Invoice FG <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_invoice_fg" name="no_invoice_fg" 
                                class="form-control myline" style="margin-bottom:5px" value="<?php echo $header['no_invoice'];?>" readonly="readonly">
                            <input type="hidden" name="id_invoice_fg" value="<?php echo $header['invoice_id'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            No. PO <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <select id="flag_po" name="flag_po" class="form-control myline select2me" 
                                data-placeholder="Silahkan pilih..." style="margin-bottom:5px" onchange="get_customer(this.value);get_no_po(this.value)">
                                <option value=""></option>
                                <?php
                                    foreach ($po_list as $row){
                                        echo '<option value="'.$row->id.'">'.$row->no_po.'</option>';
                                    }
                                ?>
                            </select>
                            <input type="hidden" name="no_po" id="no_po">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4">
                            Jenis Barang <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="jenis_barang" name="jenis_barang" 
                                class="form-control myline" style="margin-bottom:5px" value="RONGSOK" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Customer <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <!-- <select id="m_customer_id" name="m_customer_id" class="form-control myline select2me m_customer_id" 
                                data-placeholder="Silahkan pilih..." style="margin-bottom:5px" 
                                onclick="get_alamat(this.value);">
                                <option value=""></option>
                                <?php
                                    foreach ($customer_list as $row){
                                        echo '<option value="'.$row->id.'">'.$row->nama_customer.'</option>';
                                    }
                                ?>
                            </select> -->
                            <input type="text" id="nama_customer" name="nama_customer" 
                                class="form-control myline" style="margin-bottom:5px" readonly="readonly">
                            <input type="hidden" id="m_customer_id" name="m_customer_id" 
                                class="form-control myline" style="margin-bottom:5px" readonly="readonly">
                        </div>
                    </div>  
                    <?php } ?>
                    <div class="row">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-4">&nbsp;</div>
                        <div class="col-md-8">
                            <a href="javascript:;" class="btn green" id="simpanData" onclick="simpanData();"> 
                                <i class="fa fa-floppy-o"></i> Input Details </a>
                        </div>    
                    </div>
                </div>
                <div class="col-md-1">&nbsp;</div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            Type Kendaraan
                        </div>
                        <div class="col-md-8">
                            <select id="m_type_kendaraan_id" name="m_type_kendaraan_id" class="form-control myline select2me" 
                                data-placeholder="Silahkan pilih..." style="margin-bottom:5px">
                                <option value=""></option>
                                <?php
                                    foreach ($tipe_kendaraan_list as $row){
                                        echo '<option value="'.$row->id.'">'.$row->type_kendaraan.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>           
                    <div class="row">
                        <div class="col-md-4">
                            No. Kendaraan
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="no_kendaraan" id="no_kendaraan" class="form-control myline" 
                                   style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4">
                            Supir
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="supir" name="supir" onkeyup="this.value = this.value.toUpperCase()"
                                class="form-control myline" style="margin-bottom:5px">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Catatan
                        </div>
                        <div class="col-md-8">
                            <textarea id="remarks" name="remarks" rows="2" onkeyup="this.value = this.value.toUpperCase()"
                                class="form-control myline" style="margin-bottom:5px"></textarea>                           
                        </div>
                    </div>
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
function simpanData(){
    if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show(); 
    }else if($.trim($("#no_surat_jalan").val()) == ""){
        $('#message').html("Nomor BPB Harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();
    }else if($.trim($("#flag_po").val()) == ""){
        $('#message').html("Silahkan pilih PO!");
        $('.alert-danger').show();
    }else if($.trim($("#jenis_barang").val()) == ""){
        $('#message').html("Silahkan pilih jenis barang!");
        $('.alert-danger').show();
    }else{     
        $('#simpanData').text('Please Wait ...').prop("onclick", null).off("click");
        $('#formku').submit(); 
    };
};


function get_alamat(id){
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('index.php/R_SuratJalan/get_alamat'); ?>",
        data: {id: id},
        cache: false,
        success: function(result) {
            $("#alamat").val(result['alamat']);           
        } 
    });
}

function get_customer(id){
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('index.php/R_SuratJalan/get_customer'); ?>",
        data: {id: id},
        cache: false,
        success: function(result) {
            $("#m_customer_id").val(result['id']);     
            $("#nama_customer").val(result['nama_customer']);           
        } 
    });
}

function get_no_po(id){
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('index.php/R_BPB/get_no_po'); ?>",
        data: {id: id},
        success: function(result) {
            $("#no_po").val(result['no_po']);
        }
    });
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

    $("#tgl_so").datepicker({
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
      