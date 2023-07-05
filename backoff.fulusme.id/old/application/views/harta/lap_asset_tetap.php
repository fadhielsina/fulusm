<br/>
<div class="post-title col-lg-12"><h3 class="pull-left"><?php echo $title; ?></h3></div>
<br/><br/>
		<div class="col-lg-12">		
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>		
	</div>
	<div class="col-lg-12">
  
	<div class="card">
		<div class="card-body">
			<?php echo form_open( $form_action, array( 'id' => 'form_kas_penerimaan' ) ); ?>

				<table cellpadding="2" cellspacing="0" style="width:100%;height: auto;" class="m-b-15">					
					<?php if( $this->session->userdata('IDENTITY_ID') > 1 ): ?>
						<input type="hidden" name="lokasi" id="lokasi" value="<?php echo $this->session->userdata('IDENTITY_ID'); ?>">
					<?php else: ?>
						<tr>
							<td><?php echo form_label('Lokasi','lokasi'); ?></td>
							<td>
								<?php echo form_dropdown('lokasi', $lokasi, $selected_lokasi ,array('class' => 'form-control', 'id' => 'lokasi')); ?>
							</td>
							<td></td>
						</tr>
					<?php endif; ?>

					<tr>
						<td><?php echo form_label('Per Tanggal','tgl_laporan'); ?></td>
						<td >
							<div class="input-daterange input-group" >
								<input type="text" class="input-sm form-control" name="start_date" id="start" value="<?php echo $tanggal1; ?>" autocomplete="off" />
							</div>
						</td>
					</tr>
				</table>

				<div class="buttons">
					<input type="hidden" id="cetak_type" name="cetak_type" value="">
					<?php
						echo form_button(array('id' => 'button-save', 'type' => 'submit', 'content' => $this->lang->line('buat_laporan')));
						echo form_button('reset','Reset', "id = 'button-reset'" );
					?>
					<button id="spinner-loader" class="btn btn-primary" type="button" disabled="" style="display:none;">
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                      Loading...
                    </button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>

  <div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table_kas">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Asset</th>
				<th>Tanggal Perolehan</th>
				<th>Nilai Perolehan</th>
				<th>Nilai Residu</th>
				<th>Masa Ekonomis</th>
				<th>Akumulasi Penyusutan</th>
				<th>Nilai Buku</th>
			</tr>
		</thead>						
		<tbody>
			<?php foreach( $data as $no => $d ): 
				if ( $d->detailBuyPrice > 0 && $d->residu > 0 && $d->umur_ekonomis > 0) {
					$nilai_penyusutan = ( (int) $d->detailBuyPrice - (int) $d->residu ) / (int) $d->umur_ekonomis;
				} else {
					$nilai_penyusutan = 0;
				}
				?>
			<tr>
				<td><?php echo $no+1; ?></td>
				<td><?php echo $d->detailBuyName; ?></td>
				<td><?php echo $d->trxDate; ?></td>
				<td><?php echo number_format( $d->detailBuyPrice ); ?></td>
				<td><?php echo number_format( $d->residu ); ?></td>
				<td><?php echo $d->umur_ekonomis; ?></td>
				<td><?php echo number_format( $nilai_penyusutan ); ?></td>
				<td><?php echo number_format( $nilai_penyusutan ); ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>			
</div>			
</div>			
</div>						 

<script type="text/javascript">
	var dtable_init;
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

	dtable_init = $('#display_table_kas').DataTable({
		"ordering": true, // Set true agar bisa di sorting
		"order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
		language: {
			"decimal": ",",
			"thousands": "."
		},
		dom: 'Bfrtip',
		 buttons: [
			//{ extend: 'print', footer: true },
			{
				text: 'Print',
				action: function ( dt ) {
					printTable($('#display_table_kas'));
				}
			},
			{
				text: 'PDF',
				action: function ( dt ) {
					pdfTable($('#display_table_kas'));
				}
			},
			{ extend: 'excelHtml5', footer: true, messageTop: headerStack }
		],
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	});

	} );
</script>