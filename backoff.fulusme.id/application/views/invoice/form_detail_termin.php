

<div class="col-lg-12">
<div class="card">
  <div class="card-body">
	<div class="post-title"><h3 class="badge badge-info"><?php echo $title; ?></h3></div>
<?php foreach ($invoice_data as $row) { 
	$stp=$row->status_piutang; 
	$receivableID=$row->receivableID;
	$is_pending=$row->is_pending;
	$noinv=$row->invoiceID;
	$totalinv=$row->trxTotal;
	$totalbyar=$row->totalbyr;
	$userinput=$row->nama_depan;
	$is_publish=$row->is_publish;
	$sisa=$row->trxTotal-$row->totalbyr;
}?>
	
<div class="post-body">
	
<?php if($stp!=='2') { ?>	
	<?php echo form_open('invoice/termin_pay_data', array('id' => 'jurnal_form')); ?>	
<div class="row">	
	<div class="col-lg-6">
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
		<tr>
			<th><?php echo form_label('User Input','nomor'); ?></th>
			<td>
				<?php 
					$usein['name'] = $data['id'] = 'usein';
					$usein['class'] = "form-control";
					$usein['value'] =$userinput;
					$usein['readonly'] = "readonly";
					echo form_input($usein);
				?>
			</td>				
		</tr>	
			<tr>
			<th><?php echo form_label('ID. Piutang*','nomor'); ?></th>
			<td>
				<?php 
					$datain_id['name'] = $data['id'] = 'receivableID';
					$datain_id['title'] = "Nomor invoice tidak boleh kosong";
					$datain_id['class'] = "form-control";
					$datain_id['value'] =$receivableID;
					$datain_id['readonly'] = "readonly";
					$datain_id['type'] = "text";
					echo form_input($datain_id);
				?>
			</td>				
		</tr>	
		<tr>
			<th><?php echo form_label('No. Invoice*','nomor'); ?></th>
			<td>
				<?php 
					$datainv['name'] = $data['id'] = 'nomorinvoice';
					$datainv['title'] = "Nomor invoice tidak boleh kosong";
					$datainv['class'] = "form-control";
					$datainv['value'] =$noinv;
					$datainv['readonly'] = "readonly";
					echo form_input($datainv);
				?>
			</td>				
		</tr>	
		<tr>
			<th><?php echo form_label('Total Invoice','total'); ?></th>
			<td>
				<?php 
					$datatot['name'] = 'totalinv';
					$datatot['title'] = "Nomor tidak boleh kosong";
					$datatot['class'] = "form-control";
					$datatot['readonly'] = "readonly";
					$datatot['value'] =number_format($totalinv);
					echo form_input($datatot);
				?>
			</td>				
		</tr>
		<tr>
			<th><?php echo form_label('Total Bayar','total'); ?></th>
			<td>
				<?php 
					$databyr['name'] = 'totalbayar';
					$databyr['title'] = "Nomor tidak boleh kosong";
					$databyr['class'] = "form-control";
					$databyr['readonly'] = "readonly";
					$databyr['value'] =number_format($totalbyar);
					echo form_input($databyr);
				?>
			</td>				
		</tr>
		<tr>
			<th><?php echo form_label('Sisa Bayar','total'); ?></th>
			<td>
				<?php 
					$datasisa['name'] = 'sisabayar';
					$datasisa['title'] = "Nomor tidak boleh kosong";
					$datasisa['class'] = "form-control";
					$datasisa['readonly'] = "readonly";
					$datasisa['value'] =number_format($sisa);
					echo form_input($datasisa);
				?>
			</td>				
		</tr>
			
	</table>
	</div>
	<div class="col-lg-6">	
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
		
		 <tr>
            <td>Jenis Pembayaran</td>
            <td>
              <select class="form-control"  style="width: 200px" name="jns_bayar" id="jns_bayar">
				
				<?php
											 foreach ($jenisbyr as $jenisbyr): ?>
											 <option value="<?php echo $jenisbyr->id; ?>" ><?php echo $jenisbyr->id; ?> - <?php echo $jenisbyr->name ?></option>
											 <?php endforeach ?>
              </select>
			 
            </td>
          </tr> 
		  		  <tr>
          <td  style="vertical-align: top;">Bayar</td>
          <td  style="vertical-align: top;"><input type="text" class="form-control" name="trxTotalbyr" id="trxTotalbyr" onchange="formatNumber(this);" onkeyup="formatNumber(this);"  value="<?php echo number_format($sisa); ?>"/>
		  </td>
        </tr>
		<tr>
		<td style="vertical-align: top;">Status Bayar</td>
		<td style="vertical-align: top;">
		<input type="checkbox" name="stsbyr" value="2" style="position: inherit !important;left: 0px !important;
    opacity: unset;" > Lunas
		<hr/>
		</td>
		</tr>
		 <!--  <tr>
		    <td colspan="3">Untuk Pembayaran non tunai :</td></tr>
		<tr>
		<td>Bank Customer</td>
			 
			<td>
				<select name="bankcus" class="form-control">
				<?php
				 foreach ($bank as $bank):
				?>
				<option value="<?= $bank->id ?>" ><?php echo $bank->name ?></option>
				<?php endforeach ?>
				</select>
		</td>
		</tr>
		<tr>
          <td>No Kartu</td>
          
          <td><input class="form-control" type="text" name="no_kar" id="no_kar"  size="30" maxlength="50"  onkeyup="formatNumber(this);" onchange="formatNumber(this);"/></td>
        </tr>
			<tr >
		<td>Bank EDC</td>
			 
			<td>
				<select name="bankedc" class="form-control">
				<?php
				 foreach ($bank2 as $bank):
				?>
				<option value="<?= $bank->id ?>" ><?php echo $bank->name ?></option>
				<?php endforeach ?>
				</select>
		</td>
		</tr>
         <tr >
          <td>Biaya Admin</td>
          
          <td><input type="text" class="form-control" name="b_admin" id="b_admin"  size="30" maxlength="50"  onkeyup="formatNumber(this);" onchange="formatNumber(this);"/></td>
        </tr> -->
		 <tr>
  <td></td>
  <td><input type="submit" value="UPDATE DATA INVOICE" class="btn btn-info btn-block"/></td>
  <td><br/><br/></td>
  </tr>
	</table>	
	
	</div>
 </div>
  <?php echo form_close(); ?>
<?php 
} 
else { echo "<HR/><div class='col-lg-4'><h4 style='border:dashed #000 thin;padding:8px;background:#d1d1d1;border-radius:8px;'>INVOICE INI SUDAH LUNAS</h4></div>";?>


<div class="col-lg-12"></div>
<div class="col-lg-6">
<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
		
		<tr>
			<th><?php echo form_label('No. Invoice*','nomor'); ?></th>
			<td>
				<?php 
					$datainv['name'] = $data['id'] = 'nomorinvoice';
					$datainv['title'] = "Nomor invoice tidak boleh kosong";
					$datainv['class'] = "form-control";
					$datainv['value'] =$noinv;
					$datainv['disabled'] = "disabled";
					echo form_input($datainv);
				?>
			</td>				
		</tr>	
		<tr>
			<th><?php echo form_label('Total Invoice','total'); ?></th>
			<td>
				<?php 
					$datatot['name'] = 'totalinv';
					$datatot['title'] = "Nomor tidak boleh kosong";
					$datatot['class'] = "form-control";
					$datatot['disabled'] = "disabled";
					$datatot['value'] =number_format($totalinv);
					echo form_input($datatot);
				?>
			</td>				
		</tr>
		<tr>
			<th><?php echo form_label('Total Bayar','total'); ?></th>
			<td>
				<?php 
					$databyr['name'] = 'totalbayar';
					$databyr['title'] = "Nomor tidak boleh kosong";
					$databyr['class'] = "form-control";
					$databyr['disabled'] = "disabled";
					$databyr['value'] =number_format($totalbyar);
					echo form_input($databyr);
				?>
			</td>				
		</tr>
		<tr>
			<th><?php echo form_label('Sisa Bayar','total'); ?></th>
			<td>
				<?php 
					$datasisa['name'] = 'sisabayar';
					$datasisa['title'] = "Nomor tidak boleh kosong";
					$datasisa['class'] = "form-control";
					$datasisa['disabled'] = "disabled";
					$datasisa['value'] =number_format($sisa);
					echo form_input($datasisa);
				?>
			</td>				
		</tr>
			
	</table>
	</div>
<?php } ?>


<hr/>
<div class="col-lg-12"><h4>RIWAYAT PEMBAYARAN</h4></div>
<div class="col-lg-12">
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data-table" id="display_table">
	<thead>
		<tr>
	
			<th>Tanggal </th>
			<th>Cara Pembayaran </th>
			<th>Bank Klien</th>
			<th>Jumlah</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if($invoice_data_detail)
			{
				foreach ($invoice_data_detail as $row) 
				{ 

					echo '<tr>';
					echo '<td>'.$row->createdDate.'</td>';
					echo '<td>'.$row->nm_tipe.'</td>';
					echo '<td>'.$row->nm_bank.'</td>';
					echo '<td>'.number_format($row->receivablePay).'</td>';		echo '</tr>';
				}
			}
		?>
	</tbody>	
</table>		
</div>

 <?php //if($stp!=='2') { ?> 		
<!-- <div class="col-lg-12">

<hr/> <h4>JURNAL INVOICE TERMIN</h4></div>
 -->
<?php
/*	echo form_open('invoice/insert_jurnal', array('id' => 'jurnal_form', 'onsubmit' => 'return cekData();'));

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

	$data['class'] = 'input'*/;	
?>	
<!-- 
<div class="row">
	<div class="col-lg-6">
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" id="display_table">
	<tr>
			<th><?php echo form_label('No. Invoice*','nomor'); ?></th>
			<td>
				<?php 
					$datainv['name'] = $data['id'] = 'nomorinvoice';
					$datainv['title'] = "Nomor invoice tidak boleh kosong";
					$datainv['class'] = "form-control";
					$datainv['value'] =$noinv;
					$datainv['readonly'] = "readonly";
					echo form_input($datainv);
				?>
			</td>				
		</tr>	
		<tr>
			<th><?php echo form_label('Tanggal *','tanggal'); ?></th>
			<td>
				<?php 
					$data['name'] = 'tanggal';
					$data['id'] = 'datepicker';
					$data['class'] = "form-control";
					$data['title'] = "Tanggal tidak boleh kosong dan harus diisi dengan format dddd-mm-yy";	
					echo form_input($data);
				?>
			</td>				 
		</tr>		
	</table>
	</div>
	<div class="col-lg-6">	
	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
		
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
  	<div class="col-lg-12">	
	<h5>Detail</h5>
	<table width="80%" id="tblDetail" name="tblDetail" >
		<thead>
		<tr>
			<th>Akun</th>
			<th>Debit</th>
			<th>Kredit</th>	
			<th>Keterangan</th>			
		</tr>
		</thead>
		<tbody>

		<?php for ($i = 1; $i <= 2; $i++) { ?>
			<tr>
				<td>
					<?php 
						$akun['id'] = 'akun'.$i;
						$akun['class'] = '';
						echo form_dropdown('akun[]', $accounts, '' ,$akun);
					?>
				</td>
				<td>
					<?php 
						$data['id'] = 'debit'.$i;
						$data['name'] = 'debit'.$i;
						$data['class'] = '"form-control';
						$data['onBlur'] = "cekDebit($i)";
						$data['title'] = "Debit harus diisi dengan angka";
						echo form_input($data);
					?>
				</td>
				<td>
					<?php 
						$data['id'] = 'kredit'.$i;
						$data['name'] = 'kredit'.$i;
						$data['class'] = '"form-control';
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
		</tbody>
	</table>
	<br/>
	<div class="addRow">
		<a href="javascript:addRow();" class="btn btn-danger btn-sm"><span style="color:#fff;">TAMBAH BARIS</span></a>
	</div>
	
	<div class="buttons">
		<?php
			echo form_submit('post','Post', "id = 'button-save'" );
			echo form_reset('reset','Reset', "id = 'button-reset'" );
		?>
	</div>
	</div>
</div> -->
<?php //echo form_close(); ?>
 <?php //} else { } ?>
<!--  <div class="row">
 <div class="col-lg-12">
 <h3>Detail Jurnal</h3>
	<table cellpadding="0" cellspacing="0" border="0" class="display_table2" id="tblDetail2" width="100%">
	<thead>
		<tr>
			<th>Tanggal</th>
			<th>No</th>
			<th>No Invoice</th>
			<th>Item</th>
			<th>Akun</th>
			<th>Debit</th>
			<th>Kredit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if($jurnal_data)
			{
				foreach ($jurnal_data as $row) 
				{ 
					if($row->debit_kredit == 1)
					{
						$d = $row->nilai;
						$k = '';
					}
					else
					{
						$d = '';
						$k = $row->nilai; 
					}
					echo '<tr>';
					echo '<td>'.$row->tgl.'</td>';
					echo '<td>'.$row->no.'</td>';
					echo '<td>'.$row->invoice_no.'</td>';
					echo '<td>'.$row->item.'</td>';
					echo '<td>'.$row->account_name.'</td>';
					echo '<td>'.number_format(abs($d)).'</td>';
					echo '<td>'.number_format(abs($k)).'</td>';	
					echo '</tr>';
				}
			}
		?>
	</tbody>	
	<tfoot>
		<tr>
			<th>Tanggal</th>
			<th>No</th>
			<th>Item</th>
			<th>Akun</th>
			<th>Debit</th>
			<th>Kredit</th>
			<th></th>	
		</tr>
	</tfoot>
</table>		

 </div>
</div> -->

</div>
</div>
</div>
</div>
  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>
<script type='text/javascript'>
	//Validasi di client
	/*$(document).ready(function()
	{
		$('#jurnal_form').validate({
			errorLabelContainer: "#error",
			wrapper: "li",
			rules: 
			{
				nomor: "required",
				tanggal: "required dateISO",
				deskripsi: "required",
				debit1: "integer",
				kredit1: "integer",
				debit2: "integer",
				kredit2: "integer"
			}
		});
	});*/
</script>

<script type="text/javascript">

$('#trxStatus').on('change', function() {
  val = this.value;
  if(val == 2)
    $('#termin').fadeIn();
  else
    $('#termin').fadeOut();

});
</script>	
	
<script type="text/javascript">
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
				deskripsi: "required",
				debit1: "integer",
				kredit1: "integer",
				debit2: "integer",
				kredit2: "integer"
			}
		});
		$("#tblDetail2").dataTable({
		    select: {
		        style:    'os',
		        selector: 'td:first-child',
		        style: 'multi'
		    },
			dom: 'Bfrtip',
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});
	});
</script>

<script type="text/javascript" charset="utf-8">
//jQuery.noConflict();
	$(function() {
		$('#dialog-form').load('<?php echo site_url(); ?>klien/popup');
		$("#dialog-form").dialog({
			autoOpen: false,
			title: 'Klien',
			height: 520,
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

		$('#trxFullName').focus(function() {
				$('#dialog-form').dialog('open');
			});

	});
	
	 $('#trxSparepartTotal').keyup(function() {  
      updateSubTotal();
    });
    
    $('#trxJasaTotal').keyup(function() {  
      updateSubTotal();
    });

    var updateSubTotal = function () {
     trxSparepartTotal = parseInt($('#trxSparepartTotal').val());
     trxJasaTotal = parseInt($('#trxJasaTotal').val());
      // alert(trxJasaTotal);
      if (isNaN(trxSparepartTotal) || isNaN(trxJasaTotal)) {
        if(!trxJasaTotal){
          $('#trxSubtotal').val($('#trxSparepartTotal').val());
        }

        if(!trxSparepartTotal){
          $('#trxSubtotal').val($('#trxJasaTotal').val());
        }

      } else {          
        $('#trxSubtotal').val(trxJasaTotal + trxSparepartTotal);
      }
    };

</script>

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