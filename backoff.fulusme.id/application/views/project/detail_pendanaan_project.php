<?php $tgl = date('Y-m-d', $project->paid_ts); ?>
<div class="card">
    <h1><a href="<?= base_url('data_pendana/pendanaan') ?>"><i class="mdi mdi-chevron-double-left float-right"></i></a></h1>
    <div class="card-body">
        <div class="text-center mb-3">
            <h2 class="mb-0"><?= $project->nama_project ?></h2>
            <h5><?= $project->project_id ?></h5>
        </div>
        <div class="card-body">
            <div class="container mb-3">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Peminjam
                        <h4><span><?= $project->name ?></span></h4>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Nominal
                        <h4><span><?= number_format($project->nominal) ?></span></h4>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Nomor Virtual Account
                        <h4><span><?= $project->nomor_va ?></span></h4>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Status
                        <?php if ($project->status_pendanaan == "paid") : ?>
                            <h4><span><?= $project->status_pendanaan ?></span></h4>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Waktu Pembayaran
                        <h4><span><?= date('H:i:s', $project->paid_ts); ?><br><?= longdate_indo($tgl); ?></span></h4>
                    </li>
                <?php else : ?>
                    <h4><span><?= $project->status_pendanaan ?></span></h4>
                    </li>
                <?php endif; ?>
                <!-- <a href="#" class="list-group-item list-group-item-action">Status
                        <h4 class="float-right"><span><?= $project->status_pendanaan ?></span></h4>
                    </a> -->
                </ul>
            </div>
        </div>
    </div>
</div>
</div>