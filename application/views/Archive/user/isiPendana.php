<div style="background: white;
padding-top: 1px;
padding-bottom: 1px;
box-shadow: 0px 0px 20px #d4d4d4;
margin-top: -50px;" class="jumbotron jumbotron-fluid" >
<div class="container">
  <h6 class="text-center mb-4">
    <img class="mx-auto " style="margin-top: 25px"
    src="<?= base_url(); ?>/assets/img/fulusme.jpg" width="100"><br>
    Please complete the registration for next step

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
                  <option value="p">Miss</option>
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
                          echo "=====Information Source=====";
                        } ?></option>
                        <option value="friend">Friend</option>
                        <option value="social media">Social Media</option>
                        <option value="event">Event</option>
                        <option value="other">Other</option>
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
                        <small style="color: blue; font-size: 10px;">*only allow PDF and jpg file with max 200mb</small>
                        <?= form_error('image', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3 mb-sm-0">

                     <input type="text" class="form-control form-control-user-add" id="ktp" name="ktp" placeholder="Number of ID (KTP)" value="<?
                     if(set_value('ktp')){
                      echo set_value('ktp'); 
                      }else{

                      }
                      ?>"
                      >
                      <?= form_error('ktp', '<small class="text-danger pl-3">', '</small>'); ?>
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
                  <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="iscompany" name="iscompany">
                    <label class="form-check-label" for="iscompany">Register as company?</label>
                  </div>
                  <div id="iscompany_set" style="display: none"> <?= $iscompany ?></div>
                  <button id="next" data-trigger="tab" type="submit" href="#pills-profile" class="btn btn-primary btn-user btn-block form-button-user-add">
                    Next
                  </button>
                </div>




                <div class="tab-pane" id="pills-profile" role="tabpanel" aria-labelledby="pills-home-tab">
                  <h2 class="text-center">
                    Data Perusahaan 
                  </h2>

                  <div class="form-group row">
                    <div class="col-lg-3">
                      <input type="text" class="form-control form-control-user-add" id="type" name="type" placeholder="Company Type" value="<?

                      if(set_value('type')){
                        echo set_value('type'); 
                        }else{

                        }
                        ?>"
                        >
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
                          <input type="text" class="form-control form-control-user-add" id="kategoribisnis" name="kategoribisnis" placeholder="Business Category" value="<?

                          if(set_value('kategoribisnis')){
                            echo set_value('kategoribisnis'); 
                            }else{

                            }
                            ?>"
                            >
                            <?= form_error('kategoribisnis', '<small class="text-danger pl-3">', '</small>'); ?>

                          </div>

                          <div class="col-lg-7">
                            <input type="text" class="form-control form-control-user-add" id="tipebisnis" name="tipebisnis" placeholder="Business Type" value="<?

                            if(set_value('tipebisnis')){
                              echo set_value('tipebisnis'); 
                              }else{

                              }
                              ?>">
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
                                <input type="text" class="form-control form-control-user-add" id="status_kantor"
                                name="status_kantor" placeholder="Office Status" value="<?

                                if(set_value('status_kantor')){
                                  echo set_value('status_kantor'); 
                                  }else{
                                  }
                                  ?>">
                                  <?= form_error('status_kantor', '<small class="text-danger pl-3">', '</small>'); ?>
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
                        });
                        $( '[data-trigger="tab"]' ).click( function(e){
                          var href = $( this ).attr( 'href' );
                          e.preventDefault();
                          $( '[data-toggle="tab"][href="' + href + '"]' ).trigger( 'click' );
                        });
                      </script>