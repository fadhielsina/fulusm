<script>
    function formatNumber(input) {

        var num = input.value.replace(/\,/g, '');

        if (!isNaN(num)) {

            if (num.indexOf('.') > -1) {

                num = num.split('.');

                num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1,').split('')

                    .reverse().join('').replace(/^[\,]/, '');

                if (num[1].length > 2) {

                    alert('You may only enter two decimals!');

                    num[1] = num[1].substring(0, num[1].length - 1);

                }

                input.value = num[0] + '.' + num[1];

            } else {

                input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1,').split('')

                    .reverse().join('').replace(/^[\,]/, '')

            };

        } else {

            alert('Anda hanya diperbolehkan memasukkan angka!');

            input.value = input.value.substring(0, input.value.length - 1);

        }

    }
</script>



<?php

$readonly = "readonly";

$query = $this->db->get_where('trx_jatuh_tempo', ['id_project' => $jurnal_data->id_project])->row();

$proJ = $this->db->get_where('trx_project', ['id_project' => $jurnal_data->id_project])->row();

$harga_perlot = $this->db->get_where('history_project', ['id' => $jurnal_data->id_project])->row()->harga_perlot;
$total_lot = $this->db->get_where('history_project', ['id' => $jurnal_data->id_project])->row()->jumlah_lot;

if (!$harga_perlot) {
    $harga_perlot = $this->db->get_where('trx_project_retail', ['id_project' => $jurnal_data->id_project])->row()->harga_perlot;
    $total_lot = $this->db->get_where('trx_project_retail', ['id_project' => $jurnal_data->id_project])->row()->jumlah_lot;
}

if ($query) {

    // $untung = $jurnal_data->nominal * ($proJ->lender / 100) * ($proJ->persentasi_keuntungan / 100);

    $p1 = $proJ->dana_nisbah / $total_lot;

    $p2 = $harga_perlot / $jurnal_data->nominal;

    $untung = $p1 * $p2;
} else {

    $untung = 0;
}

if (!$total_dibayar) {

    $tot_bayar = 0;
} else {

    $tot_bayar = $total_dibayar->nominal;
}

if ($jurnal_data->nominal > $tot_bayar) {

    $readonly = "";
} ?>



<div class="card">

    <h1><a href="<?= base_url('purchasing/purchasing_utang') ?>"><i class="mdi mdi-chevron-double-left float-right"></i></a></h1>

    <div class="card-body">

        <h3 class="text-center"><?= $title ?> <i><?= $jurnal_data->nama_project ?></i></h3>

        <div class="card-body">

            <hr>

            <div class="mb-5">

                <form action="<?= base_url('purchasing/debt_payment') ?>/<?= $id ?>" method="post">

                    <input type="hidden" id="id_user" name="id_user" value="<?= $jurnal_data->id_pendana ?>">

                    <input type="hidden" id="nama_user" name="nama_user" value="<?= $jurnal_data->full_name ?>">

                    <input type="hidden" id="id_project" name="id_project" value="<?= $jurnal_data->id_project ?>">

                    <input type="hidden" id="nama_project" name="nama_project" value="<?= $jurnal_data->nama_project ?>">

                    <input type="hidden" id="no_invoice" name="no_invoice" value="<?= $jurnal_data->no_invoice ?>">

                    <input type="hidden" id="nomor_va" name="nomor_va" value="<?= $jurnal_data->nomor_va ?>">

                    <input type="hidden" id="status" name="status" value="<?= $jurnal_data->status ?>">

                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <h5 class="text-center">

                                <li class="list-group-item list-group-item-primary">ID Customer</li>

                            </h5>

                            <h5 class="text-center"><?= $jurnal_data->id_pendana ?></h5>

                        </div>

                        <div class="form-group col-md-6">

                            <h5 class="text-center">

                                <li class="list-group-item list-group-item-primary">Nama Customer</li>

                            </h5>

                            <h5 class="text-center"><?= $jurnal_data->full_name ?></h5>

                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <h5 class="text-center">

                                <li class="list-group-item list-group-item-primary">Nomor Bank</li>

                            </h5>

                            <h5 class="text-center"><?= $jurnal_data->bank_number ?></h5>

                        </div>

                        <div class="form-group col-md-6">

                            <h5 class="text-center">

                                <li class="list-group-item list-group-item-primary">Jumlah</li>

                            </h5>

                            <h5 class="text-center"><?= number_format($jurnal_data->nominal) ?></h5>

                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <h5 class="text-center">

                                <li class="list-group-item list-group-item-primary">Nilai Pengembalian</li>

                            </h5>

                            <input type="text" class="form-control" <?= $readonly ?> id="nominal" name="nominal" onkeyup="formatNumber(this);" placeholder="Masukan Nominal">

                            <small class="text-danger"> <?= form_error('nominal'); ?> </small>

                        </div>

                        <div class="form-group col-md-6">

                            <div class="row">

                                <div class="col">

                                    <h5 class="text-center">

                                        <li class="list-group-item list-group-item-primary">Nilai Nisbah</li>

                                    </h5>

                                    <input type="text" class="form-control text-center" <?= $readonly ?> id="keuntungan" name="keuntungan" onkeyup="formatNumber(this);" value="<?= number_format($untung) ?>">

                                    <small class="text-danger"> <?= form_error('keuntungan'); ?> </small>

                                </div>

                                <div class="col">

                                    <h5 class="text-center">

                                        <li class="list-group-item list-group-item-primary">Total Nisbah</li>

                                    </h5>

                                    <h5 class="text-center"><?= number_format($proJ->dana_nisbah) ?></h5>

                                </div>

                            </div>

                        </div>

                    </div>

                    <?php if ($jurnal_data->nominal > $tot_bayar) : ?>

                        <button class="btn btn-primary waves-effect waves-light float-right" onclick="return confirm('Periksa nominal!')" type="submit">Bayar</button>

                </form>

            <?php endif; ?>

            </div>

        </div>

    </div>

</div>