<div class="card">
  <div class="card-header">
  	<?php
  	$this->load->view("template/header_report");
  	?>	
  	<h2>Bukti Setoran Kasir</h2>	
  </div>
  <div class="card-body">
	<table cellpadding="0" cellspacing="0" border="0" class="dataTable" id="datatable-cash">
		<thead>
			<tr>
				 
				<th><?= $this->lang->line('tanggal') ?></th> 
				<th>No Invoice</th> 
				<th><?= $this->lang->line('keterangan') ?></th>
				<th><?= $this->lang->line('total') ?></th>
				 
			</tr>
		</thead>

		<tbody>
			<?php 
				$totalSetoranCash = 0;
				if($journal_data_cash)
				{
					
					foreach ($journal_data_cash as $row) 
					{ 
						$totalSetoranCash +=abs($row->AMOUNT);
						echo '<tr>';
						 
						echo '<td>'.$row->tgl.'</td>'; 
						echo '<td>'.$row->invoice_no.'</td>'; 
						echo '<td>Penerimaan '.$row->CLASS.' Dari Pasien No '.$row->no.'</td>';
						echo '<td>'.number_format(abs($row->AMOUNT)).'</td>';
						  
						echo '</tr>';
					}
				}
			?>
		</tbody>	

		<tfoot>
			<tr>
				 
				<th colspan="3" align="right"><?= $this->lang->line('total') ?></th>
				<!-- <th>No</th>
				<th>No Invoice</th>
				<th>Payment Type</th>
				<th>Insurance Name</th>
				<th><?= $this->lang->line('keterangan') ?></th> -->
				<th><?= number_format($totalSetoranCash) ?></th>
				 
			</tr>
		</tfoot>
	</table>
	<table align="center" style="width:90%">
		<tr>
			<td  colspan="3" style="text-align:right;padding-top: 100px;">
				Kasongan , <?php echo date("d-m-y"); ?>
			</td>
		</tr>
		<tr>
			<td  width="30%" style="text-align:left;border-bottom: solid 1px #000;padding-top: 100px;">
				<?php
				$nip = "";
				if(count($bendahara)>0){
					echo 'Bendahara : '.$bendahara['nama'];
					$nip = $bendahara['nip'];
				}else{
					echo 'Bendahara : ';
				} ?> 
			</td>
			<td width="30%"></td>
			<td  width="30%" style="text-align:left;border-bottom: solid 1px #000;padding-top: 100px;">
				Kasir :  
			</td>
		</tr>  
		<tr>
			<td>NIP <span style="margin-left: 45px;">:<?php echo $nip ?></span></td>
			<td></td>
			<td>NIP <span style="margin-left: 10px;">: </span></td>
		</tr>	
	</table>
</div>
</div>