<div class="post-title col-lg-12"><h3 class="badge badge-info"><?php echo $title; ?></h3></div>

<div class="post-body">

<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>
		<div class="col-lg-12">				
	<div class="buttons pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success', 'content' => 'Tambah Baru', 'onClick' => "location.href='".site_url()."barang/add'" ));
			echo form_button(array('id' => 'button-view','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-info', 'content' => 'Lihat', 'onClick' => "editAction('".site_url()."barang/view')" ));
			echo form_button(array('id' => 'button-edit', 'class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-primary','content' => 'Ubah', 'onClick' => "editAction('".site_url()."barang/edit')" ));
			
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
				<th>Kode Barang</th>
				<th>Nama</th>
				<th>Kategori</th>
				<th>Kode Kategori</th>
				<th>Cek</th>
			</tr>
		</thead>						
		<tbody>
			<?php
				if($client_data)
				{
					$i = 1;
					foreach ($client_data as $row)
					{
						echo '<tr>';
						echo '<td>'.$i++.'</td>';
						echo '<td>'.$row->barangBarcode.'</td>';
						echo '<td>'.$row->barangName.'</td>';
						echo '<td>'.$row->nama_kategori.'</td>';
						echo '<td>'.$row->kode_kategori.'</td>';
						echo '<td>'.form_hidden($i, $row->barangID).form_radio('selected_data', $row->barangID).'<a href="'.base_url().'/barang/delete/'.$row->barangID.'" class="btn btn-xs waves-effect waves-light btn-danger">hapus</a></td>';
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
