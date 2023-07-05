
<div class="card">
<div class="card-body">
<h3>Laporan <?php echo ucfirst(str_replace("_"," ",$jenis_laporan)) ?></h3>
<h4>Periode : <?php echo $months." ".$years ?></h4>
 <div class="table-responsive m-t-5">
    <table id="example23" class="table display table-bordered table-striped">
    <thead>	
	<tr>
		<th ><?= $this->lang->line('nama_akun') ?></th>
		<th ><?= $this->lang->line('saldo_awal') ?></th>
		<th ><?= $this->lang->line('debit') ?></th>
		<th ><?= $this->lang->line('kredit') ?></th>
		<th class="text-right"><?= $this->lang->line('saldo') ?></th>
		<th></th>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<th ><?= $this->lang->line('nama_akun') ?></th>
		<th ><?= $this->lang->line('saldo_awal') ?></th>
		<th ><?= $this->lang->line('debit') ?></th>
		<th ><?= $this->lang->line('kredit') ?></th>
		<th class="text-right"><?= $this->lang->line('saldo') ?></th>
		<th></th>
	</tr>
	</tfoot>	
	<tbody>
	<?php
	$totSaldo = 0;
	foreach ($dataLaporan as $key => $value) : ?>
		<tr>
		<td> <?= $value['nama_akun'] ?> </td>
		<td> <?= $value['saldo_awal'] ?> </td>
		<td> <?= $value['DEBIT'] ?> </td>
		<td> <?= $value['KREDIT'] ?> </td>
		<?php $saldo = $value['DEBIT'] - $value['KREDIT'] ?>
		<td class="text-right"> <?= $saldo ?> </td>
		<!-- <td><button class="btn btn-primary btn-xs">Detail</button></td> -->
		<td><a href="<?= base_url()?>kas/detail_bank/<?= $value['id_akun']?>" class="badge badge-primary">Detail</a></td>
		</tr>
		<?php $totSaldo += $saldo ?>
	<?php endforeach; ?>
	 </tbody>
</table>
<div class="row" style="background:#1e88e5;color:#FFFF;font-size: 25px;">
	<div class="col-md-7 text-right "><?= $this->lang->line('total_saldo') ?></div>
	<div class = "col-md-3 text-right ">Rp. <?php echo number_format($totSaldo) ?></div>
</div>
</div>
</div>
</div>

