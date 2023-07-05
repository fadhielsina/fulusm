<style>
.content-wrapper
{
	font-family:Arial, 'Helvetica Neue',Helvetica, sans-serif;
	font-size:11px;
}
p {
	line-height:1;
}

table.header {
border-collapse: collapse;
border-spacing: 0;
}
table.header tr,td { border: none; text-align:left; padding:2px; }

table.sum {
border-collapse: collapse;
border-spacing: 0;
width:100%;
}
table.sum th, tr, td { border: 1px solid #4f4f4f; padding:2px; }
table.trxapp {
border-spacing: 5;
}
table.trxapp td, th { padding:5px;text-align:center; }

.col-md-12{
}
</style> 
<div class="content-wrapper">
	<center>
	<b>PT. FRIGIA AIRCONDITIONING  - <?php echo strtoupper($address);?></b><br/>
	<b>LAPORAN TRANSAKSI  ( <?php echo strtoupper($nameper);?> ) - PENDAPATAN</b>
	</center>
	<br/><br/>
<table class="sum" >
  <thead>
  <tr>
  <th rowspan="2" scope="colgroup" style="text-align: center;">Tanggal</th>
    <th  rowspan="2" scope="colgroup" style="text-align: center;"> No. Jurnal</th>
    <th  rowspan="2" scope="colgroup" style="text-align: center;"> No. Invoice</th>
	<th rowspan="2" scope="colgroup" style="text-align: center;">Keterangan</th>
	<th rowspan="2" scope="colgroup" style="text-align: center;">Jenis Pembayaran</th>
	<th rowspan="2" scope="colgroup" style="text-align: center;">Nilai Invoice</th>
    <th colspan="2" scope="colgroup" style="text-align: center;">Biaya Administrasi</th>
    <th rowspan="2" scope="colgroup" style="text-align: center;">Jumlah Netto</th>
  </tr>
  <tr>
    <th scope="col" style="text-align: center;">%</th>
    <th scope="col" style="text-align: center;">Jumlah</th>
   
  </tr>
  </thead>
   <tbody>
		<?php 
			if($datapen)
			{
				$netto='';
				$netto_tot='';
				$inv='';
				foreach ($datapen->result() as $row) 
				{ 
			
					$netto=$row->trxTotal-$row->trxbankadmin;
					$netto_tot=$netto_tot+$netto;
					$inv=$inv+$row->trxTotal;
					echo '<tr>';
					echo '<td>'.mediumdate_indo($row->trxDate).'</td>';
					echo '<td>'.$row->no.'</td>';
					echo '<td>'.$row->invoiceID.'</td>';
					echo '<td>'.$row->ket_jurnal.'</td>';
					echo '<td>'.$row->nm_tipe.'</td>';
					echo '<td style="text-align: right;">'.number_format($row->trxTotal).'</td>';	
					echo '<td style="text-align: right;"></td>';	
					echo '<td style="text-align: right;">'.number_format($row->trxbankadmin).'</td>';	
					echo '<td  style="text-align: right;">'.number_format($netto).'</td>';	
					echo '</tr>';
				}
			}
		?>
	</tbody>	
	<tfoot>
	<tr>
	<td></td><td></td><td></td>
	<td></td>
	<td><h5>JUMLAH</h5></td>
	<td style="text-align: center;"><h5><?php if($inv) { echo number_format($inv); } ?></h5></td>
	<td></td><td></td>
	<td style="text-align: center;"><h5><?php if($netto) { echo number_format($netto_tot); } ?></h5></td>
	</tr>
	</tfoot>
</table>	
</div>		
