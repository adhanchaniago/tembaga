<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h5 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Laporan Rongsok
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/GudangFG/laporan_list'); ?>"> List Laporan Finish Good </a> 
        </h5>          
    </div>
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success <?php echo (empty($this->session->flashdata('flash_msg'))? "display-hide": ""); ?>" id="box_msg_sukses">
                <button class="close" data-close="alert"></button>
                <span id="msg_sukses"><?php echo $this->session->flashdata('flash_msg'); ?></span>
            </div>
        </div>
    </div>
    <div class="collapse well" id="form_filter" >
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                       Bulan <font color="#f00">*</font>
                    </div>
                    <div class="col-md-8">
                        <select id="bulan" name="bulan" class="form-control select2me myline" data-placeholder="Pilih..." style="margin-bottom:5px">
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Tahun
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control myline" style="margin-bottom:5px" id="tahun" name="tahun" maxlength="4" value="<?=date('Y');?>">
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-4">&nbsp;</div>
                    <div class="col-md-8">
                        <a href="javascript:;" class="btn green" id="proses_button" onclick="searchFilter();"> 
                            <i class="fa fa-refresh"></i> Proses </a>
                    </div>    
                </div>
            </div>  
        </div>
    </div>
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cubes"></i> Laporan Finish Good
                </div> 
                <div class="tools">
                    <a style="height:28px" class="btn btn-circle btn-sm blue-ebonyclay" href="#form_filter" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="form_filter">
                        <i class="fa fa-refresh"></i> Proses Laporan Inventory
                    </a>
                </div>                             
            </div> 
           <div class="portlet-body"> 
               <table width="100%" class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                   <tr >
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Stok Awal Netto</th>
                        <th>Stok Akhir Netto</th>
                        <th width="50%">Keterangan</th>
                   </tr>
                 </thead>
                 <tbody>
                <?php $no=0;
                $arr = array();
                foreach ($list as $data){ 
                            $no++;
                    ?>
                    <tr>
                        <td></td>
                        <td><?= $data->showdate ;?></td>
                        <td><?= number_format($data->stok_awal, 2, '.', ',') ;?></td>
                        <td><?= number_format($data->stok_akhir, 2, '.', ',') ;?></td>
                        <td><?php
                        if($group_id==1 || $group_id==21 || $hak_akses['view_spb']==1){
                        ?>
                            <a class="btn btn-circle btn-xs blue" href="<?php echo base_url(); ?>index.php/GudangFG/view_laporan/<?php echo $data->tanggal; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa  fa-file-text-o"></i> View &nbsp; </a>
                            <a class="btn btn-circle btn-xs blue-ebonyclay" href="<?php echo base_url(); ?>index.php/GudangFG/print_laporan_bulanan/<?php echo $data->tanggal; ?>" style="margin-bottom:4px" target="_blank"> &nbsp; <i class="fa  fa-print"></i> Print All &nbsp; </a>
                            <select id="laporan_<?=$no;?>" data-placeholder="Laporan Bulanan FG ..." class="myline select2me" style="margin-bottom:5px; width:50%; height: 75%;" onchange="show_btn(this.value,<?=$no;?>);">
                                <option value="0"></option>
                                <optgroup label="Laporan FG">
                                    <option value="5">Laporan FG</option>
                                    <option value="29">Laporan FG Aluminium</option>
                                </optgroup>
                                <optgroup label="Laporan KMP">
                                    <option value="1">Laporan KMP</option>
                                    <option value="2">Laporan KMP Aluminium</option>
                                </optgroup>
                                <optgroup label="Laporan TMS">
                                    <option value="3">Laporan TMS</option>
                                    <option value="4">Laporan TMS Aluminium</option>
                                </optgroup>
                                <optgroup label="Laporan INDOKA">
                                    <option value="6">Laporan INDOKA</option>
                                    <option value="7">Laporan INDOKA Aluminium</option>
                                </optgroup>
                            </select>
                            <a class="btn btn-circle btn-xs blue-ebonyclay" href="javascript:;" style="margin-bottom:4px; display: none;" onclick="print_laporan(<?=$no.',\''.$data->tanggal.'\'';?>);" id="btn_laporan_<?=$no;?>"> &nbsp; <i class="fa  fa-print"></i> Print Laporan&nbsp; </a>
                            <a class="btn btn-circle btn-xs green" href="<?php echo base_url(); ?>index.php/GudangFG/edit_laporan_bulanan/<?php echo $data->tanggal; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa  fa-pencil"></i> Edit &nbsp; </a>
                        <?php
                            }//if group
                }//foreach?>
                </tbody>   
                </table>
            </div>
        </div>
    </div>
<script type="text/javascript">
function show_btn(id,no){
    if(id==0){
        $('#btn_laporan_'+no).hide();
    }else{
        $('#btn_laporan_'+no).show();
    }
}

function print_laporan(id,tgl){
        var l = $('#laporan_'+id).val();
        window.open('<?php echo base_url();?>index.php/GudangFG/print_laporan_fg/'+tgl+'/'+l,'_blank');
}

function searchFilter(){
    $('#proses_button').text('Please Wait ... ');
    var s=$('#bulan').val();
    var e=$('#tahun').val();
    window.location.href = '<?php echo base_url();?>index.php/GudangFG/proses_inventory?b='+s+'&t='+e;
}
</script>