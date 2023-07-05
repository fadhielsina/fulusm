
<div class="post-body">

<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>
	<div class="col-lg-12">
	<div class="panel panel-info">
  <div class="panel-heading"><h3 class="badge badge-info"><?php echo $title; ?></h3></div>
  <div class="panel-body">
 
	<table class="table info-table" id="example23">
		<thead>
		<tr><td>Supplier : </td><td> <?php echo $supp_name; ?></td><td></td><td></td><td></td><td></td></tr>
			<tr>
				<th><?php echo $this->lang->line('tanggal')?></th>
				<th><?php echo $this->lang->line('keterangan')?></th>
				<th>Nama Jurnal</th>									
				<th><?php echo $this->lang->line('debit')?></th>
				<th><?php echo $this->lang->line('kredit')?></th>
				<th><?php echo $this->lang->line('saldo')?></th>
			</tr>
		</thead>
		<tbody>
			<?php 
				// Saldo Awal
				$sum = 0;
				
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
						echo '<td>'.$row->ket_jur.'</td>';
						echo '<td>'.$row->f_name.'</td>';
						echo '<td>'.$d.'</td>';
						echo '<td>'.$k.'</td>';	
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
</div>			
