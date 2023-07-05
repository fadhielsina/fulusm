<?php
    $this->load->view('template/header_head_cetak');
    $column_text = sprintf( '%s - %s', $tanggal1, $tanggal2 );
?>

<div class="row">
	<div class="col-12">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Laporan Laba Rugi</h3>
			<p style="text-align: center;margin-top: 5px;"><?php echo 'Periode ' . $column_text; ?></p>
		</div>
	</div>
</div>

<table class="table-report-paper">
	<thead>
		<tr><th class="th-head text-left">Deskripsi</th><th class="th-head text-right"><?php echo $column_text; ?></th></tr>
	</thead>

	<tbody>
		<tr><td class="bold">PENDAPATAN</td><td></td></tr>
		<?php 
		$total_pendapatan = 0;
		foreach( $data as $d ):
			if ( 'Pendapatan' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$total_pendapatan += $saldo;
		 ?>
		<tr>
			<td class="indent-1"><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>

		<tr><td class="bold">Jumlah Pendapatan</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pendapatan ); ?></td></tr>

		<tr><td class="bold">BEBAN POKOK PENJUALAN</td><td></td></tr>
		<?php 
		$total_hpp = 0;
		foreach( $data as $d ):
			if ( 'HPP' !== $d['grouping'] ) continue;
			$saldo = $d['debit'] - $d['kredit'];
			$total_hpp += $saldo;
		 ?>
		<tr>
			<td class="indent-1"><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>

		<tr><td class="bold">Jumlah Beban Pokok Penjualan</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_hpp ); ?></td></tr>

		<tr><td class="bold">LABA KOTOR</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pendapatan - $total_hpp ); ?></td></tr>

		
		<tr><td class="bold">BEBAN OPERASIONAL</td><td></td></tr>
		<?php 
		$total_operasional = 0;
		foreach( $data as $d ):
			if ( 'Beban Operasional' !== $d['grouping'] ) continue;
			$saldo = $d['debit'] - $d['kredit'];
			$total_operasional += $saldo;
		 ?>
		<tr>
			<td class="indent-1"><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>
		<tr><td class="bold">Jumlah Beban Operasional</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_operasional ); ?></td></tr>

		<tr><td class="bold">PENDAPATAN OPERASIONAL</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pendapatan - $total_hpp - $total_operasional ); ?></td></tr>


		<tr><td class="bold">BEBAN NON OPERASIONAL</td><td></td></tr>
		<?php 
		$total_nonoperasional = 0;
		foreach( $data as $d ):
			if ( 'Beban Non Operasional' !== $d['grouping'] ) continue;
			$saldo = $d['debit'] - $d['kredit'];
			$total_nonoperasional += $saldo;
		 ?>
		<tr>
			<td class="indent-1"><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom($saldo); ?></td>
		</tr>
		<?php endforeach; ?>

		<tr><td class="bold">Jumlah Beban Non Operasional</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_nonoperasional ); ?></td></tr>

		<tr><td class="bold">LABA BERSIH</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pendapatan - $total_hpp - $total_operasional - $total_nonoperasional ); ?></td></tr>

		
	</tbody>
</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>