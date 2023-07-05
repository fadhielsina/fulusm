<script type="text/javascript" charset="utf-8">
	$(function() {
		popup_table2 = $('#popup2').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
	});
</script>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="popup2">
	<thead>
		<tr>
			<th>ID</th>
			<th>Merk </th>
			<th>Type </th>
			<th>Series</th>
			<th></th>									
		</tr>
	</thead>
	<tbody>
		<?php
			if($client_data)
			{
				$i = 0;
				foreach ($client_data as $row)
				{
					echo '<tr>';
					echo '<td>'.$row->id.'</td>';
					echo '<td>'.$row->merk.'</td>';
					echo '<td>'.$row->type.'</td>';
					echo '<td>'.$row->series.'</td>';
					echo '<td>'.form_hidden('id'.$i, $row->id).form_radio('chkID', $i).'</td>';
					echo '</tr>';
					$i++;
				}
			}
		?>
	</tbody>							
</table>
<br/>
<?php echo anchor(site_url()."vehicles/add", 'Tambah Data baru &#187;', 'class="btn btn-info"'); ?>



