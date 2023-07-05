


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
  <div class="pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success',  'content' => $this->lang->line('tambah'), 'onClick' => "location.href='".site_url()."penjualan/add'" ));
		?>		
	</div>
  <h4 class="card-title">Cari Data</h4>
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
					$data['class'] = 'form-control col-md-4';
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
	<table cellpadding="0" cellspacing="0" border="0"  id="display_table">
	<thead>
		<tr>
			<th>Tanggal</th>
			<th>SJ</th>
			<th>NO. InvoiceS</th>
			<th>Supplier</th>
			<th>Total</th>
			<th>TOP</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if($journal_data)
			{
				foreach ($journal_data as $row) 
				{ 
					
					echo '<tr>';
					echo '<td>'. mediumdate_indo($row->trxDate) .'</td>';
					echo '<td>'. $row->trxFakturID.'</td>';
					echo '<td>'. $row->trxPOID .'</td>';
					echo '<td>'. $row->memberFullName .'</td>';
					
					echo '<td>'. number_format($row->trxTotal) .'</td>';
					echo '<td>'. $row->trxDate .'</td>';
						echo '<td><a href="'.base_url().'/penjualan/detail_sales/'.$row->trxID.'" class="btn btn-xs waves-effect waves-light btn-info">Detail</a></td>';
					echo '</tr>';
				}
			}
		?>
	</tbody>	
</table>		
</div>
  </div>
</div>