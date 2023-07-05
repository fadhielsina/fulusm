<br>
<div class="post-body">
    <h3><?= $title ?></h3>
    <div class="card">
        <form method="post" action="<?= base_url('sales/edit') ?>">
            <input class="form-control" type="hidden" id="id" name="id" value="<?= $id ?>">
            <small class="text-danger"> <?= form_error('id'); ?> </small>
            <div class="container mt-3">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Depan</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="nama_depan" name="nama_depan" value="<?= $sales->nama_depan ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Belakang</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="nama_belakang" name="nama_belakang" value="<?= $sales->nama_belakang ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No HP</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="no_hp" name="no_hp" value="<?= $sales->no_hp ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No KTP</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" id="no_ktp" name="no_ktp" value="<?= $sales->no_ktp ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="alamat" name="alamat" value="<?= $sales->alamat ?>" required>
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary mb-3 float-right">Simpan</button>
                    <a href="<?= base_url('sales/') ?>" class="btn btn-primary mb-3 float-left">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>