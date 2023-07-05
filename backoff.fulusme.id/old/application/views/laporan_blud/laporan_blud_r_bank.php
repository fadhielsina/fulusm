<div class="card">
<div class="card-body">
<ul class="nav nav-tabs profile-tab" role="tablist">
		<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#section-semua" role="tab" aria-selected="true">Penerimaan dan Pengeluaran</a>
		</li>
		<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#section-penerimaan" role="tab" aria-selected="false">Penerimaan</a>
		</li>
		<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#section-pengeluaran" role="tab" aria-selected="false">Pengeluaran</a>
		</li>
	</ul>
<br>
<h3><?php echo $this->lang->line('laporan')." ".ucfirst(str_replace("_"," ",$jenis_laporan)) ?></h3>
<div><?php echo 'Periode : <b>'.$periode.'</b>' ?></div>

<div class="col-md-12">
		<div class="tab-content">
			<div class="tab-pane active p-t-20" id="section-semua" role="tabpanel">
				<div class="row">
					<div class="col-md-12">
					    <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
					    <div class="btn-group  mb-2 mb-md-0" role="group" aria-label="First group">
					        <button type="button" class="btn btn-secondary" onClick="printTable($('#report_area'));"><i class="mdi mdi-printer"></i></button>
					        <!-- <button type="button" class="btn btn-secondary"  onClick="printTable($('#example231'));"><i class="mdi mdi-file-excel"></i></button> -->
					        <button type="button" class="btn btn-secondary"  onClick="pdfTable($('#report_area'));"><i class="mdi mdi-file-pdf"></i></button> 
					    </div>
					    </div>
					</div>  
					<div class="col-md-12">
						<div class="table-responsive m-t-5"  style="background-color:#767779;padding: 10px; ">
    					<table id="report_area" class="table table-bordered no-wrap"  style="background-color:white; ">
					    <thead>	
						<tr>
					            <th ><?= $this->lang->line('tanggal') ?></th>
					            <th ><?= 'No.Bukti' ?></th>
					            <th ><?= $this->lang->line('keterangan') ?></th>
					            <th ><?= 'Diterima' ?></th>
					            <th ><?= 'Disetor' ?></th>
						</tr>
						</thead>	
						<tbody>
						<?php
						foreach ($dataLaporan as $key => $value) {
							echo '<tr>';
							echo '<td>'.$value['tgl'].'</td>';
							echo '<td>'.$value['invoice_no'].'</td>';
							echo '<td>'.$value['uraian'].'</td>';
							echo '<td>'.number_format($value['debit']).'</td>';
							echo '<td>'.number_format($value['kredit']).'</td>';
							echo '</tr>';
						}
						?>
						</tbody>
						<tfoot>
						<tr>
					            <th ><?= $this->lang->line('tanggal') ?></th>
								<th ><?= 'No.Bukti' ?></th>
					            <th ><?= $this->lang->line('keterangan') ?></th>
					            <th ><?= 'Diterima' ?></th>
					            <th ><?= 'Disetor' ?></th>
						</tr>
						</tfoot>
						</table>
					</div>
					</div>
				</div>
			</div>
			<div class="tab-pane p-t-20" id="section-penerimaan" role="tabpanel">
				<div class="row">
				<div class="col-md-12">
					    <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
					    <div class="btn-group  mb-2 mb-md-0" role="group" aria-label="First group">
					        <button type="button" class="btn btn-secondary" onClick="printTable($('#report_area2'));"><i class="mdi mdi-printer"></i></button>
					        <!-- <button type="button" class="btn btn-secondary"  onClick="printTable($('#example231'));"><i class="mdi mdi-file-excel"></i></button> -->
					        <button type="button" class="btn btn-secondary"  onClick="pdfTable($('#report_area2'));"><i class="mdi mdi-file-pdf"></i></button> 
					    </div>
					    </div>
					</div>  
					<div class="col-md-12">
						<div class="table-responsive m-t-5"  style="background-color:#767779;padding: 10px; ">
    					<table id="report_area2" class="table table-bordered no-wrap"  style="background-color:white; ">
							<thead>	
								<tr>
										<th ><?= $this->lang->line('tanggal') ?></th>
										<th ><?= 'No.Bukti' ?></th>
										<th ><?= $this->lang->line('keterangan') ?></th>
										<th ><?= 'Diterima' ?></th>
								</tr>
							</thead>	
							<tbody>
								<?php
								foreach ($dataLaporan as $key => $value) {
									if($value['debit']!=0){

										echo '<tr>';
										echo '<td>'.$value['tgl'].'</td>';
										echo '<td>'.$value['invoice_no'].'</td>';
										echo '<td>'.$value['uraian'].'</td>';
										echo '<td>'.number_format($value['debit']).'</td>';
										echo '</tr>';
									}
								}
								?>
							</tbody>
							<tfoot>
								<tr>
										<th ><?= $this->lang->line('tanggal') ?></th>
										<th ><?= 'No.Bukti' ?></th>
										<th ><?= $this->lang->line('keterangan') ?></th>
										<th ><?= 'Diterima' ?></th>
								</tr>
							</tfoot>
						</table>
					</div>
					</div>
				</div>
			</div>
			<div class="tab-pane p-t-20" id="section-Pengeluaran" role="tabpanel">
				<div class="row">
					<div class="col-md-12">
					    <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
					    <div class="btn-group  mb-2 mb-md-0" role="group" aria-label="First group">
					        <button type="button" class="btn btn-secondary" onClick="printTable($('#report_area3'));"><i class="mdi mdi-printer"></i></button>
					        <!-- <button type="button" class="btn btn-secondary"  onClick="printTable($('#example231'));"><i class="mdi mdi-file-excel"></i></button> -->
					        <button type="button" class="btn btn-secondary"  onClick="pdfTable($('#report_area3'));"><i class="mdi mdi-file-pdf"></i></button> 
					    </div>
					    </div>
					</div>  
					<div class="col-md-12">
						<div class="table-responsive m-t-5"  style="background-color:#767779;padding: 10px; ">
    					<table id="report_area3" class="table table-bordered no-wrap"  style="background-color:white; ">
							<thead>	
								<tr>
										<th ><?= $this->lang->line('tanggal') ?></th>
										<th ><?= 'No.Bukti' ?></th>
										<th ><?= $this->lang->line('keterangan') ?></th>
										<th ><?= 'Disetor' ?></th>
								</tr>
							</thead>	
							<tbody>
								<?php
								foreach ($dataLaporan as $key => $value) {
									if($value['kredit']!=0){
										echo '<tr>';
										echo '<td>'.$value['tgl'].'</td>';
										echo '<td>'.$value['invoice_no'].'</td>';
										echo '<td>'.$value['uraian'].'</td>';
										echo '<td>'.number_format($value['kredit']).'</td>';
										echo '</tr>';
									}
								}
								?>
							</tbody>
							<tfoot>
								<tr>
										<th ><?= $this->lang->line('tanggal') ?></th>
										<th ><?= 'No.Bukti' ?></th>
										<th ><?= $this->lang->line('keterangan') ?></th>
										<th ><?= 'Disetor' ?></th>
								</tr>
							</tfoot>
						</table>
					</div>
					</div>
				</div>
			</div>
		</div>


</div>

 



</div>
</div>

<script type="text/javascript" charset="utf-8">
var oTable;
var oDialog;

$(document).ready(function() {
 


$(function () {
var table = $('#example23debit').DataTable({
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
	dom: 'Bfrtip',
	buttons: [
        {
            text: 'Print',
            action: function ( dt ) {
            	var $header = '<h1 align="center">Laporan Penerimaan Bank</h1>'; 
                printTable($('#example23debit'),$header );
            }
        },
        { extend: 'excelHtml5', footer: true },
        {
            text: 'PDF',
            action: function ( dt ) {
                pdfTable($('#example23debit'));
            }
        }
    ]
	});
});

$(function () {
var table = $('#example23kredit').DataTable({
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
	dom: 'Bfrtip',
	buttons: [
        {
            text: 'Print',
            action: function ( dt ) {
                var $header = '<h1 align="center">Laporan Pengeluaran Bank</h1>'; 
                printTable($('#example23kredit'),$header );
            }
        },
        { extend: 'excelHtml5', footer: true },
        {
            text: 'PDF',
            action: function ( dt ) {
                pdfTable($('#example23kredit'));
            }
        }
    ]
	});
});


	$("#ttl").show();
	$("#dbt").hide();
	$("#krt").hide();
  $("#_total").click(function(){
	document.getElementById("_total").className = "nav-link active";
	document.getElementById("_debit").className = "nav-link";
	document.getElementById("_kredit").className = "nav-link";
    $("#ttl").show();
	$("#dbt").hide();
	$("#krt").hide();
  });
  $("#_debit").click(function(){
	document.getElementById("_debit").className = "nav-link active";
	document.getElementById("_total").className = "nav-link";
	document.getElementById("_kredit").className = "nav-link";
    $("#ttl").hide();
	$("#dbt").show();
	$("#krt").hide();
  });
  $("#_kredit").click(function(){
	document.getElementById("_kredit").className = "nav-link active";
	document.getElementById("_debit").className = "nav-link";
	document.getElementById("_total").className = "nav-link";
    $("#ttl").hide();
	$("#dbt").hide();
	$("#krt").show();
  });


});

</script>
<?php 
//load function fot custom datatable button
$this->load->view("template/data_table_button");
?>