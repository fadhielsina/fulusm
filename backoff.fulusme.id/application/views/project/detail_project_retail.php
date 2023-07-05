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


<div class="post-title col-lg-12">
    <div class="card">
        <h1><a href="<?= base_url('project_retail') ?>"><i class="mdi mdi-chevron-double-left float-right"></i></a></h1>
        <div class="card-body mt-3 pt-0">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h4 class="text-center">Detail User</h4>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="font-bold">ID Pengelola Dana</td>
                                    <td><?= $data_project->user_id ?></td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Nama</td>
                                    <td><?= $data_project->name ?></td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Tanggal lahir</td>
                                    <td><?= $data_project->tempat_lahir ?> , <?= date('d-m-Y', strtotime($data_project->tanggal_lahir)) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Email</td>
                                    <td><?= $data_project->email ?></td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Alamat</td>
                                    <td><?= $data_project->address ?></td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Pekerjaan</td>
                                    <td><?= $data_project->pekerjaan ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col">
                        <table class="table">
                            <h4 class="text-center">Detail Project Retail</h4>
                            <tbody>
                                <tr>
                                    <td class="font-bold">ID Project</td>
                                    <td><?= $data_project->id_project ?></td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Nama Toko</td>
                                    <td><?= $data_project->nama_toko ?></td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Nama Pemilik</td>
                                    <td><?= $data_project->nama_pemilik ?></td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Alamat Toko</td>
                                    <td><?= $data_project->alamat_toko ?></td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Modal Project</td>
                                    <td><?= number_format($data_project->jumlah_pinjaman) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Tenor</td>
                                    <td><?= $data_project->tenor ?> Hari</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <table class="table">
                            <h4 class="text-center">Document Project</h4>
                            <tbody>
                                <tr>
                                    <td class="font-bold ">KTP</td>
                                    <td><?= $data_project->ktp ?></td>
                                    <td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->ktp_file ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="font-bold ">KK</td>
                                    <td><?= $data_project->kk ?></td>
                                    <td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->kk_file ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="font-bold ">Foto Diri</td>
                                    <td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->foto_diri ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="font-bold ">Foto Toko</td>
                                    <td class="pb-0"><a href="<?= base_url('data_peminjam/download_doc') ?>/<?= $data_project->foto_toko ?>"><i class="mdi mdi-folder-download" title="Download File" style="font-size:23px; color:green;"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if ($get_score_project) : ?>
                <b>
                    <h4 class="float-right ml-3"><a href="<?= base_url('project_retail/form_project/' . $project_id . '') ?>">Next</a></h4>
                    <button class="btn btn-danger float-right" onclick="printDiv('print_scorring_retail')">Print Scorring</button>
                    <div id="print_scorring_retail">
                        <div id="header"></div>
                        <h4 class="card-title">Hasil Scoring : <b>
                                <?= $get_score_project[0]->hasil_scoring ?>
                            </b> </h4>
                    <?php endif; ?>

                    <?php if ($get_score_project) { ?>
                        <ul class="list-group">
                            <?php
                            $cek = "";
                            foreach ($get_score_project as $score_project) : ?>
                                <?php
                                if ($score_project->nama_detail_tipe != $cek) { ?>
                                    <h3 class="mt-3 mb-1"><?= $score_project->nama_detail_tipe ?></h3>
                                    <li class="list-group-item d-flex justify-content-between align-items-center"><?= $score_project->nama_sub_tipe ?>
                                        <span class="pr-4"><b><?= $score_project->persent ?></b></span></li>
                                <?php
                                    $cek = $score_project->nama_detail_tipe;
                                } else { ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center"><?= $score_project->nama_sub_tipe ?>
                                        <span class="pr-4"><b><?= $score_project->persent ?></b></span></li>
                                <?php } ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <!-- pembatas -->
                <?php } else { ?>
                    <?php $this->load->view('scoring/data_scoring'); ?>
                <?php } ?>
        </div>
    </div>
</div>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.title = "Project <?= $data_project->nama_toko ?> (<?= $project_id ?>)";
        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>