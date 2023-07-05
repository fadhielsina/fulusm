<style>
table.dataTable tbody th,
table.dataTable tbody td {
     padding: 0px 0px
}	
	@keyframes blink {
  50% {
    color: transparent;
  }
}

.loader__dot {
  animation: 1s blink infinite;
}

.loader__dot:nth-child(2) {
  animation-delay: 250ms;
}

.loader__dot:nth-child(3) {
  animation-delay: 500ms;
}
</style>


<div class="post-body">

<?php
	

	echo form_open($search_URL,"id='form-jurnal'");

	$attributes = array('id' => 'fieldset', 'class' => 'fieldset');
?>
 <div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('pencarian_jurnal') ?></h4>
  <div class="row">
   <div class="col-lg-8">
  <table width="400px" border="0" align="left" cellpadding="2" cellspacing="0">						  		
		<tr>
			<td>
				<?php echo form_label($this->lang->line('bulan'),'bulan'); ?>
			</td>
			<td>
				<?php 
					$data['id'] = 'bulan';
					$data['class'] = 'form-control';
					$selected = ($this->input->post('bulan')!="")?$this->input->post('bulan'):date("m") ;
					echo form_dropdown('bulan', $months, $selected, $data);
				?>					
			</td>
		</tr>	
		<tr>
			<td>
				<?php echo form_label($this->lang->line('tahun'),'tahun'); ?>
			</td>
			<td>
				<?php 
					$data['id'] = 'tahun';
					$selected = date("Y") ;
					echo form_dropdown('tahun', $years, $selected, $data);
				?>					
			</td>
		</tr>	
		<tr>
			<td>
				
			</td>
			<td>
				<div class="buttons">
					<div class="dt-buttons">
					<?php 			
							echo form_button('cari',$this->lang->line('cari'), "id = 'button-save' " );
							echo form_reset('reset','Reset', "id = 'button-reset'" );
							echo anchor('jurnal/jurnal_billing','Load Data FO','id="load_fo_data" class="dt-button buttons-html5" onClick="return loadApi(\''.$load_api.'\')"');
					?>
					<span id="loading" style="display:none">Loading <span class="loader__dot">...</span><span class="loader__dot">...</span><span class="loader__dot">...</span></span>
					</div>
				</div>				
			</td>
		</tr>								
	</table>
	

	</div>
	<div class="col-lg-6">
		<?php //echo '<a href="'.$load_api.'" class="btn btn-primary float-right" >Load Billing</a>'; ?>
	</div>
	</div>
  </div>

</div>
	
	
<?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>
 <div class="card">
  <div class="card-body">
      <div class="row">
          <div class="col-md-6"><h4 class="card-title"><?= $this->lang->line('detail_jurnal') ?></h4></div>
          <div class="col-md-6 text-right">
              <button class="btn btn-primary" id="post_all">Post Data</button>
              <button class="btn btn-danger" id="delete_all">Delete Data</button>
          </div>
      </div>
  
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table_check">
	<thead>
		<tr>
            <th></th>
			<th><?= $this->lang->line('tanggal') ?></th>
			<th>No</th>
			<th>No Invoice</th>
			<th>Payment</th>
			<th><?= $this->lang->line('keterangan') ?></th>
			<th><?= $this->lang->line('total') ?></th>
			<!-- <th><?= $this->lang->line('kredit') ?></th> -->
			<?php if($this->session->userdata('ADMIN')=='1')
		{?>
			<th></th>	
		<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php 
			if($journal_data)
			{
				
				foreach ($journal_data as $row) 
				{ 
					
					echo '<tr>';
                    echo '<td></td>';
					echo '<td>'.$row->tgl.'</td>';
					echo '<td>'.$row->no.'</td>';
					echo '<td>'.$row->invoice_no.'</td>';
					echo '<td>'.$row->INSURANCE_NAME.'</td>';
					echo '<td>'.$row->CLASS.'</td>';
					echo '<td>'.number_format(abs($row->debet)).'</td>';
					//echo '<td>'.number_format(abs($row->kredit)).'</td>';
					echo '<td>';	
					echo '
                            <label class="custom-control-label" for="detail" style="font-size:25px">
							'.anchor(site_url()."jurnal/jurnal_billing_detail/".$row->id, '<i class="mdi mdi-content-paste" title="Detail jurnal"></i>').'
							</label>';
							
					
					//if($this->session->userdata('ADMIN')=='1')
					//{
						if($row->is_posting==1){
							echo "<span class='label label-danger'>Posted</span>";
						}else{	
						echo '
                            <label class="custom-control-label" for="defaultUnchecked" style="font-size:25px">
							'.anchor(site_url()."jurnal/proses_unpost/".$row->id, '<i class="mdi mdi-arrow-right-bold-circle" title="post to jurnal"></i>').'
							</label>
							';
						} 						
					//}
					echo'</td>'; 
					echo '</tr>';
				}
			}
		?>
	</tbody>	
	<tfoot>
		<tr>
			<th></th>
			<th><?= $this->lang->line('tanggal') ?></th>
			<th>No</th>
			<th>No Invoice</th>
			<th>Payment</th>
			<th><?= $this->lang->line('keterangan') ?></th>
			<th><?= $this->lang->line('total') ?></th>
			<th></th>	
		</tr>
	</tfoot>
</table>		
</div>
  </div>
</div>		
<script type="text/javascript" charset="utf-8">
	function loadApi(url){
		$("#load_fo_data").hide();
		$("#loading").show();
		$.getJSON(url,function(result){
			if(typeof result.succes == 'object'){
				alert("Succes load  Data");
				$("#loading").hide();
				$("#load_fo_data").show();
			}else{
				alert("All data loaded");
				$("#loading").hide();
				$("#load_fo_data").show();
			}
		});

		return false;
	}

	$(function() {
		$('#button-save').click(function() {
			var bln = $('#bulan').val();
			var thn = $('#tahun').val();
			$("#form-jurnal").submit();
			/*oTable.fnClearTable();
			$.post('<?php echo $search_URL ?>',
				  { bulan : bln, tahun : thn},
				  function(msg){
					if(msg) {
						msg = eval(msg);
						oTable.fnAddData(msg);
					}
				  }
			  );
			  */
		});
	});
        
        
</script>