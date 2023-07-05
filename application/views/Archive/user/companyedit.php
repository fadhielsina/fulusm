<div class="container-fluid">
  <h1><?= $title; ?></h1>
  <?php if (validation_errors()): ?>
    <div class="alert alert-danger mb-3" role="alert" >
      <?= validation_errors();?>
    </div>
  <?php endif; ?>
  <?= $this->session->flashdata('message'); ?>

  <div class="row "> 
    <div class="col-lg-10" style="padding-bottom: 50px">  
      <form style="margin-top: 30px;" class="user" method="post" action="<?= base_url('company/edit') ?>">
        <div class="form-group row">
          <div class="col-lg-3">
            <input type="text" class="form-control form-control-user-add" id="type" name="type" placeholder="Company Type" value="<?

            if(set_value('type')){
              echo set_value('type'); 
              }else{
                echo $company['tipe_perusahaan'];
              }?>" 
              >
              <?= form_error('type', '<small class="text-danger pl-3">', '</small>'); ?>

            </div>

            <div class="col-lg-9">
              <input type="text" class="form-control form-control-user-add" id="perusahaan" name="perusahaan" placeholder="Company Name" value="<?

              if(set_value('perusahaan')){
                echo set_value('perusahaan'); 
                }else{
                  echo $company['nama_perusahaan'];
                }?>"        
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
                    echo $company['kategori_bisnis'];
                  }?>"
                  >
                  <?= form_error('kategoribisnis', '<small class="text-danger pl-3">', '</small>'); ?>

                </div>

                <div class="col-lg-7">
                  <input type="text" class="form-control form-control-user-add" id="tipebisnis" name="tipebisnis" placeholder="Business Type" value="<?

                  if(set_value('tipebisnis')){
                    echo set_value('tipebisnis'); 
                    }else{
                      echo $company['tipe_bisnis'];
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
                        echo $company['deskripsi_perusahaan'];
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
                          echo $company['status_kantor'];
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
                           echo $company['jumlah_karyawan'];
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
                            echo $company['tahun_berdiri'];
                          }
                          ?>">
                          <?= form_error('tahun_berdiri', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-lg-4">
                          <select name="provinsi" id="provinsi" class="custom-select form-control-user-add" >
                            <option value="<?= $company['provinsi']; ?>"><?= $company['provinsi']; ?></option>


                            <?php foreach ($provinces as $p) : ?>
                              <option value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                            <?php endforeach;?>

                          </select>
                          <?= form_error('provinsi', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-lg-4">
                         <select name="kota" id="kota"class="custom-select form-control-user-add" >
                          <option value="<?= $company['kota']; ?>"><?= $company['kota']; ?></option>

                        </select>
                        <?= form_error('kota', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                      <div class="col-lg-4">
                       <select name="kecamatan" id="kecamatan"class="custom-select form-control-user-add" >
                        <option value="<?= $company['kecamatan']; ?>"><?= $company['kecamatan']; ?></option>

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
                          echo $company['no_tlp'];
                        }
                        ?>" >
                        <?= form_error('tlpPerusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                      <div class="col-lg-6">
                       <input type="text" class="form-control form-control-user-add" name="alamatWeb" id="alamatWeb"class="custom-select form-control-user-add" placeholder="Company Website" value="<?

                       if(set_value('alamatWeb')){
                        echo set_value('alamatWeb'); 
                        }else{
                          echo $company['alamat_website'];
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



                <script
                src="https://code.jquery.com/jquery-3.1.1.min.js"
                integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
                crossorigin="anonymous"></script>

                <script type="text/javascript">
                   $("#kota option:selected").attr('disabled','disabled');
                   $("#kecamatan option:selected").attr('disabled','disabled');



                  $( '[data-trigger="tab"]' ).click( function(e){

                    var href = $( this ).attr( 'href' );
                    e.preventDefault();
                    $( '[data-toggle="tab"][href="' + href + '"]' ).trigger( 'click' );


                  });


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


                  $('#kota').on('click', function() {
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