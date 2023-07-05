<div class="card">
<div class="card-body">
<h3 class="card-title" ><a href="#"><?php echo $title; ?></a></h3>
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
	<form id="form_laporan" method="POST" >
	<?php echo form_hidden('jenis_laporan', $jenis_laporan); ?>
	<table cellpadding="2" cellspacing="0" style="width:100%;height:auto">

		<tr>
			<th><?php echo form_label($this->lang->line('bulan'),'bulan'); ?></th>
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
			<th><?php echo form_label($this->lang->line('tahun'),'tahun'); ?></th>
			<td>
				<?php
					$data['id'] = 'tahun';
					$selected = date("Y");
					echo form_dropdown('tahun', $years, $selected, $data);
				?>
			</td>
		</tr>
		<?php
		//jika admin tampilkan Seluruh Data Peruhaaan
		if($this->session->userdata('ADMIN')){
		?>
			<tr>
			<th></th>
			<td>
				<?php
					$data['id'] = 'tahun';
					$selected = date("Y");
				?>
			</td>
			</tr>
		<?php
		}
		?>
	</table>

	<div class="buttons">
		<?php
			echo form_button(array('id' => 'button-save', 'content' => $this->lang->line('buat_laporan')));
			echo form_reset('reset','Reset', "id = 'button-reset'" );
		?>
	</div>

</div>
</div>
<div id="content_area" ></div>
<?php

?>

<script type="text/javascript" charset="utf-8">
	$(function() {
		$('#button-save').click(function() {
			var jenis_laporan = $('#jenis_laporan').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			$.post("<?php echo site_url()."laporan/lap_jatuh_tempo"?>",$("#form_laporan").serialize(),function(result){
				$("#content_area").html(result);
			});
		});
	});
</script>
