
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
<h3> <?php echo $title ?></h3>
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
		<th ><?= $this->lang->line('invoice_no') ?></th>
		<th ><?= $this->lang->line('tanggal') ?></th>
		<th class="text-left"><?= $this->lang->line('keterangan') ?>
		<th ><?= $this->lang->line('debit') ?></th>
		<th ><?= $this->lang->line('kredit') ?></th>
		<th></th>
	</tr>
	</thead>
		
	<tbody>
	<?php
	$totSaldo = 0;
	foreach ($dataLaporan as $key => $value) : ?>
		<tr>
		<td><?= $value['invoice_no'] ?> </td>
		<td><?= $value['tgl'] ?> </td>
		<td class="text-left"><?=$value['keterangan'] ?></td>
		<td><?= number_format( $value['DEBIT'] ); ?></td>
		<td><?= number_format( $value['KREDIT'] ); ?></td>
		<td>
			<?php
			$saldo = $value['DEBIT']-$value['KREDIT'];
			?>
			</td>
		</tr>
		<?php $totSaldo += $saldo; ?>
	<?php endforeach; ?>
	 </tbody>
	 <tfoot>
	<tr>
		<th > </th>
		<th > </th>
		<th class="text-right"><?= $this->lang->line('total') ?>
		<th colspan="2" ><?= number_format($totSaldo) ?></th> 
		 
	</tr>
	</tfoot>
</table>
 
</div>
</div>
</div>
<script type="text/javascript" charset="utf-8" src="https://www.jqueryscript.net/demo/Customizable-Multiple-Elements-Printing-Plugin-With-jQuery-printThis/printThis.js"></script>
<script type="text/javascript" charset="utf-8">
var oTable;
var oDialog;
function print($table){
	  $($table).printThis({
		pageTitle: "Report Piutang Detail",
	    loadCSS: ["http://localhost/surplus/assets/material/plugins/datatables/jquery.dataTables.min.css","http://localhost/surplus/assets/material/plugins/bootstrap/js/bootstrap.min.js"],
	    header: "<h2 style='text-align:center'> Katingan <br>"+
					"RSUD Mas Amsyar Kasongan<br>"+
					"Detail Piutang</h2>"
	});
};
$(document).ready(function() {

$(function () {
var table = $('#example231').DataTable({
	"columnDefs": [{
	"visible": true,
	"targets": 0
	},
	{
		"render": function (data, type, row) {
                 return commaSeparateNumber(data);
            },
        "targets": [3]
	}],
    language: {
        "decimal": ",",
        "thousands": "."
    },
	dom: 'Bfrtip',
	buttons: [
        /*{ extend: 'print', footer: true },
        { extend: 'excelHtml5', footer: true },
        { extend: 'pdfHtml5', footer: true }*/
        {
            text: 'Cetak',
            action: function ( e, dt, node, config ) {
                print($('#example231'));
            }
        }
    ]
	});
});
});


</script>