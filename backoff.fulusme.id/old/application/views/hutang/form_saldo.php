<div class="post-body">
<div class="card">
  <div class="card-body">
  <h3 class="card-title"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>

<?php
	echo form_open('hutang/'.$form_act, 'id="klien_form"');

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
			<th><?php echo form_label('No Dokumen / Bukti ','no_bukti'); ?></th>
			<td>
				<?php 
					$data['class'] ='form-control col-md-6';
					$data['name'] = $data['id'] = 'no_bukti';
					$data['title'] = "No Bukti tidak boleh kosong";
					echo form_input($data);
				?>
			</td>
		</tr>	
							
		<tr>
			<th><?php echo form_label('Tanggal ','tgl'); ?></th>
			<td>
				<input type="date" class="form-control col-md-3" required id="tgl_saldo" name="tgl_saldo">
			</td>
		</tr>									
		<tr>
			<th><?php echo form_label('Supplier ','supplier'); ?></th>
			<td>
				<select id="supplier" name="supplier" class="form-control col-md-6" required>
										<option value="">Cari Supllier ...</option>
										<?php foreach ($suppliers as $row) : ?>
											<option value="<?= $row->supplierID ?>"><?= $row->supplierName ?></option>
										<?php endforeach; ?>
				</select>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Akun Saldo (Debit)','ap'); ?></th>
			<td>
				<select class="form-control col-md-6" name="akun_ap_d" required="">
								<?php foreach ($nama_akun2 as $row) : ?>
									<option value="<?= $row->akun_id ?>" selected><?= $row->nama . ' - ' . $row->kode ?></option>
								<?php endforeach; ?>
							</select>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Akun Saldo (Kredit)','ap'); ?></th>
			<td>
				<select class="form-control col-md-6" name="akun_ap_k" required="">
								<?php foreach ($nama_akun as $row) : ?>
									<option value="<?= $row->akun_id ?>" selected><?= $row->nama . ' - ' . $row->kode ?></option>
								<?php endforeach; ?>
							</select>
			</td>
		</tr>				
		<tr>
			<th><?php echo form_label('Saldo Awal','saldo'); ?></th>
			<td>
			      <input name="saldo" id="saldo" class="form-control" type="text"  style="width:335px;" onkeyup="formatNumber(this);" onchange="formatNumber(this);">
				
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Keterangan ','keterangan'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'keterangan';				
$data['value'] = 'Saldo Awal Utang';						
					echo form_textarea($data);
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



<script>
function formatNumber(input)
{
    var num = input.value.replace(/\,/g,'');
    if(!isNaN(num)){
    if(num.indexOf('.') > -1){
    num = num.split('.');
    num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
    if(num[1].length > 2){
    alert('You may only enter two decimals!');
    num[1] = num[1].substring(0,num[1].length-1);
    } input.value = num[0]+'.'+num[1];
    } else{ input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'') };
    }
    else{ alert('Anda hanya diperbolehkan memasukkan angka!');
    input.value = input.value.substring(0,input.value.length-1);
    }
}
</script>