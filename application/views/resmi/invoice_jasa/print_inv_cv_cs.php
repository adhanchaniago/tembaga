<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
        <style type="text/css">
            @media print{
                body{
                    font-family:Times New Roman;
                }
            }
        </style>
    </head>
    <body class="margin-left:40px;">
        <h3><u><?= $header['nama_cv'] ?></u></h3>
        <h3 align="center"><u>INVOICE</u></h3>
        <table border="0" cellpadding="2" cellspacing="0" width="900px" style="font-family:Times New Roman;">
            <tr>
                <td width="40%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>No. Invoice</td>
                            <td>: <?= $header['no_invoice_jasa'] ?></td>
                        </tr>
                        <!-- <tr>
                            <td>Tanggal</td>
                            <td>: <?= tanggal_indo($header['tanggal']) ?></td>
                        </tr>  -->
                        <tr>
                            <td>Customer</td>
                            <td>: <?= $header['nama_customer'] ?></td>
                        </tr>  
                        <tr>
                            <td>No. Surat Jalan</td>
                            <td>: <?= $header['no_sj_resmi'] ?></td>
                        </tr>
                        
                    </table>
                </td>
                <td>&nbsp;</td>
                <td width="40%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%" style="font-family:Times New Roman;">
                        <tr>
                            <td>No. PO</td>
                            <td>: <?= $header['no_po2'] ?></td>
                        </tr>           
                        <tr>
                            <td>Pembayaran</td>
                            <td>: <?= $header['term_of_payment'] ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Jatuh Tempo</td>
                            <td>: <?= tanggal_indo($header['jatuh_tempo']) ?></td>
                        </tr>
                        <!-- <tr rowspan="2">
                            <td colspan="2">&nbsp;</td>
                        </tr> -->
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <table border="0" cellpadding="5" cellspacing="0" width="900px" style="font-family:Times New Roman;">
            <thead>
                <th style="border-top: 1px solid; border-left: 1px; border-left: 1px solid;">No</th>
                <th style="border-top: 1px solid; border-left: 1px; border-left: 1px solid;">Nama Barang</th>
                <th style="border-top: 1px solid; border-left: 1px; border-left: 1px solid;" width="20%">Quantity</th>
                <th style="border-top: 1px solid; border-left: 1px; border-left: 1px solid;">Harga Satuan</th>
                <th style="border-top: 1px solid; border-left: 1px; border-left: 1px solid; border-right: 1px solid;">Harga Jual</th>
                <!-- <th>Keterangan</th> -->
            </thead>
            <tbody>
                <?php
                    $no = 1; 
                    $total_jual = 0;
                    foreach ($myDetail as $v) { 
                ?>
                    <tr>
                        <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid;" align="center"><?= $no ?></td>
                        <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid;"><?= $v->jenis_barang ?><br>(Ongkos Kerja)</td>
                        <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid;" align="center"><?= number_format($v->sum_netto,2,".",",")." ".$v->uom ?></td>
                        <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid;" align="right">
                            <table width="100%">
                                <tr>
                                    <td>Rp</td>
                                    <td align="right"><?= number_format($v->amount,2,".",",") ?></td>
                                </tr>
                            </table></td>
                        <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid; border-right: 1px solid;" align="right">
                            <table width="100%">
                                <tr>
                                    <td>Rp</td>
                                    <td align="right"><?= number_format($v->sum_total_amount,2,".",",") ?></td>
                                </tr>
                            </table></td>
                        <!-- <td></td> -->
                    </tr>
                <?php
                        $total_jual += $v->sum_total_amount;
                        $no++; 
                    } 
                    $total_amount = $total_jual;
                ?>
                <tr>
                    <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid;" colspan="4"><b>Jumlah Harga Jual</b></td>
                    <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid; border-right: 1px solid;" align="right">
                        <table width="100%">
                            <tr>
                                <td><b>Rp</b></td>
                                <td align="right"><b><?= number_format($total_amount,2,".",",") ?></b></td>
                            </tr>
                        </table>
                    </td>
                    <!-- <td></td> -->
                </tr>
                <tr>
                    <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid;" colspan="4"><b>Dikurangi Potongan Harga</b></td>
                    <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid; border-right: 1px solid;" align="right">
                        <table width="100%">
                            <tr>
                                <td><b>Rp</b></td>
                                <td align="right"><b><?= number_format($header['diskon'],2,".",",") ?></b></td>
                            </tr>
                        </table>
                    </td>
                    <!-- <td></td> -->
                </tr>
                <tr>
                    <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid;" colspan="4"><b>Uang muka yang diterima</b></td>
                    <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid; border-right: 1px solid;" align="right">
                        <table width="100%">
                            <tr>
                                <td><b>Rp</b></td>
                                <td align="right"><b><?= number_format(0,2,".",",") ?></b></td>
                            </tr>
                        </table>
                    </td>
                    <!-- <td></td> -->
                </tr>
                <tr>
                    <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid; border-bottom: 1px solid;" colspan="4"><b>T o t a l</b></td>
                    <td style="border-top: 1px solid; border-left: 1px; border-left: 1px solid; border-bottom: 1px solid; border-right: 1px solid;" align="right">
                        <table width="100%">
                            <tr>
                                <td><b>Rp</b></td>
                                <td align="right"><b><?= number_format($total_amount,2,".",",") ?></b></td>
                            </tr>
                        </table>
                    </td>
                    <!-- <td></td> -->
                </tr>
            </tbody>
        </table>
        <br>
        <table border="0" cellpadding="2" cellspacing="0" width="900px" style="font-family:Times New Roman;">
            <tr>
                <td>
                    Catatan:<br>Pembayaran dengan Cheque/Giro dianggap lunas<br>
                    Setelah Cheque/Giro tersebut diuangkan / diterima<br>
                    dananya.
                </td>
                <td width="15%" align="center"></td>
                <td valign="top">Jakarta, <?= tanggal_indo($header['tanggal']) ?></td>
            </tr>
        </table>
        <p>&nbsp;</p>
	<body onLoad="window.print()">
    </body>
</html>
        