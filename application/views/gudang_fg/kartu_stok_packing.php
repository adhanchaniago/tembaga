 <h3 align="center"><b> Kartu Stok FG <?php echo " <i>".$start.' s/d '.$end."</i>";?></b></h3>
 <table width="100%" >
    <tr>
        <td width="33%"><b>Nama Barang : </b><?=$jb['jenis_barang'];?></td>
        <td width="34%" align="center"><b>Per Tanggal : <?=$end;?></b></td>
        <td width="33%"><b>Kode : </b><?=$jb['kode'];?></td>
    </tr>
 </table>
<table width="100%" class="table table-striped table-bordered table-hover" id="sample_6" style="font-size:12px;">
    <thead>
        <th style="width:40px">No</th>
        <th>Tanggal</th>
        <th>Nomor Packing</th>
        <th>Keterangan</th>
        <th>Masuk</th>
        <th>Keluar</th>
        <th>Sisa</th>
    </thead>
    <tbody>
    <?php
    $no = 1;
    $masuk = 0;
    $keluar = 0;
    $sisa_now = 0;
    $sisa = $stok_before['netto_masuk'] - $stok_before['netto_keluar'];
        echo '<tr>';
        echo '<td style="text-align:center"> - </td>';
        echo '<td></td>';
        echo '<td>Saldo Sebelumnya</td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td style="text-align:right">'.number_format($sisa,2,',','.').'</td>';
        echo '</tr>';
    foreach ($detailLaporan as $row){
        echo '<tr>';
        echo '<td style="text-align:center">'.$no.'</td>';
        echo '<td>'.$row->tanggal_masuk.$row->tanggal_keluar.'</td>';
        echo '<td>'.$row->no_packing.'</td>';
        echo '<td>'.$row->nomor.'</td>';
        echo '<td style="text-align:right">'.number_format($row->netto_masuk,2,',','.').'</td>';
        echo '<td style="text-align:right">'.number_format($row->netto_keluar,2,',','.').'</td>';
        $sisa_now = $sisa + $row->netto_masuk - $row->netto_keluar;
        echo '<td style="text-align:right">'.number_format($sisa_now,2,',','.').'</td>';
        echo '</tr>';
        $no++;
        $sisa = $sisa_now;
        $masuk += $row->netto_masuk;
        $keluar += $row->netto_keluar;
    }
    ?>
    <tr>
        <td colspan="3"></td>
        <td style="border-bottom:1px solid #000; border-top:1px solid #000; text-align: right;"><?=number_format($masuk,2,',','.');?></td>
        <td style="border-bottom:1px solid #000; border-top:1px solid #000; text-align: right;"><?=number_format($keluar,2,',','.');?></td>
        <td style="border-bottom:1px solid #000; border-top:1px solid #000; text-align: right;"><?=number_format($sisa,2,',','.');?></td>
    </tr>
    </tbody>
</table>
    <body onLoad="window.print()">
    </body>
</html>