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

								<div class="row mt-3">

									<div class="col">

										<h4 class="text-center">Detail Profil</h4>

										<table class="table">

											<tbody>

												<tr>

													<td class="font-bold">Nama</td>

													<td><?= $identitas[0]['full_name'] ?></td>

												</tr>

												<tr>

													<td class="font-bold ">KTP</td>

													<td><?= $identitas[0]['ktp'] ?></td>

													<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $identitas[0]['ktp_file'] ?>"><i class="mdi mdi-download" title="Download File" style="font-size:23px;"></i></a></td>

												</tr>

												<tr>

													<td class="font-bold">Phone</td>

													<td><?= $identitas[0]['phone'] ?></td>

												</tr>

												<tr>

													<td class="font-bold">Email</td>

													<td><?= $identitas[0]['email'] ?></td>

												</tr>

												<tr>

													<td class="font-bold">Alamat</td>

													<td><?= $identitas[0]['address'] ?></td>

												</tr>

												<tr>

													<td class="font-bold">Nama Akun / Bank</td>

													<td><?= $identitas[0]['bank_account_name'] ?> / <?= $identitas[0]['nama_bank'] ?></td>

												</tr>

												<tr>

													<td class="font-bold">Nomer Rekening</td>

													<td><?= $identitas[0]['bank_number'] ?></td>

												</tr>

											</tbody>

										</table>

									</div>

									<div class="col">

										<table class="table">

											<h4 class="text-center">Document Perusahaan</h4>

											<tbody>

												<tr>

													<td class="font-bold">Nama Perusahaan</td>

													<td><?= $identitas[0]['nama_perusahaan'] ?></td>

												</tr>

												<tr>

													<td class="font-bold">Phone Perusahaan</td>

													<td><?= $identitas[0]['no_tlp'] ?></td>

												</tr>

												<tr>

													<td class="font-bold">Rekening Perusahaan</td>

													<td><?= $identitas[0]['rekening_perusahaan'] ?></td>

												</tr>

												<tr>

													<td class="font-bold">Rekening Perusahaan Nama</td>

													<td><?= $identitas[0]['rekening_perusahaan_nama'] ?></td>

												</tr>

												<tr>

													<td class="font-bold">Nama Bank</td>

													<td><?= $identitas[0]['bank_name'] ?></td>

												</tr>

												<tr>

													<td class="font-bold ">ID Badan Hukum</td>

													<td><?= $identitas[0]['id_badan_hukum'] ?></td>
													<?php if ($identitas[0]['id_badan_hukum']) : ?>
														<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $identitas[0]['id_badan_hukum_file'] ?>"><i class="mdi mdi-download" title="Download File" style="font-size:23px;"></i></a></td>
													<?php endif; ?>
												</tr>

											</tbody>

										</table>

									</div>

								</div>

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