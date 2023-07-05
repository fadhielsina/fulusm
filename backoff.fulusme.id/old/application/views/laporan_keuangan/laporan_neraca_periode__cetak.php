<?php
    $this->load->view('template/header_head_cetak');
    $saldo_aset_lancar = array();
    $saldo_aset_no_lancar = array();
    $saldo_kewajiban = array();
    $saldo_ekuitas = array();

    foreach( $date_periodes as $dp ) {
		$saldo_aset_lancar[$dp] = 0;
	    $saldo_aset_no_lancar[$dp] = 0;
	    $saldo_kewajiban[$dp] = 0;
	    $saldo_ekuitas[$dp] = 0;
	}
?>

<div class="row">
	<div class="col-12">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Neraca (Multi Periode)</h3>
			<p style="text-align: center;margin-top: 5px;"><?php echo sprintf( 'Dari periode %s s/d %s', $periode_awal, $periode_akhir ); ?></p>
		</div>
	</div>
</div>

<table class="table-report-paper">
	<thead>
		<tr>
			<th class="th-head text-left">Deskripsi</th>
			<?php foreach( $date_periodes as $dp ): ?>
			<th class="th-head text-right"><?php echo date( $format_date_label, strtotime($dp) ); ?></th>
			<?php endforeach;?>
		</tr>
	</thead>

	<tbody>
		<tr><td class="bold"><strong>ASET</strong></td><td></td></tr>
		<tr><td class="bold indent-2"><strong>ASET LANCAR</strong></td><td></td></tr>
		<?php
		foreach( $data as $d ):
			if ( 'ASET LANCAR' !== $d['grouping'] ) continue;
		?>
			<tr><td class="indent-3"><?php echo $d['nama']; ?></td>
				<?php foreach( $date_periodes as $dp ) {
					if ( date( $format_date ) !== date( $format_date, strtotime($dp) ) ) {
						$saldo = ( $d['debit_'.$dp] - $d['kredit_'.$dp] );
					} else {
						$saldo = ( $d['debit_'.$dp] - $d['kredit_'.$dp] );
					}
					
					$saldo_aset_lancar[ $dp ] += $saldo;
					if ( $saldo > 0 ) {
						echo sprintf( '<td class="text-right"><a href="%s">%s</a></td>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo ) );
					} else {
						echo sprintf( '<td class="text-right">%s</td>', to_abs_nom( $saldo ) );
					}
				} ?>
			</tr>
		<?php endforeach; ?>
		<tr><td class="bold indent-2"><strong>Jumlah Aset Lancar</strong></td>
			<?php foreach( $date_periodes as $dp ) {
				echo sprintf( '<td class="bold border-top text-right">%s</td>', to_abs_nom( $saldo_aset_lancar[ $dp ] ) );
			} ?>
		</tr>

		<tr><td class="bold indent-2"><strong>ASET TIDAK LANCAR</strong></td><td></td></tr>
		<?php
		foreach( $data as $d ):
			if ( 'ASET TIDAK LANCAR' !== $d['grouping'] ) continue;
		?>
			<tr><td class="indent-3"><?php echo $d['nama']; ?></td>
				<?php foreach( $date_periodes as $dp ) {
					if ( date( $format_date ) !== date( $format_date, strtotime($dp) ) ) {
						$saldo = ( $d['debit_'.$dp] - $d['kredit_'.$dp] );
					} else {
						$saldo = ( $d['debit_'.$dp] - $d['kredit_'.$dp] );
					}
					$saldo_aset_no_lancar[ $dp ] += $saldo;
					if ( $saldo > 0 ) {
						echo sprintf( '<td class="text-right"><a href="%s">%s</a></td>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo ) );
					} else {
						echo sprintf( '<td class="text-right">%s</td>', to_abs_nom( $saldo ) );
					}
				} ?>
			</tr>
		<?php endforeach; ?>
		<tr><td class="bold indent-2"><strong>Jumlah Aset Tidak Lancar</strong></td>
			<?php foreach( $date_periodes as $dp ) {
				echo sprintf( '<td class="bold border-top text-right">%s</td>', to_abs_nom( $saldo_aset_no_lancar[ $dp ] ) );
			} ?>
		</tr>
		<tr><td class="bold"><strong>JUMLAH ASET</strong></td>
			<?php foreach( $date_periodes as $dp ) {
				echo sprintf( '<td class="bold border-top text-right">%s</td>', to_abs_nom( $saldo_aset_lancar[ $dp ] + $saldo_aset_no_lancar[ $dp ] ) );
			} ?>
		</tr>

		<tr><td class="bold"><strong>KEWAJIBAN DAN EKUITAS</strong></td><td></td></tr>
		<tr><td class="bold indent-1"><strong>KEWAJIBAN</strong></td><td></td></tr>
		<?php
		foreach( $data as $d ):
			if ( 'KEWAJIBAN' !== $d['grouping'] ) continue;
		?>
			<tr><td class="indent-2"><?php echo $d['nama']; ?></td>
				<?php foreach( $date_periodes as $dp ) {
					if ( date( $format_date ) !== date( $format_date, strtotime($dp) ) ) {
						$saldo = ( $d['kredit_'.$dp] - $d['debit_'.$dp] );
					} else {
						$saldo = $d['saldo_awal'] + ( $d['kredit_'.$dp] - $d['debit_'.$dp] );
					}
					$saldo_kewajiban[ $dp ] += $saldo;
					if ( $saldo > 0 ) {
						echo sprintf( '<td class="text-right"><a href="%s">%s</a></td>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo ) );
					} else {
						echo sprintf( '<td class="text-right">%s</td>', to_abs_nom( $saldo ) );
					}
				} ?>
			</tr>
		<?php endforeach; ?>
		<tr><td class="bold indent-1"><strong>Jumlah Kewajiban</strong></td>
			<?php foreach( $date_periodes as $dp ) {
				echo sprintf( '<td class="bold border-top text-right">%s</td>', to_abs_nom( $saldo_kewajiban[$dp] ) );
			} ?>
		</tr>

		<tr><td class="bold indent-1"><strong>EKUITAS</strong></td><td></td></tr>
		<?php
		foreach( $data as $d ):
			if ( 'EKUITAS' !== $d['grouping'] ) continue;
		?>
			<tr><td class="indent-2"><?php echo $d['nama']; ?></td>
				<?php foreach( $date_periodes as $dp ) {
					$saldo = ( $d['kredit_'.$dp] - $d['debit_'.$dp] );
					$saldo_ekuitas[ $dp ] += $saldo;
					if ( $saldo > 0 ) {
						echo sprintf( '<td class="text-right"><a href="%s">%s</a></td>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo ) );
					} else {
						echo sprintf( '<td class="text-right">%s</td>', to_abs_nom( $saldo ) );
					}
				} ?>
			</tr>
		<?php endforeach; ?>
		
		<tr><td class="indent-2">Laba Tahun ini</td>
			<?php foreach( $date_periodes as $dp ) {
					$saldo_laba = 0;
					if ( date( $format_date ) !== date( $format_date, strtotime($dp) ) ) {
						$saldo = 0;
					} else {
						foreach( $data as $d ):
							if ( 'LABA' !== $d['grouping'] ) continue;
							$saldo = ( $d['kredit_'. $dp] - $d['debit_'. $dp] );
							$saldo_laba += $saldo;
						endforeach;
						$saldo_ekuitas[ $dp ] += $saldo_laba;
					}
					echo sprintf( '<td class="text-right">%s</td>', to_abs_nom( $saldo_laba ) );
				} ?>
		</tr>

		<tr><td class="bold indent-1"><strong>Jumlah Ekuitas</strong></td>
			<?php foreach( $date_periodes as $dp ) {
				echo sprintf( '<td class="bold border-top text-right">%s</td>', to_abs_nom( $saldo_ekuitas[$dp] ) );
			} ?>
		</tr>

		<tr><td class="bold"><strong>JUMLAH KEWAJIBAN DAN EKUITAS</strong></td>
			<?php foreach( $date_periodes as $dp ) {
				echo sprintf( '<td class="border-top bold text-right">%s</td>', to_abs_nom( $saldo_kewajiban[$dp] + $saldo_ekuitas[$dp] ) );
			} ?>
		</tr>
		
	</tbody>
</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>