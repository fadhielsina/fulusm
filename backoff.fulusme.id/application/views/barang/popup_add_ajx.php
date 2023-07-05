
<?php
	echo form_open('klien/'.$form_act, 'id="klien_form"');

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
	
	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">	
			<tr>
			<th><?php echo form_label('Divisi *','nama'); ?></th>
			<td>
				<select name="divisi" >
					<option value="C">Car (C)</option>	
					<option value="B">Instalasi (B)</option>
					<option value="S">SO (S)</option>
										</select>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Nama *','nama'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nama';
					$data['class'] = 'form-control';
					$data['value'] = (set_value('nama')) ? set_value('nama') : $client_data['memberFullName'];
					$data['title'] = "Nama tidak boleh kosong";
					echo form_input($data);
				?>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('No Identitas *','identitasno'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'no_identitas';
					$data['value'] = (set_value('alamat')) ? set_value('memberKTP') : $client_data['memberKTP'];
					$data['title'] = "Identitas tidak boleh kosong";						
					echo form_input($data);
				?>
			</td>
		</tr>			
		<tr>
			<th><?php echo form_label('NPWP','npwp'); ?></th>
			<td>
				<?php 
					$nomor['title'] = "NPWP harus diisi dengan angka";	
					if ($act == 'view') $nomor['disabled'] = TRUE;

					$nomor['name'] = $nomor['id'] = 'npwp';
					$nomor['maxlength']='2';
					$nomor['size']='4';
					$nomor['value'] = (set_value('npwp')) ? set_value('npwp') : substr($client_data['memberNPWP'], 0, 2);
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp1';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					$nomor['value'] = (set_value('npwp1')) ? set_value('npwp1') : substr($client_data['memberNPWP'], 2, 3);
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp2';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					$nomor['value'] = (set_value('npwp2')) ? set_value('npwp2') : substr($client_data['memberNPWP'], 5, 3);
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp3';
					$nomor['maxlength']='1';
					$nomor['size']='2';
					$nomor['value'] = (set_value('npwp3')) ? set_value('npwp3') : substr($client_data['memberNPWP'], 8, 1);
					echo form_input($nomor);

					echo "&nbsp;-";

					$nomor['name'] = $nomor['id'] = 'npwp4';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					$nomor['value'] = (set_value('npwp4')) ? set_value('npwp4') : substr($client_data['memberNPWP'], 9, 3);
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp5';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					$nomor['value'] = (set_value('npwp5')) ? set_value('npwp5') : substr($client_data['memberNPWP'], 12, 3);
					echo form_input($nomor);
				?>							
			</td>
		</tr>						
		<tr>
			<th><?php echo form_label('Alamat *','alamat'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'alamat';
					$data['value'] = (set_value('alamat')) ? set_value('alamat') : $client_data['memberAddress'];
					$data['title'] = "Alamat tidak boleh kosong";						
					echo form_input($data);
				?>
			</td>
		</tr>									
		<tr>
			<th><?php echo form_label('Telpon *','telpon'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'telpon';
					$data['value'] = (set_value('telpon')) ? set_value('telpon') : $client_data['memberPhone'];
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
					$data['value'] = (set_value('email')) ? set_value('email') : $client_data['memberEmail'];
					$data['title'] = "Email harus diisi dengan format email yang benar. Contoh : klien@frigia.com";			
					echo form_input($data);
				?>
			</td>
		</tr>																																													
	</table>
	
	<div class="buttons">
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