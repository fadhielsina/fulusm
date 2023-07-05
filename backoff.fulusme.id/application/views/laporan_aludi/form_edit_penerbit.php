<br>
<div class="post-body">
    <?php echo $this->session->flashdata('message'); ?>
    <h3><?= $title ?></h3>
    <div class="card">
        <form method="post" action="<?= base_url('aludi/penerbit_update') ?>">
            <div class="container mt-3">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kode</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" readonly id="kode" name="kode" value="<?= $penerbit->kode ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Owner</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="owner" name="owner" value="<?= $penerbit->owner ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nomor Telepon</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" id="nomor_tlp" name="nomor_tlp" value="<?= $penerbit->nomor_telepon ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="email" name="email" value="<?= $penerbit->email ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Perusahaan</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="nama_perusahaan" name="nama_perusahaan" value="<?= $penerbit->nama_perusahaan ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Brand</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="nama_brand" name="nama_brand" value="<?= $penerbit->nama_brand ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Bidang Usaha</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="bidang_usaha" name="bidang_usaha" value="<?= $penerbit->bidang_usaha ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Total Pendanaan</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" id="total_pendanaan" name="total_pendanaan" value="<?= $penerbit->total_pendanaan ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-7">
                        <input class="form-control" type="text" readonly value="<?= $penerbit->status_name ?>" required>
                        <input class="form-control" type="hidden" readonly id="status" name="status" value="<?= $penerbit->status ?>" required>
                    </div>
                    <div class="col-sm-3">
                        <a class="btn btn-sm waves-effect waves-light btn-rounded btn-info" href="<?= site_url('aludi/penerbit_edit_status/') . $penerbit->kode ?>">Edit</a>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="deskripsi" name="deskripsi" value="<?= $penerbit->deskripsi ?>" required>
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-success mb-3 float-right">Simpan</button>
                    <a href="<?= base_url('aludi/penerbit') ?>" class="btn btn-primary mb-3 float-left">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>