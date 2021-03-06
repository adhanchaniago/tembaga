<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h5 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Pembelian 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/BeliRongsok'); ?>"> Pembelian Rongsok </a> 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/BeliRongsok/edit_dtr'); ?>"> Review TTR </a> 
        </h5>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12">
        <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h3 align="center"><b>Approve TTR</b></h3>
                    <hr class="divider" />
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
                        <form class="eventInsForm" method="post" target="_self" name="frmReject" 
                              id="frmReject">                            
                            <div class="row">
                                <div class="col-md-4">
                                    No TTR<font color="#f00">*</font>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="nomor_ttr" name="nomor_ttr" class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()">
                                    
                                    <input type="hidden" id="header_id" name="header_id">
                                    <input type="hidden" id="jml_afkir" name="jml_afkir">
                                    <input type="hidden" id="jml_packing" name="jml_packing">
                                    <input type="hidden" id="jml_lain" name="jml_lain">
                                    <input type="hidden" id="tgl" name="tanggal">
                                    <input type="hidden" id="dtr_type_1" name="dtr_type">
                                </div>
                            </div>     
                            <div class="row">
                                <div class="col-md-4">
                                    No Surat Jalan
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="no_sj" name="no_sj" class="form-control myline" style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>      
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" id="approveData" onClick="approveData();">Simpan</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if( ($group_id==1)||($hak_akses['review_ttr']==1) ){
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger <?php echo (empty($this->session->flashdata('flash_msg'))? "display-hide": ""); ?>" id="box_msg_sukses">
                    <button class="close" data-close="alert"></button>
                    <span id="msg_sukses"><?php echo $this->session->flashdata('flash_msg'); ?></span>
                </div>
            </div>
        </div>
        <form class="eventInsForm" method="post" target="_self" name="formku" 
              id="formku" action="#">  
            <div class="row">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            No. DTR <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_dtr" name="no_dtr" readonly="readonly"
                                class="form-control myline" style="margin-bottom:5px" 
                                value="<?php echo $header['no_dtr']; ?>">

                            <input type="hidden" id="dtr_type" name="dtr_type" value="<?=$header['type'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Tanggal DTR <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="tgl-dtr" name="tgl_dtr" readonly="readonly"
                                class="form-control myline input-small" style="margin-bottom:5px;float:left;" 
                                value="<?php echo date('d-m-Y', strtotime($header['tgl_dtr'])); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Tanggal <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="tanggal" name="tanggal"
                                class="form-control myline input-small" style="margin-bottom:5px;float:left;" 
                                value="<?php echo date('d-m-Y', strtotime($header['tgl_dtr'])); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            No. PO 
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_po" name="no_po" readonly="readonly"
                                class="form-control myline" style="margin-bottom:5px" 
                                value="<?php echo $header['no_po']; ?>">
                            <input type="hidden" id="id" name="id" value="<?php echo $header['id']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-5"> 
                    <div class="row">
                        <div class="col-md-4">
                            Supplier
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="supplier" name="supplier" 
                                class="form-control myline" style="margin-bottom:5px" readonly="readonly" 
                                value="<?php echo $header['nama_supplier']; ?>">

                            <input type="hidden" id="id_customer" name="id_customer" value="<?php echo $header['id_customer']; ?>">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4">
                            No TTR
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="jenis_barang" name="jenis_barang" 
                                class="form-control myline" style="margin-bottom:5px" readonly="readonly" 
                                value="auto generate if approved">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4">
                            Jumlah Afkir
                        </div>
                        <div class="col-md-8">
                            <input type="number" id="jumlah_afkir" name="jumlah_afkir" 
                                class="form-control myline" style="margin-bottom:5px" value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Jumlah Packing
                        </div>
                        <div class="col-md-8">
                            <input type="number" id="jumlah_packing" name="jumlah_packing" 
                                class="form-control myline" style="margin-bottom:5px" value="<?=$header['pengepakan'];?>">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4">
                            Jumlah Lain Lain
                        </div>
                        <div class="col-md-8">
                            <input type="number" id="jumlah_lain" name="jumlah_lain" 
                                class="form-control myline" style="margin-bottom:5px" value="0">
                        </div>
                    </div>                    
                </div>              
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <th>No</th>
                                <th>Nama Item Rongsok</th>
                                <th>UOM</th>
                                <th>Bruto (Kg)</th>
                                <th>Berat Palette</th>
                                <th>Netto (Kg)</th>
                                <th>No. Pallete</th>
                                <th>Keterangan</th>
                            </thead>
                            <tbody>
                            <?php
                                $no = 1;
                                $bruto = 0;
                                $berat = 0;
                                $netto = 0;
                                foreach ($details as $row){
                                    echo '<tr>';
                                    echo '<td style="text-align:center">'.$no.'</td>';
                                    echo '<td>'.$row->nama_item.'</td>';
                                    echo '<td>'.$row->uom.'</td>';
                                    echo '<td>'.number_format($row->bruto,2,'.',',').'</td>';
                                    echo '<td>'.number_format($row->berat_palette,2,'.',',').'</td>';
                                    echo '<td>'.number_format($row->netto,2,'.',',').'</td>';
                                    echo '<td>'.$row->no_pallete.'</td>';
                                    echo '<td>'.$row->line_remarks.'</td>';
                                    echo '</tr>';
                                    $no++;
                                    $bruto += $row->bruto;
                                    $berat += $row->berat_palette;
                                    $netto += $row->netto;
                                }
                            ?>
                            <tr>
                                <td colspan="3" style="text-align: right;"><b>Total :</b></td>
                                <td style="background-color: green; color: white;"><?=number_format($bruto,2,',','.');?></td>
                                <td style="background-color: green; color: white;"><?=number_format($berat,2,',','.');?></td>
                                <td style="background-color: green; color: white;"><?=number_format($netto,2,',',',');?></td>
                                <td colspan="2"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col-md-12">
                    <a href="javascript:;" class="btn green" onclick="approveTTR(<?=$header['id'];?>);"> 
                        <i class="fa fa-check"></i> Terima TTR </a>
                    <a href="javascript:;" class="btn red" onclick="rejectTTR(<?=$header['id'];?>);"> 
                        <i class="fa fa-times"></i> Tolak TTR </a>
                    <?php if(substr($header['no_dtr'],0,5)=='DTR-T'){?>
                    <a href="<?php echo base_url('index.php/Tolling/ttr_list'); ?>" class="btn blue-hoki"> 
                        <i class="fa fa-angle-left"></i> Kembali </a>
                    <?php }else{ ?>
                    <a href="<?php echo base_url('index.php/BeliRongsok/ttr_list'); ?>" class="btn blue-hoki"> 
                        <i class="fa fa-angle-left"></i> Kembali </a>
                    <?php } ?>
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
// function approveTTR(id_ttr){
//     const jumlah_afkir = $('#jumlah_afkir').val();
//     const jumlah_packing = $('#jumlah_packing').val();
//     const jumlah_lain = $('#jumlah_lain').val();
//     $.ajax({
//         url: "<?php echo base_url('index.php/BeliRongsok/approve_ttr'); ?>",
//         type: "POST",
//         data : {
//             id: id_ttr,
//             jumlah_afkir: jumlah_afkir,
//             jumlah_packing: jumlah_packing,
//             jumlah_lain: jumlah_lain
//         },
//         success: function (result){
//             if(result['status']){
//                 alert(result['message']);
//                 setTimeout(function(){
//                     if($('#no_dtr').val().substring(0, 5)=='DTR-T'){
//                         window.location="<?=base_url('index.php/Tolling/ttr_list');?>";
//                     }else{
//                     window.location="<?=base_url('index.php/BeliRongsok/ttr_list');?>";
//                     }
//                 },1000);
//             }
//         }
//     });
// }
function approveData(){
    if($.trim($("#nomor_ttr").val()) == ""){
        $('#message').html("Nomor TTR harus diisi, tidak boleh kosong!");
        $('.alert-danger').show(); 
    }else{
        $('#approveData').text('Please Wait ...').prop("onclick", null).off("click");
        $('#message').html("");
        $('.alert-danger').hide();
        if($('#id_customer').val() > 0){
            $('#frmReject').attr("action", "<?php echo base_url(); ?>index.php/Tolling/approve_ttr_resmi");
        }else{
            $('#frmReject').attr("action", "<?php echo base_url(); ?>index.php/BeliRongsok/approve_ttr_resmi");
        }
        $('#frmReject').submit(); 
    }
}

function approveTTR(id_ttr){
    $('#header_id').val(id_ttr);
    $('#jml_afkir').val($('#jumlah_afkir').val());
    $('#jml_packing').val($('#jumlah_packing').val());
    $('#jml_lain').val($('#jumlah_lain').val());
    $('#tgl').val($('#tanggal').val());
    $('#dtr_type_1').val($('#dtr_type').val());
    $('#message').html("");
    $('.alert-danger').hide();
        
    $("#myModal").find('.modal-title').text('Approve TTR');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function rejectTTR(id_ttr){
    var r=confirm("Anda yakin akan menolak TTR ini?");
    if (r==true){
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/BeliRongsok/reject_ttr'); ?>',
            data:{id:id_ttr},
            success:function(result){
                if(result['status']){
                    alert(result['message']);
                    setTimeout(function(){
                        window.location="<?=base_url('index.php/BeliRongsok/ttr_list');?>";
                    },1000);
                }else{
                    alert(result['message']);
                }     
            }
        });
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
      