<?php
    $this->load->view('template/header_head_cetak');
    $column_text = sprintf( '%s', $tanggal1 );
    $dateTime = new DateTime($tanggal1);
    $lastMonth = $dateTime->modify('-' . $dateTime->format('d') . ' days')->format('F Y');
?>

<div class="row">
	<div class="col-12">
		<div>
			<h3 style="text-align: center;margin-bottom: 5px;margin-top: 0;">Laba/Rugi Konsolidasi</h3>
			<p style="text-align: center;margin-top: 5px;"><?php echo $tanggal1; ?></p>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<table class="table-report-paper">
			<thead>
				<tr>
					<th class="th-head text-left">COA</th>
					<th class="th-head text-left">DESKRIPSI</th>
					<th class="th-head text-right text-uppercase" colspan="2">S/D <?php echo $lastMonth; ?></th>

					<th></th>

					<?php foreach( $identities as $identity ): ?>
					<th colspan="2" class="th-head text-left"><?php echo $identity->identityName; ?></th>
					<?php endforeach; ?>

					<th colspan="2" class="th-head text-left text-uppercase"><?php echo date('F Y', strtotime( $tanggal1 )); ?></th>
					
					<th></th>
					
					<th colspan="2" class="th-head text-left text-uppercase">S/D <?php echo date('F Y', strtotime( $tanggal1 )); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php 
				$total_pendapatan = 0;
				foreach( $data as $d ):
					if ( 'Pendapatan' !== $d['grouping'] ) continue;
					$saldo = $d['kredit'] - $d['debit'];
					$saldo_last = $d['last_kredit'] - $d['last_debit'];
					$total_pendapatan += $saldo;
				 ?>
				<tr>
					<td><?php echo $d['kode']; ?></td>
					<td class="indent-1"><?php echo $d['nama']; ?></td>
					<td class="text-right"><?php echo to_abs_nom( $saldo_last ); ?></td>
					<td>%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ):
						$saldo_id = $d['kredit_unit_' . $identity->identityID] - $d['debit_unit_' . $identity->identityID];
					?>
					<td class="text-right"><?php echo to_abs_nom( $saldo_id ); ?></td>
					<td class="text-right">0%</td>
					<?php endforeach; ?>

					<td class="text-right">0</td>
					<td class="text-right">0%</td>

					<td class="space"></td>

					<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
					<td class="text-right">0%</td>

				</tr>
				<?php endforeach; ?>

				<tr>
					<td colspan="4"></td>
				</tr>

				<tr>
					<td></td>
					<td class="indent-1"></td>
					<td class="text-right bold border-top">0</td>
					<td class="bold border-top">%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ):
						$saldo_id = $d['kredit_unit_' . $identity->identityID] - $d['debit_unit_' . $identity->identityID];
					?>
					<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
					<td class="text-right">0%</td>
					<?php endforeach; ?>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>

					<td class="space"></td>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>

				</tr>

				<?php 
				$total_biaya = 0;
				foreach( $data as $d ):
					if ( 'BIAYA' !== $d['grouping'] ) continue;
					$saldo = $d['debit'] - $d['kredit'];
					$saldo_last = $d['last_debit'] - $d['last_kredit'];
					$total_biaya += $saldo;
				 ?>
				<tr>
					<td><?php echo $d['kode']; ?></td>
					<td class="indent-1"><?php echo $d['nama']; ?></td>
					<td class="text-right"><?php echo to_abs_nom( $saldo_last ); ?></td>
					<td>%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ): 
						$saldo_id = $d['debit_unit_' . $identity->identityID] - $d['kredit_unit_' . $identity->identityID];
					?>
					<td class="text-right"><?php echo to_abs_nom( $saldo_id ); ?></td>
					<td class="text-right">0%</td>
					<?php endforeach; ?>

					<td class="text-right">0</td>
					<td class="text-right">0%</td>

					<td class="space"></td>

					<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
					<td class="text-right">0%</td>
				</tr>
				<?php endforeach; ?>

				<tr>
					<td></td>
					<td class="bold border-top">Biaya Produksi</td>
					<td class="text-right bold border-top">0</td>
					<td class="bold border-top">%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ): 
						$saldo = $d['debit_unit_' . $identity->identityID] - $d['kredit_unit_' . $identity->identityID];
					?>
					<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
					<td class="text-right">0%</td>
					<?php endforeach; ?>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>

					<td class="space"></td>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>
				</tr>

				<?php 
				$total_hpp = 0;
				foreach( $data as $d ):
					if ( 'HPP' !== $d['grouping'] ) continue;
					$saldo = $d['debit'] - $d['kredit'];
					$saldo_last = $d['last_debit'] - $d['last_kredit'];
					$total_hpp += $saldo;
				 ?>
				<tr>
					<td><?php echo $d['kode']; ?></td>
					<td><?php echo $d['nama']; ?></td>
					<td class="text-right"><?php echo to_abs_nom( $saldo_last ); ?></td>
					<td>%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ): 
						$saldo_id = $d['debit_unit_' . $identity->identityID] - $d['kredit_unit_' . $identity->identityID];
					?>
					<td class="text-right"><?php echo to_abs_nom( $saldo_id ); ?></td>
					<td class="text-right">0%</td>
					<?php endforeach; ?>

					<td class="text-right">0</td>
					<td class="text-right">0%</td>

					<td class="space"></td>

					<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
					<td class="text-right">0%</td>
				</tr>
				<?php endforeach; ?>

				<tr>
					<td></td>
					<td class="bold border-top">Harga Pokok Produksi</td>
					<td class="text-right bold border-top">0</td>
					<td class="bold border-top">%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ): ?>
					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">%</td>
					<?php endforeach; ?>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">%</td>

					<td class="space"></td>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">%</td>
				</tr>

				<?php 
				$total_hppj = 0;
				foreach( $data as $d ):
					if ( 'HPPJ' !== $d['grouping'] ) continue;
					$saldo = $d['debit'] - $d['kredit'];
					$saldo_last = $d['last_debit'] - $d['last_kredit'];
					$total_hppj += $saldo;
				 ?>
				<tr>
					<td><?php echo $d['kode']; ?></td>
					<td><?php echo $d['nama']; ?></td>
					<td class="text-right"><?php echo to_abs_nom( $saldo_last ); ?></td>
					<td>%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ):
						$saldo_id = $d['debit_unit_' . $identity->identityID] - $d['kredit_unit_' . $identity->identityID];
					?>
					<td class="text-right"><?php echo to_abs_nom( $saldo_id ); ?></td>
					<td class="text-right">0%</td>
					<?php endforeach; ?>

					<td class="text-right">0</td>
					<td class="text-right">0%</td>

					<td class="space"></td>

					<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
					<td class="text-right">%</td>
				</tr>
				<?php endforeach; ?>

				<tr>
					<td></td>
					<td class="bold border-top">Harga Pokok Penjualan</td>
					<td class="text-right bold border-top">0</td>
					<td class="bold border-top">0%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ): ?>
					<td class="text-right border-top bold">0</td>
					<td class="text-right bold border-top">0%</td>
					<?php endforeach; ?>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>

					<td class="space"></td>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>
				</tr>

				<tr>
					<td colspan="4"></td>
				</tr>

				<tr>
					<td></td>
					<td class="bold border-top">Laba Kotor</td>
					<td class="text-right bold border-top">0</td>
					<td class="bold border-top">%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ): ?>
					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">%</td>
					<?php endforeach; ?>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">%</td>

					<td class="space"></td>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">%</td>
				</tr>

				<?php 
				$total_biaya_usaha = 0;
				foreach( $data as $d ):
					if ( 'HPPJ' !== $d['grouping'] ) continue;
					$saldo = $d['debit'] - $d['kredit'];
					$saldo_last = $d['last_debit'] - $d['last_kredit'];
					$total_biaya_usaha += $saldo;
				 ?>
				<tr>
					<td><?php echo $d['kode']; ?></td>
					<td><?php echo $d['nama']; ?></td>
					<td class="text-right"><?php echo to_abs_nom( $saldo_last ); ?></td>
					<td>%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ):
						$saldo_id = $d['debit_unit_' . $identity->identityID] - $d['kredit_unit_' . $identity->identityID];
					?>
					<td class="text-right"><?php echo to_abs_nom( $saldo_id ); ?></td>
					<td class="text-right">0%</td>
					<?php endforeach; ?>

					<td class="text-right">0</td>
					<td class="text-right">0%</td>

					<td class="space"></td>

					<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
					<td class="text-right">0%</td>
				</tr>
				<?php endforeach; ?>

				<tr>
					<td></td>
					<td class="bold border-top">Biaya Usaha</td>
					<td class="text-right bold border-top">0</td>
					<td class="bold border-top">%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ): ?>
					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>
					<?php endforeach; ?>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>

					<td class="space"></td>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>
				</tr>

				<tr>
					<td colspan="4"></td>
				</tr>

				<tr>
					<td></td>
					<td class="bold border-top">Laba Usaha</td>
					<td class="text-right bold border-top">0</td>
					<td class="bold border-top">%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ): ?>
					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>
					<?php endforeach; ?>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>

					<td class="space"></td>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>
				</tr>

				<?php 
				$total_pendapatan_ll = 0;
				foreach( $data as $d ):
					if ( 'PENDAPATAN_LL' !== $d['grouping'] ) continue;
					$saldo = $d['debit'] - $d['kredit'];
					$saldo_last = $d['last_debit'] - $d['last_kredit'];
					$total_pendapatan_ll += $saldo;
				 ?>
				<tr>
					<td><?php echo $d['kode']; ?></td>
					<td><?php echo $d['nama']; ?></td>
					<td class="text-right"><?php echo to_abs_nom( $saldo_last ); ?></td>
					<td>%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ):
						$saldo_id = $d['debit_unit_' . $identity->identityID] - $d['kredit_unit_' . $identity->identityID];
					?>
					<td class="text-right"><?php echo to_abs_nom( $saldo_id ); ?></td>
					<td class="text-right">0%</td>
					<?php endforeach; ?>

					<td class="text-right">0</td>
					<td class="text-right">0%</td>

					<td class="space"></td>

					<td class="text-right"><?php echo to_abs_nom( $saldo ); ?></td>
					<td class="text-right">0%</td>
				</tr>
				<?php endforeach; ?>

				<tr>
					<td></td>
					<td class="bold border-top">Pendapatana Biaya Lain2 dan Keuangan</td>
					<td class="text-right bold border-top">0</td>
					<td class="bold border-top">0%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ): ?>
					<td class="text-right border-top bold">0</td>
					<td class="text-right border-top bold">0%</td>
					<?php endforeach; ?>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>

					<td class="space"></td>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>
				</tr>

				<tr>
					<td colspan="4"></td>
				</tr>

				<tr>
					<td></td>
					<td class="bold border-top">Laba Bersih Sebelum Pajak</td>
					<td class="text-right bold border-top">0</td>
					<td class="bold border-top">0%</td>

					<td class="space"></td>

					<?php foreach( $identities as $identity ): ?>
					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>
					<?php endforeach; ?>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>

					<td class="space"></td>

					<td class="text-right bold border-top">0</td>
					<td class="text-right bold border-top">0%</td>
				</tr>
				
			</tbody>
		</table>
	</div>
</div>

<?php  $this->load->view("template/footer_admin_cetak"); ?>