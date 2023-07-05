
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<br/>
<br/><br/><br/>
<div class="post-body">
	<?php 	echo form_open('kas/fill_kas_in', array('id' => 'jurnal_form', 'onsubmit' => 'return cekData();'));

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
	
	echo "</div>"; ?>	
	<div class="col-lg-12">
	<div class="panel panel-info">
  <div class="panel-heading"> FORM TAMBAH KAS MASUK
  </div>
  <div class="panel-body">
 
	
	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
	<input type="hidden" class="form-control" name="jns" id="jns" value="KM"  />
		<input type="hidden" class="form-control" name="identity_id" id="identity_id" value="<?php echo $identity_id; ?>"  />
		<input type="hidden" class="form-control" name="userid" id="userid" value="<?php echo $userid; ?>"  />
		<input type="hidden" class="form-control" name="tipe_trx" id="tipe_trx" value="add"  />
		 <tr>
          <td  style="vertical-align: top;">No. Nota : </td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" name="nonota" id="nonota"  value="<?php echo $nokas; ?>" readonly/>
		  </td>
        </tr>
		 <tr>
              <td width="30%">Tgl Transaksi</td>
              <td><input type="text" name="trxDate" id="datepicker" size="30" maxlength="30" /></td>
            </tr>
		 <tr>
          <td  style="vertical-align: top;">User Input : </td>
          <td  style="vertical-align: top;" colspan="3"><input type="text"  value="<?php echo $this->session->userdata('SESS_FIRST_NAME'); ?>"  readonly/>
		  </td>
        </tr>
		<input type="hidden" name="iden_type" value="<?php echo $this->session->userdata('identityType'); ?>" />
		<?php if($this->session->userdata('identityType')=='1') { ?>
		<tr>
<th><?php echo form_label('Lokasi*','lokasi'); ?></th>
	<td>
										
										<select name="lokasi" class="form-control">
										<option value="" >Pilih Lokasi</option>
											<?php
											 foreach ($get_loc_data as $get_loc_data):
											 ?>
											 <option value="<?= $get_loc_data->identityID ?>" ><?php echo $get_loc_data->identityName ?></option>
											 <?php endforeach ?>
										</select>
									</td></tr>
		<?php } else { ?>
		<tr>
		<th>Lokasi</th>
		<td>
		<input type="hidden" name="lokasi_nh" value="<?php $this->session->userdata('IDENTITY_ID'); ?>"/>
		<p><?php echo $this->session->userdata('identityName'); ?></p>
		<?php } ?>
		</td>
		</tr>
		   <tr>
          <td  style="vertical-align: top;">Diterima Dari</td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="dari" id="dari"  />
		  </td>
        </tr>
		<tr>
		<td style="vertical-align: top;">Catatan</td>
		<td style="vertical-align: top;" colspan="3">
		<textarea name="catatan" value="2" class="form-control" ></textarea>
		</td>
		</tr>
		   <tr>
          <td  style="vertical-align: top;">Sesuai Dokumen</td>
          <td  style="vertical-align: top;"><input type="text" class="form-control" name="dokumen" id="dokumen" />
		   <td  style="vertical-align: top;" class="pull-right">Nomor Dokumen</td>
          <td  style="vertical-align: top;"><input type="text" class="form-control" name="no_dokumen" id="no_dokumen" />
		  </td>
        </tr>
		  <tr>
          <td  style="vertical-align: top;">Uang Sejumlah</td>
          <td  style="vertical-align: top;" colspan="3"><input type="text"  name="jumlah" id="jumlah" onkeyup="formatNumber(this);" />
		  </td>
        </tr>
		  <tr>
          <td  style="vertical-align: top;">Terbilang</td>
          <td  style="vertical-align: top;" colspan="3"><textarea class="form-control" name="terbilang" id="terbilang" readonly ></textarea>
		  </td>
        </tr>
		 <tr>
          <td  style="vertical-align: top;"></td>
          <td  style="vertical-align: top;" colspan="3">	<?php
			echo form_submit('post','Simpan Data Kas Masuk', "id = 'button-save'" );
		?>
		  </td>
        </tr>
	</table>
	</div>
	</div>
	</div>
<?php echo form_close(); ?>	
	
</div>

<script>

	$('#jumlah').keyup(function() {  
	var bilangan=parseFloat($('#jumlah').val().split(",").join(""));
	if(isNaN(bilangan)){
  	alert('Yang anda tulis bukan bilangan')
    return false;
  }
     $('#terbilang').val(terbilang(bilangan));
    });
	
function terbilang(bilangan) {

 bilangan    = String(bilangan);
 var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
 var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
 var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');

 var panjang_bilangan = bilangan.length;

 /* pengujian panjang bilangan */
 if (panjang_bilangan > 15) {
   kaLimat = "Diluar Batas";
   return kaLimat;
 }

 /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
 for (i = 1; i <= panjang_bilangan; i++) {
   angka[i] = bilangan.substr(-(i),1);
 }

 i = 1;
 j = 0;
 kaLimat = "";


 /* mulai proses iterasi terhadap array angka */
 while (i <= panjang_bilangan) {

   subkaLimat = "";
   kata1 = "";
   kata2 = "";
   kata3 = "";

   /* untuk Ratusan */
   if (angka[i+2] != "0") {
     if (angka[i+2] == "1") {
       kata1 = "Seratus";
     } else {
       kata1 = kata[angka[i+2]] + " Ratus";
     }
   }

   /* untuk Puluhan atau Belasan */
   if (angka[i+1] != "0") {
     if (angka[i+1] == "1") {
       if (angka[i] == "0") {
         kata2 = "Sepuluh";
       } else if (angka[i] == "1") {
         kata2 = "Sebelas";
       } else {
         kata2 = kata[angka[i]] + " Belas";
       }
     } else {
       kata2 = kata[angka[i+1]] + " Puluh";
     }
   }

   /* untuk Satuan */
   if (angka[i] != "0") {
     if (angka[i+1] != "1") {
       kata3 = kata[angka[i]];
     }
   }

   /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
   if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
     subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
   }

   /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
   kaLimat = subkaLimat + kaLimat;
   i = i + 3;
   j = j + 1;

 }

 /* mengganti Satu Ribu jadi Seribu jika diperlukan */
 if ((angka[5] == "0") && (angka[6] == "0")) {
   kaLimat = kaLimat.replace("Satu Ribu","Seribu");
 }

 return kaLimat + "Rupiah";
}
</script>

  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>
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
				deskripsi: "required",
				debit1: "integer",
				kredit1: "integer",
				debit2: "integer",
				kredit2: "integer"
			}
		});
	});
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
<script type="text/javascript">

	    $(this).ready( function() {
    		$("#kodeakun").autocomplete({
      			minLength: 1,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>index.php/auto/get_akun",
		          		dataType: 'json',
		          		type: 'POST',
		          		data: req,
		          		success:    
		            	function(data){
		              		if(data.response =="true"){
		                 		add(data.message);
		              		}
		            	},
              		});
         		},
         	select: 
         		function( event, ui ) {
            event.preventDefault();
                   $("#namaakun").val(ui.item.namaakun);
					$("#kodeakun").val(ui.item.kodeakun);
					$("#idakun").val(ui.item.idakun);
        },		
    		});
	    });
	    </script>
		
		
		<script>
  function preventBack(){window.history.forward();}
  setTimeout("preventBack()", 0);
  window.onunload=function(){null};
</script>