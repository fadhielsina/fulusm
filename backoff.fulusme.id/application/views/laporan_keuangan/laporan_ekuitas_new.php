
		<div class="col-lg-12">		
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	$saldo_show = 0;
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
				<?php echo form_open( $form_action, array( 'id' => 'form_laporan' ) ); ?>
					<?php if( $this->session->userdata('IDENTITY_ID') > 1 ): ?>
							<input type="hidden" name="lokasi" id="lokasi" value="<?php echo $this->session->userdata('IDENTITY_ID'); ?>">
						<?php else: ?>
						<div class="form-group row m-b-10">
							<label class="col-sm-2 col-form-label">Lokasi</label>
						<div class="col-sm-3">
						<?php echo form_dropdown('lokasi', $lokasi, '' ,array('class' => 'form-control', 'id' => 'lokasi')); ?>
						</div>
						</div>
						<?php endif; ?>
					<table cellpadding="2" cellspacing="0" style="width:100%;height: auto;" class="m-b-15">					
						<tr>
							<th><?php echo form_label('Dari','tgl_laporan'); ?></th>
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