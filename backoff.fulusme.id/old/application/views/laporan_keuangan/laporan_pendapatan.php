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

<div class="post-body">
	<center>
	<b>PT. FRIGIA AIRCONDITIONING ( <?php echo strtoupper($nameper);?> ) - <?php echo strtoupper($address);?></b></br/>
	<b>LAPORAN TRANSAKSI KAS - PENDAPATAN</b>
	</center>
	<br/><br/>
	<div class="col-lg-12">	
	
	<?php echo form_open('laporan_keuangan/lap_pendapatan'); ?>	
	<?php if($this->session->userdata('ADMIN')) { ?>
	<?php echo form_label('Lokasi Kantor *','lokasi'); ?>
	<select name="lokasi">
			
			<?php
											 foreach ($lokasi_data as $lokasi_data):
											 if($lokasi_data->identityID==$this->session->userdata('IDENTITY_ID'))
											 {
												 ?>
												 <option value="<?php echo $lokasi_data->identityID ?>"  SELECTED ><?php echo $lokasi_data->identityName ?></option>
											 <?php } else { ?>
											 <option value="<?php echo $lokasi_data->identityID ?>" ><?php echo $lokasi_data->identityName ?></option>
											 <?php } ?>
											 <?php endforeach ?>
												
			</select>
			<br/>
	<?php } ?>
	<?php echo form_label('Tanggal Awal','tanggal'); ?> : 
	<?php 
					$datatgl['name'] = 'tanggal1';
					$datatgl['id'] = 'datepicker';
					
						echo form_input($datatgl);
				?>
	&nbsp;&nbsp;&nbsp;
	<?php echo form_label('Tanggal Akhir','tanggal'); ?> : 
	<?php 
					$datatgl['name'] = 'tanggal2';
					$datatgl['id'] = 'datepicker2';
					echo form_input($datatgl);
				?>
				&nbsp;&nbsp;&nbsp;
		 <button type="submit" name="submit" class="btn btn-warning btn-xs" value="filter">FILTER DATA</button>
		<button type="submit" name="submit" class="btn btn-primary btn-xs" value="pdf" target="_blank">EXPORT PDF</button>
	
<?php echo form_close(); ?>
	</div>
	<br/><br/><br/>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
  <thead>
  <tr>
  <th rowspan="2" scope="colgroup" style="text-align: center;">Tanggal</th>
    <th  rowspan="2" scope="colgroup" style="text-align: center;"> No. Jurnal</th>
    <th colspan="2" scope="colgroup" style="text-align: center;">No. Bukti</th>
	<th rowspan="2" scope="colgroup" style="text-align: center;">Keterangan</th>
	<th rowspan="2" scope="colgroup" style="text-align: center;">Debit</th>
    <th colspan="2" scope="colgroup" style="text-align: center;">Kredit</th>
    <th rowspan="2" scope="colgroup" style="text-align: center;">Saldo</th>
  </tr>
  <tr>
    <th scope="col" style="text-align: center;">No. Invoice</th>
    <th scope="col" style="text-align: center;">Bukti Setoran</th>
    <th scope="col" style="text-align: center;">Bank</th>
    <th scope="col" style="text-align: center;">Kas Pusat</th>
   
  </tr>
  </thead>
  <tbody>
  <tr>
  <td></td>
  <td></td>
   <td></td>
  <td></td>
   <td><b>Saldo Awal</b></td>
  <td></td>
   <td></td>
  <td></td>
   <td style="text-align: right;"><b><?php echo number_format($saldo); ?></b></td>
		<?php 
			if($datapen)
			{
				$sub='';
				$saldakhir='';
				$saldoawal=$saldo;
				foreach ($datapen->result() as $row) 
				{ 
			
					$saldoawal=$saldoawal+$row->nilai;
					$saldakhir=$saldoawal;
					$sub=$sub+$row->nilai;
					echo '<tr>';
					echo '<td>'.mediumdate_indo($row->trxDate).'</td>';
					echo '<td>'.$row->no.'</td>';
					echo '<td>'.$row->invoiceID.'</td>';
					echo '<td>'.$row->invoiceIDmanual.'</td>';
					echo '<td>'.$row->ket_jurnal.'</td>';
					echo '<td style="text-align: right;">'.number_format($row->nilai).'</td>';	
					echo '<td></td>';	
					echo '<td></td>';	
					echo '<td  style="text-align: right;">'.number_format($saldoawal).'</td>';	
					echo '</tr>';
				}
			}
		?>
	</tbody>	
	<tfoot>
	<tr>
	<td></td><td></td><td></td>
	<td></td>
	<td><h5>JUMLAH</h5></td>
	<td><h5><?php if($sub) { echo number_format($sub); } ?></h5></td>
	<td></td><td></td>
	<td><h5><?php if($saldakhir) { echo number_format($saldakhir); } ?></h5></td>
	</tr>
	</tfoot>
</table>	
</div>		
