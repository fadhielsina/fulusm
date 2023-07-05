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

<h3><?php echo $this->lang->line('laporan')." ".ucfirst(str_replace("_"," ",$jenis_laporan)) ?></h3>
<div><?php echo 'Periode : <b>'.$periode.'</b>' ?></div>


 <div class="table-responsive m-t-5" id="ttl" style="background-color:#767779;padding: 10px; ">
    <table id="report_area" class="table display table-bordered table-striped" style="background-color:white">
    <thead>	
	<tr>
            <th ><?= $this->lang->line('tanggal') ?></th>
            <th ><?= 'No.Bukti' ?></th>
            <th ><?= $this->lang->line('uraian') ?></th>
            <th ><?= 'Diterima' ?></th>
            <th ><?= 'Disetor' ?></th>
            <th ><?= 'Saldo' ?></th>
	</tr>
	</thead>	
	<tbody>
    <?php number_format($saldo=0);?>
	<?php
	foreach ($dataLaporan as $key => $value) {

        echo '<tr>';
		echo '<td>'.$value['tgl'].'</td>';
		echo '<td>'.$value['invoice_no'].'</td>';
		echo '<td>'.$value['uraian'].'</td>';
		echo '<td>'.number_format($value['debit']).'</td>';
        echo '<td>'.number_format($value['kredit']).'</td>';
        $saldo = $saldo + $value['debit'] - $value['kredit'];
		echo '<td>'.number_format($saldo).'</td>';
		echo '</tr>';
	}
	?>
	</tbody>
	<tfoot>
	<tr>
            <th ><?= $this->lang->line('tanggal') ?></th>
			<th ><?= 'No.Bukti' ?></th>
            <th ><?= $this->lang->line('uraian') ?></th>
            <th ><?= 'Diterima' ?></th>
            <th ><?= 'Disetor' ?></th>
            <th ><?= 'Saldo' ?></th>
	</tr>
	</tfoot>
	</table>
</div>


</div>
</div>
<?php 
//load function fot custom datatable button
$this->load->view("template/data_table_button");
?>