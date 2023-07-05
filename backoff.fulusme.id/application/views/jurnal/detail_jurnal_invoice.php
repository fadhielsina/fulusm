<div class="post-title col-lg-12"><h3 class="badge badge-info"><?php echo $title; ?></h3></div>
<div class="post-body">
<div class="col-lg-12">
	<div class="card card-outline-info">
  <div class="card-header text-white">DETAIL DATA</div>
  <div class="card-body">

	<table cellpadding="0" cellspacing="0" border="0" class="display_table" id="display_table">
	<thead>
		<tr>
			<th>Tanggal</th>
			<th>No</th>
			<th>No Invoice</th>
			<th>Item</th>
			<th>Akun</th>
			<th>Debit</th>
			<th>Kredit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if($jurnal_data)
			{
				foreach ($jurnal_data as $row) 
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
					echo '<td>'.$row->item.'</td>';
					echo '<td>'.$row->account_name.'</td>';
					echo '<td>'.number_format(abs($d)).'</td>';
					echo '<td>'.number_format(abs($k)).'</td>';	
					echo '</tr>';
				}
			}
		?>
	</tbody>	
	<tfoot>
		<tr>
			<th>Tanggal</th>
			<th>No</th>
			<th>No Invoice</th>
			<th>Item</th>
			<th>Akun</th>
			<th>Debit</th>
			<th>Kredit</th>
		</tr>
	</tfoot>
</table>		
</div>		
</div>		
</div>		
</div>		

<script type="text/javascript">


</script>