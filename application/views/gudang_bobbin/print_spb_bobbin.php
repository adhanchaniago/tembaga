<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body class="margin-left:40px;">
        <p>&nbsp;</p>
        <h3 style="text-align: center; text-decoration: underline;"><?php if($this->session->userdata('user_ppn')){ echo 'PT. KAWAT MAS PRAKASA<br>';} ?> SURAT PERMINTAAN BARANG</h3>
        <table border="0" cellpadding="2" cellspacing="0" width="900px" style="font-family:Microsoft Sans Serif">
            <tr>
                <td width="40%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>No. SPB</td>
                            <td>: <?php echo $header['no_spb_bobbin']; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>: <?php echo date('d-m-Y', strtotime($header['created_at'])); ?></td>
                        </tr>            
                    </table>
                </td>
                <td>&nbsp;</td>
                <td width="40%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        
                        <tr>
                            <td>Pemohon</td>
                            <td>: <?php echo $header['pic']; ?></td>
                        </tr> 
                    </table>
                </td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>Size Bobbin</strong></td>
                            <td style="text-align:center; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>Jumlah </strong></td>
                        </tr>
                        <?php
                            $jumlah = 0; $no = 1; foreach ($myDetail as $row) { $no++;
                                echo '<tr>';
                                echo '<td style="text-align:center; border-left:1px solid #000">'.$no.'</td>';
                                echo '<td style="text-align:center; border-left:1px solid #000; border-right:1px solid #000;">'.$row->bobbin_size.'</td>';
                                echo '<td style="text-align:center; border-right:1px solid #000;">'.$row->jumlah.'</td>';
                                echo '</tr>';
                                $no++;
                                $jumlah += $row->jumlah;
                            }
                        ?>
                        <tr style="height:100px">
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-right:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000"><strong>Total</strong></td>
                            <td style="text-align:center; border-right:1px solid #000; border-bottom:1px solid #000"><strong><?=$jumlah;?></strong></td>
                        </tr>                  
                    </table>
                </td>
            </tr>
            <tr><td colspan="3">
                    <p>&nbsp;</p>
                    <table width="30%" align="right" border="0">
                        <tr>
                            <td style="text-align:center">
                                Yang Mengajukan,<br>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <?php echo $header['pic']; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    <body onLoad="window.print()">
    </body>
</html>
        