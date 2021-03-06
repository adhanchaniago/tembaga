<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
        <style type="text/css">
            body{
                font-family:Times New Roman;
            }

            @media print{
                body{
                    font-family:Times New Roman;
                }
            }
        </style>
    </head>
    <body class="margin-left:40px;">
        <h3><?= $header['nama_cv']; ?></h3>
        <h3 align="center"><u>SURAT JALAN</u></h3>
        <table border="0" cellpadding="2" cellspacing="0" width="900px">
            <tr>
                <td width="40%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>No. Surat Jalan</td>
                            <td>: <?= $header['no_sj_resmi'] ?></td>
                        </tr>
                        <tr>
                            <td>No. BPB</td>
                            <td>: <?= $header['no_bpb'] ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>: <?= tanggal_indo($header['tanggal']) ?></td>
                        </tr>
                        <tr>
                            <td>No. Order</td>
                            <td>: <?= $header['no_po'] ?></td>
                        </tr>
                        
                    </table>
                </td>
                <td>&nbsp;</td>
                <td width="40%">
                    <table border="0" cellpadding="2" cellspacing="0" width="100%">
                        <tr>
                            <td>Supplier</td>
                            <td>: PT. KAWAT MAS PRAKASA</td>
                        </tr>
                        <!-- <tr>
                            <td>Customer</td>
                            <td>: <?= $header['nama_customer'] ?></td>
                        </tr>    -->                   
                        <!-- <tr>
                            <td>Catatan</td>
                            <td>: <?= $header['remarks'] ?></td>
                        </tr> -->
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <table border="0" cellpadding="5" cellspacing="0" width="900px">
            <thead>
                <!-- <th style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">No</th> -->
                <th style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">Nama Barang</th>
                <th style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid;" width="20%">Quantity</th>
                <th style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">Customer</th>
                <th style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Keterangan</th>
            </thead>
            <tbody>
                <?php
                    $no = 1; 
                    $total = 0;
                    foreach ($list_sj_detail as $v) { 
                ?>
                    <tr>
                        <!-- <td style="border-bottom: 1px solid; border-left: 1px solid;" align="center"><?= $no ?></td> -->
                        <td style="border-left: 1px solid;"><?= $v->nama_item ?><br>(Ongkos Kerja)</td>
                        <td style="border-left: 1px solid;" align="center"><?= number_format($v->total_netto,2,".",",")." ".$v->uom ?></td>
                        <td style="border-left: 1px solid;"><?= $header['nama_customer2'] ?></td>
                        <td style="border-left: 1px solid; border-right: 1px solid;"></td>
                    </tr>
                <?php
                        $total += $v->total_netto;
                        $no++; 
                    } 
                ?>
                <tr>
                    <!-- <td style="border-bottom: 1px solid; border-left: 1px solid;" align="center"><?= $no ?></td> -->
                    <td style="border-bottom: 1px solid; border-left: 1px solid;">&nbsp;</td>
                    <td style="border-bottom: 1px solid; border-left: 1px solid;" align="center">&nbsp;</td>
                    <td style="border-bottom: 1px solid; border-left: 1px solid;">&nbsp;</td>
                    <td style="border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid; border-left: 1px solid;" align="right"><b></b></td>
                    <td style="border-bottom: 1px solid; border-left: 1px solid;" align="center"><b><?= number_format($total,2,".",",")." ".$v->uom ?></b></td>
                    <td style="border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;" colspan="2" ></td>
                </tr>
            </tbody>
        </table>
        Keterangan:
        <br>
        <table border="0" cellpadding="2" cellspacing="0" width="900px">
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td width="40%"></td>
                <td width="30%">DITERIMA :</td>
                <td>DIKIRIM OLEH :</td>
            </tr>
        </table>
        <p>&nbsp;</p>
	<body onLoad="window.print()">
    </body>
</html>
        