<?php
    $this->load->view('template/header_head_cetak');
    $column_text = $tanggal1;
    $dateTime = new DateTime($tanggal1);
    $lastMonth = $dateTime->modify('-' . $dateTime->format('d') . ' days')->format('d F Y');
    
    $saldo_aset_lancar = array(
    	'last' => 0,
    	'now' => 0
    );
    $saldo_aset_no_lancar = array(
    	'last' => 0,
    	'now' => 0
    );
    $saldo_lia_pendek = array(
    	'last' => 0,
    	'now' => 0
    );
    $saldo_lia_panjang = array(
    	'last' => 0,
    	'now' => 0
    );
    $saldo_ekuitas = array(
    	'last' => 0,
    	'now' => 0
    );
    $saldo_nonpengendali = array(
    	'last' => 0,
    	'now' => 0
    );
    $saldo_laba = array(
    	'last' => 0,
    	'now' => 0
    );
?>

<div class="row">
	<div class="col-12">
		<div>
			<h3 style="margin-bottom: 5px;margin-top: 0;">CV AMOR</h3>
			<h3 style="margin-bottom: 5px;margin-top: 0;">Laporan Posisi Keuangan</h3>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-6">
		<table class="table-report-paper table-nom-parent">
			<thead>
				<tr>
					<th class="th-head text-left">COA</th>
					<th class="th-head text-left">DESKRIPSI</th>
					<th class="th-head text-right text-uppercase"><?php echo $lastMonth; ?></th>
					<th class="th-head text-right text-uppercase"><?php echo date('d F Y', strtotime( $tanggal1 ) ); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php
				$nom_break = 0;
				$nom_break_last = 0;
				foreach( $data as $d ):
					if ( 'ASET LANCAR' !== $d['grouping'] ) continue;
					$saldo = ( $d['debit'] - $d['kredit'] );
					$saldo_last = ( $d['last_debit'] - $d['last_kredit'] );
					$saldo_aset_lancar['now'] += $saldo;
					$saldo_aset_lancar['last'] += $saldo_last;
				?>
					
					<?php if( true ): ?>
					<tr class="d-none nominal-data no-print" data-nominal-now="<?php echo $nom_break; ?>" data-nominal-last="<?php echo $nom_break_last; ?>"><td colspan="4"></td></tr>
					<?php
						$nom_break = 0;
						$nom_break_last = 0;
					?>
					<tr data-id="<?php echo $d['id']; ?>" data-parent="<?php echo $d['parent_akun'];?>" data-level="<?php echo $d['level']; ?>">
						<td data-column="name"><?php echo $d['kode']; ?></td>
						<td data-column="coa" class="indent-<?php echo $d['level']; ?>"><?php echo $d['nama']; ?></td>
						<td class="text-right saldo-last"><?php echo sprintf('<a href="%s">%s</a>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo_last )); ?></td>
						<td class="text-right saldo-now"><?php echo sprintf('<a href="%s">%s</a>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo )); ?></td>
					</tr>
					<?php else: 
						$nom_break += $saldo;
						$nom_break_last += $saldo_last; 
					endif; ?>
				<?php endforeach; ?>
				<tr><td class="border-top"></td><td class="bold border-top"><strong>Jumlah Aset Lancar</strong></td><td class="bold border-top text-right"><?php echo to_abs_nom( $saldo_aset_lancar['last'] ); ?></td><td class="bold border-top text-right"><?php echo to_abs_nom( $saldo_aset_lancar['now'] ); ?></td></tr>
				
				<?php
				$nom_break = 0;
				$nom_break_last = 0;
				foreach( $data as $d ):
					if ( 'ASET TIDAK LANCAR' !== $d['grouping'] ) continue;
					$saldo = ( $d['debit'] - $d['kredit'] );
					$saldo_last = ( $d['last_debit'] - $d['last_kredit'] );
					$saldo_aset_no_lancar['now'] += $saldo;
					$saldo_aset_no_lancar['last'] += $saldo_last;

					if( $d['level'] < 5 ):
				?>
					<tr class="d-none nominal-data no-print" data-nominal-now="<?php echo $nom_break; ?>" data-nominal-last="<?php echo $nom_break_last; ?>"><td colspan="4"></td></tr>
					<?php
						$nom_break = 0;
						$nom_break_last = 0;
					?>
					<tr data-id="<?php echo $d['id']; ?>" data-parent="<?php echo $d['parent_akun'];?>" data-level="<?php echo $d['level']; ?>">
						<td data-column="name"><?php echo $d['kode']; ?></td>
						<td data-column="coa" class="indent-<?php echo $d['level']; ?>"><?php echo $d['nama']; ?></td>
						<td class="text-right saldo-last"><?php echo sprintf('<a href="%s">%s</a>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo_last )); ?></td>
						<td class="text-right saldo-now"><?php echo sprintf('<a href="%s">%s</a>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo )); ?></td>
					</tr>
					<?php else: 
						$nom_break += $saldo;
						$nom_break_last += $saldo_last;
					endif; ?>
				<?php endforeach; ?>
				<tr><td class="border-top"></td><td class="bold border-top"><strong>Jumlah Aset Tidak Lancar</strong></td><td class="bold border-top text-right"><?php echo to_abs_nom( $saldo_aset_no_lancar['last'] ); ?></td><td class="bold border-top text-right"><?php echo to_abs_nom( $saldo_aset_no_lancar['now'] ); ?></td></tr>
				<tr><td class="border-top"></td><td class="bold border-top"><strong>JUMLAH ASSET</strong></td><td class="bold border-top text-right"><?php echo to_abs_nom( $saldo_aset_lancar['last'] + $saldo_aset_no_lancar['last'] ); ?></td><td class="bold border-top text-right"><?php echo to_abs_nom( $saldo_aset_lancar['now'] + $saldo_aset_no_lancar['now'] ); ?></td></tr>
			</tbody>
		</table>
	</div>

	<div class="col-6">
		<table class="table-report-paper table-nom-parent">
			<thead>
				<tr>
					<th class="th-head text-left">COA</th>
					<th class="th-head text-left">DESKRIPSI</th>
					<th class="th-head text-right text-uppercase"><?php echo $lastMonth; ?></th>
					<th class="th-head text-right text-uppercase"><?php echo date('d F Y', strtotime( $tanggal1 ) ); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php
				$nom_break = 0;
				$nom_break_last = 0;
				foreach( $data as $d ):
					if ( 'LIA_PENDEK' !== $d['grouping'] ) continue;
					$saldo = ( $d['kredit'] - $d['debit'] );
					$saldo_lia_pendek['now'] += $saldo;
					$saldo_last = ( $d['last_kredit'] - $d['last_debit'] );
					$saldo_lia_pendek['last'] += $saldo_last;

					if( $d['level'] < 5 ):
				?>	
					<tr class="d-none nominal-data no-print" data-nominal-now="<?php echo $nom_break; ?>" data-nominal-last="<?php echo $nom_break_last; ?>"><td colspan="4"></td></tr>
					<?php
						$nom_break = 0;
						$nom_break_last = 0;
					?>
					<tr data-id="<?php echo $d['id']; ?>" data-parent="<?php echo $d['parent_akun'];?>" data-level="<?php echo $d['level']; ?>">
						<td data-column="name"><?php echo $d['kode']; ?></td>
						<td data-column="coa" class="indent-<?php echo $d['level']; ?>"><?php echo $d['nama']; ?></td>
						<td class="text-right saldo-last"><?php echo sprintf('<a href="%s">%s</a>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo_last )); ?></td>
						<td class="text-right saldo-now"><?php echo sprintf('<a href="%s">%s</a>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo )); ?></td>
					</tr>
					<?php else: 
						$nom_break += $saldo;
						$nom_break_last += $saldo_last;
					endif; ?>
				<?php endforeach; ?>
				<tr><td class="border-top"></td><td class="bold border-top"><strong>Jumlah Liabilitas Jangka Pendek</strong></td><td class="bold border-top text-right"><?php echo number_format( $saldo_lia_pendek['last'] );?></td><td class="bold border-top text-right"><?php echo number_format( $saldo_lia_pendek['now'] );?></td></tr>
				
				<?php
				$nom_break = 0;
				$nom_break_last = 0;
				foreach( $data as $d ):
					if ( 'LIA_PANJANG' !== $d['grouping'] ) continue;
					$saldo = ( $d['kredit'] - $d['debit'] );
					$saldo_lia_panjang['now'] += $saldo;
					$saldo_last = ( $d['last_kredit'] - $d['last_debit'] );
					$saldo_lia_panjang['last'] += $saldo_last;

					if( $d['level'] < 4 ):
				?>	
					<tr class="d-none nominal-data no-print" data-nominal-now="<?php echo $nom_break; ?>" data-nominal-last="<?php echo $nom_break_last; ?>"><td colspan="4"></td></tr>
					<?php
						$nom_break = 0;
						$nom_break_last = 0;
					?>
					<tr data-id="<?php echo $d['id']; ?>" data-parent="<?php echo $d['parent_akun'];?>" data-level="<?php echo $d['level']; ?>">
						<td data-column="name"><?php echo $d['kode']; ?></td>
						<td data-column="coa" class="indent-<?php echo $d['level']; ?>"><?php echo $d['nama']; ?></td>
						<td class="text-right saldo-last"><?php echo sprintf('<a href="%s">%s</a>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo_last )); ?></td>
						<td class="text-right saldo-now"><?php echo sprintf('<a href="%s">%s</a>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo )); ?></td>
					</tr>
					<?php else: 
						$nom_break += $saldo;
						$nom_break_last += $saldo_last;
					endif; ?>
				<?php endforeach; ?>
				<tr><td class="border-top"></td><td class="bold border-top"><strong>Jumlah Liabilitas Jangka Panjang</strong></td><td class="bold border-top text-right"><?php echo to_abs_nom( $saldo_lia_panjang['last'] );?></td><td class="bold border-top text-right"><?php echo number_format( $saldo_lia_panjang['now'] );?></td></tr>
				<tr><td class="border-top"></td><td class="bold border-top"><strong>JUMLAH LIABILITAS</strong></td><td class="bold border-top text-right"><?php echo number_format( $saldo_lia_panjang['last'] + $saldo_lia_pendek['last'] );?></td><td class="bold border-top text-right"><?php echo number_format( $saldo_lia_panjang['now'] + $saldo_lia_pendek['now'] );?></td></tr>

				<?php
				$nom_break = 0;
				$nom_break_last = 0;
				foreach( $data as $d ):
					if ( 'EKUITAS' !== $d['grouping'] ) continue;
					$saldo = ( $d['kredit'] - $d['debit'] );
					$saldo_ekuitas['now'] += $saldo;
					$saldo_last = ( $d['last_kredit'] - $d['last_debit'] );
					$saldo_ekuitas['last'] += $saldo_last;
					if( $d['level'] < 5 ):
				?>	
					<tr class="d-none nominal-data no-print" data-nominal-now="<?php echo $nom_break; ?>" data-nominal-last="<?php echo $nom_break_last; ?>"><td colspan="4"></td></tr>
					<?php
						$nom_break = 0;
						$nom_break_last = 0;
					?>
					<tr data-id="<?php echo $d['id']; ?>" data-parent="<?php echo $d['parent_akun'];?>" data-level="<?php echo $d['level']; ?>">
						<td data-column="name"><?php echo $d['kode']; ?></td>
						<td data-column="coa" class="indent-<?php echo $d['level']; ?>"><?php echo $d['nama']; ?></td>
						<td class="text-right saldo-last"><?php echo sprintf('<a href="%s">%s</a>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo_last )); ?></td>
						<td class="text-right saldo-now"><?php echo sprintf('<a href="%s">%s</a>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo )); ?></td>
					</tr>
					<?php else: 
						$nom_break += $saldo;
						$nom_break_last += $saldo_last;
					endif; ?>
				<?php endforeach; ?>

				<?php
				foreach( $data as $d ):
					if ( 'LABA' !== $d['grouping'] ) continue;
					$saldo = ( $d['kredit'] - $d['debit'] );
					$saldo_laba['now'] += $saldo;
					$saldo_last = ( $d['last_kredit'] - $d['last_debit'] );
					$saldo_laba['last'] += $saldo_last;
				endforeach;
				$saldo_ekuitas['last'] += $saldo_laba['last'];
				$saldo_ekuitas['now'] += $saldo_laba['now'];
				?>

				<tr><td class="border-top"></td><td>Laba Tahun ini</td><td class="text-right"><?php echo number_format( $saldo_laba['last'] );?></td><td class="text-right"><?php echo number_format( $saldo_laba['now'] );?></td></tr>
				<tr><td class="border-top"></td><td class="bold border-top"><strong>Sub - Jumlah</strong></td><td class="bold border-top text-right"><?php echo number_format( $saldo_ekuitas['last'] );?></td><td class="bold border-top text-right"><?php echo number_format( $saldo_ekuitas['now'] );?></td></tr>
				
				<?php
				foreach( $data as $d ):
					if ( 'PENGENDALI' !== $d['grouping'] ) continue;
					$saldo = ( $d['kredit'] - $d['debit'] );
					$saldo_nonpengendali['now'] += $saldo;
					$saldo_last = ( $d['last_kredit'] - $d['last_debit'] );
					$saldo_nonpengendali['last'] += $saldo_last;
				?>
					<tr>
						<td class="indent-1"><?php echo $d['kode']; ?></td>
						<td><?php echo $d['nama']; ?></td>
						<td class="text-right"><?php echo sprintf('<a href="%s">%s</a>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo_last )); ?></td>
						<td class="text-right"><?php echo sprintf('<a href="%s">%s</a>', site_url( 'jurnal/buku_besar/' . $d['id'] ), to_abs_nom( $saldo )); ?></td>
					</tr>
				<?php endforeach; ?>
				<tr><td class="border-top"></td><td class="bold border-top"><strong>JUMLAH EQUITAS</strong></td><td class="bold border-top text-right"><?php echo number_format( $saldo_ekuitas['last'] + $saldo_nonpengendali['last'] );?></td><td class="bold border-top text-right"><?php echo number_format( $saldo_ekuitas['now'] + $saldo_nonpengendali['now'] );?></td></tr>
				<tr><td class="border-top"></td><td class="bold border-top"><strong>JUMLAH LIABILITAS DAN EKUITAS</strong></td><td class="bold border-top text-right"><?php echo number_format( $saldo_lia_panjang['last'] + $saldo_lia_pendek['last'] + $saldo_ekuitas['last'] + $saldo_nonpengendali['last'] );?></td><td class="bold border-top text-right"><?php echo number_format( $saldo_lia_panjang['now'] + $saldo_lia_pendek['now'] + $saldo_ekuitas['now'] + $saldo_nonpengendali['now'] );?></td></tr>
			</tbody>
		</table>
	</div>

</div>

<?php  $this->load->view("template/footer_admin_cetak"); ?>