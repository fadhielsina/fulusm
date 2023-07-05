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
  <center><h3><?= $this->lang->line('bukti_kas_keluar') ?></h3></center>
  <br/><br/>
	<table class="sum">
	<input type="hidden" class="form-control" name="jns" id="jns" value="TKM"  />
		   <tr>
          <td  style="vertical-align: top;"><?= $this->lang->line('dibayar_kepada') ?></td>
          <td  style="vertical-align: top;" colspan="3"><?php echo $row->dari; ?>
		  </td>
        </tr>
		<tr>
		<td style="vertical-align: top;"><?= $this->lang->line('catatan') ?></td>
		<td style="vertical-align: top;" colspan="3">
		<textarea name="catatan" value="2" class="form-control"  ><?php echo $row->keterangan; ?></textarea>
		</td>
		</tr>
		   <tr>
          <td  style="vertical-align: top;"><?= $this->lang->line('sesuai_dokumen') ?></td>
          <td  style="vertical-align: top;"><?php echo $row->dok; ?></td>
		   <td  style="vertical-align: top;" class="pull-right">Nomor Dokumen</td>
          <td  style="vertical-align: top;"><?php echo $row->no_dok; ?>
		  </td>
        </tr>
		  <tr>
          <td  style="vertical-align: top;"><?= $this->lang->line('uang_sejumlah') ?></td>
          <td  style="vertical-align: top;" colspan="3">Rp. <?php echo number_format($row->jumlah); ?>
		  </td>
        </tr>
		  <tr>
          <td  style="vertical-align: top;"><?= $this->lang->line('terbilang') ?></td>
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
			<th><?= $this->lang->line('uraian') ?>/<?= $this->lang->line('nama_akun') ?></th>
			<th><?= $this->lang->line('jumlah') ?>/<?= $this->lang->line('debit') ?></th>
			<th><?= $this->lang->line('no_akun') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if($jurnal_data)
			{
				foreach ($jurnal_data as $row) 
				{ 
				 $no_jurnal=$row->no;
				
					echo '<tr>';
					echo '<td>'.$row->account_name.'</td>';
					echo '<td>'.number_format(abs($row->nilai)).'</td>';
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
	