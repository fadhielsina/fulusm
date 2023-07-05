<script type="text/javascript" src="<?php echo base_url();?>js/jurnal.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js"></script>
<div class="post-title"><h2><a href="#"><?php echo $title; ?></a></h2></div>

<div class="post-body">
<div id="dialog-form"></div>
<?php echo form_open('invoice/insert_data', array('id' => 'jurnal_form')); ?>	

<div id="form">
    <fieldset class="atas">
      <table width="100%">
        <tr>
          <td valign="top" style="vertical-align: top;">
		  <table width="100%">
		   <tr>
              <td width="30%">User Input</td>
              <td width="5">:</td>
              <td><input type="text" name="namauser" id="invoiceID" value="<?php echo $usernama; ?>" disabled class="form-control"/>
			  <input type="hidden" name="iduser" id="invoiceID" value="<?php echo $userid; ?>" />
			  </td>
            </tr>
            <tr>
              <td width="30%">No Invoice</td>
              <td width="5">:</td>
              <td><input required type="text" name="invoiceID" id="invoiceID" size="30" maxlength="30" value="<?php echo $invID; ?>" class="form-control" readonly/></td>
            </tr>
            <tr>
              <td width="30%">No Nota</td>
              <td width="5">:</td>
              <td><input required type="text" name="invoiceIDmanual" id="invoiceIDmanual" size="30" maxlength="30" class="form-control" /></td>
            </tr>
            <tr >
              <td width="30%">Tgl Invoice</td>
              <td width="5">:</td>
              <td><input type="text" name="trxDate" id="datepicker" size="30" maxlength="30" class="form-control" /></td>
            </tr>
            <tr>
              <td>Costumer</td>
              <td>:</td>
              <td><input required type="text" name="trxFullName" id="trxFullName"  size="30" maxlength="250" class="form-control"/></td>
            </tr>
            <tr>
              <td>Costumer Code</td>
              <td>:</td>
              <td>
                <input  hidden name="memberID" id="memberID"  value="" type="text" />
                <input readonly type="text" name="memberCode" id="memberCode" readonly  size="30" maxlength="50" class="form-control"/>
              </td>
            </tr>
            <tr>
              <td>alamat</td>
              <td>:</td>
              <td><input type="text" name="trxAddress" id="memberAddress" readonly  size="30" class="form-control" /></td>
            </tr>
            <tr>
              <td>telp</td>
              <td>:</td>
              <td><input type="text" name="trxPhone" id="memberPhone"  size="30" maxlength="50" class="form-control"/></td>
            </tr>


          </table>
        </td>
        <td valign="top" style="vertical-align: top;">


          <table width="100%">


           <tr>
            <td>Kode/No Plat</td>
            <td>:</td>
            <td><input type="text" name="nopol" id="nopol"  size="30" maxlength="50" class="form-control"/></td>
          </tr>      
          <tr>
            <td>Merk Mobil</td>
            <td>:</td>
            <td>
              <input  type="text" name="merk" id="merk"   size="30" maxlength="50" class="form-control"/>
            </td>
          </tr>
          <tr>
            <td>Tahun Mobil</td>
            <td>:</td>
            <td><input type="text" name="year_vech" id="year_vech"   size="30" maxlength="50" class="form-control"/></td>
          </tr>

          <tr>
            <td>No Chasis</td>
            <td>:</td>
            <td><input type="text" name="chasis_no" id="chasis_no"   size="30" maxlength="50" class="form-control"/></td>
          </tr>

          <tr>
            <td>No Engine</td>
            <td>:</td>
            <td><input type="text" name="engine_no" id="engine_no"   size="30" maxlength="50" class="form-control"/></td>
          </tr>


          <tr>
            <td>Kilometer</td>
            <td>:</td>
            <td><input type="text" name="kilometer" id="kilometer"   size="30" maxlength="50" class="form-control"/></td>
          </tr>

               

          <tr>
            <td width="30%">Tgl Masuk</td>
            <td width="5">:</td>
            <td><input type="text" name="trxInDate" id="datepicker2" size="30" maxlength="30" class="form-control"/></td>
          </tr>
          <tr>
            <td width="30%">Tgl Keluar</td>
            <td width="5">:</td>
            <td><input type="text" name="trxOutDate" id="datepicker3" size="30" maxlength="30" class="form-control"/></td>
          </tr>  
		 <tr>
          <td valign="top">Note</td>
          <td>:</td>
          <td><textarea  name="note" id="note"  rows="4" cols="50" style="width: 210px; height: 50px" class="form-control"></textarea></td>
        </tr>


        </table>
      </td>
      <td valign="top" style="vertical-align: top;">
       <table width="100%">
		 <tr>
          <td width="30%">Total Instalasi</td>
          <td width="5">:</td>
          <td><input type="text" name="trxInstalasiTotal" id="trxInstalasiTotal"  size="30" maxlength="30" class="form-control" onkeyup="formatNumber(this);" onchange="formatNumber(this);"/></td>
        </tr>
         <tr>
          <td width="30%">Total Sparepart</td>
          <td width="5">:</td>
          <td><input type="text" name="trxSparepartTotal" id="trxSparepartTotal"  size="30" maxlength="30" class="form-control" onkeyup="formatNumber(this);" onchange="formatNumber(this);"/></td>
        </tr>
        <tr>
          <td width="30%">Total Jasa</td>
          <td width="5">:</td>
          <td><input type="text" name="trxJasaTotal" id="trxJasaTotal"  size="30" maxlength="30" class="form-control" onkeyup="formatNumber(this);" onchange="formatNumber(this);"/></td>
        </tr>  
		<tr>
          <td>Discount</td>
          <td>:</td>
          <td><input class="form-control" type="text" name="trxDiscount" id="trxDiscount"  size="30" maxlength="50"  onkeyup="formatNumber(this);" onchange="formatNumber(this);" value="0"/></td>
        </tr>
		  <tr>
          <td>Subtotal</td>
          <td>:</td>
          <td><input class="form-control" type="text" name="trxSubtotal" id="trxSubtotal"  size="30" maxlength="50"  onkeyup="formatNumber(this);" onchange="formatNumber(this);"/></td>
        </tr>
        <tr>
          <td>PPN</td>
          <td>:</td>
          <td><input class="form-control" type="text" name="trxPPN" id="trxPPN"  size="30" maxlength="50" value="0"/></td>
        </tr>

        <tr>
          <td>Faktur Total</td>
          <td>:</td>
          <td><input type="text" name="trxTotal" id="trxTotal"  size="30" maxlength="50" onkeyup="formatNumber(this);" onchange="formatNumber(this);" /></td>
        </tr>
		 <tr>
            <td>Cara Pembayaran</td>
            <td>:</td>
            <td>
              <select class="form-control" style="width: 200px" name="trxStatus" id="trxStatus">
                <option value="">-Pilih</option>
                <option value="1">Cash</option>
                <option value="2">Termin</option>
              </select>
            </td>
          </tr>

			 <tr hidden id="termin">
            <td width="30%">Jatuh Tempo</td>
            <td width="5">:</td>
            <td><input class="form-control" type="text" name="trxTerminDate" id="datepicker4" class="tgl" size="30" maxlength="30" /></td>
          </tr>
			 <tr>
            <td>Jenis Pembayaran</td>
            <td>:</td>
            <td>
              <select class="form-control" style="width: 200px" name="jns_bayar" id="jns_bayar">
                <option value="">-Pilih</option>
                <option value="1">Tunai</option>
                <option value="2">Debit</option>
				 <option value="3">Kredit</option>
              </select>
			 
            </td>
          </tr> 
		  		  <tr>
          <td  style="vertical-align: top;">Total Bayar</td>
          <td  style="vertical-align: top;">:</td>
          <td  style="vertical-align: top;"><input class="form-control" type="text" name="trxTotalbyr" id="trxTotalbyr"  size="30" maxlength="50"onkeyup="formatNumber(this);" onchange="formatNumber(this);" />
		  </td>
        </tr>
		<tr>
		<td style="vertical-align: top;">Status Bayar</td><td style="vertical-align: top;">:</td>
		<td style="vertical-align: top;">
		<input type="checkbox" name="stsbyr" value="2" > Pending
		<hr/>
		</td>
		</tr>
		 
      </table>

    </td>
  </tr>
   <tr>
		    <td ><b>Untuk Pembayaran non tunai :</b></td></tr>
		<tr>
		<td style="horizontal-align: right;">Bank Customer</td>
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
          <td><input type="text" class="form-control" name="no_kar" id="no_kar"  size="30" maxlength="50"  onkeyup="formatNumber(this);" onchange="formatNumber(this);"/></td>
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
          <td><input class="form-control" type="text" name="b_admin" id="b_admin"  size="30" maxlength="50"  onkeyup="formatNumber(this);" onchange="formatNumber(this);"/></td>
        </tr>
		
  <tr>
  <td><a href="<?php echo site_url('invoice/batal_trx/'.$invID);?>" class="btn btn-danger btn-block"
  onclick="javascript: return confirm('Anda akan membatalkan transaksi dengan nomor invoice : <?php echo $invID; ?> ?')"
  />BATAL TRANSAKSI</a></td>
  <td><input type="submit" value="SIMPAN DATA INVOICE" class="btn btn-info btn-block"/></td>
  <td></td>
  </tr>
</table>
</fieldset>
</div>
	
<?php echo form_close(); ?>

</div>	
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

<script>
		
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

                var sub_total=(trxInstalasiTotal+trxSparepartTotal+trxJasaTotal)-trxDiscount;
                $('#trxSubtotal').val(numberWithCommas(sub_total));
    };
	
	    var updateTotal = function () {
			var trxSubtotal=parseInt($('#trxSubtotal').val().split(",").join(""));
                var trxPPN=parseInt($('#trxPPN').val().split(",").join(""));

                var totaltrx=(trxSubtotal)+((trxSubtotal*trxPPN)/100);
                $('#trxTotal').val(numberWithCommas(totaltrx));
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