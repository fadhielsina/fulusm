<div class="post-title col-lg-12"><h3 class="badge badge-info"><?php echo $title; ?></h3></div>
<div class="post-body">
<?php if($kas_data)
				{ foreach ($kas_data as $row){ ?>
	<?php 	echo form_open('jurnal/insert_kas_masuk', array('id' => 'jurnal_form', 'onsubmit' => 'return cekData();'));

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
	<div class="card card-outline-info">
  <div class="card-header"><h4 class="mb-0 text-white">BUKTI KAS MASUK</h4>>
   <span class="pull-right">
   <?php if($cek_post=='1') { ?>Sudah Di Posting!!,   <a href="<?php echo site_url()."kas/unpost_data_kas/".$id_trx; ?>" style="color:#fff;" class="btn btn-danger btn-xs">EDIT DATA / UNPOST</a> <?php } else { ?>
   <?php } ?>
  </span>
  </div>
  <div class="card-body">
 
	<div class="col-lg-12">	
	 <div class="panel panel-info">
  <div class="panel-body">
	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
	<input type="hidden" class="form-control" name="jns" id="jns" value="KM"  />
		   <tr>
		   <input type="hidden" class="form-control" name="identity_id" id="identity_id" value="<?php echo $identity_id; ?>"  />
		<input type="hidden" class="form-control" name="userid" id="userid" value="<?php echo $userid; ?>"  />
		   <input type="hidden" class="form-control" name="tipe_trx" id="tipe_trx" value="<?php echo $tipe_trx; ?>"  />
		    <input type="hidden" class="form-control" name="id_trx" id="id_trx" value="<?php echo $id_trx; ?>"  />
			<input type="hidden" class="form-control" name="id_trx_kas" id="id_trx_kas" value="<?php echo $id_trx_kas; ?>"  />
          <td  style="vertical-align: top;">Diterima Dari</td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="dari" id="dari" value="<?php echo $row->dari; ?>" <?php echo $disabled; ?> />
		  </td>
        </tr>
		<tr>
		<td style="vertical-align: top;">Catatan</td>
		<td style="vertical-align: top;" colspan="3">
		<textarea name="catatan" value="2" class="form-control" <?php echo $disabled; ?> ><?php echo $row->keterangan; ?></textarea>
		</td>
		</tr>
		   <tr>
          <td  style="vertical-align: top;">Sesuai Dokumen</td>
          <td  style="vertical-align: top;"><input type="text" class="form-control" name="dokumen" id="dokumen" value="<?php echo $row->dok; ?>" <?php echo $disabled; ?> />
		   <td  style="vertical-align: top;" class="pull-right">Nomor Dokumen</td>
          <td  style="vertical-align: top;"><input type="text" class="form-control" name="no_dokumen" id="no_dokumen" value="<?php echo $row->no_dok; ?>" <?php echo $disabled; ?> />
		  </td>
        </tr>
		  <tr>
          <td  style="vertical-align: top;">Uang Sejumlah</td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="jumlah" id="jumlah" value="<?php echo number_format($row->jumlah); ?>" <?php echo $disabled; ?> onkeyup="formatNumber(this);" />
		  </td>
        </tr>
		  <tr>
          <td  style="vertical-align: top;">Terbilang</td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="terbilang" id="terbilang"  value="<?php echo terbilang($row->jumlah); ?>" <?php echo $disabled; ?> />
		  </td>
        </tr>
	</table>	
	</div>
	</div>
	</div>
	</div>
	</div>
 	
	
<?php if($jurnal_data) { ?>	
<div class="col-lg-12">
	<div class="panel panel-info">
  <div class="panel-heading">DETAIL AKUN</div>
  <div class="panel-body">

	<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
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
</div>		
</div>

<?php } else { ?>
<?php


	echo form_hidden('f_id', $f_id);
	echo form_hidden('goto', current_url());

	$data['class'] = 'input';	
?>	
<div class="col-lg-12">
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
					$datatgl['class'] = "form-control";
					$data['rows'] = "2";
					echo form_textarea($data);
				?>
			</td>
		</tr>	
	</table>
	</div>
	<div class="col-lg-12">	
	<h5>Detail</h5>
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
	</table>
	<br/>
	<div class="addRow"><a href="javascript:addRow();" class="btn btn-danger btn-sm"><span style="color:#fff;">TAMBAH BARIS</span></a></div>
	
	<div class="buttons">
		<?php
			echo form_submit('post','Post', "id = 'button-save'" );
			echo form_reset('reset','Reset', "id = 'button-reset'" );
		?>
	</div>
	</div>
<?php echo form_close(); ?>
<?php } ?>
				<?php }} ?>
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