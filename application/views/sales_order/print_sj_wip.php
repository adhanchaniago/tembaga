<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body class="margin-left:40px;">
        <p>&nbsp;</p>
        <h3 style="text-align: center; text-decoration: underline;">PT. KAWATMAS PRAKASA<br>SURAT JALAN</h3>
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
                        <tr>
                            <td>Jenis Barang</td>
                            <td>: <?php echo $header['jenis_barang']; ?></td>
                        </tr>
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
                            <td colspan="2">No. Kendaraan: <?php echo $header['no_kendaraan']; ?></td>
                            <td colspan="2">Type Kendaraan: <?php echo $header['type_kendaraan']; ?></td>
                            <td colspan="2">Catatan: <?php echo $header['remarks']; ?></td>
                        </tr>
                        <tr>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No</strong></td>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>Nama Item</strong></td>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>UOM</strong></td>
                            <!-- <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No. Produksi</strong></td> -->
                            <td colspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>Qty</strong></td>
                            <td rowspan="2" style="text-align:center; border:1px solid #000"><strong>Keterangan</strong></td>
                        </tr>
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>Jumlah</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>Netto</strong></td>
                        </tr>
                        <?php
                            $no = 1;
                            $qty = 0;
                            $netto = 0;
                            foreach ($details as $row){
                                echo '<tr>';
                                echo '<td style="text-align:center; border-left:1px solid #000">'.$no.'</td>';
                                echo '<td style="border-left:1px solid #000">'.$row->jenis_barang.'</td>';
                                echo '<td style="border-left:1px solid #000">'.$row->uom.'</td>';
                                echo '<td style="text-align:right; border-left:1px solid #000">'.$row->qty.'</td>';
                                echo '<td style="text-align:right; border-left:1px solid #000">'.$row->netto.'</td>';
                                echo '<td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000">'.$row->line_remarks.'</td>';
                                echo '</tr>';
                                $qty += $row->qty;
                                $netto += $row->netto;
                                $no++;
                            }
                        ?>
                        <tr style="height:100px">
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                             <td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:right;" colspan="3"><strong>Total</strong></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000">
                                <strong><?php echo $qty; ?></strong>
                            </td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000">
                                <strong><?php echo $netto; ?></strong>
                            </td>
                            <td style="border-left:1px solid #000; "></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td colspan="3">
                    <p>&nbsp;</p>
                    <table border="0" width="100%">
                        <tr>
                            <td style="text-align:center">Pembawa/Supir</td>
                            <td style="text-align:center">Diperiksa</td>
                            <td style="text-align:center">Mengetahui</td>
                            <td style="text-align:center">Hormat Kami</td>
                            <td style="text-align:center">Tanda Terima</td>
                        </tr>
                        <tr style="height:35">
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center"><?php echo $header['supir']; ?></td>
                            <td style="text-align:center">(_____________)</td>
                            <td style="text-align:center">(_____________)</td>
                            <td style="text-align:center"><?php echo $header['realname']; ?></td>
                            <td style="text-align:center">(_____________)</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p>&nbsp;</p>
	<body onLoad="window.print()">
    </body>
</html>