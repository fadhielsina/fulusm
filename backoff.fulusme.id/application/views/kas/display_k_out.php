<br/>
<div class="post-title col-lg-12"><h3 class="pull-left"><?php echo $title; ?></h3>
<div class="pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success', 'content' => $this->lang->line('tambah'), 'onClick' => "location.href='".site_url()."kas/add_kas_out'" ));
		?>		
	</div>
</div>
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
					<tr>
						<?php if( $this->session->userdata('IDENTITY_ID') > 1 ): ?>
						<input type="hidden" name="lokasi" id="lokasi" value="<?php echo $this->session->userdata('IDENTITY_ID'); ?>">
						<?php else: ?>
						<td>Lokasi Kantor
							<?php echo form_dropdown('lokasi', $lokasi, '' ,array('class' => 'form-control', 'id' => 'lokasi')); ?>
						</td>
						<?php endif; ?>
						<td>Tanggal Awal
							<input type="text" class="input-sm form-control" name="start" id="start" value="<?php echo $tanggal1; ?>" autocomplete="off" />
						</td>
						<td>Tanggal Akhir
							<input type="text" class="input-sm form-control" name="end" id="end" value="<?php echo $tanggal2; ?>" autocomplete="off" />
						</td>
						<td><br>
							<?php
								echo form_button(array('id' => 'btn-filter-dtable', 'type' => 'button', 'content' => '<i class="fa fa-search"></i> Cari', 'class' => 'btn btn-info') );
							?>
						</td>
					</tr>	
				</table>
			<?php echo form_close(); ?>
		</div>
	</div>

 <div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table_kas">
		<thead>
			<tr>
				<th>No.Trx</th>
				<th><?= $this->lang->line('no_jurnal') ?></th>
				<th><?= $this->lang->line('tanggal') ?></th>
				<th><?= $this->lang->line('dibayar_kepada') ?></th>
				<th><?= $this->lang->line('sesuai_dokumen') ?></th>
				<th><?= $this->lang->line('no_dokumen') ?></th>
				<th>Total</th>
				<th class="no-print"></th>
			</tr>
		</thead>						
		<tbody></tbody>
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
		"processing": true,
		"serverSide": true,
		
		"ordering": true, // Set true agar bisa di sorting
		"order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
		"ajax":
		{
			"url": "<?php echo site_url('kas/kas_view_data_table') ?>", // URL file untuk proses select datanya
			"type": "POST",
			 "data": function ( data ) {
				data.tgl2 = $('#end').val();
				data.tgl1 = $('#start').val();
				data.lokasi = $('#lokasi').val();
				data.jns_trans = 'KK';
			 }
		},
		"deferRender": true,
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
		"sPaginationType": "full_numbers",
		"columns": [
			{ "data": "no_trx_kas" },
			{
				render: function( data, type, row ) {
					var html = '';
					if ( row.no ) {
						html = row.no;
					} else {
						html = '<b class="label label-danger">Belum Posting</b>';
					}
					return html;
				} 
			},
			{data: 'tgl_catat' },
			{data: 'kepada'},
			{data: 'dok'},
			{data: 'no_dok'},
			{data: 'jumlah'},
			{
				render: function( data, type, row ){
					html = '<div class="btn-group">'+
							'<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line('aksi') ?></button>'+
							'<div class="dropdown-menu">' +
								'<a class="dropdown-item" href="<?php echo site_url('kas/detail_data_out'); ?>/'+ row.id_trx +'">Detail</a>';
					if ( row.no ) {
						html += '<a class="dropdown-item" href="<?php echo site_url('kas/nota_out'); ?>/'+ row.id_trx +'" target="_blank">Nota</a>';
						var conf_label = "'<?= $this->lang->line('valid_hapus') ?> : "+ row.id_trx +" ?'";
						html += '<a class="dropdown-item" href="<?php echo site_url('kas/delete_data_kas'); ?>/'+ row.id_trx +'/kk" onclick="javascript: return confirm('+ conf_label +')"><?= $this->lang->line('hapus') ?></a>';
					}
					html += '</div></div>';
					return html;
				}
			}
			],
	});

	$('#btn-filter-dtable').click(function(){ //button filter event click
		dtable_init.ajax.reload();  //just reload table
	});

	} );
</script>