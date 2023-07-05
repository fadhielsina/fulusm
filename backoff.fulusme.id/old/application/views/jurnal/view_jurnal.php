<div class="card">
  <div class="card-body">
<div class="post-title"><h2><a href="#"><?php echo $title; ?></a></h2></div>

<div class="post-body">

<?php
	$data['class'] = 'input';
?>	

	<table width="700" border="0"  cellpadding="2" cellspacing="0">							  
		<tr>
			<th><?php echo form_label($this->lang->line('nomor'),'nomor'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nomor';
					$data['value'] = set_value('nomor');
					$data['class'] = "form-control";
					$data['value'] = $journal_data[0]->no;
					$data['readonly'] = true;
					echo form_input($data);
				?>
			</td>				
		</tr>		
		<tr>
			<th><?php echo form_label($this->lang->line('tanggal'),'tanggal'); ?></th>
			<td>
				<div class="input-group date" data-provide="datepicker" data-date-format ="yyyy-mm-dd">		
				<?php 
					$data['name'] = 'tanggal';
					$data['id'] = 'datepicker';
					$data['value'] = set_value('tanggal');
					$data['class'] = "form-control";
					$data['value'] = $journal_data[0]->tgl;
					echo form_input($data);
				?>
				</div>
			</td>				
		</tr>
		<tr>
			<th><?php echo form_label('Keterangan', 'deskripsi'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'deskripsi';					
					$data['value'] = set_value('deskripsi');
					$data['value'] = $journal_data[0]->keterangan;
					echo form_textarea($data);
				?>
			</td>
		</tr>		
	</table>
	
	<h5>Detail</h5>
	<table id="tblDetail" name="tblDetail" class="data-table">
		<tr>
			<th><?= $this->lang->line('akun') ?></th>
			<th><?= $this->lang->line('debit') ?></th>
			<th><?= $this->lang->line('kredit') ?></th>																	
		</tr>
		<?php
			$data['disabled'] = TRUE;
			$data['class'] = 'field';
			$i = 1;
			foreach ($journal_data as $row)
			{
				echo '<tr>';
				echo '<td>';
				$akun['id'] = 'akun'.$i;
				$akun['class'] = 'combo';
				$akun['disabled'] = TRUE;
				$selected = $row->akun_id;
				echo form_dropdown('akun[]', $accounts, $selected ,$akun);
				echo '</td>';
				echo '<td>';
				$data['id'] = $data['name'] = 'debit'.$i;
				$data['value'] = ($row->debit_kredit) ? $row->nilai : '' ;
				echo form_input($data);
				echo '</td>';
				echo '<td>';
				$data['id'] = $data['name'] = 'kredit'.$i;
				$data['value'] = (!$row->debit_kredit) ? $row->nilai : '' ;
				echo form_input($data);
				echo '</td>';
				echo '</tr>';
				$i++;
				$f = $row->f_id;
			}
		?>
	</table>

</div>
</div>
</div>