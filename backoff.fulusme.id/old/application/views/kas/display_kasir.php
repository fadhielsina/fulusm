<br/>
<div class="post-title col-lg-12"><h3 class="pull-left"><?php echo $title; ?></h3>
</div>
<br/><br/>
		<div class="col-lg-12">		
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>		
	</div>
	<div class="col-lg-12">
  <div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
		<thead>
			<tr>
				<th>No.Trx</th>
				<th>No Invoice</th>
				<th>No Kendaraan</th>
				<th>Merk Kendaraan</th>
				<th>Tahun Kendaraan</th>
				<th>Total Harga</th>
			</tr>
		</thead>						
		<tbody>
			<?php
				if($kas_data)
				{
					foreach ($kas_data as $row)
					{
						echo '<tr>';
						echo '<td>'.$row->trxID.'</td>';
						echo '<td>'.$row->invoiceID.'</td>';
						echo '<td>'.$row->nopol.'</td>';
						echo '<td>'.$row->car_merk.'</td>';
						echo '<td>'.$row->car_year.'</td>';
						echo '<td>'.number_format($row->trxTotal).'</td>';
						echo '</tr>';
					}
				}
			?>	
		</tbody>
	</table>
</div>			
</div>			
</div>			
</div>			
