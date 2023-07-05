


<div class="post-body">

<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	
	$data['class'] = 'input';

	echo form_open($search_URL, array( 'id' => 'form_search' ));

	$attributes = array('id' => 'fieldset', 'class' => 'fieldset');
?>
<div class="card">
		<div class="card-body">
				<table cellpadding="2" cellspacing="0" style="width:100%;height: auto;" class="m-b-15">					
					<tr>
						<td>Tanggal Awal
							<input type="date" class="input-sm form-control" name="start" id="start"  autocomplete="off" />
						</td>
						<td>Tanggal Akhir
							<input type="date" class="input-sm form-control" name="end" id="end" autocomplete="off" />
						</td>
						<td><br>
							<input type="submit" value="Cari" class="btn btn-info">
						</td>
					</tr>	
				</table>
			<?php echo form_close(); ?>
		</div>
	</div>
	
	
	
<?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>
 <div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_jurnal') ?></h4>
	<table cellpadding="0" cellspacing="0" border="0" class="display table-responsive" id="display_table" width="100%">
	<thead>
		<tr>
			<th>Date</th>
			<th>Doc Num</th>
			<th>COA</th>
			<th>Nama Akun</th>
			<th>Keterangan</th>
			<th>D</th>
			<th>K</th>
			<th>Jumlah</th>
			<th>Doc PO</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if($journal_data)
			{
				foreach ($journal_data as $row) 
				{ 
					if($row->debit_kredit == 1)
					{
						$d = $row->nilai;
						$k = 0;
					}
					else
					{
						$d = 0;
						$k = $row->nilai; 
					}
					echo '<tr>';
					echo '<td>'. $row->tgl .'</td>';
					echo '<td>'. $row->no_jurnal.'</td>';
					echo '<td>'. $row->kode .'</td>';
					echo '<td>'. $row->nama .'</td>';
					echo '<td>'. $row->keterangan .'</td>';
					echo '<td>'. number_format( $d ).'</td>';
					echo '<td>'. number_format( $k ).'</td>';
					echo '<td>'. number_format( $d + -abs($k) ).'</td>';
					echo '<td>'. $row->note_trx.'</td>';
					echo '</tr>';
				}
			}
		?>
	</tbody>	
</table>		
</div>
  </div>
</div>