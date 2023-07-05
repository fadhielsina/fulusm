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
				<div class="post-title">
					<h4 class="card-title"><?php echo 'Report '. $title ?></h4>
				</div>
				<?php echo form_open( $form_action, array( 'id' => 'form_laporan' ) ); ?>	
					<div class="form-group row m-b-10">
						<label class="col-sm-2 col-form-label">Per Tahun</label>
						<div class="col-sm-3">
							<?php 
								$datad['id'] = 'start_tahun';
								$datad['class'] = 'form-control';
								$selected = date("Y") ;
								echo form_dropdown('start_tahun', $years, $selected, $datad);
							?>
						</div>
					</div>

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

		<div id="laporan-card" class="card" style="display: none;">
			<div class="card-body">
				<div class="btn-group mb-2 mr-2" role="group">
                    <button type="button" class="btn btn-secondary font-18 btn-laporan-export" data-export="print" title="Print"><i class="mdi mdi-printer"></i></button>
                    <button type="button" class="btn btn-secondary font-18 btn-laporan-export" data-export="excel" title="Excel"><i class="mdi mdi-file-excel"></i></button>
                    <button type="button" class="btn btn-secondary font-18 btn-laporan-export" data-export="pdf" title="PDF"><i class="mdi mdi-file-pdf"></i></button>
                </div>

                <div id="laporan-iframe-container" class="laporan-iframe">
                	<iframe id="laporan-iframe" scrolling="no" frameborder="no"></iframe>
                </div><!-- /laporan-iframe -->

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
	} );
</script>