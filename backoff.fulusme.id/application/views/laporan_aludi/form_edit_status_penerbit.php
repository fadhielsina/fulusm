<br>
<div class="post-body">
    <?php echo $this->session->flashdata('message'); ?>
    <h3><?= $title ?></h3>
    <div class="card">
        <form method="post" action="<?= base_url('aludi/penerbit_update_status') ?>">
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
                        <input class="form-control" type="text" readonly id="owner" name="owner" value="<?= $penerbit->owner ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nomor Telepon</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" readonly id="nomor_tlp" name="nomor_tlp" value="<?= $penerbit->nomor_telepon ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" readonly id="email" name="email" value="<?= $penerbit->email ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Total Pendanaan</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" readonly id="total_pendanaan" name="total_pendanaan" value="<?= $penerbit->total_pendanaan ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="status" name="status">
                            <option value="<?= $penerbit->id_status ?>"><?= $penerbit->status_name ?></option>
                            <?php foreach ($aludi_status as $stat) : ?>
                                <?php if ($penerbit->id_status != $stat->id_status) : ?>
                                    <option value="<?= $stat->id_status ?>"><?= $stat->status_name ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
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