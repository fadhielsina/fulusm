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
	<b>PT. FRIGIA AIRCONDITIONING ( <?php echo strtoupper($nameper);?> ) - <?php echo strtoupper($address);?></b><br/>
	<b>LAPORAN TRANSAKSI KAS - PENDAPATAN</b>
	</center>
	<br/><br/>
<table class="sum" >
  <thead>
  <tr>
  <th rowspan="2" scope="colgroup" style="text-align: center;">Tanggal</th>
    <th  rowspan="2" scope="colgroup" style="text-align: center;"> No. Jurnal</th>
    <th colspan="2" scope="colgroup" style="text-align: center;">No. Bukti</th>
	<th rowspan="2" scope="colgroup" style="text-align: center;">Keterangan</th>
	<th rowspan="2" scope="colgroup" style="text-align: center;">Debit</th>
    <th colspan="2" scope="colgroup" style="text-align: center;">Kredit</th>
    <th rowspan="2" scope="colgroup" style="text-align: center;">Saldo</th>
  </tr>
  <tr>
    <th scope="col" style="text-align: center;">No. Invoice</th>
    <th scope="col" style="text-align: center;">Bukti Setoran</th>
    <th scope="col" style="text-align: center;">Bank</th>
    <th scope="col" style="text-align: center;">Kas Pusat</th>
   
  </tr>
  </thead>
  <tbody>
  <tr>
  <td></td>
  <td></td>
   <td></td>
  <td></td>
   <td><b>Saldo Awal</b></td>
  <td></td>
   <td></td>
  <td></td>
   <td style="text-align: right;"><b><?php echo number_format($saldo); ?></b></td>
		<?php 
			if($datapen)
			{
				$sub='';
				$saldakhir='';
				$saldoawal=$saldo;
				foreach ($datapen->result() as $row) 
				{ 
			
					$saldoawal=$saldoawal+$row->nilai;
					$saldakhir=$saldoawal;
					$sub=$sub+$row->nilai;
					echo '<tr>';
					echo '<td>'.mediumdate_indo($row->trxDate).'</td>';
					echo '<td>'.$row->no.'</td>';
					echo '<td>'.$row->invoiceID.'</td>';
					echo '<td>'.$row->invoiceIDmanual.'</td>';
					echo '<td>'.$row->ket_jurnal.'</td>';
					echo '<td style="text-align: right;">'.number_format($row->nilai).'</td>';	
					echo '<td></td>';	
					echo '<td></td>';	
					echo '<td  style="text-align: right;">'.number_format($saldoawal).'</td>';	
					echo '</tr>';
				}
			}
		?>
	</tbody>	
	<tfoot>
	<tr>
	<td></td><td></td><td></td>
	<td></td>
	<td><b>JUMLAH</b></td>
	<td style="text-align: right;"><b><?php if($sub) { echo number_format($sub); } ?></b></td>
	<td></td><td></td>
	<td style="text-align: right;"><b><?php if($saldakhir) { echo number_format($saldakhir); } ?></b></td>
	</tr>
	</tfoot>
</table>	
</div>		
