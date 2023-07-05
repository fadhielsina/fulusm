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



    function hitung_lot() {

        var jumlah_lot = document.getElementById('jumlah_lot').value;

        var modal_project = document.getElementById('modal_project').value.replace(/[$,]+/g, "");

        var hasil = parseInt(modal_project) / parseInt(jumlah_lot);

        if (!isNaN(hasil)) {

            document.getElementById('harga_perlot').value = hasil.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

        } else {

            document.getElementById('harga_perlot').value = modal_project.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

        }

    }



    function hitung_pembagian() {

        var hasil_pendana = document.getElementById('pem_pendana').value;

        var hasil = 100 - parseInt(hasil_pendana);

        document.getElementById('pem_peminjam').value = hasil;

    }



    function jenis() {

        var jenis = document.getElementById('jenis_pengembalian').value;

        var mydiv = document.getElementById('tambahan');

        if (jenis == 0) {

            mydiv.innerHTML = "<label>Tanggal Jatuh Tempo</label><input type='date' min='<?= date('Y-m-d', strtotime('+' . $user_data->tenor . 'day')); ?>' value='<?= date('Y-m-d', strtotime('+' . $user_data->tenor . 'day')); ?>' id='tgl_pengembalian' name='tgl_pengembalian' class='form-control'><small class='text-danger'> <?= form_error('tgl_pengembalian'); ?> </small>"

        }

        if (jenis == 1) {

            mydiv.innerHTML = "<label>Jenis Angsuran</label><select class='form-control' id='jatuh_tempo' name='jatuh_tempo'><option disabled selected>Pilih Jenis Angsuran</option><option value='1'>1 Bulan</option><option value='2'>2 Bulan</option><option value='3'>3 Bulan</option><option value='4'>4 Bulan</option><option value='5'>5 Bulan</option><option value='6'>6 Bulan</option><option value='7'>7 Bulan</option><option value='8'>8 Bulan</option><option value='9'>9 Bulan</option><option value='10'>10 Bulan</option><option value='12'>12 Bulan</option></select><small class='text-danger'> <?= form_error('jatuh_tempo'); ?> </small>"

        }

    }
</script>



<div class="card">
    <h1><a href="<?= base_url('project_retail/') ?>"><i class="mdi mdi-chevron-double-left float-right"></i></a></h1>
    <div class="card-body pt-0">
        <div class="container">
            <h4 class="mb-4">Project Retail : <?= $project_id ?></h4>
            <div class="row mb-4">
                <div class="col">
                    <label>Nama Peminjam</label>
                    <h5><?= $user_data->name ?></h5>
                </div>

                <div class="col">
                    <label>Nama Toko</label>
                    <h5><?= $user_data->nama_toko ?></h5>
                </div>

                <div class="col">
                    <label>Alamat Toko</label>
                    <h5><?= $user_data->alamat_toko ?> Hari</h5>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col">
                    <label>Tenor Pinjam</label>
                    <h5><?= $user_data->tenor ?> Hari</h5>
                </div>
                <div class="col">
                    <label>Score Project</label>
                    <?php if ($score) { ?>
                        <h5><?= $score[0]->hasil_scoring ?></h5>
                    <?php } else { ?>
                        <h5>0</h5>
                    <?php } ?>
                </div>
                <div class="col">
                    <label>Status Project</label>
                    <h5><?= $user_data->nama_status ?></h5>
                </div>
            </div>

            <?php $cek = "readonly";
            $cek_select = "disabled";

            if ($trx_project) {
                $rating = $trx_project->rating;
                $jumlah_lot = number_format($trx_project->jumlah_lot);
                $harga_perlot = number_format($trx_project->harga_perlot);
                $modal_project = number_format($trx_project->modal_project);
                $estimasi = $trx_project->estimasi_keuntungan;
                $mitra = $this->db->get_where('trx_project_retail', ['id_project' => $project_id])->row()->mitra;
            }

            if ($stat_project->edit_st == "0" && $formProject == null) {
                $cek = "";
                $cek_select = "";
                $rating = $grade->id;
                $jumlah_lot = 1;
                $harga_perlot = number_format($user_data->jumlah_pinjaman);
                $modal_project = number_format($user_data->jumlah_pinjaman);
                $estimasi = 1.3;
                $mitra = '';
            }
            ?>

            <form action="<?= base_url('project_retail/form_project') ?>/<?= $project_id ?>" method="post">
                <input type="hidden" name="id" value="<?= $project_id ?>">
                <input type="hidden" name="nama_peminjam" value="<?= $user_data->name ?>">
                <input type="hidden" name="nama_project" value="Project Retail">
                <input type="hidden" name="tenor" value="<?= $user_data->tenor ?>">
                <input type="hidden" name="id_peminjam" value="<?= $user_data->user_id ?>">

                <div class="row mb-4">
                    <div class="col">
                        <label>Rating ( 1 - 5 ) </label>
                        <h5><input class="form-control" <?= $cek ?> type="text" onkeyup="formatNumber(this);" name="rating" value="<?= $rating ?>"></h5>
                    </div>
                    <div class="col">
                        <label>Jumlah Lot</label>
                        <h5><input class="form-control" <?= $cek ?> type="number" min="1" max="5" onkeyup="hitung_lot(); if(this.value>5){alert('Maksimal 5');this.value='';}" name="jumlah_lot" id="jumlah_lot" value="<?= $jumlah_lot ?>"></h5>
                    </div>
                    <div class="col">
                        <label>Harga PerLot</label>
                        <h5><input class="form-control" <?= $cek ?> type="text" onkeyup="formatNumber(this);" name="harga_perlot" id="harga_perlot" value="<?= $harga_perlot ?>"></h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Modal Project</label>
                        <h5><input class="form-control" <?= $cek ?> type="text" onkeyup="formatNumber(this);hitung_lot()" name="modal_project" id="modal_project" value="<?= $modal_project ?>">
                        </h5>
                    </div>
                    <div class="col">
                        <label>Estimasi Keuntungan Project (%)</label>
                        <h5><input class="form-control" <?= $cek ?> type="text" name="keuntungan" value="<?= $estimasi ?>"></h5>
                    </div>
                    <div class="col">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class=" form-group col">
                        <label>Mitra</label>
                        <?php if ($cek_select == "") : ?>
                            <select class="form-control" <?= $cek_select ?> name="mitra" id="mitra">
                                <option disabled selected>Pilih Mitra</option>
                                <?php foreach ($list_mitra as $key) : ?>
                                    <option value="<?= $key->id_koperasi ?>"><?= $key->nama_koperasi ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else : ?>
                            <input type="text" class="form-control" <?= $cek ?> name="mitra" id="mitra" value="<?= $mitra ?>">
                        <?php endif; ?>
                        <small class="text-danger"> <?= form_error('mitra'); ?> </small>
                    </div>

                    <div class="form-group col">
                        <label>ID Anggota</label>
                        <input type="text" class="form-control" readonly name="id_anggota" id="id_anggota" value="<?= $user_data->id_anggota ?>">
                        <small class="text-danger"> <?= form_error('id_anggota'); ?> </small>
                    </div>
                </div>
                <?php if ($cek == "") : ?>
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Jenis Pendanaan</label>
                            <select class="form-control" id="tipe" name="tipe">
                                <option disabled selected>Pilih Jenis</option>
                                <option value="1">Muddharabah</option>
                                <option value="2">Musyarakah</option>
                                <option value="3">Murabahah</option>
                            </select>
                            <small class="text-danger"> <?= form_error('tipe'); ?> </small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col">
                            <label>Jenis Pengembalian</label>
                            <select class="form-control" name="jenis_pengembalian" id="jenis_pengembalian" onchange="jenis();">
                                <option disabled selected>Pilih Jenis</option>
                                <option value="0">Di Akhir</option>
                                <option value="1">Per Bulan</option>
                            </select>
                            <small class="text-danger"> <?= form_error('jenis_pengembalian'); ?> </small>
                        </div>
                        <div class="form-group col" id="tambahan">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label>Note</label>
                            <textarea class="form-control" id="note" name="note" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-2">
                            <button type="submit" class="btn btn-block btn-outline-secondary" onclick="return confirm('Approve project ini?')">Approve</button>
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-block btn-danger" name="reject" onclick="return confirm('Anda akan reject project ini?')">Reject Project</button>
                        </div>
                    </div>
                <?php endif ?>
            </form>
        </div>
    </div>
</div>