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
										<input type="date" class="form-control" readonly id="tgl_pembelian" name="tgl_pembelian" value="<?php echo $data->trxDate; ?>">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Termin</label>
									<div class="col">
										<?php $termin_text = ( '2' == $data->trxbankmethod ) ? 'Credit' : 'Cash'; ?>
										<input type="text" name="termin" class="form-control" value="<?php echo $termin_text; ?>" readonly>
									</div>
								</div>
								<div id="termin_div">
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Supplier</label>
									<div class="col">
										<input type="text" name="supplier" value="<?php echo $data->trxFullName; ?>" class="form-control" readonly>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col">
								
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
										</tr>
									</thead>
									<tbody>
										<?php foreach( $detail as $k => $d ): ?>
										<tr>
											<td><?php echo $k+1; ?></td>
											<td><?php echo $d->detailBuyName; ?></td>
											<td><?php echo $d->detailBuyQty; ?></td>
											<td><?php echo number_format( $d->detailBuyPrice ); ?></td>
											<td><?php echo number_format( $d->residu ); ?></td>
											<td><?php echo $d->discPercent; ?></td>
											<td><?php echo $d->discPercent; ?></td>
											<td>PPN</td>
											<td><?php echo $d->detailBuySubtotal; ?></td>
											<td><?php echo $d->tgl_pakai; ?></td>
											<td><?php echo $d->keterangan; ?></td>
										</tr>
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
										<textarea class="form-control" id="keterangan" name="keterangan" rows="4" readonly=""><?php echo $data->note; ?></textarea>
									</div>
								</div>
							</div>
							<div class="col-md-2">&nbsp;</div>
							<div id="subtotaldiv" class="col-md-5">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Subtotal</label>
									<div class="col">
										<input type="text" name="subtotal" class="form-control" value="<?php echo number_format( $data->trxSubtotal ); ?>" readonly="">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Diskon</label>
									<div class="col">
										<input type="text" id="subtotal_diskon" name="diskon" class="form-control" value="<?php echo number_format( $data->trxDiscount ); ?>" readonly="">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Pajak</label>
									<div class="col">
										<input type="text" name="pajak" class="form-control" value="<?php echo number_format( $data->trxPPN ); ?>" readonly="">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Total</label>
									<div class="col">
										<input type="text" name="total" class="form-control" value="<?php echo number_format( $data->trxTotal ); ?>" readonly="">
									</div>
								</div>
							</div>
						</div>

						<div class="text-center">
							<a class="btn default" name="cancel" href="<?= base_url('harta/pembelian_harta') ?>"><i class="m-icon-swapleft"></i> Kembali</a> 
						</div>
					</div>
			</div>
		</div>
	</div>
</div>

<script>
	function termin_opt() {
		var idTermin = $('#termin').val();
		var myDiv = $('#termin_div');
		if (idTermin == 2) {
			myDiv.html("<div class='form-group row'><label class='col-sm-3 col-form-label'>Tanggal</label><div class='col'><input type='date' class='form-control' id='tgl_termin' name='tgl_termin'></div></div>")
		} else {
			myDiv.html("<div class='form-group row'><label class='col-sm-3 col-form-label'>Kas</label><div class='col'><select id='kas_id' name='kas_id' class='form-control' required><option selected disabled>Dari Kas ...</option><?php foreach ($all_kas as $row) : ?><option value='<?= $row->id ?>'><?= $row->nama ?></option><?php endforeach; ?></select></div></div>")
		}
	}
</script>