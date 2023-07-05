<div class="post-body">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-5">
                    <h4 class="card-title"><?= $title ?></h4>

                    <?= form_open('' . base_url() . 'project_retail/'); ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Filter Project</label>
                            <select class="form-control" id="stat_pro" name="stat_pro" onchange="this.form.submit()">
                                <option selected disabled>--Pilih Status--</option>
                                <option value="10">Semua Project</option>
                                <?php foreach ($status_pro as $row) : ?>
                                    <option value="<?= $row->id ?>"><?= $row->status ?></option>
                                <?php endforeach ?>
                            </select>
                            <small class="text-danger"> <?= form_error('stat_pro'); ?> </small>
                        </div>
                    </div>
                    <?= form_close(); ?>

                    <div class="table-responsive m-t-5">
                        <table id="table_all_project" class="display">
                            <thead>
                                <tr>
                                    <th>Id Project</th>
                                    <th>Nama Pemilik</th>
                                    <th>ID User</th>
                                    <th>Nama Toko</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Modal Project</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if ($data_project) {
                                    foreach ($data_project as $versi1) : ?>
                                        <?php $warna1 = 'info';
                                        $nama = 'Pending';
                                        if ($versi1->status == 1) {
                                            $warna1 = 'secondary';
                                            $nama = 'Approve';
                                        }

                                        if ($versi1->status == 2) {
                                            $warna1 = 'dark';
                                            $nama = 'Ongoing';
                                        }

                                        if ($versi1->status == 3) {
                                            $warna1 = 'danger';
                                            $nama = 'Reject';
                                        }

                                        if ($versi1->status == 4) {
                                            $warna1 = 'warning';
                                            $nama = 'Cancelled';
                                        }

                                        if ($versi1->status == 5) {
                                            $warna1 = 'success';
                                            $nama = 'Finish';
                                        } ?>

                                        <tr>
                                            <td class="text-center"><?= $versi1->id_project ?></td>
                                            <td><?= $versi1->nama_pemilik ?></td>
                                            <td><?= $versi1->user_id ?></td>
                                            <td><?= $versi1->nama_toko ?></td>
                                            <td><?= date('Y-m-d', $versi1->create_ts) ?></td>
                                            <td><?= number_format($versi1->jumlah_pinjaman) ?></td>
                                            <td>
                                                <h6><span class="badge badge-<?= $warna1 ?>"><?= $nama ?></span></h6>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="badge badge-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Aksi
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="<?= site_url('project_retail/detail/' . $versi1->id . '') ?>">Detail</a>
                                                        <?php if ($nama !== 'Pending' && $nama !== 'Reject') : ?>
                                                            <a class="dropdown-item" href="<?= site_url('project_retail/market_place/' . $versi1->id_project . '') ?>">Detail Market Place</a>
                                                            <?php if ($nama == 'Finish' or $nama == 'Ongoing') : ?>
                                                                <a class="dropdown-item" href="#">Detail Pengembalian Dana</a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
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


<script type="text/javascript">
    $(document).ready(function() {
        $('#table_all_project').DataTable({
            "order": [
                [4, "desc"]
            ]
        });
    });
</script>