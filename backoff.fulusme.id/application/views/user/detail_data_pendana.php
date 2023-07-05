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
</script>

<div class="post-title col-lg-12">
	<div class="post-body">
		<div class="col-lg-12">

			<!-- <h4 class="card-title"><input type="button" value="Back" onclick="history.back()" class="btn btn-primary btn-sm"></h4> -->
			<div class="card">
				<h1><a href="<?= base_url('data_pendana') ?>"><i class="mdi mdi-chevron-double-left float-right"></i></a></h1>
				<div class="card-body pt-0">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Project</a>
						</li>
					</ul>

					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
							<div class="container">
								<img style="width: 200px;" src="https://www.fulusme.id/assets/img/profile/<?= $query_image ?>" class="rounded mx-auto d-block" alt="...">
								<div class="row mt-3">
									<div class="col">
										<h4 class="text-center">Detail Profil</h4>
										<table class="table">
											<tbody>
												<tr>
													<td class="font-bold">Nama</td>
													<td><?= $identitas['full_name'] ?></td>
												</tr>
												<tr>
													<td class="font-bold ">KTP</td>
													<td><?= $identitas['ktp'] ?></td>
													<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $identitas['ktp_file'] ?>"><i class="mdi mdi-download" title="Download File" style="font-size:23px;"></i></a></td>
												</tr>
												<tr>
													<td class="font-bold">Phone</td>
													<td><?= $identitas['phone'] ?></td>
												</tr>
												<tr>
													<td class="font-bold">Email</td>
													<td><?= $identitas['email'] ?></td>
												</tr>
												<?php if ($identitas['type'] == 1) : ?>
													<tr>
														<td class="font-bold">Alamat</td>
														<td><?= $identitas['address'] ?></td>
													</tr>
												<?php endif; ?>
												<tr>
													<td class="font-bold">Nama Akun / Bank</td>
													<td><?= $identitas['bank_account_name'] ?> / <?= $identitas['bank_name'] ?></td>
												</tr>
												<tr>
													<td class="font-bold">Nomer Rekening</td>
													<td><?= $identitas['bank_number'] ?></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="col">
										<table class="table">
											<?php $custo = 0;
											if ($identitas['type'] == 2) : ?>
												<h4 class="text-center">Profil Perusahaan</h4>
												<tbody>
													<tr>
														<td class="font-bold">Nama Perusahaan</td>
														<td><?= $identitas['namaperusahaan'] ?></td>
													</tr>
													<tr>
														<td class="font-bold">Phone Perusahaan</td>
														<td><?= $identitas['phone_company'] ?></td>
													</tr>
													<tr>
														<td class="font-bold">Nomor Akta Perusahaan</td>
														<td><?= $identitas['nomoraktaperusahaan'] ?></td>
													</tr>
													<tr>
														<td class="font-bold">Jenis Perusahaan</td>
														<td><?= $identitas['jenisperusahaan'] ?></td>
													</tr>
													<tr>
														<td class="font-bold">Alamat Perusahaan</td>
														<td><?= $identitas['alamatperusahaan'] ?></td>
													</tr>
													<tr>
														<td class="font-bold ">Surat Kuasa</td>
														<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $identitas['surat_kuasa_file'] ?>"><i class="mdi mdi-download" title="Download File" style="font-size:23px;"></i></a></td>
													</tr>
													<tr>
														<td class="font-bold ">Akte Perusahaan</td>
														<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $identitas['akte_perusahaan_file'] ?>"><i class="mdi mdi-download" title="Download File" style="font-size:23px;"></i></a></td>
													</tr>
													<tr>
														<td class="font-bold">Nama Kustodian</td>
														<td> <?= $identitas['custodian_name']; ?> </td>
													</tr>
													<tr>
														<td class="font-bold">Nomor Custodian</td>
														<td> <?= $identitas['custodian']; ?> </td>
													</tr>
												</tbody>
											<?php else : ?>
												<h4 class="text-center">Dokumen Pribadi</h4>
												<tbody>
													<tr>
														<td class="font-bold">Total Gaji</td>
														<?php if ($identitas['total_gaji'] == 1) : ?>
															<td>
																< Rp. 500.000.000 </td>
																<?php else : ?>
															<td> > Rp. 500.000.000 </td>
														<?php endif; ?>
													</tr>
													<tr>
														<td class="font-bold ">Slip Gaji</td>
														<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $identitas['slipgaji_file'] ?>"><i class="mdi mdi-download" title="Download File" style="font-size:23px;"></i></a></td>
													</tr>
													<tr>
														<td class="font-bold">Nama Kustodian</td>
														<?php if ($identitas['custodian_name']) : ?>
															<?php $custo = 1; ?>
															<td> <?= $identitas['custodian_name']; ?> </td>
														<?php else : ?>
															<td> - </td>
														<?php endif; ?>
													</tr>
													<tr>
														<td class="font-bold">Nomor Custodian</td>
														<?php if ($identitas['custodian']) : ?>
															<td> <?= $identitas['custodian']; ?> </td>
														<?php else : ?>
															<td> - </td>
														<?php endif; ?>
													</tr>
												</tbody>
											<?php endif; ?>
										</table>
									</div>
								</div>
								<?php if ($identitas['active'] != 1) : ?>
									<div class="text-center">
										<?= form_open('data_pendana/aktivasi_pendana'); ?>
										<input type="hidden" name="id" value="<?= $identitas['id'] ?>">
										<?php if ($identitas['type'] == 1) : ?>
											<?php if ($custo == 0) : ?>
												<input type="text" name="custodian_name" placeholder="Nama Kustodian" required class="form-control" style="width: 226px; margin-bottom: 5px;">
												<input type="number" name="custodian" placeholder="Nomor Kustodian" required class="form-control" style="width: 226px; margin-bottom: 5px;">
											<?php else : ?>
												<input type="hidden" name="custodian_name" placeholder="Nama Kustodian" value="<?= $identitas['custodian_name'] ?>" required>
												<input type="hidden" name="custodian" placeholder="Nomor Kustodian" value="<?= $identitas['custodian'] ?>" required>
											<?php endif; ?>
											<input type="text" onkeyup="formatNumber(this);" name="max_pendanaan" placeholder="Maksimal Pendanaan" required class="form-control" style="width: 226px; margin-bottom: 5px;">
											<br>
											<input type="text" name="note" placeholder="Note" required class="form-control" style="width: 326px; height: 48px; margin-bottom: 5px;">
											<br>
										<?php else : ?>
											<input type="hidden" name="max_pendanaan" value="0" class="form-control">
											<input type="hidden" name="note" placeholder="Note" class="form-control">
											<input type="hidden" name="custodian_name" placeholder="Nama Kustodian" value="<?= $identitas['custodian_name'] ?>" required>
											<input type="hidden" name="custodian" placeholder="Nomor Kustodian" value="<?= $identitas['custodian'] ?>" required>
										<?php endif; ?>
										<button type="submit" name="submitpost" class="btn btn-primary" onclick="return confirm('Anda Yakin?')">Approve</button>
										<button type="submit" name="rejected" class="btn btn-danger" onclick="return confirm('Anda Yakin?')">Reject</button>
										<?= form_close(); ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
							<h4 class="mt-3"><?= $title ?></h4>
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="display_table">
								<thead>
									<tr>
										<th>No</th>
										<th>Project ID</th>
										<th>Nama Project</th>
										<th>Nominal</th>
										<th>Jumlah Unit</th>
										<th>Peminjam</th>
										<th>Status</th>
										<th></th>
									</tr>
								</thead>

								<tfoot>
									<tr>
										<th>No</th>
										<th>Project ID</th>
										<th>Nama Project</th>
										<th>Nominal</th>
										<th>Jumlah Unit</th>
										<th>Peminjam</th>
										<th>Status</th>
										<th></th>
									</tr>
								</tfoot>

								<tbody>
									<?php
									if ($data_project) {
										$i = 1;
										foreach ($data_project as $row) : ?>
											<?php $query = $this->data_model->getPerlot($row->project_id); ?>
											<tr>
												<td class="text-center"><?= $i ?></td>
												<td><?= $row->project_id ?></td>
												<td><?= $row->nama_project ?></td>
												<td><?= number_format($row->nominal) ?></td>
												<td class="text-center"> <?= $row->nominal / $query->harga_perlot ?></td>
												<td><?= $row->name ?></td>
												<td><?= $row->status_pendanaan ?></td>
												<td><a href="<?= base_url('data_pendana/pendanaan_detail') ?>/<?= $row->id ?>">Detail</a></td>
											</tr>
									<?php
											$i++;
										endforeach;
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>