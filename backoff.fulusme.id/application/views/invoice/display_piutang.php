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

	<div class="card card-outline-info">
        <div class="card-header">
            <h4 class="mb-0 text-white">Filter Data</h4></div>
        <div class="card-body">
            
        	<?php echo form_open('invoice/invoice_piutang'); ?>	
				
				<div class="row">
				<?php if( $this->session->userdata('IDENTITY_ID') > 1 ){ ?>
					<input type="hidden" name="lokasi" id="lokasi" value="<?php echo $this->session->userdata('IDENTITY_ID'); ?>">
				<?php } else { ?>
					<div class="col-3">
					<?php echo form_label($this->lang->line('lokasi').'*','lokasi'); ?>
					<select name="lokasi" class="form-control">
						<option value="" >- Semua Lokasi -</option>	
						<?php
						foreach ($lokasi_data as $lokasi_data):
							if( $lokasi_data->identityID == $selected_lokasi )
							{
							 ?>
							 	<option value="<?php echo $lokasi_data->identityID ?>" selected><?php echo $lokasi_data->identityName ?></option>
							<?php } else { ?>
								<option value="<?php echo $lokasi_data->identityID ?>" ><?php echo $lokasi_data->identityName ?></option>
							<?php } ?>
						<?php endforeach ?>									
					</select>
					</div>
				<?php } ?>
					
					<div class="col-3">
					<?php echo form_label($this->lang->line('tanggal_awal'),'tanggal'); ?> : 
					<?php 
						$datatgl['name'] = 'tanggal1';
						$datatgl['type'] = 'date';
						$datatgl['value'] = $tanggal1;
						$datatgl['class']="form-control";
						
							echo form_input($datatgl);
					?>
					</div>
					<div class="col-3">
					<?php echo form_label($this->lang->line('tanggal_akhir'),'tanggal'); ?> : 
					<?php 
						$datatgl['name'] = 'tanggal2';
						$datatgl['type'] = 'date';
						$datatgl['value'] = $tanggal2;
						$datatgl['class']="form-control";
						echo form_input($datatgl);
					?>
					</div>
					<div class="col-3 align-middle pt-4">
					 	<button type="submit" name="submit" class="btn btn-info btn-sm" value="filter"><i class="fa fa-search"></i> <?= $this->lang->line('filter_data') ?></button>
					</div>
				</div>	
			<?php echo form_close(); ?>

        </div>
    </div>

<div class="card card-outline-info">

	<div class="card-header">
   		<h4 class="mb-0 text-white"><i class="fa fa-th-list"></i> <?= $this->lang->line('detail_data') ?></h4>
    </div>
  <div class="card-body">
<div class="post-body">
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	
	$data['class'] = 'input';
?>
	<?php echo $this->session->flashdata('message'); ?>
		<div class="col-lg-12">
	<div class="panel panel-info">
  <div class="panel-body">
	<table cellpadding="0" cellspacing="0" border="0" class="table table-responsive" id="display_table">
	<thead>
		<tr>
			<th style="width: 130px"><?= $this->lang->line('tgl_pencatatan') ?></th>
			<th style="width: 140px">No Invoice</th>
			<!-- <th>No. SPK/BPBB</th> -->
			<th>Customer</th>
			<th><?= $this->lang->line('keterangan') ?> </th> 
			<th><?= $this->lang->line('nominal') ?> </th>
			<th>Status </th>
			<th class="no-print"></th>			
		</tr>
	</thead>
	<tbody>
		<?php 
			if($journal_data)
			{
				foreach ($journal_data as $row) 
				{ 
					$statuspost='';
					if($row->is_publish=='0')
					{
						$statuspost="<span class='label label-danger'>F</span>";
					}
					else
					{
						$statuspost="<span class='label label-success'>T</span>";
					}
					
					$statuslunas='';
					if($row->statuslunas=='2')
					{
						$statuslunas="<span class='label label-danger'>F</span>";
					}
					else
					{
						$statuslunas="<span class='label label-success'>T</span>";
					}

					echo '<tr>';
					echo '<td>'.$row->trxDate.'</td>';
					echo '<td>'.$row->invoiceID.'</td>';
					//echo '<td>'.$row->invoiceIDmanual.'</td>';
					echo '<td>'. anchor('invoice/detail_custumer_inv/' . $row->memberID, $row->trxFullName ).'</td>';
					echo '<td>'.$row->note.'</td>'; 		
					echo '<td>'.number_format($row->trxTotal - $row->trxPay).'</td>';	
					echo '<td>'.$statuslunas.'</td>';	
					echo '<td class="no-print">'.anchor(site_url()."invoice/invoice_pay_termin/".$row->invoiceID, 'Detail').'</td>'; 							
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
</div>		
