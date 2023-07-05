
<div class="card card-outline-info">
<div class="card-header">
	<h3 class="text-white">Detail Data Hutang </h3>
</div>
<div class="card-body">
<div class="card-title">
<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
	<div class="btn-group  mb-2 mb-md-0" role="group" aria-label="First group">
	    <button type="button" class="btn btn-secondary" onClick="printTable($('#report_area'));"><i class="mdi mdi-printer"></i></button>
	    <!-- <button type="button" class="btn btn-secondary"  onClick="printTable($('#example231'));"><i class="mdi mdi-file-excel"></i></button> -->
	    <button type="button" class="btn btn-secondary"  onClick="pdfTable($('#report_area'));"><i class="mdi mdi-file-pdf"></i></button> 
	</div>
	</div>
</div>
 
 <div class="table-responsive m-t-5" style="background-color:#767779;padding: 10px; ">
	<table id="report_area" cellpadding="0" cellspacing="0" border="0" class="table no-wrap table-bordered table-striped"  style="background-color:white">
    <thead>	
	<tr>
		<th ><?= $this->lang->line('invoice_no') ?></th>
		<th ><?= $this->lang->line('tanggal')  ?></th> 
		<th ><?= $this->lang->line('catatan') ?></th>
		<th ><?= $this->lang->line('pembelian') ?></th> 
		<th ><?= $this->lang->line('total_bayar') ?></th> 
		<th ><?= $this->lang->line('hutang_pembelian') ?></th> 
		<th></th>  
	</tr>
	</thead>
	<tbody>
	<?php
	$totHutang = 0;
	$supptemp = "";
	foreach ($dataLaporan as $key => $value) {
		if($supptemp != $value['trxFullName']){
			echo '<tr>
			<td colspan="7"><strong>'.$value['trxFullName'].'</strong></td>
			</tr>'; 
		}
		$SisaBayar = $value['trxTotal'] - $value['tot_bayar'];
		echo '<tr>';
		echo '<td style="padding-left:40px">'.$value['invoiceBuyID'].'</td>';
		echo '<td>'.$value['trxDate'].'</td>';
		echo '<td>'.$value['note'].'</td>';
		echo '<td>'.number_format($value['trxTotal']).'</td>';
		echo '<td>'.number_format($value['tot_bayar']).'</td>';		
		echo '<td class="text-right">'.number_format($SisaBayar).'</td>';
		echo '<td class="text-right">'.($value['is_pay']==1?"Lunas":"").'</td>';
		//<button class="btn btn-primary btn-xs">Detail</button>
		echo '</tr>';
		$totHutang += $SisaBayar;
		$supptemp = $value['trxFullName'];
	}
	?>
	 </tbody>
	 <tfoot>
	<tr>
		<th ><?= $this->lang->line('invoice_no') ?></th>
		<th ><?= $this->lang->line('tanggal')  ?></th> 
		<th ><?= $this->lang->line('catatan') ?></th>
		<th ><?= $this->lang->line('total_pembelian') ?></th>
		<th ><?= $this->lang->line('total_bayar') ?></th> 		 
		<th ><?= $this->lang->line('hutang_pembelian') ?></th>
		<th></th>  
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
