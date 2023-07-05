<?php
$fieldData = array(
		array($start,"170911-0011","071754","Jhon Smith","Umum",rand(100,500),rand(500,7000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),"test1"),
		array($start,"170911-0011","071754","Jhon Smith","Umum",rand(100,500),rand(500,7000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),"test1"),
		array($start,"170911-0011","071754","Jhon Smith","Umum",rand(100,500),rand(500,7000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),"test1"),
		array($start,"170911-0011","071754","Jhon Smith","Umum",rand(100,500),rand(500,7000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),"test1"),
		array($start,"170911-0011","071754","Jhon Smith","Umum",rand(100,500),rand(500,7000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),rand(200,3000),"test1"),
		
);

?>

 <div class="table-responsive m-t-5">
    <table id="example231" class="table display table-bordered table-striped">
    <thead>	
	<tr>
		<th >No </th>
		<th >Tgl Bayar</th>
		<th >No Kwitansi</th>
		<th >No RM</th>
		<th >Pasien</th>
		<th>Jns Pembayaran</th>
		<th>Ttl Biaya</th>
		<th>Tunai</th>
		<th>Debit</th>
		<th>Kredit</th>
		<th>Deposit</th>
		<th>Piutang</th>
		<th>Cicilan</th>
		<th>Asuransi</th>
		<th>Hutang</th>
		<th>Ciciclan Piutang</th>
		<th>Pendapatan Sebelumnya</th>
		<th>Sisa Cicilan</th>
		<th>Jns Kasir</th>
		<th>Kasir</th>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<tr>
		<th >No </th>
		<th >Tgl Bayar</th>
		<th >No Kwitansi</th>
		<th >No RM</th>
		<th >Pasien</th>
		<th>Jns Pembayaran</th>
		<th>Ttl Biaya</th>
		<th>Tunai</th>
		<th>Debit</th>
		<th>Kredit</th>
		<th>Deposit</th>
		<th>Piutang</th>
		<th>Cicilan</th>
		<th>Asuransi</th>
		<th>Hutang</th>
		<th>Ciciclan Piutang</th>
		<th>Pendapatan Sebelumnya</th>
		<th>Sisa Cicilan</th>
		<th>Jns Kasir</th>
		<th>Kasir</th>
	</tr>
	</tr>
	</tfoot>	
	<tbody>
	<?php
	$no=1;
	foreach ($fieldData as $key => $value) {
		echo '<tr>';
		echo '<td>'.$no.'</td>';
		echo '<td>'.$value[0].'</td>';
		echo '<td>'.$value[1].'</td>';
		echo '<td>'.$value[2].'</td>';
		echo '<td>'.$value[3].'</td>';
		echo '<td>'.$value[4].'</td>';
		echo '<td>'.$value[5].'</td>';
		echo '<td>'.$value[6].'</td>';
		echo '<td>'.$value[7].'</td>';
		echo '<td>'.$value[8].'</td>';
		echo '<td>'.$value[9].'</td>';
		echo '<td>'.$value[10].'</td>';
		echo '<td>'.$value[11].'</td>';
		echo '<td>'.$value[12].'</td>';
		echo '<td>'.$value[13].'</td>';
		echo '<td>'.$value[14].'</td>';
		echo '<td>'.$value[15].'</td>';
		echo '<td>'.$value[16].'</td>';
		echo '<td>'.$value[17].'</td>';
		echo '<td>'.$value[18].'</td>';
		$jumlah = $value[3] +$value[4]+$value[5];
		
		echo '</tr>';
		$no++;
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
    ]
	
	});
});
});


</script>