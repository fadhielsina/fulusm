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
<?php if($kas_data)
				{ foreach ($kas_data as $row){ ?>
			<div style="text-align:right;">Nomor : <span style="border:thin solid #000;padding-left:8px;padding-right:8px;"><?php echo $row->no_trx_kas; ?></span></div>
			<br/>
  <center><h3>BUKTI KAS MASUK</h3></center>
  <br/><br/>
	<table class="sum">
	<input type="hidden" class="form-control" name="jns" id="jns" value="TKM"  />
		   <tr>
          <td  style="vertical-align: top;">Diterima Dari</td>
          <td  style="vertical-align: top;" colspan="3"><?php echo $row->dari; ?>
		  </td>
        </tr>
		<tr>
		<td style="vertical-align: top;">Catatan</td>
		<td style="vertical-align: top;" colspan="3">
		<textarea name="catatan" value="2" class="form-control"  ><?php echo $row->keterangan; ?></textarea>
		</td>
		</tr>
		   <tr>
          <td  style="vertical-align: top;">Sesuai Dokumen</td>
          <td  style="vertical-align: top;"><?php echo $row->dok; ?></td>
		   <td  style="vertical-align: top;" class="pull-right">Nomor Dokumen</td>
          <td  style="vertical-align: top;"><?php echo $row->no_dok; ?>
		  </td>
        </tr>
		  <tr>
          <td  style="vertical-align: top;">Uang Sejumlah</td>
          <td  style="vertical-align: top;" colspan="3">Rp. <?php echo number_format($row->jumlah); ?>
		  </td>
        </tr>
		  <tr>
          <td  style="vertical-align: top;">Terbilang</td>
          <td  style="vertical-align: top;" colspan="3"><?php echo terbilang($row->jumlah); ?>
		  </td>
        </tr>
	</table>	
 				<?php }} ?>
	
<?php if($jurnal_data) { ?>	
<br/><br/>
	<table class="sum">
	<thead>
		<tr>
			<th>Uraian / Nama Akun</th>
			<th>Jumlah ( Kredit )</th>
			<th>No Akun</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if($jurnal_data)
			{
				foreach ($jurnal_data as $row) 
				{ 
				 $no_jurnal=$row->no;
					if($row->debit_kredit == 1)
					{
						$d = $row->nilai;
						$k = '';
					}
					else
					{
						$d = '';
						$k = $row->nilai; 
					}
					echo '<tr>';
					echo '<td>'.$row->account_name.'</td>';
					echo '<td>'.number_format(abs($d)).'</td>';
					echo '<td>'.$row->kode.'</td>';
					echo '</tr>';
				}
			}
		?>
	</tbody>	
</table>		
<?php } ?>
<br/><br/>
<div style="text-align:right;">No. Jurnal : <span style="border:thin solid #000;padding-left:8px;padding-right:8px;"><?php echo $no_jurnal; ?></span></div>
</div>
	