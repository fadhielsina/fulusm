<style>
.table #x td {
	border :none;}</style>
<?php $byears=$years-1; ?>
<div class="card">
<div class="card-body">
<h3><?php echo ucfirst(str_replace("_"," ",$this->lang->line('laporan_neraca'))) ?></h3>
<h4><?= $this->lang->line('periode') ?><?php echo $years; ?> dan <?= $byears;?></h4>
 <div class="table-responsive m-t-5">
    <table id="example23" class="table display table-bordered table-striped">
    <thead>	
	<tr>
		<th ><?= $this->lang->line('kode_akun') ?></th>
		<th ><?= $this->lang->line('nama_akun') ?></th>
		<th ><?= $years; ?></th>
		<th ><?= $byears; ?></th>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<th ><?= $this->lang->line('kode_akun') ?></th>
		<th ><?= $this->lang->line('nama_akun') ?></th>
		<th ><?= $years; ?></th>
		<th ><?= $byears; ?></th>
	</tr>
	</tfoot>	
	<tbody><?php
	foreach ($output as $key => $value){
		echo '<tr style="background-color:#007bff;color:#FFFF" id="x">';
		echo '<td>'.$key.'</td>';
		echo '<td></td>';
		echo '<td></td>';
		echo '<td></td>';			
		echo '</tr>';
		foreach($value as $key2 => $value2){
			echo '<tr  style="background-color:lightblue;color:#FFFF;" id="x">';
				echo '<td style="padding-left:2em;">'.$key2.'</td>';
				echo '<td></td>';
				echo '<td></td>';
				echo '<td></td>';			
				echo '</tr>';
				$s=0;
				$k=0;
				foreach($value2 as $key3 => $value3){
					$tahuns=isset($value3['stahunsebelumnya'])?$value3['stahunsebelumnya']: '0';
					$s+=$value3['stahunsekarang'];
					$k+=$tahuns;
					echo '<tr>';
					echo '<td style="padding-left:4em;">'.$key3.'</td>';
					echo '<td>'.$value3['nama_akun'].'</td>';
					echo '<td>'.$value3['stahunsekarang'].'</td>';
					echo '<td>'.$tahuns.'</td>';			
					echo '</tr>';
				}		
				echo '<tr style="background-color:white">';
				echo '<td></td>';
				echo '<td type="text" class="text-right"><b>Jumlah '.$key2.'</b></td>';
				echo '<td>'.$s.'</td>';
				echo '<td>'.$k.'</td>';			
				echo '</tr>';
			}}
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
	"bSort": false,
	dom: 'Bfrtip',
	buttons: [
        { extend: 'print', footer: true },
        { extend: 'excelHtml5', footer: true },
        { extend: 'pdfHtml5', footer: true }
    ],
	"columnDefs": [
		{
			"targets":[2,3],
			"render": $.fn.dataTable.render.number( ',', '.', 2  )
		}
		],
		"displayLength": 25
	});
});
});


</script>