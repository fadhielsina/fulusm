


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
  <h4 class="card-title">Pencarian Buku Besar</h4>
   <div class="col-lg-6">
  <table border="0" align="center" cellpadding="2" cellspacing="0" style="width:100%;">						  		
		<tr>
			<?php if( $this->session->userdata('IDENTITY_ID') > 1 ): ?>
			<input type="hidden" name="lokasi" id="lokasi" value="<?php echo $this->session->userdata('IDENTITY_ID'); ?>">
			<?php else: ?>
			<td>Lokasi Kantor</td>
			<td>
				<?php echo form_dropdown('lokasi', $lokasi, $selected_lokasi ,array('class' => 'form-control', 'id' => 'lokasi')); ?>
			</td>
			<?php endif; ?>
		</tr>
		<tr>
			<td>
				<?php echo form_label($this->lang->line('bulan'),'bulan'); ?></td>
			<td>
				<?php 
					$data['id'] = 'bulan';
					$data['class'] = 'form-control';
					$selected = date("m") ;
					echo form_dropdown('bulan', $months, $selected, $data);
				?>					
			</td>
		</tr>	
		<tr>
			<td>
				<?php echo form_label($this->lang->line('tahun'),'tahun'); ?></td>
			<td>
				<?php 
					$data['id'] = 'tahun';
					$selected = date("Y") ;
					echo form_dropdown('tahun', $years, $selected, $data);
				?>					
			</td>
		</tr>								
	</table>
	
	<div class="buttons">
		<?php 			
				echo form_button(array('id' => 'button-save', 'type' => 'submit', 'content' => $this->lang->line('cari')));
				echo form_reset('reset','Reset', "id = 'button-reset'" );
				
		?>
	</div>
	</div>
  </div>

</div>
	
	
<?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>
 <div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_jurnal') ?></h4>
	<table cellpadding="0" cellspacing="0" border="0" class="display table-responsive" id="display_table">
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
			<th>Unit Code</th>
			<th>Cust. Code</th>
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
					echo '<td>'. $row->identityID .'</td>';
					echo '<td>'. $row->memberCode .'</td>';
					echo '</tr>';
				}
			}
		?>
	</tbody>	
</table>		
</div>
  </div>
</div>