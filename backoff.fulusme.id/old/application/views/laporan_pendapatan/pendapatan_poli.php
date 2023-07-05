<?php
$fieldData = array(
		array("Poli A",$start,"-",round(100,1000),round(500,7000),round(200,3000)),
		array("Poli A",$start,"-",round(100,1000),round(500,7000),round(200,3000)),
		array("Poli B",$start,"-",round(100,1000),round(500,7000),round(200,3000)),
		array("Poli B",$start,"-",round(100,1000),round(500,7000),round(200,3000)),
		array("Poli B",$start,"-",round(100,1000),round(500,7000),round(200,3000)),
		array("Poli C",$start,"-",round(100,1000),round(500,7000),round(200,3000)),
		array("Poli C",$start,"-",round(100,1000),round(500,7000),round(200,3000)),
		array("Poli C",$start,"-",round(100,1000),round(500,7000),round(200,3000)),
);

?>

 <div class="table-responsive m-t-5">
    <table id="example231" class="table display table-bordered table-striped">
    <thead>	
	<tr>
		<th >Unit </th>
		<th >Tanggal</th>
		<th >Shift</th>
		<th >Rawat Inap</th>
		<th >Rawat Jalan</th>
		<th>IGD</th>
		<th>Total Per Unit</th>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<th >Unit </th>
		<th >Tanggal</th>
		<th >Shift</th>
		<th >Rawat Inap</th>
		<th >Rawat Jalan</th>
		<th>IGD</th>
		<th>Total Per Unit</th>
	</tr>
	</tfoot>	
	<tbody>
	<?php
	foreach ($fieldData as $key => $value) {
		echo '<tr>';
		echo '<td>'.$value[0].'</td>';
		echo '<td>'.$value[1].'</td>';
		echo '<td>'.$value[2].'</td>';
		echo '<td>'.$value[3].'</td>';
		echo '<td>'.$value[4].'</td>';
		echo '<td>'.$value[5].'</td>';
		$jumlah = $value[3] +$value[4]+$value[5];
		echo '<td>'.$jumlah.'</td>';
		
		echo '</tr>';
	}
	?>
	 </tbody>
</table>
</div>

<script type="text/javascript" charset="utf-8">
var oTable;
var oDialog;

$(document).ready(function() {
  /*$('#example231').DataTable({
    dom: 'Bfrtip',
    order: [[0, 'asc']],
    rowGroup: {
        dataSrc: 0
    }
    });*/
$(function () {
var table = $('#example231').DataTable({
	"columnDefs": [{
	"visible": false,
	"targets": 0
	}],
	"order": [
		[0, 'asc']
	],
	dom: 'Bfrtip',
	buttons: [
        { extend: 'print', footer: true },
        { extend: 'excelHtml5', footer: true },
        { extend: 'pdfHtml5', footer: true }
    ],
	"drawCallback": function (settings) {
		var api = this.api();
		var rows = api.rows({
		page: 'current'
		}).nodes();
		var last = null;
		api.column(0, {
		page: 'current'
		}).data().each(function (group, i) {

			if (last !== group) {
			$(rows).eq(i).before('<tr class="group" style="background-color:#007bff;color:#FFFF"><td colspan="5">' + group + '</td><td>'+24000+'</td></tr>');
			last = group;
			}
		});
	}
	});
});
});


</script>