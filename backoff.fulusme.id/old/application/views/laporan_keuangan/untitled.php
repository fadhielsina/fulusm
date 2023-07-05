<?php
    $this->load->view('template/header_head_cetak');
    $column_text = $tanggal1;
?>

<div class="row">
	<div class="col-12">
		<img src="<?php echo site_url(); ?>assets/img/logo-smb-left.png" width="200" style="">
		<div style="margin-top:-45px;">
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Neraca (Standar)</h3>
			<p style="text-align: center;"><?php echo 'Per Tgl. ' . $column_text; ?></p>
		</div>
	</div>
</div>

<table>
	<thead>
		<tr><th class="th-head text-left">Deskripsi</th><th class="th-head text-right">Nilai</th></tr>
	</thead>

	<tbody>
		<tr><td class="bold"><strong>ASET</strong></td><td></td></tr>
		<tr><td class="bold indent-2"><strong>ASET LANCAR</strong></td><td></td></tr>
		<?php
		$saldo_aset_lancar = 0;
		foreach( $data as $d ):
			if ( 'ASET LANCAR' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$saldo_aset_lancar += $saldo;
		?>
			<tr><td class="indent-3"><?php echo $d['nama']; ?></td><td><?php echo number_format( $saldo ); ?></td></tr>
		<?php endforeach; ?>
		<tr><td class="bold indent-2"><strong>Jumlah Aset Lancar</strong></td><td class="bold border-top"><?php echo number_format( $saldo_aset_lancar ); ?></td></tr>

		<tr><td class="bold indent-2"><strong>ASET TIDAK LANCAR</strong></td><td></td></tr>
		<?php
		$saldo_aset_no_lancar = 0;
		foreach( $data as $d ):
			if ( 'ASET TIDAK LANCAR' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$saldo_aset_no_lancar += $saldo;
		?>
			<tr><td class="indent-3"><?php echo $d['nama']; ?></td><td><?php echo number_format( $saldo ); ?></td></tr>
		<?php endforeach; ?>
		<tr><td class="bold indent-2"><strong>Jumlah Aset Tidak Lancar</strong></td><td class="bold border-top"><?php echo number_format( $saldo_aset_no_lancar ); ?></td></tr>
		<tr><td class="bold"><strong>JUMLAH ASET</strong></td><td class="bold border-top"><?php echo number_format( $saldo_aset_lancar + $saldo_aset_no_lancar ); ?></td></tr>

		<tr><td class="bold"><strong>KEWAJIBAN DAN EKUITAS</strong></td><td></td></tr>
		<tr><td class="bold indent-1"><strong>KEWAJIBAN</strong></td><td></td></tr>
		<?php
		$saldo_kewajiban = 0;
		foreach( $data as $d ):
			if ( 'KEWAJIBAN' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$saldo_kewajiban += $saldo;
		?>
			<tr><td class="indent-2"><?php echo $d['nama']; ?></td><td><?php echo number_format( $saldo ); ?></td></tr>
		<?php endforeach; ?>
		<tr><td class="bold indent-1"><strong>Jumlah Kewajiban</strong></td><td><?php echo number_format( $saldo_kewajiban ); ?></td></tr>

		<tr><td class="bold indent-1"><strong>EKUITAS</strong></td><td></td></tr>
		<?php
		$saldo_ekuitas = 0;
		foreach( $data as $d ):
			if ( 'KEWAJIBAN' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$saldo_ekuitas += $saldo;
		?>
			<tr><td class="indent-2"><?php echo $d['nama']; ?></td><td><?php echo number_format( $saldo ); ?></td></tr>
		<?php endforeach; ?>
		<tr><td class="bold indent-1"><strong>Jumlah Ekuitas</strong></td><td><?php echo number_format( $saldo_ekuitas ); ?></td></tr>

		<tr><td class="bold"><strong>JUMLAH KEWAJIBAN DAN EKUITAS</strong></td><td class="bold border-top"><?php echo number_format( $saldo_kewajiban + $saldo_ekuitas ); ?></td></tr>
		
	</tbody>
</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>