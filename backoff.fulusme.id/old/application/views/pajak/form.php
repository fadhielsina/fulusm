<br/>
<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>

<?php
	echo form_open('pajak/action',array('id' => 'jurnal_form','id' => 'pajak_form', 'class' => 'form-material m-t-40'));
	
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

	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}

	$data['class'] = 'input';
?>	
						
		<table class="table color-table info-table">					  
		<tr>
			<th><?php echo form_label($this->lang->line('npwp').'*','npwp'); ?></th>
			<td>				
				<?php 
					$nomor['title'] = $this->lang->line('valid_npwp');						

					$nomor['name'] = $nomor['id'] = 'npwp';
					$nomor['maxlength']='2';
					$nomor['size']='4';			
					
					$nomor['value'] = (set_value('npwp')) ? set_value('npwp') : substr($pajak_data['npwp'], 0, 2);	
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp1';
					$nomor['maxlength']='3';
					$nomor['size']='5';		
					$nomor['value'] = (set_value('npwp1')) ? set_value('npwp1') : substr($pajak_data['npwp'], 2, 3);				
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp2';
					$nomor['maxlength']='3';
					$nomor['size']='5';	
					$nomor['value'] = (set_value('npwp2')) ? set_value('npwp2') : substr($pajak_data['npwp'], 5, 3);			
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp3';
					$nomor['maxlength']='1';
					$nomor['size']='2';
					$nomor['value'] = (set_value('npwp3')) ? set_value('npwp3') : substr($pajak_data['npwp'], 8, 1);			
					echo form_input($nomor);

					echo "&nbsp;-";

					$nomor['name'] = $nomor['id'] = 'npwp4';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					$nomor['value'] = (set_value('npwp4')) ? set_value('npwp4') : substr($pajak_data['npwp'], 9, 3);	
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp5';
					$nomor['maxlength']='3';
					$nomor['size']='5';		
					$nomor['value'] = (set_value('npwp5')) ? set_value('npwp5') : substr($pajak_data['npwp'], 12, 3);			
					echo form_input($nomor);
				?>							
			</td>
		</tr>					
		<tr>
			<th><?php echo form_label($this->lang->line('nama_wajib_pajak').'*','nama_wp'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nama_wp';
					$data['class'] ='form-control';
					$data['value'] = (set_value('nama_wp')) ? set_value('nama_wp') : $pajak_data['nama'];
					$data['title'] = $this->lang->line('valid_nama_wajib_pajak');	
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('alamat').'*','alamat'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'alamat';	
					$data['value'] = (set_value('alamat')) ? set_value('alamat') : $pajak_data['alamat'];
					$data['title'] = $this->lang->line('valid_alamat');					
					echo form_input($data);
				?>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label($this->lang->line('kota').'*','kota'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'kota';
					$data['value'] = (set_value('kota')) ? set_value('kota') : $pajak_data['kota'];
					$data['title'] = $this->lang->line('valid_kota');					
					echo form_input($data);
				?>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label($this->lang->line('telepon').'*','telpon'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'telpon';	
					$data['value'] = (set_value('telpon')) ? set_value('telpon') : $pajak_data['telpon'];
					$data['title'] = $this->lang->line('valid_telepon');			
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<th><?php echo form_label('Fax','fax'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'fax';	
					$data['value'] = (set_value('fax')) ? set_value('fax') : $pajak_data['fax'];
					unset($data['title']);
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<th><?php echo form_label('Email *','email'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'email';	
					$data['value'] = (set_value('email')) ? set_value('email') : $pajak_data['email'];
					$data['title'] = $this->lang->line('valid_email');			
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('jenis_usaha').'*','jenis'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'jenis';	
					$data['value'] = (set_value('jenis')) ? set_value('jenis') : $pajak_data['jenis_usaha'];	
					$data['title'] = $this->lang->line('valid_jenis_usaha');					
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<th><?php echo form_label($this->lang->line('klu').'*','klu'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'klu';	
					$data['maxlength']='6';	
					$data['value'] = (set_value('klu')) ? set_value('klu') : $pajak_data['klu'];								
					$data['title'] = $this->lang->line('valid_klu');						
					echo form_input($data);
					unset($data['maxlength']);
				?>
			</td>
		</tr>
	</table>

	<?php
		$attributes = array('id' => 'fieldset');
		echo form_fieldset($this->lang->line('data_pemilik'), $attributes);	
	?>	
		<table class="table color-table info-table">
		<tr>
			<th><?php echo form_label($this->lang->line('nama_pemilik').'*','nama_pemilik'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nama_pemilik';
					$data['value'] = (set_value('nama_pemilik')) ? set_value('nama_pemilik') : $pajak_data['pemilik'];						
					$data['title'] = $this->lang->line('valid_nama_pemilik');	
					echo form_input($data);
				?>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label($this->lang->line('npwp').'*','npwp_pemilik'); ?></th>
			<td>
				<?php 
					$nomor['title'] = $this->lang->line('valid_npwp');					

					$nomor['name'] = $nomor['id'] = 'npwp_pemilik';
					$nomor['maxlength']='2';
					$nomor['size']='4';			
					$nomor['value'] = (set_value('npwp_pemilik')) ? set_value('npwp_pemilik') : substr($pajak_data['npwp_pemilik'], 0, 2);
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp_pemilik1';
					$nomor['maxlength']='3';
					$nomor['size']='5';		
					$nomor['value'] = (set_value('npwp_pemilik1')) ? set_value('npwp_pemilik1') : substr($pajak_data['npwp_pemilik'], 2, 3);
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp_pemilik2';
					$nomor['maxlength']='3';
					$nomor['size']='5';	
					$nomor['value'] = (set_value('npwp_pemilik2')) ? set_value('npwp_pemilik2') : substr($pajak_data['npwp_pemilik'], 5, 3);				
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp_pemilik3';
					$nomor['maxlength']='1';
					$nomor['size']='2';
					$nomor['value'] = (set_value('npwp_pemilik3')) ? set_value('npwp_pemilik3') : substr($pajak_data['npwp_pemilik'], 8, 1);			
					echo form_input($nomor);

					echo "&nbsp;-";

					$nomor['name'] = $nomor['id'] = 'npwp_pemilik4';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					$nomor['value'] = (set_value('npwp_pemilik4')) ? set_value('npwp_pemilik4') : substr($pajak_data['npwp_pemilik'], 9, 3);
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp_pemilik5';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					$nomor['value'] = (set_value('npwp_pemilik5')) ? set_value('npwp_pemilik5') : substr($pajak_data['npwp_pemilik'], 12, 3);					
					echo form_input($nomor);
				?>
			</td>
		</tr>
	</table>
	<?php	echo form_fieldset_close(); ?>
		<table class="table color-table info-table">	
		<tr>
			<th><?php echo form_label($this->lang->line('keterangan'),'keterangan'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'keterangan';
					$data['value'] = (set_value('keterangan')) ? set_value('keterangan') : $pajak_data['keterangan'];	
					unset($data['title']);
					echo form_textarea($data);
				?>													
			</td>
		</tr>	
	</table>
	<hr/>
	<div class="buttons pull-left">
		<?php 		
			echo form_submit('simpan',$this->lang->line('simpan'), "id = 'button-save'" );
			echo form_reset('reset','Reset', "id = 'button-reset'" );
		?>
	</div>

<?php echo form_close(); ?>

</div>
</div>
</div>

<script type='text/javascript'>
	//Validasi di client
	$(document).ready(function()
	{
		$('#pajak_form').validate({
			errorLabelContainer: "#error",
			wrapper: "li",
			rules: 
			{
				npwp: "required digits",
				npwp1: "required digits",
				npwp2: "required digits",
				npwp3: "required digits",
				npwp4: "required digits",
				npwp5: "required digits",
				nama_wp: "required",
				alamat: "required",						
				telpon: "required",						
				email: "required email",						
				jenis: "required",										
				klu: "required digits",										
				nama_pemilik: "required",
				npwp_pemilik: "required digits",
				npwp_pemilik1: "required digits",
				npwp_pemilik2: "required digits",
				npwp_pemilik3: "required digits",
				npwp_pemilik4: "required digits",
				npwp_pemilik5: "required digits"
			}
		});
	});
</script>
