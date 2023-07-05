<div class="card">
    <h1><a href="#" onclick="history.back();"><i class="mdi mdi-chevron-double-left float-right"></i></a></h1>
    <div class="card-body">
        <h3 class="text-center">Histori Pendanaan</h3>
        <?php if ($project != null) : ?>
            <h3 class="text-center"><?= $project->nama_project ?> (<?= $project->id ?>)</h3>
        <?php endif; ?>
        <div class="card-body">
            <div class="table-responsive m-t-5">
                <table class="table color-table info-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User Id</th>
                            <th>Nama Pendana</th>
                            <th>No Rekening</th>
                            <th>No Virtual Account </th>
                            <th style="width: 60px">Tgl Pembayaran</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        $total = 0;
                        foreach ($trackPendanaan as $row) : ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $row->user_id ?></td>
                                <td><a href="<?= base_url('data_pendana/detail') ?>/<?= $row->id_pendana ?>"><?= $row->full_name ?></a></td>
                                <td><?= $row->bank_number ?></td>
                                <td><?= $row->nomor_va ?></td>
                                <td><?= $row->create_ts ?></td>
                                <td><?= number_format($row->nominal) ?></td>
                            </tr>
                        <?php $no++;
                            $total += $row->nominal;
                        endforeach; ?>
                    </tbody>
                </table>
                <h4 class="text-right">Total : <?= number_format($total) ?></h4>
            </div>
        </div>
        <?php if ($returPendanaan) : ?>
            <hr>
            <div class="card-body">
                <div class="text-center">
                    <h3>Histori Retur Pendanaan</h3>
                </div>
                <div class="table-responsive m-t-5">
                    <table class="table color-table info-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User Id</th>
                                <th>Nama Pendana</th>
                                <th>No Rekening</th>
                                <th>No Virtual Account </th>
                                <th style="width: 100px">Tgl Retur</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            $total_retur = 0;
                            foreach ($returPendanaan as $row) : ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $row->user_id ?></td>
                                    <td><a href="<?= base_url('data_pendana/detail') ?>/<?= $row->id_pendana ?>"><?= $row->full_name ?></a></td>
                                    <td><?= $row->bank_number ?></td>
                                    <td><?= $row->nomor_va ?></td>
                                    <td><?= $row->waktu_retur ?></td>
                                    <td><?= number_format($row->nominal_retur) ?></td>
                                </tr>
                            <?php $no++;
                                $total_retur += $row->nominal_retur;
                            endforeach; ?>
                        </tbody>
                    </table>
                    <h4 class="text-right">Total : <?= number_format($total_retur) ?></h4> <br>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($pelunasanPendanaan) : ?>
            <hr>
            <div class="card-body">
                <div class="text-center">
                    <h3>Histori Pelunasan Pendanaan</h3>
                </div>
                <div class="table-responsive m-t-5">
                    <table class="table color-table info-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User Id</th>
                                <th>Nama Pendana</th>
                                <th>No Rekening</th>
                                <th>No Virtual Account </th>
                                <th style="width: 100px">Tgl Pelunasan</th>
                                <th>Nominal</th>
                                <th>Nisbah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            $total_pelunasan = 0;
                            $total_nisbah = 0;
                            foreach ($pelunasanPendanaan as $row) : ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $row->user_id ?></td>
                                    <td><a href="<?= base_url('data_pendana/detail') ?>/<?= $row->id_pendana ?>"><?= $row->full_name ?></a></td>
                                    <td><?= $row->bank_number ?></td>
                                    <td><?= $row->nomor_va ?></td>
                                    <td><?= $row->return_ts ?></td>
                                    <td><?= number_format($row->nominal_retur) ?></td>
                                    <td><?= number_format($row->keuntungan) ?></td>
                                </tr>
                            <?php $no++;
                                $total_pelunasan += $row->nominal_retur;
                                $total_nisbah += $row->keuntungan;
                            endforeach; ?>
                        </tbody>
                    </table>
                    <h4 class="text-right">Total : <?= number_format($total_pelunasan) ?></h4> <br>
                    <h4 class="text-right">Total Nisbah : <?= number_format($total_nisbah) ?></h4>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>