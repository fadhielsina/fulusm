
	
	<?php

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
			<h4 class="m-b-0 text-white"><?php echo $title." ".strtoupper($nama_laporan) ?></h4>
		</div>
		<div class="card-body">
			<div><?php echo 'Periode : <b>'.$periode.'</b>' ?></div>
			<!-- <div><?php echo 'Asuransi : <b>'.$asuransi.'</b>' ?></div> -->
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
	
