
<div class="post-body">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="mb-0 text-white">Pembelian Harta Tetap</h4>
			</div>
			<div class="card-body">
				<?php if ($tipe == 'add') : ?>
					<div class="container">
						<?= form_open('harta/form_insert_pembelian') ?>
						<div class="row">
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">No Pembelian</label>
									<div class="col">
										<input type="text" name="no_pembelian" readonly class="form-control text-uppercase" id="no_pembelian" value="auto">
									</div>
								</div>
			 
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Tgl. Beli</label>
									<div class="col">
										<input type="date" class="form-control" required id="tgl_pembelian" name="tgl_pembelian">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Akun Aset Tetap</label>
									<div class="col">
										<select class="form-control" name="aset_akun" required="">
								<?php foreach ($all_aset as $row) : ?>
									<option value="<?= $row->id ?>"><?= $row->nama . ' - ' . $row->kode ?></option>
								<?php endforeach; ?>
							</select>
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
									<label class="col-sm-3 col-form-label">Pajak</label>
									<div class="col bt-switch">
										<input type="hidden" name="pajak_apply" value="0">
										<input type="checkbox" name="pajak_apply" class="pajak_apply" value="1" data-size="normal" checked>
									</div>
								</div>
							</div>
						</div>
						
	 
						<div class="row">
							<div class="col">
								
								<button type="button" class="btn btn-success m-b-10" data-toggle="modal" data-target="#hartaTetapModal"><i class="fa fa-plus"></i> Tambah Detail</button>
								<input type="text" name="assets_data" id="assets_data_exist" style="width: 0; border:none;" value="" required="">

								<table id="table_harta_tetap" class="table table-bordered table-harta-tetap table-responsive" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Item</th>
											<th>Qty</th>
											<th>Harga</th>
											<th>N. Residu</th>
											<th>Disc %</th>
											<th>Diskon</th>
											<th>Pajak</th>
											<th>Subtotal</th>
											<th>Tgl. Pakai</th>
											<th>Keterangan</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<td colspan="12" class="notif-empty">Tidak ada data yang diinputkan</td>
									</tbody>
								</table>
			
		   
	 
					  
							
								   
																 
						 
																									   
			  
							</div>
						</div>

						<div class="row">
							<div class="col-md-5">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Keterangan</label>
									<div class="col">
										<textarea class="form-control" required id="keterangan" name="keterangan" rows="4"></textarea>
									</div>
								</div>
							</div>
							<div class="col-md-2">&nbsp;</div>
							<div id="subtotaldiv" class="col-md-5">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Subtotal</label>
									<div class="col">
										<input type="text" name="subtotal" class="form-control" value="0" readonly="">
									</div>
								</div>
			 
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Diskon</label>
									<div class="col">
										<input type="text" id="subtotal_diskon" name="diskon" class="form-control" value="0">
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

	 
						<div class="text-center">
							<a class="btn default" name="cancel" href="<?= base_url('harta/pembelian_harta') ?>"><i class="m-icon-swapleft"></i> Kembali</a> <button type="submit" class="btnsave btn btn-primary" name="save"><i class="fa fa-save"></i> Simpan</button>
						</div>
						<?= form_close() ?>
					</div>

		  
	
					<div id="hartaTetapModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="hartaTetapModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="harta_tetap_form">
	                                <div class="modal-header">
	                                    <h4 class="modal-title" id="myModalLabel">Harta Tetap</h4>
	                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                                </div>
	                                <div class="modal-body">
	                                    <div class="form-group row">
											<label class="col-sm-3 col-form-label">Kode</label>
											<div class="col">
												<input type="text" name="kode" class="form-control" value="auto" style="text-transform: uppercase;">
											</div>
										</div>
			   
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Nama</label>
											<div class="col">
												<input type="text" name="nama" class="form-control" required="">
											</div>
										</div>
			   
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Kelompok Asset Tetap</label>
											<div class="col">
												<select name="kelompok_asset" class="form-control" style="width:100%;" required="">
													<option selected disabled></option>
													<?php foreach ($kelompok_harta as $row) : ?>
														<option value="<?= $row->id ?>"><?= $row->nama_kelompok ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
			   
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Tanggal Pakai</label>
											<div class="col">
												<input type="date" name="tgl_pakai" class="form-control">
											</div>
										</div>
			   
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Umur Ekonomis</label>
											<div class="col">
												<input type="text" name="umur_ekonomis" class="form-control" placeholder="Tahun">
											</div>
										</div>
			   
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Lokasi</label>
											<div class="col">
												<select name="lokasi" class="form-control" style="width:100%;" required="">
													<option selected disabled></option>
													<?php foreach ($location as $row) : ?>
														<option value="<?= $row->identityID ?>"><?= $row->identityName ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
			   
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Keterangan</label>
											<div class="col">
												<textarea name="keterangan" rows="4" class="form-control"></textarea>
											</div>
										</div>
	                                </div>
			  
	                                <div class="modal-footer justify-content-center">
	                                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
	                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
	                                </div>
                            	</form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>

				<?php else : ?>
					<div class="container">
						<?= form_open("harta/form_edit/$id") ?>
						<div class="form-group row" style="margin-bottom: 10px;">
							<label class="col-sm-2 col-form-label">Kode</label>
							<div class="col">
								<input type="text" readonly class="form-control-plaintext" id="kode" name="kode" value="<?= $data_harta->kode ?>">
							</div>
						</div>
		   
						<div class="row">
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Nama Kelompok</label>
									<div class="col">
										<input type=" text" class="form-control<?= $tipe2 ?>" required <?= $read ?> value="<?= $data_harta->nama_kelompok ?>" id="nama_kelompok" name="nama_kelompok">
									</div>
								</div>
			 
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Umur Ekonomis</label>
									<div class="col">
										<input type="number" class="form-control<?= $tipe2 ?>" required <?= $read ?> value="<?= $data_harta->umur ?>" id="umur_ekonomis" name="umur_ekonomis">
									</div>
								</div>
			 
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Keterangan</label>
									<div class="col">
										<input type="text" class="form-control<?= $tipe2 ?>" required <?= $read ?> value="<?= $data_harta->keterangan ?>" id="keterangan" name="keterangan">
									</div>
								</div>
							</div>
			
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Metode Depresiasi</label>
									<div class="col">
										<select id="metode_depresiasi" name="metode_depresiasi" class="form-control<?= $tipe2 ?>" <?= $dis ?> <?= $read ?> required>
											<option selected value="<?= $data_harta->metode ?>"><?= $data_harta->metode ?></option>
											<option value="Metode Saldo Menurun">Metode Saldo Menurun </option>
											<option value="Metode Garis Lurus">Metode Garis Lurus</option>
										</select>
									</div>
								</div>
			 
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Akun
										<br> Harta</label>
									<div class="col">
										<select id="akun_harta" name="akun_harta" class="form-control<?= $tipe2 ?>" <?= $dis ?> <?= $read ?> required>
											<option selected value="<?= $akun_h->id ?>"><?= $akun_h->kode ?> - <?= $akun_h->nama ?></option>
											<?php foreach ($akun as $row) : ?>
												<option value="<?= $row->id ?>"><?= $row->kode ?> - <?= $row->nama ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
			 
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Akun Akumulasi</label>
									<div class="col">
										<select id="akun_akumulasi" name="akun_akumulasi" class="form-control<?= $tipe2 ?>" <?= $dis ?> <?= $read ?> required>
											<option selected value="<?= $akun_a->id ?>"><?= $akun_a->kode ?> - <?= $akun_a->nama ?></option>
											<?php foreach ($akun as $row) : ?>
												<option value="<?= $row->id ?>"><?= $row->kode ?> - <?= $row->nama ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
			 
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Akun Depresiasi</label>
									<div class="col">
										<select id="akun_depresiasi" name="akun_depresiasi" class="form-control<?= $tipe2 ?>" <?= $dis ?> <?= $read ?> required>
											<option selected value="<?= $akun_d->id ?>"><?= $akun_d->kode ?> - <?= $akun_d->nama ?></option>
											<?php foreach ($akun as $row) : ?>
												<option value="<?= $row->id ?>"><?= $row->kode ?> - <?= $row->nama ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
						</div>
		   
						<div class="text-center">
							<a class="btn default" name="cancel" href="<?= base_url('harta/kelompok_harta') ?>"><i class="m-icon-swapleft"></i> Kembali</a>
							<?php if ($tipe == 'edit') : ?>
								<button type="submit" class="btnsave btn btn-primary" name="save"><i class="fa fa-save"></i> Simpan</button>
							<?php endif; ?>
						</div>
						<?= form_close() ?>
					</div>
						
		  
				<?php endif; ?>
			</div>
		</div>
</div>

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

	$('#harta_tetap_form').on('submit', function(event){
		event.preventDefault();
		var data = $(this).serializeObject(),
			index = is_edit ? activeIndex : no - 1,
			$template = $('<tr class="tr-detail-'+ index +'" data-index="'+ index +'"><td>'+ (index + 1) +'</td><td><input type="hidden" name="detail['+ index +'][nama_item]" value="' + data.nama + '"> '+ data.nama +'</td>' +
						'<td><input type="hidden" name="detail['+ index +'][qty]" value="1">1</td>' + 
						'<td><input type="hidden" name="detail['+ index +'][harga]" value="0"> <span class="d-pop" data-field="harga">0</span></td>' +
						'<td><input type="hidden" name="detail['+ index +'][residu]" value="0"> <span class="d-pop" data-field="residu">0</span></td>' +
						'<td><input type="hidden" name="detail['+ index +'][discount_percentage]" value="0"> <span class="d-pop" data-field="discount">0</span></td>' +
						'<td><input type="hidden" name="detail['+ index +'][discount]" value="0"> <span data-field="discount">0</span></td>' +
						'<td><input type="hidden" name="detail['+ index +'][pajak]" value="0"> PPN</td>' +
						'<td><input type="hidden" name="detail['+ index +'][subtotal]" value="0"> <span data-field="subtotal">0</span></td>' +
						'<td><input type="hidden" name="detail['+ index +'][tgl_pakai]" value="'+data.tgl_pakai+'"> '+data.tgl_pakai+'</td>' +
						'<td><input type="hidden" name="detail['+ index +'][keterangan]" value="'+data.keterangan+'"> '+data.keterangan+'</td>' +
						'<td>' +
							'<input type="hidden" name="detail['+ index +'][lokasi]" value="'+data.lokasi+'">'+
							'<input type="hidden" name="detail['+ index +'][kode]" value="'+data.kode+'">'+
							'<input type="hidden" name="detail['+ index +'][umur_ekonomis]" value="'+data.umur_ekonomis+'">'+
							'<input type="hidden" name="detail['+ index +'][kelompok_asset]" value="'+data.kelompok_asset+'">'+
							'<a href="#" data-options="'+ index +'" data-toggle="tooltip" data-original-title="Edit" class="edit-detail-item--js"> <i class="fa fa-pencil text-inverse mr-2"></i> </a>' +
							'<a href="#" data-toggle="tooltip" data-original-title="Delete" class="delete-detail-item--js"> <i class="fa fa-window-close text-danger"></i> </a>' +
						'</td></tr>');

		$('body').trigger('show_dpop', [$template]);

		models[ index ] = data;
		console.log(data, 'data');
		if ( is_edit ) {
			$('#table_harta_tetap').find('.tr-detail-' + activeIndex).replaceWith( $template );
		} else {
			$('#table_harta_tetap').find('tbody').append( $template ).end().find('.notif-empty').hide();
			no = no + 1;
		}
		$('#hartaTetapModal').modal('hide');
		$('#assets_data_exist').val(1);
	});

	$('body').on('click', '.edit-detail-item--js', function( event ){
		event.preventDefault();
		is_edit = true;
		activeIndex = $(this).data('options');
		$editObj = $(this);

		$('#hartaTetapModal').modal('show');

	}).on('click', '.delete-detail-item--js', function( event ){
		event.preventDefault();
		$(this).closest('tr').remove();
	}).on('show_dpop', function(e, context){
		$('.d-pop', context).each(function(){
			var popover = $(this).popover({
				html: true,
				title: '<i class="fa fa-edit"></i> Edit <button class="close"><i class="fa fa-times"></i></button>',
				content: '<input type="text" class="form-control m-b-10 detail_text_update"><button class="btn btn-primary btn-submit-popup"><i class="fa fa-save"></i> Update</button>'
			}).on('shown.bs.popover', function (event) {
			    var $popup = $('#' + $(event.target).attr('aria-describedby')),
			    	currQty = popover.prev().val();
			    $popup.find('.detail_text_update').val(currQty)
			    .end().find('button.close').click(function (e) {
			        popover.popover('hide');
			    }).end().find('.btn-submit-popup').click(function (e) {
			        e.preventDefault();
			        var qty = $(this).prev('.detail_text_update').val();
			        popover.text(qty);
			        popover.popover('hide');
			        models[ popover.closest('tr').data('index') ][ popover.data('field') ] = qty;
			        $('body').trigger('detail_update', [ popover.closest('tr').data('index') ]);
			    });
			});
		});
	}).on('detail_update', function( e, index ){
		models[ index ]['discount'] = models[ index ]['discount'] || 0;
		models[ index ]['subtotal'] = models[ index ]['harga'] - ( models[ index ]['discount'] * models[ index ]['harga'] / 100 );
		$.each(models[ index ], function(k,v){
			$('.tr-detail-' + index).find('[data-field="'+ k +'"]').text(v).prev().val(v);
		});

		$('body').trigger('update_subtotaldiv');

	}).on('update_subtotaldiv', function(){
		submodels['subtotal'] = 0;
		$.each( models, function(k,v){
			submodels['subtotal'] += parseInt(v.subtotal);
		});
		if ( $('.pajak_apply').is(':checked') ) {
			submodels['pajak'] = submodels['subtotal'] * 0.1;
		} else {
			submodels['pajak'] = 0;
		}
		submodels['total'] = submodels['subtotal'] - submodels['diskon'] + submodels['pajak'];

		$.each( submodels, function(k,v){
			$('#subtotaldiv').find('input[name="'+k+'"]').val(v);
		});
	});


	$('#hartaTetapModal').on('show.bs.modal', function (event) {
		if ( is_edit ) {
			var modal = $(this),
				key = $editObj.data('options'),
				data = models[ key ];

			$.each(data, function(k,v){
				modal.find('[name="'+ k +'"]').val( v ).trigger('change');
			});
		}
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
			myDiv.html("<div class='form-group row'><label class='col-sm-3 col-form-label'>Akun Utang</label><br><div class='col'><select id='utang_id' name='utang_id' class='form-control' required><option value=''>Pilih Akun Utang ...</option><?php if(is_array($all_utang)){foreach ($all_utang as $row) : ?><option value='<?= $row->id ?>'><?= $row->nama ?></option><?php endforeach;} ?></select></div></div> <div class='form-group row'><label class='col-sm-3 col-form-label'>Jatuh Tempo</label><div class='col'><input type='date' class='form-control' id='tgl_termin' name='tgl_termin'></div></div>")
			} else {
			myDiv.html("<div class='form-group row'><label class='col-sm-3 col-form-label'>Kas</label><br><div class='col'><select id='kas_id' name='kas_id' class='form-control' required><option value=''>Dari Kas ...</option><?php if(is_array($all_kas)){foreach ($all_kas as $row) : ?><option value='<?= $row->id ?>'><?= $row->nama ?></option><?php endforeach;} ?></select></div></div>")
		}
	}
</script>