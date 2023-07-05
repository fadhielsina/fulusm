<br/>
<div class="col-lg-12">
<h3 class="pull-left"><i class="fa fa-windows"></i> 	<?php echo $title; ?></h3>
  <div class="pull-right">
					<?php echo anchor(site_url()."invoice/invoice_add", '<i class="fa fa-plus-square-o"></i> Tambah ', 'class="btn btn-sm  waves-effect waves-light btn-success"'); ?>
					<?php echo anchor(site_url()."invoice/invoice_kasir", '<i class="fa fa-pause"></i> Pending ', 'class="btn btn-sm  waves-effect waves-light btn-info"'); ?>
					<?php echo anchor(site_url()."invoice/invoice_piutang", '<i class="fa fa-money"></i> Piutang ', 'class="btn btn-sm  waves-effect waves-light btn-warning"'); ?>
     </div>
	  </div>



<div class="post-body">

<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	
	$data['class'] = 'input';
?>
<br/><br/>
		<div class="col-lg-12">	
	<div class="panel panel-info">
  <h4 class="card-title">FILTER DATA</h4>
  <div class="panel-body">
	<?php echo form_open('invoice'); ?>	
		<div class="panel panel-info">
  <div class="panel-body">
	<?php if($this->session->userdata('ADMIN')) { ?>
	
	<?php echo form_label('Lokasi Kantor *','lokasi'); ?>
	<select name="lokasi" class="form-control form-control-line col-md-2">
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
					$datatgl['type'] = 'date';
					$datatgl['id'] = 'example-date-input';
					$datatgl['class'] = 'form-control form-control-line col-md-2';
					
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
	<br/><br/>
	<div class="col-lg-12">
		<div class="card">
  <div class="card-body">
  <h4 class="card-title">DETAIL DATA</h4>
	<?php echo $this->session->flashdata('message'); ?>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
	<thead>
		<tr>
			<th style="width: 60px">No. Invoice</th>
			<th style="width: 60px">Tgl</th>
			<th>Customer</th>
			<th>Jumlah </th>
			<th>Up</th>
			<th>Posting</th>
			<th>No Jurnal</th>
			<th></th>			
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_inv='';
			if($journal_data)
			{
				
				foreach ($journal_data as $row) 
				{ 
					
					$is_update='';
					$statuspost='';
					$menuup='';
					if($row->is_publish=='0')
					{
						$statuspost="<span class='label label-warning'>No</span>";
						$menuup='e';
					}
					else
					{
						$statuspost="<a href=".site_url()."jurnal/detail_jurnal_inv/".$row->invoiceID." class='btn btn-success btn-xs'>Posting</a></span>";
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
					echo '<tr>';
					echo '<td>'.$row->invoiceID.'</td>';
					echo '<td>'.shortdate_indo($row->trxDate).'</td>';
					echo '<td>'.$row->trxFullName.'</td>';
					echo '<td>'.number_format($row->trxTotal).'</td>';	
					echo '<td>'.$is_update.'</td>';	
					echo '<td>'.$statuspost.'</td>';
				    echo '<td>'.$row->no_jurnal.'</td>';
					?>
					
					<td>
					<ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle " style="padding:4px;">Aksi <b class="caret"></b></a>
                        <ul class="dropdown-menu">
						<li><?php echo anchor(site_url()."invoice/invoice_detail/".$row->trxID."/".$menuup, 'Detail'); ?></li>		
                   		<li><?php echo anchor(site_url()."invoice/nota/".$row->invoiceID, 'Nota' , array('target' => '_blank')); ?></li>	
						</ul>
                    </li>
                </ul>
				</td>
					<?php echo '</tr>';
					$total_inv=$total_inv+$row->trxTotal;
				}
			}
		?>
	</tbody>	
	<tfoot>
	<tr><td colspan="6" style="text-align:right;"><h5>Total</h5></td><td><h5><?php if($total_inv){ echo number_format($total_inv);}?></h5></td></tr>
	</tfoot>
</table>		

</div>	
</div>	
</div>	
</div>		
