
<div class="card">
<div class="card-body">
<h3>Laporan <?php echo $jenis_laporan ?></h3>
<h4>Periode : <?php echo $months." ".$years ?></h4>
<br>
<br>
 <div class="table-responsive m-t-5">
 	<table id="example23" class="table display table-bordered table-striped">
    <thead>	
	<tr>
		<th width="10%">No </th>
		<th width="30%"><?= $this->lang->line('uraian') ?></th>
		<th width="20%"><?php echo $months." ".($years-1); ?></th>
		<th width="20%"><?php echo $months."  ".$years; ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
		$no = 1;
		$Totsaldo = 0;
		foreach ($dataLaporan as $key => $value) {
			echo '<tr>';	
			echo '<td >'.$no.' </td>
				<td >'.$key.'</td>
				<td >'.number_format($value[0]).'</td>
				<td >'.number_format($value[1]).'</td>
				';
			echo '</tr>';	
			$no++;	

		}
	
	?>
	</tbody>
	</table>

</div>
</div>
</div>

<script type="text/javascript" charset="utf-8">
var oTable;
var oDialog;

$(document).ready(function() {
$(function () {
var table = $('#example23').DataTable({
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
        { extend: 'print', footer: true },
        { extend: 'excelHtml5', footer: true },
        { extend: 'pdfHtml5', footer: true }
    ]
	});
});
});


</script>