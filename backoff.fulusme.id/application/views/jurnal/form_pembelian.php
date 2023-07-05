<script type="text/javascript" src="<?php echo base_url();?>js/jurnal.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js"></script>
<br/><br/>
<div class="col-lg-12">	<h3 class="badge badge-info"><?php echo $title; ?></h3></div><br/><br/><br/>

<div class="post-body">
<div id="dialog-form"></div>
<div class="panel panel-info">
  <div class="panel-heading">FORM TAMBAH DATA</div>
  <div class="panel-body">
<?php
	echo form_open('jurnal/insert', array('id' => 'jurnal_form', 'onsubmit' => 'return cekData();'));

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

	
	<div class="col-lg-6">
	<div class="panel panel-info">
  <div class="panel-body">
	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
		<tr>
			<th><?php echo form_label('Tanggal *','tanggal'); ?></th>
			<td>
				<?php 
					$datatgl['name'] = 'tanggal';
					$datatgl['id'] = 'datepicker';
					$datatgl['value'] = date('Y-m-d');
					$datatgl['title'] = "Tanggal tidak boleh kosong dan harus diisi dengan format dddd-mm-yy";	
					echo form_input($datatgl);
				?>
			</td>				 
		</tr>		
		
		<tr>
			<th><?php echo form_label('Deskripsi*','deskripsi'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'deskripsi';					
					$data['title'] = "Deskripsi tidak boleh kosong";
					$data['rows'] = "2";
					echo form_textarea($data);
				?>
			</td>
		</tr>	
	</table>
	</div>
	</div>
	</div>
	<div class="col-lg-6">	
	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
	<tr>
			<th><?php echo form_label('Nomor Dokumen*','nomor'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nomorinvoice';
					$data['title'] = "Nomor invoice tidak boleh kosong";
					$data['class'] = "form-control";
					echo form_input($data);
				?>
			</td>				
		</tr>		
		<tr>
			<th><?php echo form_label('Jumlah','jumlah'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'jumlah';
					$data['title'] = "Jumlah tidak boleh kosong";
					$data['class'] = "form-control";
					echo form_input($data);
				?>
			</td>				
		</tr>		
		<tr>
			<th><?php echo form_label('Vendor','nomor'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'vendor';
					$data['title'] = "Vendor tidak boleh kosong";
					$data['class'] = "form-control";
					echo form_input($data);
				?>
			</td>				
		</tr>		
		</table>
	</div>
	</div>
	</div>
 
 <div class="panel panel-info">
  <div class="panel-heading">DETAIL JURNAL</div>
  <div class="panel-body">
  <div class="col-lg-12">	
   <br/><br/>
	<table id="tblDetail" name="tblDetail" class="data-table">
		<tr>
			<th>Akun</th>
			<th>Debit</th>
			<th>Kredit</th>	
			<th>Keterangan</th>			
		</tr>
		<?php for ($i = 1; $i <= 2; $i++) { ?>
			<tr>
				<td>
					<?php 
						$akun['id'] = 'akun'.$i;
						$akun['class'] = 'combo';
						echo form_dropdown('akun[]', $accounts, '' ,$akun);
					?>
				</td>
				<td>
					<?php 
						$data['id'] = 'debit'.$i;
						$data['name'] = 'debit'.$i;
						$data['class'] = 'field';
						$data['onBlur'] = "cekDebit($i)";
						$data['title'] = "Debit harus diisi dengan angka";
						echo form_input($data);
					?>
				</td>
				<td>
					<?php 
						$data['id'] = 'kredit'.$i;
						$data['name'] = 'kredit'.$i;
						$data['class'] = 'field';
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
	<div class="addRow"><a href="javascript:addRow();" class="btn btn-danger btn-sm"><span style="color:#fff;">TAMBAH BARIS</span></a></div>
	
	<div class="buttons">
		<?php
			echo form_submit('post','Post', "id = 'button-save'" );
			echo form_reset('reset','Reset', "id = 'button-reset'" );
		?>
	</div>
	
<?php echo form_close(); ?>
</div>
</div>
</div>
</div>

<script type='text/javascript'>
	//Validasi di client
	$(document).ready(function()
	{
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
	});
</script>
<script type="text/javascript" charset="utf-8">
jQuery.noConflict();
	$(function() {
		$('#dialog-form').load('<?php echo site_url(); ?>vendor/popup');
		$("#dialog-form").dialog({
			autoOpen: false,
			title: 'Vendor',
			height: 560,
			width: 900,
			modal: true,
			buttons: {
				'OK': function() {
					var chkIdx = $('input:radio:checked').val();
					var aData = popup_table.fnGetData(chkIdx);
					$("#memberID").val(aData[0]);
					$("#memberCode").val(aData[1]);
					$("#trxFullName").val(aData[2]);
					$("#memberAddress").val(aData[3]);
					$("#memberPhone").val(aData[4]);
					$(this).dialog('close');
				},
				'Batal': function() {
					$(this).dialog('close');
				}
			},
		});

		$('#vendor').focus(function() {
				$('#dialog-form').dialog('open');
			});

	});
	
	
</script>