<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h4 style="color:navy">
            <i class="fa fa-angle-right"></i> Pembelian 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/BeliRongsok'); ?>"> Pembelian Rongsok </a> 
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/BeliRongsok/voucher_list'); ?>"> Voucher List </a> 
        </h4>          
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">                            
    <div class="col-md-12">      

        <?php
            if( ($group_id==1)||($hak_akses['voucher_list']==1) ){
        ?>
        
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-beer"></i>Voucher List
                </div>                
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>No. Voucher</th> 
                    <th>Tanggal</th> 
                    <th>Jenis Voucher</th>  
                    <th>No. PO</th>  
                    <th>Tanggal PO</th>                    
                    <th>Amount (Rp)</th> 
                    <th>Katerangan</th>
                    <!--th>Actions</th-->
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
                        <td><?php echo $data->no_voucher; ?></td>
                        <td style="text-align:center"><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>
                        <td><?php echo $data->jenis_voucher; ?></td>
                        <td><?php echo $data->no_po; ?></td>
                        <td style="text-align:center"><?php echo date('d-m-Y', strtotime($data->tanggal_po)); ?></td>
                        <td style="text-align:right"><?php echo number_format($data->amount,0,',','.'); ?></td>
                        <td><?php echo $data->keterangan; ?></td>                        
                        <!--td style="text-align:center">                             
                            
                        </td-->
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
       