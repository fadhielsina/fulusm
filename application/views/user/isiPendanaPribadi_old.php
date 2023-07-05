<div style="background: white;
padding-top: 1px;
padding-bottom: 1px;
box-shadow: 0px 0px 20px #d4d4d4;
margin-top: -50px;" class="jumbotron jumbotron-fluid">
  <div class="container">
    <h6 class="text-center mb-4">
      <img class="mx-auto " style="margin-top: 25px" src="<?= base_url(); ?>assetsprofile/asset/images/dealfintech.jpg" width="100"><br>
      Silakan lengkapi data pribadi anda
      <a href="<?= base_url('user') ?>">
        <p class="text-center"> <i class="fas fa-arrow-left" style="font-size: 12px;"></i> kembali ke pilihan jenis pemodal</p>
      </a>
    </h6>

  </div>
</div>


<button id="nyalakan" style="display: none;" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#ambilFotoModal">Aktifkan Kamera</button>
<canvas style="display: none;" id="canvas" width=320 height=240></canvas>
<script>



</script>



<div class="modal fade bd-example-modal-lg" id="ambilFotoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="    max-width: 100%;">
      <div class="modal-body" style="padding: 0px;
    line-height: unset;">
        <video id="player" style="pointer-events: none;width: 100%;position: relative;" controls autoplay></video>
        <button id="capture" data-dismiss="modal" style="display: block;position: absolute;bottom: 23px;height: 40px;background: white;height: 50px;right: 23px;box-shadow: -15px -15px 68px -9px rgba(114,108,108,0.75);
-webkit-box-shadow: -15px -15px 68px -9px rgba(114,108,108,0.75);
-moz-box-shadow: -15px -15px 68px -9px rgba(114,108,108,0.75);;border: none;color: black;width: 50px;border-radius: 50px;" class=""><i class="fa fa-camera" aria-hidden="true"></i></button>
      </div>

    </div>
  </div>


</div>



<script>
  const player = document.getElementById('player');
  const canvas = document.getElementById('canvas');
  const context = canvas.getContext('2d');
  const captureButton = document.getElementById('capture');
  const nyalakanButton = document.getElementById('nyalakan');

  const constraints = {
    video: true,
  };

  captureButton.addEventListener('click', () => {

    context.drawImage(player, 0, 0, canvas.width, canvas.height);
    const dataURL = canvas.toDataURL();
    $('#img_prof').attr('src', dataURL);
    $('#urlimage').val(dataURL);

    // 



    // Stop all video streams.
    player.srcObject.getVideoTracks().forEach(track => track.stop());
  });

  nyalakanButton.addEventListener('click', () => {

    navigator.mediaDevices.getUserMedia(constraints)
      .then((stream) => {
        // Attach the video stream to the video element and autoplay.
        player.srcObject = stream;
      });
  });
</script>










<div class="row">
  <div class="col-lg-9 mx-auto">
    <div class="card o-hidden border-0 shadow-lg my-9">
      <div class="card-body">
        <div class="tab-content" id="tabs-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <h2 class="text-center">
              Data Pribadi
            </h2>
            <?= $this->session->flashdata('message'); ?>
            <form style="margin-top: 30px;" enctype="multipart/form-data" class="user" method="post" action="<?= base_url('user/addPendanaPribadi') ?>">
              <!-- nama dan gender -->
              <div class="form-group">
                <input type="hidden" value="<?= $user['id']; ?>" class="form-control form-control-user-add" id="id" name="id">







                <input type="hidden" class="form-control form-control-user-add" id="urlimage" name="urlimage">












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
              <div class="row">
                <div class="col-lg-7">
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

                  <!-- alamat  -->
                  <div class="form-group row">
                    <div class="col-lg-12">
                      <input type="text" class="form-control form-control-user-add" id="address" name="address" placeholder="Alamat Sesuai KTP" value="<?
                                                                                                                                                        if (set_value('address')) {
                                                                                                                                                          echo set_value('address');
                                                                                                                                                        } else {
                                                                                                                                                        }
                                                                                                                                                        ?>">
                      <?= form_error('address', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                  </div>
                  <!-- akhir alamat  -->

                  <!-- telepon rumah dan no hp -->
                  <div class="form-group row">
                    <div class="col-lg-6 mb-3 mb-sm-0">
                      <input type="text" class="form-control form-control-user-add" id="phone" name="phone" placeholder="Telepon" value="<?
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



                  <!-- ktp dan unggah KTP -->
                  <div class="form-group row">
                    <div class="col-lg-6 mb-3 mb-sm-0">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input img-edit" id="image" name="image" onchange="return fileValidation('image')" for="image" />
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

                  <!-- tempat lahir dan tanggal lahir -->
                  <div class="form-group row">
                    <div class="col-lg-6">
                      <input type="text" class="form-control form-control-user-add" id="birthplace" name="birthplace" placeholder="Tempat Lahir" value="<?
                                                                                                                                                        if (set_value('birthplace')) {
                                                                                                                                                          echo set_value('birthplace');
                                                                                                                                                        } else {
                                                                                                                                                        }
                                                                                                                                                        ?>">
                      <?= form_error('birthplace', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="col-lg-6">
                      <input type="date" class="form-control form-control-user-add" id="birthdate" name="birthdate" placeholder="Tanggal Lahir " value="<?
                                                                                                                                                        if (set_value('birthdate')) {
                                                                                                                                                          echo set_value('birthdate');
                                                                                                                                                        } else {
                                                                                                                                                        }
                                                                                                                                                        ?>">
                      <?= form_error('birthdate', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                  </div>

                  <div class="form-group row" style="">
                    <div class="col-lg-6 mb-3 mb-sm-0">
                      <input type="text" class="form-control form-control-user-add" id="emergencyphone" name="emergencyphone" placeholder=" Nomor Telepon Darurat" value="<?
                                                                                                                                                                          if (set_value('emergencyphone')) {
                                                                                                                                                                            echo set_value('emergencyphone');
                                                                                                                                                                          } else {
                                                                                                                                                                          }
                                                                                                                                                                          ?>">
                      <?= form_error('emergencyphone', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="col-lg-6 mb-3 mb-sm-0">
                      <input type="text" class="form-control form-control-user-add" id="waris" name="waris" placeholder="Nama Ahli Waris" value="<?
                                                                                                                                                  if (set_value('waris')) {
                                                                                                                                                    echo set_value('waris');
                                                                                                                                                  } else {
                                                                                                                                                  }
                                                                                                                                                  ?>">
                      <?= form_error('waris', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                  </div>
                  <!-- akhir tempat lahir dan tanggal lahir -->

                </div>
                <div class='col-lg-5'>
                  <!--start foto -->
                  <div class="form-group row">
                    <div class="col-sm-12">


                      <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" style="height: 300px !important;
    object-fit: contain;
    width: 100%;
    align-items: center;" for="customFile" id="img_prof" name="img_prof" class="img-thumbnail custom-file-label ">
                      <div style="
    align-content: center;
    display: inline-block;
    text-align: center;
    /* margin: auto; */
    width: 100%;
" class="text-center">
                        <p style="
    align-content: center;
    display: inline-block;
    margin-left: 112px;
    text-align: center;
    margin: auto;
" class="text-center">klik untuk mengambil Foto Profil</p>
                      </div>
                      <!--<div class="custom-file">-->
                      <!--	<input type="file" class="custom-file-input img-edit" id="imagei" name="imagei" for="imagei">-->
                      <!--</div>-->


                    </div>
                  </div>
                  <script>
                    $("#img_prof").click(function() {
                      //  $( "#imagei" ).trigger( "click" );
                      $("#nyalakan").trigger("click");

                    })

                    //                 var previewImage = function(input, block){
                    //     var fileTypes = ['jpg', 'jpeg', 'png'];
                    //     var extension = input.files[0].name.split('.').pop().toLowerCase();  /*se preia extensia*/
                    //     var isSuccess = fileTypes.indexOf(extension) > -1; /*se verifica extensia*/
                    // var filea = input.files[0].size;

                    //     if (filea > 2000000 ) { 
                    //                 alert('ukuran file tidak sesuai'); 

                    //                 filea = ''; 
                    //                 return false; 
                    //     }  

                    //     if(isSuccess){
                    //         var reader = new FileReader();

                    //         reader.onload = function (e) {
                    //             block.attr('src', e.target.result);
                    //         };
                    //         reader.readAsDataURL(input.files[0]);
                    //     }else{
                    //         alert('file type not accepted');
                    //     }

                    // };

                    // $(document).on('change', '#imagei', function(){
                    //     previewImage(this, $('#img_prof'));
                    // });
                  </script>
                  <!--akhir foto-->
                </div>

              </div>
              <!-- no tlp darurat dan nama ahli waris -->

              <!-- akhir telepon rumah dan no hp -->
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
                    <option value="">Bidang Pekerjaan</option>
                    <option value="pemerintahan">Pemerintahan</option>
                    <option value="swasta">Swasta</option>
                    <option value="freelance">Kerja Lepas</option>
                  </select>
                  <?= form_error('jenispekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir jenis pekerjaan -->



              <!--slip gaji -->
              <div class="form-group row">
                <div class="col-lg-12">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input img-edit" id="slipgaji" name="slipgaji" onchange="return fileValidation('slipgaji')" for="slipgaji" />
                    <label style="white-space: nowrap;
                        padding-right: 87px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        height: 33px;
                        font-size: .8rem;" class="custom-file-label img-label" for="slipgaji">Unggah Slip Gaji</label>
                    <small style="color: blue; font-size: 10px;">*hanya format PDF dan file .jpg dengan maksimum 2MB</small>
                    <?= form_error('image', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
              </div>

              <!--akhir slip gaji -->



              <!-- pendidikan terakhir -->
              <div class="form-group row">
                <div class="col-lg-12">
                  <select name="pendidikan" id="pendidikan" class="custom-select form-control-user-add">
                    <?php if (set_value('pendidikan')) { ?>
                      <option selected value="<?php echo set_value('pendidikan');  ?>"><?php echo set_value('pendidikan');  ?></option>
                    <?php } ?>
                    <option value="">Pendidikan</option>
                    <option value="sd">Sekolah Dasar</option>
                    <option value="smp">Sekolah Menengah Pertama</option>
                    <option value="sma">Sekolah Menengah Atas</option>
                    <option value="diploma"> Diploma</option>
                    <option value="sarjana"> Sarjana</option>
                    <option value="lainnya"> Lainnya</option>

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

              <!-- sumber informasi  -->
              <div class="form-group row">
                <div class="col-lg">
                  <select name="source" id="source" class="custom-select form-control-user-add">
                    <?php if (set_value('source')) { ?>
                      <option selected value="<?php echo set_value('source');  ?>"><?php echo set_value('source');  ?></option>
                    <?php } ?>
                    <option value="">Sumber Informasi</option>
                    <option value="Teman">Teman</option>
                    <option value="Media Sosial">Media Sosial</option>
                    <option value="Kegiatan/Event">Kegiatan/Event</option>
                    <option value="Lainnya">Lainnya</option>
                  </select>
                  <?= form_error('source', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <!-- akhir sumber informasi -->



              <button type="submit" class="btn btn-primary btn-user btn-block form-button-user-add">Simpan</button>
              <!--  <button data-trigger="tab" type="submit" class="btn btn-primary btn-user btn-block form-button-user-add">
              Simpan ga 
            </button> -->
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


  // $( '[data-trigger="tab"]' ).click( function(e){
  //   var href = $( this ).attr( 'href' );
  //   e.preventDefault();
  //   $( '[data-toggle="tab"][href="' + href + '"]' ).trigger( 'click' );
  // });





  function fileValidation(ini) {
    var fileInput =
      document.getElementById(ini);

    var filePath = fileInput.value;
    var filea = fileInput.files[0].size;



    // Allowing file type 
    var allowedExtensions =
      /(\.jpg|\.jpeg|\.png|\.pdf)$/i;
    if (filea > 2000000) {
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


  (function($) {
    $.fn.inputFilter = function(inputFilter) {
      return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      });
    };
  }(jQuery));


  $("#noktp").inputFilter(function(value) {
    return /^-?\d*$/.test(value) && (value === "" || value.length <= 16);
  });

  $("#extention").inputFilter(function(value) {
    return /^-?\d*$/.test(value) && (value === "" || value.length <= 5);
  });

  $("#nonpwp").inputFilter(function(value) {
    return /^-?\d*$/.test(value) && (value === "" || value.length <= 15);
  });





  $("#rekening").inputFilter(function(value) {
    return /^-?\d*$/.test(value) && (value === "" || value.length <= 16);
  });


  $("#phonehp").inputFilter(function(value) {
    return /^-?\d*[+]?\d*$/.test(value) && (value === "" || value.length <= 16);
  });
  $("#phone").inputFilter(function(value) {
    return /^-?\d*[+]?\d*$/.test(value) && (value === "" || value.length <= 16);
  });

  $("#emergencyphone").inputFilter(function(value) {
    return /^-?\d*[+]?\d*$/.test(value) && (value === "" || value.length <= 16);
  });



  $("#tlpPerusahaan").inputFilter(function(value) {
    return /^-?\d*[+]?\d*$/.test(value) && (value === "" || value.length <= 16);
  });
</script>