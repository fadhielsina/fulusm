<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>

<?php
	echo form_open('anggaran/'.$form_act, 'id="klien_form"');
?>
	
	<table class="table color-table info-table" cellpadding="2" cellspacing="0">	
			<tr>
			<th><?php echo form_label(' Akun','nama'); ?></th>
			<td>
			<select name="akun" class="form-control col-md-6">
									
											<?php foreach ( $akun as $akun ){?>
											<option value="<?=$akun->akun_id;?>" <?php if($akun->akun_id==$mapping_data['id_akun']) echo 'selected="selected"'; ?> > <?php echo $akun->nama; ?></option>
											<?php }?>
												
										</select>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Nominal ','kode'); ?></th>
			<td>
				<?php 
					$dataa['class'] ='form-control col-md-3';
					$dataa['name'] = $dataa['id'] = 'nominal';
					$dataa['value'] =$mapping_data['nominal'];
					echo form_input($dataa);
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
				echo form_button(array('id' => 'button-cancel', 'content' => 'Batal', 'onClick' => "location.href='".site_url()."anggaran/mapping'" ));
			}
			else
			{
				echo form_button(array('id' => 'button-cancel', 'content' => 'Kembali', 'onClick' => "location.href='".site_url()."anggaran/mapping'" ));
			}
		?>				
	</div>

<?php echo form_close(); ?>

</div>	
</div>	
</div>	
