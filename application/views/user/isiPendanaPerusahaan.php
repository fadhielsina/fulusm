<div style="background: white;
padding-top: 1px;
padding-bottom: 1px;
box-shadow: 0px 0px 20px #d4d4d4;
margin-top: -50px;" class="jumbotron jumbotron-fluid">
  <div class="container">
    <h6 class="text-center mb-4">
      <img class="mx-auto " style="margin-top: 25px" src="<?= base_url(); ?>assetsprofile/asset/images/dealfintech.jpg" width="100"><br>
      Silahkan lengkapi data anda sebagai Pemodal perusahaan
      <a href="<?= base_url('user') ?>">
        <p class="text-center"> <i class="fas fa-arrow-left" style="font-size: 12px;"></i> kembali ke pilihan jenis Pemodalan</p>
      </a>
    </h6>
  </div>
</div>

<div class="row">
  <div class="col-lg-9 mx-auto">
    <div class="card o-hidden border-0 shadow-lg my-9">
      <div class="card-body">
        <div class="tab-content" id="tabs-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <h2 class="text-center">
              Data Pemodal Perusahaan
            </h2>
            <?= $this->session->flashdata('message'); ?>
            <form style="margin-top: 30px;" enctype="multipart/form-data" class="user" method="post" action="<?= base_url('user/addPendanaPerusahaan') ?>">
              <!-- nama dan gender -->
              <div class="form-group">
                <input type="hidden" value="<?= $user['id']; ?>" class="form-control form-control-user-add" id="id" name="id">
                <div class="row">
                  <div class="col-lg-2 col-sm-12">
                    <select name="gender" id="gender" class="custom-select form-control-user-add">
                      <?php if (set_value('gender')) { ?>
                        <option selected value="<?php echo set_value('gender');  ?>"> <?php echo set_value('gender');  ?></option>
                      <?php } ?>
                      <option value="l">Bapak</option>
                      <option value="p">Ibu</option>
                    </select>
                  </div>
                  <div class="col-lg-10 col-sm-12">
                    <input type="text" class="form-control form-control-user-add" id="name" placeholder="Nama Lengkap" name="name" value="<?
                                                                                                                                          if (set_value('name')) {
                                                                                                                                            echo set_value('name');
                                                                                                                                          } else {
                                                                                                                                            echo $user['name'];
                                                                                                                                          } ?>">
                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
              </div>
              <!-- akhir nama dan gender -->

              <!-- Email -->
              <div class="form-group">
                <input type="text" class="form-control form-control-user-add" id="email" name="email" placeholder="Alamat Email" value="<?
                                                                                                                                        if (set_value('email')) {
                                                                                                                                          echo set_value('email');
                                                                                                                                        } else {
                                                                                                                                          echo $user['email'];
                                                                                                                                        }
                                                                                                                                        ?>" readonly>
                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
              <!-- akhir email -->

              <!--start foto -->
              <div class="form-group row">
                <div class="col-md-6">
                  <div id="my_camera"></div>
                  <input type=button class="btn btn-success" value="Klik untuk mengambil foto profil" onClick="take_snapshot()">
                  <input type="hidden" name="image_profil" required class="image-tag">
                </div>
                <div class="col-md-6">
                  <div id="results">Foto yang anda ambil akan tampil disini...</div>
                </div>
                <?= form_error('image_profil', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
              <script language="JavaScript">
                Webcam.set({
                  width: 400,
                  height: 300,
                  image_format: 'jpeg',
                  jpeg_quality: 90
                });

                Webcam.attach('#my_camera');

                function take_snapshot() {
                  Webcam.snap(function(data_uri) {
                    $(".image-tag").val(data_uri);
                    document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
                  });
                }
              </script>
              <!--akhir foto-->

              <!-- ktp dan unggah KTP -->
              <div class="form-group row">
                <div class="col-lg-6 mb-3 mb-sm-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input img-edit" id="image" required onchange="return fileValidation('image')" name="image" for="image" />
                    <label style="white-space: nowrap;
                        padding-right: 87px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        height: 33px;
                        font-size: .8rem;" class="custom-file-label img-label" for="image">Unggah file KTP</label>
                    <small style="color: blue; font-size: 10px;">*hanya format PDF dan file .jpg dengan maksimum 2MB</small>
                    <?= form_error('image', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
                <div class="col-lg-6 mb-3 mb-sm-0">
                  <input type="text" class="form-control form-control-user-add" id="noktp" maxlength="16" name="noktp" placeholder="No. KTP" value="<?
                                                                                                                                                    if (set_value('noktp')) {
                                                                                                                                                      echo set_value('noktp');
                                                                                                                                                    } else {
                                                                                                                                                    }
                                                                                                                                                    ?>">
                  <?= form_error('noktp', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir ktp dan unggah KTP -->

              <!-- New Form -->
              <!--surat kuasa & akte perusahaan-->
              <div class="form-group row">
                <div class="col-lg-6 mb-3 mb-sm-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input img-edit" id="surat_kuasa" required onchange="return fileValidation('surat_kuasa')" name="surat_kuasa" for="image" />
                    <label style="white-space: nowrap;
                        padding-right: 87px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        height: 33px;
                        font-size: .8rem;" class="custom-file-label img-label" for="image">Unggah Surat Kuasa</label>
                    <small style="color: blue; font-size: 10px;">*hanya format PDF dan file .jpg dengan maksimum 2MB</small>
                    <?= form_error('surat_kuasa', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
                <div class="col-lg-6 mb-3 mb-sm-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input img-edit" id="akte_perusahaan" required onchange="return fileValidation('akte_perusahaan')" name="akte_perusahaan" for="image" />
                    <label style="white-space: nowrap;
                        padding-right: 87px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        height: 33px;
                        font-size: .8rem;" class="custom-file-label img-label" for="image">Unggah Akte Perusahaan</label>
                    <small style="color: blue; font-size: 10px;">*hanya format PDF dan file .jpg dengan maksimum 2MB</small>
                    <?= form_error('akte_perusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
              </div>
              <!-- akhir surat kuasa & akte perusahaan -->

              <!-- no rekening custodian -->
              <div class="form-group row">
                <div class="col-lg-6 mb-3 mb-sm-0">
                  <input type="text" class="form-control form-control-user-add" id="custodian" name="custodian" placeholder="Nomor rekening kustodian" value="<?
                                                                                                                                                              if (set_value('custodian')) {
                                                                                                                                                                echo set_value('custodian');
                                                                                                                                                              } else {
                                                                                                                                                              }
                                                                                                                                                              ?>">
                  <?= form_error('custodian', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-lg-6 mb-3 mb-sm-0">
                  <input type="text" class="form-control form-control-user-add" id="custodian_name" name="custodian_name" placeholder="Nama pemilik rekening kustodian" value="<?
                                                                                                                                                                                if (set_value('custodian')) {
                                                                                                                                                                                  echo set_value('custodian');
                                                                                                                                                                                } else {
                                                                                                                                                                                }
                                                                                                                                                                                ?>">
                  <?= form_error('custodian', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir no rekening custodian -->

              <!-- akhir New Form -->

              <!-- telepon rumah dan no hp -->
              <div class="form-group row">
                <div class="col-lg-6 mb-3 mb-sm-0">
                  <input type="text" class="form-control form-control-user-add" id="phone" name="phone" placeholder="Telepon Perusahaan" value="<?
                                                                                                                                                if (set_value('phone')) {
                                                                                                                                                  echo set_value('phone');
                                                                                                                                                } else {
                                                                                                                                                }
                                                                                                                                                ?>">
                  <?= form_error('phone', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-lg-6 mb-3 mb-sm-0">
                  <input type="text" class="form-control form-control-user-add" id="phonehp" name="phonehp" placeholder="Nomor Hp" value="<?
                                                                                                                                          if (set_value('phonehp')) {
                                                                                                                                            echo set_value('phonehp');
                                                                                                                                          } else {
                                                                                                                                          }
                                                                                                                                          ?>">
                  <?= form_error('phonehp', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir telepon rumah dan no hp -->

              <!-- jabatan dan nip  -->
              <div class="form-group row">
                <div class="col-lg-6">
                  <input type="text" class="form-control form-control-user-add" id="jabatan" name="jabatan" placeholder="Jabatan" value="<?
                                                                                                                                          if (set_value('jabatan')) {
                                                                                                                                            echo set_value('jabatan');
                                                                                                                                          } else {
                                                                                                                                          }
                                                                                                                                          ?>">
                  <?= form_error('jabatan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="form-control form-control-user-add" id="nip" name="nip" placeholder="NIP" value="<?
                                                                                                                              if (set_value('nip')) {
                                                                                                                                echo set_value('nip');
                                                                                                                              } else {
                                                                                                                              }
                                                                                                                              ?>">
                  <?= form_error('nip', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir jabatan dan nip -->

              <!-- nama perusahaan dan nomor akta perusahaan -->
              <div class="form-group row">
                <div class="col-lg-6">
                  <input type="text" class="form-control form-control-user-add" id="namaperusahaan" name="namaperusahaan" placeholder="Nama Perusahaan" value="<?
                                                                                                                                                                if (set_value('namaperusahaan')) {
                                                                                                                                                                  echo set_value('namaperusahaan');
                                                                                                                                                                } else {
                                                                                                                                                                }
                                                                                                                                                                ?>">
                  <?= form_error('namaperusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="form-control form-control-user-add" id="nomoraktaperusahaan" name="nomoraktaperusahaan" placeholder="No. Akta Perusahaan" value="<?
                                                                                                                                                                              if (set_value('nomoraktaperusahaan')) {
                                                                                                                                                                                echo set_value('nomoraktaperusahaan');
                                                                                                                                                                              } else {
                                                                                                                                                                              }
                                                                                                                                                                              ?>">
                  <?= form_error('nomoraktaperusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir nama perusahaan dan nomor akta perusahaan -->

              <!-- jenis perusahaan dan alamat perusahaan -->
              <div class="form-group row">
                <div class="col-lg-6">
                  <select name="jenisperusahaan" id="jenisperusahaan" class="custom-select form-control-user-add">
                    <?php if (set_value('jenisperusahaan')) { ?>
                      <option selected value="<?php echo set_value('jenisperusahaan');  ?>"><?php echo set_value('jenisperusahaan');  ?></option>
                    <?php } ?>
                    <option value="">Jenis Perusahaan</option>
                    <option value="pt">PT</option>
                    <option value="cv">CV</option>
                    <option value="koperasi">Koperasi</option>
                  </select>
                  <?= form_error('jenisperusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="col-lg-6">
                  <input type="text" class="form-control form-control-user-add" id="alamatperusahaan" name="alamatperusahaan" placeholder="Alamat Perusahaan" value="<?
                                                                                                                                                                      if (set_value('alamatperusahaan')) {
                                                                                                                                                                        echo set_value('alamatperusahaan');
                                                                                                                                                                      } else {
                                                                                                                                                                      }
                                                                                                                                                                      ?>">
                  <?= form_error('alamatperusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

              </div>
              <!-- akhir jenis perusahaan dan alamat perusahaan -->

              <!-- propinsi kota kecamatan -->
              <div class="form-group row">
                <div class="col-lg-4">
                  <select name="provinsi_user" id="provinsi_user" class="custom-select form-control-user-add">
                    <option value="">Propinsi</option>
                    <?php foreach ($provinces as $p) :
                      if (set_value('provinsi_user')) {
                        if (set_value('provinsi_user') == $p['name']) { ?>
                          <option selected value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                        <?php } else { ?>
                          <option value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                        <?php }
                      } else { ?>
                        <option value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                    <?php }
                    endforeach; ?>
                  </select>
                  <?= form_error('provinsi_user', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-lg-4">
                  <select name="kota_user" id="kota_user" class="custom-select form-control-user-add">
                    <option value="">Kota/Kabupaten</option>
                    <?php if (set_value('kota_user')) { ?>
                      <option selected value="<?php echo set_value('kota_user');  ?>"> <?php echo set_value('kota_user');  ?></option>
                    <?php } ?>
                  </select>
                  <?= form_error('kota_user', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-lg-4">
                  <select name="kecamatan_user" id="kecamatan_user" class="custom-select form-control-user-add">
                    <option value="">Kecamatan</option>
                    <?php if (set_value('kecamatan_user')) { ?>
                      <option selected value="<?php echo set_value('kecamatan_user');  ?>"> <?php echo set_value('kecamatan_user');  ?></option>
                    <?php } ?>
                  </select>
                  <?= form_error('kecamatan_user', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir propinsi kota kecamatan -->

              <!-- agama -->
              <div class="form-group row">
                <div class="col-lg-12">
                  <select name="agama" id="agama" class="custom-select form-control-user-add">
                    <?php if (set_value('agama')) { ?>
                      <option selected value="<?php echo set_value('agama');  ?>"> <?php echo set_value('agama');  ?></option>
                    <?php } ?>

                    <option value="">Agama</option>
                    <option value="islam">Islam</option>
                    <option value="katholik">Katolik</option>
                    <option value="hindu">Hindu</option>
                    <option value="buddha">Budha</option>
                    <option value="konghucu">Konghucu</option>
                  </select>
                  <?= form_error('agama', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir agama -->

              <!-- pekerjaan -->
              <div class="form-group row">
                <div class="col-lg-12">
                  <input type="text" class="form-control form-control-user-add" id="pekerjaan" name="pekerjaan" placeholder="Pekerjaan" value="<?
                                                                                                                                                if (set_value('pekerjaan')) {
                                                                                                                                                  echo set_value('pekerjaan');
                                                                                                                                                } else {
                                                                                                                                                }
                                                                                                                                                ?>">
                  <?= form_error('pekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir pekerjaan -->

              <!-- jenis pekerjaan -->
              <div class="form-group row">
                <div class="col-lg-12">
                  <select name="jenispekerjaan" id="jenispekerjaan" class="custom-select form-control-user-add">
                    <?php if (set_value('jenispekerjaan')) { ?>
                      <option selected value="<?php echo set_value('jenispekerjaan');  ?>"><?php echo set_value('jenispekerjaan');  ?></option>
                    <?php } ?>
                    <option value="">Jenis Pekerjaan</option>
                    <option value="pemerintahan">Pemerintah</option>
                    <option value="swasta">Karyawan Swasta</option>
                    <option value="wirausaha">Wirausaha</option>
                    <option value="freelance">Pekerja Lepas</option>
                  </select>
                  <?= form_error('jenispekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir jenis pekerjaan -->

              <!-- pendidikan terakhir -->
              <div class="form-group row">
                <div class="col-lg-12">
                  <select name="pendidikan" id="pendidikan" class="custom-select form-control-user-add">
                    <?php if (set_value('pendidikan')) { ?>
                      <option selected value="<?php echo set_value('pendidikan');  ?>"><?php echo set_value('pendidikan');  ?></option>
                    <?php } ?>
                    <option value="">Pendidikan Terakhir</option>
                    <option value="sd">Sekolah Dasar</option>
                    <option value="smp">Sekolah Menengah Pertama</option>
                    <option value="sma">Sekolah Menengah Atas</option>
                    <option value="diploma"> Diploma</option>
                    <option value="sarjana"> Sarjana</option>
                    <option value="pascasarjana"> Pasca Sarjana</option>
                  </select>
                  <?= form_error('pendidikan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir pendidikan terakhir -->

              <!-- nomor rekening bank    -->
              <div class="form-group row">
                <div class="col-lg-12">
                  <input type="text" class="form-control form-control-user-add" id="rekening" name="rekening" placeholder="Nomor Rekening Bank" value="<?
                                                                                                                                                        if (set_value('rekening')) {
                                                                                                                                                          echo set_value('rekening');
                                                                                                                                                        } else {
                                                                                                                                                        }
                                                                                                                                                        ?>">
                  <?= form_error('rekening', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir nomor rekening bank -->

              <!-- nama bank -->
              <div class="form-group row">
                <div class="col-lg-12">
                  <input type="text" class="form-control form-control-user-add" id="nama_bank" name="nama_bank" placeholder="Nama Bank" value="<?
                                                                                                                                                if (set_value('nama_bank')) {
                                                                                                                                                  echo set_value('nama_bank');
                                                                                                                                                } else {
                                                                                                                                                }
                                                                                                                                                ?>">
                  <?= form_error('nama_bank', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir nama bank -->

              <!-- Nama Pemilik Rekening Bank -->
              <div class="form-group row">
                <div class="col-lg-12">
                  <input type="text" class="form-control form-control-user-add" id="nama_akun_bank" name="nama_akun_bank" placeholder="Nama Pemilik Rekening Bank" value="<?
                                                                                                                                                                          if (set_value('nama_akun_bank')) {
                                                                                                                                                                            echo set_value('nama_akun_bank');
                                                                                                                                                                          } else {
                                                                                                                                                                          }
                                                                                                                                                                          ?>">
                  <?= form_error('nama_akun_bank', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir Nama Pemilik Rekening Bank -->

              <button type="submit" class="btn btn-primary btn-user btn-block form-button-user-add">
                Simpan
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous">

</script>

<script type="text/javascript">
  $(document).ready(function() {
    if ($("#iscompany_set").text() == 1) {
      $('#pills-profile-tab').removeClass('disabled');
      $('#iscompany').prop('checked', true);
    } else {
      $('#iscompany').click(function() {
        if ($('#iscompany').prop('checked')) {
          $('#pills-profile-tab').removeClass('disabled');
        } else {
          $('#pills-profile-tab').addClass('disabled');
        }
      });

      $('#next').click(function() {
        if ($('#iscompany').prop('checked')) {} else {
          $('#pills-profile-tab').addClass('disabled');
          $("#saveButton").trigger("click");
        }
      });
    }

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

    $('#provinsi_user').on('change', function() {
      $("#kota_user").empty();
      var provinsi = $('#provinsi_user :selected').val();
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
            $("select#kota_user").append($("<option>")
              .val(kota[i].name)
              .html(kota[i].name)
            );
          }
        }
      });
    });

    $('#kota').on('change', function() {
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


    $('#kota_user').on('change', function() {
      $("#kecamatan_user").empty();
      var kota = $('#kota_user :selected').val();
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
            $("select#kecamatan_user").append($("<option>")
              .val(kecamatan[i].name)
              .html(kecamatan[i].name)
            );
          }
        }
      });
    });
  });


  $('[data-trigger="tab"]').click(function(e) {
    var href = $(this).attr('href');
    e.preventDefault();
    $('[data-toggle="tab"][href="' + href + '"]').trigger('click');
  });

  function fileValidation(ini) {
    var fileInput =
      document.getElementById(ini);

    var filePath = fileInput.value;
    var filea = fileInput.files[0].size;



    // Allowing file type 
    var allowedExtensions =
      /(\.jpg|\.jpeg|\.png|\.pdf)$/i;
    if (filea > 10000000) {
      alert('ukuran file tidak sesuai');
      fileInput.value = '';
      filea = '';
      return false;
    }
    if (!allowedExtensions.exec(filePath)) {
      alert('Tipe file tidak sesuai');
      fileInput.value = '';
      return false;
    }
  }
</script>