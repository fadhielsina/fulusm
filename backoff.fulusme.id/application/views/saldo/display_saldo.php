		<div class="col-lg-12">		
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>		
	</div>
	<div class="col-lg-12">	
	
	<div class="card card-outline-info">
        <div class="card-header">
            <h4 class="mb-0 text-white">SALDO PIUTANG
            <span class="pull-right">
				<?php 
					echo form_button(array('id' => 'button-addnew', 'content' => '<i class="fa fa-plus"></i> Tambah Baru', 'class' => 'btn btn-success', 'onClick' => "location.href='".site_url()."saldo/add_saldo_piutang'" ));
				?>		
			</span>
			</h4>
        </div>
        <div class="card-body">
            
        	<?php echo form_open('saldo/data_saldo_piutang'); ?>
				
				<div class="row">
					<div class="col-4">
						
						<?php echo form_label('Tanggal Awal','tanggal'); ?> : 
						<?php 
							$datatgl['name'] = 'tanggal1';
							$datatgl['id'] = 'datepicker';
							
								echo form_input($datatgl);
						?>

					</div>
					
					<div class="col-4">
						<?php echo form_label('Tanggal Akhir','tanggal'); ?> : 
						<?php 
										$datatgl['name'] = 'tanggal2';
										$datatgl['id'] = 'datepicker2';
										echo form_input($datatgl);
									?>
					</div>
					<div class="col-4 align-middle">
						<button type="submit" name="submit" class="btn btn-info btn-sm" value="filter"><i class="fa fa-search"></i> FILTER DATA</button>
					</div>
				</div>	
			<?php echo form_close(); ?>

        </div>
    </div>

	</div>

	<div class="col-lg-12">
	<div class="card card-outline-info">
		<div class="card-header">
            <h4 class="mb-0 text-white">DETAIL DATA</h4>
        </div>
  <div class="card-body">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
		<thead>
			<tr>
				<th>No.Trx</th>
				<th>Tgl. Input</th>
				<th>Kode Customer</th>
				<th>Customer</th>
				<th>Alamat</th>
				<th>No. Ref.</th>
				<th>Saldo Piutang</th>
				<th>Jatuh Tempo</th>
				<th></th>
			</tr>
		</thead>						
		<tbody>
			<?php
				if($kas_data)
				{
					$total= 0;
					foreach ($kas_data as $row)
					{
						echo '<tr>';
						echo '<td>'.$row->no_trx_bal.'</td>';
						
						echo '<td>'.mediumdate_indo($row->tgl_catat).'</td>';
						echo '<td>'.$row->memberCode.'</td>';
						echo '<td>'.$row->memberFullName.'</td>';
						echo '<td>'.$row->memberAddress.'</td>';
						echo '<td>'.$row->no_trx_bal.'</td>';
						echo '<td>'.number_format($row->bal).'</td>';
						echo '<td>'.mediumdate_indo($row->tgl_jt).'</td>';
						?>
						<td>
						<?php echo anchor(site_url()."saldo/add_saldo_detail/".$row->no_trx_bal, 'Detail'); ?>
						</td>
						<?php echo '</tr>';
						$total=$total+$row->bal;
					}
					
				}
			?>	
			
		</tbody>
		<footer>
		<?php if($kas_data) { ?>
			<td colspan="5"></td><td><h5>TOTAL</h5></td><td colspan="3"><h5><?php echo number_format($total);?></h5></td>
		<?php } ?>
			</footer>
	</table>
</div>			
</div>			
</div>				
