<?php
    $this->load->view('template/header_head_cetak');
    $start_periode = $start_tahun;
    $end_periode = $end_tahun;
    $total_pendapatan = array();
    $total_hpp = array();
    $total_operasional = array();
    $total_nonoperasional = array();

    foreach( $date_periodes as $dp ) {
		$total_pendapatan[$dp] = 0;
		$total_hpp[$dp] = 0;
		$total_operasional[$dp] = 0;
		$total_nonoperasional[$dp] = 0;
	}
?>

<div class="row">
	<div class="col-12">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Laba/Rugi (Multi Periode)</h3>
			<p style="text-align: center;margin-top: 5px;"><?php echo sprintf( 'Dari periode %s s/d %s', $start_periode, $end_periode ); ?></p>
		</div>
	</div>
</div>

<table class="table-report-paper">
	<thead>
		<tr><th class="th-head text-left">Deskripsi</th>
			<?php foreach( $date_periodes as $dp ): ?>
			<th class="th-head text-right"><?php echo date('Y', strtotime($dp) ); ?></th>
			<?php endforeach;?>
		</tr>
	</thead>

	<tbody>
		<tr><td class="bold">PENDAPATAN</td><td></td></tr>
		<?php 
		foreach( $data as $d ):
			if ( 'Pendapatan' !== $d['grouping'] ) continue;
		 ?>
		<tr>
			<td class="indent-1"><?php echo $d['nama']; ?></td>
			<?php
			foreach( $date_periodes as $dp ) {
				$saldo = $d['kredit_' . $dp] - $d['debit_' . $dp];
				$total_pendapatan[ $dp ] += $saldo;
				echo '<td class="text-right">'. to_abs_nom( $saldo ) .'</td>';
			}
			?>
		</tr>
		<?php endforeach; ?>

		<tr><td class="bold">Jumlah Pendapatan</td>
			<?php
			foreach( $date_periodes as $dp ) {
				echo '<td class="bold border-top text-right">'. to_abs_nom( $total_pendapatan[$dp] ) .'</td>';
			} ?>
		</tr>

		<tr><td class="bold">BEBAN POKOK PENJUALAN</td><td></td></tr>
		<?php 
		foreach( $data as $d ):
			if ( 'HPP' !== $d['grouping'] ) continue;
		 ?>
		<tr>
			<td class="indent-1"><?php echo $d['nama']; ?></td>
			<?php
			foreach( $date_periodes as $dp ) {
				$saldo = $d['debit_' . $dp] - $d['kredit_' . $dp];
				$total_hpp[ $dp ] += $saldo;
				echo '<td class="text-right">'. to_abs_nom( $saldo ) .'</td>';
			}
			?>
		</tr>
		<?php endforeach; ?>

		<tr><td class="bold">Jumlah Beban Pokok Penjualan</td>
			<?php
			foreach( $date_periodes as $dp ) {
				echo '<td class="bold border-top text-right">'. to_abs_nom( $total_hpp[$dp] ) .'</td>';
			} ?>
		</tr>

		<tr><td class="bold">LABA KOTOR</td>
			<?php
			foreach( $date_periodes as $dp ) {
				echo '<td class="bold border-top text-right">'. to_abs_nom( $total_pendapatan[$dp] - $total_hpp[$dp] ) .'</td>';
			} ?>
		</tr>

		
		<tr><td class="bold">BEBAN OPERASIONAL</td><td></td></tr>
		<?php 
		foreach( $data as $d ):
			if ( 'Beban Operasional' !== $d['grouping'] ) continue;
		 ?>
		<tr>
			<td class="indent-1"><?php echo $d['nama']; ?></td>
			<?php
			foreach( $date_periodes as $dp ) {
				$saldo = $d['debit_' . $dp] - $d['kredit_' . $dp];
				$total_operasional[ $dp ] += $saldo;
				echo '<td class="text-right">'. to_abs_nom( $saldo ) .'</td>';
			}
			?>
		</tr>
		<?php endforeach; ?>
		<tr><td class="bold">Jumlah Beban Operasional</td>
			<?php
			foreach( $date_periodes as $dp ) {
				echo '<td class="bold border-top text-right">'. to_abs_nom( $total_operasional[$dp] ) .'</td>';
			}
			?>
		</tr>

		<tr><td class="bold">PENDAPATAN OPERASIONAL</td>
			<?php
			foreach( $date_periodes as $dp ) {
				$total_pendapatan_operasi = 0;
				$total_pendapatan_operasi = $total_pendapatan[$dp] - $total_hpp[$dp] - $total_operasional[$dp];
				echo '<td class="bold border-top text-right">'. to_abs_nom( $total_pendapatan_operasi ) .'</td>';
			}
			?>
		</tr>


		<tr><td class="bold">BEBAN NON OPERASIONAL</td><td></td></tr>
		<?php 
		foreach( $data as $d ):
			if ( 'Beban Non Operasional' !== $d['grouping'] ) continue;
		 ?>
		<tr>
			<td class="indent-1"><?php echo $d['nama']; ?></td>
			<?php
			foreach( $date_periodes as $dp ) {
				$saldo = $d['debit_' . $dp] - $d['kredit_' . $dp];
				$total_nonoperasional[ $dp ] += $saldo;
				echo '<td class="text-right">'. to_abs_nom( $saldo ) .'</td>';
			}
			?>
		</tr>
		<?php endforeach; ?>

		<tr><td class="bold">Jumlah Beban Non Operasional</td>
			<?php
			foreach( $date_periodes as $dp ) {
				if ( isset( $total_nonoperasional[$dp] ) ) {
					echo '<td class="bold border-top text-right">'. to_abs_nom( $total_nonoperasional[$dp] ) .'</td>';
				} else {
					echo '<td class="bold border-top text-right">0</td>';
				}
			}
			?>
		</tr>

		<tr><td class="bold">LABA BERSIH</td>
			<?php
			foreach( $date_periodes as $dp ) {
				$tot_laba_bersih = 0;
				$tot_laba_bersih = $total_pendapatan[$dp] - $total_hpp[$dp] - $total_operasional[$dp] - $total_nonoperasional[$dp];
				echo '<td class="bold border-top text-right">'. to_abs_nom( $tot_laba_bersih ) .'</td>';
			}
			?>
		</tr>

		
	</tbody>
</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>