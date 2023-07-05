<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>

<?php
	echo form_open('barang/'.$form_act, 'id="klien_form"');

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
			<th><?php echo form_label('Kode Barang ','kode'); ?></th>
			<td>
				<?php 
					$dataa['class'] ='form-control col-md-3';
					$dataa['name'] = $dataa['id'] = 'procode';
					$dataa['value'] =$client_data['barangBarcode'];
					$dataa['readonly'] ='readonly';
					echo form_input($dataa);
				?>
			</td>
		</tr>	
			<tr>
			<th><?php echo form_label('Jenis Barang','nama'); ?></th>
			<td>
			<select name="kategori" class="form-control col-md-6">
									
											<?php foreach ( $kategori_data as $kategori_data ){?>
											<option value="<?=$kategori_data->id_kat_barang;?>" <?php if($kategori_data->id_kat_barang==$client_data['id_kat_barang']) echo 'selected="selected"'; ?> > <?php echo $kategori_data->nama_kategori; ?></option>
											<?php }?>
												
										</select>
			</td>
		</tr>		
		<tr>
			<th><?php echo form_label('Satuan 1','nama'); ?></th>
			<td>
			<select name="satuan1" class="form-control col-md-6">
										
			<?php foreach ( $satuan1 as $satuan1 ){?>
			<option value="<?=$satuan1->satuanID;?>" <?php if($satuan1->satuanID==$client_data['satuanID']) echo 'selected="selected"'; ?> > <?php echo $satuan1->satuanName; ?></option>
			<?php }?>								
												
										</select>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Satuan 2','nama'); ?></th>
			<td>
			<select name="satuan2" class="form-control col-md-6">
			<?php foreach ( $satuan2 as $satuan2 ){?>
			<option value="<?=$satuan2->satuanID;?>" <?php if($satuan2->satuanID==$client_data['satuanID2']) echo 'selected="selected"'; ?> > <?php echo $satuan2->satuanName; ?></option>
			<?php }?>	
												
										</select>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Nama ','nama'); ?></th>
			<td>
				<?php 
					$data['class'] ='form-control';
					$data['name'] = $data['id'] = 'nama';
					$data['value'] = (set_value('nama')) ? set_value('nama') : $client_data['barangName'];
					$data['title'] = "Nama tidak boleh kosong";
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
