
<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-edit"></i> <?php echo $title; ?></h3>
<?php
	echo form_open('unit_com/'.$form_act, array('id' => 'jurnal_form','id' => 'user_form', 'class' => 'form-material m-t-40'));

	$data['class'] = 'input';
	if ($act == 'view') $data['disabled'] = TRUE;
?>

	<table class="table">
	<tr>
			<th>Kode Perusahaan / Unit</th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'kdunit';
					$data['value'] = (set_value('kdunit')) ? set_value('kdunit') : $user_data['identityCode'];
					$data['class'] ='form-control';
					$data['title'] = $this->lang->line('valid_nama_depan');
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<th>Nama Perusahaan / Unit</th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nmunit';
					$data['value'] = (set_value('nmunit')) ? set_value('nmunit') : $user_data['identityName'];
					$data['class'] ='form-control';
					$data['title'] = $this->lang->line('valid_nama_depan');
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<th>Alamat</th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'addrunit';
					$data['value'] = (set_value('addrunit')) ? set_value('addrunit') : $user_data['identityAddress'];
					$data['title'] = $this->lang->line('valid_nama_belakang');
					echo form_input($data);
				?>
			</td>			
		</tr>
		<tr>
			<th>No Telp</th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'hpunit';
					$data['value'] = (set_value('hpunit')) ? set_value('hpunit') : $user_data['identityPhone'];
					$data['title'] = $this->lang->line('valid_username');
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<th>PIC</th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'picunit';
					$data['value'] = (set_value('picunit')) ? set_value('picunit') : $user_data['identityOwner'];
					$data['title'] = $this->lang->line('valid_username');
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr >
			<th>Perusahaa/Unit Induk</th>
			<td>

			<select name="ho_unit" class="form-control">
			
			<?php
			 foreach ($lokasi_data as $lokasi_data):
			 if($lokasi_data->identityID==$user_data['identityHead'])
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
