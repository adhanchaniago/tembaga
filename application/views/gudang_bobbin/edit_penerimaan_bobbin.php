<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h5 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Gudang Bobbin
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/GudangBobbin'); ?>"> Create Bobbin Penerimaan</a> 
        </h5>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12"> 
        <?php
            if( ($group_id==1)||($hak_akses['edit']==1) ){
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
              id="formku" action="<?php echo base_url('index.php/GudangBobbin/update_penerimaan_bobbin'); ?>">
            <div class="row">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            No. Surat Penerimaan<font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_produksi" name="no_produksi" readonly="readonly"
                                class="form-control myline" style="margin-bottom:5px" 
                                value="<?php echo $header['no_penerimaan']; ?>">
<!--                             <input type="hidden" id="id_peminjaman" name="id_peminjaman" value="<?php echo $header['id_peminjaman']; ?>"> -->
                            <input type="hidden" id="id" name="id" value="<?php echo $header['id']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Tanggal <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="tanggal" name="tanggal" 
                                class="form-control input-small myline" style="margin-bottom:5px; float:left;" 
                                value="<?php echo date('d-m-Y', strtotime($header['tanggal'])); ?>">
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
                    <?php
                            if($header['status']==0){
                                echo '<div style="background-color:green; color:white; padding:4px">Ready</div>';
                            }else if($header['status']==1){
                                echo '<div style="background-color:blue; color:white; padding:4px">Used</div>';
                            }else if($header['status']==2){
                                echo '<div style="background-color:yellow; color:black; padding:4px">Delivered</div>';
                            }else if($header['status']==3){
                                echo '<div style="background-color:orange; color:white; padding:4px">Booked</div>';
                            }  ?>
                        <input type="hidden" id="status" name="status" value="<?=$header['status'];?>">
                    <div class="row">
                        <div class="col-md-4">
                            No. Surat Jalan
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control myline" onkeyup="this.value = this.value.toUpperCase()" style="margin-bottom: 5px" readonly name="nama_pemohon" value="<?php echo $header['surat_jalan'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Customer/Supplier
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control myline" style="margin-bottom: 5px" readonly name="jenis_packing" value="<?php echo $header['pengirim'] ?>">
                        </div>
                    </div>
<!--                     <div class="row">
                        <div class="col-md-4">
                            No. Surat Peminjaman
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control myline" style="margin-bottom: 5px" readonly name="jenis_packing" value="<?php echo $header['no_surat_peminjaman'] ?>">

                            <input type="hidden" name="id_jenis" id="id_jenis" value="<?php echo $header['no_surat_peminjaman'] ?>">
                        </div>
                    </div> -->
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
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover" id="tabel_bobbin">
                            <thead>
                                <th>No</th>
                                <th>Nomor Bobbin</th>
                                <th>Berat</th>
                                <th>Actions</th>
                            </thead>
                            <tbody id="boxDetail">
                                <?php 
                                $no = 1;
                                foreach ($list_barang as $value) {
                                    echo '<tr>';
                                    echo '<td>'.$no.'</td>';
                                    echo '<td>'.$value->nomor_bobbin.'</td>';
                                    echo '<td>'.$value->berat.'</td>';
                                    echo '<td><a class="btn btn-xs btn-circle red" href="'.base_url().'index.php/GudangBobbin/delete_detail_penerimaan_bobbin/'.$header['id'].'/'.$value->id.'" style="margin-top:5px" onclick="return confirm(\'Anda yakin menghapus transaksi ini?\');"><i class="fa fa-trash"></i> Delete </a></td>';
                                    $no++;
                                }
                                ?>
                                </tr>
                                    <tr>
                                        <td style="text-align:center"><div id="no_tabel_1"><?=$no;?></div></td>
                                        <input type="hidden" id="id_bobbin_1" name="details[1][id_bobbin]">
                                        <td><input type="text" id="nomor_bobbin_1" name="details[1][nomor_bobbin]" class="form-control myline" onchange="getBobbin(1);"  autofocus onfocus="this.value = this.value;" onkeyup="this.value = this.value.toUpperCase()"></td>
                                        <td><input type="text" id="berat_1" name="details[1][berat]" class="form-control myline" readonly="readonly"></td>
                                        <td style="text-align:center"><a id="btn_1" href="javascript:;" class="btn btn-xs btn-circle red disabled" onclick="hapusDetail(1);" style="margin-top:5px"><i class="fa fa-trash"></i> Delete </a></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col-md-12">
                    <a href="javascript:;" class="btn green" onclick="simpanData();"> 
                        <i class="fa fa-floppy-o"></i> Simpan </a>
                        
                    <a href="<?php echo base_url('index.php/GudangBobbin/bobbin_terima'); ?>" class="btn blue-hoki"> 
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
function simpanData(){
    if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show(); 
    }else{     
        $('#formku').submit(); 
    };
};

function getBobbin(id){
    var no = $("#nomor_bobbin_"+id).val();
    const new_id = id + 1;
    if(no!=''){    
        var check = check_duplicate();
        if(check){
            $.ajax({
                url: "<?php echo base_url('index.php/GudangBobbin/get_bobbin_deliver'); ?>",
                type: "POST",
                data : {nomor_bobbin: no},
                success: function (result){
                    if (result!=null){
                        $("#id_bobbin_"+id).val(result['id']);
                        $("#berat_"+id).val(result['berat']);
                        $("#btn_"+id).removeClass('disabled');
                        $("#nomor_bobbin_"+id).prop('readonly', true);
                        create_new_input(id);
                        $('#nomor_bobbin_'+new_id).focus();
                    } else {
                        alert('Nomor Bobbin tidak ditemukan, silahkan ulangi kembali');
                        $("#nomor_bobbin_"+id).val('');
                    }
                }
            });
        } else {
            //alert('Inputan pallete tidak boleh sama dengan inputan sebelumnya!');
            $("#nomor_bobbin_"+id).val('');
        }
    }
}

function hapusDetail(id){
    var r=confirm("Anda yakin menghapus item bobbin ini?");
    if (r==true){
        $('#nomor_bobbin_'+id).closest('tr').remove();
        }
}

function create_new_input(id){
       var new_id = id+1;
       const nomor = id+<?=$no;?>;
        $("#tabel_bobbin>tbody").append('<tr>'+
            '<tr>'+
                '<td style="text-align:center"><div id="no_tabel_'+new_id+'">'+nomor+'</div></td>'+
                '<input type="hidden" id="id_bobbin_'+new_id+'" name="details['+new_id+'][id_bobbin]">'+
                '<td><input type="text" id="nomor_bobbin_'+new_id+'" name="details['+new_id+'][nomor_bobbin]" class="form-control myline" onchange="getBobbin('+new_id+');"  autofocus onfocus="this.value = this.value;" onkeyup="this.value = this.value.toUpperCase()"></td>'+
                '<td><input type="text" id="berat_'+new_id+'" name="details['+new_id+'][berat]" class="form-control myline" readonly="readonly"></td>'+
                '<td style="text-align:center"><a id="btn_'+new_id+'" href="javascript:;" class="btn btn-xs btn-circle red disabled" onclick="hapusDetail('+new_id+');" style="margin-top:5px"><i class="fa fa-trash"></i> Delete </a></td>'+
            '</tr>');
}

function check_duplicate(){
    var valid = true;
        $.each($("select[name$='[barang_id]']"), function (index1, item1) {
            $.each($("select[name$='[barang_id]']").not(this), function (index2, item2) {
                if ($(item1).val() == $(item2).val()) {
                    valid = false;
                }
            });
        });
        return valid;
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
    
    // loadDetail(<?php echo $header['id']; ?>);
});
</script>
      