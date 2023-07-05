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

<div class="post-title col-lg-12"><h3 class="badge badge-info"><i class="fa fa-windows"></i> 	<?php echo $title; ?></h3>
<div class="col-lg-12">
  <div class="pull-right">
					<?php echo anchor(site_url()."invoice", '<i class="fa fa-backward"></i> Kembali ', 'class="btn btn-default"'); ?>
     </div>
	  </div>
</div>

<div class="post-body">
<div class="col-lg-12">	
	<div class="panel panel-info">
  <div class="panel-heading">FILTER DATA</div>
  <div class="panel-body">
	<?php echo form_open('invoice/invoice_kasir'); ?>	
		<div class="panel panel-info">
  <div class="panel-body">
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
												
			</select> &nbsp;&nbsp;&nbsp;
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
		 <button type="submit" name="submit" class="btn btn-info btn-sm" value="filter"><i class="fa fa-search"></i> FILTER DATA</button>
			</div>
			</div>
	
		
<?php echo form_close(); ?>
</div>
</div>
	</div>
	<?php echo $this->session->flashdata('message'); ?>
	<div class="col-lg-12">
	<div class="panel panel-info">
  <div class="panel-heading"><i class="fa fa-th-list"></i> DETAIL DATA</div>
  <div class="panel-body">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
	<thead>
		<tr>
			<th style="width: 60px">No. Invoice</th>
			<th style="width: 60px">Tanggal Invoice</th>
			<th>No. SPK/BPBB</th>
			<th>Customer</th>
			<th>Jasa </th>
			<th>Sparepart </th>
			<th>Diskon </th>
			<th>Jumlah </th>
			<th>Tot. Byr </th>
			<th>Sisa </th>
			<th>Lunas</th>
			<th></th>			
		</tr>
	</thead>
	<tbody>
		<?php 
			if($journal_data)
			{
				
				foreach ($journal_data as $row) 
				{ 
				  $sisabyr=$row->trxTotal-($row->totalbyr+$row->trxPay);
					$statuspost='';
					if($row->isfinish=='0')
					{
						$statuspost="<span class='label label-danger'>F</span>";
					}
					else
					{
						$statuspost="<span class='label label-success'>T</span>";
					}
					echo '<tr>';
					echo '<td>'.$row->invoiceID.'</td>';
					echo '<td>'.$row->trxDate.'</td>';
					echo '<td>'.$row->invoiceIDmanual.'</td>';
					echo '<td>'.$row->trxFullName.'</td>';
					echo '<td>'.number_format($row->trxJasaTotal).'</td>';	
					echo '<td>'.number_format($row->trxSparepartTotal).'</td>';	
					echo '<td>'.number_format($row->trxDiscount).'</td>';		
					echo '<td>'.number_format($row->trxTotal).'</td>';	
					echo '<td>'.number_format($row->totalbyr+$row->trxPay).'</td>';	
					echo '<td>'.number_format($sisabyr).'</td>';	
					echo '<td>'.$statuspost.'</td>';
					echo '<td>'.anchor(site_url()."invoice/invoice_pay/".$row->invoiceID, 'Detail', array('class' => 'btn btn-success btn-xs')).'</td>'; 							
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
