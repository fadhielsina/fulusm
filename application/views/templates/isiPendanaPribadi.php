<div style="background: white;
padding-top: 1px;
padding-bottom: 1px;
box-shadow: 0px 0px 20px #d4d4d4;
margin-top: -50px;" class="jumbotron jumbotron-fluid" >
<div class="container">
  <h6 class="text-center mb-4">
    <img class="mx-auto " style="margin-top: 25px"
    src="<?= base_url(); ?>/assetsprofile/asset/images/dealfintech.jpg" width="100"><br>
    Silahkan lengkapi data pribadi anda

  </h6>
</div>
</div>

<div class="row">
  <div class="col-lg-6 mx-auto">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body">
       <div class="tab-content" id="tabs-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
          <h2 class="text-center">
            Data Pribadi
          </h2>
          <?= $this->session->flashdata('message'); ?>
          <form style="margin-top: 30px;" enctype="multipart/form-data"
          class="user" method="post" action="<?= base_url('user') ?>">
          <!-- nama dan gender -->
            <div class="form-group">
              <input type="hidden" value="<?=$user['id']; ?>" class="form-control form-control-user-add" id="id" name="id">
              <div class="row">
                <div class="col-lg-2 col-sm-12">
                  <select name="gender" id="gender"class="custom-select form-control-user-add" >
                    <option value="l">Bapak</option>
                    <option value="p">Ibu</option>
                  </select>
                </div>
                <div class="col-lg-10 col-sm-12">
                  <input type="text" class="form-control form-control-user-add" id="name" placeholder="Nama Lengkap" name="name" value="<?
                    if(set_value('name')){
                      echo set_value('name'); 
                    }else{
                      echo $user['name'];
                    }?>">                  
                  <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
            </div>
            <!-- akhir nama dan gender -->

            <!-- Email -->
            <div class="form-group">
              <input type="text" class="form-control form-control-user-add" id="email" name="email" placeholder="Alamat Email" value="<?
              if(set_value('email')){
                echo set_value('email'); 
                }else{
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
                  if(set_value('address')){
                    echo set_value('address'); 
                  }else{
                  }
                ?>"
              >
                <?= form_error('address', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
            <!-- akhir alamat  -->

            <!-- telepon rumah dan no hp -->
            <div class="form-group row">
              <div class="col-lg-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user-add" id="phone" name="phone" placeholder="Telepon" value="<?
                  if(set_value('phone')){
                    echo set_value('phone'); 
                  }else{
                  }
                ?>"
              >
                <?= form_error('phone', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
              <div class="col-lg-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user-add" id="phonehp" name="phonehp" placeholder="Nomor Hp" value="<?
                  if(set_value('phonehp')){
                    echo set_value('phonehp'); 
                  }else{
                  }
                ?>"
              >
                <?= form_error('phonehp', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
            <!-- akhir telepon rumah dan no hp -->

            <!-- sumber informasi  -->
            <div class="form-group row">
              <div class="col-lg">
                <select name="source" id="source" class="custom-select form-control-user-add" >
                  <option value="<?php 
                    if(set_value('tipebisnis')){
                      echo set_value('tipebisnis'); 
                    }else{} 
                    ?>"
                  >
                <?php if(set_value('tipebisnis')){
                        echo set_value('tipebisnis'); 
                      }else{
                        echo "Sumber Informasi";
                      } ?>
                        
                  </option>
                  <option value="friend">Teman</option>
                  <option value="social media">Media Sosial</option>
                  <option value="event">Kegiatan/Event</option>
                  <option value="other">Lainnya</option>
                </select>
                <?= form_error('source', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
            <!-- akhir sumber informasi -->

            <!-- ktp dan unggah KTP -->
            <div class="form-group row">
              <div class="col-lg-6 mb-3 mb-sm-0">
                <div class="custom-file">
                  <input type="file" class="custom-file-input img-edit" id="image" name="image" for="image"/>
                    <label style="white-space: nowrap;
                        padding-right: 87px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        height: 33px;
                        font-size: .8rem;" 
                        class="custom-file-label img-label" for="image">Unggah file KTP</label>
                    <small style="color: blue; font-size: 10px;">*hanya format PDF dan file .jpg dengan maksimum 2MB</small>
                    <?= form_error('image', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <div class="col-lg-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user-add" id="noktp" name="noktp" placeholder="No. KTP" value="<?
                  if(set_value('noktp')){
                    echo set_value('noktp'); 
                  }else{
                  }
                ?>"
                >
                <?= form_error('noktp', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
            <!-- akhir ktp dan unggah KTP -->

            <!-- tempat lahir dan tanggal lahir -->
            <div class="form-group row">
              <div class="col-lg-6">
                <input type="text" class="form-control form-control-user-add" id="birthplace" name="birthplace" placeholder="Tempat Lahir" value="<?
                  if(set_value('birthplace')){
                    echo set_value('birthplace'); 
                  }else{
                  }
                ?>"
                >
                <?= form_error('birthplace', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
              <div class="col-lg-6">
                <input type="date" class="form-control form-control-user-add" id="birthdate" name="birthdate" placeholder="Tanggal Lahir " value="<?
                  if(set_value('birthdate')){
                    echo set_value('birthdate'); 
                  }else{
                  }
                ?>"
                >
                <?= form_error('birthdate', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
            <!-- akhir tempat lahir dan tanggal lahir -->

            <!-- propinsi kota kecamatan -->
            <div class="form-group row">
              <div class="col-lg-4">
                <select name="provinsi_user" id="provinsi_user" class="custom-select form-control-user-add" >
                  <option value="">Propinsi</option>
                  <?php foreach ($provinces as $p) : ?>
                  <option value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                  <?php endforeach;?>
                </select>
                <?= form_error('provinsi_user', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
              <div class="col-lg-4">
                <select name="kota_user" id="kota_user"class="custom-select form-control-user-add" >
                  <option value="">Kota/Kabupaten</option>
                </select>
                <?= form_error('kota_user', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
              <div class="col-lg-4">
                <select name="kecamatan_user" id="kecamatan_user"class="custom-select form-control-user-add" >
                  <option value="">Kecamatan</option>
                </select>
                <?= form_error('kecamatan_user', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
            <!-- akhir propinsi kota kecamatan -->

            <!-- agama -->
            <div class="form-group row">
              <div class="col-lg-12">
                <select name="agama" id="agama" class="custom-select form-control-user-add" >
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
                  if(set_value('pekerjaan')){
                    echo set_value('pekerjaan'); 
                  }else{
                  }
                ?>"
                >
                <?= form_error('pekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
            <!-- akhir pekerjaan -->

            <!-- jenis pekerjaan -->
            <div class="form-group row">
                <div class="col-lg-12">
                  <select name="jenispekerjaan" id="jenispekerjaan" class="custom-select form-control-user-add" >
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
                <select name="pendidikan" id="pendidikan" class="custom-select form-control-user-add" >
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
                  if(set_value('rekening')){
                    echo set_value('rekening'); 
                  }else{
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
                  if(set_value('nama_bank')){
                    echo set_value('nama_bank'); 
                  }else{
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
                  if(set_value('nama_akun_bank')){
                    echo set_value('nama_akun_bank'); 
                  }else{
                  }
                ?>">
              <?= form_error('nama_akun_bank', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
            <!-- akhir Nama Pemilik Rekening Bank -->
                              
            <button data-trigger="tab" type="submit" class="btn btn-primary btn-user btn-block form-button-user-add">
              Simpan
            </button>
          </form>
        </div>                    
      </div>
    </div>
  </div>
</div>
</div>
                <script
                src="https://code.jquery.com/jquery-3.1.1.min.js"
                integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
                crossorigin="anonymous">
                  
                </script>

                <script type="text/javascript">
                  $(document).ready(function(){
                    if($("#iscompany_set").text() == 1){
                      $('#pills-profile-tab').removeClass('disabled');
                      $('#iscompany').prop('checked', true);
                    }else{
                      $('#iscompany').click(function(){
                        if($('#iscompany').prop('checked')){
                          $('#pills-profile-tab').removeClass('disabled');
                        }else{
                          $('#pills-profile-tab').addClass('disabled');
                        }
                      });

                      $('#next').click(function(){
                        if($('#iscompany').prop('checked')){
                        }else{
                          $('#pills-profile-tab').addClass('disabled');
                          $( "#saveButton" ).trigger( "click" );
                        }
                      });
                    }

                    $('#provinsi').on('click', function() {
                      $("#kota").empty();
                      var provinsi = $('#provinsi :selected').val();
                      var data={province:provinsi};
                      $.ajax({
                        type : 'post',
                        url : "<?= base_url('user/setkota'); ?>",
                        data: data,
                        success: function(result){
                          var kota = JSON.parse(result);
                          for(var i = 0; i < kota.length; i++){
                            $("select#kota").append( $("<option>")
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
                      var data={province:provinsi};
                      $.ajax({
                        type : 'post',
                        url : "<?= base_url('user/setkota'); ?>",
                        data: data,
                        success: function(result){
                          var kota = JSON.parse(result);
                          for(var i = 0; i < kota.length; i++){
                            $("select#kota_user").append( $("<option>")
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
                      var data={kota:kota};
                      $.ajax({
                        type : 'post',
                        url : "<?= base_url('user/setkecamatan'); ?>",
                        data: data,
                        success: function(result){
                          var kecamatan = JSON.parse(result);
                          for(var i = 0; i < kecamatan.length; i++){
                            $("select#kecamatan").append( $("<option>")
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
                      var data={kota:kota};
                      $.ajax({
                        type : 'post',
                        url : "<?= base_url('user/setkecamatan'); ?>",
                        data: data,
                        success: function(result){
                          var kecamatan = JSON.parse(result);
                          for(var i = 0; i < kecamatan.length; i++){
                            $("select#kecamatan_user").append( $("<option>")
                              .val(kecamatan[i].name)
                              .html(kecamatan[i].name)
                              );
                          }
                        }
                      });
                    });
                  });


$( '[data-trigger="tab"]' ).click( function(e){
  var href = $( this ).attr( 'href' );
  e.preventDefault();
  $( '[data-toggle="tab"][href="' + href + '"]' ).trigger( 'click' );
});
</script>