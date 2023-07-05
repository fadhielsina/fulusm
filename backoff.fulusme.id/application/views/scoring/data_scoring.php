<script>
    function hitung_skor() {
        var persent = document.getElementsByName('persent[]');
        var header_persent = document.getElementsByName('header_persent[]');
        var nilai = document.getElementsByName('nilai[]');

        var total = 0;
        var hasil_nilai_scoring = 0;

        for (var i = 0; i < persent.length; i++) {
            total += parseInt(nilai[i].value) * (parseInt(persent[i].value) / 100);
            hasil_nilai_scoring += total / header_persent.length;

            if (!isNaN(total)) {
                hasil = total.toFixed(2);
                document.getElementsByName('nilai-scoring[]')[i].value = hasil;
                document.getElementById('hasil_nilai_scoring').value = Math.round(hasil_nilai_scoring);
                total = 0;
            }
        }
    }

    function hitung() {
        var persent = document.getElementsByName('persent[]');
        // var scorring = document.getElementsByName('scorring[]');
        var nilai = document.getElementsByName('nilai[]');
        var nilai_scoring = document.getElementsByName('nilai-scoring[]');

        var hasil_persent = 0;
        // var hasil_scorring = 0;
        var hasil_nilai = 0;
        var hasil_nilai_scoring = 0;

        for (var i = 0, iLen = persent.length; i < iLen; i++) {
            hasil_persent += parseInt(persent[i].value);
            // hasil_scorring += parseInt(scorring[i].value);
            hasil_nilai += parseInt(nilai[i].value);
            hasil_nilai_scoring += parseInt(nilai_scoring[i].value);
        }
        if (!isNaN(hasil_persent)) {
            document.getElementById('hasil_persent').value = hasil_persent;
        }
        if (!isNaN(hasil_nilai)) {
            document.getElementById('hasil_nilai').value = hasil_nilai;
        }
    }
</script>

<?php if ($form_scoring != null) : ?>
    <form action="<?= base_url('project_retail/detail') ?>/<?= $id ?>" method="post">
    <?php else : ?>
        <form action="<?= base_url('project/project_detail') ?>/<?= $project_id ?>" method="post">
        <?php endif; ?>
        <input type="hidden" id="id_project" name="id_project" value="<?= $project_id ?>">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Jenis Tipe</label>
                <select class="form-control" id="tipe_id" name="tipe_id" onchange="this.form.submit()">
                    <option disabled selected>Pilih Tipe -- Waktu Periode Berlaku</option>
                    <?php foreach ($get_tipe as $row) : ?>
                        <option value="<?= $row['id'] ?>"><?= $row['nama_tipe'] ?> -- <?= $row['tgl_berlaku']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <a href="<?= base_url('scoring/addType') ?>" class="btn btn-primary" style="margin-top:31px;">Tambah Tipe</a>
            </div>
        </div>
        <?php if ($tipe) : ?>
            <h3 class="text-center"><?= $tipe->nama_tipe; ?></h3>
            <h5 class="text-center">Berlaku Hingga <?= $tipe->tgl_berlaku ?></h5>
        <?php endif; ?>
        <ul class="list-group">
            <?php foreach ($get_table_scoring as $row) : ?>
                <li class="list-group-item active"><?= $row['nama_detail_tipe'] ?>
                    <input type="hidden" name="header_persent[]" value="<?= $row['bobot_persent'] ?>">
                    <span class="float-right" style="margin-right:150px;"><?= $row['bobot_persent'] ?>%</span>
                </li>
                <?php
                $parent = $this->db->get_where('scr_sub_detail_tipe', ['detail_tipe_id' => $row['id']])->result_array();
                foreach ($parent as $column) : ?>
                    <li class="list-group-item">
                        <div class="form-row">
                            <div class="col-7 pt-2 pl-4" style="color:black;">
                                <?= $column['nama_sub_detail'] ?>
                                <input type="hidden" id="nama_detail_tipe" name="nama_detail_tipe[]" value="<?= $column['detail_tipe_id'] ?>">
                                <input type="hidden" class="form-control" id="nama_sub_detail" name="nama_sub_detail[]" value="<?= $column['nama_sub_detail'] ?>" style="border-width:0px; border:none; background-color:white; color:black;">
                            </div>
                            <div class="col">
                                <select class="form-control" id="persent" name="persent[]" onchange="hitung(); hitung_skor();" style="width:226px;">
                                    <option selected value="0">. . . Select . . .</option>
                                    <?php
                                    $sub_parent = $this->db->get_where('scr_faktor', ['sub_detail_tipe_id' => $column['id']])->result_array();
                                    foreach ($sub_parent as $sub_column) : ?>
                                        <option value="<?= $sub_column['score'] ?>"><?= $sub_column['nama_faktor'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control text-center" id="nilai" name="nilai[]" onchange="hitung(); hitung_skor();" readonly value="<?= $column['bobot_persent'] ?> %">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="nilai-scoring" name="nilai-scoring[]" onchange="hitung()" readonly placeholder="Scoring" value="0">
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <li class="list-group-item active">
                <div class="form-row">
                    <div class="col-6 mt-2">
                        <h3 class="ml-4" style="color:white;">Total</h3>
                    </div>
                    <div class="col">
                        <input type="hidden" id="hasil_persent" style="background-color:white;" readonly class="form-control text-center">
                    </div>
                    <div class="col">
                        <input type="text" id="hasil_nilai_scoring" name="hasil_nilai_scoring" style="background-color:white;" readonly class="form-control text-center">
                    </div>
                    <div class="col">
                        <input type="hidden" id="hasil_nilai" style="background-color:white;" readonly class="form-control text-center">
                    </div>
                </div>
            </li>
            <div class="mt-3">
                <div class="row">
                    <div class="col">
                    </div>
                    <div class="col">
                        <textarea class="form-control" placeholder="Berikan Note" id="note_score" name="note_score" rows="4"></textarea>
                    </div>
                </div>
                <button type="submit" name="submitscore" class="btn btn-primary float-right" onclick="return confirm('Finish Scoring?')">Submit Score</button>
            </div>
        </form>