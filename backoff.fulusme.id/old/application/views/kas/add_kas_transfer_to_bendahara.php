<script type="text/javascript" src="<?php echo base_url();?>js/jurnal.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js"></script>
<br/>
<div class="col-lg-12">	<h3 class="pull-left"> <i class="fa fa-windows"></i> <?php echo $title; ?></h3>
<br/>
<div class="post-body">
	<?php 	echo form_open('jurnal/insert_kas_setor_to_bendahara', array('id' => 'jurnal_form','class' => 'form-material m-t-40'));

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
	<div class="card">
		<div class="card-body">
			<h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>
	 
			<table class="table color-table info-table">

				<?php 
					echo form_hidden('f_id', $f_id);
					echo form_hidden('tf_dari', $tf_dari);
					echo form_hidden('tf_ke', $tf_ke);
					echo form_hidden('type_trx', $type_trx);
				?>
				<input type="hidden" class="form-control" name="jns" id="jns" value="KM"  />
				<input type="hidden" class="form-control" name="identity_id" id="identity_id" value="<?php echo $identity_id; ?>"  />
				<input type="hidden" class="form-control" name="userid" id="userid" value="<?php echo $userid; ?>"  />
				<input type="hidden" class="form-control" name="tipe_trx" id="tipe_trx" value="add"  />
				<tr>
				  <td  style="vertical-align: top;">Tanggal Transaksi</td>
				  <td  style="vertical-align: top;" colspan="3">
					<input type="date" class="form-control" name="tgl_trx" id="tgl_trx" required />
				  </td>
				</tr>

				<tr>
				  <td style="vertical-align: top;">Total</td>
				  <td style="vertical-align: top;" colspan="3">
				  	<input type="hidden" name="jumlah" class="form-control" value="<?php echo $total_setor; ?>">
				  	<input type="text" class="form-control" value="<?php echo number_format( $total_setor ); ?>" readonly="true">
				  </td>
				</tr>

				<tr>
				  <td style="vertical-align: top;">No Bukti</td>
				  <td style="vertical-align: top;" colspan="3">
					<input type="text" name="no_bukti" class="form-control" required>
				  </td>
				</tr>

				<tr>
				  <td style="vertical-align: top;">keterangan</td>
				  <td style="vertical-align: top;" colspan="3">
					<textarea name="keterangan" class="form-control" required></textarea>
				  </td>
				</tr>
			</table>

			<div class="form-actions">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                            	<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Post</button>
                                <button type="button" class="btn btn-inverse">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
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
<script type="text/javascript" src="<?php echo base_url();?>js/jurnal.js"></script>
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
			},
			 submitHandler: function(form) {
			   $.post($('#jurnal_form').attr('action'),$('#jurnal_form').serialize(),function(result){
					console.log(result);
					var Dataresult = JSON.parse(result);
					if(Dataresult.error==0){
						var myWindow = window.open("<?php echo base_url() ?>/"+Dataresult.data, "width=900,height=800"); 
					}
					document.location.href = Dataresult.target;
				})
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
		$('#jurnal_formd').validate({
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