<br/>
<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>
<?php
	echo form_open('pejabat/'.$form_act, array('id' => 'jurnal_form','id' => 'user_form', 'class' => 'form-material m-t-40'));

	$data['class'] = 'input';
	if ($act == 'view') $data['disabled'] = TRUE;
?>

	<table class="table">
		<tr>
			<th><?php echo form_label($this->lang->line('nama').'*','nama'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nama';
					$data['value'] = (set_value('nama')) ? set_value('nama') : $user_data['nama'];
					$data['class'] ='form-control';
					$data['title'] = $this->lang->line('valid_nama');
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('nip'),'nip'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nip';
					$data['value'] = (set_value('nip')) ? set_value('nip') : $user_data['nip'];
					$data['title'] = $this->lang->line('valid_nip');
					echo form_input($data);
				?>
			</td>			
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('jabatan'),'jabatan'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'jabatan';
					$data['value'] = (set_value('jabatan')) ? set_value('jabatan') : $user_data['jabatan'];
					$data['title'] = $this->lang->line('valid_jabatan');
					echo form_dropdown($data['name'], $data_jabatan, $data['value']);
				?>
			</td>			
		</tr>
	</table>
  	<hr/>
	<div class="buttons pull-left">
		<?php 
			if($act!='view')
			{ 
				echo form_submit('simpan', $this->lang->line('simpan'), "id = 'button-save' class='btn btn-secondary'" );
				echo form_reset('reset','Reset', "id = 'button-reset' class='btn btn-secondary'" );
				if($this->session->userdata('ADMIN'))
					echo form_button(array('id' => 'button-cancel','class' => 'btn btn-secondary', 'content' => $this->lang->line('batal'), 'onClick' => "location.href='".site_url()."pejabat'" ));
			}
			else
			{
				echo form_button(array('id' => 'button-cancel','class' => 'btn-secondary', 'content' => 'Kembali', 'onClick' => "location.href='".site_url()."pejabat'" ));
			}
		?>
	</div>

<?php echo form_close(); ?>
</div></div>
</div>
<script type='text/javascript'>
	//Validasi di client
	$(document).ready(function()
	{
		$('#user_form').validate({
			errorLabelContainer: "#error",
			wrapper: "li",
			rules: 
			{
				nama: "required"
			}
		});
	});
</script>