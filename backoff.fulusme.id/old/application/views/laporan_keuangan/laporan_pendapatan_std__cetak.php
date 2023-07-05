<?php
    $this->load->view('template/header_head_cetak');
    $column_text = sprintf( '%s - %s', $tanggal1, $tanggal2 );
    $cabang_label = isset( $data[0] ) ? $data[0]['identityName'] : '';
?>

<div class="row">
	<div class="col-12">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Laporan Pendapatan</h3>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;"><?php echo $cabang_label; ?></h3>
			<p style="text-align: center;margin-top: 5px;"><?php echo 'Dari ' . $column_text; ?></p>
		</div>
	</div>
</div>

<table class="table-report-paper">
	<thead>
		<tr>
			<th class="th-head text-left">No</th>
			<th class="th-head text-left">Invoice</th>
			<th class="th-head text-left">Tanggal</th>
			<th class="th-head text-left">Pelanggan</th>
			<th class="th-head text-left">Total</th>
		</tr>
	</thead>

	<tbody>

		<?php 
		$total = 0;
		foreach( $data as $no => $d ):
			$total += $d['trxTotal'];
		 ?>
			<tr>
				<td><?php echo $no+1; ?></td>
				<td><?php echo $d['invoiceID']; ?></td>
				<td><?php echo date('d F Y', strtotime( $d['trxInDate'] ) ); ?></td>
				<td><?php echo $d['memberFullName']; ?></td>
				<td><?php echo number_format( $d['trxTotal'] ); ?></td>
			</tr>
		<?php endforeach; ?>
		
	</tbody>

	<tfoot>
		<tr><td colspan="3"></td><td class="bold border-top">TOTAL</td><td class="bold border-top"><?php echo number_format( $total ); ?></td></tr>
	</tfoot>
</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>