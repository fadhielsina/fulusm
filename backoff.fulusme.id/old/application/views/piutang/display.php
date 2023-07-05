
<div class="post-body">

<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>
		<div class="col-lg-12">				
	<div class="buttons pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success', 'content' => 'Tambah Baru', 'onClick' => "location.href='".site_url()."piutang/add_saldo'" ));
			
		?>	
	</div>
	</div>
	<div class="col-lg-12">
	<div class="panel panel-info">
  <div class="panel-heading"><h3 class="badge badge-info"><?php echo $title; ?></h3></div>
  <div class="panel-body">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
		<thead>
			<tr>
				<th>No</th>
				<th>No. AP</th>
				<th>No. Doc/Bukti</th>
				<th>Customer</th>
				<th>Saldo Awal</th>
				<th>Bayar</th>
				<th>Sisa</th>
			</tr>
		</thead>						
		<tbody>
			<?php
				if($piutang_data)
				{
					$i = 1;
					foreach ($piutang_data as $row)
					{
						echo '<tr>';
						echo '<td>'.$i++.'</td>';
						echo '<td>'.$row->no_trx_bal.'</td>';
						echo '<td>'.$row->no_doc.'</td>';
						echo '<td>'.$row->memberFullName.'</td>';
						echo '<td>'.number_format($row->bal_awal).'</td>';
					    echo '<td>'.number_format($row->bayar).'</td>';
						 echo '<td>'.number_format($row->bal_awal-$row->bayar).'</td>';
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
