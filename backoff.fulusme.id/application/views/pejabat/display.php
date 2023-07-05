<br/>
<div class="post-title col-lg-12">
	<h3 class="pull-left"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>
	<div class="pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success',  'content' => $this->lang->line('tambah'), 'onClick' => "location.href='".site_url()."pejabat/add'" ));
			echo form_button(array('id' => 'button-view','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-info',  'content' => $this->lang->line('lihat'), 'onClick' => "editAction('".site_url()."pejabat/view')" ));
			echo form_button(array('id' => 'button-edit','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-primary',  'content' => $this->lang->line('ubah'), 'onClick' => "editAction('".site_url()."pejabat/edit')" ));
			echo form_button(array('id' => 'button-delete','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger',  'content' => $this->lang->line('hapus'), 'onClick' => "deleteAction('".site_url()."pejabat/delete')" ));
		?>		
	</div>
</div>
		
<div class="post-body">

<?php //echo $this->session->flashdata('message'); ?>
<?php
	/*if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}*/
?>
<br/><br/>
<div class="col-lg-12">
<div class="card">
  <div class="card-body">
  <h4 class="card-title"><?php echo $this->lang->line('detail_data');?></h4>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
		<thead>
			<tr>
				<th><?php echo $this->lang->line('nama');?></th>
				<th><?php echo $this->lang->line('nip');?></th>
				<th><?php echo $this->lang->line('jabatan');?></th>
				<th><?php echo $this->lang->line('cek');?></th>
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
						echo '<td>'.$row->nama.'</td>';
						echo '<td>'.$row->nip.'</td>';
						echo '<td>'.$row->nama_jabatan.'</td>';
						echo '<td>'.form_hidden($i, $row->id).form_radio('selected_data', $row->id, "","id='".$row->id."'style='opacity:1;left:0px;position:relative;'").'</td>';
						echo '</tr>';
						$i++;
					}
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th><?php echo $this->lang->line('nama');?></th>
				<th><?php echo $this->lang->line('nip');?></th>
				<th><?php echo $this->lang->line('jabatan');?></th>
				<th><?php echo $this->lang->line('cek');?></th>
			</tr>
		</tfoot>
	</table>
</div>
</div>
</div>
</div>
