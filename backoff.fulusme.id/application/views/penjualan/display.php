
<script type="text/javascript" src="<?php echo base_url();?>js/group_table.js"></script>
	<br/>
<div class="post-title col-lg-12"><h3 class="pull-left"> <i class="fa fa-windows"></i> <?php echo $title; ?></h3>
	<div class="pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success',  'content' => $this->lang->line('tambah'), 'onClick' => "location.href='".site_url()."penjualan/add'" ));
		?>		
	</div>
</div>
<br/><br/>
<div class="post-body">

<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>


<div class="col-lg-12">
	<div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>
<table class="table info-table" id="example23">
		<thead>
			<tr>
				<th>No Faktur</th>
				<th>No PO</th>
				<th>Supplier</th>
				<th>Term</th>									
				<th>Amount</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if($account_data)
				{
					$i = 0;
					foreach ($account_data as $row)
					{
						echo '<tr>';
						echo '<td>'.$row->trxFakturID.'</td>';
						echo '<td>'.$row->trxPOID.'</td>';
						echo '<td>'.$row->memberFullName.'</td>';
						echo '<td>'.$row->trxStatus.'</td>';
						echo '<td>'.number_format( $row->trxTotal ).'</td>';
						echo '<td><a href="#" class="btn btn-primary">Detail</a></td>';
						echo '</tr>';
						$i++;
					}
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th>No Faktur</th>
				<th>No PO</th>
				<th>Supplier</th>
				<th>Term</th>									
				<th>Amount</th>
				<th>Aksi</th>
			</tr>
		</tfoot>
	</table>
</div>
</div>
</div>
</div>

 