
<br/><br/>
<div class="col-lg-12">	<h3 class="badge badge-info"> <i class="fa fa-windows"></i> <?php echo $title; ?></h3>
<div class="col-lg-12"></div>
<div class="col-lg-12">
  <div class="pull-right">
					<?php echo anchor(site_url()."invoice", 'Kembali ', 'class="btn btn-default"'); ?>
     </div>
	  </div>
</div>

<div class="post-body">
<div id="dialog-form"></div>
<div id="dialog-form2"></div>
<?php echo form_open('invoice/insert_data', array('id' => 'jurnal_form')); ?>	
<div class="col-lg-12">
	<div class="panel panel-info">
  <div class="panel-heading">FORM TAMBAH DATA</div>
  <div class="panel-body">
<div id="form">
    <fieldset class="atas">
      <table width="100%">
        <tr>
          <td valign="top" style="vertical-align: top;" width="33%">
		  <table width="100%">
		  
		   <tr>
              <td width="30%">User Input</td>
              <td width="5">:</td>
              <td><input type="text" name="namauser" id="invoiceID" value="<?php echo $usernama; ?>" disabled class="form-control"/>
			  <input type="hidden" name="iduser" id="invoiceID" value="<?php echo $userid; ?>" />
			  </td>
            </tr>
            <tr>
              <td width="30%">No Nota</td>
              <td width="5">:</td>
              <td><input required type="text" name="invoiceIDmanual" id="invoiceIDmanual" size="30" maxlength="30" class="form-control" /></td>
            </tr>
            <tr>
              <td width="30%">Tgl Invoice</td>
              <td width="5">:</td>
              <td><input type="text" name="trxDate" id="datepicker" size="30" maxlength="30" class="form-control" /></td>
            </tr>
			 <tr>
              <td colspan="3" style="color:#6b56c2; background-color: #fff;padding: 6px;border: thin solid #a2a1ad;"><b><i class="fa fa-fw fa-users"></i> DATA CUSTOMER</b> <a id="OpenDialog" class="btn btn-default btn-xs pull-right"><i class="fa fa-plus"></i> Tambah Customer</a></td>
			 
            </tr>
			   <tr>
              <td>Cari Costumer</td>
              <td>:</td>
              <td>
			  <input required type="text" name="kodemember" id="kodemember"  size="30" maxlength="250" onClick="this.value='';" class="form-control"/>
			  </td>
            </tr>
            <tr>
              <td>Nama Costumer</td>
              <td>:</td>
              <td><input readonly type="text" name="trxFullName" id="trxFullName"  size="30" maxlength="250" class="form-control"/>
			  </td>
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
			<tr>
          <td valign="top">Note</td>
          <td>:</td>
          <td><textarea  name="note" id="note"  rows="4" cols="50" style="width: 210px; height: 50px" class="form-control"></textarea></td>
        </tr>
			 <tr>
              <td colspan="3" style="color:#6b56c2; background-color: #fff;padding: 6px;border: thin solid #a2a1ad;"> <b><i class="fa fa-truck"></i>  DATA KENDARAAN</b> <a id="OpenDialog2" class="btn btn-default btn-xs pull-right"><i class="fa fa-plus"></i> Tambah Kendaraan</a></td>
			 
            </tr>
			
			 <tr>
            <td>Kode/No Plat</td>
            <td>:</td>
            <td><input type="text" name="nopol" id="nopol"  size="30" maxlength="50" class="form-control"/></td>
          </tr>
  <tr>
              <td>Cari Mobil</td>
              <td>:</td>
              <td>
			  <input  type="text" name="merk_search" id="merk_search"  size="30" maxlength="250" onClick="this.value='';" class="form-control"/>
			  </td>
            </tr>		  
          <tr>
            <td>Merk Mobil</td>
            <td>:</td>
            <td>
			  <input  hidden name="merkid" id="merkid"  value="" type="text" />
              <input readonly  type="text" name="merk" id="merk"   size="30" maxlength="50" class="form-control"/>
            </td>
          </tr>
					    <tr>
            <td>Type Mobil</td>
            <td>:</td>
            <td>
              <input readonly type="text" name="type" id="type"   size="30" maxlength="50" class="form-control"/>
            </td>
          </tr>
		  <tr>
            <td>Series Mobil</td>
            <td>:</td>
            <td>
              <input  readonly type="text" name="series" id="series"   size="30" maxlength="50" class="form-control"/>
            </td>
          </tr>
          
         
          </table>
        </td>
        <td valign="top" style="vertical-align: top;" width="33%">


          <table width="100%">

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
              <td colspan="3" style="color:#6b56c2; background-color: #fff;padding: 6px;border: thin solid #a2a1ad;"><b><i class="fa fa-shopping-cart"></i>  DATA TRANSAKSI</b></td>
			 
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
		 <tr>
          <td  style="vertical-align: top;">Total Bayar</td>
          <td  style="vertical-align: top;">:</td>
          <td  style="vertical-align: top;"><input class="form-control" type="text" name="trxTotalbyr" id="trxTotalbyr"  size="30" maxlength="50"onkeyup="formatNumber(this);" onchange="formatNumber(this);" />
		  </td>
        </tr>
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
		  		  
		<tr>
		<td style="vertical-align: top;">Status Bayar</td><td style="vertical-align: top;">:</td>
		<td style="vertical-align: top;">
		<input type="checkbox" name="stsbyr" value="2" > Pending
		<HR/>
		</td>
		</tr>
		 <tr>
              <td colspan="3" style="color:#6b56c2; background-color: #fff;padding: 6px;border: thin solid #a2a1ad;"><b><i class="fa fa-credit-card"></i>  <i>UNTUK PEMBAYARAN NON TUNAI</i></b></td>
			 
            </tr>
		<tr>
		<td style="vertical-align: top;">Bank Customer</td>
		 <td  style="vertical-align: top;">:</td>
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
          <td style="vertical-align: top;">No Kartu</td>
		   <td  style="vertical-align: top;">:</td>
          <td><input type="text" class="form-control" name="no_kar" id="no_kar"  size="30" maxlength="50"  /></td>
        </tr>
			<tr >
		<td style="vertical-align: top;">Bank EDC</td>
		 <td  style="vertical-align: top;">:</td>
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
          <td style="vertical-align: top;">Biaya Admin</td>
		   <td  style="vertical-align: top;">:</td>
          <td><input class="form-control" type="text" name="b_admin" id="b_admin"  size="30" maxlength="50"  onkeyup="formatNumber(this);" onchange="formatNumber(this);"/></td>
        </tr>
		 <tr>
  <td colspan="3">
  <div class="pull-right">
  <input type="submit" value="SIMPAN " class="btn btn-info"/>
  <a href="<?php echo site_url('invoice/');?>" class="btn btn-default"
  onclick="javascript: return confirm('Anda akan membatalkan transaksi ?')"/>BATAL </a>
  </div>
  </td>

  </tr>
      </table>

    </td>
  </tr>
  		
 
</table>
</fieldset>
</div>
</div>
</div>
</div>
	
<?php echo form_close(); ?>

</div>	




 <div id="dialog" title="Dialog Title" style="display: none" >
<form action="" method="POST" id="klien_form" class="form-group">

	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">	
			<tr>
			<th><?php echo form_label('Divisi *','nama'); ?></th>
			<td>
				<select name="divisi" id="divisi" >
					<option value="C">Car (C)</option>	
					<option value="B">Instalasi (B)</option>
					<option value="S">SO (S)</option>
										</select>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Nama *','nama'); ?></th>
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
			<th><?php echo form_label('No Identitas *','identitasno'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'no_identitas';
					$data['title'] = "Identitas tidak boleh kosong";						
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
			<th><?php echo form_label('Email','email'); ?></th>
			<td>
				<?php 
					$data['name'] = $data['id'] = 'email';
					$data['title'] = "Email harus diisi dengan format email yang benar. Contoh : klien@frigia.com";			
					echo form_input($data);
				?>
			</td>
		</tr>		
			<tr><td></td><td> <input id="submit-p" class="btn btn-info" type="submit" value="Tambah Klien"></td></tr>
	</table>
	
	

<?php echo form_close(); ?>
    </div>
	
	
	 <div id="dialog2" title="Dialog Title" style="display: none" >
<form action="" method="POST" id="kendaraan_form" class="form-group">
	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">	
		
		<tr>
			<th><?php echo form_label('Merk *','merk'); ?></th>
			<td>
				<?php 
					$datamerk['name'] = $datamerk['id'] = 'merk_add';
					$datamerk['class'] = 'form-control';
					$datamerk['placeholder'] = "Contoh : Toyota";
					echo form_input($datamerk);
				?>
			</td>
		</tr>	
		<tr>
			<th><?php echo form_label('Type','identitasno'); ?></th>
			<td>
				<?php 
					$datatype['name'] = $datatype['id'] = 'type_add';
					$datatype['class'] = 'form-control';
					$datatype['placeholder'] = "Contoh : Avanza";						
					echo form_input($datatype);
				?>
			</td>
		</tr>			
		
		<tr>
			<th><?php echo form_label('Series','email'); ?></th>
			<td>
				<?php 
					$dataseries['name'] = $dataseries['id'] = 'series_add';
					$dataseries['placeholder'] = "Contoh : Veloz";	
					$dataseries['class'] = 'form-control';					
					echo form_input($dataseries);
				?>
			</td>
		</tr>					
	<tr><td></td><td> <input id="submit-p" class="btn btn-info" type="submit" value="Tambah Kendaraan"></td></tr>		
	</table>
	<?php echo form_close(); ?>
    </div>
	
 <script src="<?php echo base_url(); ?>assets/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery-ui.min.js"></script>

 <script type="text/javascript">

	    $(this).ready( function() {
    		$("#kodemember").autocomplete({
      			minLength: 1,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>index.php/auto/get_member",
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
                   $("#memberID").val(ui.item.memberID);
					$("#memberCode").val(ui.item.memberCode);
					$("#trxFullName").val(ui.item.memberFullName);
					$("#memberAddress").val(ui.item.memberAddress);
					$("#memberPhone").val(ui.item.memberPhone);
        },		
    		});
	    });
	    </script>
		
		<script type="text/javascript">
		jQuery.noConflict();
	    $(this).ready( function() {
    		$("#merk_search").autocomplete({
      			minLength: 1,
      			source: 
        		function(req, add){
          			$.ajax({
		        		url: "<?php echo base_url(); ?>index.php/auto/get_vehicles",
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
                  $("#merkid").val(ui.item.id);
					$("#merk").val(ui.item.merk);
					$("#type").val(ui.item.type);
					$("#series").val(ui.item.series);
        },		
    		});
	    });
	    </script>

<script type="text/javascript">
        $(document).ready(function () {
            $("#OpenDialog").click(function () {
                $("#dialog").dialog({modal: true, height: 400, width: 1005,title: 'Tambah Data Customer', });
            });
        });
    </script>
	
	<script type="text/javascript">
        $(document).ready(function () {
            $("#OpenDialog2").click(function () {
                $("#dialog2").dialog({modal: true, height: 300, width: 1005,title: 'Tambah Data Kendaraan', });
            });
        });
    </script>
	
	<script>
    $(document).ready(function(){
        $("#klien_form").submit(function(e){
            e.preventDefault();
            var divisi = $("#divisi").val();;
            var nama= $("#nama").val();
			 var no_identitas= $("#no_identitas").val();
			  var npwp= $("#npwp").val();
			   var npwp1= $("#npwp1").val();
			    var npwp2= $("#npwp2").val();
				 var npwp3= $("#npwp3").val();
				  var npwp4= $("#npwp4").val();
				   var npwp5= $("#npwp5").val();
				    var alamat= $("#alamat").val();
				var telpon= $("#telpon").val();
				var email= $("#email").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>index.php/klien/insert',
                data: {divisi:divisi,nama:nama,no_identitas:no_identitas,npwp:npwp,npwp1:npwp1,npwp2:npwp2,npwp3:npwp3,npwp4:npwp4,npwp5:npwp5,alamat:alamat,telpon:telpon,email:email},
                success:function(data)
                {
					$('#dialog').dialog('close');
                    alert('Simpan Data Berhasil!!');
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
    $(document).ready(function(){
        $("#kendaraan_form").submit(function(e){
            e.preventDefault();
            var merk = $("#merk_add").val();;
            var type_mobil= $("#type_add").val();
				var series= $("#series_add").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>index.php/vehicles/insert',
                data: {merk:merk,type:type_mobil,series:series},
                success:function(data)
                {
					$('#dialog2').dialog('close');
                    alert('Simpan Data Kendaraan Berhasil!!');
                },
                error:function()
                {
                    alert('fail');
                }
            });
        });
    });
</script>

<script type="text/javascript">
jQuery.noConflict();
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



