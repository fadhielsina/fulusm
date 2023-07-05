<div class="post-body">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-5">
                    <h4 class="card-title"><?= $title ?></h4>

                    <?= form_open('' . base_url() . 'project/'); ?>
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

                    <table id="table_all_project" class="display">
                        <thead>
                            <tr>
                                <th>Id Project</th>
                                <th>Nama Project</th>
                                <th>Lokasi</th>
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
                                    <?php if ($cek == 10) : ?>
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
                                            <td class="text-center"><?= $versi1->id ?></td>
                                            <td><?= $versi1->nama_project ?></td>
                                            <td><?= $versi1->lokasi_project ?></td>
                                            <td><?= date('Y-m-d', $versi1->create_ts) ?></td>
                                            <td><?= number_format($versi1->modal_project) ?></td>
                                            <td>
                                                <h6><span class="badge badge-<?= $warna1 ?>"><?= $nama ?></span></h6>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="badge badge-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Aksi
                                                    </button>

                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="<?= base_url('project/project_detail') ?>/<?= $versi1->id ?>">Detail</a>
                                                        <?php if ($nama !== 'Pending' && $nama !== 'Reject') : ?>
                                                            <a class="dropdown-item" href="<?= base_url('project/marketplace_detail') ?>/<?= $versi1->id ?>">Detail Market Place</a>
                                                            <?php if ($nama == 'Finish' or $nama == 'Ongoing') : ?>
                                                                <a class="dropdown-item" href="<?= base_url('transaksi/form_bayar') ?>/<?= $versi1->id ?>">Detail Pengembalian Dana</a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    <?php else : ?>
                                        <?php if ($versi1->status == $cek) : ?>
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
                                                <td class="text-center"><?= $versi1->id ?></td>
                                                <td><?= $versi1->nama_project ?></td>
                                                <td><?= $versi1->lokasi_project ?></td>
                                                <td><?= date('Y-m-d', $versi1->create_ts) ?></td>
                                                <td><?= number_format($versi1->modal_project) ?></td>
                                                <td>
                                                    <h6><span class="badge badge-<?= $warna1 ?>"><?= $nama ?></span></h6>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="badge badge-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Aksi
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="<?= base_url('data_peminjam/project_detail') ?>/<?= $versi1->id ?>">Detail</a>
                                                            <?php if ($nama !== 'Pending' && $nama !== 'Reject') : ?>
                                                                <a class="dropdown-item" href="<?= base_url('project/detail') ?>/<?= $versi1->id ?>">Detail Market Place</a>
                                                                <?php if ($nama == 'Finish' or $nama == 'Ongoing') : ?>
                                                                    <a class="dropdown-item" href="<?= base_url('transaksi/form_bayar') ?>/<?= $versi1->id ?>">Detail Pengembalian Dana</a>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#table_all_project').DataTable({
            "order": [
                [3, "desc"]
            ]
        });
    });
</script>