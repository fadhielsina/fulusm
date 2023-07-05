
<script type="text/javascript" src="<?php echo base_url();?>js/group_table.js"></script>
	
<div class="post-body">

<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>


<div class="col-lg-12">
	<div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>
  <div class="pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success',  'content' => $this->lang->line('tambah'), 'onClick' => "location.href='".site_url()."akun/add'" ));
			echo form_button(array('id' => 'button-view','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-info',  'content' => $this->lang->line('lihat'), 'onClick' => "editAction('".site_url()."akun/view')" ));
			echo form_button(array('id' => 'button-edit','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-primary',  'content' => $this->lang->line('ubah'), 'onClick' => "editAction('".site_url()."akun/edit')" ));
			echo form_button(array('id' => 'button-delete','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger',  'content' => $this->lang->line('hapus'), 'onClick' => "deleteAction('".site_url()."akun/delete')" ));
		?>		
	</div>
  <table class="table info-table" id="display_table">
		<thead>
			<tr>
				<th><?= $this->lang->line('grup'); ?></th>
				<!-- <th><?= $this->lang->line('divisiom'); ?></th>
				<th><?= $this->lang->line('departement'); ?></th> -->
				<th><?= $this->lang->line('akun'); ?></th>
				<th><?= $this->lang->line('kode'); ?></th>									
				<th><?= $this->lang->line('cek'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				if($account_data)
				{
					$i = 0;
					foreach ($account_data as $row)
					{
						echo '<tr>';
						echo '<td>'.$row->groups_name.'</td>';
						echo '<td>'.$row->nama.'</td>';
						echo '<td>'.$row->kode.'</td>';
						echo '<td>'.form_hidden($i, $row->id).form_radio('selected_data', $row->id).'</td>';
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

 