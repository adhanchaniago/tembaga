<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h5 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/R_InvoiceJasa/'); ?>"> Invoice Jasa </a> 
            <i class="fa fa-angle-right"></i> Input Invoice Jasa
        </h5>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12"> 
        <?php
            if( ($group_id==9)||($hak_akses['add']==1) ){
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
              id="formku" action="<?php echo base_url('index.php/R_InvoiceJasa/save'); ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            No. Invoice Jasa<font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_inv_jasa" name="no_inv_jasa" 
                                class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()">
                        </div>
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
                    <div class="row">
                        <div class="col-md-4">
                            No. Surat Jalan Resmi<font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_sj_resmi" name="no_sj_resmi" 
                                class="form-control myline" style="margin-bottom:5px" value="<?php echo $header['no_sj_resmi'];?>" readonly="readonly">
                            <input type="hidden" name="id_sj" value="<?php echo $header['id'];?>">
                        </div>
                    </div>
                <?php
                if($header['r_so_id'] > 0){
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            No. Sales Order
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_so" name="no_so" readonly="readonly"
                                class="form-control myline" style="margin-bottom:5px" 
                                value="<?php echo $header['no_so']; ?>">
                            
                            <input type="hidden" id="id_so" name="id_so" value="<?php echo $header['r_so_id']; ?>">
                            <input type="hidden" name="id_invoice_resmi" value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Tanggal SO.
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="tgl_so" id="tgl_so" class="form-control myline input-small" style="margin-bottom:5px; float: left;" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo date('d-m-Y', strtotime($header['tgl_so'])) ?>" readonly="readonly">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4">
                            Bank <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <select id="bank_id" name="bank_id" class="form-control myline select2me" 
                                data-placeholder="Silahkan pilih..." style="margin-bottom:5px">
                                <option value=""></option>
                                <?php
                                    foreach ($bank_list as $row){
                                        echo '<option value="'.$row->id.'">'.$row->nama_bank.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Nama Direktur
                        </div>
                        <div class="col-md-8">
                            <!-- <input type="text" id="nama_direktur" name="nama_direktur" class="form-control myline" style="margin-bottom:5px"> -->
                            <select id="nama_direktur" name="nama_direktur" class="form-control myline select2me" data-placeholder="Silahkan pilih..." style="margin-bottom:5px">
                                <option value="Budinata Atmadja">Budinata Atmadja</option>
                                <option value="Senkiawan Tjandra">Senkiawan Tjandra</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Diskon
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="diskon" name="diskon" class="form-control myline" style="margin-bottom:5px" value="0" onkeyup="getComa(this.value, this.id)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Biaya Tambahan
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="add_cost" name="add_cost" class="form-control myline" style="margin-bottom:5px" value="0" onkeyup="getComa(this.value, this.id)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Materai
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="materai" name="materai" class="form-control myline" style="margin-bottom:5px" value="0" onkeyup="getComa(this.value, this.id)">
                        </div>
                    </div>
                <?php
                } else if($header['r_po_id'] > 0){
                ?>  
                    <div class="row">
                        <div class="col-md-4">
                            No. Purchase Order
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_po" name="no_po" readonly="readonly"
                                class="form-control myline" style="margin-bottom:5px" 
                                value="<?php echo $header['no_po']; ?>">
                            
                            <input type="hidden" id="id_po" name="id_po" value="<?php echo $header['r_po_id']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Tanggal PO
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="tgl_po" id="tgl_po" class="form-control myline input-small" style="margin-bottom:5px; float: left;" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo date('d-m-Y', strtotime($header['tgl_po'])) ?>" readonly="readonly">
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
                            Customer <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="nama_customer" name="nama_customer" 
                                class="form-control myline" style="margin-bottom:5px" value="<?php echo $header['nama_customer'];?>" readonly="readonly">

                            <input type="hidden" name="customer_id" value="<?php echo $header['m_cv_id'];?>">
                            <input type="hidden" name="idkmp" value="<?php echo $header['idkmp'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Term of payment <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="term_of_payment" name="term_of_payment" 
                                class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()">                      
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Jatuh Tempo <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="tgl_jth_tempo" name="tgl_jth_tempo" 
                                class="form-control myline input-small" style="margin-bottom:5px;float:left;" 
                                value="<?php echo date('d-m-Y'); ?>">
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
function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 95 || charCode > 105))
        return false;
    return true;
}

function getComa(value, id){
    angka = value.toString().replace(/\,/g, "");
    $('#'+id).val(angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    // hitungSubTotal();
}

function simpanData(){
    if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show(); 
    }else if($.trim($("#no_inv_jasa").val()) == ""){
        $('#message').html("Silahkan isi Nomor Invoice!");
        $('.alert-danger').show();
    }else if($.trim($("#term_of_payment").val()) == ""){
        $('#message').html("Silahkan isi term of payment!");
        $('.alert-danger').show();
    }else if($.trim($("#tgl_jth_tempo").val()) == ""){
        $('#message').html("Silahkan isi Tanggal Jatuh Tempo!");
        $('.alert-danger').show();
    }else{     
        $('#simpanData').text('Please Wait ...').prop("onclick", null).off("click");
        $('#formku').submit(); 
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
        dateFormat: 'dd-mm-yy'
    });

    $("#tgl_jth_tempo").datepicker({
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
      