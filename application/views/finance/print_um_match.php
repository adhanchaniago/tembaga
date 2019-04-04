<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body class="margin-left:40px;">
        <p>&nbsp;</p>
        <?php if($this->session->userdata('user_ppn')==1){
            echo '<h3 style="text-align: center; text-decoration: underline;">PT. KAWATMAS PRAKASA<br>DATA TERIMA RONGSOK (DTR)</h3>';
        } ?>
        <h3 style="text-align: center; text-decoration: underline;">BUKTI TERIMA BANK</h3>
        <table border="0" cellpadding="2" cellspacing="0" width="900px" style="font-family:Microsoft Sans Serif">
            <tr>
                <td width="60%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>No. Matching</td>
                            <td>: <?php echo $header['no_matching'];?></td>
                        </tr>
                        <tr>
                            <td>Diterima Dari</td>
                            <td>: <?= $header['nama_customer'];?></td>
                        </tr>
                        <tr>
                            <td valign="top">Sejumlah</td>
                            <td>: **<?php echo ucwords(number_to_words($header['total'])); ?>**</td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
                <td width="40%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>No. Uang Masuk</td>
                            <td>: <?php echo $header['no_uang_masuk'];?></td>
                        </tr>
                        <tr>
                            <td>Tgl Bukti</td>
                            <td>: <?php echo tanggal_indo($header['tanggal']);?></td>
                        </tr>          
                        <tr>
                            <td>Tgl Jatuh Tempo</td>
                            <td>: <?php echo tanggal_indo($header['tgl_cair']);?></td>
                        </tr>
                        <tr>
                            <td>Cek / Giro</td>
                            <td>: <?php echo $header['bank_pembayaran'];?></td>
                        </tr>
                        <tr>
                            <td>Kurs</td>
                            <td>: <?php echo $header['currency'];?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No</strong></td>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No. Invoice</strong></td>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No Account</strong></td>
                            <td rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right: 1px solid #000;"><strong>Total Harga</strong></td>
                        </tr>
                       <tr></tr>
                        <?php
                            $no = 1;
                            $total = 0;
                            $total_invoice = 0;
                            foreach ($details as $row){
                                // $harga_total = $row->total+$row->biaya1+$row->biaya2;
                        ?>
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000;"><?=$no;?></td>
                            <td style="border-left:1px solid #000;"><?=$row->no_invoice;?></td>
                            <td style="text-align:right; border-left:1px solid #000;"></td>
                            <td style="text-align:right; border-left:1px solid #000; border-right: 1px solid #000;"><?=number_format($row->total,0,',', '.');?></td>
                        </tr>
                        <?php
                                $total += $row->total;
                                $no++;
                            }
                        ?>
                        <tr style="height:100px">
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000" colspan="2"><strong>Jumlah </strong> :</td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000"></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000; border-right: 1px solid #000;">
                                <strong><?=number_format($total,0,',', '.');?></strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td colspan="3">
                    <p>&nbsp;</p>
                    <table border="0" width="100%">
                        <tr>
                            <td style="text-align:center">Mengetahui</td>
                            <td style="text-align:center">Disetujui</td>
                            <td style="text-align:center">Pembukuan</td>
                            <td style="text-align:center">Kassa/Keuangan</td>
                            <td style="text-align:center">Disetor / Diterima</td>
                        </tr>
                        <tr style="height:35">
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center"></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">(_______________)</td>
                            <td style="text-align:center">(_______________)</td>
                            <td style="text-align:center">(_______________)</td>
                            <td style="text-align:center">(_______________)</td>
                            <td style="text-align:center">(_______________)</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p>&nbsp;</p>
    <body onLoad="window.print()">
    </body>
</html>
        