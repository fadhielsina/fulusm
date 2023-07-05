<div class="col-lg-12">
	<h3 class="badge badge-info"> <i class="fa fa-windows"></i> <?php echo $title; ?></h3>
</div>

<div class="post-body">

<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	
	$data['class'] = 'input';
?>
		<div class="col-lg-12">	
	<div class="card card-outline-info">
  <div class="card-header"><h4 class="mb-0 text-white">FILTER DATA 
  	<span class="pull-right">
		<?php echo anchor(site_url()."purchasing/purchasing_add", '<i class="fa fa-plus-square-o"></i> Tambah ', 'class="btn btn-success"'); ?>
	 </span></h4></div>
  <div class="card-body">
	<?php echo form_open('purchasing'); ?>	
		<div class="panel panel-info">
  			<div class="row">
	<?php if($this->session->userdata('ADMIN')) { ?>
			<div class="col-md-4">
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
			</div>
			<?php } ?>

			<div class="col-md-3">
			<?php echo form_label('Tanggal Awal','tanggal'); ?> : 
				<?php
					$datatgl['name'] = 'tanggal1';
					$datatgl['id'] = 'datepicker';
					$datatgl['class'] = 'datepicker form-control';	
						echo form_input($datatgl);
				?>
			</div>
			
			<div class="col-md-3">
				<?php echo form_label('Tanggal Akhir','tanggal'); ?> : 
				<?php 
					$datatgl['name'] = 'tanggal2';
					$datatgl['id'] = 'datepicker_end';
					echo form_input($datatgl);
				?>
			</div>
		 	<div class="col-md-2">
		 		<div>&nbsp;&nbsp;</div>
		 		<button type="submit" name="submit" class="btn btn-info btn-sm" value="filter"><i class="fa fa-search"></i> FILTER DATA</button>
			</div>

			</div>
		</div>
<?php echo form_close(); ?>
</div>
</div>
	</div>
	<div class="col-lg-12">
	<div class="card card-outline-info">
  		<div class="card-header"><h4 class="mb-0 text-white"><i class="fa fa-th-list"></i> DETAIL DATA</h4></div>
  		<div class="card-body">
	<?php echo $this->session->flashdata('message'); ?>
	<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped dataTable table-responsive" id="display_table">
	<thead>
		<tr>
			<th style="width: 60px">No. PO</th>
			<th style="width: 60px">Tgl</th>
			<th>Vendor</th>
			<th>Jumlah </th>
			<th >Note </th>
			<th>Tipe Bayar</th>
			<th>Jatuh Tempo</th>
			<th>Status</th>
			<th>No Jurnal</th>
			<th></th>			
		</tr>
	</thead>
	<tbody>
		<?php 
			if($journal_data)
			{
				
				foreach ($journal_data as $row) 
				{ 
					
					$is_update='';
					$statusbyr='';
					$menuup='';
					if($row->trxStatus=='2')
					{
						$statusbyr="<span class='label label-warning'>Termin</span>";
						$menuup='e';
					}
					else
					{
						$statusbyr="<span class='label label-info'>Cash</span>";
						$menuup='p';
					}
					if($row->is_update=='0'||$row->is_update==' '||$row->is_update==null)
					{
						$is_update="<span class='label label-success'>No</span>";
					}
					else
					{
						$is_update="<span class='label label-danger'>Yes</span>";
					}
					
					if($row->is_pay=='0')
					{
						$stslunas="<span class='label label-danger'>Belum Lunas</span>";
					}
					else
					{
						$stslunas="<span class='label label-success'>Lunas</span>";
					}
					
					echo '<tr>';
					echo '<td>'.$row->invoiceBuyID.'</td>';
					echo '<td>'.mediumdate_indo($row->trxDate).'</td>';
					echo '<td>'.$row->trxFullName.'</td>';
					echo '<td>'.number_format($row->trxTotal).'</td>';	
					echo '<td>'.$row->note.'</td>';	
					echo '<td>'.$statusbyr.'</td>';	
					echo '<td>'.mediumdate_indo($row->trxTerminDate).'</td>';
					echo '<td>'.$stslunas.'</td>';	
					echo "<td>";if($row->no_jurnal) {
					echo "<a href=".site_url()."jurnal/detail_jurnal_inv/".$row->invoiceBuyID." class='btn btn-success btn-xs'>".$row->no_jurnal;
					}
					echo "</td>";
					?>
					
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line('aksi') ?></button>
							<div class="dropdown-menu">
								<?php echo anchor(site_url()."purchasing/purchasing_detail/".$row->invoiceBuyID, 'Detail', array('class'=> 'dropdown-item')); ?>		
								<?php echo anchor(site_url()."purchasing/nota/".$row->invoiceBuyID, 'Nota' , array('target' => '_blank', 'class' => 'dropdown-item')); ?>	
								<a href="<?php echo site_url()."purchasing/delete_data_purchasing/".$row->trxID;?>" onclick="javascript: return confirm('Anda akan menghapus data : <?php echo $row->invoiceBuyID; ?> ?')" class="dropdown-item">Hapus</a>
							</div>
						</div>
				</td>
					<?php echo '</tr>';
				}
			}
		?>
	</tbody>	
</table>		

</div>	
</div>	
</div>	
</div>		
