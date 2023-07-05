<br>
<div class="col-lg-12">
    <?php
    if ($this->session->userdata('SUCCESSMSG')) {
        echo "<div class='success'>" . $this->session->userdata('SUCCESSMSG') . "</div>";
        $this->session->unset_userdata('SUCCESSMSG');
    }
    ?>
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><?= $title ?></h4>
            <?= form_open('kas/rekonsiliasi'); ?>
            <div class="row">
                <div class="col-3">
                    <label>Kas / Bank</label>
                    <select class="form-control" name="akun" id="akun" required>
                        <option disabled selected value="">Cari dan Pilih</option>
                        <?php foreach ($all_kas as $row) : ?>
                            <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-3">
                    <label> Tanggal </label>
                    <input class="form-control" type="date" id="tgl1" name="tgl1" value="<?= date('Y-m-01'); ?>">
                </div>
                <div class="col-3">
                    <label> Tanggal </label>
                    <input class="form-control" type="date" id="tgl2" name="tgl2" value="<?= date('Y-m-d'); ?>">
                </div>
                <div class="col-1">
                    <label>Filter</label>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">REKENING BANK</h4>
                    <!-- ============================================================== -->
                    <!-- To do list widgets -->
                    <!-- ============================================================== -->
                    <?= form_open('kas/upload_csv_bank') ?>
                    <div class="to-do-widget mt-3 common-widget">
                        <div class="card">
                            <label for="input-file-now" class="text-center">Import File</label>
                            <input type="file" id="input-file-now" class="dropify" />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger">Import</button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <button class="float-right btn btn-sm btn-success" type="submit">Balanced & Save</button>
                    <h4 class="card-title">JURNAL SURPLUS</h4>
                    <!-- ============================================================== -->
                    <!-- To do list widgets -->
                    <!-- ============================================================== -->
                    <?= form_open('kas/rekonsiliasi_save') ?>
                    <div class="to-do-widget mt-3 common-widget">
                        <ul class="list-task todo-list list-group mb-0" data-role="tasklist">
                            <?php $saldo_total = 0;
                            if ($histori_data) : ?>
                                <?php foreach ($histori_data as $row) : ?>
                                    <li class="list-group-item border-0 mb-0 py-3 pr-3 pl-0" data-role="task">
                                        <div class="checkbox checkbox-info w-100">
                                            <input type="checkbox" id="inputBook" name="inputCheckboxesBook">
                                            <label for="inputBook" class=""> <span><?= $row->no_trx_kas ?></span> <span> ( <?= $row->tgl_catat ?> ) </span>
                                            </label>
                                        </div>
                                        <div class="font-12 pl-3 d-inline-block ml-2"> <?= number_format($row->jumlah) ?></div>
                                    </li>
                                    <?php $saldo_total += $row->jumlah ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                        <div class="text-center">
                            <h4>Total <span><?= number_format($saldo_total) ?></span></h4>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Row -->
</div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#table_bank').DataTable({
            "order": [
                [0, "asc"]
            ]
        });

        $('#table_bank tbody').on('click', 'tr', function() {
            var data = table.row(this).data();
            location.replace("<?= base_url('Kas/detail_data_in/') ?>" + data[0])
        });
    });
</script>