<br/>
<div class="col-lg-12">	<h3 class="pull-left"> <i class="fa fa-windows"></i> <?php echo $title; ?></h3>
<br/><br/>

<div class="card">
  <div class="card-body">
  <h4 class="card-title">DETAIL</h4>
		<div class="pull-left">
		<?php
			echo form_button(array('id' => 'button-cancel','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-info', 'content' => 'Kembali', 'onClick' => "location.href='".site_url()."akun/detail_akun'" ));
		?>
	</div>
	
	<table class="table color-table info-table" id="display_table">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Akun</th>
				<th>F</th>									
				<th>saldo Awal</th>		
				<th>Debit</th>
				<th>Kredit</th>
				<th>D/K</th>
				<th>Saldo</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				// Saldo Awal
				/*$sum = 0;
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
				}*/

				$sum=0;
				
				if($journal_data)
				{
					foreach ($journal_data as $row) 
					{ 
						if($row->debit_kredit == 1)
						{
							$sum += $row->nilai;
							$d = number_format($row->nilai, 0, '', '.');
							$k = '';
							$saldo = $row->saldo_awal  - $row->nilai;
						}
						else
						{
							$sum -= $row->nilai;
							$d = '';
							$k = number_format($row->nilai, 0, '', '.');
							$saldo = $row->saldo_awal  + $row->nilai;
						}
						$dk = ($sum>=0) ? 'D' : 'K';
						echo '<tr>';
						echo '<td>'.$row->tgl.'</td>';
						echo '<td>'.$row->account_name.'</td>';
						echo '<td>'.$row->f_name.'</td>';
						echo '<td>'.$row->saldo_awal.'</td>';
						echo '<td>'.$d.'</td>';
						echo '<td>'.$k.'</td>';	
						echo '<td>'.$dk.'</td>';
						echo '<td>'.number_format(($saldo), 0, '', '.').'</td>';				
						echo '</tr>';
					}
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th>Tanggal</th>
				<th>Keterangan</th>
				<th>F</th>									
				<th>Saldo Awal</th>	
				<th>Debit</th>
				<th>Kredit</th>
				<th>D/K</th>
				<th>Saldo</th>
			</tr>
		</tfoot>
	</table>										


		</div>				
</div>		
