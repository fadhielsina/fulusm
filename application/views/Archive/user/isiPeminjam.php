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
        <a class="nav-link" id="pills-profile-tab" data-toggle="tab" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Data Perusahaan</a>
      </li>
    </ul>


    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body">
       <div class="tab-content" id="tabs-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
          <h2 class="text-center">
            Data Pribadi 
          </h2>

          <form style="margin-top: 30px;"
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
                  <input type="text" class="form-control form-control-user-add" id="division" name="division" placeholder="Division" value="<?
                  if(set_value('division')){
                    echo set_value('division'); 
                    }else{
                      
                    }
                    ?>">
                    <?= form_error('division', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-8 mb-3 mb-sm-0">
                    
                   <input type="text" class="form-control form-control-user-add" id="phone" name="phone" placeholder="phone" value="<?
                   if(set_value('phone')){
                    echo set_value('phone'); 
                    }else{
                      
                    }
                    ?>"
                    >
                    <?= form_error('phone', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  <div class="col-sm-4">
                    <input type="text" class="form-control form-control-user-add" id="extention" name="extention" placeholder="Extention" value="<?
                    if(set_value('extention')){
                      echo set_value('extention'); 
                      }else{
                        
                      }
                      ?>"
                      >
                      <?= form_error('extention', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                  </div>
                  <a id="next" data-trigger="tab" href="#pills-profile" class="btn btn-primary btn-user btn-block form-button-user-add">
                    Next
                  </a>
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
                                      <option value="">Province</option>
                                      

                                      <?php foreach ($provinces as $p) : ?>
                                        <option value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                                      <?php endforeach;?>

                                    </select>
                                    <?= form_error('provinsi', '<small class="text-danger pl-3">', '</small>'); ?>
                                  </div>
                                  <div class="col-lg-4">
                                   <select name="kota" id="kota"class="custom-select form-control-user-add" >
                                    <option value="">City/Regency</option>

                                  </select>
                                  <?= form_error('kota', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="col-lg-4">
                                 <select name="kecamatan" id="kecamatan"class="custom-select form-control-user-add" >
                                  <option value="">District</option>

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

                              
                              <button type="submit" class="btn btn-primary btn-user btn-block form-button-user-add">
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
                  $( '[data-trigger="tab"]' ).click( function(e){

                    var href = $( this ).attr( 'href' );
                    e.preventDefault();
                    $( '[data-toggle="tab"][href="' + href + '"]' ).trigger( 'click' );


                  });


                  $('#provinsi').on('change', function() {
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
                </script>
