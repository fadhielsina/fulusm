<style>
	.form-control:disabled,
	.form-control[readonly] {
		opacity: 1;
	}

	.form-control {
		font-size: 13px;
		color: black;
	}
</style>

<!-- start -->

<div class="post-title col-lg-12">
	<!-- <h4 class="card-title"><input type="button" value="Back" onclick="history.back()" class="btn btn-primary btn-sm"></h4> -->
	<div class="card">
		<h1><a href="<?= base_url('data_peminjam/detail') ?>/<?= $data_project->peminjam_id ?>"><i class="mdi mdi-chevron-double-left float-right"></i></a></h1>
		<div class="card-body mt-3 pt-0">
			<div class="container">
				<div class="row">
					<div class="col">
						<h4 class="text-center">Detail Project</h4>
						<table class="table">
							<tbody>
								<tr>
									<td class="font-bold">ID Penerbit</td>
									<td><?= $data_project->peminjam_id ?></td>
								</tr>
								<tr>
									<td class="font-bold">Nama Penerbit</td>
									<td><?= $data_project->name ?></td>
								</tr>
								<tr>
									<td class="font-bold">ID Project</td>
									<td><?= $project_id ?></td>
								</tr>
								<tr>
									<td class="font-bold">Nama Project</td>
									<td><?= $data_project->nama_project ?></td>
								</tr>
								<tr>
									<td class="font-bold">Deskripsi Project</td>
									<td><?= $data_project->deskripsi_project ?></td>
								</tr>
								<tr>
									<td class="font-bold">Lokasi</td>
									<td><?= $data_project->lokasi_project ?></td>
								</tr>
								<tr>
									<td class="font-bold">Modal Project</td>
									<td><?= number_format($data_project->modal_project) ?></td>
								</tr>
								<tr>
									<td class="font-bold">Tenor</td>
									<td><?= $data_project->tenor ?> Hari</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<table class="table">
							<h4 class="text-center">Document Project</h4>
							<tbody>
								<tr>
									<td class="font-bold ">SPK/PO/Wa'ad</td>
									<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->spk ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
								</tr>
								<tr>
									<td class="font-bold ">LOA</td>
									<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->loa ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
								</tr>
								<tr>
									<td class="font-bold ">Kontrak</td>
									<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->kontrak ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
								</tr>
								<tr>
									<td class="font-bold ">Rekening Koran</td>
									<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->rekening_koran ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
								</tr>
								<tr>
									<td class="font-bold ">Profil Perusahaan</td>
									<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->profil_perusahaan ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
								</tr>
								<tr>
									<td class="font-bold ">Laporan Keuangan</td>
									<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->laporan_keuangan ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
								</tr>
								<tr>
									<td class="font-bold ">Proposal Bisnis</td>
									<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->prospektus ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
								</tr>
								<tr>
									<td class="font-bold ">PKS Penerbit</td>
									<td class="pb-0"><a href="<?= base_url('data_peminjam/download_akad') ?>/<?= $data_project->peminjam_id ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col">
						<?php if ($update_doc) : $data_project = $update_doc ?>
							<table class="table">
								<h4 class="text-center">Document Project Versi 1</h4>
								<tbody>
									<tr>
										<td class="font-bold ">SPK</td>
										<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->spk ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
									</tr>
									<tr>
										<td class="font-bold ">LOA</td>
										<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->loa ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
									</tr>
									<tr>
										<td class="font-bold ">Kontrak</td>
										<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->kontrak ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
									</tr>
									<tr>
										<td class="font-bold ">Rekening Koran</td>
										<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->rekening_koran ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
									</tr>
									<tr>
										<td class="font-bold ">Profil Perusahaan</td>
										<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->profil_perusahaan ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
									</tr>
									<tr>
										<td class="font-bold ">Laporan Keuangan</td>
										<td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->laporan_keuangan ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
									</tr>
									<tr>
										<td class="font-bold ">Dokumen Pendukung</td>
										<td class="pb-0"><a href="<?= base_url('data_peminjam/download_prospektus') ?>/<?= $data_project->prospektus ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
									</tr>
								</tbody>
							</table>
						<?php endif; ?>
					</div>
				</div>
				<div class="text-center">
					<a class="btn btn-secondary" href="<?= base_url('data_peminjam/edit_document') ?>/<?= $project_id ?>">Re Upload Document</a>
				</div>
				<?php if ($get_score_project) : ?>
					<div class="col">
						<h5 class="float-right"><a href="<?= base_url('project/form_project') ?>/<?= $project_id ?>">Next</a></h5>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<?php if ($get_score_project) : ?>
				<button class="btn btn-danger float-right" onclick="printDiv('print_scorring')">Print Scorring</button>
				<div id="print_scorring">
					<b>
						<h4 class="card-title">Hasil Scoring : <b>
								<?= $get_score_project[0]->hasil_scoring ?>
							</b> </h4>
						<ul class="list-group">
							<?php
							$cek = "";
							foreach ($get_score_project as $score_project) : ?>
								<?php
								if ($score_project->nama_detail_tipe != $cek) { ?>
									<h3 class="mt-3 mb-1"><?= $score_project->nama_detail_tipe ?></h3>
									<li class="list-group-item d-flex justify-content-between align-items-center"><?= $score_project->nama_sub_tipe ?>
										<span class="pr-4"><b><?= $score_project->persent ?></b></span>
									</li>
								<?php
									$cek = $score_project->nama_detail_tipe;
								} else { ?>
									<li class="list-group-item d-flex justify-content-between align-items-center"><?= $score_project->nama_sub_tipe ?>
										<span class="pr-4"><b><?= $score_project->persent ?></b></span>
									</li>
								<?php } ?>
							<?php endforeach; ?>
						</ul>
				</div>
				<!-- pembatas -->
			<?php else : ?>
				<?php $this->load->view('scoring/data_scoring'); ?>
			<?php endif; ?>
		</div>
	</div>

</div>
</div>

<script>
	function printDiv(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;

		document.title = "Project <?= $data_project->nama_project ?> (<?= $project_id ?>)";
		document.body.innerHTML = printContents;

		window.print();

		document.body.innerHTML = originalContents;
	}
</script>