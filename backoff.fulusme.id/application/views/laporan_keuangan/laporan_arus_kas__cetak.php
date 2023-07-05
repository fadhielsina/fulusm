<?php
    $this->load->view('template/header_head_cetak');
?>

<div class="row">
	<div class="col-12">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Arus Kas</h3>
			<p style="text-align: center;margin-top: 5px;"><?php echo sprintf( 'Dari Periode %s/%s s/d %s/%s', $start_bulan, $start_tahun, $end_bulan, $end_tahun ) ?></p>
		</div>
	</div>
</div>

<table class="table-report-paper">
	<thead>
		<tr><th class="th-head text-left">Deskripsi</th><th class="th-head text-right">Nilai</th></tr>
	</thead>

	<tbody>
		<tr><td class="bold"><strong>Arus kas dari Aktivitas Operasional</strong></td><td></td></tr>
		<?php 
			$saldo_operasi = 0;
			foreach( $data as $d ):
			if ( 'Arus kas Dari Aktivitas Operasi' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$saldo_operasi += $saldo;
		?>
			<tr><td class="indent-1"><?php echo $d['nama_akun']; ?></td><td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td></tr>
		<?php endforeach;?>
		<tr><td class="bold"><strong>Kas bersih yang diperoleh dari Aktivitas Operasional</strong></td><td class="text-right border-top"><?php echo to_abs_nom( $saldo_operasi ); ?></td></tr>

		<tr><td class="bold"><strong>Arus kas dari Aktivitas Investasi</strong></td><td></td></tr>
		<?php 
			$saldo_investasi = 0;
			foreach( $data as $d ):
			if ( 'Arus kas Dari Aktivitas Investasi' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$saldo_investasi += $saldo;
		?>
			<tr><td class="indent-1"><?php echo $d['nama']; ?></td><td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td></tr>
		<?php endforeach;?>
		<tr><td class="bold"><strong>Kas bersih yang diperoleh dari Aktivitas Investasi</strong></td><td class="text-right border-top"><?php echo to_abs_nom( $saldo_investasi ); ?></td></tr>

		<tr><td class="bold"><strong>Arus kas dari Aktivitas Pendanaan</strong></td><td></td></tr>
		<?php 
			$saldo_pendanaan = 0;
			foreach( $data as $d ):
			if ( 'Arus kas Dari Aktivitas Pendanaan' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$saldo_pendanaan += $saldo;
		?>
			<tr><td class="indent-1"><?php echo $d['nama']; ?></td><td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td></tr>
		<?php endforeach;?>
		<tr><td class="bold"><strong>Kas bersih yang diperoleh dari Aktivitas Pendanaan</strong></td><td class="text-right border-top"><?php echo to_abs_nom( $saldo_pendanaan ); ?></td></tr>

		<tr><td class="bold"><strong>Kas bersih dihasilkan oleh / (dipakai) di Periode ini</strong></td><td class="text-right border-top"><?php echo to_abs_nom( $saldo_operasi + $saldo_investasi + $saldo_pendanaan ); ?></td></tr>
		<tr><td class="bold"><strong>Kas dan Setara Kas di awal periode</strong></td><td class="text-right border-top">0</td></tr>
		<tr><td class="bold"><strong>Kas dan Setara Kas di akhir periode</strong></td><td class="text-right border-top"><?php echo to_abs_nom( $saldo_operasi + $saldo_investasi + $saldo_pendanaan ); ?></td></tr>
		
	</tbody>
</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>