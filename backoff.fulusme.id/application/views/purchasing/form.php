<div class="post-body">
<div id="dialog-form"></div>
	<?php 	echo form_open('purchasing/fill_data_pembelian', array('id' => 'jurnal_form'));

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
	<div class="card card-outline-info">
  <div class="card-header"><h4 class="mb-0 text-white"><i class="fa fa-plus-square"></i> FORM TAMBAH DATA PEMBELIAN  <span class="pull-right">
					<?php echo anchor(site_url()."invoice", '<i class="fa fa-backward"></i> Kembali '); ?>
     </span></h4></div>
  <div class="card-body">
<div id="form">
    <fieldset class="atas">
      <table width="100%">
        <tr>
          <td valign="top" style="vertical-align: top;" width="33%">
		  <table width="100%">
		 <input type="hidden" class="form-control" name="tipe_trx" id="tipe_trx" value="add"  /> 
		 <input type="hidden" name="namauser" id="invoiceID" value="<?php echo $usernama; ?>" disabled class="form-control"/>
			  <input type="hidden" name="iduser" id="invoiceID" value="<?php echo $userid; ?>" />
			 <tr>
              <td colspan="3" style="color:#6b56c2; background-color: #fff;padding: 6px;border: thin solid #a2a1ad;"><b><i class="fa  fa-building-o"></i> DATA VENDOR</b> <a id="OpenDialog_po" class="btn btn-default btn-xs pull-right"><i class="fa fa-plus"></i> Tambah Vendor</a></td>
			 
            </tr>
			  <tr>
              <td width="100">Cari Vendor</td>
              <td>:</td>
              <td><input  type="text" name="carivendor" id="carivendor"   class="form-control" onClick="this.value='';"/></td>
            </tr>
            <tr>
              <td>Nama Vendor</td>
              <td>:</td>
              <td>
			  <p id="p_nama"></p>
			  <input required type="hidden" name="namavendor" id="namavendor"  size="30" maxlength="250" class="form-control"/></td>
            </tr>
            <tr>
              <td>Kode Vendor</td>
              <td>:</td>
              <td>
				<p id="p_kode"></p>
                <input  hidden name="vendorID" id="vendorID"  value="" type="text" />
                <input readonly type="hidden" name="vendorCode" id="vendorCode" readonly  size="30" maxlength="50" class="form-control"/>
              </td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>:</td>
              <td>
			  <p id="p_addr"></p>
			  <input type="hidden" name="vendorAddress" id="vendorAddress" readonly  size="30" class="form-control" /></td>
            </tr>
			 <tr>
              <td>Kota</td>
              <td>:</td>
              <td>
			  <p id="p_city"></p>
			  <input type="hidden" name="vendorCity" id="vendorCity" readonly  size="30" class="form-control" /></td>
            </tr>
            <tr>
              <td>telp</td>
              <td>:</td>
              <td>
			   <p id="p_telp"></p>
			  <input type="hidden" name="vendorPhone" id="vendorPhone"  size="30" maxlength="50" class="form-control"/></td>
            </tr>
			
			
          </table>
        </td>
        <td valign="top" style="vertical-align: top;" width="33%">


          <table width="100%">
		 <tr>
              <td colspan="3" style="color:#6b56c2; background-color: #fff;padding: 6px;border: thin solid #a2a1ad;"><b><i class="fa fa-shopping-cart"></i>  DATA TRANSAKSI</b></td>
			 
            </tr>
		   <tr>
              <td width="30%">No PO</td>
              <td width="5">:</td>
              <td><input required type="text" name="invoiceIDmanual" id="invoiceIDmanual" size="30" maxlength="30" class="form-control" /></td>
            </tr>
            <tr>
              <td width="30%">Tgl PO</td>
              <td width="5">:</td>
              <td><input type="text" name="trxDate" id="datepicker" size="30" maxlength="30" class="form-control datepicker" /></td>
            </tr>
		<tr>
          <td valign="top">Note</td>
          <td>:</td>
          <td><textarea  name="note" id="note"  rows="4" cols="50" style="width: 210px; height: 50px" class="form-control"></textarea></td>
        </tr>
        <tr>
          <td>Total Transaksi</td>
          <td>:</td>
          <td><input type="text" name="trxTotaltrx" id="trxTotaltrx"  size="30" maxlength="50" onkeyup="formatNumber(this);" onchange="formatNumber(this);" /></td>
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
          <td><input  class="form-control" type="hidden" name="trxPPN" id="trxPPN"  size="30" maxlength="50" value="10"/>10 %</td>
        </tr>
		  <tr>
          <td>Faktur Total</td>
          <td>:</td>
          <td><input type="text" name="trxTotal" id="trxTotal"  size="30" maxlength="50" onkeyup="formatNumber(this);" onchange="formatNumber(this);" /></td>
        </tr>
        </table>
      </td>
      <td valign="top" style="vertical-align: top;" width="33%">
       <table>
		 
		
		 <tr>
              <td colspan="3" style="color:#6b56c2; background-color: #fff;padding: 6px;border: thin solid #a2a1ad;"><b><i class="fa fa-money"></i>  DATA PEMBAYARAN</b></td>
			 
            </tr>
			 <tr>
          <td  style="vertical-align: top;">Total Bayar / DP</td>
          <td  style="vertical-align: top;">:</td>
          <td  style="vertical-align: top;"><input class="form-control" type="text" name="trxTotalbyr" id="trxTotalbyr"  size="30" maxlength="50"onkeyup="formatNumber(this);" onchange="formatNumber(this);" />
		  </td>
        </tr>
		 <tr>
            <td>Cara Pembayaran</td>
            <td>:</td>
            <td>
              <select class="form-control" style="width: 200px" name="trxStatus" id="trxStatus">
            
                <option value="1">Cash</option>
                <option value="2">Termin</option>
              </select>
            </td>
          </tr>

			 <tr id="termin">
            <td width="30%">Jatuh Tempo</td>
            <td width="5">:</td>
            <td><input class="form-control" type="text" name="trxTerminDate" id="datepicker4" class="tgl" size="30" maxlength="30" /></td>
          </tr>
			 <tr>
            <td>Jenis Pembayaran</td>
            <td>:</td>
            <td>
              <select class="form-control" style="width: 200px" name="jns_bayar" id="jns_bayar">
              <?php
				 foreach ($jenisbyr as $jenisbyr):
				?>
				<option value="<?= $jenisbyr->id ?>" ><?php echo $jenisbyr->name ?></option>
				<?php endforeach ?>
              </select>
			 
            </td>
          </tr> 
		  		  
         <tr >
          <td style="vertical-align: top;">Biaya Admin</td>
		   <td  style="vertical-align: top;">:</td>
          <td><input class="form-control" type="text" name="b_admin" id="b_admin"  size="30" maxlength="50"  onkeyup="formatNumber(this);" onchange="formatNumber(this);"/></td>
        </tr>
      </table>

    </td>
  </tr>
  		
 
</table>
</fieldset>
</div>
	<div class="buttons">
		<?php
			echo form_submit('post','Simpan', "id = 'button-save'" );
			echo form_reset('reset','Reset', "id = 'button-reset'" );
		?>
	</div>
<?php echo form_close(); ?>
</div>
</div>


</div>
	

</div>	
 
 
  <div id="dialog-purchase" title="Dialog Title" style="display: none" >
<form action="" method="POST" id="vendor_form" class="form-group">

	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">	
			<tr>
			<th><?php echo form_label('Kode Vendor *','kode'); ?></th>
			<td>
				<?php 
					$dataven['name'] = $dataven['id'] = 'kode';
					$dataven['class'] = 'form-control';
					$dataven['title'] = "Kode tidak boleh kosong";
					$dataven['value'] = $vendorcode;
					echo form_input($dataven);
				?>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Nama Vendor*','nama'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'nama';
					$data['class'] = 'form-control';
					$data['title'] = "Nama tidak boleh kosong";
					echo form_input($data);
				?>
			</td>
		</tr>		
		<tr>
			<th><?php echo form_label('NPWP','npwp'); ?></th>
			<td>
				<?php 
					$nomor['title'] = "NPWP harus diisi dengan angka";	
					$nomor['name'] = $nomor['id'] = 'npwp';
					$nomor['maxlength']='2';
					$nomor['size']='4';
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp1';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp2';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp3';
					$nomor['maxlength']='1';
					$nomor['size']='2';
					echo form_input($nomor);

					echo "&nbsp;-";

					$nomor['name'] = $nomor['id'] = 'npwp4';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					echo form_input($nomor);

					echo "&nbsp;.";

					$nomor['name'] = $nomor['id'] = 'npwp5';
					$nomor['maxlength']='3';
					$nomor['size']='5';
					echo form_input($nomor);
				?>							
			</td>
		</tr>						
		<tr>
			<th><?php echo form_label('Alamat *','alamat'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'alamat';
					$data['title'] = "Alamat tidak boleh kosong";						
					echo form_input($data);
				?>
			</td>
		</tr>				
		<tr>
			<th><?php echo form_label('Kota *','kota'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'kota';
					$data['title'] = "Alamat tidak boleh kosong";						
					echo form_input($data);
				?>
			</td>
		</tr>				
		<tr>
			<th><?php echo form_label('Telpon *','telpon'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'telpon';
					$data['title'] = "Telpon tidak boleh kosong";
					echo form_input($data);
				?>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Penanggung Jawab','UP'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'up';
					$data['title'] = "Email harus diisi dengan format email yang benar. Contoh : klien@frigia.com";			
					echo form_input($data);
				?>
			</td>
		</tr>		
			<tr><td></td>
			<td> <input id="submit-pu" class="btn btn-info" type="submit" value="Tambah Vendor"></td></tr>
	</table>
	
	

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
        $(document).ready(function () {
            $("#OpenDialog_po").click(function () {
                $("#dialog-purchase").dialog({modal: true, height: 400, width: 1005,title: 'Tambah Data Vendor', });
            });
        });
    </script>


 <script type="text/javascript">

	    $(this).ready( function() {
    		$("#carivendor").autocomplete({
      			minLength: 1,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo site_url(); ?>auto/get_vendor",
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
                   $("#vendorID").val(ui.item.supplierID);
					$("#vendorCode").val(ui.item.supplierCode);
					$("#namavendor").val(ui.item.supplierName);
					$("#vendorAddress").val(ui.item.supplierAddress);
					$("#vendorPhone").val(ui.item.supplierPhone);
					$("#vendorCity").val(ui.item.suppliercity);
					
					$("#p_kode").text(ui.item.supplierCode);
					$("#p_nama").text(ui.item.supplierName);
					$("#p_telp").text(ui.item.supplierPhone);
					$("#p_addr").text(ui.item.supplierAddress);
					$("#p_city").text(ui.item.suppliercity); 
        },		
    		});
	    });
	    </script>
		
		<script>
    $(document).ready(function(){
        $("#vendor_form").submit(function(e){
            e.preventDefault();
			 var kode= $("#kode").val();
            var nama= $("#nama").val();
			  var npwp= $("#npwp").val();
			   var npwp1= $("#npwp1").val();
			    var npwp2= $("#npwp2").val();
				 var npwp3= $("#npwp3").val();
				  var npwp4= $("#npwp4").val();
				   var npwp5= $("#npwp5").val();
				    var alamat= $("#alamat").val();
				  var kota= $("#kota").val();
				var telpon= $("#telpon").val();
				var up= $("#up").val();
            $.ajax({
                type: "POST",
                url: '<?php echo site_url() ?>vendor/insert',
                data: {kode:kode,nama:nama,npwp:npwp,npwp1:npwp1,npwp2:npwp2,npwp3:npwp3,npwp4:npwp4,npwp5:npwp5,alamat:alamat,kota:kota,telpon:telpon,up:up},
                success:function(data)
                {
					$('#dialog-purchase').dialog('close');
					$('#vendor_form')[0].reset();
                    alert('Simpan Data Berhasil!!');
					location.reload();
                },
                error:function()
                {
                    alert('fail');
                }
            });
        });
    });
</script>



<script>
	
	
	$('#trxTotaltrx').keyup(function() {  
      updateSubTotal();
    });
	
    $('#trxDiscount').keyup(function() {  
      updateSubTotal();
    });
	
	$('#trxPPN').keyup(function() {  
      updateTotal();
    });

    var updateSubTotal = function () {
                var trxTotaltrx=parseInt($('#trxTotaltrx').val().split(",").join(""));
				 var trxDiscount=parseInt($('#trxDiscount').val().split(",").join(""));
		
		  if (isNaN(trxTotaltrx)) 
		 {
			 trxTotaltrx=0;
		 }
				var sub_total=trxTotaltrx;
                var sub_total_disc=(trxTotaltrx)-trxDiscount;
				if(isNaN(sub_total)) {
$('#trxSubtotal').val(numberWithCommas(sub_total));
$('#trxTotal').val(numberWithCommas((sub_total)+((sub_total*10)/100)));
}
else 
{
$('#trxSubtotal').val(numberWithCommas(sub_total_disc));
$('#trxTotal').val(numberWithCommas((sub_total_disc)+((sub_total_disc*10)/100)));
}
    };
	
	    var updateTotal = function () {
			var trxSubtotal=parseInt($('#trxSubtotal').val().split(",").join(""));

                var totaltrx=(trxSubtotal)+((trxSubtotal*10)/100);
				
				if(isNaN(totaltrx)) {
									$('#trxTotal').val(numberWithCommas(trxSubtotal));
}
else 
{
				$('#trxTotal').val(numberWithCommas(totaltrx));
}

               
    };
	
	
	function numberWithCommas(number) {
    var parts = number.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

</script>