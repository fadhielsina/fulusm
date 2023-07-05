<br>
<div class="post-body">
    <h3><?= $title ?></h3>
    <div class="card">
        <form method="post" action="<?= base_url('sales/insert') ?>">
            <div class="container mt-3">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Depan</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="nama_depan" name="nama_depan" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Belakang</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="nama_belakang" name="nama_belakang" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="username" name="username" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No HP</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="no_hp" name="no_hp" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No KTP</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" id="no_ktp" name="no_ktp" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="alamat" name="alamat" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="password" id="password1" name="password1">
                        <small class="text-danger"> <?= form_error('password1'); ?> </small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ulangi Password</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="password" id="password2" name="password2">
                        <small class="text-danger"> <?= form_error('password2'); ?> </small>
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-success mb-3 float-right">Simpan</button>
                    <a href="<?= base_url('sales/') ?>" class="btn btn-primary mb-3 float-left">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>