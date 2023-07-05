
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
<div class="post-body">
<div class="row">
					<div class="col-md-12">
					
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
										echo '<td>'.anchor(site_url()."purchasing/purchasing_aset_detail_debt/".$row->supplierID."/".$row->iddebt."/".$row->idenID."/".$row->utangID, '<button class="btn btn-primary">Detail</button').'</td>'; 							
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
