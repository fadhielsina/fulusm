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

<br>
<div class="post-body">
    <?php echo $this->session->flashdata('message'); ?>
    <h3><?= $title ?></h3>
    <div class="card">
        <form method="post" action="<?= base_url('aludi/penerbit_create') ?>">
            <div class="container mt-3">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Owner</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="owner" name="owner" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nomor Telepon</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" placeholder="Masukan nomor tlp tanpa angka 0 / +62 didepan" id="nomor_tlp" name="nomor_tlp" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="email" name="email" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Perusahaan</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="nama_perusahaan" name="nama_perusahaan" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Brand</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="nama_brand" name="nama_brand" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Bidang Usaha</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="bidang_usaha" name="bidang_usaha" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Total Pendanaan</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="total_pendanaan" onkeyup="formatNumber(this)" name="total_pendanaan" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="status" name="status">
                            <?php foreach ($aludi_status as $stat) : ?>
                                <option value="<?= $stat->id_status ?>"><?= $stat->status_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="deskripsi" name="deskripsi" required>
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