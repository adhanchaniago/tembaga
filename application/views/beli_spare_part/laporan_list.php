<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h5 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Laporan Sparepart
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/BeliSparePart/laporan_list'); ?>"> List Laporan Sparepart </a> 
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
  
   <div class="col-md-12" style="margin-top: 10px;"> 
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cubes"></i> Laporan BeliSparePart
                </div>                            
            </div> 
           <div class="portlet-body"> 
               <table width="100%" class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                   <tr >
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Jumlah <br>Item</th>
                        <th>Stok Bruto <br>Sebelum</th>
                        <th>Stok Netto <br>Sebelum</th>
                        <th>Bruto <br>Masuk</th>
                        <th>Netto <br>Masuk</th>
                        <th>Bruto <br>Keluar</th>
                        <th>Netto <br>Keluar</th>
                        <th>Stok Bruto <br>Akhir</th>
                        <th>Stok Netto <br>Akhir</th>
                        <th>Keterangan</th>
                   </tr>
                 </thead>
                 <tbody>
                <?php $no=0;
                if(isset($reg)) { foreach ($reg as $data){ ?>
                    <tr>
                        <td><?= $no;?></td>
                        <td><?= $data['showdate'] ;?></td>
                        <td><?= $data['jumlah'] ;?></td>
                        <td style="background-color: powderblue;"><?= ($data['bruto_masuk_b'] - $data['bruto_keluar_b']) - ($data['bruto_masuk'] - $data['bruto_keluar']) ;?></td>
                        <td style="background-color: powderblue;"><?= ($data['netto_masuk_b'] - $data['netto_keluar_b']) - ($data['netto_masuk'] -$data['netto_keluar']) ;?></td>
                        <td><?= $data['bruto_masuk'] ;?></td>
                        <td><?= $data['netto_masuk'] ;?></td>
                        <td><?= $data['bruto_keluar'] ;?></td>
                        <td><?= $data['netto_keluar'] ;?></td>
                        <td style="background-color: turquoise;"><?= ($data['bruto_masuk_b'] - $data['bruto_keluar_b']) ;?></td>
                        <td style="background-color: turquoise;"><?= ($data['netto_masuk_b'] - $data['netto_keluar_b']) ;?></td>
                        <td><?php
                        if($group_id==1 || $hak_akses['view_spb']==1){
                        ?>
                            <a class="btn btn-circle btn-xs blue" href="<?php echo base_url(); ?>index.php/BeliSparePart/view_laporan/<?php echo $data['tanggal']; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa  fa-file-text-o"></i> View &nbsp; </a>
                        <?php
                            }//if group
                        }//foreach
                    echo '</tr>';
                    }//if ?>
                    <?php /*
                        $no = 1;
                        foreach($detailTanggal as $data) { ?>
                    <tr>
                        <td><?= $no;?></td>
                        <td><?= $data->showdate ;?></td>
                        <td><?= $data->jumlah ;?></td>
                        <td><?= $data->bruto_masuk ;?></td>
                        <td><?= $data->netto_masuk ;?></td>
                        <td><?= $data->bruto_keluar ;?></td>
                        <td><?= $data->netto_keluar ;?></td>
                        <td>
                        <?php
                        if($group_id==1 || $hak_akses['view_spb']==1){
                        ?>
                            <a class="btn btn-circle btn-xs blue" href="<?php echo base_url(); ?>index.php/BeliSparePart/view_laporan/<?php echo $data->tanggal; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa  fa-file-text-o"></i> View &nbsp; </a>
                            <a class="btn btn-circle btn-xs red" href="<?php echo base_url(); ?>index.php/BeliSparePart/view_detail_laporan/<?php echo $data->tanggal; ?>" style="margin-bottom:4px"> &nbsp; <i class="fa  fa-file-text-o"></i> Detail &nbsp; </a>
                        <?php
                        }
                        ?>
                        </td>
                    </tr>    
                <?php } */?>
                </tbody>   
                </table>
            </div>
        </div>
    </div>
<script>
function simpanData(){
  
        $('#formku').submit(); 

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
});
</script>
      