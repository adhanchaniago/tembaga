<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8" />
    </head>
    <body onLoad="window.print()">
      <table width="100%" style="page-break-after: auto;">
        <tr>
          <td align="center">
            <!-- <h4>Laporan sisa Sales Order per <?= date("M Y", strtotime($this->uri->segment(3))) ?></h4> -->
            <h4>Laporan sisa Sales Order per <?= date("M Y") ?></h4>
          </td>
        </tr>
      </table>
      <table width="100%" cellpadding="2" cellspacing="0" style="font-size: 13px;">
        <thead>
           <tr>
                <th style="text-align: center; border-top: 1px solid; border-left: 1px solid;">No</th>
                <th style="border-top: 1px solid; border-left: 1px solid;">Nama Customer</th>
                <th style="border-top: 1px solid; border-left: 1px solid;">No. Sales Order</th>
                <th style="border-top: 1px solid; border-left: 1px solid;">Tgl PO</th>
                <th style="border-top: 1px solid; border-left: 1px solid;">Kode Barang</th>
                <th style="border-top: 1px solid; border-left: 1px solid;">Nama Barang</th>
                <th style="text-align: center; border-top: 1px solid; border-left: 1px solid;">Harga/KG</th>
                <th style="text-align: center; border-top: 1px solid; border-left: 1px solid;">Netto Order</th>
                <th style="text-align: center; border-top: 1px solid; border-left: 1px solid;">Netto Kirim</th>
                <th style="text-align: center; border-top: 1px solid; border-left: 1px solid;">Sisa Order</th>
                <th style="text-align: center; border-top: 1px solid; border-left: 1px solid; border-right: 1px solid;">No. PO</th>
           </tr>
         </thead>
         <tbody>
        <?php 
        $no = 1; 
        $netto = 0;
        $netto2 = 0;
        $last_tolling = 0;
        $last_ppn = 0;
        $last_series = null;
        $last_series_2 = null;
        foreach($detailLaporan as $row){ 
          $sisa_order = $row->netto - $row->netto_kirim;
          if($sisa_order > 0){
 /*           $total_amount = $row->netto * $row->amount;  */
        if($last_tolling!=$row->flag_tolling){
          echo '<tr>
            <td colspan="2" style="text-align: right; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;">'.(($last_ppn==1)?'PPN' : 'Non PPN').' | '.(($last_tolling > 0)?'Tolling':'Non-Tolling').'</td>
            <td colspan="7" style="text-align: right; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; "><strong>Total</strong></td>
            <td style="text-align: right; border-left:1px solid #000; border-top:1px solid #000; border-bottom:1px solid #000;"><strong>'.number_format($netto,2,',','.').'</strong></td>
            <td style="border:1px solid #000;"></td>
          </tr>';
          $netto = 0;
          $last_series=null;
          $last_series_2=null;
        }else{
           echo '';
        }
        ?>
            <tr>
                <?php echo ($last_series==$row->nama_customer) ? '<td align="center" style="border-left: 1px solid;">' : '<td align="center" style="border-top: 1px solid; border-left: 1px solid;">'.$no;?></td>
                <?php echo ($last_series==$row->nama_customer) ? '<td style="border-left:1px solid #000">' : '<td style="border-top: 1px solid;border-left: 1px solid;">'.$row->nama_customer; ?></td>
                <?php echo ($last_series_2==$row->no_sales_order) ? '<td style="border-left:1px solid #000">' : '<td style="border-top: 1px solid;border-left: 1px solid;">'.$row->no_sales_order; ?></td>
                <td align="center" style="border-top: 1px solid; border-left: 1px solid;"><?= date('d-m-Y', strtotime($row->tgl_po)) ?></td>
                <td style="border-top: 1px solid; border-left: 1px solid;"><?= $row->kode_barang ?></td>
                <td style="border-top: 1px solid; border-left: 1px solid;"><?= $row->nama_barang ?></td>
                <td align="center" style="border-top: 1px solid; border-left: 1px solid;"><?= number_format($row->amount,2,',','.') ?></td>
                <td align="center" style="border-top: 1px solid; border-left: 1px solid;"><?= number_format($row->netto,2,',','.') ?></td>
                <td align="right" style="border-top: 1px solid; border-left: 1px solid;"><?= number_format($row->netto_kirim,2,',','.') ?></td>
                <td align="right" style="border-top: 1px solid; border-left: 1px solid;"><?= number_format($sisa_order,2,',','.') ?></td>
                <td align="right" style="border-top: 1px solid; border-left: 1px solid; border-right: 1px solid;"><?=$row->no_po;?></td>
            </tr>
        <?php 
          ($last_series==$row->nama_customer) ? '' : $no++; 
          $last_ppn = $row->flag_ppn;
          $last_tolling = $row->flag_tolling;
          $last_series = $row->nama_customer;
          $last_series_2 = $row->no_sales_order;
          $netto += $sisa_order;
          $netto2 += $sisa_order;
          } 
        }
        ?>
          <tr>
            <td colspan="2" style="text-align: right; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;"><?=(($last_ppn==1)?'PPN' : 'Non PPN').' | '.(($last_tolling > 0)?'Tolling':'Non-Tolling');?></td>
            <td colspan="7" style="text-align: right; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; "><strong>Total</strong></td>
            <td style="text-align: right; border-left:1px solid #000; border-top:1px solid #000; border-bottom:1px solid #000;"><strong><?=number_format($netto,2,',','.');?></strong></td>
            <td style="border:1px solid #000;"></td>
          </tr>
          <tr>
            <td colspan="9" style="text-align: right; border-left:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; "><strong>Grand Total</strong></td>
            <td style="text-align: right; border-left:1px solid #000; border-top:1px solid #000; border-bottom:1px solid #000;"><strong><?=number_format($netto2,2,',','.');?></strong></td>
            <td style="border:1px solid #000;"></td>
          </tr>
        </tbody>
      </table>
    </body>
</html>