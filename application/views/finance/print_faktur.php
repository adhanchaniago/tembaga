<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body class="margin-left:40px;" style="margin-top: 75px;">
        <p>&nbsp;</p>
        <table border="0" cellpadding="2" cellspacing="0" width="900px" style="font-family:Microsoft Sans Serif">
            <tr>
                <td><h3>Pengusaha Kena Pajak</h3></td>
            </tr>
            <tr>
                <td width="60%">
                    <table border="0" cellpadding="2" cellspacing="1" width="100%">
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td> PT. KAWAT MAS PRAKASA</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td> Jl. Halim Perdana Kusuma No. 51 Kec. Batu Ceper, Tangerang</td>
                        </tr>
                        <tr>
                            <td>NPWP</td>
                            <td>:</td>
                            <td> 01.146.699.2.4 16.000</td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
                <td width="40%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>No. Invoice</td>
                            <td>: <?php echo $header['no_invoice'];?></td>
                        </tr>
                        <tr>
                            <td>No. Surat Jalan</td>
                            <td>: <?php echo $header['no_surat_jalan'];?></td>
                        </tr>
                    </table>
                </td>
            </tr>
                <tr>
                    <td colspan="3" style="border-bottom:1px solid #000; border-top:1px solid #000; text-align: center;"><h3>FAKTUR PENJUALAN</h3></td>
                </tr>
            <tr>
                <td width="60%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td colspan="3">PEMBELI / PENERIMA JASA</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td> <?php echo $header['nama_customer']?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td> <?php echo $header['alamat'];?></td>
                        </tr>
                        <tr>
                            <td>NPWP</td>
                            <td>:</td>
                            <td> <?php echo $header['npwp'];?></td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
                <td width="40%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Syarat Pembayaran</td>
                            <td>: <?php echo $header['term_of_payment'];?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Jatuh Tempo</td>
                            <td>: <?php echo tanggal_indo($header['tgl_jatuh_tempo']);?></td>
                        </tr>             
                        <tr>
                            <td>No. PO</td>
                            <td>: <?php echo $header['no_po'];?></td>
                        </tr>
                        <!-- <tr>
                            <td>Pajak</td>
                            <td>: <?php echo $header['flag_ppn']==1 ? "PPN" : "NON-PPN" ?></td>
                        </tr> -->
                    </table>
                </td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No</strong></td>
                            <td colspan="4" rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>Nama Item</strong></td>
                            <td rowspan="2"  style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>Qty</strong></td>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>Netto</strong></td>
                            <td rowspan="2" colspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;" width="15%"><strong>Harga</strong></td>
                            <td rowspan="2" colspan="2" style="text-align:center; border:1px solid #000" width="20%"><strong>Total Harga</strong></td>
                        </tr>
                                <tr>
                                </tr>
                        <?php
                            if($header['flag_tolling']!=0){
                                $ket = ' (Ongkos Kerja)';
                            }else{
                                $ket = '';
                            }
                            $c = $header['currency'];
                            $no = 1;
                            $total = 0;
                            $total_netto = 0;
                            $harga_ppn = 0;
                            foreach ($details as $row){
                        ?>
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000;"><?=$no;?></td>
                            <td colspan="4" style="border-left:1px solid #000;"><?=$row->jenis_barang.$ket;?></td>
                            <td style="text-align:right; border-left:1px solid #000;"><?=$row->qty;?></td>
                            <td style="text-align:right; border-left:1px solid #000;"><?=number_format($row->netto,2,',','.').' '.$row->uom;?></td>
                            <td style="border-left:1px solid #000;"><?=$c;?></td>
                            <td style="text-align:right;"><?=number_format($row->harga,2,',', '.');?></td>
                            <td style="border-left:1px solid #000;"><?=$c;?></td>
                            <td style="text-align:right; border-right:1px solid #000;"><?=number_format($row->total_harga,2,',', '.');?></td>
                        </tr>
                        <?php
                                $total_netto += $row->netto;
                            if($header['currency']=='IDR'){
                                $total += round($row->total_harga,0);
                            }else{
                                $total += round($row->total_harga,2);
                            }
                                $no++;
                            }
                        if($header['flag_ppn']==1 && $header['currency']=='IDR'){
                            $harga_ppn = ($total-$header['diskon']-$header['add_cost']) * 10/100;
                        }
                        ?>
                        <tr style="height:100px">
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td colspan="3" style="border-left:1px solid #000; border-bottom:1px solid #000"><?=$header['keterangan'];?></td>
                            <td style="border-bottom: 1px solid #000;"></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td colspan="2" style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="text-align:right; border-right:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:left; border-left:1px solid #000; border-bottom:1px solid #000" colspan="9"><strong>Jumlah Harga Jual</strong></td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000"><?=$c;?></td>
                            <td style="text-align:right; border-right:1px solid #000; border-bottom:1px solid #000"><?=number_format($total,2,',', '.');?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left; border-left:1px solid #000; border-bottom:1px solid #000" colspan="9"><strong>Dikurangi Potongan Harga</strong></td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000"><?=$c;?></td>
                            <td style="text-align:right; border-right:1px solid #000; border-bottom:1px solid #000"><?=number_format($header['diskon'],2,',', '.');?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left; border-left:1px solid #000; border-bottom:1px solid #000" colspan="9"><strong>Lain Lain</strong></td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000"><?=$c;?></td>
                            <td style="text-align:right; border-right:1px solid #000; border-bottom:1px solid #000"><?=number_format($header['add_cost'],2,',', '.');?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left; border-left:1px solid #000; border-bottom:1px solid #000" colspan="9"><strong>Dasar Pengenaan Pajak</strong></td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000"><?=$c;?></td>
                            <td style="text-align:right; border-right:1px solid #000; border-bottom:1px solid #000"><?=($header['currency']=='IDR')?number_format(round($total-$header['diskon']-$header['add_cost'],0),2,',', '.'):number_format(round($total-$header['diskon']-$header['add_cost'],2),2,',', '.');?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left; border-left:1px solid #000; border-bottom:1px solid #000" colspan="9"><strong>PPN = 10% x Dasar Pengenaan Pajak</strong></td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000"><?=$c;?></td>
                            <td style="text-align:right; border-right:1px solid #000; border-bottom:1px solid #000"><?=($header['currency']=='IDR')?number_format(round($harga_ppn,0),2,',', '.'):number_format(round($harga_ppn,2),2,',', '.');?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left; border-left:1px solid #000; border-bottom:1px solid #000" colspan="9"><strong>Materai</strong></td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000"><?=$c;?></td>
                            <td style="text-align:right; border-right:1px solid #000; border-bottom:1px solid #000"><?=number_format($header['materai'],2,',', '.');?></td>
                        </tr>
                        <?php 
                        if($header['currency']=='IDR'){
                        $total_bersih = round($total-$header['diskon']-$header['add_cost']+$header['materai'],0)+round($harga_ppn,0);
                        }else{
                        $total_bersih = round($total-$header['diskon']-$header['add_cost']+$header['materai'],2)+round($harga_ppn,2);
                        };?>
                        <tr>
                            <td style="text-align:left; border-left:1px solid #000; border-bottom:1px solid #000" colspan="9"><strong>T O T A L</strong></td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000"><?=$c;?></td>
                            <td style="text-align:right; border-right:1px solid #000; border-bottom:1px solid #000"><?=number_format($total_bersih,2,',', '.');?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-left: 1px solid #000;">Terbilang</td>
                            <td>:</td>
                            <td colspan="5" rowspan="3" style="vertical-align: top">** <?php echo ucwords(number_to_words_d($total_bersih, $c)); ?> **</td>
                            <td colspan="3"  style="border-right: 1px solid #000;">Tangerang, <?=tanggal_indo($header['tanggal']);?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-left: 1px solid #000;"></td>
                            <td></td>
                            <td colspan="3"  style="border-right: 1px solid #000;"></td>
                        </tr>
                        <tr>
                            <td colspan="11" style="height: 75px; border-right:1px solid #000; border-left:1px solid #000;"></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="border-left: 1px solid #000;"></td>
                            <td colspan="3">Transfer Ke :</td>
                            <td colspan="4" style="border-right: 1px solid #000;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-left: 1px solid #000;">Perhatian</td>
                            <td>:</td>
                            <td width="30%" rowspan="2" style="border-bottom: 1px solid #000;">Pembayaran dengan Cheque/Giro baru dapat dianggap sah, apabila Cheque/Giro tsb, sudah diuangkan</td>
                            <td colspan="3" rowspan="2" style="border-bottom: 1px solid #000;">Nama:PT. KAWAT MAS PRAKASA <br>
                            ACC: <?=$header['nomor_rekening'];?><br>
                            BANK <?=$header['kode_bank'];?><br>
                            <?=$header['kantor_cabang'];?>
                            </td>
                            <td colspan="4" style="border-right: 1px solid #000;"></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="border-left: 1px solid #000; border-bottom: 1px solid #000;"></td>
                            <td colspan="4" style="text-align: center; border-bottom: 1px solid #000; border-right: 1px solid #000;">
                                <strong style="text-decoration: underline;"><?php echo '('.$header['nama_direktur'].')';?></strong><br>
                                <span>Direktur</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p>&nbsp;</p>
    <body onLoad="window.print()">
    </body>
</html>
        