
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
		<div class="card">
		<div class="card-body">
			<?php echo form_open( $form_action, array( 'id' => 'form_kas_penerimaan' ) ); ?>
				<table cellpadding="2" cellspacing="0" style="width:100%;height: auto;" class="m-b-15">					
					<tr>
						<?php if( $this->session->userdata('IDENTITY_ID') > 1 ): ?>
						<input type="hidden" name="lokasi" id="lokasi" value="<?php echo $this->session->userdata('IDENTITY_ID'); ?>">
						<?php else: ?>
						<td>Unit Bisnis
							<?php echo form_dropdown('lokasi', $lokasi, '' ,array('class' => 'form-control col-md-4', 'id' => 'lokasi')); ?><input type="submit" value="Cari" class= 'btn btn-sm btn-info '  />
						</td>
						<?php endif; ?>
					</tr>	
				</table>
			<?php echo form_close(); ?>
		</div>
	</div>
<div class="card">
  <div class="card-body">
<div class="post-body">
<div class="row">
					<div class="col-md-12">
						<div class="buttons pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success', 'content' => 'Input Saldo Awal Utang', 'onClick' => "location.href='".site_url()."hutang/add_saldo'" ));
			
		?>	
	</div>
						<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
						<thead>
							<tr>
							    <th>No</th>
								<th>Nama</th>
								<th>Saldo <hr/>(awal  rp) </th>
								<th>Hutang </th>
								<th>Bayar</th>
								<th>Saldo  <hr/> (akhir  rp) </th>
								<th>Keterangan </th>
								<th></th>			
							</tr>
						</thead>
						<tbody>
							<?php 
								if($journal_data)
								{
									$i = 1;
									foreach ($journal_data as $row) 
									{ 
									$tot_utang=$row->totalbyr;
									$sisa=$row->totaltrx-$tot_utang;
										
										if($row->is_pay=='0' || $row->is_pay=="")
										{
											$stslunas="<span class='label label-danger'>".$this->lang->line('belum_lunas')."</span>";
										}
										else
										{
											$stslunas="<span class='label label-success'>".$this->lang->line('lunas')."</span>";
										}
										echo '<tr>';
										echo '<td>'.$i++.'</td>';
										echo '<td>'.$row->supplierName.'</td>';
										echo '<td>'.number_format($row->totaltrx).'</td>';	
										echo '<td>'.number_format($sisa).'</td>';
										echo '<td>'.number_format($row->totalbyr).'</td>';	
										echo '<td>'.number_format($sisa).'</td>';	
										echo '<td>'.$row->note.'</td>';	
										echo '<td>'.anchor(site_url()."purchasing/purchasing_detail_debt/".$row->supplierID."/".$row->iddebt."/".$row->idenID, '<button class="btn btn-primary">Detail</button').'</td>'; 							
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
