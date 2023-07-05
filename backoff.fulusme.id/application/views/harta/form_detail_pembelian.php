<div class="form-group row" style="margin-bottom: 10px;">
    <label class="col-sm-3 col-form-label">Kode</label>
    <div class="col">
        <input type="text" readonly class="form-control-plaintext" id="kode" value="AUTO">
    </div>
</div>
<div class="form-group row" style="margin-bottom: 10px;">
    <label class="col-sm-3 col-form-label">Nama</label>
    <div class="col">
        <input type="text" class="form-control" id="nama_detail" name="nama_detail" required>
    </div>
</div>
<div class="form-group row" style="margin-bottom: 10px;">
    <label class="col-sm-3 col-form-label">Kelompo Aset Tetap</label>
    <div class="col">
        <select id="kelompok_detail" name="kelompok_detail" class="form-control" style="width: 335px;" required>
            <option selected disabled>Kelompok ...</option>
            <?php foreach ($kelompok_harta as $row) : ?>
                <option value="<?= $row->id ?>">(<?= $row->kode ?>) <?= $row->nama_kelompok ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row" style="margin-bottom: 10px;">
    <label class="col-sm-3 col-form-label">Tipe Harta Tetap</label>
    <div class="col">
        <select id="tipe_harta" name="tipe_harta" class="form-control" style="width: 335px;" required>
            <option selected disabled>Cari Tipe ...</option>
            <option value="1">Berwujud</option>
            <option value="2">Tidak Berwujud</option>
        </select>
    </div>
</div>
<div class="form-group row" style="margin-bottom: 10px;">
    <label class="col-sm-3 col-form-label">Lokasi</label>
    <div class="col">
        <input type="text" class="form-control" id="lokasi_detail" name="lokasi_detail" required>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Keterangan</label>
    <div class="col">
        <textarea class="form-control" required id="keterangan_detail" name="keterangan_detail" rows="4"></textarea>
    </div>
</div>