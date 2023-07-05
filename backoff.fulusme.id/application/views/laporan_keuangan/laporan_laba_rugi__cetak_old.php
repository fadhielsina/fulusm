<?php
    $this->load->view('template/header_head_cetak');
    $column_text = sprintf( '%s - %s', $tanggal1, $tanggal2 );
?>

<div class="row">
	<div class="col-12">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Laba/Rugi (Standar)</h3>
			<p style="text-align: center;margin-top: 5px;"><?php echo 'Dari ' . $column_text; ?></p>
		</div>
	</div>
</div>

<table class="table-report-paper">
	<thead>
		<tr><th class="th-head text-left">COA</th><th class="th-head text-left">Deskripsi</th><th class="th-head text-right"><?php echo $column_text; ?></th></tr>
	</thead>

	<tbody>
		<?php 
		$total_pendapatan = 0;
		foreach( $data as $d ):
			if ( 'Pendapatan' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$total_pendapatan += $saldo;
		 ?>
		<tr>
			<td><?php echo $d['kode']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>

		<tr><td class="border-top">4100000</td><td class="bold border-top">Total Penjualan External</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pendapatan ); ?></td></tr>
		<tr class="spacer"><td colspan="3"></td></tr>

		<?php
		$total_pendapatan_in = 0; 
		foreach( $data as $d ):
			if ( 'Pendapatan_IN' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$total_pendapatan_in += $saldo;
		 ?>
		<tr>
			<td><?php echo $d['kode']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>

		<tr><td class="border-top">4200000</td><td class="bold border-top">Total Penjualan Internal</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pendapatan_in ); ?></td></tr>
		<tr><td class="border-top">4000000</td><td class="bold border-top">PENJUALAN NETTO</td><td class="border-top text-right"><?php echo number_format( $total_pendapatan + $total_pendapatan_in ); ?></td></tr>
		<tr class="spacer"><td colspan="3"></td></tr>

		<tr>
			<td>1141001</td>
			<td>Stok Awal Bahan Baku</td>
			<td class="text-right">0</td>
		</tr>
		<?php
		$total_pemakaian_bb = 0; 
		foreach( $data as $d ):
			if ( 'PEMAKAIAN_BB' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$total_pemakaian_bb += $saldo;
		 ?>
		<tr>
			<td><?php echo $d['kode']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td>1141001</td>
			<td>Stok Akhir Bahan Baku</td>
			<td class="text-right">0</td>
		</tr>
		<tr><td class="border-top">5100000</td><td class="bold border-top">Pemakaian Bahan Baku</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pemakaian_bb ); ?></td></tr>
		<tr class="spacer"><td colspan="3"></td></tr>

		<tr>
			<td>5210000</td>
			<td>Stok Awal Bahan Pembungkus</td>
			<td class="text-right">0</td>
		</tr>
		<?php
		$total_pemakaian_bp = 0; 
		foreach( $data as $d ):
			if ( 'PEMAKAIAN_BP' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$total_pemakaian_bp += $saldo;
		 ?>
		<tr>
			<td><?php echo $d['kode']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td>5210000</td>
			<td>Stok Akhir Bahan Pembungkus</td>
			<td class="text-right">0</td>
		</tr>

		<tr><td class="border-top">5200000</td><td class="bold border-top">Pemakaian Bahan Pembungkus</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pemakaian_bp ); ?></td></tr>
		<tr class="spacer"><td colspan="3"></td></tr>
		
		<?php
		$total_pemakaian_bbb = 0; 
		foreach( $data as $d ):
			if ( 'PEMAKAIAN_BBB' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$total_pemakaian_bbb += $saldo;
		 ?>
		<tr>
			<td><?php echo $d['kode']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>

		<tr><td class="border-top"></td><td class="bold border-top">Pemakaian Bahan Bahan Bakar</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pemakaian_bbb ); ?></td></tr>

		<?php
		$total_biaya_produksi = 0; 
		foreach( $data as $d ):
			if ( 'BIAYA_PRODUKSI' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$total_biaya_produksi += $saldo;
		 ?>
		<tr>
			<td><?php echo $d['kode']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>

		<tr><td class="border-top"></td><td class="bold border-top">Biaya Produksi</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_biaya_produksi + $total_pemakaian_bb + $total_pemakaian_bp + $total_pemakaian_bbb ); ?></td></tr>

		<?php
		$sum_biaya_produksi = $total_biaya_produksi + $total_pemakaian_bb + $total_pemakaian_bp + $total_pemakaian_bbb;
		$total_hpp = 0; 
		foreach( $data as $d ):
			if ( 'BIAYA_HPP' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$total_hpp += $saldo;
		 ?>
		<tr>
			<td><?php echo $d['kode']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>

		<tr><td class="border-top"></td><td class="bold border-top">Harga Pokok Produksi</td><td class="bold border-top text-right"><?php echo to_abs_nom( $sum_biaya_produksi - $total_hpp ); ?></td></tr>

		<?php
		$total_beban_pokok = 0; 
		foreach( $data as $d ):
			if ( 'BEBAN_POKOK_PJ' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$total_beban_pokok += $saldo;
		 ?>
		<tr>
			<td><?php echo $d['kode']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>

		<tr><td class="border-top"></td><td class="bold border-top">BEBAN POKOK PENJUALAN</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_beban_pokok ); ?></td></tr>

		<tr><td class="border-top"></td><td class="bold border-top">LABA KOTOR</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pendapatan_in ); ?></td></tr>

		<?php
		$total_biaya_usaha = 0; 
		foreach( $data as $d ):
			if ( 'BIAYA_USAHA' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$total_biaya_usaha += $saldo;
		 ?>
		<tr>
			<td><?php echo $d['kode']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>

		<tr><td class="border-top"></td><td class="bold border-top">BIAYA USAHA</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_biaya_usaha ); ?></td></tr>

		<tr><td class="border-top"></td><td class="bold border-top">LABA USAHA</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_biaya_usaha ); ?></td></tr>

		<?php
		$total_pendapatan_dll = 0; 
		foreach( $data as $d ):
			if ( 'PENDAPATAN_DLL' !== $d['grouping'] ) continue;
			$saldo = $d['kredit'] - $d['debit'];
			$total_pendapatan_dll += $saldo;
		 ?>
		<tr>
			<td><?php echo $d['kode']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
		</tr>
		<?php endforeach; ?>

		<tr><td class="border-top"></td><td class="bold border-top">PENDAPATAN (BEBAN) LAIN-LAIN & KEU.- NETO</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pendapatan_dll ); ?></td></tr>

		<tr><td class="border-top"></td><td class="bold border-top">LABA SEBELUM PAJAK PENGHASILAN</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pendapatan_dll ); ?></td></tr>

		<tr><td class="border-top"></td><td class="bold border-top">MANFAAT (BEBAN)  PAJAK PENGHASILAN</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pendapatan_dll ); ?></td></tr>

		<tr><td class="border-top"></td><td class="bold border-top">LABA BERSIH TAHUN BERJALAN</td><td class="bold border-top text-right"><?php echo to_abs_nom( $total_pendapatan_dll ); ?></td></tr>

		
	</tbody>
</table>

<?php  $this->load->view("template/footer_admin_cetak"); ?>