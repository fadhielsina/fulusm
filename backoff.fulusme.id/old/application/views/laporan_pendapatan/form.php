<script type="text/javascript" charset="utf-8">
	$(function() {
		$('#button-save').click(function() {
			var jenis_laporan = $('#jenis_laporan').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();
			//location.href = '<?php echo site_url();?>laporan_keuangan/'+jenis_laporan+'/'+bulan+'/'+tahun;
		});
	});
</script>

<div class="card">
<div class="card-title" style="padding-right: 5px;">
	<h2><a href="#"><?php echo $title; ?></a></h2>
</div>

<div class="card-body">

<?php
	echo "<div id='error' class='error-message' ";

	if($this->session->userdata('ERRMSG_ARR'))
	{
		echo ">";
		echo $this->session->userdata('ERRMSG_ARR');
		$this->session->unset_userdata('ERRMSG_ARR');
	}
	else
	{
		echo "style='display:none'>";
	}
	
	echo "</div>";

	$data['class'] = 'input';	
?>

	<table cellpadding="2" cellspacing="0" style="width:100%;height:auto">						  		
		<tr>
			<th><?php echo form_label('Jenis Laporan','jenis_laporan'); ?></th>
			<td>
				<?php 
					$data['id'] = 'jenis_laporan';
					$data['class'] = "form-control";
					$selected = 'laporan_neraca';
					$options = array( 'laporan_operasional' => 'Operasional',
								  	  'laporan_neraca' => 'Laporan Neraca',
								  	  'laporan_neraca_lajur' => 'Laporan Neraca Lajur'
								  	);
					echo form_dropdown('jenis_laporan', $options, $selected, $data);
				?>					
			</td>
		</tr>
		<tr>
			<th><?php echo form_label('Poli','poli'); ?></th>
			<td>
				<?php 
					$data['id'] = 'poli';
					$data['class'] = "form-control";
					$selected = "-";
					$options = array( '-'=>"Semua Poli",
									  'poli_penyakit_dalam' => 'Poli Penyakit Dalam',
								  	  'poli_gigi_mulut' => 'Poli Gigi dana Mulut',
								  	  'poli_kandundan' => 'Poli Kandungan',
								  	);
					echo form_dropdown('poli', $options, $selected, $data);
				?>					
			</td>
		</tr>
		<tr>
			<th><?php echo form_label('Bulan','bulan'); ?></th>
			<td>
				<?php 
					$data['id'] = 'bulan';
					$data['class'] = "form-control";
					$selected = date("m");
					echo form_dropdown('bulan', $months, $selected, $data);
				?>					
			</td>
		</tr>		
		<tr>
			<th><?php echo form_label('Tahun','tahun'); ?></th>
			<td>
				<?php 
					$data['id'] = 'tahun';
					$selected = date("Y");
					echo form_dropdown('tahun', $years, $selected, $data);
				?>					
			</td>
		</tr>							
	</table>
	
	<div class="buttons">
		<?php
			echo form_button(array('id' => 'button-save', 'content' => 'Buat Laporan'));
			echo form_reset('reset','Reset', "id = 'button-reset'" );
		?>
	</div>
	
</div>
</div>
