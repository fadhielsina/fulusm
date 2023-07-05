<div class="post-title col-lg-12"><h3 class="badge badge-info"><i class="fa fa-windows"></i> <?php echo $title; ?></h3></div>

<div class="post-body">

<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>
	<div class="col-lg-12">						
	<div class="buttons">
		<?php 
			echo form_button(array('id' => 'button-addnew', 'content' => 'Tambah Baru', 'onClick' => "location.href='".site_url()."vehicles/add'" ));
			echo form_button(array('id' => 'button-view', 'content' => 'Lihat', 'onClick' => "editAction('".site_url()."vehicles/view')" ));
			if($this->session->userdata('ADMIN')) { 
			echo form_button(array('id' => 'button-edit', 'content' => 'Ubah', 'onClick' => "editAction('".site_url()."vehicles/edit')" ));
			echo form_button(array('id' => 'button-delete', 'content' => 'Hapus', 'onClick' => "deleteAction('".site_url()."vehicles/delete')" ));
			}
		?>		
	</div>
	</div>
	
	<div class="col-lg-12">
	<div class="panel panel-info">
  <div class="panel-heading"><i class="fa fa-th-list"></i> DETAIL DATA</div>
  <div class="panel-body">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
		<thead>
			<tr>
				<th>No</th>
				<th>Merk</th>
				<th>Type</th>
				<th>Series</th>
				<th>Cek</th>
			</tr>
		</thead>						
		<tbody>
			<?php
				if($vehicles_data)
				{
					$i = 0;
					foreach ($vehicles_data as $row)
					{
						echo '<tr>';
						echo '<td>'.$i++.'</td>';
						echo '<td>'.$row->merk.'</td>';
						echo '<td>'.$row->type.'</td>';
						echo '<td>'.$row->series.'</td>';
						echo '<td>'.form_hidden($i, $row->id).form_radio('selected_data', $i).'</td>';
						echo '</tr>';
						$i++;
					}
				}
			?>	
		</tbody>
		<tfoot>
			<tr>
				<th>No</th>
				<th>Merk</th>
				<th>Type</th>
				<th>Series</th>
				<th>Cek</th>
			</tr>
		</tfoot>
	</table>
</div>	
</div>	
</div>	
</div>			
