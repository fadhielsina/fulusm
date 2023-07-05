
	
	<?php
	$card_title = $nama_laporan;
	$card_title = isset( $nama_title_laporan ) ? $nama_title_laporan : $card_title;

	if($error != "")
	{
		echo '<div class="alert alert-danger">';
		echo $error;
		echo "</div>";
	}
	else
	{
		//echo "style='display:none'>";
?>	
	<div class="card card card-outline-info">
		<div class="card-header">
			<h4 class="m-b-0 text-white"><?php echo " ".strtoupper($card_title) ?></h4>
		</div>
		<div class="card-body">
			<div class="card-title">
			<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
				<div class="btn-group  mb-2 mb-md-0" role="group" aria-label="First group">
				    <button type="button" class="btn btn-secondary" onClick="printTable($('#report_area'));"><i class="mdi mdi-printer"></i></button>
				    <button type="button" class="btn btn-secondary" onClick="excelTable($('#report_area'));"><i class="mdi mdi-file-excel"></i></button>
				    <button type="button" class="btn btn-secondary"  onClick="pdfTable($('#report_area'));"><i class="mdi mdi-file-pdf"></i></button> 
				</div>
				</div>
			</div>
			<div><?php echo 'Periode : <b>'.$periode.'</b>' ?></div>
			<div><?php echo 'Poli : <b>'.$poli.'</b>' ?></div>
			<?php
			if($nama_laporan =="kasir"){
				echo '<div>Kasir : <b>'.$nama_kasir.'</b></div>';
			}

			?>
			<div>
				<?php 
                $laporan['dataLaporan'] = $dataLaporan;
                $laporan['start'] = $start;
                $laporan['end'] = $end;
                $laporan['jns_laporan'] = $jns_laporan;
                $this->load->view($main_content,$laporan);	
                ?>			
			</div>
		</div>
	</div>
	
<?php
}
	
?>	
	
