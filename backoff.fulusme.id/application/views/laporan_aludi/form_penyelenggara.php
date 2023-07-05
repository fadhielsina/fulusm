<br>
<div class="post-body">
    <?php echo $this->session->flashdata('message'); ?>
    <h3><?= $title ?></h3>
    <div class="card">
        <form method="post" action="<?= base_url('aludi/penyelenggara_pulling') ?>">
            <div class="container mt-3">
                <?php $i = 0;
                foreach ($field['label'] as $label) : ?>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><?= $label ?></label>
                        <div class="col-sm-10">
                            <input class="form-control" type="<?= $field['type_form'][$i] ?>" id="<?= $field['idname'][$i] ?>" name="<?= $field['idname'][$i] ?>" required>
                        </div>
                    </div>
                <?php $i++;
                endforeach; ?>
                <div class="col">
                    <button type="submit" class="btn btn-success mb-3 float-right">Simpan</button>
                    <a href="<?= base_url('aludi/penerbit') ?>" class="btn btn-primary mb-3 float-left">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>