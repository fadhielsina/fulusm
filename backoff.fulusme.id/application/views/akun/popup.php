<script type="text/javascript" charset="utf-8">
	$(function() {
		popup_table = $('#popup').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
	});
</script>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="popup">
	<thead>
		<tr>
			<th>ID</th>
			<th>Kode</th>
			<th>Nama Akun</th>
			<th></th>									
		</tr>
	</thead>
	<tbody>
		<?php
			if($akun)
			{
				$i = 0;
				foreach ($akun as $row)
				{
					echo '<tr>';
					echo '<td>'.$row->id.'</td>';
					echo '<td>'.$row->kode.'</td>';
					echo '<td>'.$row->nama.'</td>';
					echo '<td>'.form_hidden('id'.$i, $row->id).form_radio('chkID', $i).'</td>';
					echo '</tr>';
					$i++;
				}
			}
		?>
	</tbody>							
</table>


