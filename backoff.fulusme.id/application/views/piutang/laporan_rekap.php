
<div class="card">
<div class="card-header">
<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
	<div class="btn-group  mb-2 mb-md-0" role="group" aria-label="First group">
	    <button type="button" class="btn btn-secondary" onClick="printTable($('#report_area'));"><i class="mdi mdi-printer"></i></button>
	    <!-- <button type="button" class="btn btn-secondary"  onClick="printTable($('#example231'));"><i class="mdi mdi-file-excel"></i></button> -->
	    <button type="button" class="btn btn-secondary"  onClick="pdfTable($('#report_area'));"><i class="mdi mdi-file-pdf"></i></button> 
	</div>
	</div>
</div>
<div class="card-body">
<h3> <?php echo $this->lang->line('laporan').'  '.ucfirst(str_replace("_"," ",$this->lang->line('rekap_piutang'))) ?></h3>
<h4>Periode : <?php echo $months." ".$years ?></h4>
<?php
if(isset($is_detail)){
	echo '<a class="btn btn-success float-right" href="'.$url_back.'">Kembali</a>';
}
?>
 <div class="table-responsive m-t-5" style="background-color:#767779;padding: 10px; ">
	<table id="report_area" cellpadding="0" cellspacing="0" border="0" class="table no-wrap table-bordered table-striped"  style="background-color:white">
    <thead>	
	<tr>
		<th ><?= $this->lang->line('nama_akun') ?></th>
		<th ><?= $this->lang->line('balance')." ".$this->lang->line('last_month') ?></th>
		<th class="text-right"><?= $this->lang->line('saldo')." ".$this->lang->line('current_month') ?>
		<th ><?= $this->lang->line('debit') ?></th>
		<th ><?= $this->lang->line('kredit') ?></th>
		<th  class="no-print"></th>
	</tr>
	</thead>
	
	<tbody>
	<?php
	$totSaldo = 0;
	foreach ($dataLaporan as $key => $value) : 
	  if(strlen($value['kode_akun'])>4){
	  	$padding = "60px";
	  }else if(strlen($value['kode_akun'])>3){
	  	$padding = "60px";
	  }else if(strlen($value['kode_akun'])>2){
	  	$padding = "10px";
	  }else{
	  	$padding = "0px";
	  }

	?>
		<tr>
		<td style="padding-left: <?php echo $padding ?>"><?= $value['nama_akun'] ?> </td>
		<td><?= number_format( $value['total_last_month'] ); ?></td>
		<?php $saldo = $value['DEBIT'] - $value['KREDIT']; ?>
		<td class="text-right"><?= number_format( $saldo ); ?></td>
		<td class="text-right"><?= number_format( $value['DEBIT'] ); ?></td>
		<td class="text-right"><?= number_format( $value['KREDIT'] ); ?></td>
		<td class="no-print">
			<?php
			if(isset($is_detail)){

			}else{
			?>
			<a href="<?= base_url()."/Piutang/detail/".$value['id_akun']."/".$years."/".$month ?>" class="badge badge-primary">Detail</a>
			<?php 
			} 
			?>
			</td>
		</tr>
		<?php $totSaldo += $saldo; ?>
	<?php endforeach; ?>
	 </tbody>
	 <tfoot>
	<tr>
		<th ><?= $this->lang->line('nama_akun') ?></th>
		<th ><?= $this->lang->line('balance')." ".$this->lang->line('last_month') ?></th>
		<th class="text-right"><?= $this->lang->line('saldo')." ".$this->lang->line('current_month') ?>
		<th ><?= $this->lang->line('debit') ?></th>
		<th ><?= $this->lang->line('kredit') ?></th>
		</th>
		<th  class="no-print"></th>
	</tr>
	</tfoot>	
</table>
<!-- <div class="row" style="background:#1e88e5;color:#FFFF;font-size: 25px;">
	<div class="col-md-7 text-right "><?= $this->lang->line('total_saldo') ?>:</div>
	<div class = "col-md-3 text-right ">Rp. <?php echo number_format($totSaldo) ?></div>
</div> -->
</div>
</div>
</div>

<?php 
//load function fot custom datatable button
$this->load->view("template/data_table_button");
?>