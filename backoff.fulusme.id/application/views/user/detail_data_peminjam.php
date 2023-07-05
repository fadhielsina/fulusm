<div class="post-title col-lg-12">
	<div class="col-lg-12">
		<!-- <h4 class="card-title"><input type="button" value="Back" onclick="history.back()" class="btn btn-primary btn-sm"></h4> -->
		<div class="card">
			<h1><a href="<?= base_url('data_peminjam') ?>"><i class="mdi mdi-chevron-double-left float-right"></i></a></h1>
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
							<img style="width: 200px;" src="https://www.fulusme.id/assets/img/profile/<?= $identitas['image'] ?>" class="rounded mx-auto d-block" alt="...">
							<div class="row mt-3">
								<div class="col">
									<h4 class="text-center">Detail Profil</h4>
									<table class="table">
										<tbody>
											<tr>
												<td class="font-bold">ID</td>
												<td><?= $user_id ?></td>
											</tr>
											<tr>
												<td class="font-bold">Nama</td>
												<td><?= $identitas['name'] ?></td>
											</tr>

											<tr>
												<td class="font-bold">Phone</td>
												<td><?= $identitas['phone'] ?></td>
											</tr>

											<tr>
												<td class="font-bold">Email</td>
												<td><?= $identitas['email'] ?></td>
											</tr>

											<tr>
												<td class="font-bold">Alamat</td>
												<td><?= $identitas['address'] ?></td>
											</tr>

											<tr>
												<td class="font-bold">Nama Perusahaan</td>
												<td><?= $identitas['nama_perusahaan'] ?></td>
											</tr>

											<tr>
												<td class="font-bold">Phone Perusahaan</td>
												<td><?= $identitas['no_tlp'] ?></td>
											</tr>

										</tbody>
									</table>
								</div>

								<div class="col">

									<table class="table">

										<h4 class="text-center">Document Profil</h4>

										<tbody>

											<tr>

												<td class="font-bold ">KTP</td>

												<td><?= $identitas['ktp'] ?></td>

												<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $identitas['ktp_file'] ?>"><i class="mdi mdi-download" title="Download File" style="font-size:23px;"></i></a></td>

											</tr>

											<tr>

												<td class="font-bold ">NPWP</td>

												<td><?= $identitas['npwp'] ?></td>

												<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $identitas['npwp_file'] ?>"><i class="mdi mdi-download" title="Download File" style="font-size:23px;"></i></a></td>

											</tr>

											<tr>

												<td class="font-bold ">ID Badan Hukum</td>

												<td><?= $identitas['id_badan_hukum'] ?></td>

												<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $identitas['id_badan_hukum_file'] ?>"><i class="mdi mdi-download" title="Download File" style="font-size:23px;"></i></a></td>

											</tr>

											<tr>

												<td class="font-bold ">SIUP</td>

												<td></td>

												<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $identitas['siup'] ?>"><i class="mdi mdi-download" title="Download File" style="font-size:23px;"></i></a></td>

											</tr>

											<tr>

												<td class="font-bold ">TDP</td>

												<td></td>

												<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $identitas['tdp'] ?>"><i class="mdi mdi-download" title="Download File" style="font-size:23px;"></i></a></td>

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

									<th>Nama Project</th>

									<th>Lokasi</th>

									<th>Nilai Project</th>

									<th>Modal Project</th>

									<th>Deadline</th>

									<th>Status</th>

									<th></th>

								</tr>

							</thead>

							<tbody>

								<?php

								if ($data_project) {

									$i = 1;

									foreach ($data_project as $row) { ?>

										<tr>

											<td class="text-center"><?= $i ?></td>

											<td><?= $row->nama_project ?></td>

											<td><?= $row->lokasi_project ?></td>

											<td><?= number_format($row->nilai_project) ?></td>

											<td><?= number_format($row->modal_project) ?></td>

											<td><?= $row->deadline ?></td>

											<td><?= $row->status ?></td>

											<td><a href="<?= base_url('project/project_detail') ?>/<?= $row->id ?>">Detail</a></td>

										</tr>

								<?php

										$i++;
									}
								}

								?>

							</tbody>

							<tfoot>

								<tr>

									<th>No</th>

									<th>Nama Project</th>

									<th>Lokasi</th>

									<th>Nilai Project</th>

									<th>Modal Project</th>

									<th>Deadline</th>

									<th>Status</th>

									<th></th>

								</tr>

							</tfoot>

						</table>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>