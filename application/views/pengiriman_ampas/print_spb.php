<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body class="margin-left:40px;">
        <p>&nbsp;</p>
        <h3 style="text-align: center; text-decoration: underline;"><?php if($this->session->userdata('user_ppn')==1){ echo 'PT. KAWAT MAS PRAKASA<br>'; }?>SURAT PERMINTAAN BARANG AMPAS</h3>
        <table border="0" cellpadding="2" cellspacing="0" width="900px" style="font-family:Microsoft Sans Serif">
            <tr>
                <td width="40%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>No. SPB</td>
                            <td>: <?php echo $header['no_spb_ampas']; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>: <?php echo tanggal_indo($header['tanggal']); ?></td>
                        </tr>    
                        <tr>
                            <td>Keterangan</td>
                            <td>: <?php echo $header['keterangan']; ?></td>
                        </tr>                
                    </table>
                </td>
                <td>&nbsp;</td>
                <td width="40%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>Jenis Barang</td>
                            <td>: AMPAS</td>
                        </tr>
                    <?php
                        if($header['status'] == '9'){
                    ?>
                        <tr>
                            <td>Di tolak oleh</td>
                            <td>: <?php echo $header['reject_name']; ?></td>
                        </tr>
                        <tr>
                            <td>Catatan</td>
                            <td>: <?php echo $header['reject_remarks']; ?></td>
                        </tr>
                    <?php
                    } else if($header['status'] == '1'){
                    ?>
                        <tr>
                            <td>Di terima oleh</td>
                            <td>: <?php echo $header['approved_name']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </table>
                </td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr><td colspan="3">
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>No</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>Nama Item</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>UOM</strong></td>
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><strong>Berat</strong></td>
                            <td style="text-align:center; border:1px solid #000"><strong>Keterangan</strong></td>
                        </tr>
                        <?php
                            $no = 1;
                            $berat = 0;
                            foreach ($details as $row){
                                echo '<tr>';
                                echo '<td style="text-align:center; border-left:1px solid #000">'.$no.'</td>';
                                echo '<td style="border-left:1px solid #000">'.$row->nama_item.'</td>';
                                echo '<td style="border-left:1px solid #000">'.$row->uom.'</td>';                             
                                echo '<td style="border-left:1px solid #000">'.number_format($row->netto,0,',', '.').'</td>';
                                echo '<td style="text-align:right; border-left:1px solid #000; border-right:1px solid #000">'.$row->keterangan.'</td>';
                                echo '</tr>';
                                $berat += $row->netto;
                                $no++;
                            }
                        ?>
                        <tr style="height:100px">
                            <td style="text-align:center; border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                            <td style="border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td style="border-left: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000;"><?=number_format($berat,0,',', '.');?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3">
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
	<body onLoad="window.print()">
    </body>
</html>