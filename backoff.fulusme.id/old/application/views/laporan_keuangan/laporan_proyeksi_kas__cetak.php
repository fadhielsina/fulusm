<?php
    $this->load->view('template/header_head_cetak');

    $saldo_kas = array();
    $saldo_piutang = array();
    $saldo_hutang = array();
    foreach( $date_periodes as $dp ){
		$saldo_kas[ $dp ] = 0;
		$saldo_piutang[ $dp ] = 0;
		$saldo_hutang[ $dp ] = 0;
	}

    foreach( $data as $d ) {
    	foreach( $date_periodes as $dp ){
    		
    		if ( 'SALDO KAS' === $d['grouping'] ) {
    			$saldo = $d['debit_' . $dp] - $d['kredit_' . $dp];
    			$saldo_kas[ $dp ] += $saldo;
    		}

    		if ( 'PIUTANG' === $d['grouping'] ) {
    			$saldo = $d['debit_' . $dp];
    			$saldo_piutang[ $dp ] += $saldo;
    		}

    		if ( 'HUTANG' === $d['grouping'] ) {
    			$saldo = $d['kredit_' . $dp];
    			$saldo_hutang[ $dp ] += $saldo;
    		}
    	}
    }
?>

<div class="row">
	<div class="col-12">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Proyeksi Kas Per Bulan</h3>
		</div>
	</div>
</div>

<table class="table-report-paper">
	<thead>
		<tr><th class="th-head text-left">Keterangan</th>
			<?php foreach( $date_periodes as $dp ): ?>
			<th class="th-head text-right"><?php echo date('F Y', strtotime($dp) ); ?></th>
			<?php endforeach;?>
		</tr>
	</thead>

	<tbody>
		<tr><td class="bold"><strong><?php echo sprintf('Saldo Kas per %s', date('d F Y') ); ?></strong></td>
			<?php foreach( $date_periodes as $dp ): ?>
			<td class="text-right"><?php echo number_format( $saldo_kas[ $dp ] ); ?></td>
			<?php endforeach;?>
		</tr>

		<tr><td class="bold"><strong>Sumber Pendapatan</strong></td>
			<?php foreach( $date_periodes as $dp ): ?>
			<td class="text-right"></td>
			<?php endforeach;?>
		</tr>

		<tr><td class="indent-1">Piutang Jatuh Tempo</td>
			<?php foreach( $date_periodes as $dp ): ?>
			<td class="text-right"><?php echo number_format( $saldo_piutang[$dp] ); ?></td>
			<?php endforeach;?>
		</tr>

		<tr><td class="bold"><strong>Total Sumber Pendapatan</strong></td>
			<?php foreach( $date_periodes as $dp ): ?>
			<td class="text-right bold border-top"><?php echo number_format( $saldo_piutang[$dp] ); ?></td>
			<?php endforeach;?>
		</tr>

		<tr><td class="bold"><strong>Penggunaan Kas</strong></td>
			<?php foreach( $date_periodes as $dp ): ?>
			<td class="text-right"></td>
			<?php endforeach;?>
		</tr>

		<tr><td class="indent-1">Hutang Jatuh Tempo</td>
			<?php foreach( $date_periodes as $dp ): ?>
			<td class="text-right"><?php echo number_format( $saldo_hutang[$dp] ); ?></td>
			<?php endforeach;?>
		</tr>

		<tr><td class="bold"><strong>Total Penggunaan Kas</strong></td>
			<?php foreach( $date_periodes as $dp ): ?>
			<td class="text-right border-top bold"><?php echo number_format( $saldo_hutang[$dp]); ?></td>
			<?php endforeach;?>
		</tr>

		<tr><td class="bold"><strong>Perkiraan Lebih/Kurang Kas</strong></td>
			<?php foreach( $date_periodes as $dp ): ?>
			<td class="text-right border-top bold"><?php echo number_format( $saldo_kas[$dp] + $saldo_piutang[$dp] - $saldo_hutang[$dp] ); ?></td>
			<?php endforeach;?>
		</tr>
	</tbody>
</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>