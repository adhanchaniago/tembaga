<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body class="margin-left:40px;">
        <h2 align="center"><b><u>Laporan Gudang Rongsok per <?= tanggal_indo($tgl); ?></u></b></h2>
        <table width="100%" >
            <tr>
                <td width="33%"><b>Nama Barang : </b><?=$rongsok['nama_item'];?></td>
                <td width="33%"><b>Kode Rongsok : </b><?=$rongsok['kode_rongsok'];?></td>
            </tr>
         </table>
        <table width="100%" class="table table-striped table-bordered table-hover" id="sample_6" style="font-size:15px;">
            <thead>
                <th style="width:40px">No</th> 
                <th width="25%">Nomor Seng</th> 
                <th width="25%">No Packing</th>    
                <th width="25%">Bruto</th>
                <th width="15%">Berat Palette</th> 
                <th width="25%">Netto</th>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $bruto = 0;
            $berat = 0;
            $netto = 0;
            foreach ($detailLaporan as $row){
                echo '<tr>';
                echo '<td style="text-align:center;border-bottom:1px solid #000;">'.$no.'</td>';
                echo '<td style="border-bottom:1px solid #000;">'.$row->nomor_seng.'</td>';
                echo '<td style="border-bottom:1px solid #000;">'.$row->no_pallete.'</td>';
                echo '<td style="border-bottom:1px solid #000; text-align:right;">'.number_format($row->bruto,2,',','.').'</td>';
                echo '<td style="border-bottom:1px solid #000; text-align:right;">'.number_format($row->berat_palette,2,',','.').'</td>';
                echo '<td style="border-bottom:1px solid #000; text-align:right;">'.number_format($row->netto,2,',','.').'</td>';
                echo '</tr>';
                $no++;
                $bruto += $row->bruto;
                $berat += $row->berat_palette;
                $netto += $row->netto;
            }
            ?>
            <tr>
                <td colspan="3"></td>
                <td style="border-bottom:1px solid #000; border-top:1px solid #000"><?=number_format($bruto,2,',','.');?></td>
                <td style="border-bottom:1px solid #000; border-top:1px solid #000"><?=number_format($berat,2,',','.');?></td>
                <td style="border-bottom:1px solid #000; border-top:1px solid #000"><?=number_format($netto,2,',','.');?></td>
            </tr>
            </tbody>
        </table>
    <body onLoad="window.print()">
    </body>
</html>