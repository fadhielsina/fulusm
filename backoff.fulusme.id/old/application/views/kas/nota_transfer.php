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
  <center><h3>CASH TRANSFER NOTE</h3></center>
  <br/><br/>
	<table class="sum">
	<input type="hidden" class="form-control" name="jns" id="jns" value="TKM"  />
		   <tr>
          <td  style="vertical-align: top;">From Account</td>
          <td  style="vertical-align: top;" colspan="3"><?php echo $row->nm_akun; ?>
		  </td>
        </tr>
		   <tr>
          <td  style="vertical-align: top;">To Account</td>
          <td  style="vertical-align: top;" colspan="3"><?php echo $row->nm_akun2; ?>
		  </td>
        </tr>
		<tr>
		<td style="vertical-align: top;">Note</td>
		<td style="vertical-align: top;" colspan="3">
		<textarea name="catatan" value="2" class="form-control"  ><?php echo $row->keterangan; ?></textarea>
		</td>
		</tr>
		  <tr>
          <td  style="vertical-align: top;"></td>
          <td  style="vertical-align: top;" colspan="3">Rp. <?php echo number_format($row->jumlah); ?>
		  </td>
        </tr>
		  <tr>
          <td  style="vertical-align: top;">Be calculated</td>
          <td  style="vertical-align: top;" colspan="3"><?php echo terbilang($row->jumlah); ?>
		  </td>
        </tr>
	</table>	
 				<?php }} ?>
	
</div>
	