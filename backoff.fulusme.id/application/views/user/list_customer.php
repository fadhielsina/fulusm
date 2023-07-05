<div class="post-body">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive m-t-5">
					<h4 class="card-title"><?= $title ?></h4>
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Pribadi</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Perusahaan</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
							<table id="table_peminjam" class="display">
								<thead>
									<tr>
										<th>User ID</th>
										<th>Nama</th>
										<th>KTP</th>
										<th>Alamat</th>
										<th>Email</th>
										<th>Telpon</th>
										<th>Status</th>
										<th></th>
									</tr>
								</thead>

								<tbody>
									<?php
									if ($user_data) {
										$i = 0;
										foreach ($user_data as $row) {
											if ($row->type == 1) {
												echo '<tr>';
												echo '<td class="text-center">' . $row->user_id . '</td>';
												echo '<td>' . $row->name . '</td>';
												echo '<td>' . $row->ktp . '</td>';
												echo '<td>' . $row->address . '</td>';
												echo '<td>' . $row->email_user . '</td>';
												echo '<td>' . $row->phone . '</td>';
												if ($row->active == 1) :
													echo '<td> Teraktivasi </td>';
												else :
													echo '<td> Belum Teraktivasi </td>';
												endif;
												echo '<td><a href="' . base_url('' . $link_detail . '') . $row->id_user . '"class="btn btn-primary btn-sm">Detail</a></td>';
												echo '</tr>';
												$i++;
											}
										}
									}
									?>
								</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
							<table id="table_peminjam_company" class="display">
								<thead>
									<tr>
										<th>User ID</th>
										<th>Nama</th>
										<th>KTP</th>
										<th>Perusahaan</th>
										<th>Kota</th>
										<th>Phone</th>
										<th>Status</th>
										<th></th>
									</tr>
								</thead>

								<tbody>
									<?php
									if ($user_data) {
										$i = 0;
										foreach ($user_data as $row) {
											if ($row->type == 2) {
												echo '<tr>';
												echo '<td class="text-center">' . $row->user_id . '</td>';
												echo '<td>' . $row->name . '</td>';
												echo '<td>' . $row->ktp . '</td>';
												echo '<td>' . $row->namaperusahaan . '</td>';
												echo '<td>' . $row->kota . '</td>';
												echo '<td>' . $row->phone . '</td>';
												if ($row->active == 1) :
													echo '<td> Teraktivasi </td>';
												else :
													echo '<td> Belum Teraktivasi </td>';
												endif;
												echo '<td><a href="' . base_url('' . $link_detail . '') . $row->id_user . '"class="btn btn-primary btn-sm">Detail</a></td>';
												echo '</tr>';
												$i++;
											}
										}
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

<script type="text/javascript">
	$(document).ready(function() {
		$('#table_peminjam').DataTable();

	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#table_peminjam_company').DataTable();

	});
</script>