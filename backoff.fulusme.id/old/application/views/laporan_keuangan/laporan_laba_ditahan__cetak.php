<?php
    $this->load->view('template/header_head_cetak');
?>

<div class="row">
	<div class="col-12">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Laba Ditahan</h3>
			<p style="text-align: center;margin-top: 5px;"><?php echo sprintf( 'Per %s', $start_tahun ) ?></p>
		</div>
	</div>
</div>

<table class="table-report-paper">
	<thead>
		<tr><th class="th-head text-left">Keterangan</th><th class="th-head text-right">Nilai</th></tr>
	</thead>

	<tbody>
		<tr><td>Laba ditahan tahun <?php echo $start_tahun - 1; ?></td><td></td></tr>
		<tr><td class="bold"><strong>Laba Bersih Tahun ini</strong></td><td></td></tr>
		<tr><td class="bold"><strong>Laba ditahan tahun <?php echo $start_tahun; ?></strong></td><td></td></tr>
	</tbody>
</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>