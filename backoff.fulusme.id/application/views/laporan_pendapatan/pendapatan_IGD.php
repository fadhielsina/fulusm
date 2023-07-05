<?php


?>


 <div class="table-responsive m-t-5" style="background-color:#767779;padding: 10px; ">
	<table id="report_area" cellpadding="0" cellspacing="0" border="0" class="table no-wrap table-bordered table-striped"  style="background-color:white">
    <thead>	
	<tr>  
        <!-- <th ><?= $this->lang->line('tanggal') ?></th> -->
        <th width="50%" ><!-- <?= $this->lang->line('keterangan') ?> --></th>
        <th ><?= $this->lang->line('penerimaan') ?></th><!-- 
        <th ><?= $this->lang->line('kredit') ?></th> -->
        <th><?= $this->lang->line('saldo') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	$jumlah = 0;
	$tempHeader = "";
	foreach ($dataLaporan as $key => $value) {
		if($jns_laporan == "laporan_bulanan" ){
			$header = date("M Y",strtotime($value['tgl']));
		}else{
			$header = date("d M Y",strtotime($value['tgl']));
		}
		if($tempHeader != $header){
			echo '<tr>';
			echo '<td colspan="3">'.$header.'</td>';
			echo '</tr>';
			echo '<tr>';	
			echo '<td style="padding-left:20px;">'.$value['keterangan'].'</td>';/*
			echo '<td>'.$value['debit'].'</td>';*/
			echo '<td>'.number_format( $value['kredit'] ).'</td>';
			$jumlah += $value['kredit'];		
			echo '<td>'.number_format( $jumlah ).'</td>';		
			echo '</tr>';
		}else{
			echo '<tr>';	
			echo '<td style="padding-left:20px;">'.$value['keterangan'].'</td>';/*
			echo '<td>'.$value['debit'].'</td>';*/
			echo '<td>'.number_format( $value['kredit'] ).'</td>';
			$jumlah += $value['kredit'];		
			echo '<td>'.number_format( $jumlah ).'</td>';		
			echo '</tr>';
		}

		$tempHeader = $header;
	}
	?>
	 </tbody>
	<tfoot>
	<tr>
       <!--  <th ><?= $this->lang->line('tanggal') ?></th> -->
        <th ><!-- <?= $this->lang->line('keterangan') ?> --></th>
        <th ><?= $this->lang->line('penerimaan') ?></th><!-- 
        <th ><?= $this->lang->line('kredit') ?></th> -->
        <th><?= $this->lang->line('saldo') ?></th>
	</tr>
	</tfoot>	
</table>
</div>

<script type="text/javascript" charset="utf-8">
var oTable;
var oDialog;

$(document).ready(function() {
  /*$('#example23').DataTable({
    dom: 'Bfrtip',
    order: [[0, 'asc']],
    rowGroup: {
        dataSrc: 0
    }
    });*/
$(function () {
var table = $('#example23Group').DataTable({
	"columnDefs": [{
	"visible": false,
	"targets": 0
	}],
	"order": [
		[0, 'asc']
	],
	dom: 'Bfrtip',
	buttons: [
        {
            text: 'Print',
            action: function ( dt ) {
                printTable($('#example23Group'));
            }
        },
        { extend: 'excelHtml5', footer: true },
        {
            text: 'PDF',
            action: function ( dt ) {
                pdfTable($('#example23Group'));
            }
        }
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
			$(rows).eq(i).before('<tr class="group" style="background-color:#007bff;color:#FFFF"><td colspan="6">' + group + '</td></tr>');
			last = group;
			}
		});
	}
	});
});
});


</script>

<?php 
//load function fot custom datatable button
$this->load->view("template/data_table_button");
?>