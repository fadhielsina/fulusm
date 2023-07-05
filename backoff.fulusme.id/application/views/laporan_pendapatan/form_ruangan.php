
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

<div class="card" style="padding-top:25px">
<div class="card-body" style="padding-top:30px">
<div class="post-title" style="margin-top: 20px;">
<h4 class="card-title"><?php echo $title ?></h4>
</div>
	<form id="form_laporan" method="POST"> 
	<?php echo form_hidden('nama_laporan', $nama_laporan); ?>
	<table  cellpadding="2" cellspacing="0" style="width:100%;height: auto;">					
		<tr>
			<th><?php echo form_label($this->lang->line('jenis_laporan'),'jenis_laporan'); ?></th>
			<td>
				<?php 
					$data['id'] = 'jenis_laporan';
					$data['class'] = "form-control";
					$selected = 'laporan_neraca';
					$options = array( 'laporan_harian' => $this->lang->line('harian'),
								  	  'laporan_bulanan' => $this->lang->line('bulanan')
								  	);
					echo form_dropdown('jenis_laporan', $options, $selected, $data);
				?>					
			</td>
		</tr>		
		<tr>
			<th><?php echo form_label($this->lang->line('tgl_laporan'),'tgl_laporan'); ?></th>
			<td >
				<div class="input-daterange input-group" id="datepicker" >
				    <input type="text" class="input-sm form-control" name="start" />
				    <span class="input-group-addon">to</span>
				    <input type="text" class="input-sm form-control" name="end" />
				</div>
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('ruangan'),'jenis_ruangan'); ?></th>
			<td>
				<?php 
					$data['id'] = 'jenis_ruangan';
					$data['class'] = "form-control";
					$selected = '';
					$options = array( 'all' => $this->lang->line('semua_ruangan'),
								  	  'Multazam II.212 ISO'=>'Multazam II.212 ISO',
										'Multazam II.205'=>'Multazam II.205',
										'ICU'=>'ICU',
										'Marwah 232'=>'Marwah 232',
										'PICU'=>'PICU',
										'Marwah 236'=>'Marwah 236',
										'Arafah 6'=>'Arafah 6',
										'Madinah 3'=>'Madinah 3',
										'Shofa 225'=>'Shofa 225',
										'Marwah 234'=>'Marwah 234',
										'Multazam II.223'=>'Multazam II.223',
										'ARAFAH BOX BAYI 8'=>'ARAFAH BOX BAYI 8',
										'Madinah 1'=>'Madinah 1',
										'Multazam II.208'=>'Multazam II.208',
										'Multazam II.207'=>'Multazam II.207',
										'MADINAH 8'=>'MADINAH 8',
										'Arafah 2'=>'Arafah 2',
										'Multazam II.211 ISO'=>'Multazam II.211 ISO',
										'Shofa 226'=>'Shofa 226',

								  	);
					echo form_dropdown('jenis_ruangan', $options, $selected, $data);
				?>					
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('nama_asuransi'),'nama_asuransi'); ?></th>
			<td>
				<?php 
					$data['id'] = 'nama_asuransi';
					$data['class'] = "form-control";
					$selected = 'all';
					$options = array( 'all' => $this->lang->line('semua'),
								  	  'askes'=>'ASKES',
										'askes pns'=>'ASKES PNS',
										'axa mandiri'=>'AXA Mandiri',
										'b n i'=>'B N I',
										'bpjs non pbi'=>'BPJS NON PBI',
										'bpjs non pbi + kai'=>'BPJS NON PBI + KAI',
										'bpjs pbi'=>'BPJS PBI',
										'in health '=>'IN HEALTH ',
										'jalinan kasih'=>'JALINAN KASIH',
										'jampersal'=>'JAMPERSAL',
										'jasa raharja'=>'JASA RAHARJA',
										'karyawan pku'=>'KARYAWAN PKU',
										'prudential'=>'PRUDENTIAL',
										'pt. telkom'=>'PT. TELKOM'
								  	);
					echo form_dropdown('nama_asuransi', $options, $selected, $data);
				?>					
			</td>
		</tr>
	</table>
	</form>
	<div class="buttons">
		<?php
			echo form_button(array('id' => 'button-save', 'content' => $this->lang->line('buat_laporan')));
			echo form_button('reset','Reset', "id = 'button-reset'" );
		?>
	</div>
</div>
</div>
<div id="content_area">
	
</div>


<script type="text/javascript" charset="utf-8">
	$(function() {
		$('#button-save').click(function() {
			var jenis_laporan = $('#jenis_laporan').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			$.post("<?php echo site_url()."laporan/"?>"+jenis_laporan,$("#form_laporan").serialize(),function(result){
				$("#content_area").html(result);
			});
			//location.href = '<?php echo site_url();?>laporan_keuangan/'+jenis_laporan+'/'+bulan+'/'+tahun;
		});
	});
	
    $('.input-daterange').datepicker({
	     orientation: "bottom left"
	});

</script>
