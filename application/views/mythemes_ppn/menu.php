<!-- CONTAINER -->
<div class="page-container">
    <!-- SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <!-- SIDEBAR MENU -->
            <?php
            $module_name = $this->uri->segment(1);
            $action_name = $this->uri->segment(2);
            $group_id    = $this->session->userdata('group_id');
            $CI =& get_instance();
            if($group_id != 1){
                $CI->load->model('Model_modules');
                $akses_menu = $CI->Model_modules->akses_menu($group_id);
                // print_r($akses_menu);
            }
            ?>
            <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">				
                <li class="sidebar-toggler-wrapper">
                    <!-- SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler"></div>
                </li>                
                
                
                <?php if($group_id==1 || (isset($akses_menu['BeliSparePart']) || isset($akses_menu['BeliRongsok']) || isset($akses_menu['BeliFinishGood']) || isset($akses_menu['BeliWIP']))){ ?>
                <li <?php if($module_name=="BeliSparePart" || $module_name=="BeliRongsok" || $module_name=="IngotRendah" || $module_name=="BeliFinishGood" || $module_name=="BeliWIP") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="icon-folder"></i>
                    <span class="title">PEMBELIAN</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if($group_id==1 || (isset($akses_menu['BeliSparePart']) && $akses_menu['BeliSparePart']==1)){ ?>
                        <li <?php if($module_name=="BeliSparePart") echo 'class="start active open"'; ?>>
                            <a href="javascript:;">
                            <i class="fa fa-cogs"></i>
                            <span class="title">SPARE PART</span>
                            <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <?php if($group_id==1 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliSparePart">
                                    <i class="fa fa-send"></i>
                                    Beli Spare Part </a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['po_list']) && $akses_menu['po_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliSparePart/po_list">
                                    <i class="fa fa-file-word-o"></i>
                                    PO List </a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['spb_list']) && $akses_menu['spb_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliSparePart/spb_list">
                                    <i class="fa fa-file-word-o"></i>
                                    SPB List </a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['bpb_list']) && $akses_menu['bpb_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliSparePart/bpb_list">
                                    <i class="fa fa-cubes"></i>
                                    BPB List </a>
                                </li> 
                                <?php } if($group_id==1 || (isset($akses_menu['lpb_list']) && $akses_menu['lpb_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliSparePart/lpb_list">
                                    <i class="fa fa-usd"></i>
                                    LPB List </a>
                                </li>
                                <?php }  if($group_id==1 || (isset($akses_menu['voucher_list']) && $akses_menu['voucher_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliSparePart/voucher_list">
                                    <i class="fa fa-usd"></i>
                                    Voucher List </a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['laporan']) && $akses_menu['laporan']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliSparePart/laporan_list">
                                    <i class="fa fa-usd"></i>
                                    Laporan SP </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliSparePart/gudang_sparepart">
                                    <i class="fa fa-cubes"></i>
                                    Gudang SP </a>
                                </li>
                            <?php } ?>
                            </ul>
                        </li>
                        <?php } if($group_id==1 || (isset($akses_menu['BeliRongsok']) && $akses_menu['BeliRongsok']==1)){ ?>
                        <li <?php if($module_name=="BeliRongsok") echo 'class="start active open"'; ?>>
                            <a href="javascript:;">
                            <i class="fa fa-rocket"></i>
                            <span class="title">RONGSOK</span>
                            <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <?php if($group_id==1 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliRongsok">
                                    <i class="fa fa-file-word-o"></i>
                                    PO List </a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['create_dtr']) && $akses_menu['create_dtr']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliRongsok/dtr_list">
                                    <i class="fa fa-file-excel-o"></i>
                                    DTR List </a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['matching']) && $akses_menu['matching']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliRongsok/matching">
                                    <i class="fa fa-chain"></i>
                                    Matching PO - DTR</a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['ttr_list']) && $akses_menu['ttr_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliRongsok/ttr_list">
                                    <i class="fa fa-file-powerpoint-o"></i>
                                    TTR List </a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['voucher_list']) && $akses_menu['voucher_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliRongsok/voucher_list">
                                    <i class="fa fa-usd"></i>
                                    Voucher List </a>
                                </li>
                                <?php } ?>
                                <!-- <?php if($group_id==1 || (isset($akses_menu['view_laporan']) && $akses_menu['view_laporan']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliRongsok/laporan_list">
                                    <i class="fa fa-briefcase"></i>
                                    Laporan Rongsok </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliRongsok/gudang_rongsok">
                                    <i class="fa fa-cubes"></i>
                                    Gudang Rongsok </a>
                                </li>
                                <?php } ?> -->
                            </ul>
                        </li>
                        <?php } ?>
                        
                        <!-- <li <?php if($module_name=="IngotRendah") echo 'class="start active open"'; ?>>
                            <a href="javascript:;">
                            <i class="fa fa-openid"></i>
                            <span class="title">INGOT RENDAH</span>
                            <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/IngotRendah">
                                    <i class="fa fa-file-word-o"></i>
                                    PO List </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/IngotRendah/dtr_list">
                                    <i class="fa fa-file-excel-o"></i>
                                    DTR List </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/IngotRendah/ttr_list">
                                    <i class="fa fa-file-powerpoint-o"></i>
                                    TTR List </a>
                                </li>
                            </ul>
                        </li> -->
                        <?php if($group_id==1 || (isset($akses_menu['BeliFinishGood']) && $akses_menu['BeliFinishGood']==1)){ ?>
                        <li <?php if($module_name=="BeliFinishGood") echo 'class="start active open"'; ?>>
                            <a href="javascript:;">
                                <i class="fa fa-cubes"></i>
                                <span class="title">FINISH GOOD</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                            <?php if($group_id==1 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliFinishGood">
                                        <i class="fa fa-file-word-o"></i>
                                        PO List
                                    </a>
                                </li>
                            <?php } if($group_id==1 || (isset($akses_menu['dtbj_list']) && $akses_menu['dtbj_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliFinishGood/dtbj_list">
                                        <i class="fa fa-file-text-o"></i>
                                        DTBJ List
                                    </a>
                                </li>
                            <?php } if($group_id==1 || (isset($akses_menu['matching']) && $akses_menu['matching']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliFinishGood/matching">
                                        <i class="fa fa-chain"></i>
                                        Matching PO - DTBJ
                                    </a>
                                </li>
                            <?php } ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliFinishGood/voucher_list">
                                        <i class="fa fa-usd"></i>
                                        Voucher List
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } if($group_id==1 || (isset($akses_menu['BeliWIP']) && $akses_menu['BeliWIP']==1)){ ?>
                        <li <?php if($module_name=="BeliWIP") echo 'class="start active open"'; ?>>
                            <a href="javascript:;">
                                <i class="fa fa-life-ring"></i>
                                <span class="title">WIP</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <?php if($group_id==1 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliWIP">
                                        <i class="fa fa-file-word-o"></i>
                                        PO List
                                    </a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['dtwip_list']) && $akses_menu['dtwip_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliWIP/dtwip_list">
                                        <i class="fa fa-file-text-o"></i>
                                        DTWIP List
                                    </a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['matching_dtwip']) && $akses_menu['matching_dtwip']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliWIP/matching">
                                        <i class="fa fa-chain"></i>
                                        Matching PO - DTWIP
                                    </a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['voucher_list']) && $akses_menu['voucher_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/BeliWIP/voucher_list">
                                        <i class="fa fa-usd"></i>
                                        Voucher List
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    </ul>
                </li>
                <?php } if($group_id==1 || (isset($akses_menu['Tolling']) && $akses_menu['Tolling']==1)){ ?>
                <li <?php if($module_name=="Tolling") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-user"></i>
                    <span class="title">TOLLING TITIPAN</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li <?php if($module_name=="Tolling") echo 'class="start active open"'; ?>>
                            <a href="javascript:;">
                            <i class="fa fa-cogs"></i>
                            <span class="title">Tolling Customer</span>
                            <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <?php if($group_id==1 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling">
                                    <i class="fa fa-truck"></i>
                                    Sales Order</a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['dtr_list']) && $akses_menu['dtr_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/dtr_list">
                                    <i class="fa fa-file-excel-o"></i>
                                    DTR List </a>
                                </li>
                                <?php } if($group_id==1 || (isset($akses_menu['ttr_list']) && $akses_menu['ttr_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/ttr_list">
                                    <i class="fa fa-file-powerpoint-o"></i>
                                    TTR List </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/dtwip_list">
                                        <i class="fa fa-file-text-o"></i>
                                        DTWIP List
                                    </a>
                                </li>
                                <!-- <li>
                                    <a href="<?php //echo base_url(); ?>index.php/Tolling/produksi_ampas">
                                    <i class="fa fa-trash"></i>
                                    Produksi Ampas </a>
                                </li> -->
                            <?php } if($group_id==1 || (isset($akses_menu['surat_jalan']) && $akses_menu['surat_jalan']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/surat_jalan">
                                    <i class="fa fa-truck"></i>
                                    Surat Jalan </a>
                                </li>
                            <?php } ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/cek_balance">
                                    <i class="fa fa-balance-scale"></i>
                                    Cek Balance </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/laporan_sisa_tolling_customer">
                                    <i class="fa fa-print"></i>
                                    Laporan Sisa Balance </a>
                                </li>
                            </ul>
                        </li>
                        <li <?php if($module_name=="Tolling") echo 'class="start active open"'; ?>>
                            <a href="javascript:;">
                            <i class="fa fa-rocket"></i>
                            <span class="title">Tolling Supplier</span>
                            <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <!-- <li>
                                    <a href="#">
                                    <i class="fa fa-file-word-o"></i>
                                    Under Construction </a>
                                </li> -->
                            <?php if($group_id==1 || (isset($akses_menu['spb_list']) && $akses_menu['spb_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/spb_list">
                                    <i class="fa fa-file-word-o"></i>
                                    SPB Keluar </a>
                                </li>
                            <?php } if($group_id==1 || (isset($akses_menu['surat_jalan']) && $akses_menu['surat_jalan']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/surat_jalan_keluar">
                                    <i class="fa fa-truck"></i>
                                    Surat Jalan Keluar </a>
                                </li>
                            <?php } if($group_id==1 || (isset($akses_menu['po_list']) && $akses_menu['po_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/po_list">
                                    <i class="fa fa-cubes"></i>
                                    PO List </a>
                                </li>
                            <?php } if($group_id==1 || (isset($akses_menu['dtr_list']) && $akses_menu['dtr_list']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/dtt_list">
                                        <i class="fa fa-book"></i>
                                        DTT LIST
                                    </a>
                                </li>
                            <?php } if($group_id==1 || (isset($akses_menu['matching']) && $akses_menu['matching']==1)){ ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/matching">
                                        <i class="fa fa-file-text-o"></i>
                                        Matching Tolling
                                    </a>
                                </li>
                            <?php } ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/voucher_list">
                                        <i class="fa fa-usd"></i>
                                        Voucher List
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Tolling/cek_balance_po">
                                    <i class="fa fa-balance-scale"></i>
                                    Cek Balance </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            <?php } if($group_id==1 || (isset($akses_menu['Ingot']) && $akses_menu['Ingot']==1)){ ?>
                <li <?php if($module_name=="Ingot" || $action_name=="produksi_wip" || $action_name=="produksi_fg") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-industry"></i>
                    <span class="title">PRODUKSI</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li <?php if($module_name=="Ingot") echo 'class="start active open"'; ?>>
                            <a href="javascript:;">
                            <i class="fa fa-eraser"></i>
                            <span class="title">PRODUKSI INGOT</span>
                            <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Ingot">
                                    <i class="fa fa-flask"></i>
                                    Create Produksi</a>
                                </li>
                                <?php if($group_id==1 || (isset($akses_menu['spb_list']) && $akses_menu['spb_list']==1)){ ?>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Ingot/filter_spb/1">
                                        <i class="fa fa-file-excel-o"></i>
                                        SPB List </a>
                                    </li>
                                <?php } ?>
                                <!-- <li>
                                        <a href="<?php echo base_url(); ?>index.php/Ingot/skb_list">
                                        <i class="fa fa-file-powerpoint-o"></i>
                                        SKB List </a>
                                    </li> -->
                                <?php if($group_id==1 || (isset($akses_menu['hasil_produksi']) && $akses_menu['hasil_produksi']==1)){ ?>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Ingot/hasil_produksi">
                                        <i class="fa fa-fire"></i>
                                        Hasil Produksi </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Ingot/hasil_produksi2">
                                        <i class="fa fa-fire"></i>
                                        Hasil Produksi 2 </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php if($group_id==1 || (isset($akses_menu['hasil_produksi']) && $akses_menu['hasil_produksi']==1)){ ?>
                        <li><a href="javascript:;">
                                <i class="fa fa-life-ring"></i>
                                <span class="title">Rolling</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/GudangWIP/produksi_wip/ROLLING">
                                    <i class="fa fa-life-ring"></i>
                                    Produksi Rolling </a>
                                </li>
                                <!-- <li>
                                    <a href="<?php echo base_url(); ?>index.php/GudangWIP/spb_list/ROLLING">
                                    <i class="fa fa-file-word-o"></i>
                                    SPB ROLLING </a>
                                </li> -->
                            </ul>
                        </li>
                        <li><a href="javascript:;">
                                <i class="fa fa-fire"></i>
                                <span class="title">Bakar Ulang</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/GudangWIP/produksi_wip/BAKAR ULANG">
                                    <i class="fa fa-fire"></i>
                                    Produksi Bakar Ulang </a>
                                </li>
                                <!-- <li>
                                    <a href="<?php echo base_url(); ?>index.php/GudangWIP/spb_list/BAKAR ULANG">
                                    <i class="fa fa-file-word-o"></i>
                                    SPB Bakar Ulang </a>
                                </li> -->
                            </ul>
                        </li>
                        <li><a href="javascript:;">
                                <i class="fa fa-tty"></i>
                                <span class="title">Cuci</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/GudangWIP/produksi_wip/CUCI">
                                    <i class="fa fa-tty"></i>
                                    Produksi Cuci </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/GudangWIP/spb_list/CUCI">
                                    <i class="fa fa-file-word-o"></i>
                                    SPB Cuci </a>
                                </li>
                            </ul>
                        </li>
                        <?php } if($group_id==1 || (isset($akses_menu['produksi']) && $akses_menu['produksi']==1)){  ?>
                        <li <?php if($action_name=="produksi_fg") echo 'class="start active open"'; ?>>
                            <a href="<?php echo base_url(); ?>index.php/GudangFG/produksi_fg">
                            <i class="fa fa-cube"></i>
                            Produksi FG </a>
                        </li>
                        <?php } ?>
                        
                    </ul>
                </li>
            <?php } if($group_id==1 || ( (isset($akses_menu['GudangWIP'])&&$akses_menu['GudangWIP']==1) || (isset($akses_menu['GudangFG'])&&$akses_menu['GudangFG']==1) ) ){ ?>
                <li <?php if(($module_name=="GudangRongsok") || ($module_name=="GudangWIP" && $action_name!="produksi_wip" && $action_name!="proses_wip") || ($module_name=="GudangFG" && $action_name!="produksi_fg") || ($module_name=="StokOpname")) echo 'class="start active open"'; ?>>
                    <a href="#">
                    <i class="fa fa-cubes"></i>
                    <span class="title">GUDANG</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li <?php if($module_name=="GudangRongsok") echo 'class="start active open"'; ?>>
                        <a href="#">
                        <i class="fa fa-circle"></i>
                        <span class="title">RONGSOK</span>
                        <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                        <?php if($group_id==1 || (isset($akses_menu['spb_list']) && $akses_menu['spb_list']==1)){ ?>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/GudangRongsok/spb_list">
                                <i class="fa fa-file-excel-o"></i>
                                SPB Rongsok </a>
                            </li>
                        <?php }  if($group_id==1 || (isset($akses_menu['view_laporan']) && $akses_menu['view_laporan']==1)){ ?>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/GudangRongsok/gudang_rongsok">
                                <i class="fa fa-cubes"></i>
                                Gudang Rongsok </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span class="title">Laporan Rongsok</span>
                                <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangRongsok/index">
                                        <i class="fa fa-search"></i>
                                        Kartu Stok Rongsok </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangRongsok/laporan_list">
                                        <i class="fa fa-briefcase"></i>
                                        Laporan Bulanan</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangRongsok/search_permintaan_gudang">
                                        <i class="fa fa-arrows-h"></i>
                                        Laporan Keluar Masuk</a>
                                    </li>
                                    <!-- <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangRongsok/search_permintaan_gudang">
                                        <i class="fa fa-print"></i>
                                        Permintaan Gudang</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangRongsok/search_permintaan_external">
                                        <i class="fa fa-print"></i>
                                        Permintaan External</a>
                                    </li> -->
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                        </li>

                        <li <?php if($module_name=="GudangWIP") echo 'class="start active open"'; ?>>
                        <a href="#">
                        <i class="fa fa-circle"></i>
                        <span class="title">WIP</span>
                        <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                        <?php if($group_id==1 || $group_id == 21 || (isset($akses_menu['spb_list']) && $akses_menu['spb_list']==1)){ ?>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/GudangWIP/spb_list">
                                <i class="fa fa-file-word-o"></i>
                                SPB WIP </a>
                            </li>
                        <?php } if($group_id==1 || $group_id == 21 || (isset($akses_menu['bpb_list']) && $akses_menu['bpb_list']==1)){ ?>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/GudangWIP/bpb_list">
                                <i class="fa fa-file-excel-o"></i>
                                BPB WIP </a>
                            </li>
                        <?php } if($group_id==1 || $group_id == 21 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/GudangWIP/stok_wip">
                                <i class="fa fa-cubes"></i>
                                Gudang WIP </a>
                            </li>
                        <?php }  ?>
                            <li>
                                <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span class="title">Laporan Gudang</span>
                                <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangWIP/kartu_stok_wip">
                                        <i class="fa fa-search"></i>
                                        Kartu Stok WIP </a>
                                    </li>
                                <?php if($group_id==1 || $group_id == 21 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangWIP/laporan_list">
                                        <i class="fa fa-briefcase"></i>
                                        Laporan WIP </a>
                                    </li>
                                <?php } if($group_id==1 || $group_id == 21 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                                    <!-- <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangWIP/stok_wip">
                                        <i class="fa fa-inbox"></i>
                                        Stok WIP </a>
                                    </li> -->
                                <?php } ?>
                                </ul>
                            </li>
                        </ul>
                        </li>

                        <li <?php if($module_name=="GudangFG") echo 'class="start active open"'; ?>>
                        <a href="#">
                        <i class="fa fa-circle"></i>
                        <span class="title">FINISH GOOD</span>
                        <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/GudangFG/spb_list">
                                <i class="fa fa-file-word-o"></i>
                                SPB FG </a>
                            </li>
                        <?php if($group_id==1 || (isset($akses_menu['bpb_list']) && $akses_menu['bpb_list']==1)){ ?>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/GudangFG/bpb_list">
                                <i class="fa fa-file-excel-o"></i>
                                BPB FG </a>
                            </li>
                        <?php } if($group_id==1 || $group_id == 21 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/GudangFG/">
                                <i class="fa fa-cubes"></i>
                                Gudang FG </a>
                            </li>
                            <?php } if($group_id==1 || $group_id == 21 || (isset($akses_menu['laporan_so']) && $akses_menu['laporan_so']==1)){ ?>
                            <li>
                                <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span class="title">Laporan Gudang</span>
                                <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangFG/kartu_stok_index">
                                        <i class="fa fa-search"></i>
                                        Kartu Stok FG </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangFG/laporan_list">
                                        <i class="fa fa-briefcase"></i>
                                        Laporan FG </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangFG/print_stok_fg" target="_blank">
                                        <i class="fa fa-print"></i>
                                        Print Stok FG </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangFG/print_stok_ukuran_fg" target="_blank">
                                        <i class="fa fa-print"></i>
                                        Stok Per Ukuran FG </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/GudangFG/laporan_pemasukan">
                                        <i class="fa fa-briefcase"></i>
                                        Pemasukan & Pengeluaran FG </a>
                                    </li>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                        </li>
                    </ul>
                </li>
            <?php } if($group_id==1 || (isset($akses_menu['PengirimanAmpas']) && $akses_menu['PengirimanAmpas']==1)){ ?>
                <li <?php if($module_name=="PengirimanAmpas") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-jsfiddle"></i>
                    <span class="title">AMPAS</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if($group_id==1 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/PengirimanAmpas">
                            <i class="fa fa-file-word-o"></i>
                            PO List </a>
                        </li><!-- 
                        <?php } if($group_id==1 || (isset($akses_menu['dtr_list']) && $akses_menu['dtr_list']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/PengirimanAmpas/dtr_list">
                            <i class="fa fa-file-excel-o"></i>
                            DTA List </a>
                        </li> -->
                        <?php } if($group_id==1 || (isset($akses_menu['spb_list']) && $akses_menu['spb_list']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/PengirimanAmpas/spb_list">
                                <i class="fa fa-file-text-o"></i>
                                SPB List
                            </a>
                        </li>
                        <?php } if($group_id==1 || (isset($akses_menu['bpb_list']) && $akses_menu['bpb_list']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/PengirimanAmpas/bpb_list">
                                <i class="fa fa-file-text-o"></i>
                                BPB List
                            </a>
                        </li>
                        <?php } if($group_id==1 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url() ?>index.php/PengirimanAmpas/gudang_ampas">
                                <i class="fa fa-cubes"></i>
                                Gudang Ampas
                            </a>
                        </li>
                        <!-- <li>
                            <a href="<?php echo base_url() ?>index.php/PengirimanAmpas/gudang_bs">
                                <i class="fa fa-cubes"></i>
                                Gudang BS
                            </a>
                        </li> -->
                        <?php } ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/PengirimanAmpas/surat_jalan">
                            <i class="fa fa-truck"></i>
                            Surat Jalan</a>
                        </li>
                    </ul>
                </li>
                <?php } ?>                        
                <!-- <li <?php if($module_name=="PengirimanSample") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-taxi"></i>
                    <span class="title">PENGIRIMAN SAMPLE</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/PengirimanSample">
                            <i class="fa fa-file-word-o"></i>
                            Request Sample </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/PengirimanSample/skb_list">
                            <i class="fa fa-file-excel-o"></i>
                            SKB List </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/PengirimanSample/surat_jalan">
                            <i class="fa fa-truck"></i>
                            Surat Jalan</a>
                        </li>
                    </ul>
                </li> -->
            <?php if($group_id==1 || (isset($akses_menu['Retur']) && $akses_menu['Retur']==1)){ ?>
                <li <?php if($module_name=="Retur") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-undo"></i>
                    <span class="title">RETUR</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                    <?php if($group_id==1 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Retur">
                                <i class="fa fa-file-text-o"></i>
                                Terima Retur
                            </a>
                        </li>
                    <?php } if($group_id==1 || (isset($akses_menu['view_retur']) && $akses_menu['view_retur']==1)){ ?>
                        <!-- <li>
                            <a href="<?php echo base_url(); ?>index.php/Retur/fulfilment_list">
                                <i class="fa fa-cubes"></i>
                                Retur Fulfilment
                            </a>
                        </li> -->
                    <?php } if($group_id==1 || (isset($akses_menu['surat_jalan']) && $akses_menu['surat_jalan']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Retur/surat_jalan">
                                <i class="fa fa-truck"></i>
                                Surat Jalan
                            </a>
                        </li>
                    <?php } ?>
                        <!-- <li>
                            <a href="<?php echo base_url(); ?>index.php/Retur">
                            <i class="fa fa-file-excel-o"></i>
                            DTR List </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Retur/ttr_list">
                            <i class="fa fa-file-text-o"></i>
                            TTR List </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Retur/request_barang_list">
                            <i class="fa fa-file-text-o"></i>
                            Request Barang List </a>
                        </li> -->
                        <!--li>
                            <a href="<?php echo base_url(); ?>index.php/PengirimanAmpas/surat_jalan">
                            <i class="fa fa-truck"></i>
                            Surat Jalan</a>
                        </li-->
                    </ul>
                </li>
            <?php } ?>
                <!-- <li <?php if($module_name=="RollingKawatHitam") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-life-ring"></i>
                    <span class="title">ROLLING KAWAT HITAM</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/RollingKawatHitam">
                            <i class="fa fa-file-word-o"></i>
                            Permintaan Barang (SPB) </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/RollingKawatHitam/skb_list">
                            <i class="fa fa-file-powerpoint-o"></i>
                            SKB List </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/RollingKawatHitam/hasil_produksi">
                            <i class="fa fa-life-ring"></i>
                            Hasil Produksi </a>
                        </li>
                    </ul>
                </li>
                <li <?php if($module_name=="CuciKawatHitam") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-ge"></i>
                    <span class="title">CUCI KAWAT HITAM</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/CuciKawatHitam">
                            <i class="fa fa-file-word-o"></i>
                            Permintaan Barang (SPB) </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/CuciKawatHitam/skb_list">
                            <i class="fa fa-file-powerpoint-o"></i>
                            SKB List </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/CuciKawatHitam/dtr_list">
                            <i class="fa fa-file-text-o"></i>
                            DTR List </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/CuciKawatHitam/ttr_list">
                            <i class="fa fa-file"></i>
                            TTR List </a>
                        </li>
                    </ul>
                </li> -->
                <?php if($group_id==1 || (isset($akses_menu['GudangBobbin']) && $akses_menu['GudangBobbin']==1)){ ?>
                <li <?php if($module_name=="GudangBobbin") echo 'class="start active open"'; ?> >
                    <a href="javascript:;">
                    <i class="fa fa-bullseye"></i>
                    <span class="title">GUDANG BOBBIN</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if($group_id==1 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/GudangBobbin">
                            <i class="fa fa-bullseye"></i>
                            Bobbin Register </a>
                        </li>
                        <?php } if($group_id==1 || (isset($akses_menu['spb_list']) && $akses_menu['spb_list']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/GudangBobbin/spb_list">
                            <i class="fa fa-file-word-o"></i>
                            SPB Bobbin </a>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/GudangBobbin/bobbin_request">
                            <i class="fa fa-file-word-o"></i>
                            Bobbin Request </a>
                        </li>
                        <?php if($group_id==1 || (isset($akses_menu['add']) && $akses_menu['add']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/GudangBobbin/bobbin_terima">
                            <i class="fa fa-file-word-o"></i>
                            Bobbin Terima Barang </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/GudangBobbin/bpk_list">
                            <i class="fa fa-square"></i>
                            Peminjaman BP & Kardus </a>
                        </li>
                    <?php } ?>
                    </ul>
                </li>
            <?php } if($group_id==1 || (isset($akses_menu['SalesOrder']) && $akses_menu['SalesOrder']==1)){ ?>
                <li <?php if($module_name=="SalesOrder") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-briefcase"></i>
                    <span class="title">SALES ORDER</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if($group_id==1 || (isset($akses_menu['index']) && $akses_menu['index']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/SalesOrder">
                            <i class="fa fa-file-word-o"></i>
                            Sales Order (SO) </a>
                        </li>
                        <?php } if($group_id==1 || (isset($akses_menu['spb_list']) && $akses_menu['spb_list']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/SalesOrder/spb_list">
                            <i class="fa fa-file-word-o"></i>
                            SPB List </a>
                        </li>
                        <?php } if($group_id==1 || (isset($akses_menu['surat_jalan']) && $akses_menu['surat_jalan']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/SalesOrder/surat_jalan">
                            <i class="fa fa-file"></i>
                            Surat Jalan </a>
                        </li>
                        <?php } if($group_id==1 || (isset($akses_menu['laporan_so']) && $akses_menu['laporan_so']==1)){ ?>
                        <li>
                            <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span class="title">Laporan SO </span>
                            <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/SalesOrder/laporan_so/">
                                    <i class="fa fa-search"></i> Laporan SO </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/SalesOrder/laporan_sisa_so/">
                                    <i class="fa fa-search"></i> Laporan Sisa SO </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/SalesOrder/laporan_sj/">
                                    <i class="fa fa-search"></i> Laporan Surat Jalan </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/SalesOrder/laporan_penjualan/">
                                    <i class="fa fa-search"></i> Laporan Penjualan </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/search_penjualan_customer/">
                                    <i class="fa fa-search"></i> Rekap per Customer</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/search_penjualan_jb/">
                                    <i class="fa fa-search"></i> Rekap per Jenis Barang</a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } if($group_id==1 || (isset($akses_menu['Finance']) && $akses_menu['Finance']==1)){ ?>
                <li <?php if($module_name=="Finance") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="fa fa-money"></i>
                    <span class="title">FINANCE</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                    <?php if($group_id==1 || (isset($akses_menu['view_um']) && $akses_menu['view_um']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Finance">
                            <i class="fa fa-file-word-o"></i>
                            Kas Masuk </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Finance/bank_masuk">
                            <i class="fa fa-file-word-o"></i>
                            Bank Masuk </a>
                        </li>
                    <?php } if($group_id==1 || (isset($akses_menu['view_invoice']) && $akses_menu['view_invoice']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Finance/invoice">
                            <i class="fa fa-file-word-o"></i>
                            Invoice </a>
                        </li>
                    <?php } if($group_id==1 || (isset($akses_menu['matching']) && $akses_menu['matching']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Finance/matching">
                            <i class="fa fa-files-o"></i>
                            Matching Invoice </a>
                        </li>
                    <?php } if($group_id==1 || (isset($akses_menu['list_kas']) && $akses_menu['list_kas']==1)){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Finance/list_kas">
                            <i class="fa fa-book"></i>
                            List Kas </a>
                        </li>
                    <?php  } if($group_id==1 || (isset($akses_menu['voucher_list']) && $akses_menu['voucher_list']==1)){?>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Finance/voucher_list">
                            <i class="fa fa-file-excel-o"></i>
                            Voucher List </a>
                        </li>
                    <?php  } ?>
                    <?php if($group_id==1 || (isset($akses_menu['laporan_finance']) && $akses_menu['laporan_finance']==1)){ ?>
                        <li>
                            <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span class="title">Laporan</span>
                            <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/laporan_sj/">
                                    <i class="fa fa-search"></i> Laporan Surat Jalan </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/laporan_penjualan_gabungan/">
                                    <i class="fa fa-search"></i> Laporan Penjualan </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/laporan_pembelian/">
                                    <i class="fa fa-search"></i> Laporan Pembelian </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/laporan_penjualan_piutang/">
                                    <i class="fa fa-search"></i> Laporan Piutang Belum Lunas </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/laporan_bahan_pembantu/">
                                    <i class="fa fa-search"></i> Laporan Bahan Pembantu dan Pelumas </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/search_penjualan_customer/">
                                    <i class="fa fa-search"></i> Rekap per Customer</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/search_penjualan_jb/">
                                    <i class="fa fa-search"></i> Rekap per Jenis Barang</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/rangking_rongsok/">
                                    <i class="fa fa-search"></i> Rangking Pemasukan Rongsok </a>
                                </li>
                                <!-- <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/print_penjualan_customer2/" target="_blank">
                                    <i class="fa fa-print"></i> Rekap per Customer KMP</a>
                                </li> -->
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/search_penerimaan/">
                                    <i class="fa fa-money" style="color: green;"></i> Rekap Penerimaan Kas/Bank</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/search_pengeluaran/">
                                    <i class="fa fa-money" style="color: red;"></i> Rekap Pengeluaran Kas/Bank</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Finance/search_trx/">
                                    <i class="fa fa-money" style="color: blue;"></i> Rekap Trs. Kas/Bank</a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } if($group_id==1 || (isset($akses_menu['VoucherCost']) && $akses_menu['VoucherCost']==1)){ ?>
                <li <?php if($module_name=="VoucherCost") echo 'class="start active open"' ?>>
                    <a href="javascript:;">
                    <i class="fa fa-usd"></i>
                    <span class="title">VOUCHER COST</span>
                    <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/VoucherCost/kas_keluar">
                                <i class="fa fa-left">-</i>
                                Kas Keluar
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/VoucherCost/bank_keluar">
                                <i class="fa fa-left">-</i>
                                Bank Keluar
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
                <li <?php if($module_name=="MNumberings" || $module_name=="Apolo" 
                        || $module_name=="MProvinces" || $module_name=="MCities" 
                        || $module_name=="Customer" || $module_name=="Supplier" 
                        || $module_name=="Bank" || $module_name=="Rongsok" 
                        || $module_name=="Sparepart" || $module_name=="JenisBarang" 
                        || $module_name=="Ampas" || $module_name=="TypeKendaraan" 
                        || $module_name=="Kendaraan" || $module_name=="MasterIngotRendah" 
                        || $module_name=="GroupCost" || $module_name=="Cost") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="icon-folder"></i>
                    <span class="title">MASTER</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Supplier">
                            <i class="fa fa-truck"></i>
                            Data Supplier </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Customer">
                            <i class="fa fa-user"></i>
                            Data Customer </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Rongsok">
                            <i class="fa fa-beer"></i>
                            Data Rongsok </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Sparepart">
                            <i class="fa fa-cogs"></i>
                            Data Sparepart </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Ampas">
                            <i class="fa fa-trash"></i>
                            Data Ampas </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/MasterIngotRendah">
                            <i class="fa fa-openid"></i>
                            Data Ingot Rendah </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/JenisBarang">
                            <i class="fa fa-rebel"></i>
                            Jenis Barang</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/MNumberings">
                                <i class="fa fa-sort-numeric-asc"></i> Numberings</a>
                        </li>
                        <li <?php if($module_name=="TypeKendaraan" || $module_name=="Kendaraan") echo 'class="start active open"'; ?>>
                            <a href="javascript:;">
                            <i class="fa fa-car"></i> Kendaraan <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">                              
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/TypeKendaraan">
                                        <i class="fa fa-car"></i> Type Kendaraan</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Kendaraan">
                                        <i class="fa fa-taxi"></i> Daftar Kendaraan</a>
                                </li>                                
                            </ul>
                        </li>
                        <li <?php if($module_name=="GroupCost" || $module_name=="Cost") echo 'class="start active open"'; ?>>
                            <a href="javascript:;">
                            <i class="fa fa-usd"></i> Cost <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">                              
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/GroupCost">
                                        <i class="fa fa-euro"></i> Group Cost</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Cost">
                                        <i class="fa fa-yen"></i> Master Cost</a>
                                </li>                                
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Apolo">
                                <i class="fa fa-bank"></i> Apolo</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Bank">
                                <i class="fa fa-bank"></i> Bank</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/MProvinces">
                                <i class="fa fa-globe"></i> Provinsi</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/MCities">
                                <i class="fa fa-globe"></i> Kota</a>
                        </li>
                    </ul>
                </li>
                <li <?php if($module_name=="Groups" || $module_name=="Users" || $module_name=="Modules") echo 'class="start active open"'; ?>>
                    <a href="javascript:;">
                    <i class="icon-settings"></i>
                    <span class="title">System and Utility</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Groups">
                            Group Management</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Users">
                            User Management</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Modules">
                            Module Management</a>
                        </li>                                             
                    </ul>
                </li>
                
                <li class="last ">
                    &nbsp;
                </li>
            </ul>
        </div>
    </div>
    <!-- CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            
            