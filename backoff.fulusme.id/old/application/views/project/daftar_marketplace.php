<div class="post-body">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-5">
                    <h4 class="card-title"><?= $title ?></h4>
                    <table id="pro_berjalan" class="table display table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>Id Project</th>

                                <th>Nama Project</th>

                                <th>Tgl Approve</th>

                                <th>Deadline Promosi</th>

                                <th>Pinjaman</th>

                                <th>Dana Terkumpul</th>

                                <th>Status</th>

                                <th></th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($project as $row) : ?>

                                <?php $dana_terkumpul = $this->project_model->getDanaTerkumpul($row['id_project']);

                                $id_project = $row['id_project'];

                                $cek_modal = $this->project_model->getDataProject($id_project);

                                if ($cek_modal) {

                                    $modal = $cek_modal->modal_project;

                                    $type = "non_retail";
                                } else {

                                    $modal = $this->db->get_where('trx_project_retail', ['id_project' => $id_project])->row()->modal_project;

                                    $type = "retail";
                                }

                                $sekarang = date('Y-m-d', time());

                                $hamin2 = date('Y-m-d', strtotime("-2 day", strtotime(date($row['tgl_deadline']))));

                                $notif = ['warna' => 'info', 'pesan' => 'Sedang Proses'];

                                if ($dana_terkumpul->nominal >= $modal) {

                                    $notif = ['warna' => 'success', 'pesan' => 'Dana Terkumpul'];
                                } elseif ($sekarang  >= $row['tgl_deadline']) {

                                    $notif = ['warna' => 'danger', 'pesan' => 'Waktu Habis'];
                                } elseif ($sekarang >= $hamin2) {

                                    $notif = ['warna' => 'warning', 'pesan' => 'Kurang dari 3 hari'];
                                } ?>

                                <tr>

                                    <td><?= $row['id_project'] ?></td>

                                    <td><?= $row['nama_project'] ?></td>

                                    <td><?= $row['tgl_app'] ?></td>

                                    <td><?= $row['tgl_deadline'] ?></td>

                                    <td><?= number_format($modal) ?></td>

                                    <td><?= number_format($dana_terkumpul->nominal) ?></td>

                                    <td>

                                        <h5><span class="badge badge-<?= $notif['warna'] ?>"><?= $notif['pesan'] ?></span></h5>

                                    </td>

                                    <?php if ($type == "retail") : ?>

                                        <td><a href="<?= base_url('project_retail/market_place') ?>/<?= $row['id_project'] ?>">Detail</a></td>

                                    <?php else : ?>

                                        <td><a href="<?= base_url('project/marketplace_detail') ?>/<?= $row['id_project'] ?>">Detail</a></td>

                                    <?php endif; ?>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                        <tfoot>

                            <tr>

                                <th>Id Project</th>

                                <th>Nama Project</th>

                                <th>Tgl Approve</th>

                                <th>Deadline Promosi</th>

                                <th>Pinjaman</th>

                                <th>Dana Terkumpul</th>

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

<script type="text/javascript">
    $(document).ready(function() {

        $('#pro_berjalan').DataTable({

            "order": [

                [2, "desc"]

            ]

        });

    });
</script>