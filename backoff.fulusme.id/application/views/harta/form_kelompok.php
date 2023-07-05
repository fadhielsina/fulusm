<br />
<div class="post-title col-lg-12">
    <h3 class="pull-left"><i class="fa fa-windows"></i> <?php echo $title; ?></h3>
</div>

<div class="post-body">
    <br /><br />
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <?php if ($tipe == 'add') : ?>
                    <div class="container">
                        <?= form_open('harta/form_insert') ?>
                        <div class="form-group row" style="margin-bottom: 10px;">
                            <label class="col-sm-2 col-form-label">Kode</label>
                            <div class="col">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="AUTO">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Kelompok</label>
                                    <div class="col">
                                        <input type=" text" class="form-control" required id="nama_kelompok" name="nama_kelompok">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Umur Ekonomis</label>
                                    <div class="col">
                                        <input type="number" class="form-control" required id="umur_ekonomis" name="umur_ekonomis">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Keterangan</label>
                                    <div class="col">
                                        <textarea class="form-control" required id="keterangan" name="keterangan" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Metode Depresiasi</label>
                                    <div class="col">
                                        <select id="metode_depresiasi" name="metode_depresiasi" class="form-control" required>
                                            <option selected disabled>Pilih Metode ...</option>
                                            <option value="Metode Saldo Menurun">Metode Saldo Menurun </option>
                                            <option value="Metode Garis Lurus">Metode Garis Lurus</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Akun
                                        <br> Harta</label>
                                    <div class="col">
                                        <select id="akun_harta" name="akun_harta" class="form-control" required>
                                            <option selected disabled>Cari Akun ...</option>
                                            <?php foreach ($akun as $row) : ?>
                                                <option value="<?= $row->id ?>"><?= $row->kode ?> - <?= $row->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Akun Akumulasi</label>
                                    <div class="col">
                                        <select id="akun_akumulasi" name="akun_akumulasi" class="form-control" required>
                                            <option selected disabled>Cari Akun ...</option>
                                            <?php foreach ($akun as $row) : ?>
                                                <option value="<?= $row->id ?>"><?= $row->kode ?> - <?= $row->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Akun Depresiasi</label>
                                    <div class="col">
                                        <select id="akun_depresiasi" name="akun_depresiasi" class="form-control" required>
                                            <option selected disabled>Cari Akun ...</option>
                                            <?php foreach ($akun as $row) : ?>
                                                <option value="<?= $row->id ?>"><?= $row->kode ?> - <?= $row->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <a class="btn default" name="cancel" href="<?= base_url('harta/kelompok_harta') ?>"><i class="m-icon-swapleft"></i> Kembali</a> <button type="submit" class="btnsave btn btn-primary" name="save"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                <?php else : ?>
                    <div class="container">
                        <?= form_open("harta/form_edit/$id") ?>
                        <div class="form-group row" style="margin-bottom: 10px;">
                            <label class="col-sm-2 col-form-label">Kode</label>
                            <div class="col">
                                <input type="text" readonly class="form-control-plaintext" id="kode" name="kode" value="<?= $data_harta->kode ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Kelompok</label>
                                    <div class="col">
                                        <input type=" text" class="form-control<?= $tipe2 ?>" required <?= $read ?> value="<?= $data_harta->nama_kelompok ?>" id="nama_kelompok" name="nama_kelompok">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Umur Ekonomis</label>
                                    <div class="col">
                                        <input type="number" class="form-control<?= $tipe2 ?>" required <?= $read ?> value="<?= $data_harta->umur ?>" id="umur_ekonomis" name="umur_ekonomis">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Keterangan</label>
                                    <div class="col">
                                        <input type="text" class="form-control<?= $tipe2 ?>" required <?= $read ?> value="<?= $data_harta->keterangan ?>" id="keterangan" name="keterangan">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Metode Depresiasi</label>
                                    <div class="col">
                                        <select id="metode_depresiasi" name="metode_depresiasi" class="form-control<?= $tipe2 ?>" <?= $dis ?> <?= $read ?> required>
                                            <option selected value="<?= $data_harta->metode ?>"><?= $data_harta->metode ?></option>
                                            <option value="Metode Saldo Menurun">Metode Saldo Menurun </option>
                                            <option value="Metode Garis Lurus">Metode Garis Lurus</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Akun
                                        <br> Harta</label>
                                    <div class="col">
                                        <select id="akun_harta" name="akun_harta" class="form-control<?= $tipe2 ?>" <?= $dis ?> <?= $read ?> required>
                                            <option selected value="<?= $akun_h->id ?>"><?= $akun_h->kode ?> - <?= $akun_h->nama ?></option>
                                            <?php foreach ($akun as $row) : ?>
                                                <option value="<?= $row->id ?>"><?= $row->kode ?> - <?= $row->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Akun Akumulasi</label>
                                    <div class="col">
                                        <select id="akun_akumulasi" name="akun_akumulasi" class="form-control<?= $tipe2 ?>" <?= $dis ?> <?= $read ?> required>
                                            <option selected value="<?= $akun_a->id ?>"><?= $akun_a->kode ?> - <?= $akun_a->nama ?></option>
                                            <?php foreach ($akun as $row) : ?>
                                                <option value="<?= $row->id ?>"><?= $row->kode ?> - <?= $row->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Akun Depresiasi</label>
                                    <div class="col">
                                        <select id="akun_depresiasi" name="akun_depresiasi" class="form-control<?= $tipe2 ?>" <?= $dis ?> <?= $read ?> required>
                                            <option selected value="<?= $akun_d->id ?>"><?= $akun_d->kode ?> - <?= $akun_d->nama ?></option>
                                            <?php foreach ($akun as $row) : ?>
                                                <option value="<?= $row->id ?>"><?= $row->kode ?> - <?= $row->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <a class="btn default" name="cancel" href="<?= base_url('harta/kelompok_harta') ?>"><i class="m-icon-swapleft"></i> Kembali</a>
                            <?php if ($tipe == 'edit') : ?>
                                <button type="submit" class="btnsave btn btn-primary" name="save"><i class="fa fa-save"></i> Simpan</button>
                            <?php endif; ?>
                        </div>
                        <?= form_close() ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>