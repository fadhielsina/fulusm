

<br/>
<div class="post-title col-lg-12"><h3 class="pull-left"><i class="fa fa-windows"></i> <?= $this->lang->line('list_currency') ?></h3>
		  <div class="pull-right">
		<?php 
			/*echo form_button(array('id' => 'button-addnew','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-success', 'content' => $this->lang->line('tambah'), 
				'onClick' => "location.href='".site_url()."".$add_act."'" ));
			echo form_button(array('id' => 'button-view','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-info', 'content' => $this->lang->line('lihat'), 'onClick' => "editAction('".site_url()."user/view')" ));
			echo form_button(array('id' => 'button-edit','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-primary', 'content' => $this->lang->line('ubah'), 'onClick' => "editAction('".site_url()."user/edit')" ));
			echo form_button(array('id' => 'button-delete','class' => 'btn btn-sm waves-effect waves-light btn-rounded btn-danger', 'content' => $this->lang->line('hapus'), 'onClick' => "deleteAction('".site_url()."user/delete')" ));*/
		?>		
		</div>
		</div>
		
<div class="post-body">

<?php echo $this->session->flashdata('message'); ?>
<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>
<br/><br/>
<div class="col-lg-12">
<div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
		<thead>
			<tr>
				<th ><?= $this->lang->line('currency_code') ?></th>
				<th ><?= $this->lang->line('currency_name') ?></th>
				<th ><?= $this->lang->line('currency_symbol') ?></th>
				<th ><?= $this->lang->line('currency_rate') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i=1;
				foreach ($currency_data as $key => $value) {
				echo '<tr>';
				echo '<td>'.$value['currency_code'].'</td>';
				echo '<td>'.$value['currency_name'].'</td>';
				echo '<td>'.$value['currency_symbol'].'</td>';
				echo '<td>'.form_hidden($i++, $value['id_currency']);
				if($value['is_aktif'] == 1 ){
					echo '<span class="btn 	btn-themecolor"> Activated </span>';
				}else{
					echo anchor("setting/Currency_aktiv/".$value['id_currency'],'Activate','class="btn 	btn-primary"');
				}
				echo '</td>';
				echo '</tr>';
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th ><?= $this->lang->line('currency_code') ?></th>
				<th ><?= $this->lang->line('currency_name') ?></th>
				<th ><?= $this->lang->line('currency_symbol') ?></th>
				<th ><?= $this->lang->line('currency_rate') ?></th>
			</tr>
		</tfoot>
	</table>
</div>
</div>
</div>
</div>
