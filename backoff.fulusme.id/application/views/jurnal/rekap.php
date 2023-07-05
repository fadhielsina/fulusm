


<div class="post-body">

<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	
	$data['class'] = 'input';

	echo form_open($search_URL);

	$attributes = array('id' => 'fieldset', 'class' => 'fieldset');
?>
 <div class="card">
  <div class="card-body">
  <h4 class="card-title">PENCARIAN JURNAL</h4>
   <div class="col-lg-6">
  <table width="300" border="0" align="center" cellpadding="2" cellspacing="0">						  		
		<tr>
			<th>
				<?php echo form_label('Bulan','bulan'); ?>
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
			<th>
				<?php echo form_label('Tahun','tahun'); ?>
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
				echo form_button('cari', 'Cari', "id = 'button-save'" );
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
  <h4 class="card-title"><?php echo $title ?></h4>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
	<thead>
		<tr>
			<th>Tanggal</th>
			<th>No</th>
			<th>No Invoice</th>
		<?php //} ?>
		</tr>
	</thead>
	<tbody>
		<?php 
			if($journal_data)
			{
				foreach ($journal_data as $row) 
				{ 
					
					echo '<tr>';
					echo '<td>'.$row->tgl.'</td>';
					echo '<td>'.$row->no.'</td>';
					echo '<td>'.$row->keterangan.'</td>';
					echo '</tr>';
				}
			}
		?>
	</tbody>	
	<tfoot>
		<tr>
			<th>Tanggal</th>
			<th>No</th>
			<th>Item</th>
		</tr>
	</tfoot>
</table>		
</div>
  </div>
</div>		
<script type="text/javascript" charset="utf-8">
	$(function() {
		$('#button-save').click(function() {
			var bln = $('#bulan').val();
			var thn = $('#tahun').val();
			
			oTable.fnClearTable();
			$.post('<?php echo $search_URL ?>',
				  { bulan : bln, tahun : thn},
				  function(msg){
					if(msg) {
						msg = eval(msg);
						oTable.fnAddData(msg);
					}
				  }
			  );
		});
	});
</script>