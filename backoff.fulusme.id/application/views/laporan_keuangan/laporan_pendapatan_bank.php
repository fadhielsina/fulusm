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

<br/><br/>
<div class="col-lg-12"><h3 class="badge badge-info"><i class="fa fa-windows"></i> 	Laporan Pendapatan</h3></div>

<div class="post-body">
	<center>
<b>PT. FRIGIA AIRCONDITIONING  - <?php echo strtoupper($address);?></b><br/>
	<b>LAPORAN TRANSAKSI ( <?php echo strtoupper($nameper);?> ) - PENDAPATAN</b>
	</center>
	<br/><br/>
			<div class="col-lg-12">	
	<div class="panel panel-info">
  <div class="panel-heading">FILTER DATA</div>
  <div class="panel-body">
	
	<?php echo form_open('laporan_keuangan/lap_pendapatan_bank'); ?>	
	<?php if($this->session->userdata('ADMIN')) { ?>
	<?php echo form_label('Lokasi Kantor *','lokasi'); ?>
	<select name="lokasi">
 <option value=" " >- Semua Lokasi -</option>	
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
			
	<?php } ?>&nbsp;&nbsp;
	<?php echo form_label('Jenis Bayar *','Jenis'); ?>
	<select name="jns_byr">	
		<option value="0">Semua</option>
		<option value="1">Cash</option>
		<option value="2">Bank</option>
	</select>
	&nbsp;&nbsp;
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
		 <button type="submit" name="submit" class="btn btn-warning btn-xs" value="filter">FILTER </button>
		<button type="submit" name="submit" class="btn btn-primary btn-xs" value="pdf" target="_blank"> PDF</button>
		<button type="submit" name="submit" class="btn btn-success btn-xs" value="excel" target="_blank" style="color:#000;"> Excel</button>
	
<?php echo form_close(); ?>
	</div>
	</div>
	</div>
	<br/><br/>
	<div class="col-lg-12">
	<div class="panel panel-info">
  <div class="panel-heading"><i class="fa fa-th-list"></i> DETAIL DATA</div>
  <div class="panel-body">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
  <thead>
  <tr>
  <th rowspan="2" scope="colgroup" style="text-align: center;">Tanggal</th>
    <th  rowspan="2" scope="colgroup" style="text-align: center;"> No. Jurnal</th>
    <th  rowspan="2" scope="colgroup" style="text-align: center;"> No. Invoice</th>
	<th rowspan="2" scope="colgroup" style="text-align: center;">Keterangan</th>
	<th rowspan="2" scope="colgroup" style="text-align: center;">Jenis Pembayaran</th>
	<th rowspan="2" scope="colgroup" style="text-align: center;">Nilai Invoice</th>
    <th colspan="2" scope="colgroup" style="text-align: center;">Biaya Administrasi</th>
    <th rowspan="2" scope="colgroup" style="text-align: center;">Jumlah Netto</th>
  </tr>
  <tr>
    <th scope="col" style="text-align: center;">%</th>
    <th scope="col" style="text-align: center;">Jumlah</th>
   
  </tr>
  </thead>
  <tbody>
		<?php 
			if($datapen)
			{
				$netto='';
				$netto_tot='';
				$inv='';
				foreach ($datapen->result() as $row) 
				{ 
			
					$netto=$row->trxTotal-$row->trxbankadmin;
					$netto_tot=$netto_tot+$netto;
					$inv=$inv+$row->trxTotal;
					echo '<tr>';
					echo '<td>'.mediumdate_indo($row->trxDate).'</td>';
					echo '<td>'.$row->no.'</td>';
					echo '<td>'.$row->invoiceID.'</td>';
					echo '<td>'.$row->ket_jurnal.'</td>';
					echo '<td>'.$row->nm_tipe.'</td>';
					echo '<td style="text-align: right;">'.number_format($row->trxTotal).'</td>';	
					echo '<td style="text-align: right;"></td>';	
					echo '<td style="text-align: right;">'.number_format($row->trxbankadmin).'</td>';	
					echo '<td  style="text-align: right;">'.number_format($netto).'</td>';	
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
	<td><h5><?php if($inv) { echo number_format($inv); } ?></h5></td>
	<td></td><td></td>
	<td><h5><?php if($netto) { echo number_format($netto_tot); } ?></h5></td>
	</tr>
	</tfoot>
</table>	
</div>
</div>
</div>		
