<br>

<div class="post-body">

    <h3><?= $title ?></h3>

    <div class="card">

        <form method="post" action="<?= base_url('mitra/insert') ?>">

            <div class="container mt-3">

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label">ID Koperasi / Mitra</label>

                    <div class="col-sm-10">

                        <input class="form-control" type="text" id="id_mitra" name="id_mitra" required>

                    </div>

                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label">Nama Koperasi / Mitra</label>

                    <div class="col-sm-10">

                        <input class="form-control" type="text" id="nama_mitra" name="nama_mitra" required>

                    </div>

                </div>

                <div class="col">

                    <button type="submit" class="btn btn-success mb-3 float-right">Simpan</button>

                    <a href="<?= base_url('mitra/') ?>" class="btn btn-primary mb-3 float-left">Kembali</a>

                </div>

            </div>

        </form>

    </div>

</div>