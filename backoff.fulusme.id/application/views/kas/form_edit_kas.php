<?php
$nama_akun = $this->db->get_where('akun', ['id' => $jurnal_detail->akun_id])->row();
?>
<?= form_open("jurnal/edit_detail_kas") ?>
<div class="form-group row">
    <input type="hidden" id="id_jrnl_detail" name="id_jrnl_detail" value="<?= $id ?>">
    <input type="hidden" name="invoice" id="invoice" value="<?= $no_invoice->invoice_no ?>">
    <input type="hidden" name="jenis" id="jenis" value="<?= $jurnal_detail->debit_kredit ?>">
    <input type="hidden" name="nilai_default" id="nilai_default" value="<?= $jurnal_detail->nilai ?>">

    <label for="staticEmail" class="col-sm-2 col-form-label">Akun</label>
    <div class="col-sm-10">
        <select class="form-control" name="akun" id="akun">
            <option selected value="<?= $jurnal_detail->akun_id ?>"> <?= $nama_akun->nama ?> </option>
            <?php foreach ($akun as $row) : ?>
                <option value="<?= $row->id ?>"><?= $row->nama ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Nilai</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="nilai" name="nilai" onkeyup="formatNumber(this);" value="<?= number_format($jurnal_detail->nilai) ?>">
    </div>
</div>
<div class="text-center">
    <button type="submit" class="btn btn-primary">Save Edit</button>
</div>
<?= form_close() ?>

<script>
    function formatNumber(input) {
        var num = input.value.replace(/\,/g, '');
        if (!isNaN(num)) {
            if (num.indexOf('.') > -1) {
                num = num.split('.');
                num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1,').split('').reverse().join('').replace(/^[\,]/, '');
                if (num[1].length > 2) {
                    alert('You may only enter two decimals!');
                    num[1] = num[1].substring(0, num[1].length - 1);
                }
                input.value = num[0] + '.' + num[1];
            } else {
                input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1,').split('').reverse().join('').replace(/^[\,]/, '')
            };
        } else {
            alert('Anda hanya diperbolehkan memasukkan angka!');
            input.value = input.value.substring(0, input.value.length - 1);
        }
    }
</script>