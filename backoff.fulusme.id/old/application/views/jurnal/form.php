<script type="text/javascript" src="<?php echo base_url();?>js/jurnal.js"></script>

<div class="col-lg-12">	

<div class="post-body">
<?php echo form_open('jurnal/insert_ju', array('id' => 'jurnal_form','class' => 'form-material m-t-40', 'onsubmit' => 'return cekData();')); ?>
<div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('form_tambah_data') ?></h4>
<?php

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

	echo form_hidden('f_id', $f_id);
	echo form_hidden('goto', current_url());

	$data['class'] = 'input';	
?>	


	
	<div class="col-lg-12">
	<table class="table color-table info-table">
	<tr>
			<th>Jenis Jurnal</th>
			<td>
					<select name="jnsjrn" id="jnsjrn" class="form-control" style="width:50%;">
					<option value="ju" > Jurnal Umum</option>	
					<option value="juc" > Jurnal Umum ( Customer )</option>	
					<option value="juv">Jurnal Umum ( Vendor )</option>
					<option value="JPE">Jurnal Penyesuaian</option>
										</select>
			</td>				
		</tr>
			<tr id="divven">			
			<th>Vendor</th>
			<td>
					<select id="supplier" name="supplier" class="form-control" style="width:50%;">
										<option value="tesestsetsetsetse">Cari Supplier ...</option>
										<?php foreach ($supplier as $row) : ?>
											<option value="<?= $row->supplierID ?>"><?= $row->supplierName ?></option>
										<?php endforeach; ?>
									</select>
			</td>				
		</tr>	
		<tr id="divcus">
			<th>Customer</th>
			<td>
					<select id="member" name="member" class="form-control" style="width:50%;">
										<option value="">Cari Customer ...</option>
										<?php foreach ($members as $row) : ?>
											<option value="<?= $row->memberID ?>"><?= $row->memberFullName ?></option>
										<?php endforeach; ?>
									</select>		
	
			</td>				
		</tr>			
		<tr>
			<th><?php echo form_label($this->lang->line('no_invoice_dokumen').'*','nomor'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nomorinvoice';
					$data['title'] = "Nomor invoice tidak boleh kosong";
					$data['class'] = "form-control";
					$val = ($this->input->post('nomorinvoice')?$this->input->post('nomorinvoice'):set_value('nomorinvoice'));
					echo form_input($data,$val);
				?>
			</td>				
		</tr>		
		<tr>
			<th>Keterangan</th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'keterangan';					
					$data['title'] = "Deskripsi tidak boleh kosong";
					$data['rows'] = "2";
					echo form_textarea($data);
				?>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label($this->lang->line('tanggal').'*','tanggal'); ?></th>
			<td>
				<input type="date" class="form-control col-lg-6" required id="tanggal" name="tanggal">
			</td>				 
		</tr>		
		
		</table>
	</div>
		</div>
			</div>
 
 <div class="card">
  <div class="card-body">
  <h4 class="card-title"><?= $this->lang->line('jurnal') ?> </h4>
  <div class="col-lg-12">	
   <br/><br/>
   	<table id="tblDetail" name="tblDetail" class="table" data-disable-validate-akun="1">
		<tr>
			<th><?= $this->lang->line('akun') ?></th>
			<th><?= $this->lang->line('debit') ?></th>
			<th><?= $this->lang->line('kredit') ?></th>	
			<th><?= $this->lang->line('keterangan') ?></th>			
		</tr>
		<?php for ($i = 1; $i <= 2; $i++) { ?>
			<tr>
				<td>
					<?php 
						$akun['id'] = 'akun'.$i;
						$akun['class'] = 'form-control';
						echo form_dropdown('akun[]', $accounts, '' ,$akun);
					?>
				</td>
				<td>
					<?php 
						$data['id'] = 'debit'.$i;
						$data['name'] = 'debit'.$i;
						$data['class'] = 'form-control';
						$data['onBlur'] = "cekDebit($i)";
						$data['title'] = "Debit harus diisi dengan angka";
						echo form_input($data);
					?>
				</td>
				<td>
					<?php 
						$data['id'] = 'kredit'.$i;
						$data['name'] = 'kredit'.$i;
						$data['class'] = 'form-control';
						$data['onBlur'] = "cekKredit($i)";
						$data['title'] = "Kredit harus diisi dengan angka";
						echo form_input($data);
					?>
				</td>
				<td>
					<?php 
						$data['id'] = 'keterangan'.$i;
						$data['class'] = 'form-control';
						$data['name'] = 'keterangan'.$i;
						echo form_input($data);
					?>
				</td>
			</tr>
		<?php } ?>
	</table>
	<br/>
	<div class="pull-right">
		<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#jur-template-modal">Load Template</button>
		<a href="javascript:addRow();" class="btn btn-danger btn-sm"><span style="color:#fff;"><?= $this->lang->line('tambah_baris') ?></span></a>
	</div>
	
	<div class="pull-left">
		<?php
			echo form_submit('post','Post', "id = 'button-save'" );
			echo form_reset('reset','Reset', "id = 'button-reset'" );
		?>
	</div>
	

</div>
</div>
</div>
<?php echo form_close(); ?>
</div>

<div class="modal fade" id="jur-template-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Jurnal Template</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            	<div class="form-group">
            		<label>Select Template: </label>
            		<select id="find-template-select" class="form-control" style="width: 100%;">
            			<?php foreach( $template as $temp ): ?>
            			<option value="<?php echo htmlspecialchars($temp->akun_data); ?>"><?php echo $temp->nama_template; ?></option>
            			<?php endforeach; ?>	
            		</select>
            	</div>
            	<div class="form-group">
            		<button type="button" id="find-template-submit" class="btn btn-primary btn-block">Pasang</button>
            	</div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div style="display:none;">
	<?php $akun['id'] = 'akun_template';
		$akun['class'] = 'form-control';
		echo form_dropdown('akun[]', $accounts, '' ,$akun); 
	?>
</div>

<script type='text/javascript'>
	//Validasi di client
	$(document).ready(function()
	{
		//$('#jurnal_form').submit(function(){
			$('#jurnal_form').validate({
				errorLabelContainer: "#error",
				wrapper: "li",
				rules: 
				{
					nomor: "required",
					tanggal: "required dateISO",
					debit1: "integer",
					kredit1: "integer",
					debit2: "integer",
					kredit2: "integer"
				}
			});

			$('#find-template-submit').on('click', function(event){
				event.preventDefault();
				var data = $('#find-template-select').val(),
					tbl = $('#tblDetail');
				if ( data ) data = $.parseJSON(data);

				if ( data ) {
					tbl.find('tr').eq(0).nextAll().remove();
					$.each(data, function(k, v){
						var lastRow = k + 1;
						var ddlAkun = '<select name="akun[]" id="akun'+lastRow+'" class="form-control form-control-line" >';
							ddlAkun += $("#akun_template").html();
							ddlAkun += '</select>',
							nilai = v.nilai ? v.nilai : '0';
							valDebit = v.debit_kredit == '1' ? nilai : '',
							valKredit = v.debit_kredit == '1' ? '' : nilai;
							
							var txtDebit = '<input name="debit'+lastRow+'" id="debit'+lastRow+'" class="form-control form-control-line" title="Debit harus diisi dengan angka" onBlur="cekDebit('+lastRow+');" value="'+valDebit+'" />';
							var txtKredit = '<input name="kredit'+lastRow+'" id="kredit'+lastRow+'" class="form-control form-control-line" title="Kredit harus diisi dengan angka" onBlur="cekKredit('+lastRow+');" value="'+valKredit+'" />';
							var txtKeterangan = '<input name="keterangan'+lastRow+'" id="keterangan'+lastRow+'" class="form-control form-control-line" title="Keterangan akun" />';
							tbl.children().append("<tr><td>"+ddlAkun+"</td><td>"+txtDebit+"</td><td>"+txtKredit+"</td><td>"+txtKeterangan+"</td></tr>");
							tbl.find('#akun'+lastRow).val(v.akun_id).trigger('change');
							$("#debit"+lastRow).rules("add", "integer");
							$("#kredit"+lastRow).rules("add", "integer");
							$("#keterangan"+lastRow).rules("add", "integer");
					});
					reload_select();
					$('#jur-template-modal').modal('hide');	
				}

				console.log(typeof data, data, 'data');
			});
		//});
	});
</script>

<script>  
 $("#divven").hide();
  $("#divcus").hide();
$(document).ready(function(){
    $('#jnsjrn').on('change', function() {
      if ( this.value == 'juc')
      {
        $("#divcus").show();
		$("#divven").hide();
      }
	 else if ( this.value == 'juv')
	  {
		 $("#divcus").hide();
		$("#divven").show();
	  }
      else
      {
        $("#divven").hide();
		$("#divcus").hide();
      }
    });
});
</script>
