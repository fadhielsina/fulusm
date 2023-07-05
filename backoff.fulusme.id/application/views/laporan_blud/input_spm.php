
<div class="col-lg-12">	
    <h3 class="pull-left"> <i class="fa fa-windows"></i> <?php echo $title; ?></h3>
<br/>
<div class="post-body">
	<?php 	echo form_open('Procurement/proses_input_spm', array('id' => 'jurnal_form_spm','class' => 'form-material m-t-40'));

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
        <div class="row">
          <div class="col-md-6"><h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4></div>
          <div class="col-md-6 text-right">
              <a class="btn btn-primary" href="<?php echo base_url('Procurement/spp') ?>"><?= $this->lang->line('kembali') ?></a>
          </div>
      </div>
	<table class="table color-table info-table">
	<input type="hidden" class="form-control" name="jns" id="jns" value="KM"  />
		<input type="hidden" name="id_procurements" id="id_procurements" value="<?php echo $id ?>">
		<input type="hidden" class="form-control" name="userid" id="userid" value="<?php echo $userid; ?>"/>
		<input type="hidden" class="form-control" name="tipe_trx" id="tipe_trx" value="add"  />
		<tr>
          <td  style="vertical-align: top;width:20%"><?= $this->lang->line('no_invoice') ?></td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="invoiceNo" id="invoiceNo" readonly=""  value="<?php echo (isset($procurement['invoiceNo']))?$procurement['invoiceNo']:set_value('invoiceNo') ?>"/>
		  </td>
        </tr>
		<tr>
          <td  style="vertical-align: top;width:20%"><?= $this->lang->line('no_spp') ?></td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="no_spp" id="no_spp" readonly=""  value="<?php echo (isset($procurement['noSpp']))?$procurement['noSpp']:set_value('no_spp') ?>"/>
		  </td>
        </tr>
        <tr>
          <td  style="vertical-align: top;width:20%"><?= $this->lang->line('uraian') ?> SPP</td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="uraianSpp" id="uraianSpp" readonly=""  value="<?php echo (isset($procurement['uraianSpp']))?$procurement['uraianSpp']:set_value('uraianSpp') ?>"/>
		  </td>
        </tr>
		<tr>
		<td style="vertical-align: top;"><?= $this->lang->line('no_spm') ?></td>
		<td style="vertical-align: top;" colspan="3">
		<input type="text" class="form-control" name="no_spm" id="no_spm"  />
		</td>
		</tr>
		<tr>
		<td style="vertical-align: top;"><?= $this->lang->line('tanggal')." ".$this->lang->line('no_spm') ?></td>
		<td style="vertical-align: top;" colspan="3">
		<input type="date" class="form-control" name="tgl_spm" id="tgl_spm" value="<?php echo date('Y-m-d') ?>" />
		</td>
		</tr>
		  <tr>
          <td  style="vertical-align: top;"><?= $this->lang->line('uang_sejumlah') ?></td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="jumlah" id="jumlah" onkeyup="formatNumber(this);" value="<?php echo (isset($procurement['total_purchases']))?$procurement['total_purchases']:set_value('jumlah') ?>" readonly="" />
		  </td>
        </tr>
<!--		  <tr>
          <td  style="vertical-align: top;"><?= $this->lang->line('terbilang') ?></td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="terbilang" id="terbilang" readonly />
		  </td>-->
        </tr>
        <tr>
            <td colspan="4">
                <div class="row">
        <?php
        foreach($pajakData as $index=>$item){
        	$attributes = 'pph_final' === $index ? 'readonly="true"' : '';
            echo '<div class="col-md-3 pt-2">
                '.$item['label'].'</div>
                <div class="col-md-3 pt-2">
                 <input type="text" class="form-control" name="'.$index.'" id="'.$index.'" value="'.$item['value'].'" '.$attributes.' onkeyup="formatNumber(this);" />
                </div>
            ';
        }
        ?>
                </div>
            </td>
        </tr>
        </tr>
		  <tr>
          <td  style="vertical-align: top;"><?= $this->lang->line('total_bayar') ?></td>
          <td  style="vertical-align: top;" colspan="3"><input type="text" class="form-control" name="jumlah_dibayarkan" id="jumlah_dibayarkan" value="" onkeyup="formatNumber(this);" readonly="true"  />
		  </td>
        </tr>
        </tr>
		  <!-- <tr>
          <td  style="vertical-align: top;"><?= $this->lang->line('kas_keluar') ?></td>
          <td  style="vertical-align: top;" colspan="3">
          	<?php 
				$akun['id'] = 'akun_spm';
				$akun['class'] = 'form-control';
				echo form_dropdown('akun_spm_debit', $accounts, '' ,$akun);
			?>
			<?php 
				echo form_hidden('akun_spm_kredit',$akunUtang['id'] );
			?>
		  </td>
        </tr> -->
	</table>	
	
	
	</div>
	</div>
 <div class="card">
  <div class="card-body">
  <!--<h4 class="card-title"><?= $this->lang->line('jurnal_kas_masuk') ?></h4>
  		
<?php


	echo form_hidden('f_id', $f_id);
	echo form_hidden('goto', current_url());

	$data['class'] = 'input';	
?>	

	
	<div class="col-lg-12">
	 <table class="table color-table info-table">
		<tr>
			<th><?php echo form_label($this->lang->line('tanggal').' *','tanggal'); ?></th>
			<td>
				<?php 
					$datatgl['name'] = 'tanggal';
					$datatgl['type'] = 'date';
					$datatgl['id'] = 'example-date-input';
					$datatgl['class'] = 'form-control form-control-line';
					$datatgl['value'] = date('Y-m-d');
					$datatgl['title'] = "Tanggal tidak boleh kosong dan harus diisi dengan format dddd-mm-yy";	
					echo form_input($datatgl);
				?>
			</td>				 
		</tr>	
		<tr>
			<th><?php echo form_label($this->lang->line('deskripsi').' *','deskripsi'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'deskripsi';					
					$data['title'] = "Deskripsi tidak boleh kosong";
					$data['class'] = "form-control";
					$data['rows'] = "2";
					$data['value'] = (isset($procurement['description']))?$procurement['description']:set_value('deskripsi') ;
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
						$data['value'] = "";
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
						$data['value'] = "";
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
						$data['value'] = "";
						echo form_input($data);
					?>
				</td>
				<td>
					<?php 
						$data['id'] = 'keterangan'.$i;
						$data['class'] = 'form-control';
						$data['name'] = 'keterangan'.$i;
						$data['value'] = "";
						echo form_input($data);
					?>
				</td>
			</tr>
		<?php } ?>
	</table> -->
	<br/>
	<!-- <div class="pull-right"><a href="javascript:addRow();" class="btn btn-danger btn-sm"><span style="color:#fff;"><?= $this->lang->line('tambah_baris') ?></span></a></div> -->
	
	<div class="pull-left">
		<?php
			echo form_submit('post','Post', "id = 'button-save' class='btn btn-primary'" );
			echo form_reset('reset','Reset', "id = 'button-reset'  class='btn btn-secondary'" );
		?>
	</div>
	</div>
<?php echo form_close(); ?>
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
		$('#jumlah').add($('#ppn')).trigger("keyup");
		
		// auto count
		var timeout = 0,
			get_total_pph = function(){
				return Number($('#pph_21').val().replace(',', '')) + Number($('#pph_22').val().replace(',', '')) + Number($('#pph_23').val().replace(',', ''));
			},
			get_total_bayar = function(){
				return Number($('#jumlah').val().replace(',', '')) - Number($('#ppn').val().replace(',', '')) - get_total_pph();
			};
		$('#pph_21, #pph_22, #pph_23').on('keyup', function(){
			clearTimeout(timeout);
			timeout = setTimeout(function(){
				$('#pph_final').val( get_total_pph() ).trigger('keyup');
				$('#jumlah_dibayarkan').val( get_total_bayar() ).trigger('keyup');
			},300);
		} ).trigger('keyup');
		
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