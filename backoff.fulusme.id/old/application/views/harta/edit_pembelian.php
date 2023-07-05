<br />
<div class="post-title col-lg-12">
	<h3 class="pull-left"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>
</div>

<div class="post-body">
	<br /><br />
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="mb-0 text-white">Pembelian Harta Tetap</h4>
			</div>
			<div class="card-body">
				<div class="container">
					<?= form_open('harta/form_edit_pembelian') ?>
					<div class="row">
						<div class="col">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">No Pembelian</label>
								<div class="col">
									<input type="text" name="no_pembelian" readonly class="form-control text-uppercase" id="no_pembelian" value="<?php echo $data->invoiceBuyID; ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Tanggal</label>
								<div class="col">
									<input type="date" class="form-control" required id="tgl_pembelian" name="tgl_pembelian" value="<?php echo $data->trxDate; ?>">
								</div>
							</div>
						</div>
						<div class="col">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Termin</label>
								<div class="col">
									<select id="termin" name="termin" class="form-control" onchange="termin_opt();" required>
										<option disabled>Pilih Termin ...</option>
										<?php
										$terms = array ( '1' => 'Cash', '2' => 'Credit' ); 
										foreach( $terms as $k => $t ):
										?>
										<option value="<?php echo $k; ?>" <?php echo $k == $data->trxbankmethod ? 'selected' : ''; ?>><?php echo $t; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div id="termin_div">
								<?php if( '2' == $data->trxbankmethod ): ?>
								<div class='form-group row'>
									<label class='col-sm-3 col-form-label'>Jatuh Tempo</label>
									<div class='col'><input type='date' class='form-control' id='tgl_termin' name='tgl_termin' value="<?php echo $data->trxTerminDate; ?>"></div>
								</div>
								<?php endif; ?>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Supplier</label>
								<div class="col">
									<select id="supplier" name="supplier" class="form-control" required>
										<option selected disabled>Cari Supplier ...</option>
										<?php foreach ($supplier as $row) : ?>
											<option value="<?= $row->supplierID ?>" <?php echo $row->supplierID == $data->supplierID ? 'selected' : ''; ?>><?= $row->supplierName ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col">
							
							<button type="button" class="btn btn-success m-b-10" data-toggle="modal" data-target="#hartaTetapModal"><i class="fa fa-plus"></i> Tambah Detail</button>

							<table id="table_harta_tetap" class="table table-bordered table-harta-tetap table-responsive">
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
									<?php 
									$models = array();
									foreach( $detail as $k => $d ):
										$models[] = array(
											'kode' => $d->detailBuyCode,
											'qty' => 1,
											'nama' => $d->detailBuyName,
											'harga' => $d->detailBuyPrice,
											'residu' => $d->residu,
											'discount_percentage' => $d->discPercent,
											'discount' => $d->discPercent,
											'pajak' => $d->trxPPN,
											'subtotal' => $d->detailBuySubtotal,
											'tgl_pakai' => $d->tgl_pakai,
											'keterangan' => $d->keterangan,
											'lokasi' => $d->identityID,
											'umur_ekonomis' => $d->umur_ekonomis,
											'kelompok_asset' => $d->kelompokHartaID
										);
									?>
									<tr class="tr-detail-<?php echo $k; ?>" data-index="<?php echo $k; ?>"><td><?php echo $k+1; ?></td><td><input type="hidden" name="detail[<?php echo $k; ?>][nama_item]" value="<?php echo $d->detailBuyName; ?>"><?php echo $d->detailBuyName; ?></td>
									<td><input type="hidden" name="detail[<?php echo $k; ?>][qty]" value="<?php echo $d->detailBuyQty; ?>"></td>
									<td><input type="hidden" name="detail[<?php echo $k; ?>][harga]" value="<?php echo $d->detailBuyPrice; ?>"> <span class="d-pop" data-field="harga"><?php echo $d->detailBuyPrice; ?></span></td>
									<td><input type="hidden" name="detail[<?php echo $k; ?>][residu]" value="<?php echo $d->residu; ?>"> <span class="d-pop" data-field="residu"><?php echo $d->residu; ?></span></td>
									<td><input type="hidden" name="detail[<?php echo $k; ?>][discount_percentage]" value="<?php echo $d->discPercent; ?>"> <span class="d-pop" data-field="discount"><?php echo $d->discPercent; ?></span></td>
									<td><input type="hidden" name="detail[<?php echo $k; ?>][discount]" value="<?php echo $d->discPercent; ?>"> <span data-field="discount"><?php echo $d->discPercent; ?></span></td>
									<td><input type="hidden" name="detail[<?php echo $k; ?>][pajak]" value="<?php echo $d->trxPPN; ?>"> PPN</td>
									<td><input type="hidden" name="detail[<?php echo $k; ?>][subtotal]" value="<?php echo $d->detailBuySubtotal; ?>"> <span data-field="subtotal"><?php echo $d->detailBuySubtotal; ?></span></td>
									<td><input type="hidden" name="detail[<?php echo $k; ?>][tgl_pakai]" value="<?php echo $d->tgl_pakai; ?>"><?php echo $d->tgl_pakai; ?></td>
									<td><input type="hidden" name="detail[<?php echo $k; ?>][keterangan]" value="<?php echo $d->keterangan; ?>"><?php echo $d->keterangan; ?></td>
									<td>
										<input type="hidden" name="detail[<?php echo $k; ?>][lokasi]" value="<?php echo $d->identityID; ?>">
										<input type="hidden" name="detail[<?php echo $k; ?>][kode]" value="<?php echo $d->detailBuyCode; ?>">
										<input type="hidden" name="detail[<?php echo $k; ?>][umur_ekonomis]" value="<?php echo $d->umur_ekonomis; ?>">
										<input type="hidden" name="detail[<?php echo $k; ?>][kelompok_asset]" value="<?php echo $d->kelompokHartaID; ?>">
										<a href="#" data-options="<?php echo $k; ?>" data-toggle="tooltip" data-original-title="Edit" class="edit-detail-item--js"> <i class="fa fa-pencil text-inverse mr-2"></i> </a>
										<a href="#" data-toggle="tooltip" data-original-title="Delete" class="delete-detail-item--js"> <i class="fa fa-window-close text-danger"></i> </a>
									</td></tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="row">
						<div class="col-md-5">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Keterangan</label>
								<div class="col">
									<textarea class="form-control" required id="keterangan" name="keterangan" rows="4"><?php echo $data->note; ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-2">&nbsp;</div>
						<div id="subtotaldiv" class="col-md-5">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Subtotal</label>
								<div class="col">
									<input type="text" name="subtotal" class="form-control" value="<?php echo $data->trxSubtotal; ?>" readonly="">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Diskon</label>
								<div class="col">
									<input type="text" id="subtotal_diskon" name="diskon" class="form-control" value="<?php echo $data->trxDiscount; ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Pajak</label>
								<div class="col">
									<input type="text" name="pajak" class="form-control" value="<?php echo $data->trxPPN; ?>" readonly="">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Total</label>
								<div class="col">
									<input type="text" name="total" class="form-control" value="<?php echo $data->trxTotal; ?>" readonly="">
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
												<option disabled></option>
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
												<option disabled></option>
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
			</div>
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

    var no = <?php echo count( $models ) + 1; ?>,
    	models = <?php echo json_encode( $models ); ?>,
    	submodels = {subtotal: 0, diskon: 0, pajak:0, total: 0},
    	is_edit = false,
		$editObj,
    	activeIndex;

	$('#harta_tetap_form').on('submit', function(event){
		event.preventDefault();
		var data = $(this).serializeObject(),
			index = is_edit ? activeIndex : no - 1,
			$template = $('<tr class="tr-detail-'+ index +'" data-index="'+ index +'"><td>'+ (index + 1) +'</td><td><input type="hidden" name="detail['+ index +'][nama_item]" value="' + data.nama + '"> '+ data.nama +'</td>' +
						'<td><input type="hidden" name="detail['+ index +'][qty]" value="1"></td>' + 
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
		submodels['total'] = submodels['subtotal'] - submodels['diskon'] - submodels['pajak'];

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
			myDiv.html("<div class='form-group row'><label class='col-sm-3 col-form-label'>Tanggal</label><div class='col'><input type='date' class='form-control' id='tgl_termin' name='tgl_termin'></div></div>")
		} else {
			myDiv.html("<div class='form-group row'><label class='col-sm-3 col-form-label'>Kas</label><div class='col'><select id='kas_id' name='kas_id' class='form-control' required><option selected disabled>Dari Kas ...</option><?php foreach ($all_kas as $row) : ?><option value='<?= $row->id ?>'><?= $row->nama ?></option><?php endforeach; ?></select></div></div>")
		}
	}

	$(document).ready(function(){
		$('body').trigger('show_dpop', [$('#table_harta_tetap')]);
	});

</script>