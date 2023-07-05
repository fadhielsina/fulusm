<div class="container-fluid">
  <h1><?= $title; ?></h1>
  <?php if (validation_errors()) : ?>
    <div class="alert alert-danger mb-3" role="alert">
      <?= validation_errors(); ?>
    </div>
  <?php endif; ?>
  <?= $this->session->flashdata('message'); ?>

  <div class="row ">
    <div class="col-lg-10" style="padding-bottom: 50px">
      <form style="margin-top: 30px;" class="user" method="post" action="<?= base_url('company/edit') ?>">
        <div class="form-group row">
          <div class="col-lg-3">
            <label for="">Tipe Perusahaan</label>
            <input type="text" class="form-control form-control-user-add" id="type" name="type" placeholder="Company Type" value="<?= isset($company["tipe_perusahaan"]) ? $company["tipe_perusahaan"] : ''; ?>">
            <?= form_error('type', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>

          <div class="col-lg-9">
            <label for="">Nama Perusahaan</label>
            <input type="text" class="form-control form-control-user-add" id="perusahaan" name="perusahaan" placeholder="Company Name" value="<?= isset($company["nama_perusahaan"]) ? $company["nama_perusahaan"] : ''; ?>">
            <?= form_error('perusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-lg-5">
            <label for="">Kategori Bisnis</label>
            <input type="text" class="form-control form-control-user-add" id="kategoribisnis" name="kategoribisnis" placeholder="Business Category" value="<?= isset($company["kategori_bisnis"]) ? $company["kategori_bisnis"] : ''; ?>">
            <?= form_error('kategoribisnis', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>

          <div class="col-lg-7">
            <label for="">Tipe Bisnis</label>
            <input type="text" class="form-control form-control-user-add" id="tipebisnis" name="tipebisnis" placeholder="Business Type" value="<?= isset($company["tipe_bisnis"]) ? $company["tipe_bisnis"] : ''; ?>">
            <?= form_error('tipebisnis', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-lg-12">
            <label for="">Deskripsi Perusahaan</label>
            <input type="text" class="form-control form-control-user-add" id="deskripsi" style="height: 200px" name="deskripsi" placeholder="Description" value="<?= isset($company["deskripsi_perusahaan"]) ? $company["deskripsi_perusahaan"] : ''; ?>">
            <?= form_error('deskripsi', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-lg-4">
            <label for="">Status Kantor</label>
            <input type="text" class="form-control form-control-user-add" id="status_kantor" name="status_kantor" placeholder="Office Status" value="<?= isset($company["status_kantor"]) ? $company["status_kantor"] : ''; ?>">
            <?= form_error('status_kantor', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="col-lg-4">
            <label for="">Jumlah Karyawan</label>
            <input type="text" class="form-control form-control-user-add" id="jumlah_karyawan" name="jumlah_karyawan" placeholder="Number of Employee" value="<?= isset($company["jumlah_karyawan"]) ? $company["jumlah_karyawan"] : ''; ?>">
            <?= form_error('jumlah_karyawan', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="col-lg-4">
            <label for="">Tahun Berdiri</label>
            <input type="text" class="form-control form-control-user-add" id="tahun_berdiri" name="tahun_berdiri" placeholder="Founded Year" value="<?= isset($company["tahun_berdiri"]) ? $company["tahun_berdiri"] : ''; ?>">
            <?= form_error('tahun_berdiri', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>

        <?php
        $prov = isset($company["provinsi"]) ? $company["provinsi"] : '';
        $kot = isset($company["kota"]) ? $company["kota"] : '';
        $kec = isset($company["kecamatan"]) ? $company["kecamatan"] : '';
        ?>

        <div class="form-group row">
          <div class="col-lg-4">
            <label for="">Provinsi</label>
            <select name="provinsi" id="provinsi" class="custom-select form-control-user-add">
              <option value="<?= $prov; ?>"><?= $prov; ?></option>
              <?php foreach ($provinces as $p) : ?>
                <option value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
              <?php endforeach; ?>
            </select>
            <?= form_error('provinsi', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="col-lg-4">
            <label for="">Kota</label>
            <select name="kota" id="kota" class="custom-select form-control-user-add">
              <option value="<?= $kot; ?>"><?= $kot; ?></option>
              <option value="<?= $company['kota']; ?>"><?= $company['kota']; ?></option>
            </select>
            <?= form_error('kota', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="col-lg-4">
            <label for="">Kecamatan</label>
            <select name="kecamatan" id="kecamatan" class="custom-select form-control-user-add">
              <option value="<?= $kec; ?>"><?= $kec; ?></option>
              <option value="<?= $company['kecamatan']; ?>"><?= $company['kecamatan']; ?></option>
            </select>
            <?= form_error('kecamatan', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-lg-6">
            <label for="">Telpon Perusahaan</label>
            <input type="text" class="form-control form-control-user-add" name="tlpPerusahaan" id="tlpPerusahaan" class="custom-select form-control-user-add" placeholder="Company Phone Number" value="<?= isset($company["tlpPerusahaan"]) ? $company["tlpPerusahaan"] : ''; ?>">
            <?= form_error('tlpPerusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="col-lg-6">
            <label for="">Alamat WEB</label>
            <input type="text" class="form-control form-control-user-add" name="alamatWeb" id="alamatWeb" class="custom-select form-control-user-add" placeholder="Company Website" value="<?= isset($company["alamat_website"]) ? $company["alamat_website"] : ''; ?>">
            <?= form_error('alamatWeb', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block form-button-user-add">
          Save
        </button>
      </form>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

<script type="text/javascript">
  $("#kota option:selected").attr('disabled', 'disabled');
  $("#kecamatan option:selected").attr('disabled', 'disabled');

  $('[data-trigger="tab"]').click(function(e) {
    var href = $(this).attr('href');
    e.preventDefault();
    $('[data-toggle="tab"][href="' + href + '"]').trigger('click');
  });

  $('#provinsi').on('click', function() {
    $("#kota").empty();
    var provinsi = $('#provinsi :selected').val();
    var data = {
      province: provinsi
    };
    $.ajax({
      type: 'post',
      url: "<?= base_url('user/setkota'); ?>",
      data: data,
      success: function(result) {
        var kota = JSON.parse(result);
        for (var i = 0; i < kota.length; i++) {
          $("select#kota").append($("<option>")
            .val(kota[i].name)
            .html(kota[i].name)
          );
        }
      }
    });
  });


  $('#kota').on('click', function() {
    $("#kecamatan").empty();
    var kota = $('#kota :selected').val();
    var data = {
      kota: kota
    };
    $.ajax({
      type: 'post',
      url: "<?= base_url('user/setkecamatan'); ?>",
      data: data,
      success: function(result) {
        var kecamatan = JSON.parse(result);
        for (var i = 0; i < kecamatan.length; i++) {
          $("select#kecamatan").append($("<option>")
            .val(kecamatan[i].name)
            .html(kecamatan[i].name)
          );
        }
      }
    });
  });
</script>