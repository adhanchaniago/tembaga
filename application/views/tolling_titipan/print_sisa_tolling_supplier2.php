<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body onLoad="window.print()">
      <table width="100%" style="page-break-after: auto;">
        <tr>
          <td colspan="2" align="center">
            <!-- <h4>Laporan sisa Sales Order per <?= date("M Y", strtotime($this->uri->segment(3))) ?></h4> -->
            <h4>Laporan sisa Tolling Supplier per <?=tanggal_indo($tgl); ?></h4>
          </td>
        </tr>
      </table>
      <table width="100%" cellpadding="2" cellspacing="0" style="font-size: 13px;">
        <thead>
           <tr>
                <th style="text-align: center; border-top: 1px solid; border-left: 1px solid;">No</th>
                <th style="border-top: 1px solid; border-left: 1px solid;">Nama Supplier</th>
                <th width="5%" style="text-align: center; border-top: 1px solid; border-left: 1px solid; border-right: 1px solid;">Netto</th>
           </tr>
         </thead>
         <tbody>
          <?php
          $no = 0;

          $netto = 0;
          foreach ($detailLaporan as $row){
            $no++;
              echo '<tr>';
              echo '<td align="center" style="border-top: 1px solid; border-left: 1px solid;">'.$no.'</td>';
              echo '<td style="border-top: 1px solid;border-left: 1px solid;">'.$row->nama_supplier.'</td>';
              echo '<td style="text-align:right; border-top: 1px solid;border-left: 1px solid;border-right: 1px solid">'.number_format($row->netto,2,',','.').'</td>';
              echo '</tr>';

              $netto += $row->netto;
          }
          ?>
          <tr>
            <td colspan="2" style="text-align: right; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; "><strong>Grand Total</strong></td>
            <td style="text-align: right; border-left:1px solid #000; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;"><strong><?=number_format($netto,2,',','.');?></strong></td>
          </tr>
        </tbody>
      </table>
    </body>
</html>