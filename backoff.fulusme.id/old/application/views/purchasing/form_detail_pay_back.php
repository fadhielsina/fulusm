<div class="post-body">
	<?= form_open( $form_action ) ?>
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="mb-0 text-white">Pembayaran Hutang</h4>
			</div>
			<div class="card-body">
				<div class="container">
					<div class="row">
							<div class="col">
							<label class="col-md-4 col-form-label">Supplier</label>
									<input type="text" name="no_po" class="form-control text-uppercase" value="<?php echo $supplier; ?>" disabled >
									<input type="hidden" name="supplierID" id="supplierID" class="form-control text-uppercase" value="<?php echo $supplierID; ?>" >
								</div>
								
								
								<div class="col">
								<label class="col-lg-6 col-form-label">No Bukti Pembayaran</label>
									<input type="text" name="no_po" class="form-control text-uppercase" readonly " placeholder="otomatis oleh sistem..">
								</div>
								<div class="col">
								<label class="col-lg-6 col-form-label">Riwayat Pembayaran</label><br/>
									<a id="btn_lihat_bayar" class="btn btn-success btn-block" data="<?php echo $supplierID; ?>">Lihat Riwayat Pembayaran</a>
								</div>
					</div>
			
					
					<div class="row">
						<div class="col">
							
							<input type="text" name="assets_data" id="assets_data_exist" style="width: 0; border:none;" value="" required="">

							<table id="mydata" class="table table-bordered table-pembelian">
								<thead>
									<tr>
										<th>NO TTB / Faktur</th>
										<th>Keterangan</th>
										<th>Saldo</th>
										<th>Tot. Pembayaran</th>
										<th>Sisa Bayar</th>
									</tr>
								</thead>
								 <tbody id="show_data">
                 
								</tbody>
							</table>
						</div>
					</div>

					<div class="row">
						<div class="col-md-5">
						</div>
						<div class="col-md-2">&nbsp;</div>
						<div id="subtotaldiv" class="col-md-5">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Dibayar : </label>
								<div class="col">
									<input type="text" name="total" class="form-control" value="0" readonly="">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="mb-0 text-white">Jurnal Pembelian</h4>
			</div>
			<div class="card-body">
				<table id="tblDetail" name="tblDetail" class="table">
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
									$data['type'] = 'number';
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
									$data['type'] = 'text';
									echo form_input($data);
								?>
							</td>
						</tr>
					<?php } ?>
				</table>
				<br/>
				<div class="pull-right">
					<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#jur-template-modal">Load Template</button>
					<a href="javascript:addRow();" class="btn btn-primary btn-sm"><span style="color:#fff;"><?= $this->lang->line('tambah_baris') ?></span></a>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="text-center">
					<a class="btn  btn-danger" name="cancel" href="<?= base_url('pembelian') ?>"><i class="m-icon-swapleft"></i> Batal</a> 
					<button type="submit" class="btnsave btn  btn-success" name="save"><i class="fa fa-save"></i> Simpan Transaksi</button>
				</div>
			</div>
		</div>
	</div>

	<?= form_close() ?>

</div>


<div class="modal fade" id="jur-template-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Jurnal Template</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            	<div class="form-group">
            		<label>Select Template: </label>
            		<select id="find-template-select" class="form-control" style="width: 100%;">
            			<?php foreach( $template as $temp ): ?>
            			<option value="<?php echo htmlspecialchars($temp->akun_data); ?>"><?php echo $temp->nama_template; ?></option>
            			<?php endforeach; ?>	
            		</select>
            	</div>
            	<div class="form-group">
            		<button type="button" id="find-template-submit" class="btn btn-primary btn-block">Pasang</button>
            	</div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div style="display:none;">
	<?php $akun['id'] = 'akun_template';
		$akun['class'] = 'form-control';
		echo form_dropdown('akun[]', $accounts, '' ,$akun); 
	?>
</div>

<div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Bayar</h3>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
 
					<input name="debtID" id="debtID" class="form-control" type="hidden" style="width:335px;" readonly>
					 <div class="form-group">
                        <label class="control-label col-xs-3" >NO TTB / Faktur</label>
                        <div class="col-xs-9">
                            <input name="ttb" id="ttb" class="form-control" type="text" style="width:335px;" readonly>
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label class="control-label col-xs-3" >Saldo</label>
                        <div class="col-xs-9">
                            <input name="saldo" id="saldo" class="form-control" type="text"  style="width:335px;" disabled>
                        </div>
                    </div>
 
 
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Total Bayar</label>
                        <div class="col-xs-9">
                            <input name="totalbyr" id="totalbyr" class="form-control" type="text" style="width:335px;" disabled>
                        </div>
                    </div>
					
					
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Sisa Bayar</label>
                        <div class="col-xs-9">
                            <input name="sisa" id="sisa" class="form-control" type="text" style="width:335px;" disabled>
                        </div>
                    </div>
					<hr/>
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Dibayar</label>
                        <div class="col-xs-9">
                            <input name="dibayar" id="dibayar" class="form-control" type="text"  style="width:335px;" onkeyup="formatNumber(this);" onchange="formatNumber(this);">
                        </div>
                    </div>
 
                </div>
 
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_simpan">Bayar</button>
                </div>
            </form>
            </div>
            </div>
        </div>
		
		
		<div class="modal fade" id="Modallihatbyr" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
           <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Riwayat Pembayaran</h3>
            </div>
            <div class="modal-body">
							
							<input type="text" name="assets_data" id="assets_data_exist" style="width: 0; border:none;" value="" required="">

							<table id="mydata2" class="table table-bordered table-pembelian">
								<thead>
									<tr>
										<th>NO TTB / Faktur</th>
										<th>Tanggal Bayar</th>
										<th>Jumlah Bayar</th>
									</tr>
								</thead>
								 <tbody id="show_data_bayar">
                 
								</tbody>
							</table>
						
					</div>
            </div>
            </div>
        </div>
		
<script type="text/javascript">
    $(document).ready(function(){
		
        tampil_data_barang();   //pemanggilan fungsi tampil barang.
         
        $('#mydata').dataTable();
		$('#mydata2').dataTable();
          
        //fungsi tampil barang
        function tampil_data_barang(){
			var supplierID=$('#supplierID').val();
            $.ajax({
				type : "POST",
                url   : '<?php echo site_url('auto/ajax_get_vendor') ?>',
				data : {supplierID:supplierID},
                async : true,
                dataType : 'json',
                success : function(data){
                    var html = '';
                    var i;
					 var totalsum=0;
					  var totalbyr=0;
					   var totalsisa=0;
                    for(i=0; i<data.length; i++){
						totalsum+=parseInt(data[i].trxTotal);
						totalbyr+=parseInt(data[i].totalbyr);
						totalsisa+=parseInt(data[i].trxTotal - data[i].totalbyr);
                        html += '<tr>'+
                                '<td>'+data[i].no_dokumen+'</td>'+
                                '<td>'+data[i].note+'</td>'+
                                '<td>'+formatRupiah(data[i].trxTotal)+'</td>'+
								'<td>'+formatRupiah(data[i].totalbyr)+'</td>'+
								'<td>'+numberWithCommas(data[i].trxTotal - data[i].totalbyr)+'</td>'+
                                '<td style="text-align:right;">'+
                                    '<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="'+data[i].trxID+'">Bayar</a>'+' '+
                                '</td>'+
                                '</tr>';
                    }
					 html += '<tr><td></td><td><b>TOTAL</b></td><td><b>'+numberWithCommas(totalsum)+'</b></td><td><b>'+numberWithCommas(totalbyr)+'</b></td><td><b>'+numberWithCommas(totalsisa)+'</b></td></tr>';
                    $('#show_data').html(html);
                }
 
            });
        }
 
        //GET UPDATE
        $('#show_data').on('click','.item_edit',function(){
            var id=$(this).attr('data');
            $.ajax({
               	type : "GET",
                url   : '<?php echo site_url('auto/ajax_get_vendor_id') ?>',
                dataType : "JSON",
                data : {id:id},
                success: function(data){
                    $.each(data,function( note, trxTotal){
                        $('#ModalaEdit').modal('show');
						var a=parseInt(data.trxTotal);
						var b=parseInt(data.totalbyr);
						var c=a-b;
                        $('[name="ttb"]').val(data.note);
                        $('[name="saldo"]').val(formatRupiah(data.trxTotal));
						$('[name="totalbyr"]').val(formatRupiah(data.totalbyr));
						$('[name="sisa"]').val(numberWithCommas(c));
						$('[name="dibayar"]').val(numberWithCommas(c));
						$('[name="debtID"]').val(data.debtID);
                    });
                }
            });
            return false;
        });
 
 
         function tampil_riwayat_bayar(){
			var supplierID=$('#supplierID').val();
            $.ajax({
				type : "POST",
                url   : '<?php echo site_url('auto/ajax_get_debt_pay') ?>',
				data : {supplierID:supplierID},
                async : true,
                dataType : 'json',
                success : function(data){
                    var html = '';
                    var i;
					  var totalbyr=0;
                    for(i=0; i<data.length; i++){
						totalbyr+=parseInt(data[i].debtPay);
                        html += '<tr>'+
                                '<td>'+data[i].note+'</td>'+
                                '<td>'+data[i].debtDate+'</td>'+
                                '<td>'+formatRupiah(data[i].debtPay)+'</td>'+
                                '</tr>';
                    }
					 html += '<tr><td></td><td><b>TOTAL</b></td><td><b>'+numberWithCommas(totalbyr)+'</b></td></tr>';
                    $('#show_data_bayar').html(html);
                }
 
            });
        }
		
         $('#btn_lihat_bayar').on('click',function(){
            tampil_riwayat_bayar(); 
            $('#Modallihatbyr').modal('show');
        });
 
        //Simpan Barang
        $('#btn_simpan').on('click',function(){
            var debtID=$('#debtID').val();
            var dibayar=$('#dibayar').val();
			var dibayarint=parseInt($('#dibayar').val().split(",").join(""));
			var total=parseInt($('[name="total"]').val());
            $.ajax({
                type : "POST",
                 url   : '<?php echo site_url('purchasing/simpan_termin_pay') ?>',
                dataType : "JSON",
                data : {debtID:debtID , dibayar:dibayar},
                success: function(data){
					 $('[name="debtID"]').val("");
                    $('[name="dibayar"]').val("");
					 $('#ModalaEdit').modal('hide');
                    tampil_data_barang();
					 total+=parseInt(dibayarint);
					  $('[name="total"]').val(total);
					  $('#debit1, #kredit2').val(total);;
                }
            });
            return false;
        });
 
        //Update Barang
        $('#btn_update').on('click',function(){
            var kobar=$('#kode_barang2').val();
            var nabar=$('#nama_barang2').val();
            var harga=$('#harga2').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('index.php/barang/update_barang')?>",
                dataType : "JSON",
                data : {kobar:kobar , nabar:nabar, harga:harga},
                success: function(data){
                    $('[name="kobar_edit"]').val("");
                    $('[name="nabar_edit"]').val("");
                    $('[name="harga_edit"]').val("");
                    $('#ModalaEdit').modal('hide');
                    tampil_data_barang();
                }
            });
            return false;
        });
 
        //Hapus Barang
        $('#btn_hapus').on('click',function(){
            var kode=$('#textkode').val();
            $.ajax({
            type : "POST",
            url  : "<?php echo base_url('index.php/barang/hapus_barang')?>",
            dataType : "JSON",
                    data : {kode: kode},
                    success: function(data){
                            $('#ModalHapus').modal('hide');
                            tampil_data_barang();
                    }
                });
                return false;
            });
 
    });
	
	
	$('#find-template-submit').on('click', function(event){
		event.preventDefault();
		var data = $('#find-template-select').val(),
			tbl = $('#tblDetail');
		if ( data ) data = $.parseJSON(data);

		if ( data ) {
			tbl.find('tr').eq(0).nextAll().remove();
			$.each(data, function(k, v){
				var lastRow = k + 1;
				var ddlAkun = '<select name="akun[]" id="akun'+lastRow+'" class="form-control form-control-line" >';
					ddlAkun += $("#akun_template").html();
					ddlAkun += '</select>',
					valDebit = v.debit_kredit == '1' ? submodels['total'] : '',
					valKredit = v.debit_kredit == '1' ? '' : submodels['total'];
					
					var txtDebit = '<input name="debit'+lastRow+'" id="debit'+lastRow+'" class="form-control form-control-line" title="Debit harus diisi dengan angka" onBlur="cekDebit('+lastRow+');" value="'+valDebit+'" />';
					var txtKredit = '<input name="kredit'+lastRow+'" id="kredit'+lastRow+'" class="form-control form-control-line" title="Kredit harus diisi dengan angka" onBlur="cekKredit('+lastRow+');" value="'+valKredit+'" />';
					var txtKeterangan = '<input name="keterangan'+lastRow+'" id="keterangan'+lastRow+'" class="form-control form-control-line" title="Keterangan akun" />';
					tbl.children().append("<tr><td>"+ddlAkun+"</td><td>"+txtDebit+"</td><td>"+txtKredit+"</td><td>"+txtKeterangan+"</td></tr>");
					tbl.find('#akun'+lastRow).val(v.akun_id).trigger('change');
					//$("#debit"+lastRow).rules("add", "integer");
					//$("#kredit"+lastRow).rules("add", "integer");
					//$("#keterangan"+lastRow).rules("add", "integer");
			});
			reload_select();
			$('#jur-template-modal').modal('hide');	
		}

		console.log(typeof data, data, 'data');
	});
 
</script>

<script>
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
		
			if(ribuan){
				separator = sisa ? ',' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
		}
		
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