<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body class="margin-left:40px;">
        <h3 style="text-align: center; text-decoration: underline;"><?php if($this->session->userdata('user_ppn')==1){ echo 'PT. KAWAT MAS PRAKASA<br>'; }?>MATCHING INVOICE</h3>
        <table border="0" cellpadding="2" cellspacing="0" width="900px" style="font-family:Microsoft Sans Serif">
            <tr>
                <td width="50%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>No. Matching</td>
                            <td>: <?php echo $header['no_matching'];?></td>
                        </tr>
                        <tr>
                            <td valign="top">Sejumlah</td>
                            <td>: ***<?php echo ucwords(number_to_words($header['total'])); ?>***</td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>Tanggal</td>
                            <td>: <?php echo tanggal_indo($header['tanggal']);?></td>
                        </tr>
                        <tr>
                            <td>Customer</td>
                            <td>: <?php echo $header['nama_customer'];?></td>
                        </tr>          
                        <tr>
                            <td>Catatan</td>
                            <td>: <?php echo $header['keterangan'];?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td width="10%" rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No</strong></td>
                            <td width="35%" rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No. Invoice</strong></td>
                            <td width="20%" rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No. Account</strong></td>
                            <td width="35%" rowspan="2" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000;"><strong>Nominal Invoice</strong></td>                        
                        </tr>
                       
                                <tr>
                                </tr>
                        <?php
                            $no = 1;
                            $total = 0;
                            foreach ($details as $row){
                        ?>
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000;"><?=$no;?></td>
                            <td style="border-left:1px solid #000;"><?=$row->nomor.' | '.$row->tanggal;?></td>
                            <td style="border-left:1px solid #000;">&nbsp;</td>
                            <td style="text-align:right; border-left:1px solid #000; border-right: 1px solid #000;"><?=number_format($row->nominal,2,',', '.');?></td>
                        </tr>
                        <?php
                                $total += $row->nominal;
                                $no++;
                            }
                        ?>
                        <tr style="height:50px">
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000;" colspan="3"><strong>Total</strong></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000; border-right: 1px solid #000;">
                                <strong><?=number_format($total,2,',', '.');?></strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3"><hr class="divider"></td>
            </tr>
            <tr>
                <td colspan="3">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td width="10%" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No</strong></td>
                            <td width="35%" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No. Uang Masuk</strong></td>
                            <td width="20%" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No. Account</strong></td>
                            <td width="35%" style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; border-right:1px solid #000;"><strong>Nominal</strong></td>
                        </tr>
                        <?php
                            $no = 1;
                            $nominal = 0;
                            foreach ($details_um as $row){
                        ?>
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000;"><?=$no;?></td>
                            <td style="text-align:left; border-left:1px solid #000;"><?=$row->nomor.(($row->nomor_cek!=null)? ' | '.$row->nomor_cek : '').(($row->nama_bank!=null)? ' ('.$row->nama_bank.')':'');?></td>
                            <td style="border-left:1px solid #000;">&nbsp;</td>
                            <td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000;"><?=number_format($row->nominal,2,',','.');?></td>
                        </tr>
                        <?php $nominal += $row->nominal; $no++; } ?>
                        <tr style="height:50px">
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right; border-left:1px solid #000; border-bottom:1px solid #000;"><strong>Total</strong></td>
                            <td style="text-align:right; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;"><strong><?=number_format($nominal,2,',','.');?></strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- <tr><td colspan="3">
                    <p>&nbsp;</p>
                    <table border="0" width="100%">
                        <tr>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center">Dibuat Oleh</td>
                        </tr>
                        <tr style="height:35">
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center"></td>
                        </tr>
                        <tr>
                            <td style="text-align:center"></td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center"></td>
                        </tr>
                    </table>
                </td>
            </tr> -->
        </table>
        <p>&nbsp;</p>
    <body onLoad="window.print()">
    </body>
</html>
        