<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h5 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Pembelian 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/BeliSparePart'); ?>"> Pembelian Spare Part </a> 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/BeliSparePart/create_po'); ?>"> Create Purchase Order (PO) </a> 
        </h5>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12">
        <?php
            if( ($group_id==1)||($hak_akses['create_po']==1) ){
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
              id="formku" action="<?php echo base_url('index.php/BeliSparePart/save_po'); ?>">  
            <div class="row">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            No PO Terakhir 
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_pengajuan" name="no_pengajuan" readonly="readonly"
                                class="form-control myline" style="margin-bottom:5px" 
                                value="<?php echo $no_po['no_po'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            No. PO <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                        <?php if($this->session->userdata('user_ppn')==1){
                            echo '<input type="text" id="no_po" name="no_po" class="form-control myline" placeholder="Silahkan isi Nomor PO..." style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()">';
                        }else{
                            echo '<input type="text" id="no_po" name="no_po" readonly="readonly"
                                class="form-control myline" style="margin-bottom:5px" 
                                value="Auto Generate">';
                        }?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Tanggal PO <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="tanggal" name="tanggal" 
                                class="form-control myline input-small" style="margin-bottom:5px;float:left;" 
                                value="<?php echo date('d-m-Y'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            No Pengajuan 
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_pengajuan" name="no_pengajuan" readonly="readonly"
                                class="form-control myline" style="margin-bottom:5px" 
                                value="<?php echo $myData['no_pengajuan']; ?>">

                            <input type="hidden" id="beli_sparepart_id" name="beli_sparepart_id" value="<?php echo $myData['id']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Tgl Pengajuan 
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="tgl_pengajuan" name="tgl_pengajuan" readonly="readonly"
                                class="form-control myline" style="margin-bottom:5px" 
                                value="<?php echo date('d-m-Y', strtotime($myData['tgl_pengajuan'])); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Yang Mengajukan 
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="created_name" name="created_name" readonly="readonly"
                                class="form-control myline" style="margin-bottom:5px" 
                                value="<?php echo $myData['created_name']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-1">&nbsp;</div>
                <div class="col-md-6">
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
                                        echo '<option value="'.$row->id.'">'.$row->nama_supplier.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Contact Person
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="contact_person" name="contact_person" readonly="readonly"
                                class="form-control myline" style="margin-bottom:5px">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Term of Payment <font color="#f00">*</font>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="term_of_payment" name="term_of_payment" 
                                class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()">
                        </div>
                        <div class="col-md-2">
                            Materai
                        </div>
                        <div class="col-md-4">
                            <select id="materai" name="materai" class="form-control myline select2me" 
                                data-placeholder="Silahkan pilih..." style="margin-bottom:5px">
                                <option></option>
                                <option value="3000">Materai 3000</option>
                                <option value="6000">Materai 6000</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Currency
                        </div>
                        <div class="col-md-4">
                            <select id="currency" name="currency" class="form-control myline select2me" 
                                data-placeholder="Silahkan pilih..." style="margin-bottom:5px" onchange="get_cur(this.value);">
                                <option value="IDR">IDR</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div id="show_kurs">
                        <div class="col-md-2">
                            Kurs
                        </div>
                        <div class="col-md-4">
                            <input type="number" id="kurs" name="kurs" class="form-control myline" value="1">
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Discount
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="diskon" name="diskon" class="form-control myline" placeholder="%" style="margin-bottom:5px" onkeyup="getComa(this.value, this.id)">
                        </div>
                    <?php if($this->session->userdata('user_ppn')==1){?>
                        <div class="col-md-2">
                            PPN
                        </div>
                        <div class="col-md-4">
                            <select id="ppn" name="ppn" class="form-control myline" 
                                data-placeholder="Silahkan pilih..." style="margin-bottom:5px">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    <?php } else{ ?>
                        <input type="hidden" id="ppn" name="ppn" value="0">
                    <?php } ?>
                    </div>
                </div>              
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <th style="width:40px">No</th>
                                <th>
                                    <input type="checkbox" id="check_all" name="check_all" onclick="checkAll()" class="form-control">
                                </th>
                                <th width="25%">Nama Item Spare Part</th>
                                <th width="10%">Unit of Measure</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Sub Total</th>
                            </thead>
                            <tbody>
                            <?php
                                $no = 1;
                                foreach ($myDetail as $row){
                                    echo '<tr>';
                                    echo '<td style="text-align:center">'.$no.'</td>';
                                    echo '<td>';
                                    echo '<input type="checkbox" value="1" id="check_'.$no.'" name="myDetails['.$no.'][check]" 
                                            onclick="check();" class="form-control">';
                                    echo '<input type="hidden" name="myDetails['.$no.'][beli_sparepart_detail_id]" value="'.$row->id.'">';
                                    echo '<input type="hidden" name="myDetails['.$no.'][sparepart_id]" value="'.$row->sparepart_id.'">';
                                    echo '</td>';
                                    echo '<td><input type="text" name="myDetails['.$no.'][nama_item]" '
                                            . 'class="form-control myline" value="'.$row->nama_item.'" '
                                            . 'readonly="readonly"></td>';
                                    echo '<td><input type="text" name="myDetails['.$no.'][uom]" '
                                            . 'class="form-control myline" value="'.$row->uom.'" '
                                            . 'readonly="readonly"></td>';
                                    echo '<td><input type="text" id="harga_'.$no.'" name="myDetails['.$no.'][harga]" '
                                            . 'class="form-control myline" value="0" '
                                            . 'onkeyup="hitungSubTotal('.$no.');"></td>';
                                    echo '<td><input type="text" id="qty_'.$no.'" name="myDetails['.$no.'][qty]" '
                                            . 'class="form-control myline" value="'.$row->qty.'" '
                                            . 'readonly="readonly"></td>';
                                    echo '<td><input type="text" id="total_harga_'.$no.'" name="myDetails['.$no.'][total_harga]" '
                                            . 'class="form-control myline" value="0" readonly="readonly"></td>';
                                    echo '</tr>';
                                    $no++;
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col-md-12">
                    <a href="javascript:;" class="btn green" id="simpanData" onclick="simpanData();"> 
                        <i class="fa fa-floppy-o"></i> Create PO </a>

                    <a href="<?php echo base_url('index.php/BeliSparePart'); ?>" class="btn blue-hoki"> 
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
function get_contact(id){
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('index.php/BeliSparePart/get_contact_name'); ?>",
        data: {id: id},
        cache: false,
        success: function(result) {
            $("#contact_person").val(result['pic']);
        } 
    });
}

function getComa(value, id){
    angka = value.toString().replace(/\,/g, "");
    $('#'+id).val(angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}

function get_cur(id){
    if(id=='USD'){
        $('#show_kurs').show();
    }else if(id=='IDR'){
        $('#show_kurs').hide();
        $('#kurs').val(1);
    }
}

function hitungSubTotal(id){
    harga = $('#harga_'+id).val().toString().replace(/\,/g, "");
    qty   = $('#qty_'+id).val().toString().replace(/\,/g, "");
    total_harga = Number(harga)* Number(qty);
    total_harga = total_harga.toFixed(2);
    
    $('#harga_'+id).val(harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#total_harga_'+id).val(total_harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

    $('#uniform-check_'+id+' span').attr('class', 'checked');
    $('#check_'+id).attr('checked', true);
}

function checkAll(){
    if ($('#check_all').prop("checked")) {  
        $('input').each(function(i){
            $('#uniform-check_'+i+' span').attr('class', 'checked');
            $('#check_'+i).attr('checked', true);
        });
    }else{
        $('input').each(function(i){
            $('#uniform-check_'+i+' span').attr('class', '');
            $('#check_'+i).attr('checked', false);
        });
    }   
}

function check(){
    $('#uniform-check_all span').attr('class', '');
    $('#check_all').attr('checked', false);    
}

function simpanData(){
    var item_check = 0;
    $('input').each(function(i){
        if($('#check_'+i).prop("checked")){
            item_check += 1;                    
        }
    });
    
    if($.trim($("#no_po").val()) == ""){
        $('#message').html("Nomor PO harus diisi, tidak boleh kososng!");
        $('.alert-danger').show(); 
    }else if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi, tidak boleh kososng!");
        $('.alert-danger').show(); 
    }else if($.trim($("#supplier_id").val()) == ""){
        $('#message').html("Silahkan pilih nama supplier!");
        $('.alert-danger').show(); 
    }else if($.trim($("#term_of_payment").val()) == ""){
        $('#message').html("Term of payment harus diisi!");
        $('.alert-danger').show(); 
    }else{    
        if(item_check==0){
            $('#message').html("Silahkan pilih item spare part yang akan di-create PO!"); 
            $('.alert-danger').show(); 
        }else{
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/BeliSparePart/get_penomoran_po'); ?>",
                data: {
                    no_po: $('#no_po').val(),
                    tanggal: $('#tanggal').val()
                },
                cache: false,
                success: function(result) {
                    var res = result['type'];
                    if(res=='duplicate'){
                        $('#message').html("Nomor PO sudah ada, tolong coba lagi!");
                        $('.alert-danger').show();
                    }else{
                        $('#simpanData').text('Please Wait ...').prop("onclick", null).off("click");
                        $('#formku').submit(); 
                    }
                }
            });
        }
    };
};
</script>

<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$(function(){
    $('#show_kurs').hide();
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