<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-35VN14CNFE"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-35VN14CNFE');
</script>


<div style="background: white;
padding-top: 1px;
padding-bottom: 1px;
box-shadow: 0px 0px 20px #d4d4d4;
margin-top: -50px;" class="jumbotron jumbotron-fluid" >
<div class="container">
  <h6 class="text-center mb-4">
    <img class="mx-auto " style="margin-top: 25px"
    src="<?= base_url(); ?>assetsprofile/asset/images/dealfintech.jpg" width="100"><br>
    Silahkan lengkapi data pribadi anda

  </h6>
</div>
</div>
<div class="row">
  <div class="col-lg-6 mx-auto">
    <ul class="nav nav-tabs mb-3 justify-content-center" id="pills-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="pills-home-tab" data-toggle="tab" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Data Pribadi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" id="pills-profile-tab" data-toggle="tab" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Data Perusahaan</a>
      </li>
    </ul>
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
          <div class="form-group">
            <input type="hidden" value="<?=$user['id']; ?>" class="form-control form-control-user-add" id="id" name="id">
            <div class="row">
              <div class="col-lg-2 col-sm-12">
                <select name="gender" id="gender"class="custom-select form-control-user-add" >
                  <option value="l">Mr</option>
                  <option value="p">Ms</option>
                  <option value="p">Mrs</option>
                </select>
              </div>
              <div class="col-lg-10 col-sm-12">
                <input type="text" class="form-control form-control-user-add" id="name" placeholder="fullname" name="name" value="<?
                if(set_value('name')){
                  echo set_value('name'); 
                  }else{
                    echo $user['name'];
                  }
                  ?>">                  
                  <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <input type="text" class="form-control form-control-user-add" id="email" name="email" placeholder="Email Address" value="<?
              if(set_value('email')){
                echo set_value('email'); 
                }else{
                  echo $user['email'];
                }
                ?>" readonly>
                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
              <div class="form-group row">
                <div class="col-lg-12">
                  <input type="text" class="form-control form-control-user-add" id="address" name="address" placeholder="Address" value="<?
                  if(set_value('address')){
                    echo set_value('address'); 
                    }else{
                    }
                    ?>">
                    <?= form_error('address', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-lg mb-3 mb-sm-0">

                   <input type="text" class="form-control form-control-user-add" id="phone" name="phone" placeholder="phone" value="<?
                   if(set_value('phone')){
                    echo set_value('phone'); 
                    }else{

                    }
                    ?>"
                    >
                    <?= form_error('phone', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-lg">
                    <select name="source" id="source" class="custom-select form-control-user-add" >
                      <option value="<?php if(set_value('tipebisnis')){
                        echo set_value('tipebisnis'); 
                        }else{

                        } ?>"><?php if(set_value('tipebisnis')){
                          echo set_value('tipebisnis'); 
                        }else{
                          echo "Information Source";
                        } ?></option>
                        <option value="friend">Teman</option>
                        <option value="social media">Media Sosial</option>
                        <option value="event">Event</option>
                        <option value="other">Lainnya</option>
                      </select>
                      <?= form_error('source', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                  </div>

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
                        class="custom-file-label img-label" for="image">Upload ID (KTP) file</label>
                        <small style="color: blue; font-size: 10px;">*only allow PDF and jpg file with max 2mb</small>
                        <?= form_error('image', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3 mb-sm-0">

                     <input type="text" class="form-control form-control-user-add" id="noktp" name="noktp" placeholder="Number of ID (KTP)" value="<?
                     if(set_value('noktp')){
                      echo set_value('noktp'); 
                      }else{

                      }
                      ?>"
                      >
                      <?= form_error('noktp', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-lg mb-3 mb-sm-0">

                     <input type="text" class="form-control form-control-user-add" id="kk" name="kk" placeholder="Number of Family ID (KK)" value="<?
                     if(set_value('kk')){
                      echo set_value('kk'); 
                      }else{

                      }
                      ?>"
                      >
                      <?= form_error('kk', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-12">
                      <input type="text" class="form-control form-control-user-add" id="address" name="address" placeholder="Address" value="<?
                      if(set_value('address')){
                        echo set_value('address'); 
                        }else{

                        }
                        ?>">
                        <?= form_error('address', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-4">
                        <select name="provinsi_user" id="provinsi_user" class="custom-select form-control-user-add" >
                          <option value="">Province</option>


                          <?php foreach ($provinces as $p) : ?>
                            <option value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                          <?php endforeach;?>

                        </select>
                        <?= form_error('provinsi_user', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                      <div class="col-lg-4">
                       <select name="kota_user" id="kota_user"class="custom-select form-control-user-add" >
                        <option value="">City/Regency</option>

                      </select>
                      <?= form_error('kota_user', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="col-lg-4">
                      <select name="kecamatan_user" id="kecamatan_user"class="custom-select form-control-user-add" >
                        <option value="">District</option>

                      </select>
                      <?= form_error('kecamatan_user', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-12">
                      <select name="agama" id="agama" class="custom-select form-control-user-add" >
                        <option value="">Agama</option>
                        <option value="islam">Islam</option>
                        <option value="katholik">Katolik</option>
                        <option value="hindu">Hindu</option>
                        <option value="buddha">Buddha</option>
                        <option value="konghucu">Konghucu</option>
                      </select>
                      <?= form_error('agama', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-12">
                      <input type="text" class="form-control form-control-user-add" id="pekerjaan" name="pekerjaan" placeholder="Occupation" value="<?
                      if(set_value('pekerjaan')){
                        echo set_value('pekerjaan'); 
                        }else{

                        }
                        ?>">
                        <?= form_error('pekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-12">
                        <select name="jenispekerjaan" id="jenispekerjaan" class="custom-select form-control-user-add" >
                          <option value="">Occupation type</option>
                          <option value="pemerintahan">Goverment</option>
                          <option value="swasta">Private</option>
                          <option value="freelance">Freelance</option>
                        </select>
                        <?= form_error('jenispekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div></div>
                      <div class="form-group row">
                        <div class="col-lg-12">
                          <select name="pendidikan" id="pendidikan" class="custom-select form-control-user-add" >
                            <option value="">Pendidikan Terakhir</option>
                            <option value="sd">Sekolah Dasar</option>
                            <option value="smp">Sekolah Menengah Pertama</option>
                            <option value="sma">Sekolah Menengah Atas</option>
                            <option value="diploma"> Diploma</option>
                            <option value="sarjana"> Sarjana</option>

                          </select>
                          <?= form_error('pendidikan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div></div>
                        <div class="form-group row">
                    <div class="col-lg-12">
                      <input type="text" class="form-control form-control-user-add" id="rekening" name="rekening" placeholder="Bank Number" value="<?
                      if(set_value('rekening')){
                        echo set_value('rekening'); 
                        }else{

                        }
                        ?>">
                        <?= form_error('rekening', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                    </div>
                    <div class="form-group row">
                    <div class="col-lg-12">
                      <input type="text" class="form-control form-control-user-add" id="nama_bank" name="nama_bank" placeholder="Bank Name" value="<?
                      if(set_value('nama_bank')){
                        echo set_value('nama_bank'); 
                        }else{

                        }
                        ?>">
                        <?= form_error('nama_bank', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                    </div>
                    <div class="form-group row">
                    <div class="col-lg-12">
                      <input type="text" class="form-control form-control-user-add" id="nama_akun_bank" name="nama_akun_bank" placeholder="Bank Account Name" value="<?
                      if(set_value('nama_akun_bank')){
                        echo set_value('nama_akun_bank'); 
                        }else{

                        }
                        ?>">
                        <?= form_error('nama_akun_bank', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                    </div>
                        <div class="form-group form-check">
                          <input type="checkbox" class="form-check-input" id="iscompany" name="iscompany">
                          <label class="form-check-label" for="iscompany">Daftar Sebagai Perusahaan?</label>
                        </div>
                        <div id="iscompany_set" style="display: none"> <?= $iscompany ?></div>
                        <button id="next" data-trigger="tab" type="submit" href="#pills-profile" class="btn btn-primary btn-user btn-block form-button-user-add">
                          Lanjut
                        </button>
                      </div>




                      <div class="tab-pane" id="pills-profile" role="tabpanel" aria-labelledby="pills-home-tab">
                        <h2 class="text-center">
                          Data Perusahaan 
                        </h2>
                        <div class="form-group row">
                          <div class="col-lg-12">
                            <input type="text" class="form-control form-control-user-add" id="idperusahaan" name="idperusahaan" placeholder="Company ID Number" value="<?
                            if(set_value('idperusahaan')){
                              echo set_value('idperusahaan'); 
                              }else{

                              }
                              ?>">
                              <?= form_error('idperusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-lg-3">
                              <select name="type" id="type" class="custom-select form-control-user-add" >
                                <option value="">Company Type</option>
                                <option value="cv">CV</option>
                                <option value="koprasi">Trading Cooperative</option>
                                <option value="pemerintah daerah"> Local Goverment</option>
                                <option value="pemerintah pusat"> Main Government</option>
                                <option value="lainnya">Other</option>
                              </select>
                              <?= form_error('type', '<small class="text-danger pl-3">', '</small>'); ?>

                            </div>

                            <div class="col-lg-9">
                              <input type="text" class="form-control form-control-user-add" id="perusahaan" name="perusahaan" placeholder="Company Name" value="<?

                              if(set_value('perusahaan')){
                                echo set_value('perusahaan'); 
                                }else{

                                }
                                ?>"
                                >
                                <?= form_error('perusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                              </div>

                            </div>

                            <div class="form-group row">
                              <div class="col-lg-5">
                               <select name="kategoribisnis" id="kategoribisnis" class="custom-select form-control-user-add" >
                                <option value="">Business Category</option>
                                <option value="agrikultur">Agriculture</option>
                                <option value="teknologi">Technology</option>
                                <option value="infrastuktur">Infrastructure</option>
                                <option value="ekonomi kreatif">Creative Economy </option>
                                <option value="lainnya">Other</option>
                              </select>
                              <?= form_error('kategoribisnis', '<small class="text-danger pl-3">', '</small>'); ?>

                            </div>

                            <div class="col-lg-7">
                              <select name="tipebisnis" id="tipebisnis" class="custom-select form-control-user-add" >
                                <option value="">Business Type</option>
                                <option value="b2b">B 2 B</option>
                                <option value="b2c">B 2 C</option>
                                <option value="ctc">C 2 C</option>
                              </select>
                              <?= form_error('tipebisnis', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                          </div>

                          <div class="form-group row">
                            <div class="col-lg-12">
                              <input type="text" class="form-control form-control-user-add" id="deskripsi" style="height: 200px"
                              name="deskripsi" placeholder="Description" value="<?

                              if(set_value('deskripsi')){
                                echo set_value('deskripsi'); 
                                }else{

                                }
                                ?>">
                                <?= form_error('deskripsi', '<small class="text-danger pl-3">', '</small>'); ?>
                              </div>
                            </div>

                            <div class="form-group row">
                              <div class="col-lg-4">
                                <select name="status_kantor" id="status_kantor" class="custom-select form-control-user-add" >
                                  <option value="">Office Status</option>
                                  <option value="sewa">Rent</option>
                                  <option value="kepemilikan sendiri">Fully Ownership</option>
                                </select>
                              </div>
                              <div class="col-lg-4">
                                <input type="text" class="form-control form-control-user-add" id="jumlah_karyawan"
                                name="jumlah_karyawan" placeholder="Number of Employee" value="<?
                                if(set_value('jumlah_karyawan')){
                                  echo set_value('jumlah_karyawan'); 
                                  }else{
                                  }
                                  ?>">
                                  <?= form_error('jumlah_karyawan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="col-lg-4">
                                 <input type="text" class="form-control form-control-user-add" id="tahun_berdiri"
                                 name="tahun_berdiri" placeholder="Founded Year" value="<?

                                 if(set_value('tahun_berdiri')){
                                  echo set_value('tahun_berdiri'); 
                                  }else{

                                  }
                                  ?>">
                                  <?= form_error('tahun_berdiri', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                              </div>

                              <div class="form-group row">
                                <div class="col-lg-4">
                                  <select name="provinsi" id="provinsi" class="custom-select form-control-user-add" >
                                    <option value="<?php if(set_value('provinsi')){
                                      echo set_value('provinsi'); 
                                      }else{

                                      } ?>"><?php if(set_value('provinsi')){
                                        echo set_value('provinsi'); 
                                      }else{
                                        echo "Province";
                                      } ?></option>
                                      <?php foreach ($provinces as $p) : ?>
                                        <option value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                                      <?php endforeach;?>
                                    </select>
                                    <?= form_error('provinsi', '<small class="text-danger pl-3">', '</small>'); ?>
                                  </div>
                                  <div class="col-lg-4">
                                   <select name="kota" id="kota"class="custom-select form-control-user-add" >
                                    <option value="<?php if(set_value('kota')){
                                      echo set_value('kota'); 
                                      }else{

                                      } ?>"><?php if(set_value('kota')){
                                        echo set_value('kota'); 
                                      }else{
                                        echo "City";
                                      } ?></option>
                                    </select>
                                    <?= form_error('kota', '<small class="text-danger pl-3">', '</small>'); ?>
                                  </div>
                                  <div class="col-lg-4">
                                   <select name="kecamatan" id="kecamatan"class="custom-select form-control-user-add" >
                                    <option value="<?php if(set_value('kecamatan')){
                                      echo set_value('kecamatan'); 
                                      }else{

                                      } ?>"><?php if(set_value('kecamatan')){
                                        echo set_value('kecamatan'); 
                                      }else{
                                        echo "District";
                                      } ?></option>
                                    </select>
                                    <?= form_error('kecamatan', '<small class="text-danger pl-3">', '</small>'); ?>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-lg-6">
                                    <input type="text" class="form-control form-control-user-add" name="tlpPerusahaan" id="tlpPerusahaan"class="custom-select form-control-user-add" placeholder="Company Phone Number" value="<?
                                    if(set_value('tlpPerusahaan')){
                                      echo set_value('tlpPerusahaan'); 
                                      }else{
                                      }
                                      ?>" >
                                      <?= form_error('tlpPerusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="col-lg-6">
                                     <input type="text" class="form-control form-control-user-add" name="alamatWeb" id="alamatWeb"class="custom-select form-control-user-add" placeholder="Company Website" value="<?
                                     if(set_value('alamatWeb')){
                                      echo set_value('alamatWeb'); 
                                      }else{
                                      }
                                      ?>">
                                      <?= form_error('alamatWeb', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                  </div>
                                  <button id="saveButton" type="submit" class="btn btn-primary btn-user btn-block form-button-user-add">
                                    Save
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
                    crossorigin="anonymous"></script>
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