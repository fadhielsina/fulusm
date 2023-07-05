
		<div class="col-lg-12">		
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	$saldo_show = 0;
	$periode_text = sprintf( 'Per Tanggal: %s', $tanggal1 );
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
					<table cellpadding="2" cellspacing="0" style="width:100%;height: auto;" class="m-b-15">					
						<tr>
							<th><?php echo form_label('Per Tanggal','tgl_laporan'); ?></th>
							<td >
								<div class="input-daterange input-group" >
                                    <input type="text" class="input form-control-sm" name="start" id="start" value="<?php echo $tanggal1; ?>" autocomplete="off" />
									<span class="input-group-addon">s.d</span>
									<input type="text" class="input form-control-sm" name="end" id="end" value="<?php echo $tanggal2; ?>" autocomplete="off" />					
								</div>
							</td>
						</tr>	
                        <div class="col-4 mt-4">
                        <tr>
                            <th><?php echo form_label('Akun Kas/Bank'); ?></th>
                            <td>
                                    <?php
                                        $data['name'] = 'nama'; 
                                        $data['id'] = 'nama';
                                        $data['class'] = "form-control col-6";
                                        $selected = 'all';
                                        echo form_dropdown('nama', $akun, $selected ,$data); ?>
                            </td>				
                        </tr>
                        </div>
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

		<div id="laporan-card" class="card" style="display: none;">
			<div class="card-body">
				<div class="btn-group mb-2 mr-2" role="group">
                    <button type="button" class="btn btn-secondary font-18 btn-laporan-export" data-export="print" title="Print"><i class="mdi mdi-printer"></i></button>
                    <!-- <button type="button" class="btn btn-secondary font-18 btn-laporan-export" data-export="excel" title="Excel"><i class="mdi mdi-file-excel"></i></button> -->
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


	    var cetak_type = 'view';
		$('#laporan-iframe').on('load', function(){
			$('#spinner-loader').hide();
			$('#laporan-card').slideDown();
			$(this).height($(this)[0].contentWindow.document.body.scrollHeight + 60 +'px' );
		});
		
		$('#form_laporan').on('submit', function( event ){
			if ( 'view' === cetak_type ) {
				event.preventDefault();
				$('#spinner-loader').show();
				$('#laporan-card').slideUp();
				$.post($(this).prop('action'), $(this).serialize(),function(result){
					$("#laporan-iframe").prop('srcdoc', result);
				});
			}
		});

		$('.btn-laporan-export').on('click', function( event ){
			event.preventDefault();
			var type = $(this).data('export');

			if ( 'print' === type ) {
				$('#laporan-iframe')[0].contentWindow.print();
			}

			if ( 'pdf' === type ) {
				cetak_type = 'pdf';
				$('#cetak_type').val( cetak_type );
				$('#form_laporan').submit();

				cetak_type = 'view';
				$('#cetak_type').val( cetak_type );
			}
		});

	} );
</script>