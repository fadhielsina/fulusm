
<script type="text/javascript" src="<?php echo base_url();?>js/group_table.js"></script>
	<br/>

<div class="post-body">

<?php
	if($this->session->userdata('SUCCESSMSG'))
	{
		echo "<div class='alert alert-success'>".$this->session->userdata('SUCCESSMSG')."</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
?>

	<div class="card">
	
  <div class="card-body">
    <div class="pull-right">
		<?php 
			echo form_button(array('id' => 'button-addnew','class' => 'btn btn-xs waves-effect waves-light btn-success',  'content' => 'Kembali', 'onClick' => "location.href='".site_url()."penjualan/buku_penj'" ));
		?>		
	</div>
  <h4 class="card-title"><?= $this->lang->line('detail_data') ?></h4>
  <div class="table-responsive">
<table class="table" id="display_table_pembelian">
		<thead>
			<tr>
				<th>No SJ</th>
				<th>No INVOICE</th>
				<th>Customer</th>
				<th>Nama Barang</th>
				<th>Harga</th>
				<th>QTY 1</th>
				<th>QTY 2</th>
				<th>Diskon</th>
				
				<th>PPN</th>
				<th>Sub Total</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if($account_data)
				{
					$i = 0;
					$total=0;
					foreach ($account_data as $row)
					{
						echo '<tr>';
						echo '<td>'.$row->trxFakturID.'</td>';
						echo '<td>'.$row->trxPOID.'</td>';
						echo '<td>'.$row->memberFullName.'</td>';
						echo '<td>'.$row->barangName.'</td>';
						echo '<td>'.number_format($row->detailPrice).'</td>';
						echo '<td>'.$row->detailQty.' ('.$row->sat1.') </td>';
						echo '<td>'.$row->detailQty2.' ('.$row->sat2.') </td>';
						echo '<td>'.number_format($row->discPercent).'</td>';
						$sub1=$row->detailSubtotal-$row->discPercent;
						echo '<td>'.number_format($row->trxPPN).'</td>';
						$sub2=$sub1;
						echo '<td>'.number_format( $sub2 ).'</td>';
						echo '</tr>';
						$total=$total+$sub2;
						$i++;
					}
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8"></td><td>TOTAL</td><td><b><?php echo number_format($total); ?></b></td>
			</tr>
		</tfoot>
	</table>
	</div>
</div>
</div>
	
	<?php echo form_open($form_edit_jurnal, array('id' => 'jurnal_form', 'onsubmit' => 'return cekData();')); ?>
	<div id="edit-jurnal-toggle" class="card card-outline-info d-none">
		<input type="hidden" name="identity_id" value="<?php echo $data_jurnal[0]->identityID; ?>">
		<input type="hidden" name="jurnal_id" value="<?php echo $data_jurnal[0]->jurnal_id; ?>">
		<input type="hidden" name="redirect_url" value="<?php echo $redirect_url; ?>">
		<div class="card-header">
			<h4 class="mb-0 text-white">Edit Jurnal</h4>
		</div>
		<div class="card-body">
			<table id="tblDetail" name="tblDetail" class="table">
				<tr>
					<th><?= $this->lang->line('akun') ?></th>
					<th><?= $this->lang->line('debit') ?></th>
					<th><?= $this->lang->line('kredit') ?></th>	
					<th><?= $this->lang->line('keterangan') ?></th>
					<th></th>		
				</tr>
				<?php foreach( $data_jurnal as $key => $jur ):
					$i = $key + 1; 
					$nilai_debit = 0;
					$nilai_kredit = 0;
					if ( $jur->debit_kredit ) {
						$nilai_debit = $jur->nilai;
					} else {
						$nilai_kredit = $jur->nilai;
					}
					?>
					<tr>
						<td>
							<?php 
								$akun['id'] = 'akun'.$i;
								$akun['class'] = 'form-control';
								echo form_dropdown('akun[]', $accounts, $jur->akun_id ,$akun);
								echo '<input type="hidden" name="jurnal_det_id'. $i .'" value="'. $jur->id.'">';
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
								$data['value'] = $nilai_debit;
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
								$data['value'] = $nilai_kredit;
								echo form_input($data);
							?>
						</td>
						<td>
							<?php 
								$data['id'] = 'keterangan'.$i;
								$data['class'] = 'form-control';
								$data['name'] = 'keterangan'.$i;
								$data['type'] = 'text';
								$data['value'] = $jur->keterangan;
								echo form_input($data);
							?>
						</td>
						<td>
							<?php if( $i > 2 ): ?>
							<button type="button" class="btn btn-danger btn-delete-akun-jur"><i class="fa fa-trash"></i></button>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
			<br/>
			<div class="pull-right">
				<button type="submit" class="btnsave btn btn-sm btn-success" name="save"><i class="fa fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#jur-template-modal">Load Template</button>
				<a href="javascript:addRow();" class="btn btn-primary btn-sm"><span style="color:#fff;"><?= $this->lang->line('tambah_baris') ?></span></a>
			</div>
		</div>
	</div>
	</form>

</div>

<div id="editBarangModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="pembelianModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 650px;">
        <div class="modal-content">
            <form action="<?php echo $form_edit_action; ?>" method="POST" id="pembelian_form">
                <input type="hidden" name="detailID" value="">
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
							<input type="number" name="qty" class="form-control" required="">
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
							<input type="number" name="qty_2" class="form-control" >
						</div>
						<div class="col-sm-3">
							<select name="satuan_2" class="form-control" style="width: 100%;">
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
							<input type="number" name="harga" class="form-control" required="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Diskon (Rp)</label>
						<div class="col">
							<input type="number" name="diskon" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">PPN (10%)</label>
						<div class="col">
							<input type="number" name="ppn" class="form-control" value="10">
						</div>
					</div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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

<script type="text/javascript">
	$('.btn-edit-barang').on('click', function(event){
		event.preventDefault();
		var opts = $(this).data('options'),
			modal = $('#editBarangModal');
		
		modal.modal('show');
        modal.find('[name="kode"]').val( opts.barangBarcode ).trigger('change').end()
        .find('[name="nama"]').val( opts.barangName ).trigger('change').end()
        .find('[name="idbarang"]').val( opts.barangID ).trigger('change');

        $.each(opts, function(k,v){
			modal.find('[name="'+ k +'"]').val( v ).trigger('change');
		});
	});
	$('.btn-delete-akun-jur').on('click', function( event ){
		event.preventDefault();
		$(this).closest('tr').remove();
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
					valDebit = v.debit_kredit == '1' ? 0 : '',
					valKredit = v.debit_kredit == '1' ? '' : 0;
					
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