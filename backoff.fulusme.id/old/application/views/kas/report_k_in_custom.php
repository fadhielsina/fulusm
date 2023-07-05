
		<div class="col-lg-12">		
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	$saldo_show = $saldo[0]->saldo;
	$periode_text = sprintf( 'Periode: %s s.d %s', $tanggal1 ? $tanggal1 : '-', $tanggal2 ? $tanggal2 : '-');
	$print_header = '<p style="text-align:center;">Katingan</p><p style="text-align:center;">RSUD Mas Amsyar Kasongan</p><h3 style="text-align:center;">BUKU KAS BENDAHARA PENERIMAAN</h3><p style="text-align:center;">'. $periode_text .'</p>';
?>		
	</div>
	<div class="col-lg-12">

		<div class="card">
			<div class="card-body">
			<div class="post-title">
			<h4 class="card-title"><?php echo 'Report '. $title ?></h4>
			</div>
				<?php echo form_open('kas/report_kas_masuk'); ?>	
				<form id="form_laporan" method="POST"> 
					<table cellpadding="2" cellspacing="0" style="width:100%;height: auto;" class="m-b-15">					
						<tr>
							<th><?php echo form_label('Periode','tgl_laporan'); ?></th>
							<td >
								<div class="input-daterange input-group" >
								    <input type="text" class="input-sm form-control" name="start" id="start" value="<?php echo $tanggal1; ?>" autocomplete="off" />
								    <span class="input-group-addon">s.d</span>
								    <input type="text" class="input-sm form-control" name="end" id="end" value="<?php echo $tanggal2; ?>" autocomplete="off" />
								</div>
							</td>
						</tr>	
					</table>
				<div class="buttons">
					<?php
						echo form_button(array('id' => 'button-save', 'type' => 'submit', 'content' => $this->lang->line('buat_laporan')));
						echo form_button('reset','Reset', "id = 'button-reset'" );
					?>
				</div>
				</form>
			</div>
			</div>

<div id="content_area"></div>

  <div class="card card-outline-info">
  	<div class="card-header">
  		<h4 class="m-b-0 text-white"><?php echo $title; ?></h4>
  	</div>
  
  <div class="card-body">
  	<div class="card-title">
		<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
		<div class="btn-group  mb-2 mb-md-0" role="group" aria-label="First group">
		    <button type="button" class="btn btn-secondary" onClick="printTable($('#report_area'));"><i class="mdi mdi-printer"></i></button>
		    <button type="button" class="btn btn-secondary"  onClick="excelTable($('#report_area'));"><i class="mdi mdi-file-excel"></i></button>
		    <button type="button" class="btn btn-secondary"  onClick="pdfTable($('#report_area'));"><i class="mdi mdi-file-pdf"></i></button> 
		</div>
		</div>
	</div>
  	<h4 id="periode-text" class="card-title">
  		<?php echo $periode_text; ?>		
  	</h4>
  	<div class="table-responsive m-t-5"  style="background-color:#767779;padding: 10px; ">
	<table id="report_area" cellpadding="0" cellspacing="0" border="0" class="table no-wrap display"  style="background-color:white">
		<thead>
			<tr>
				<th><?= $this->lang->line('tanggal') ?></th>
				<th>No.Bukti</th>
				<th><?= $this->lang->line('keterangan') ?></th>
				<th><?= $this->lang->line('diterima') ?></th>
				<th><?= $this->lang->line('disetor') ?></th>
				<th><?= $this->lang->line('saldo') ?></th>
			</tr>
		</thead>						
		<tbody>

			<?php
				if($kas_data)
				{
					$saldo_init = $saldo[0]->saldo;
					$income = 0;
					$outcome = 0;
					foreach( $kas_data as $row ) {
						if ( $row->type == 1 ) {
							$outcome += $row->jumlah;
						} else if ( $row->type == 2) {
							$income += $row->jumlah;
						}
					}
					//$saldo_show = 0;
					$saldo_show = $saldo_show - ( $income - $outcome );
					?>
					<tr>
						<td></td>
						<td></td>
						<td>SALDO</td>
						<td><?php echo number_format( $saldo_show ); ?></td>
						<td></td>
						<td><?php echo number_format( $saldo_show ); ?></td>
					</tr>
					<?php
					
					foreach ($kas_data as $row)
					{
						
						if ( $row->type == 1 ) {
							$pengeluaran = ($row->jumlah);
							$pemasukan = 0;
							$saldo_show -= abs( $pengeluaran );
						} else if ( $row->type == 2) {
							$pemasukan = ($row->jumlah);
							$pengeluaran = 0;
							$saldo_show += $pemasukan;
						} else{
							$pengeluaran =0;
							$pemasukan = 0;
						}
						
						echo '<tr>';
						echo '<td>'.date('d/m/Y', strtotime( $row->tgl_catat ) ).'</td>';
						echo '<td>'.$row->no.'</td>';
						echo '<td>'.$row->keterangan.'</td>';
						echo '<td>'.number_format($pemasukan).'</td>';
						echo '<td>'.number_format($pengeluaran).'</td>';
						echo '<td>'.number_format($saldo_show).'</td>';
						echo '</tr>';
					}
				}
			?>	
		</tbody>
	</table>
	</div>
</div>			
</div>			
</div>			
</div>			


<script type="text/javascript">
	$( function() {
	    var dateFormat = "yyyy/mm/dd",
	      from = $( "#start" )
	        .datepicker({
	          defaultDate: "+1w",
	          changeMonth: true,
	          numberOfMonths: 1
	        })
	        .on( "change", function() {
	          to.datepicker( "option", "minDate", getDate( this ) );
	        }),
	      to = $( "#end" ).datepicker({
	        defaultDate: "+1w",
	        changeMonth: true,
	        numberOfMonths: 1
	      })
	      .on( "change", function() {
	        from.datepicker( "option", "maxDate", getDate( this ) );
	      });
	 
	    function getDate( element ) {
	      var date;
	      try {
	        date = $.datepicker.parseDate( dateFormat, element.value );
	      } catch( error ) {
	        date = null;
	      }
	 
	      return date;
	    }
	    
	    var headerStack = [ 'Katingan', 'RSUD Mas Amsyar Kasongan', 'BUKU KAS BENDAHARA PENERIMAAN', '<?php echo $periode_text; ?>'],
	    	myTable = $('#example231').dataTable({
			language: {
	            "decimal": ",",
	            "thousands": "."
	        },
			dom: 'Bfrtip',
			 buttons: [
	            {
		            text: 'Print',
		            action: function ( dt ) {
		                printTable($('#example231'));
		            }
		        },
	            { 
	            	extend: 'excelHtml5', 
	            	footer: true, 
	            	messageTop: headerStack
	            },
	            {
		            text: 'PDF',
		            action: function ( dt ) {
		                pdfTable($('#example231'));
		            }
		        }
	        ],
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
	} );
</script>