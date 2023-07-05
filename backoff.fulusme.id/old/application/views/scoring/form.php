<br />
<h4><input type="button" value="Back" class="btn btn-primary btn-sm" onclick="history.back()"></h4>
<div class="post-body">
  <div class="card">
    <div class="card-body">
      <h3 class="card-title"><?php echo $title; ?></h3>
      <form action="<?= base_url('scoring/addType') ?>" method="post">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Nama Tipe</label>
            <input type="text" class="form-control" id="nama_tipe" name="nama_tipe" placeholder="Nama Tipe" value="<?= set_value('nama_tipe'); ?>">
            <small class="text-danger"> <?= form_error('nama_tipe'); ?> </small>
          </div>
        </div>
        <input class="btn btn-primary" type="submit" name="tipe" value="Simpan">
      </form>
    </div>
  </div>
  <!-- Form 2  -->
  <div class="card">
    <div class="card-body">
      <h3 class="card-title">Tambah Detail Tipe</h3>
      <form action="<?= base_url('scoring/addDetailType') ?>" method="post">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Jenis Tipe</label>
            <select class="form-control" name="tipe_id">
              <option disabled selected>Pilih Tipe</option>
              <?php foreach ($get_tipe as $row) : ?>
              <option value="<?= $row['id'] ?>"><?= $row['nama_tipe'] ?></option>
              <?php endforeach; ?>
            </select>
            <small class="text-danger"> <?= form_error('tipe_id'); ?> </small>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Nama Detail Tipe</label>
            <input type="text" class="form-control" id="nama_detail_tipe" name="nama_detail_tipe[]" placeholder="Nama Detail Tipe" value="<?= set_value('nama_detail_tipe[]'); ?>">
            <small class="text-danger"> <?= form_error('nama_detail_tipe[]'); ?> </small>
          </div>
        </div>
        <div id="insert-form"></div>
        <div class="form-group col">
          <input class="btn btn-primary float-right" type="submit" name="detail" value="Simpan">
      </form>
      <button type="button" class="btn btn-success" id="btn-tambah-form">Tambah Baris</button>
      <button type="button" class="btn btn-danger" id="btn-reset-form">Reset</button>
    </div>
  </div>
</div>
<!-- Form 3  -->
<div class="post-body">
  <div class="card">
    <div class="card-body">
      <h3 class="card-title">Tambah Sub Detail Tipe</h3>
      <form action="<?= base_url('scoring/addSubDetail') ?>" method="post">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Jenis Detail Tipe</label>
            <select class="form-control" name="detail_tipe_id">
              <option disabled selected>Pilih Detail Tipe</option>
              <?php foreach ($get_detail as $row_detail) : ?>
              <option value="<?= $row_detail['id'] ?>"><?= $row_detail['nama_detail_tipe'] ?> - <?= $row_detail['nama_tipe'] ?> </option>
              <?php endforeach; ?>
            </select>
            <small class="text-danger"> <?= form_error('detail_tipe_id'); ?> </small>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Nama Sub Detail Tipe</label>
            <input type="text" class="form-control" id="nama_sub_detail" name="nama_sub_detail[]" placeholder="Nama Sub Detail Tipe" value="<?= set_value('nama_sub_detail[]'); ?>">
            <small class="text-danger"> <?= form_error('nama_sub_detail[]'); ?> </small>
          </div>
          <div class="form-group col-md-2">
            <label>Bobot Aspek</label>
            <input type="text" class="form-control" id="bobot_persent" name="bobot_persent[]" placeholder="%" value="<?= set_value('bobot_persent[]'); ?>">
            <small class="text-danger"> <?= form_error('bobot_persent[]'); ?> </small>
          </div>
        </div>
        <div id="insert-form-detail"></div>
        <div class="form-group col">
          <input class="btn btn-primary float-right" type="submit" name="detail" value="Simpan">
      </form>
      <button type="button" class="btn btn-success" id="btn-tambah-form-detail">Tambah Baris</button>
      <button type="button" class="btn btn-danger" id="btn-reset-form-detail">Reset</button>
    </div>
  </div>
</div>
<!-- Form 4 -->
<div class="card">
  <div class="card-body">
    <h3 class="card-title">Tambah Faktor Score</h3>
    <form action="<?= base_url('scoring/addFaktor') ?>" method="post">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Jenis Sub Detail Tipe</label>
          <select class="form-control" name="sub_detail_tipe_id">
            <option disabled selected>Pilih Sub Detail Tipe</option>
            <?php foreach ($get_sub_detail as $row_detail) : ?>
            <option value="<?= $row_detail['id'] ?>"><?= $row_detail['nama_sub_detail'] ?> - <?= $row_detail['nama_detail_tipe'] ?> </option>
            <?php endforeach; ?>
          </select>
          <small class="text-danger"> <?= form_error('sub_detail_tipe_id'); ?> </small>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Nama Faktor</label>
          <input type="text" class="form-control" id="nama_faktor" name="nama_faktor[]" placeholder="Nama Sub Detail Tipe" value="<?= set_value('nama_faktor[]'); ?>">
          <small class="text-danger"> <?= form_error('nama_faktor[]'); ?> </small>
        </div>
        <div class="form-group col-md-2">
          <label>Score</label>
          <input type="text" class="form-control" id="score" name="score[]" placeholder="0-100" value="<?= set_value('score[]'); ?>">
          <small class="text-danger"> <?= form_error('score[]'); ?> </small>
        </div>
      </div>
      <div id="insert-form-sub-detail"></div>
      <div class="form-group col">
        <input class="btn btn-primary float-right" type="submit" name="detail" value="Simpan">
    </form>
    <button type="button" class="btn btn-success" id="btn-tambah-form-sub-detail">Tambah Baris</button>
    <button type="button" class="btn btn-danger" id="btn-reset-form-sub-detail">Reset</button>
  </div>
</div>

<!-- Kita buat textbox untuk menampung jumlah data form -->
<input type="hidden" id="jumlah-form" value="1">

<script>
  $(document).ready(function() { // Ketika halaman sudah diload dan siap
    $("#btn-tambah-form").click(function() { // Ketika tombol Tambah Data Form di klik
      var jumlah = parseInt($("#jumlah-form").val()); // Ambil jumlah data form pada textbox jumlah-form
      var nextform = jumlah + 1; // Tambah 1 untuk jumlah form nya

      // Kita akan menambahkan form dengan menggunakan append
      // pada sebuah tag div yg kita beri id insert-form
      $("#insert-form").append("<div class='form-row'><div class='form-group col-md-6'><label>Nama Detail Tipe</label><input type='text' class='form-control' id='nama_detail_tipe' name='nama_detail_tipe[]' placeholder='Nama Detail Tipe' value='<?= set_value('nama_detail_tipe[]'); ?>'><small class='text-danger'> <?= form_error('nama_detail_tipe[]'); ?> </small></div></div>");

      $("#jumlah-form"); // Ubah value textbox jumlah-form dengan variabel nextform
    });

    // Buat fungsi untuk mereset form ke semula
    $("#btn-reset-form").click(function() {
      $("#insert-form").html(""); // Kita kosongkan isi dari div insert-form
      $("#jumlah-form").val("1"); // Ubah kembali value jumlah form menjadi 1
    });
  });
</script>

<script>
  $(document).ready(function() { // Ketika halaman sudah diload dan siap
    $("#btn-tambah-form-detail").click(function() { // Ketika tombol Tambah Data Form di klik
      var jumlah = parseInt($("#jumlah-form").val()); // Ambil jumlah data form pada textbox jumlah-form
      var nextform = jumlah + 1; // Tambah 1 untuk jumlah form nya

      // Kita akan menambahkan form dengan menggunakan append
      // pada sebuah tag div yg kita beri id insert-form
      $("#insert-form-detail").append("<div class='form-row'><div class='form-group col-md-6'><label>Nama Sub Detail Tipe</label><input type='text' class='form-control' id='nama_sub_detail' name='nama_sub_detail[]' placeholder='Nama Sub Detail Tipe' value='<?= set_value('nama_sub_detail[]'); ?>'><small class='text-danger'> <?= form_error('nama_sub_detail[]'); ?> </small></div><div class='form-group col-md-2'><label>Bobot Aspek</label><input type='text' class='form-control' id='bobot_persent' name='bobot_persent[]' placeholder='%' value='<?= set_value('bobot_persent[]'); ?>'><small class='text-danger'> <?= form_error('bobot_persent[]'); ?> </small></div></div>");

      $("#jumlah-form-detail"); // Ubah value textbox jumlah-form dengan variabel nextform
    });

    // Buat fungsi untuk mereset form ke semula
    $("#btn-reset-form-detail").click(function() {
      $("#insert-form-detail").html(""); // Kita kosongkan isi dari div insert-form
      $("#jumlah-form-detail").val("1"); // Ubah kembali value jumlah form menjadi 1
    });
  });
</script>

<script>
  $(document).ready(function() { // Ketika halaman sudah diload dan siap
    $("#btn-tambah-form-sub-detail").click(function() { // Ketika tombol Tambah Data Form di klik
      var jumlah = parseInt($("#jumlah-form").val()); // Ambil jumlah data form pada textbox jumlah-form
      var nextform = jumlah + 1; // Tambah 1 untuk jumlah form nya

      // Kita akan menambahkan form dengan menggunakan append
      // pada sebuah tag div yg kita beri id insert-form
      $("#insert-form-sub-detail").append("<div class='form-row'><div class='form-group col-md-6'><label>Nama Faktor</label><input type='text' class='form-control' id='nama_faktor' name='nama_faktor[]' placeholder='Nama Sub Detail Tipe' value='<?= set_value('nama_faktor[]'); ?>'><small class='text-danger'> <?= form_error('nama_faktor[]'); ?> </small></div><div class='form-group col-md-2'><label>Score</label><input type='text' class='form-control' id='score' name='score[]' placeholder='0-100' value='<?= set_value('score[]'); ?>'><small class='text-danger'> <?= form_error('score[]'); ?> </small></div></div>");

      $("#jumlah-form-detail"); // Ubah value textbox jumlah-form dengan variabel nextform
    });

    // Buat fungsi untuk mereset form ke semula
    $("#btn-reset-form-sub-detail").click(function() {
      $("#insert-form-sub-detail").html(""); // Kita kosongkan isi dari div insert-form
      $("#jumlah-form-detail").val("1"); // Ubah kembali value jumlah form menjadi 1
    });
  });
</script>