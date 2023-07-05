<?php
    $this->load->view('template/header_head_cetak');
    $column_text = sprintf( '%s - %s', $tanggal1, $tanggal2 );

    $saldo_ekuitas = 0;
	foreach( $data as $d ) {
		if ( 'EKUITAS' !== $d['grouping'] ) continue;
		$saldo = ( $d['kredit'] - $d['debit'] );
		$saldo_ekuitas += $saldo;
	}

	$saldo_kewajiban = 0;
	foreach( $data as $d ) {
		if ( 'KEWAJIBAN' !== $d['grouping'] ) continue;
		$saldo = ( $d['kredit'] - $d['debit'] );
		$saldo_kewajiban += $saldo;
	}

    $saldo_laba = 0;
	foreach( $data as $d ) {
		if ( 'LABA' !== $d['grouping'] ) continue;
		$saldo = ( $d['kredit'] - $d['debit'] );
		$saldo_laba += $saldo;
	}

	$total_penambahan_ekuitas = $saldo_laba - $saldo_kewajiban;
	$total_akhir_periode = $saldo_ekuitas + $total_penambahan_ekuitas; 
?>

<div class="row">
	<div class="col-12">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Perubahan Ekuitas Pemilik</h3>
			<p style="text-align: center;margin-top: 5px;"><?php echo 'Dari ' . $column_text; ?></p>
		</div>
	</div>
</div>

<table class="table-report-paper">
	<thead>
		<tr><th class="th-head text-left">Deskripsi</th><th class="th-head text-right"><?php echo $column_text; ?></th></tr>
	</thead>

	<tbody>
		<tr><td class="bold">Ekuitas Pemilik Awal Periode</td><td class="text-right"><?php echo number_format( $saldo_ekuitas ); ?></td></tr>
		<tr><td class="bold">Penambahan Ekuitas Pemilik</td><td class="text-right"></td></tr>
		<tr><td class="indent-1">Pendapatan Bersih</td><td class="text-right"><?php echo number_format( $saldo_laba ); ?></td></tr>
		<tr><td class="indent-1">Penarikan</td><td class="text-right"><?php echo number_format( $saldo_kewajiban ); ?></td></tr>
		<tr><td class="bold">Total Penambahan Ekuitas Pemilik</td><td class="text-right border-top"><?php echo number_format( $total_penambahan_ekuitas ); ?></td></tr>
		<tr><td class="bold">Ekuitas Pemilik Akhir Periode</td><td class="text-right"><?php echo number_format( $total_akhir_periode ); ?></td></tr>
	</tbody>
</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>