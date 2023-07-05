<div class="post-title"><h3 class="badge badge-info"><?php echo $title; ?></h3></div>

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
			echo form_button(array('id' => 'button-addnew', 'content' => 'Tambah Baru', 'onClick' => "location.href='".site_url()."klien/add'" ));
			echo form_button(array('id' => 'button-view', 'content' => 'Lihat', 'onClick' => "editAction('".site_url()."klien/view')" ));
			echo form_button(array('id' => 'button-edit', 'content' => 'Ubah', 'onClick' => "editAction('".site_url()."klien/edit')" ));
			if($this->session->userdata('ADMIN')) { 
			echo form_button(array('id' => 'button-delete', 'content' => 'Hapus', 'onClick' => "deleteAction('".site_url()."klien/delete')" ));
			}
		?>		
	</div>
	</div>
	<div class="col-lg-12">
	<div class="panel panel-info">
  <div class="panel-heading">DETAIL DATA</div>
  <div class="panel-body">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
		<thead>
			<tr>
				<th>No</th>
				<th>Kode Member</th>
				<th>No Identitas</th>
				<th>Npwp</th>
				<th>Nama</th>
				<th>Alamat</th>
				<th>Telpon</th>
				<th>Cek</th>
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
						echo '<td>'.$i++.'</td>';
						echo '<td>'.$row->memberCode.'</td>';
						echo '<td>'.$row->memberKTP.'</td>';
						echo '<td>'.$row->memberNPWP.'</td>';
						echo '<td>'.$row->memberFullName.'</td>';
						echo '<td>'.$row->memberAddress.'</td>';
						echo '<td>'.$row->memberPhone.'</td>';
						echo '<td>'.form_hidden($i, $row->memberID).form_radio('selected_data', $i).'</td>';
						echo '</tr>';
						$i++;
					}
				}
			?>	
		</tbody>
		<tfoot>
			<tr>
				<th>Nama</th>
				<th>Alamat</th>
				<th>Telpon</th>
				<th>Cek</th>
			</tr>
		</tfoot>
	</table>
</div>			
</div>			
</div>			
</div>			
