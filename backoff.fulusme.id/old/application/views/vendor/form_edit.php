<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>

<?php
	echo form_open('supplier/'.$form_act, 'id="klien_form"');

	echo "<div id='error' class='error-message' ";

	if($this->session->userdata('ERRMSG_ARR'))
	{
		echo ">";
		echo $this->session->userdata('ERRMSG_ARR');
		$this->session->unset_userdata('ERRMSG_ARR');
	}
	else
	{
		echo "style='display:none'>";
	}
	
	echo "</div>";

	$data['class'] = 'input';
	if ($act == 'view') $data['disabled'] = TRUE;
?>
	
	<table class="table color-table info-table" cellpadding="2" cellspacing="0">	
			<tr>
			<th><?php echo form_label('Kode Entitas','nama'); ?></th>
			<td>
				<select name="entitas" id="entitas">
				<?php $en=$client_data['entitas']; 
				      if($en=='A')
					  {
						  $sel_a="selected";
						   $sel_i="";
						    $sel_e="";
					  }
					  else if($en=='I')
					  {
						  $sel_a="";
						   $sel_i="selected";
						    $sel_e="";
					  }
					  else 
						  {
						  $sel_a="";
						   $sel_i="";
						    $sel_e="selected";
					  }
				?>
				

					<option value="A" <?php echo $sel_a; ?>> (A)</option>	
					<option value="I" <?php echo $sel_i; ?>>Internal (I)</option>
					<option value="E" <?php echo $sel_e; ?>>Eksternal (E)</option>
										</select>
			</td>
		</tr>		
		<tr>
			<th><?php echo form_label('Nama ','nama'); ?></th>
			<td>
				<?php 
					$data['class'] ='form-control';
					$data['name'] = $data['id'] = 'nama';
					$data['value'] = (set_value('nama')) ? set_value('nama') : $client_data['supplierName'];
					$data['title'] = "Nama tidak boleh kosong";
					echo form_input($data);
				?>
			</td>
		</tr>	
							
		<tr>
			<th><?php echo form_label('Alamat ','alamat'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'alamat';
					$data['value'] = (set_value('alamat')) ? set_value('alamat') : $client_data['supplierAddress'];
					$data['title'] = "Alamat tidak boleh kosong";						
					echo form_textarea($data);
				?>
			</td>
		</tr>									
		<tr>
			<th><?php echo form_label('Telpon ','telpon'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'telpon';
					$data['value'] = (set_value('telpon')) ? set_value('telpon') : $client_data['supplierPhone'];
					$data['title'] = "Telpon tidak boleh kosong";
					echo form_input($data);
				?>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Email','email'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'email';
					$data['value'] = (set_value('email')) ? set_value('email') : $client_data['supplierEmail'];
					$data['title'] = "Email harus diisi dengan format email yang benar. Contoh : klien@wmu.com";			
					echo form_input($data);
				?>
			</td>
		</tr>				
		<tr>
			<th><?php echo form_label('PIC','pic'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'pic';
					$data['value'] = (set_value('pic')) ? set_value('pic') : $client_data['supplierContactPerson'];		
					echo form_input($data);
				?>
			</td>
		</tr>					
	</table>
	
	<div class="buttons pull-left">
		<?php 
			if($act!='view')
			{ 
				echo form_submit('simpan','Simpan', "id = 'button-save'" );
				echo form_reset('reset','Reset', "id = 'button-reset'" );
				echo form_button(array('id' => 'button-cancel', 'content' => 'Batal', 'onClick' => "location.href='".site_url()."klien'" ));
			}
			else
			{
				echo form_button(array('id' => 'button-cancel', 'content' => 'Kembali', 'onClick' => "location.href='".site_url()."klien'" ));
			}
		?>				
	</div>

<?php echo form_close(); ?>

</div>	
</div>	
</div>	
