
		<div class="col-lg-12">		
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	$saldo_show = 0;
	$periode_text = sprintf( 'Periode: %s s.d %s', $tanggal1 ? $tanggal1 : '-', $tanggal2 ? $tanggal2 : '-');
	$column_text = sprintf( '%s - %s', $tanggal1, $tanggal2 );
	$print_header = '<p style="text-align:center;">Katingan</p><p style="text-align:center;">RSUD Mas Amsyar Kasongan</p><h3 style="text-align:center;">BUKU KAS BENDAHARA PENERIMAAN</h3><p style="text-align:center;">'. $periode_text .'</p>';
?>		
	</div>
	<div class="col-lg-12">

		<div class="card">
			<div class="card-body">
				<div class="post-title">
					<h4 class="card-title"><?php echo 'Report '. $title ?></h4>
				</div>
				<?php echo form_open( $form_action, array( 'id' => 'form_pendapatan' ) ); 
					if(!$this->session->userdata('ADMIN')):
				?>	
					<input type="hidden" name="lokasi" value="<?php echo $this->session->userdata('IDENTITY_ID'); ?>">
				<?php endif; ?>
				
					<table cellpadding="2" cellspacing="0" style="width:100%;height: auto;" class="m-b-15">					
						<tr>
							<?php if($this->session->userdata('ADMIN')): ?>
							<td>Lokasi Kantor
								<?php echo form_dropdown('lokasi', $lokasi, $selected_lokasi ,array('class' => 'form-control')); ?>
							</td>
							<?php endif; ?>
							<td>Tanggal Awal
								<input type="text" class="input-sm form-control" name="start" id="start" value="<?php echo $tanggal1; ?>" autocomplete="off" />
							</td>
							<td>Tanggal Akhir
								<input type="text" class="input-sm form-control" name="end" id="end" value="<?php echo $tanggal2; ?>" autocomplete="off" />
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
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table_pendapatan">
					<thead>
						<tr>
							<th class="th-head text-left">No</th>
							<th class="th-head text-left">Invoice</th>
							<th class="th-head text-left">Tanggal</th>
							<th class="th-head text-left">Pelanggan</th>
							<th class="th-head text-left">Total</th>
						</tr>
					</thead>						
					<tbody>
						<?php 
						$total = 0;
						foreach( $data as $no => $d ):
							$total += $d['trxTotal'];
						 ?>
							<tr>
								<td><?php echo $no+1; ?></td>
								<td><?php echo $d['invoiceID']; ?></td>
								<td><?php echo date('d F Y', strtotime( $d['trxInDate'] ) ); ?></td>
								<td><?php echo $d['trxFullName']; ?></td>
								<td><?php echo number_format( $d['trxTotal'] ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr><td colspan="3"></td><td class="bold border-top"><strong>TOTAL</strong></td><td class="bold border-top"><?php echo number_format( $total ); ?></td></tr>
					</tfoot>
				</table>
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

	var oTable = $('#display_table_pendapatan').dataTable({
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
                    printTable($('#display_table_pendapatan'));
                }
            },
            {
                text: 'PDF',
                action: function ( dt ) {
                    pdfTable($('#display_table_pendapatan'));
                }
            },
            { extend: 'excelHtml5', footer: true, messageTop: headerStack }
        ],
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                commaSeparateNumber(pageTotal)
            );
        }
	});

	} );
</script>