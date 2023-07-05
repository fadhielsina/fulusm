<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>

<?php
	echo form_open('barang_kategori/'.$form_act, 'id="klien_form"');

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
			<th><?php echo form_label('Nama Kategori','nama'); ?></th>
			<td>
				<?php 
					$data['class'] ='form-control';
					$data['name'] = $data['id'] = 'nama';
					$data['value'] = (set_value('nama')) ? set_value('nama') : $client_data['nama_kategori'];
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
