<style>
 .makeover{
                vertical-align: middle;
            }
</style>

<div class="col-lg-12">	<h3 class="badge badge-info"><?php echo $title; ?></h3></div>
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
	
	echo "</div>"; ?>	
<div class="row">
<div class="post-body col-lg-6">
	<?php echo form_open('kas/update_trx_kas', array('id' => 'update_kas')); ?>
	<?php  foreach ($po_data as $row){ $jml_po=$row->trxTotal;?>
	<div class="">
	<div class="card card-outline-info">
  <div class="card-header text-white">BUKTI PO
  <div class="pull-right"><input id="chkRead" type="checkbox" name="chkRead" class="makeover" /> EDIT DATA</div>
  </div>
  <div class="card-body">
 
	<div class="col-lg-12">	
	 <div class="panel panel-info">
  <div class="panel-body">
	<table class="table no-border" border="0" align="center" cellpadding="2" cellspacing="0">
	 <tr>
          <td  style="vertical-align: top;">No PO</td>
          <td  style="vertical-align: top;" colspan="3">
		  <input type="hidden" class="form-control" name="type_trx" value="po" />
		  <input type="hidden" class="form-control" name="id_trx" value="<?php echo $row->trxID; ?>" />
		  <input type="text" class="form-control" name="nopo" id="nopo" value="<?php echo $row->invoiceBuyID; ?>" readonly />
		  </td>
        </tr>
		<tr>
          <td  style="vertical-align: top;">Tanggal Input</td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="tgl_trx" id="datepicker2" value="<?php echo $row->trxDate; ?>" readonly />
		  </td>
        </tr>
	  <tr>
          <td  style="vertical-align: top;">Lokasi</td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="lokasi" id="lokasi" value="<?php echo $row->identityName; ?>" readonly />
		  </td>
        </tr>
		   <tr>
          <td  style="vertical-align: top;">Nama Vendor/Supplier</td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="kepada" id="kepada" value="<?php echo $row->supplierName; ?>" readonly />
		  </td>
        </tr>
		<tr>
		<td style="vertical-align: top;">Catatan</td>
		<td style="vertical-align: top;" colspan="3">
		<textarea name="catatan" value="2" id="catatan" class="form-control" readonly ><?php echo $row->note; ?></textarea>
		</td>
		</tr>
		  <tr>
          <td  style="vertical-align: top;">Jumlah</td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="jumlah" id="jumlah_det" value="<?php echo number_format($row->trxTotal); ?>" readonly onkeyup="formatNumber(this);" />
		  </td>
        </tr>
		  <tr>
          <td  style="vertical-align: top;">Down Payment</td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="trxDp" id="trxDP" value="<?php echo number_format($row->trxDP); ?>" readonly onkeyup="formatNumber(this);" />
		  </td>
        </tr>
		
	</table>	
	<div id="simpanedit">
	<input type="submit" class="btn btn-info btn-sm pull-right" value="Simpan Perubahan" />
	</div>
	<table>
	<tr>
		<td colspan="3"><a href="<?php echo base_url();?>purchasing/batal_trx_po/<?php echo $row->invoiceBuyID; ?>" class="btn btn-xs btn-danger pull-left" onclick="return confirm('Apakah Anda yakin akan menghapus transaksi ini ?')" />HAPUS TRANSAKSI</a></td>
		</tr>
	</table>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<?php } ?>
	<?php echo form_close(); ?>
	</div>
	
	<div class="col-lg-6">
 	<div class="card card-outline-info">
  <div class="card-header text-white">JURNAL PEMBELIAN</div>
  <div class="card-body">
  		

<?php if(!$jurnal_data) { ?>
	<?php 	echo form_open('purchasing/insert_jurnal_po', array('id' => 'jurnal_form')); ?>
	<?php
	echo form_hidden('f_id', $f_id);
	echo form_hidden('goto', current_url());

?>	
	<table class="table no-border" border="0" align="center" cellpadding="2" cellspacing="0">
		<tr>
			<th><?php echo form_label('Tanggal Jurnal*','tanggal'); ?></th>
			<td>
			<input type="hidden" class="form-control" name="k_type"  value="kkt" />
			<input type="hidden" class="form-control" name="no_kas" id="no_kas" value="<?php echo $id_trx_kas; ?>" />
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
			<th><?php echo form_label('Deskripsi Jurnal','deskripsi'); ?></th>
			<td>
			<textarea class="form-control" name ="deskripsi" id="deskripsi"></textarea>
			</td>
		</tr>	
		<tr>
			<th>Jurnal Pembelian ? </th>
			<td>
				<input type="submit" value="Buat Jurnal Pembelian" class="btn btn-info btn-sm" />
			</td>
		</tr>	
	</table>
	<?php echo form_close();
	
} else {?> 
<?php  foreach ($jurnal_data as $dat){ ?>
<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
<tr>
			<th><?php echo form_label('No Jurnal*','tanggal'); ?></th>
			<td>
			
				<?php 
					$dataformdet['value'] = $dat->no;
					$dataformdet['readonly'] = "readonly";
					echo form_input($dataformdet);
				?>
			</td>				 
		</tr>	
		<tr>
			<th><?php echo form_label('No Invoice*','tanggal'); ?></th>
			<td>
			
				<?php 
					$dataformdet['value'] = $dat->invoice_no;
					$dataformdet['readonly'] = "readonly";
					echo form_input($dataformdet);
				?>
			</td>				 
		</tr>	
		<tr>
			<th><?php echo form_label('Tanggal Jurnal*','tanggal'); ?></th>
			<td>
			
				<?php 
					$dataformdet['value'] = $dat->tgl;
					$dataformdet['readonly'] = "readonly";
					echo form_input($dataformdet);
				?>
			</td>				 
		</tr>	
		<tr>
			<th><?php echo form_label('Deskripsi Jurnal','deskripsi'); ?></th>
			<td>
			<textarea  readonly><?php echo $dat->keterangan; ?></textarea>
			</td>
		</tr>	
	</table>
<?php } ?>
<?php }
	?>	
	<?php if($jurnal_data) {
foreach($jurnal_data as $rowj) { $is_post=$rowj->is_post;} if($is_post!='1'){?>
	<?php 	echo form_open('purchasing/insert_jurnal_po_act', array('id' => 'jurnal_form')); ?>
	<h5>Detail Akun</h5>
	<table id="tblDetail" name="tblDetail" class="data-table">
	<tr>
			<th><?php echo form_label('Kode Akun*','akun'); ?></th>
			<td>
			<input type="hidden" class="form-control" name="k_type"  value="kkt" />
				 <input  type="text" name="kodeakun" id="kodeakun"  size="30" maxlength="250" onClick="this.value='';" />
					<?php 
						$datakode['id'] = 'id_jurn';
						$datakode['name'] = 'id_jurnal';
						$datakode['value'] = $idjur;
						$datakode['type'] = 'hidden';
						echo form_input($datakode);
					?>
					<?php if($jurnal_data_det) {
						foreach($jurnal_data_det as $row) {
							$item_c=$row->item;
							$item_ne=$item_c+1;
						$datacount['id'] = 'count_item';
						$datacount['name'] = 'count_item';
						$datacount['value'] = $item_ne;
						$datacount['type'] = 'hidden';
						echo form_input($datacount);
						}
					} else {?>
					<?php 
					$datacount['id'] = 'count_item';
						$datacount['name'] = 'count_item';
						$datacount['value'] = '1';
						$datacount['type'] = 'hidden';
						echo form_input($datacount);
					}?>
				</td>
		</tr>	
		
		<tr>
			<th><?php echo form_label('Nama Akun*','akun'); ?></th>
			<td>
					<?php 
						$data_na['id'] = 'namaakun';
						$data_na['name'] = 'namaakun';
						$data_na['readonly'] = 'readonly';
						$data_na['class'] = 'form-control';
						echo form_input($data_na);
					?>
					<?php 
						$data_coa['id'] = 'idakun';
						$data_coa['name'] = 'idakun';
						$data_coa['type'] = 'hidden';
						echo form_input($data_coa);
					?>
						<input type="hidden" class="form-control" name="no_kas" id="no_kas" value="<?php echo $id_trx_kas; ?>" />
				</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Posisi D/K','d/k'); ?></th>
			<td>
				<select name="dk">
				<option value="d">Debet</option>
				<option value="k">Kredit</option>
				</select>
				</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Jumlah','jumlah'); ?></th>
		<td>
					<?php 
						$data['id'] = 'jumlah_jur';
						$data['name'] = 'jumlah';
						$data['onkeyup']="formatNumber(this);";
						echo form_input($data);
					?>
				</td>
		</tr>
		<tr>
			<th><?php echo form_label('Keterangan','keterangan'); ?></th>
		<td>
					<?php 
						$dataket['id'] = 'keterangan';
						$dataket['name'] = 'keterangan';
						$dataket['class'] = 'form-control';
						echo form_input($dataket);
					?>
				</td>
		</tr>
		
	</table>
	<br/>
	<div class="buttons">
		<?php
			echo form_submit('post','Simpan', "id = 'button-save'" );
		?>
	</div>
<?php echo form_close(); ?>
	<?php }}  ?>

<?php if($jurnal_data_list) { ?>
 <div class="col-lg-12">
	<table cellpadding="0" cellspacing="0" border="0">
	<thead>
		<tr>
			<th>Akun</th>
			<th>Debit</th>
			<th>Kredit</th>
			<th>Keterangan</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if($jurnal_data_list)
			{
				$dtotal=0;
				$ktotal=0;
				foreach ($jurnal_data_list as $row) 
				{ 
					$idtrx_k_i=$row->trx_kas_in_id;
					if($row->debit_kredit == 1)
					{
						$d = $row->nilai;
						$k = '';
						$dtotal=$dtotal+$d;
					}
					else
					{
						$d = '';
						$k = $row->nilai; 
						$ktotal=$ktotal+$k;
					}
					echo '<tr>';
					echo '<td>'.$row->account_name.'</td>';
					echo '<td>'.number_format(abs($d)).'</td>';
					echo '<td>'.number_format(abs($k)).'</td>';	
					echo '<td>'.$row->ket_jurnal_det.'</td>';
					?>
					<td>
					<?php if($is_post!='1') { ?>
					<?php echo anchor(site_url()."purchasing/btl_jurnal_po/".$row->id_jr_det."/".$id_trx_kas."/".$row->jurnal_id, 'batal' , array('class' => 'btn btn-xs btn-danger')); ?>
					<?php } ?>
					</td>
					<?php
					echo '</tr>';
					
					
					
					
				}
				echo '<tr>';
					echo '<td><h4>Jumlah</h4></td><td><h4>'.number_format($dtotal).'</h4></td><td><h4>'.number_format($ktotal).'</h4></td>';
					echo '</tr>';
				if($dtotal!=$ktotal)
					{
						echo '<tr>';
					echo '<td  colspan="4"><b class="label label-danger">Jumlah Debit dan Kredit tidak sama</b></td>';
					echo '</tr>';
					}
			if(($jml_po!=$ktotal)||($jml_po!=$dtotal))
					{
						echo '<tr>';
					echo '<td colspan="4"><h4 class="text text-danger">Jumlah Transaksi dan jurnal tidak sama!!</h4></td>';
					echo '</tr>';
					}		
			 
			}
		?>
	</tbody>	
</table>		
<?php if($dtotal==$ktotal)
					{ ?>
<div class="buttons">

<?php if($is_post!='1') { ?>
					<?php echo anchor(site_url()."purchasing/pra_jurnal/".$id_trx_kas, 'Posting' , array('class' => 'btn btn-xs btn-warning')); } else {echo "&nbsp;&nbsp; <b>Sudah diposting!</b>";
				?>
				
			<a href="<?php echo base_url();?>purchasing/unpost_jur/<?php echo $row->invoice_no; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda yakin akan unpost jurnal ini ?')" />UNPOST JURNAL</a><hr/>
				<?php	echo form_button(array('class' => 'btn btn-success btn-sm', 'content' => 'Tambah Transaksi Baru', 'onClick' => "location.href='".site_url()."purchasing/purchasing_add'" ));}?>
			
	</div>
					<?php } ?>
 </div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>

<script>

	$('#jumlah_det').keyup(function() {  
	var bilangan=parseFloat($('#jumlah_det').val().split(",").join(""));
	if(isNaN(bilangan)){
  	alert('Yang anda tulis bukan bilangan')
    return false;
  }
     $('#terbilang_det').val(terbilang(bilangan));
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
 $('#simpanedit').hide(); 
	$('#jumlah_jur').keyup(function() {  
	var bilangan2=parseFloat($('#jumlah').val().split(",").join(""));
	var bilangan=parseFloat($('#jumlah_jur').val().split(",").join(""));
	if(!isNaN(bilangan)){
		if(bilangan>bilangan2)
		{
			alert('Jumlah melebihi nilai invoice!!');
			$('#jumlah_jur').val('');
    return false;
		}
	}
	else {
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
		


<script type="text/javascript">
        $(document).ready(function () {
            $("#chkRead").change(function () {
                if ($(this).is(":checked")) {
					alert("Anda akan melakukan perubahan pada data!!" );
                    $('#catatan').removeAttr("readonly");
					 $('#datepicker2').removeAttr("readonly");
					$('#dokumen').removeAttr("readonly");
					$('#no_dokumen').removeAttr("readonly");
					$('#jumlah_det').removeAttr("readonly");
					$('#kepada').removeAttr("readonly");
					 $('#simpanedit').show(); 
                }
                else {
                    $('#catatan').attr('readonly', true);
					 $('#datepicker2').attr('readonly', true);
					$('#dokumen').attr('readonly', true);
					$('#no_dokumen').attr('readonly', true);
					$('#jumlah_det').attr('readonly', true);
					$('#kepada').attr('readonly', true);
					 $('#simpanedit').hide(); 
                }
            });
        });
    </script>