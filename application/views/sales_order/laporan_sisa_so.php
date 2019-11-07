<div class="row">
    <div class="col-md-12 alert-warning alert-dismissable">        
        <h5 style="color:navy">
            <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> Home </a> 
            <i class="fa fa-angle-right"></i> Laporan Finance
            <i class="fa fa-angle-right"></i> 
            <a href="<?php echo base_url('index.php/Finance/index'); ?>">Finance</a> 
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
        <h3>Laporan Sisa Sales Order</h3>
        <hr class="divider">
        <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                           Laporan <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <select id="laporan" name="laporan" class="form-control select2me myline" data-placeholder="Pilih..." style="margin-bottom:5px">
                                    <option value="0">Global</option>
                                    <option value="1">Per Jenis Barang</option>
                                </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                           Jenis <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <select id="jenis" name="jenis" class="form-control select2me myline" data-placeholder="Pilih..." style="margin-bottom:5px">
                                    <option value=""></option> 
                                    <?php if($this->session->userdata('user_ppn')==1){ ?>
                                    <option value="1">KMP</option>
                                    <?php }else{ ?>
                                    <option value="0">KH</option>
                                    <option value="2">KMP + KH</option>
                                    <?php } ?>
                                </select>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-4">&nbsp;</div>
                        <div class="col-md-8">
                            <a href="javascript:;" class="btn green" onclick="simpanData();"> 
                                <i class="fa fa-search"></i> Proses </a>
                        </div>    
                    </div>
                </div>        
            </div>
    </div>
<script type="text/javascript">
function simpanData(){
    if($.trim($("#laporan").val()) == ""){
        $('#message').html("Laporan harus dipilih, tidak boleh kosong!");
        $('.alert-danger').show();
    }else if($.trim($("#jenis").val()) == ""){
        $('#message').html("Jenis harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();
    }else{     
        var l=$('#laporan').val();
        var j=$('#jenis').val();
        window.open('<?php echo base_url();?>index.php/SalesOrder/print_laporan_sisa_so?l='+l+'&j='+j,'_blank');
    };
};
</script>