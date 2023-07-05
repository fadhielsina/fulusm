<script type="text/javascript" src="<?php echo base_url();?>js/jurnal.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js"></script>
<br/><br/>
<div class="col-lg-12">	<h3 class="badge badge-info"> <i class="fa fa-windows"></i> <?php echo $title; ?></h3></div><br/><br/><br/>
<?php $lock='';$rol=''; if($kode_up=='e') { $lock='';$rol='';} else if($kode_up=='p') { $lock='disabled';$rol='readonly';} ?>
<div class="post-body">
<div class="col-lg-12">
	<div class="panel panel-info">
  <div class="panel-heading">FORM TAMBAH DATA</div>
  <div class="panel-body">
<div id="dialog-form"></div>
<div id="dialog-form2"></div>
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Detail Invoice</a></li>
    <li><a href="#tabs-2">Jurnal Invoice</a></li>
  </ul>
  <div id="tabs-1">
	<?php echo form_open('invoice/insert_data', array('id' => 'jurnal_form')); ?>	

<div id="form">
<?php foreach ($invoice_data as $row) { $noinv=$row->invoiceID;$totalinv=$row->trxTotal;$userinput=$row->nama_depan;$is_publish=$row->is_publish;?>
			
    <fieldset class="atas"> <table width="100%">
        <tr>
          <td valign="top" style="vertical-align: top;" width="33%">
		  <table width="100%">
		     <tr>
              <td width="30%">No Invoice</td>
              <td width="5">:</td>
              <td><input required type="text" <?php echo $rol; ?> name="noinvoice_gab" id="noinvoice_gab" size="30" maxlength="30" class="form-control"  <?php echo $lock; ?> value="<?php echo $row->invoiceID; ?>" />
			  <input type="hidden" name="edit_type" value="<?php echo $kode_up; ?>"/>
			  </td>
            </tr>
		   <tr>
              <td width="30%">User Input</td>
              <td width="5">:</td>
              <td><input type="text" name="namauser" id="invoiceID" value="<?php echo $row->nama_depan; ?>" disabled class="form-control"/>
			  </td>
            </tr>
			 <tr>
              <td width="30%">User Edit</td>
              <td width="5">:</td>
              <td><input type="text" name="namauser" id="invoiceID" value="<?php echo $usernama; ?>" disabled class="form-control"/>
			  <input type="hidden" name="iduser" id="invoiceID" value="<?php echo $userid; ?>" />
			  </td>
            </tr>
			 <tr>
              <td width="30%">Lokasi Kantor</td>
              <td width="5">:</td>
              <td>
			  <input type="text" name="namauser" id="lokasi" value="<?php echo $row->identityName; ?>" disabled class="form-control"/>
			  </td>
            </tr>
            <tr>
              <td width="30%">No Nota</td>
              <td width="5">:</td>
              <td><input required type="text" name="invoiceIDmanual" id="invoiceIDmanual" size="30" maxlength="30" class="form-control"  <?php echo $lock; ?> value="<?php echo $row->invoiceIDmanual; ?>" /></td>
            </tr>
            <tr>
              <td width="30%">Tgl Invoice</td>
              <td width="5">:</td>
              <td><input type="text" name="trxDate" id="datepicker" value="<?php echo $row->trxDate; ?>" size="30" maxlength="30" class="form-control"  <?php echo $lock; ?>/><br/></td>
            </tr>
			 <tr>
			 
              <td colspan="3" style="color:#6b56c2; background-color: #fff;padding: 6px;border: thin solid #a2a1ad;"><b><i class="fa fa-fw fa-users"></i> DATA CUSTOMER</b></td>
			 
            </tr>
            <tr>
              <td>Costumer</td>
              <td>:</td>
              <td><input required type="text" name="trxFullName" id="trxFullName"  size="30" maxlength="250" class="form-control"  <?php echo $lock; ?> value="<?php echo $row->memberFullName; ?>"/></td>
            </tr>
            <tr>
              <td>Costumer Code</td>
              <td>:</td>
              <td>
                <input  hidden name="memberID" id="memberID"  value="<?php echo $row->memberID; ?>" type="text" />
                <input value="<?php echo $row->memberCode; ?>" <?php echo $rol; ?> type="text" name="memberCode" id="memberCode"   size="30" maxlength="50" class="form-control"/>
              </td>
            </tr>
            <tr>
              <td>alamat</td>
              <td>:</td>
              <td><input type="text" name="trxAddress" value="<?php echo $row->memberAddress; ?>" id="memberAddress" <?php echo $rol; ?>  size="30" class="form-control"  <?php echo $lock; ?>/></td>
            </tr>
            <tr>
              <td>telp</td>
              <td>:</td>
              <td><input type="text" value="<?php echo $row->memberPhone; ?>" name="trxPhone" id="memberPhone"  size="30" maxlength="50" class="form-control" <?php echo $lock; ?>/></td>
            </tr>
			<tr>
          <td valign="top">Note</td>
          <td>:</td>
          <td><textarea  name="note" id="note"  rows="4" cols="50" style="width: 210px; height: 50px" class="form-control" <?php echo $lock; ?>><?php echo $row->note; ?></textarea><br/></td>
        </tr>
			 <tr>
              <td colspan="3" style="color:#6b56c2; background-color: #fff;padding: 6px;border: thin solid #a2a1ad;"> <b>DATA KENDARAAN</b></td>
			 
            </tr>
			
			 <tr>
            <td>Kode/No Plat</td>
            <td>:</td>
            <td><input type="text" name="nopol" id="nopol"  size="30" maxlength="50" class="form-control"  <?php echo $lock; ?> value="<?php echo $row->trxcarno; ?>"/></td>
          </tr>      
          <tr>
            <td>Merk Mobil</td>
            <td>:</td>
            <td>
			  <input  hidden name="merkid" id="merkid"  value="" type="text" />
              <input  type="text" name="merk" id="merk"   size="30" maxlength="50" class="form-control"  <?php echo $lock; ?> value="<?php echo $row->car_merk; ?>"/>
            </td>
          </tr>
					    <tr>
            <td>Type Mobil</td>
            <td>:</td>
            <td>
              <input <?php echo $rol; ?> type="text" name="type" id="type"   size="30" maxlength="50" class="form-control" <?php echo $lock; ?> value="<?php echo $row->trxcartype; ?>" />
            </td>
          </tr>
		  <tr>
            <td>Series Mobil</td>
            <td>:</td>
            <td>
              <input  <?php echo $rol; ?> type="text" name="series" id="series"   size="30" maxlength="50" class="form-control" <?php echo $lock; ?> value="<?php echo $row->trxcarseries; ?>"/>
            </td>
          </tr>
          
         
          </table>
        </td>
        <td valign="top" style="vertical-align: top;" width="33%">


          <table width="100%">

			 <tr>
            <td>Tahun Mobil</td>
            <td>:</td>
            <td><input type="text" name="year_vech" id="year_vech"   class="form-control" size="30" maxlength="50" class="field" value="<?php echo $row->car_year; ?>" <?php echo $lock; ?>/></td>
          </tr>
          <tr>
            <td>No Chasis</td>
            <td>:</td>
            <td><input type="text" name="chasis_no" id="chasis_no"   size="30" maxlength="50" class="form-control"  <?php echo $lock; ?> value="<?php echo $row->chasis_no; ?>"/></td>
          </tr>

          <tr>
            <td>No Engine</td>
            <td>:</td>
            <td><input type="text" name="engine_no" id="engine_no"   size="30" maxlength="50" class="form-control"  <?php echo $lock; ?> value="<?php echo $row->engine_no; ?>"/></td>
          </tr>


          <tr>
            <td>Kilometer</td>
            <td>:</td>
            <td><input type="text" name="kilometer" id="kilometer"   size="30" maxlength="50" class="form-control"  <?php echo $lock; ?> value="<?php echo $row->kilometer; ?>"/><br/></td>
          </tr>

               
			 <tr>
              <td colspan="3" style="color:#6b56c2; background-color: #fff;padding: 6px;border: thin solid #a2a1ad;"><b>DATA TRANSAKSI</b></td>
			 
            </tr>
          <tr>
            <td width="30%"><br/>Tgl Masuk</td>
            <td width="5">:</td>
            <td><input type="text" name="trxInDate" value="<?php echo $row->trxInDate; ?>" id="datepicker2" size="30" maxlength="30" class="form-control" <?php echo $lock; ?>/></td>
          </tr>
          <tr>
            <td width="30%">Tgl Keluar</td>
            <td width="5">:</td>
            <td><input type="text" name="trxOutDate" id="datepicker3" size="30" maxlength="30" class="form-control"  <?php echo $lock; ?> value="<?php echo $row->trxOutDate; ?>"/></td>
          </tr>  
		 <tr>
          <td width="30%">Total Instalasi</td>
          <td width="5">:</td>
          <td><input type="text" name="trxInstalasiTotal" id="trxInstalasiTotal"  size="30" maxlength="30" class="form-control"  <?php echo $lock; ?> onkeyup="formatNumber(this);" onchange="formatNumber(this);" value="<?php echo number_format($row->trxInstalasiTotal); ?>"/></td>
        </tr>
         <tr>
          <td width="30%">Total Sparepart</td>
          <td width="5">:</td>
          <td><input type="text" name="trxSparepartTotal" id="trxSparepartTotal"  size="30" maxlength="30" class="form-control"  <?php echo $lock; ?> onkeyup="formatNumber(this);" onchange="formatNumber(this);" value="<?php echo number_format($row->trxSparepartTotal); ?>"/></td>
        </tr>
        <tr>
          <td width="30%">Total Jasa</td>
          <td width="5">:</td>
          <td><input type="text" name="trxJasaTotal" id="trxJasaTotal"  size="30" maxlength="30" class="form-control"  <?php echo $lock; ?> onkeyup="formatNumber(this);" onchange="formatNumber(this);" value="<?php echo number_format($row->trxJasaTotal); ?>"/></td>
        </tr>  
		<tr>
          <td>Discount</td>
          <td>:</td>
          <td><input class="form-control"  <?php echo $lock; ?> type="text" name="trxDiscount" id="trxDiscount"  size="30" maxlength="50"  onkeyup="formatNumber(this);" onchange="formatNumber(this);" value="<?php echo number_format($row->trxDiscount); ?>"/></td>
        </tr>
		  <tr>
          <td>Subtotal</td>
          <td>:</td>
          <td><input class="form-control"  <?php echo $lock; ?> type="text" name="trxSubtotal" id="trxSubtotal"  size="30" maxlength="50"  onkeyup="formatNumber(this);" onchange="formatNumber(this);" value="<?php echo number_format($row->trxSubtotal); ?>"/></td>
        </tr>
        <tr>
          <td>PPN</td>
          <td>:</td>
          <td><input  class="form-control"  <?php echo $lock; ?> type="hidden" name="trxPPN" id="trxPPN"  size="30" maxlength="50" value="10"/>10 %</td>
        </tr>

        <tr>
          <td>Faktur Total</td>
          <td>:</td>
          <td><input type="text" class="form-control" name="trxTotal" id="trxTotal"  size="30" maxlength="50" onkeyup="formatNumber(this);" onchange="formatNumber(this);" value="<?php echo number_format($row->trxTotal); ?>" <?php echo $lock; ?>/><br/></td>
        </tr>

        </table>
      </td>
      <td valign="top" style="vertical-align: top;" width="33%">
       <table>
		 
		
		 <tr>
              <td colspan="3" style="color:#6b56c2; background-color: #fff;padding: 6px;border: thin solid #a2a1ad;"><b>DATA PEMBAYARAN</b></td>
			 
            </tr>
		 <tr>
		 <tr>
          <td  style="vertical-align: top;">Total Bayar</td>
          <td  style="vertical-align: top;">:</td>
          <td  style="vertical-align: top;"><input class="form-control"  <?php echo $lock; ?> type="text" name="trxTotalbyr" id="trxTotalbyr"  size="30" maxlength="50"onkeyup="formatNumber(this);" onchange="formatNumber(this);" value="<?php echo number_format($row->trxPay); ?>"/>
		  </td>
        </tr>
            <td>Cara Pembayaran</td>
            <td>:</td>
            <td>
			<?php if($row->trxStatus=='1') { $selectbyr1='selected';$selectbyr2='';} else if($row->trxStatus=='2'){  $selectbyr2='selected';$selectbyr1='';}?>
              <select class="form-control"  <?php echo $lock; ?> style="width: 200px" name="trxStatus" id="trxStatus">
              <option value="1" <?php echo $selectbyr1;?>>Cash</option>
                <option value="2"  <?php echo $selectbyr2;?>>Termin</option>
              </select>
            </td>
          </tr>

			 <tr hidden id="termin">
            <td width="30%">Jatuh Tempo</td>
            <td width="5">:</td>
            <td><input class="form-control"  <?php echo $lock; ?> type="text" name="trxTerminDate" id="datepicker4" class="tgl" size="30" maxlength="30" /></td>
          </tr>
			 <tr>
            <td>Jenis Pembayaran</td>
            <td>:</td>
            <td>
              <select class="form-control"  <?php echo $lock; ?> style="width: 200px" name="jns_bayar" id="jns_bayar">
				
				<?php
											 foreach ($jenisbyr as $jenisbyr):
											 if($jenisbyr->id==$row->trxbankmethod)
											 {
												 ?>
												 <option value="<?php echo $jenisbyr->id ?>"  SELECTED ><?php echo $jenisbyr->name ?></option>
											 <?php } else { ?>
											 <option value="<?php echo $jenisbyr->id ?>" ><?php echo $jenisbyr->name ?></option>
											 <?php } ?>
											 <?php endforeach ?>
              </select>
			 
            </td>
          </tr> 
		  		  
		<tr>
		<td style="vertical-align: top;">Status Bayar</td><td style="vertical-align: top;">:</td>
		<td style="vertical-align: top;">
		<input type="checkbox" name="stsbyr" value="2" <?php echo $lock; ?> > Pending
		<HR/>
		</td>
		</tr>
		 <tr>
              <td colspan="3" style="color:#6b56c2; background-color: #fff;padding: 6px;border: thin solid #a2a1ad;"><b><i>UNTUK PEMBAYARAN NON TUNAI</i></b></td>
			 
            </tr>
		<tr>
		<td style="vertical-align: top;">Bank Customer</td>
		 <td  style="vertical-align: top;">:</td>
			<td>
				<select name="bankcus" class="form-control" <?php echo $lock; ?>>
					<?php
											 foreach ($bank as $bank):
											 if($bank->id==$row->trxbankmember)
											 {
												 ?>
												 <option value="<?php echo $bank->id ?>"  SELECTED ><?php echo $bank->name ?></option>
											 <?php } else { ?>
											 <option value="<?php echo $bank->id ?>" ><?php echo $bank->name ?></option>
											 <?php } ?>
											 <?php endforeach ?>
				</select>
				
		</td>
		</tr>
		<tr>
          <td style="vertical-align: top;">No Kartu</td>
		   <td  style="vertical-align: top;">:</td>
          <td><input type="text" class="form-control"  <?php echo $lock; ?> name="no_kar" id="no_kar"  size="30" maxlength="50"  value="<?php echo $row->trxbanknorek; ?>"/></td>
        </tr>
			<tr >
		<td style="vertical-align: top;">Bank EDC</td>
		 <td  style="vertical-align: top;">:</td>
			<td>
				<select name="bankedc" class="form-control" <?php echo $lock; ?>>
				<?php
											 foreach ($bank2 as $bank2):
											 if($bank2->id==$row->trxbankedc)
											 {
												 ?>
												 <option value="<?php echo $bank2->id ?>"  SELECTED ><?php echo $bank2->name ?></option>
											 <?php } else { ?>
											 <option value="<?php echo $bank2->id ?>" ><?php echo $bank2->name ?></option>
											 <?php } ?>
											 <?php endforeach ?>
				</select>
		</td>
		</tr>
         <tr >
          <td style="vertical-align: top;">Biaya Admin</td>
		   <td  style="vertical-align: top;">:</td>
          <td><input class="form-control"  <?php echo $lock; ?> type="text" name="b_admin" id="b_admin"  size="30" maxlength="50"  onkeyup="formatNumber(this);" onchange="formatNumber(this);" value="<?php echo number_format($row->trxbankadmin); ?>"/></td>
        </tr>
		<?php if($kode_up=='e'){ ?>
		 <tr>
  <td colspan="3"><br/><br/>
  <input type="submit" value="SIMPAN PERUBAHAN" class="btn btn-info"/>
  <a href="<?php echo site_url('invoice/');?>" class="btn btn-warning " style="color:#fff;"
  onclick="javascript: return confirm('Anda akan membatalkan transaksi ?')"/>BATAL </a></td>
  </tr>
		<?php } else { ?>
		<tr><td colspan="3"><br/><b style="border: dotted #a4a4a4 thin;padding:8px;background: #9485d1;border-radius:8px;color:#fff;">INVOICE SUDAH DI POSTING</b></td></tr>
		<?php }?>
      </table>

    </td>
  </tr>
  		
 
</table>

</fieldset>
</div>
				<?php }?>
<?php echo form_close(); ?>
 </div>
  <div id="tabs-2">
	
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
<br/>
<?php if($is_publish!=1) { ?>
	<h5>Jurnal Invoice</h5>
	<hr/>
	<div class="col-lg-6">
	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
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

	</table>
	</div>
	<div class="col-lg-6">	
	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
		<tr>
			<th><?php echo form_label('Tanggal *','tanggal'); ?></th>
			<td>
				<?php 
					$datatgl['name'] = 'tanggal';
					$datatgl['class'] = "form-control";
					$datatgl['id'] = 'datepicker5';
					$datatgl['value'] =date('Y-m-d');
					$datatgl['title'] = "Tanggal tidak boleh kosong dan harus diisi dengan format dddd-mm-yy";	
					echo form_input($datatgl);
				?>
			</td>				 
		</tr>		
		<tr>
			<th><?php echo form_label('Deskripsi*','deskripsi'); ?></th>
			<td>
				<?php 
					$datades['name'] = $data['id'] = 'deskripsi';		
					$datades['class'] = "form-control";					
					$datades['title'] = "Deskripsi tidak boleh kosong";
					$datades['rows'] = "2";
					echo form_textarea($datades);
				?>
			</td>
		</tr>	
	</table>	
	</div>
  
	
	
	<table id="tblDetail" name="tblDetail" class="data-table">
		<tr>
			<th>Akun</th>
			<th>Debit</th>
			<th>Kredit</th>	
			<th>Keterangan</th>			
		
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
	
	
	<div class="buttons"><br/>
	<a href="javascript:addRow();" class="btn btn-danger btn-sm"><span style="color:#fff;">TAMBAH BARIS</span></a>
		<?php
			echo form_submit('post','Post', "id = 'button-save'" );
			echo form_reset('reset','Reset', "id = 'button-reset'" );
		?>
	</div>
	
<?php echo form_close(); ?>
<?php } else { echo "Invoice ini sudah di posting <br/> <br/>"; ?>
<a href="<?php echo site_url(); ?>jurnal/unpost_jurnal_invoice/<?php echo $noinv; ?>" onclick="javascript: return confirm('Anda akan meng-Unpost jurnal ini ?')" class="btn btn-danger" >UnPOST Jurnal</a>
 <?php } ?>
 </div>
</div>
</div>
</div>
</div>
</div>
  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>
<script type="text/javascript" src="<?php echo base_url();?>js/jurnal.js"></script>
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
	
	
</script>
<script type="text/javascript" charset="utf-8">
jQuery.noConflict();
	$(function() {
		$('#dialog-form2').load('<?php echo site_url(); ?>vehicles/popup');
		$("#dialog-form2").dialog({
			autoOpen: false,
			title: 'Kendaraan',
			height: 520,
			width: 900,
			modal: true,
			buttons: {
				'OK': function() {
					var chkIdx2 = $('input:radio:checked').val();
					var aData2 = popup_table2.fnGetData(chkIdx2);
					$("#merkid").val(aData2[0]);
					$("#merk").val(aData2[1]);
					$("#type").val(aData2[2]);
					$("#series").val(aData2[3]);
					$(this).dialog('close');
				},
				'Batal': function() {
					$(this).dialog('close');
				}
			},
		});

		$('#merk').focus(function() {
				$('#dialog-form2').dialog('open');
			});

	});
	
	
</script>
<script>
	$('#trxInstalasiTotal').keyup(function() {  
      updateSubTotal();
    });
	
	$('#trxSparepartTotal').keyup(function() {  
      updateSubTotal();
    });
	
	$('#trxJasaTotal').keyup(function() {  
      updateSubTotal();
    });
	
    $('#trxDiscount').keyup(function() {  
      updateSubTotal();
    });
	
	$('#trxPPN').keyup(function() {  
      updateTotal();
    });

    var updateSubTotal = function () {
		 var trxInstalasiTotal=parseInt($('#trxInstalasiTotal').val().split(",").join(""));
			var trxSparepartTotal=parseInt($('#trxSparepartTotal').val().split(",").join(""));
                var trxJasaTotal=parseInt($('#trxJasaTotal').val().split(",").join(""));
				 var trxDiscount=parseInt($('#trxDiscount').val().split(",").join(""));
		 if (isNaN(trxInstalasiTotal)) 
		 {
			 trxInstalasiTotal=0;
		 }
		 
		  if (isNaN(trxSparepartTotal)) 
		 {
			 trxSparepartTotal=0;
		 }
		 
		  if (isNaN(trxJasaTotal)) 
		 {
			 trxJasaTotal=0;
		 }
				var sub_total=trxInstalasiTotal+trxSparepartTotal+trxJasaTotal;
                var sub_total_disc=(trxInstalasiTotal+trxSparepartTotal+trxJasaTotal)-trxDiscount;
				if(isNaN(sub_total)) {
$('#trxSubtotal').val(numberWithCommas(sub_total));
$('#trxTotal').val(numberWithCommas((sub_total)+((sub_total*10)/100)));
$('#trxTotalbyr').val(numberWithCommas((sub_total_disc)+((sub_total_disc*10)/100)));
}
else 
{
$('#trxSubtotal').val(numberWithCommas(sub_total_disc));
$('#trxTotal').val(numberWithCommas((sub_total_disc)+((sub_total_disc*10)/100)));
$('#trxTotalbyr').val(numberWithCommas((sub_total_disc)+((sub_total_disc*10)/100)));
}
    };
	
	    var updateTotal = function () {
			var trxSubtotal=parseInt($('#trxSubtotal').val().split(",").join(""));

                var totaltrx=(trxSubtotal)+((trxSubtotal*10)/100);
				
				if(isNaN(totaltrx)) {
									$('#trxTotal').val(numberWithCommas(trxSubtotal));
				$('#trxTotalbyr').val(numberWithCommas(trxSubtotal));
}
else 
{
				$('#trxTotal').val(numberWithCommas(totaltrx));
				$('#trxTotalbyr').val(numberWithCommas(totaltrx));
}

               
    };
	
	
	function numberWithCommas(number) {
    var parts = number.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

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


