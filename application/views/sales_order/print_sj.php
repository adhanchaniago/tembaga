<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body class="margin-left:40px;">
        <p>&nbsp;</p>
        <h3 style="text-align: center; text-decoration: underline;"><?php if($this->session->userdata('user_ppn')==1){ echo 'PT. KAWATMAS PRAKASA<br>'; }
        if($header['status']==1){
            echo 'PACKING LIST</h3>';
        }else{
            echo 'PACKING LIST SEMENTARA</h3>';
        }?>
        <table border="0" cellpadding="2" cellspacing="0" width="900px" style="font-family:Microsoft Sans Serif">
            <tr>
                <td width="60%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>No. Surat Jalan</td>
                            <td>: <?php echo $header['no_surat_jalan']; ?></td>
                        </tr>
                        <tr>
                            <td>No. Sales Order</td>
                            <td>: <?php echo $header['no_sales_order']; ?></td>
                        </tr>
                        <tr>
                            <td>No. PO</td>
                            <td>: <?php echo $header['no_po']; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>: <?php echo tanggal_indo($header['tanggal']); ?></td>
                        </tr>
                        <tr>
                            <td>Customer</td>
                            <td>: <?php echo $header['nama_customer']; ?></td>
                        </tr>
                        <!-- <tr>
                            <td>Jenis Barang</td>
                            <td>: <?php echo $header['jenis_barang']; ?></td>
                        </tr> -->
                    </table>
                </td>
                <td>&nbsp;</td>
                <td width="40%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>Tanggal SJ</td>
                            <td>: <?php echo tanggal_indo($header['tanggal']); ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal SO</td>
                            <td>: <?php echo tanggal_indo($header['tanggal_so']); ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td colspan="2"><?php echo $header['alamat'];?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td colspan="3">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td colspan="3">No. Kendaraan: <?php echo $header['no_kendaraan']; ?></td>
                            <td colspan="3">Type Kendaraan: <?php echo $header['type_kendaraan']; ?></td>
                            <td colspan="3">Catatan: <?php echo $header['remarks']; ?></td>
                        </tr>
                        <tr>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>NO</strong></td>
                            <td colspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>KODE</strong></td>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>NAMA ITEM</strong></td>
                            <!-- <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No. Produksi</strong></td> -->
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>NO.PRD</strong></td>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>NO.PACKING</strong></td>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>NO.BOBBIN</strong></td>
                            <td colspan="3" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;; border-right:1px solid #000"><strong>QUANTITY(KG)</strong></td>
                            <!-- <td rowspan="2" style="text-align:center; border:1px solid #000"><strong>Keterangan</strong></td> -->
                        </tr>
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>LAMA</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000"><strong>BARU</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>BRUTO</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>BOBBIN</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000"><strong>NETTO</strong></td>
                        </tr>
                        <?php
                            $last_series = null;
                            $no = 1;
                            $bruto = 0;
                            $bobin = 0;
                            $netto = 0;
                            foreach ($details as $row){
                                if($row->jenis_barang!=$last_series && $last_series!=null){
                                    echo '<tr><td colspan="7" style="text-align:right; border-left:1px solid #000; border-top:1px solid #000; border-bottom:1px solid #000;"><strong>Total :</strong></td>';
                                    echo '<td style="text-align:right; border-left:1px solid #000; border-top:1px solid #000; border-bottom:1px solid #000">
                                            <strong>'.number_format($bruto, 2, '.', ',').'</strong>
                                        </td>
                                        <td style="text-align:right; border-left:1px solid #000; border-top:1px solid #000; border-bottom:1px solid #000">
                                            <strong>'.number_format($bobin, 2, '.', ',').'</strong>
                                        </td>
                                        <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000;">
                                            <strong>'.number_format($netto, 2, '.', ',').'</strong>
                                        </td></tr>';
                                    $bruto = 0;
                                    $bobin = 0;
                                    $netto = 0;
                                    $no = 1;
                                }else{
                                    echo '<tr>';
                                }
                                echo '<td style="text-align:center; border-left:1px solid #000">'.$no.'</td>';
                                echo '<td style="border-left:1px solid #000">'.$row->kode_lama.'</td>';
                                echo '<td style="border-left:1px solid #000">'.$row->kode_baru.'</td>';
                                echo '<td style="border-left:1px solid #000">'.$row->jenis_barang.'</td>';
                                echo '<td style="border-left:1px solid #000">'.$row->no_produksi.'</td>';
                                echo '<td style="border-left:1px solid #000">'.$row->no_packing.'</td>';
                                echo '<td style="border-left:1px solid #000">'.$row->nomor_bobbin.'</td>';
                                echo '<td style="text-align:right; border-left:1px solid #000">'.number_format($row->bruto, 2, '.', ',').'</td>';
                                echo '<td style="text-align:right; border-left:1px solid #000">'.number_format($row->bruto-$row->netto, 2, '.', ',').'</td>';
                                echo '<td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000">'.number_format($row->netto, 2, '.', ',').'</td>';
                                // echo '<td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000">'.$row->line_remarks.'</td>';
                                if($row->jenis_barang==$last_series){
                                    echo '<tr>';
                                }
                                $last_series = $row->jenis_barang;
                                $bruto += $row->bruto;
                                $bobin += $row->bruto-$row->netto;
                                $netto += $row->netto;
                                $no++;
                            }
                            // $no = 1;
                            // $bruto = 0;
                            // $bobin = 0;
                            // $netto = 0;
                            // foreach ($details as $row){
                            //     echo '<tr>';
                            //     echo '<td style="text-align:center; border-left:1px solid #000">'.$no.'</td>';
                            //     echo '<td style="border-left:1px solid #000">'.$row->jenis_barang.'</td>';
                            //     echo '<td style="border-left:1px solid #000">'.$row->no_produksi.'</td>';
                            //     echo '<td style="border-left:1px solid #000">'.$row->no_packing.'</td>';
                            //     echo '<td style="border-left:1px solid #000">'.$row->nomor_bobbin.'</td>';
                            //     echo '<td style="text-align:right; border-left:1px solid #000">'.number_format($row->bruto, 2, '.', ',').'</td>';
                            //     echo '<td style="text-align:right; border-left:1px solid #000">'.number_format($row->berat, 2, '.', ',').'</td>';
                            //     echo '<td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000">'.number_format($row->netto, 2, '.', ',').'</td>';
                            //     // echo '<td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000">'.$row->line_remarks.'</td>';
                            //     echo '</tr>';
                            //     $bruto += $row->bruto;
                            //     $bobin += $row->berat;
                            //     $netto += $row->netto;
                            //     $no++;
                            // }
                        ?>
                        <tr>
                            <td colspan="7" style="text-align:right; border-left:1px solid #000; border-top:1px solid #000; border-bottom:1px solid #000;"><strong>Total :</strong></td>
                            <td style="text-align:right; border-left:1px solid #000; border-top:1px solid #000; border-bottom:1px solid #000">
                                <strong><?php echo number_format($bruto, 2, '.', ','); ?></strong>
                            </td>
                            <td style="text-align:right; border-left:1px solid #000; border-top:1px solid #000; border-bottom:1px solid #000">
                                <strong><?php echo number_format($bobin, 2, '.', ','); ?></strong>
                            </td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000;">
                                <strong><?php echo number_format($netto, 2, '.', ','); ?></strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td colspan="3">
                    <p>&nbsp;</p>
                    <table border="0" width="100%">
                        <tr>
                            <td style="text-align:center">Tanda Terima</td>
                            <td style="text-align:center">Pembawa / Supir</td>
                            <td style="text-align:center">Diperiksa</td>
                            <td style="text-align:center">Mengetahui</td>
                            <td style="text-align:center">Hormat Kami</td>
                        </tr>
                        <tr style="height:35">
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <!-- <td style="text-align:center">&nbsp;</td> -->
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                        </tr>
                        <tr><?php if($this->session->userdata('user_ppn')==1){?>
                            <td style="text-align:center">(_____________)</td>
                            <td style="text-align:center">(_____________)</td>
                            <td style="text-align:center">(_____________)</td>
                            <td style="text-align:center"><strong>(Tjan Lin Oy)</strong></td>
                            <td style="text-align:center"><strong>(Istadi)</strong></td>
                            <?php }else{ ?>
                            <td style="text-align:center">(_____________)</td>
                            <td style="text-align:center">(_____________)</td>
                            <td style="text-align:center">(_____________)</td>
                            <td style="text-align:center"><strong>(Andi)</strong></td>
                            <td style="text-align:center"><strong>(Bambang)</strong></td>
                            <?php } ?>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p>&nbsp;</p>
	<body onLoad="window.print()">
    </body>
</html>
        