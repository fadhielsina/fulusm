<div class="post-body">
<?php echo form_open($form_action, array('id' => 'jurnal_form', 'onsubmit' => 'return cekData();')); ?>
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="mb-0 text-white">Pembelian Barang</h4>
			</div>
			<div class="card-body">
				<div class="container">
					<div class="row">
							<div class="col">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">No TTB</label>
								<div class="col">
									<input type="text" name="no_faktur" id="no_faktur" class="form-control text-uppercase" value="" required="" data-field="faktur">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Supplier</label>
								<div class="col">
									<select id="supplier" name="supplier" class="form-control" required>
										<option value="">Cari Supplier ...</option>
										<?php foreach ($supplier as $row) : ?>
											<option value="<?= $row->supplierID ?>"><?= $row->supplierName ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">No PO</label>
								<div class="col">
									<input type="text" name="no_po" id="no_po" class="form-control text-uppercase" value="" required="" data-field="po">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Tanggal</label>
								<div class="col">
									<input type="date" class="form-control" required id="tgl_pembelian" name="tgl_pembelian">
								</div>
							</div>
						</div>
						<div class="col">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Termin</label>
								<div class="col">
									<select id="termin" name="termin" class="form-control" onchange="termin_opt();" required>
										<option value="">Pilih Termin ...</option>
										<option value="1">Cash </option>
										<option value="2">Credit </option>
									</select>
								</div>
							</div>
							<div id="termin_div">
							</div>
							
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Keterangan</label>
								<div class="col">
									<textarea name="keterangan" class="form-control" rows="5"></textarea>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label>Input Item Barang</label>
								<input type="hidden" name="kdbarang" id="kdbarang" value="">
								<input type="text" name="item" id="kodebarang" class="form-control" value="" placeholder="Pilih item barang berdasarkan kode atau nama barang">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							
							<input type="text" name="assets_data" id="assets_data_exist" style="width: 0; border:none;" value="" >

							<table id="table_pembelian" class="table table-bordered table-pembelian">
								<thead>
									<tr>
										<th>Kode Barang</th>
										<th>Nama Barang</th>
										<th>Qty</th>
										<th>Harga</th>
										<th>Diskon</th>
										<th>Tot. Harga</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<td colspan="6" class="notif-empty">Tidak ada data yang diinputkan</td>
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
								<label class="col-sm-3 col-form-label">Subtotal</label>
								<div class="col">
									<input type="text" name="subtotal" class="form-control"  readonly="">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Pajak</label>
								<div class="col">
									<input type="text" name="pajak" class="form-control" value="0" readonly="">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Total</label>
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

<div id="pembelianModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="pembelianModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 650px;">
        <div class="modal-content">
            <form id="pembelian_form">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Item Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
						<label class="col-sm-3 col-form-label">Kode Barang</label>
						<div class="col">
							<input type="hidden" name="idbarang" value="">
							<input type="text" name="kode" class="form-control-plaintext text-uppercase" value="" required="" readonly="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Nama Barang</label>
						<div class="col">
							<input type="text" name="nama" class="form-control-plaintext" required="" readonly="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Qty 1</label>
						<div class="col-sm-6">
							<input type="text" name="qty" id="qty1"  class="form-control"  required="">
						</div>
						<div class="col-sm-3">
							<select name="satuan_1" id="satuan_1" class="form-control" style="width: 100%;">
								<?php foreach( $satuans as $sat ): ?>
								<option value="<?php echo $sat->satuanID; ?>"><?php echo $sat->satuanName; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Qty 2</label>
						<div class="col-sm-6">
							<input type="text" name="qty_2" id="qty2" class="form-control" >
						</div>
						<div class="col-sm-3">
							<select name="satuan_2" id="satuan_2" class="form-control" style="width: 100%;">
								<option value="">Pilih Satuan</option>
								<?php foreach( $satuans as $sat ): ?>
								<option value="<?php echo $sat->satuanID; ?>"><?php echo $sat->satuanName; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Harga</label>
						<div class="col">
							<input type="number" name="harga" id="harga1" class="form-control" required="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Diskon (Rp)</label>
						<div class="col">
							<input type="number" name="diskon"  id="diskon1"  class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">PPN (10%)</label>
						<div class="col">
							<div class="bt-switch">
								<input type="checkbox" name="ppn" class="pajak_apply" id="ispajak" value="10" data-size="normal">
							</div>
						</div>
					</div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <button type="submit" id="btn-submit-pemb" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                </div>
        	</form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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



   <form>
            <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bayar Hutang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Saldo</label>
                            <div class="col-md-10">
                              <input type="text" name="product_code_edit" id="product_code_edit" class="form-control" placeholder="Product Code" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Dibayar</label>
                            <div class="col-md-10">
                              <input type="text" name="price_edit" id="price_edit" class="form-control" placeholder="Price">
                            </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" type="submit" id="btn_update" class="btn btn-primary">Update</button>
                  </div>
                </div>
              </div>
            </div>
            </form>
			
<script>
	$.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    var no = 1,
    	models = [],
    	submodels = {subtotal: 0, diskon: 0, pajak:0, total: 0},
    	is_edit = false,
		$editObj,
    	activeIndex;

	$('#pembelian_form').on('submit', function(event){
		event.preventDefault();
		var vppn=0;
		if(document.getElementById('ispajak').checked) {
		vppn=10;
		} 
		var data = $(this).serializeObject(),
			index = is_edit ? activeIndex : no - 1,
			$template = $('<tr class="tr-detail-'+ index +'" data-index="'+ index +'"><td>'+ data.kode +'</td><td><input type="hidden" name="detail['+ index +'][idbarang]" value="' + data.idbarang + '"> '+ data.nama +'</td>' +
						'<td><input type="hidden" name="detail['+ index +'][qty]" value="'+ data.qty +'">'+ data.qty +'</td>' + 
						'<td><input type="hidden" name="detail['+ index +'][harga]" value="'+ data.harga +'">'+ commaSeparateNumber( data.harga ) +'</td>' +
						'<td><input type="hidden" name="detail['+ index +'][diskon]" value="'+ data.diskon +'">'+ commaSeparateNumber( data.diskon ) +'</td>' +
						'<td><input type="hidden" name="detail['+ index +'][totharga]" value="'+ data.qty*(data.harga-data.diskon ) +'">'+ commaSeparateNumber(Number((data.qty*(data.harga-data.diskon )) ).toFixed(2)) +'</td>' +
						'<td><input type="hidden" name="detail['+ index +'][ppn]" value="'+ data.ppn +'">'+ '</td>' +
						'<td><input type="hidden" name="detail['+ index +'][subtotal]" value="'+ data.qty*(data.harga-data.diskon )+((vppn/100)*(data.qty*(data.harga-data.diskon ))) +'">'+'</td>' +
						'<td>' +
							'<input type="hidden" name="detail['+ index +'][diskon]" value="'+data.diskon+'">'+
							'<input type="hidden" name="detail['+ index +'][ppn]" value="'+data.ppn+'">'+
							'<input type="hidden" name="detail['+ index +'][qty_2]" value="'+data.qty_2+'">'+
							'<input type="hidden" name="detail['+ index +'][satuan_1]" value="'+data.satuan_1+'">'+
							'<input type="hidden" name="detail['+ index +'][satuan_2]" value="'+data.satuan_2+'">'+
							'<a href="#" data-options="'+ index +'" data-toggle="tooltip" data-original-title="Edit" class="edit-detail-item--js"> <i class="fa fa-pencil text-inverse mr-2"></i> </a>' +
							'<a href="#" data-toggle="tooltip" data-original-title="Delete" class="delete-detail-item--js"> <i class="fa fa-window-close text-danger"></i> </a>' +
						'</td></tr>');

		models[ index ] = data;
		console.log(data, 'data');
		if ( is_edit ) {
			$('#table_pembelian').find('.tr-detail-' + activeIndex).replaceWith( $template );
		} else {
			$('#table_pembelian').find('tbody').append( $template ).end().find('.notif-empty').hide();
			no = no + 1;
		}
		
	
		$('#pembelianModal').modal('hide');
		$('#assets_data_exist').val(1);
		
		$('body').trigger('detail_update', [index]);
		$('#pembelian_form').trigger("reset");
	});

	$('body').on('click', '.edit-detail-item--js', function( event ){
		event.preventDefault();
		is_edit = true;
		activeIndex = $(this).data('options');
		$editObj = $(this);

		$('#pembelianModal').modal('show');

	}).on('click', '.delete-detail-item--js', function( event ){
		event.preventDefault();
		$(this).closest('tr').remove();
	}).on('detail_update', function( e, index ){
		models[ index ]['diskon'] = Number(models[ index ]['diskon']);
		if(document.getElementById('ispajak').checked) {
		models[ index ]['ppn'] = Number(( models[ index ]['ppn'] ) / 100 * ( ( models[ index ]['harga'] - models[ index ]['diskon'] ) * models[ index ]['qty'] ));
		} else 
		{
			models[ index ]['ppn'] =0;
		}
		models[ index ]['subtotal2'] =  Number( ( models[ index ]['harga'] - models[ index ]['diskon'] ) * models[ index ]['qty'] ).toFixed(2) ;
		$.each(models[ index ], function(k,v){
			$('.tr-detail-' + index).find('[data-field="'+ k +'"]').text(v).prev().val(v);
		});

		$('body').trigger('update_subtotaldiv');

	}).on('update_subtotaldiv', function(){
		submodels['subtotal'] = 0;
		submodels['pajak'] = 0;
		$.each( models, function(k,v){
			submodels['subtotal'] += Number(v.subtotal2);
		});
		
		$.each( models, function(k,v){
			submodels['pajak'] += ( Number(v.ppn) );
		});

		$.each( models, function(k,v){
			submodels['diskon'] += ( Number(v.diskon) );
		});

		submodels['total'] = Number(submodels['subtotal'] + submodels['pajak']).toFixed(2);

		$.each( submodels, function(k,v){
			$('#subtotaldiv').find('input[name="'+k+'"]').val(commaSeparateNumber(v));
		});
		
		$('#debit1, #kredit2').val(Math.round(submodels['total']));
	});


	$('#pembelianModal').on('show.bs.modal', function (event) {
		var label = '<i class="fa fa-plus"></i> Tambah';
		if ( is_edit ) {
			var modal = $(this),
				key = $editObj.data('options'),
				data = models[ key ];

			$.each(data, function(k,v){
				modal.find('[name="'+ k +'"]').val( v ).trigger('change');
			});
			label = '<i class="fa fa-edit"></i> Simpan';
		}
		$('#btn-submit-pemb').html(label);
	}).on('hidden.bs.modal', function( event ){
		is_edit = false;
	});
	var timeout;
	$('#subtotal_diskon').on('keyup', function(){
		var $this = $(this);
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			submodels['diskon'] = $this.val();
			$('body').trigger('update_subtotaldiv');
		}, 600);
	});
	function termin_opt() {
		var idTermin = $('#termin').val();
		var myDiv = $('#termin_div');
		if (idTermin == 2) {
			myDiv.html("<div class='form-group row'><label class='col-sm-3 col-form-label'>Jatuh Tempo</label><div class='col'><input type='text' class='form-control'  name='tgl_termin'></div></div>")
		} else {
			//myDiv.html("<div class='form-group row'><label class='col-sm-3 col-form-label'>Kas</label><div class='col'><select id='kas_id' name='kas_id' class='form-control' required><option value=''>Dari Kas ...</option><?php foreach ($all_kas as $row) : ?><option value='<?= $row->id ?>'><?= $row->nama ?></option><?php endforeach; ?></select></div></div>")
		}
	}

	$("#kodebarang").autocomplete({    
        minLength:0,
        delay:0,
        source:'<?php echo site_url('auto/get_barang'); ?>',   
        select:function(event, ui){
          if ( $('#pembelianModal').length ) {
            $('#pembelianModal').modal('show');
            $('#pembelian_form').trigger('reset');
            $('#pembelianModal').find('[name="kode"]').val( ui.item.barangBarcode ).trigger('change').end()
            .find('[name="nama"]').val( ui.item.nama ).trigger('change').end()
            .find('[name="idbarang"]').val( ui.item.idbarang ).trigger('change').end()
            .find('#satuan_1').val(ui.item.satuanID).trigger('change').end()
			 .find('#satuan_2').val(ui.item.satuanID2).trigger('change');
			
          }
        },
        change: function(){
        	$('#kodebarang').val('');
        }
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
	$('#no_faktur, #no_po').on('keyup', function(){
		var $this = $(this),
			field = $this.data('field');
		clearTimeout(timeout);
		timeout = setTimeout(function(){
			$.ajax({
				method: 'POST',
				url: '<?php echo site_url('auto/check_faktur_pemb'); ?>',
				data: { type: field, kode: $this.val() },
				dataType: 'json'
			}).done(function(resp){
				var color = resp.success ? 'red' : '';
				$this.css({borderColor: color });
				$('#alert_container').html( resp.data );
			});
		}, 600);
	});
</script>