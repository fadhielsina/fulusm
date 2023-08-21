<script>
	function formatNumber(input) {
		var num = input.value.replace(/\,/g, '');
		if (!isNaN(num)) {
			if (num.indexOf('.') > -1) {
				num = num.split('.');
				num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1,').split('')
					.reverse().join('').replace(/^[\,]/, '');
				if (num[1].length > 2) {
					alert('You may only enter two decimals!');
					num[1] = num[1].substring(0, num[1].length - 1);
				}
				input.value = num[0] + '.' + num[1];
			} else {
				input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1,').split('')
					.reverse().join('').replace(/^[\,]/, '')
			};
		} else {
			alert('Anda hanya diperbolehkan memasukkan angka!');
			input.value = input.value.substring(0, input.value.length - 1);
		}
	}

	function hitung_lot() {
		var jumlah_lembar_shm = document.getElementById('jumlah_lembar_shm').value;
		var modal_project = document.getElementById('modal_project').value.replace(/[$,]+/g, "");
		var hasil = parseInt(modal_project) / parseInt(jumlah_lembar_shm);
		document.getElementById('harga_perlot').value = hasil.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
	}

	function hitung_pembagian() {
		var hasil_pendana = document.getElementById('pem_pendana').value;
		var hasil = 100 - parseInt(hasil_pendana);
		document.getElementById('pem_peminjam').value = hasil;
	}

	function jenis() {
		var jenis = document.getElementById('jenis_pengembalian').value;
		var mydiv = document.getElementById('tambahan');
		if (jenis == 0) {
			mydiv.innerHTML = "<label>Tanggal Jatuh Tempo</label><input type='date' id='tgl_pengembalian' name='tgl_pengembalian' class='form-control'><small class='text-danger'> <?= form_error('tgl_pengembalian'); ?> </small>"
		}
		if (jenis == 1) {
			mydiv.innerHTML = "<label>Jenis Angsuran</label><select class='form-control' id='jatuh_tempo' name='jatuh_tempo'><option disabled selected>Pilih Jenis Angsuran</option><option value='1'>1 Bulan</option><option value='2'>2 Bulan</option><option value='3'>3 Bulan</option><option value='4'>4 Bulan</option><option value='5'>5 Bulan</option><option value='6'>6 Bulan</option><option value='7'>7 Bulan</option><option value='8'>8 Bulan</option><option value='9'>9 Bulan</option><option value='10'>10 Bulan</option><option value='12'>12 Bulan</option></select><small class='text-danger'> <?= form_error('jatuh_tempo'); ?> </small>"
		}
	}
</script>

<div class="post-body">
	<?php echo $this->session->flashdata('message'); ?>
	<?php
	if ($this->session->userdata('SUCCESSMSG')) {
		echo "<div class='success'>" . $this->session->userdata('SUCCESSMSG') . "</div>";
		$this->session->unset_userdata('SUCCESSMSG');
	}
	?>

	<?php if ($stat_project) : ?>
		<?php if ($stat_project->note_app) { ?>
			<?php $color = "info";
			if ($data_project->status == "Reject") {
				$color = "danger";
			} ?>
			<div class="alert alert-<?= $color ?> alert-dismissible fade show" role="alert">
				<strong>Project ini telah di <?= $data_project->status ?>! </strong> <br> Note : <?= $stat_project->note_app ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php } ?>
	<?php endif; ?>

	<?php if ($history_project != null) : ?>
		<div class="card">
			<h1><a href="<?= base_url('project/project_detail') ?>/<?= $data_project->id_project ?>"><i class="mdi mdi-chevron-double-left float-right"></i></a></h1>
			<div class="card-body">
				<div class="container">
					<h4 class="mb-2">Versi 1</h4>
					<h5 class="mb-4 card-subtitle text-center">Note : <br> <?= $stat_project->note ?></h5>
					<div class="row mb-4">
						<div class="col">
							<label>Nama Penerbit</label>
							<h5><?= $user_data[0]->name ?></h5>
						</div>
						<div class="col">
							<label>Nama Usaha</label>
							<h5><?= $history_project->nama_project ?></h5>
						</div>
						<div class="col">
							<label>Periode Dividen</label>
							<h5><?= $history_project->tenor ?> Hari</h5>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col">
							<label>Deadline</label>
							<h5><?= $history_project->deadline ?></h5>
						</div>
						<div class="col">
							<label>Score Project</label>
							<?php if ($score) { ?>
								<h5><?= $score[0]->hasil_scoring ?></h5>
							<?php } else { ?>
								<h5>0</h5>
							<?php } ?>
						</div>
						<div class="col">
							<label>Status Project</label>
							<h5><?= $data_project->id_project ?></h5>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col">
							<label>Code Saham</label>
							<h5><?= $history_project->code_saham_alias ?></h5>
						</div>
						<div class="col">
							<label>Jumlah Lembar Saham Yang Diterbitkan</label>
							<h5><?= $history_project->jumlah_lembar_shm ?></h5>
						</div>
						<div class="col">
							<label>Harga PerLot Saham</label>
							<h5><?= number_format($history_project->harga_perlot) ?></h5>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label>Harga Perlembar Saham</label>
							<h5><?= number_format($history_project->harga_perlembar_shm) ?></h5>
						</div>
						<div class="col">
							<label>Modal Yang Dibutuhkan</label>
							<h5><?= number_format($history_project->modal_project) ?></h5>
						</div>
						<div class="col">
							<label>Estimasi Dividen</label>
							<h5><?= $history_project->keuntungan ?>%</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php else : ?>
		<div class="card">
			<h1><a href="<?= base_url('project/project_detail') ?>/<?= $data_project->id_project ?>"><i class="mdi mdi-chevron-double-left float-right"></i></a></h1>
			<div class="card-body pt-0">
				<div class="container">
					<h4 class="mb-4">Versi 0</h4>
					<div class="row mb-4">
						<div class="col">
							<label>Nama Penerbit</label>
							<h5><?= $user_data[0]->name ?></h5>
						</div>
						<div class="col">
							<label>Nama Project</label>
							<h5><?= $data_project->nama_project ?></h5>
						</div>
						<div class="col">
							<label>Tenor Pinjam</label>
							<h5><?= $data_project->tenor ?> Hari</h5>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col">
							<label>Deadline</label>
							<h5><?= $data_project->deadline ?></h5>
						</div>
						<div class="col">
							<label>Score Project</label>
							<?php if ($score) { ?>
								<h5><?= $score[0]->hasil_scoring ?></h5>
							<?php } else { ?>
								<h5>0</h5>
							<?php } ?>
						</div>
						<div class="col">
							<label>Status Project</label>
							<h5><?= $data_project->status ?></h5>
						</div>
					</div>

					<?php $cek = "readonly";
					if ($stat_project->edit_st == "0" && $data_project->status == "Pending" && $formProject == null) {
						$cek = "";
					}
					?>
					<form action="<?= base_url('project/form_project') ?>/<?= $data_project->id_project ?>" method="post">
						<input type="hidden" name="id" value="<?= $data_project->id_project ?>">
						<input type="hidden" name="type" value="<?= $data_project->type ?>">
						<div class="row mb-4">
							<div class="col">
								<label>Kode Saham </label>
								<input class="form-control" <?= $cek ?> type="hidden" name="rating" value="<?= $grade->id ?>">
								<h5><input class="form-control" maxlength="6" <?= $cek ?> type="text" name="code_saham" value="<?= $data_project->code_saham_alias ?>" required></h5>
							</div>
							<div class="col">
								<label>Jumlah Lembar Saham Yang Diterbitkan</label>
								<h5><input class="form-control" <?= $cek ?> type="number" min="100" onkeyup="hitung_lot()" name="jumlah_lembar_shm" id="jumlah_lembar_shm" value="<?= number_format($data_project->jumlah_lembar_shm) ?>"></h5>
							</div>
							<div class="col">
								<label>Harga PerLot Saham</label>
								<h5><input class="form-control" <?= $cek ?> type="text" onkeyup="formatNumber(this);" name="harga_perlot" id="harga_perlot" value="<?= number_format($data_project->harga_perlot) ?>"></h5>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<label>Harga Perlembar Saham</label>
								<h5><input class="form-control" <?= $cek ?> type="text" name="perlembar_saham" id="perlembar_saham" onkeyup="formatNumber(this)" value="<?= number_format($data_project->harga_perlembar_shm) ?>">
								</h5>
							</div>
							<div class="col">
								<label>Modal Yang Dibutuhkan</label>
								<h5><input class="form-control" <?= $cek ?> type="text" onkeyup="formatNumber(this);hitung_lot()" name="modal_project" id="modal_project" value="<?= number_format($data_project->modal_project) ?>">
								</h5>
							</div>
							<div class="col">
								<label>Estimasi Dividen</label>
								<h5><input class="form-control" <?= $cek ?> type="text" name="keuntungan" value="<?= $data_project->keuntungan ?>"></h5>
							</div>
						</div>
						<?php if ($cek == "") : ?>
							<div class="row">
								<div class="col-lg-6">
									<label>Note Perubahan</label>
									<textarea class="form-control" id="note" name="note" rows="4"></textarea>
								</div>
								<div class="mt-5">
									<button type="submit" class="btn btn-block btn-outline-secondary" name="editform" onclick="return confirm('Simpan Perubahan?')">Simpan Perubahan</button>
								</div>
							</div>
						<?php endif ?>
					</form>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ($stat_project->note_score) { ?>
		<div class="alert alert-info alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<strong>Project ini telah di scoring. </strong> <br> Note : <?= $stat_project->note_score ?>
		</div>
	<?php } ?>

	<?php if ($data_project->status == 'Pending') : ?>
		<?php $this->load->view('scoring/form_project_data') ?>
	<?php endif; ?>

</div>