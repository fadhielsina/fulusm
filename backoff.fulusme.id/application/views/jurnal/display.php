


<div class="post-body">

<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	
	$data['class'] = 'input';

	echo form_open($search_URL, array( 'id' => 'form_search' ));

	$attributes = array('id' => 'fieldset', 'class' => 'fieldset');
?>
 <div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('pencarian_jurnal') ?></h4>
   <div class="col-lg-6">
  <table width="300" border="0" align="center" cellpadding="2" cellspacing="0">						  		
		<tr>
			<th>
				<?php echo form_label($this->lang->line('bulan'),'bulan'); ?>
			<td>
				<?php 
					$data['id'] = 'bulan';
					$data['class'] = 'form-control';
					$selected = date("m") ;
					echo form_dropdown('bulan', $months, $selected, $data);
				?>					
			</td>
		</tr>	
		<tr>
			<th>
				<?php echo form_label($this->lang->line('tahun'),'tahun'); ?>
			<td>
				<?php 
					$data['id'] = 'tahun';
					$selected = date("Y") ;
					echo form_dropdown('tahun', $years, $selected, $data);
				?>					
			</td>
		</tr>								
	</table>
	
	<div class="buttons">
		<?php 			
				echo form_button(array('id' => 'button-save', 'type' => 'submit', 'content' => $this->lang->line('cari')));
				echo form_reset('reset','Reset', "id = 'button-reset'" );
				
		?>
	</div>
	</div>
  </div>

</div>
	
	
<?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>
 <div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_jurnal') ?></h4>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
	<thead>
		<tr>
			<th><?= $this->lang->line('tanggal') ?></th>
			<th>No</th>
			<th>No Invoice</th>
			<th class="no-print">Item</th>
			<th><?= $this->lang->line('akun') ?></th>
			<th><?= $this->lang->line('debit') ?></th>
			<th ><?= $this->lang->line('kredit') ?></th>
			<?php if($this->session->userdata('ADMIN')=='1')
		{?>
			<th class="no-print"></th>	
		<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php 
			if($journal_data)
			{
				foreach ($journal_data as $row) 
				{ 
					if($row->debit_kredit == 1)
					{
						$d = $row->nilai;
						$k = '';
					}
					else
					{
						$d = '';
						$k = $row->nilai; 
					}
					echo '<tr>';
					echo '<td>'.$row->tgl.'</td>';
					echo '<td>'.$row->no.'</td>';
					echo '<td>'.$row->invoice_no.'</td>';
					echo '<td class="no-print">'.$row->item.'</td>';
					echo '<td>'.$row->kode .' - ' . $row->account_name.'</td>';
					echo '<td>'.number_format(abs($d)).'</td>';
					echo '<td>'.number_format(abs($k)).'</td>';	
					if($this->session->userdata('ADMIN')=='1')
					{

						echo '<td class="no-print">'.anchor(site_url()."jurnal/jurnal_koreksi/".$row->id."/".$row->invoice_no, 'Jurnal Korekesi').'</td>'; 							
					}
					echo '</tr>';
				}
			}
		?>
	</tbody>	
	<tfoot>
		<tr>
			<th><?= $this->lang->line('tanggal') ?></th>
			<th>No</th>
			<th>No Invoice</th>
			<th class="no-print">Item</th>
			<th><?= $this->lang->line('akun') ?></th>
			<th><?= $this->lang->line('debit') ?></th>
			<th><?= $this->lang->line('kredit') ?></th>
			<?php if($this->session->userdata('ADMIN')=='1')
			{?>
				<th class="no-print"></th>	
			<?php } ?>	
		</tr>
	</tfoot>
</table>		
</div>
  </div>
</div>		
<script type="text/javascript" charset="utf-8">
	$(function() {
		var display_cur = $.fn.dataTable.render.number( ',', '.', 0 ).display;
		
		$('#form_search').on('submit', function( event ){
			event.preventDefault();

			$.post($(this).prop('action'), $(this).serialize(),function(msg){
				if(msg) {
					oTable.fnClearTable();
					msg = eval(msg);
					$.each( msg, function(i, v){
						msg[i][5] = display_cur( msg[i][5] );
						msg[i][6] = display_cur( msg[i][6] );
					});
					oTable.fnAddData(msg);
					$.each(oTable.fnGetNodes(), function(i,v){
						v.children[7].classList.add('no-print');
						v.children[3].classList.add('no-print');
					});
				}
			});

		});
	});
</script>