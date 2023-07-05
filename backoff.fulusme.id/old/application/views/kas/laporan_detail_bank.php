
<div class="card">
<div class="card-body">
<h3>Laporan <?php echo ucfirst(str_replace("_"," ",$jenis_laporan)) ?></h3>
<a href="<?= base_url()?>kas/rekap_bank" class="btn btn-primary">Back</a>
 <div class="table-responsive m-t-5">
    <table id="example23" class="table display table-bordered table-striped">
    <thead>	
	<tr>
		<th ><?= $this->lang->line('tanggal') ?></th>
		<th >No Invoice</th>
		<th ><?= $this->lang->line('keterangan') ?></th>
		<th ><?= $this->lang->line('debit') ?></th>
		<th ><?= $this->lang->line('kredit') ?></th>
		<th></th>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<th ><?= $this->lang->line('tanggal') ?></th>
		<th >No Invoice</th>
		<th ><?= $this->lang->line('keterangan') ?></th>
		<th ><?= $this->lang->line('debit') ?></th>
		<th ><?= $this->lang->line('kredit') ?></th>
		<th></th>
	</tr>
	</tfoot>	
	<tbody>
	<?php
	$totSaldo = 0;
	$deb = 0;
	$kred = 0;
	$saldo = 0;
	foreach ($dataLaporan as $key => $value) : ?>
		<tr>
		<td> <?= $value['tgl'] ?> </td>
		<td> <?= $value['invoice_no'] ?> </td>
		<td> <?= $value['keterangan'] ?></td>
		<?php if ( $value['debit_kredit'] == 1 ) { ?>
			<td> <?= $value['nilai'] ?> </td>
			<td> </td>
			<?php $deb += $value['nilai'] ?>
		<?php } else { ?>
			<td> </td>
			<td> <?= $value['nilai'] ?> </td>
			<?php $kred += $value['nilai'] ?>
		<?php } ?>
		</tr>
		<?php $saldo = $deb - $kred ?>
	<?php endforeach; ?>
	<?php $totSaldo += $saldo ?>
	 </tbody>
</table>
<div class="row" style="background:#1e88e5;color:#FFFF;font-size: 25px;">
	<div class="col-md-7 text-right "><?= $this->lang->line('total_saldo') ?></div>
	<div class = "col-md-3 text-right ">Rp. <?php echo number_format($totSaldo) ?></div>
</div>
</div>
</div>
</div>