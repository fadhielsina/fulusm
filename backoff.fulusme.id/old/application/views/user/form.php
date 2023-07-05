<br/>
<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>
<?php
	echo form_open('user/'.$form_act, array('id' => 'jurnal_form','id' => 'user_form', 'class' => 'form-material m-t-40'));

	$data['class'] = 'input';
	if ($act == 'view') $data['disabled'] = TRUE;
?>

	<table class="table">
		
		<tr>
			<th><?php echo form_label($this->lang->line('username').'*','username'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'username';
					$data['value'] = (set_value('username')) ? set_value('username') : $user_data['username'];
					$data['title'] = $this->lang->line('valid_username');
					$data['class'] = 'form-control';
					echo form_input($data);
				?>
			</td>
		</tr>
		<?php if($this->session->userdata('ADMIN')) { $lokhidden='';} else { $lokhidden='hidden';} ?>
		<tr <?php echo $lokhidden; ?>>
			<th>Unit / Segmen</th>
			<td>

			<select name="lokasi" class="form-control">
			
			<?php
			 foreach ($lokasi_data as $lokasi_data):
			 if($lokasi_data->identityID==$user_data['identity_id'])
			 {
				 ?>
				 <option value="<?php echo $lokasi_data->identityID ?>" SELECTED ><?php echo $lokasi_data->identityName ?></option>
			 <?php } else { ?>
			 <option value="<?php echo $lokasi_data->identityID ?>" ><?php echo $lokasi_data->identityName ?></option>
			 <?php } ?>
			 <?php endforeach ?>
												
			</select> 
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('hak_akses').'*','level_akses'); ?></th>
			<td>
				
			<select name="level_akses" class="form-control">
			
			<?php
			foreach ($level_data as $item_level):
			?>
			<option value="<?php echo $item_level['id_level'] ?>" <?php echo $item_level['id_level'] == $user_data['level_akses'] ? 'selected' : ''; ?>><?php echo $item_level['nama_level'] ?></option>
			 <?php endforeach ?>							
			</select> 
			</td>
		</tr>
		<tr>
			<th>
				<?php
					$password_label = ($act=='add') ? 'Password *' : 'Password';  
					echo form_label($password_label,'password');
				?>
			</th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'password';
					$data['value'] = '';
					if($act=='add') $data['title'] = $this->lang->line('valid_password'); else unset($data['title']);
					echo form_password($data);
				?>
			</td>
		</tr>
		<?php if($this->session->userdata('ADMIN')) { ?>
		<tr>
			<th><?php echo form_label('Administrator','administrator'); ?></th>
			<td>
				<?php 
					$administrator['name'] = $administrator['id'] = 'administrator';
					$administrator['value'] = '1';
					$administrator['style'] = 'opacity:1;position:relative;left:auto';
					
					if ($user_data['administrator'] == 1 || set_value('administrator') == 1) {
						$administrator['checked'] = TRUE;
					}
					if ($act == 'view') {
						$administrator['disabled'] = TRUE;
					}
					echo form_checkbox($administrator);
				?>									
			</td>
		</tr>
		<?php } ?>
		<?php if($act=='edit') { ?>
		<?php if($this->session->userdata('SESS_USER_ID')!=$user_data['id']) {
			if($this->session->userdata('ADMIN')) { ?>
		<tr>
			<th><?php echo form_label('Reset Password','reset'); ?></th>
			<td>
				<?php 
					$resetpass['name'] = $resetpass['id'] = 'reset_pass';
					$resetpass['value'] = '1';
					echo form_checkbox($resetpass);
				?>									
			</td>
		</tr>
		<?php } } } 
		if(($this->session->userdata('SESS_USER_ID')==$user_data['id'])||($this->session->userdata('ADMIN'))) { ?> 
		<tr class="reset-passwd-tr">
			<th>
				<?php
					$password_label = ($act=='add') ? 'Password *' : 'Password';  
					echo form_label($password_label,'password');
				?>
			</th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'password';
					$data['value'] = '';
					if($act=='add') $data['title'] = $this->lang->line('valid_password'); else unset($data['title']);
					echo form_password($data);
				?>
			</td>
		</tr>
		<tr class="reset-passwd-tr">
			<th><?php echo form_label($this->lang->line('ulangi').$password_label,'cpassword'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'cpassword';
					$data['value'] = '';
					$data['title'] = $this->lang->line('valid_ulang_password');
					echo form_password($data);
				?>	
			</td>
		</tr>
		<?php }  ?>
	</table>
  <hr/>
	<div class="buttons pull-left">
		<?php 
			if($act!='view')
			{ 
				echo form_submit('simpan', $this->lang->line('simpan'), "id = 'button-save' class='btn btn-secondary'" );
				echo form_reset('reset','Reset', "id = 'button-reset' class='btn btn-secondary'" );
				if($this->session->userdata('ADMIN'))
					echo form_button(array('id' => 'button-cancel','class' => 'btn btn-secondary', 'content' => $this->lang->line('batal'), 'onClick' => "location.href='".site_url()."user'" ));
			}
			else
			{
				echo form_button(array('id' => 'button-cancel','class' => 'btn-secondary', 'content' => 'Kembali', 'onClick' => "location.href='".site_url()."user'" ));
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
				fname: "required lettersonly",
				lname: "required lettersonly",
				username: "required alphanumeric",
				<?php if($act=='add') echo 'password: "required",'; ?>
				cpassword: {
					equalTo: "#password"
				}
			}
		});
		if ( ! $('#reset_pass').is(':checked') ) {
			$('.reset-passwd-tr').hide();
		}
		$('#reset_pass').on('click', function(){
			if ( $(this).is(':checked') ) {
				$('.reset-passwd-tr').show();
			} else {
				$('.reset-passwd-tr').hide();
			}
		});
	});
</script>