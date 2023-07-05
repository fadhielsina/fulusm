
<div class="post-body">

<?php //echo $this->session->flashdata('message'); ?>
<?php
	/*if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}*/
?>
<div class="col-lg-12">
<div class="card">
  <div class="card-body">
  <h4 class="card-title pull-left"><?php echo $this->lang->line('detail_data');?></h4>
  	<div class="pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light  btn-primary',  'content' => $this->lang->line('tambah'), 'onClick' => "location.href='".site_url()."unit_com/add'" ));
			echo form_button(array('id' => 'button-view','class' => 'btn btn-sm waves-effect waves-light  btn-primary',  'content' => $this->lang->line('lihat'), 'onClick' => "editAction('".site_url()."unit_com/view')" ));
			echo form_button(array('id' => 'button-edit','class' => 'btn btn-sm waves-effect waves-light  btn-primary',  'content' => $this->lang->line('ubah'), 'onClick' => "editAction('".site_url()."unit_com/edit')" ));
			echo form_button(array('id' => 'button-delete','class' => 'btn btn-sm waves-effect waves-light  btn-danger',  'content' => $this->lang->line('hapus'), 'onClick' => "deleteAction('".site_url()."unit_com/delete')" ));
		?>		
	</div>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
		<thead>
			<tr>
				<th>Kode Perusahaan / Unit</th>
				<th>Nama Perusahaan / Unit</th>
				<th>Alamat</th>
				<th>No. Telp</th>
				<th>PIC</th>
				<th class="no-print"><?php echo $this->lang->line('cek');?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				if($user_data)
				{
					$i = 0;
					foreach ($user_data as $row)
					{
						echo '<tr>';
						echo '<td>'.$row->identityCode.'</td>';
						echo '<td>'.$row->identityName.'</td>';
						echo '<td>'.$row->identityAddress.'</td>';
						echo '<td>'.$row->identityPhone.'</td>';
						echo '<td>'.$row->identityOwner.'</td>';
						echo '<td  class="no-print">'.form_hidden($i, $row->identityID).form_radio('selected_data', $row->identityID, "","id='".$row->identityID."'style='opacity:1;left:0px;position:relative;'").'</td>';
						echo '</tr>';
						$i++;
					}
				}
			?>
		</tbody>
	</table>
</div>
</div>
</div>
</div>
