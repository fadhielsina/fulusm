<script type="text/javascript" charset="utf-8">
	$(function() {
		$('#button-save').click(function() {
			var bln = $('#bulan').val();
			var thn = $('#tahun').val();
			oTable.fnClearTable();
			$.post('<?php echo site_url().'invoice/search' ?>',
				  { bulan : bln, tahun : thn},
				  function(msg){
					if(msg) {
						msg = eval(msg);
						oTable.fnAddData(msg);
					}
				  }
			  );
		});
	});
</script>


<div class="col-lg-12">

	<div class="card card-outline-info">
        <div class="card-header">
            <h4 class="mb-0 text-white">Filter Data</h4></div>
        <div class="card-body">
            
        	<?php echo form_open('invoice/invoice_piutang'); ?>	
				
				<div class="row">
					
					<div class="col-4">
					<?php echo form_label($this->lang->line('tanggal_awal'),'tanggal'); ?> : 
					<?php 
						$datatgl['name'] = 'tanggal1';
						$datatgl['type'] = 'date';
						$datatgl['value'] = $tanggal1;
						$datatgl['class']="form-control";
						
							echo form_input($datatgl);
					?>
					</div>
					<div class="col-4">
					<?php echo form_label($this->lang->line('tanggal_akhir'),'tanggal'); ?> : 
					<?php 
						$datatgl['name'] = 'tanggal2';
						$datatgl['type'] = 'date';
						$datatgl['value'] = $tanggal2;
						$datatgl['class']="form-control";
						echo form_input($datatgl);
					?>
					</div>
					<div class="col-4 align-middle pt-4">
					 	<button type="submit" name="submit" class="btn btn-info btn-sm" value="filter"><i class="fa fa-search"></i> <?= $this->lang->line('filter_data') ?></button>
					</div>
				</div>	
			<?php echo form_close(); ?>

        </div>
    </div>

<div class="card card-outline-info">

	<div class="card-header">
   		<h4 class="mb-0 text-white"><i class="fa fa-th-list"></i> <?= $this->lang->line('detail_data') . ' Invoice : ' ?> <?php echo isset( $journal_data[0] ) ? $journal_data[0]->trxFullName : ''; ?></h4>
    </div>
  <div class="card-body">
<div class="post-body">
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	
	$data['class'] = 'input';
?>
	<?php echo $this->session->flashdata('message'); ?>
		<div class="col-lg-12">
	<div class="panel panel-info">
  <div class="panel-body">
	<table cellpadding="0" cellspacing="0" border="0" class="table table-responsive" id="display_member_table_check">
	<thead>
		<tr>
			<th class="no-print"><i class="fa fa-th-list"></i></th>
			<th class="no-print">ID Piutang</th>
			<th style="width: 130px"><?= $this->lang->line('tgl_pencatatan') ?></th>
			<th style="width: 140px">No Invoice</th>
			<!-- <th>No. SPK/BPBB</th> -->
			<th>Jasa </th>
			<th>Sparepart </th>
			<th><?= $this->lang->line('keterangan') ?> </th> 
			<th><?= $this->lang->line('nominal') ?> </th>
			<th>Status </th>
			<th class="no-print"></th>			
		</tr>
	</thead>
	<tbody>
		<?php 
			if($journal_data)
			{
				foreach ($journal_data as $row) 
				{ 
					$statuslunas='';
					if($row->statuslunas=='2')
					{
						$statuslunas="<span class='label label-success'>Lunas</span>";
					}
					else
					{
						$statuslunas="<span class='label label-danger'>Belum Lunas</span>";
					}

					echo '<tr>';
					echo '<td class="no-print"></td>';
					echo '<td class="no-print">'. $row->receivableID .'</td>';
					echo '<td>'.$row->trxDate.'</td>';
					echo '<td>'.$row->invoiceID.'</td>';
					//echo '<td>'.$row->invoiceIDmanual.'</td>';
					echo '<td>'.number_format($row->trxJasaTotal).'</td>';	
					echo '<td>'.number_format($row->trxSparepartTotal).'</td>';	
					echo '<td>'.$row->note.'</td>'; 		
					echo '<td>'.number_format($row->trxTotal - $row->trxPay).'</td>';	
					echo '<td>'.$statuslunas.'</td>';	
					echo '<td class="no-print">'.anchor(site_url()."invoice/invoice_pay_termin/".$row->invoiceID, 'Detail').'</td>'; 							
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
</div>		
</div>


<!-- Modal -->
<div class="modal fade" id="memberPiutangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pembayaran a/n <?php echo isset( $journal_data[0] ) ? $journal_data[0]->trxFullName : ''; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open('invoice/bulk_termin_pay_data', array('id' => 'jurnal_member_piutang_form')); ?>	
      <div class="modal-body">
      	<label>Untuk Invoice(s): </label>
      	<ul id="invoice-list" class="list-group form-group">
      		<li class="list-group-item" style="color:red;">Pilih invoice yang akan dibayar</li>
      	</ul>

      	<input type="hidden" name="nomor_cust" value="<?php echo $nomor_cust; ?>">
      	<div class="form-group row">
			<div class="col">
				<label>Jumlah Bayar</label>
			</div>
			<div class="col">
				<input type="text" name="jumlah_bayar" id="m_jumlah_bayar" class="form-control col" placeholder="Masukan jumlah nominal" onchange="formatNumber(this);" onkeyup="formatNumber(this);" required="">
			</div>
		</div>
		<div class="form-group row">
			<div class="col">
				<label>Jenis Pembayaran</label>
			</div>
			<div class="col">
			<select class="form-control" name="jns_bayar" id="jns_bayar" required="">
				<?php
				 foreach ($jenisbyr as $jenisbyr): ?>
				 <option value="<?php echo $jenisbyr->id; ?>" ><?php echo $jenisbyr->id; ?> - <?php echo $jenisbyr->name ?></option>
				 <?php endforeach ?>
              </select>
            </div>
		</div>
		<div class="form-group row">
			<div class="col">
				<label>Pilih Akun</label>
			</div>
			<div class="col">
				<?php
				echo form_dropdown('akun_kas_bank', $accounts, '' , array(
					'class' => 'form-control',
					'required' => true
				));
				?>
			</div>
		</div>
		<div class="form-group row">
			<div class="col">
				<label>Status Bayar</label>
			</div>
			<div class="col">
				<input type="checkbox" name="stsbyr" value="2" style="position: inherit !important;left: 0px !important;opacity: unset;"> Lunas
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Bayar</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>		


<script type="text/javascript">
	var memTable;
	$(document).ready(function(){
		memTable =  $('#display_member_table_check').DataTable({
	            columnDefs: [{
	                    orderable: false,
	                    className: 'select-checkbox',
	                    targets:   0,
	                },
	                {
	                "targets": [ 1 ],
		                "visible": false,
		                "searchable": false
		            }
	            ],
	            select: {
	                style:    'os',
	                selector: 'td:first-child',
	                style: 'multi'
	            },
			dom: 'Bfrtip',
			buttons: [
			  { 
	            extend: 'excelHtml5', 
	            footer: true, 
	            messageTop: headerStack
	          }, {
	                text: 'PDF',
	                action: function ( dt ) {
	                    pdfTable($("#display_table_check"));
	                }
	            }, //{ extend: 'print', footer: true },
	            {
	                text: 'Print',
	                action: function ( dt ) {
	                    printTable($("#display_table_check"));
	                }
	            },
	            'selectAll','selectNone',
	            {
                text: 'Bayar',
	                action: function ( e, dt, node, config ) {
	                    $('#memberPiutangModal').modal('show');
	                }
	            }
			],
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});

		$('#memberPiutangModal').on('show.bs.modal', function (e) {
			var data = memTable.rows({selected:true}).data(),
				invoice = [],
				total = 0;

			if ( data.length ) {
				$.each(data, function(k, v){
					var tot = parseInt( v[7].replace(/,/g, '') );
					invoice.push('<li class="list-group-item"><input type="hidden" name="trx_total[]" value="'+ tot +'"><input type="hidden" name="piutang_id[]" value="'+ v[1] +'"><input type="hidden" name="inv_id[]" value="'+ v[3] +'">'+ v[3]+ '</li>');
					total += tot;
				});
				$('#invoice-list').html(invoice.join(''));
				$('#m_jumlah_bayar').val(total).trigger('change');
			}
		});
	});
	function formatNumber(input)
	{
	    var num = input.value.replace(/\,/g,'');
	    if(!isNaN(num)){
	    if(num.indexOf('.') > -1){
	    num = num.split('.');
	    num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
	    if(num[1].length > 2){
	    alert('You may only enter two decimals!');
	    num[1] = num[1].substring(0,num[1].length-1);
	    } input.value = num[0]+'.'+num[1];
	    } else{ input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'') };
	    }
	    else{ alert('Anda hanya diperbolehkan memasukkan angka!');
	    input.value = input.value.substring(0,input.value.length-1);
	    }
	}
</script>