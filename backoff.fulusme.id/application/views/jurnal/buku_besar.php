
<div class="card">
  <div class="card-body">
  <h4 class="card-title"><?php echo $title ?></h4>
		<div class="pull-left">
		<?php
			echo form_button(array('id' => 'button-cancel','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-info', 'content' => $this->lang->line('kembali'), 'onClick' => "location.href='".site_url()."akun/detail_akun'" ));
		?>
	</div>
	<div class="pull-right">
		<h4><?php echo $this->lang->line('akun')?> : <?php echo $account_data['nama']?></h4>
	</div>
	<table class="table info-table" id="example23">
		<thead>
			<tr>
				<th><?php echo $this->lang->line('tanggal')?></th>
				<th><?php echo $this->lang->line('keterangan')?></th>
				<th>No Jurnal</th>
				<th>Nama Jurnal</th>									
				<th><?php echo $this->lang->line('debit')?></th>
				<th><?php echo $this->lang->line('kredit')?></th>
				<th><?php echo $this->lang->line('d_k')?></th>
				<th><?php echo $this->lang->line('saldo')?></th>
			</tr>
		</thead>
		<tbody>
			<?php 
				// Saldo Awal
				$sum = 0;
				if ($account_data['saldo_awal'] != 0)
				{
					$sum = $account_data['saldo_awal'];
					if ($sum < 0)
					{
						$d = '';
						$k = number_format(-$sum, 0, '', '.');
						$dk = 'K';
					}
					else
					{
						$d = number_format($sum, 0, '', '.');
						$k = '';
						$dk = 'D';
					}
					echo '<tr>';
					echo '<td></td>';
					echo '<td>Saldo Awal</td>';
					echo '<td></td>';
					echo '<td>'.$d.'</td>';
					echo '<td>'.$k.'</td>';	
					echo '<td>'.$dk.'</td>';
					echo '<td>'.number_format(abs($sum), 0, '', '.').'</td>';				
					echo '</tr>';
				}


				
				if($journal_data)
				{
					foreach ($journal_data as $row) 
					{ 
						if($row->debit_kredit == 1)
						{
							$sum += $row->nilai;
							$d = number_format($row->nilai, 0, '', '.');
							$k = '';
						}
						else
						{
							$sum -= $row->nilai;
							$d = '';
							$k = number_format($row->nilai, 0, '', '.');
						}
						$dk = ($sum>=0) ? 'D' : 'K';
						echo '<tr>';
						echo '<td>'.$row->tgl.'</td>';
						echo '<td>'.$row->keterangan.'</td>';
						echo '<td>'. anchor('jurnal/view_jurnal/' . $row->id, $row->no, 'target="_blank"') .'</td>';
						echo '<td>'.$row->f_name.'</td>';
						echo '<td>'.$d.'</td>';
						echo '<td>'.$k.'</td>';	
						echo '<td>'.$dk.'</td>';
						echo '<td>'.number_format(abs($sum), 0, '', '.').'</td>';				
						echo '</tr>';
					}
				}
			?>
		</tbody>
	</table>										
	</div>	 
	</div>		
</div>