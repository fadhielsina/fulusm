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
    Silahkan lengkapi data Anda
  </h6>
</div>
</div>

<div class="row">

  <div class="col-lg-9 mx-auto">
    
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body">
          
       
           
        
          <h2 class="text-center">
            Data Pribadi
          </h2>
          <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message'); ?>
            </div>
            </div>

          <form style="margin-top: 30px;" enctype="multipart/form-data"
          class="user" method="post" action="<?= base_url('user') ?>">
              
        <!--ini start nya       -->
              
              <div class="form-group">

            <input type="hidden" value="<?=$user['id']; ?>" class="form-control form-control-user-add" id="id" name="id">
            <input type="hidden" value="<?=$user['id_anggota']; ?>" class="form-control form-control-user-add" id="id_anggota" name="id_anggota">
            <div class="row">
              <div class="col-lg-2 col-sm-12">
                  <label>Gender</label> 
                <select name="gender" id="gender"class="custom-select form-control-user-add" >
                    <?php if(set_value('gender')){
                        if(set_value('gender') == 'p'){?>
                        <option selected value="<?php echo set_value('gender');  ?>"> Ibu</option>
                            
                        <?php
                        }else{
                        ?>
                        <option selected value="<?php echo set_value('gender');  ?>"> Bapak</option>
                        <?php
                        }
                        ?>
                    
                        
                            
                        <?php }?>
                  <option value="l">Bapak</option>
                  <option value="p">Ibu</option>
                </select>
              </div>

              <div class="col-lg-10 col-sm-12">
                  <label>Nama Lengkap</label> 
                <input type="text" class="form-control form-control-user-add" id="name" placeholder="Nama Lengkap" name="name" value="<?

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
                <label>Email</label> 
              <input type="text" class="form-control form-control-user-add" id="email" name="email" placeholder="Alamat Email" value="<?
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
                        <label>Alamat</label> 
                      <input type="text" class="form-control form-control-user-add" id="address" name="address" placeholder="Alamat Sesuai KTP" value="<?
                      if(set_value('address')){
                        echo set_value('address'); 
                        }else{

                        }
                        ?>">
                        <?= form_error('address', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                    
                    <div class="col-lg-6 mb-3 mb-sm-0">

                     <input type="text" class="form-control form-control-user-add" maxlength="16" id="noktp" name="noktp" placeholder="Nomor KTP" value="<?
                     if(set_value('noktp')){
                      echo set_value('noktp'); 
                      }else{

                      }
                      ?>"
                      >
                      <?= form_error('noktp', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="col-lg-6 mb-3 mb-sm-0">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input img-edit" id="image" onchange="return fileValidation('image')" name="image" for="image"/>
                        <label style="white-space: nowrap;
                        padding-right: 87px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        height: 33px;
                        font-size: .8rem;" 
                        class="custom-file-label img-label" for="image">Unggah KTP</label>
                        <small style="color: blue; font-size: 10px;">*Gunakan File PDF atau JPG dengan ukuran Maksimal 2 Mb</small>
                        <?= form_error('image', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                    </div>
                  </div>
                    
                    <div class="form-group row">
                    
                    <div class="col-lg-6 mb-3 mb-sm-0">

                     <input type="text" class="form-control form-control-user-add" id="nokk" maxlength="16"  name="nokk" placeholder="Nomor KK" value="<?
                     if(set_value('nokk')){
                      echo set_value('nokk'); 
                      }else{

                      }
                      ?>"
                      >
                      <?= form_error('nokk', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="col-lg-6 mb-3 mb-sm-0">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input img-edit" id="imagekk" onchange="return fileValidation('imagekk')" name="imagekk" for="imagekk"/>
                        <label style="white-space: nowrap;
                        padding-right: 87px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        height: 33px;
                        font-size: .8rem;" 
                        class="custom-file-label img-label" for="imagekk">Unggah KK</label>
                        <small style="color: blue; font-size: 10px;">*Gunakan File PDF atau JPG dengan ukuran Maksimal 2 Mb</small>
                        <?= form_error('imagekk', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <div class="col-lg-6">
                      <input type="text" class="form-control form-control-user-add" id="birthplace" name="birthplace" placeholder="Tempat Lahir" value="<?
                      if(set_value('birthplace')){
                        echo set_value('birthplace'); 
                        }else{

                        }
                        ?>">
                        <?= form_error('birthplace', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>

                      <div class="col-lg-6">
                      <input type="date" class="form-control form-control-user-add" id="birthdate" name="birthdate" placeholder="Tanggal Lahir" value="<?
                      if(set_value('birthdate')){
                        echo set_value('birthdate'); 
                        }else{

                        }
                        ?>">
                        <?= form_error('birthdate', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>

                    </div>
               
                <!--ini akhirnya -->
                    
                    
                    
                    
                    
                <div class="form-group row">
                    <div class="col-lg-12">
                      <select name="agama" id="agama" class="custom-select form-control-user-add" >
                        <?php if(set_value('agama')){?>
                            <option selected value="<?php echo set_value('agama');  ?>"> <?php echo set_value('agama');  ?></option>
                        <?php }?>
                          
                          
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
                  
                  
                  <div class="form-group row">
                          <div class="col-lg-12">
                            <select name="pendidikan" id="pendidikan" class="custom-select form-control-user-add" >
                                <?php if(set_value('pendidikan')){?>
                                    <option selected value="<?php echo set_value('pendidikan');  ?>"><?php echo set_value('pendidikan');  ?></option>
                                <?php }?>
                              <option value="">Pendidikan</option>
                              <option value="sd">Sekolah Dasar</option>
                              <option value="smp">Sekolah Menengah Pertama</option>
                              <option value="sma">Sekolah Menengah Atas</option>
                              <option value="diploma"> Diploma</option>
                              <option value="sarjana"> Sarjana</option>
                              <option value="lainnya"> Lainnya</option>

                            </select>
                            <?= form_error('pendidikan', '<small class="text-danger pl-3">', '</small>'); ?>
                          </div></div>
                    
                    
                    
                <div class="form-group row">
                        <div class="col-lg-12">
                          <select name="pekerjaan" id="pekerjaan" class="custom-select form-control-user-add" >
                              <?php if(set_value('pekerjaan')){?>
                                    <option selected value="<?php echo set_value('pekerjaan');  ?>"><?php echo set_value('pekerjaan');  ?></option>
                                <?php }?>
                            <option value="">Pekerjaan</option>
                            <option value="pns">PNS</option>
                            <option value="bumn">BUMN</option>
                            <option value="swasta">Swasta</option>
                            <option value="wiraswasta">Wirausaha</option>
                            <option value="lainnya">Lainnya</option>
                          </select>
                          <?= form_error('pekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-lg-12">
                          <select name="jenispekerjaan" id="jenispekerjaan" class="custom-select form-control-user-add" >
                                <?php if(set_value('jenispekerjaan')){?>
                                    <option selected value="<?php echo set_value('jenispekerjaan');  ?>"><?php echo set_value('jenispekerjaan');  ?></option>
                                <?php }?>
                            <option value="">Bidang Pekerjaan</option>
                            <option value="pemerintahan">Pemerintahan</option>
                            <option value="swasta">Swasta</option>
                            <option value="freelance">Kerja Lepas</option>
                          </select>
                          <?= form_error('jenispekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div></div>
                        
                        
                        
                    
                <div class="form-group row">
                  <div class="col-lg-12">

                   <input type="text" class="form-control form-control-user-add" id="phone" name="phone" placeholder="Nomor HP " value="<?
                   if(set_value('phone')){
                    echo set_value('phone'); 
                    }else{

                    }
                    ?>"
                    >
                    <?= form_error('phone', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  </div>
                          
                        </div>
                      </div>
                      
                      <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body">
          <h2 class="text-center">
            Data Toko
          </h2>
          
        
          
          <div class="form-group row">
                  <div class="col-lg-12">

                   <input type="text" class="form-control form-control-user-add" id="nama_toko" name="nama_toko" placeholder="Nama Toko " value="<?
                   if(set_value('nama_toko')){
                    echo set_value('nama_toko'); 
                    }else{

                    }
                    ?>"
                    >
                    <?= form_error('nama_toko', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  </div>
                  
                  
                  
            <div class="form-group row">
                  <div class="col-lg-12">

                   <input type="text" class="form-control form-control-user-add" id="alamat_toko" name="alamat_toko" placeholder="Alamat Toko " value="<?
                   if(set_value('alamat_toko')){
                    echo set_value('alamat_toko'); 
                    }else{

                    }
                    ?>"
                    >
                    <?= form_error('alamat_toko', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  </div>
                  
                  
                  
                  
                  <div class="form-group row">
                      <div class="col-lg-4">
                        <select name="provinsi_user" id="provinsi_user" class="custom-select form-control-user-add" >
                          <option value="">Propinsi</option>
                            <?php foreach ($provinces as $p) : 
                                if(set_value('provinsi_user')){
                                    if(set_value('provinsi_user') == $p['name']){?>
                                        <option selected value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                                    <?php } else{?>
                                        <option value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                                    <?php }
                                } else { ?>
                                    <option value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                                <?php }
                            endforeach;?>
                        </select>
                        <?= form_error('provinsi_user', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                      <div class="col-lg-4">
                       <select name="kota_user" id="kota_user"class="custom-select form-control-user-add" >
                        <option value="">Kota/Kabupaten</option>
                            <?php if(set_value('kota_user')){?>
                                <option selected value="<?php echo set_value('kota_user');  ?>">   <?php echo set_value('kota_user');  ?></option>
                            <?php }?>
                      </select>
                      <?= form_error('kota_user', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="col-lg-4">
                      <select name="kecamatan_user" id="kecamatan_user"class="custom-select form-control-user-add" >
                        <option value="">Kecamatan</option>
                            <?php if(set_value('kecamatan_user')){?>
                                <option selected value="<?php echo set_value('kecamatan_user');  ?>">   <?php echo set_value('kecamatan_user');  ?></option>
                            <?php }?>
                      </select>
                      <?= form_error('kecamatan_user', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                  </div>
                  
                  
                  
                  
                  
                  <div class="form-group row">
                        <div class="col-lg-12">
                          <select name="jenisusaha" id="jenisusaha" class="custom-select form-control-user-add" >
                            <?php if(set_value('jenisusaha')){?>
                                <option selected value="set_value('jenisusaha');  ?>"><?= set_value('jenisusaha');  ?></option>
                            <?php }?>
                            
                            
                            <option value="">Jenis Usaha</option>
                            <option value="perorangan">Perorangan</option>
                            <option value="koperasi">Koperasi</option>
                            
                            
                          </select>
                          <?= form_error('jenisusaha', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div></div>
                        
                        
                    <div class="form-group row">
                        <div class="col-lg-6">
                          <select name="mitra" id="mitra" class="custom-select form-control-user-add" >
                            <?php if(set_value('mitra')){
                                
                                
                                
                                
                        
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            $namakoperasi = $this->db->get_where('koperasi', ['id_koperasi' => set_value('mitra')])->row_array();
                            
                            
                            ?>
                                <option selected value="set_value('mitra');  ?>"><?=  $namakoperasi["nama_koperasi"];  ?></option>
                            <?php }?>
                            
                            
                            <option value="">Mitra</option>
                            <?php foreach ($mitra as $p) : 
                                if(set_value('mitra')){
                                    if(set_value('mitra') == $p['nama_koperasi']){?>
                                        <option selected value="<?= $p['id_koperasi'];  ?>"><?= $p['nama_koperasi'];  ?></option>
                                    <?php } else{?>
                                        <option value="<?= $p['id_koperasi'];  ?>"><?= $p['nama_koperasi'];  ?></option>
                                    <?php }
                                } else { ?>
                                    <option value="<?= $p['id_koperasi'];  ?>"><?= $p['nama_koperasi'];  ?></option>
                                <?php }
                            endforeach;?>
                            
                            
                          </select>
                          <?= form_error('mitra', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-lg-6">


                            <input id="penyimpanmitra" type="text" name="user" hidden>
                            <input type="text" class="form-control form-control-user-add" id="idmitra" name="idmitra" placeholder="ID Mitra" 
                            value="<?
                                        if(set_value('idmitra')){
                                            echo set_value('idmitra'); 
                                        }
                                    ?>">
                            <?= form_error('idmitra', '<small class="text-danger pl-3">', '</small>'); ?>
                            
                            
                            <p id="cekcek"></p>
                        
                        </div>
                    </div>
                  
          
         
        
          </div>
          
          </div>
          
          
          
          <!--ini awal bagian upload-->
          <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body">
                        <h2 class="text-center">
            Upload foto pendukung
          </h2>
                        <div class="row" style="padding:50px;">
                            <div class="col-lg-6">
                                <!--start foto -->
            <div class="form-group row">
				<div class="col-sm-12">

                            <label> Unggah foto diri :</label>
							<img src="<?= base_url('assets/img/profile/'). $user['image']; ?>" style="height: 300px !important; object-fit: cover;" for="customFile" id="img_prof" class="img-thumbnail custom-file-label ">
							<div class="custom-file text-center">
								<input type="file" class="custom-file-input img-edit" id="imagei" name="imagei" for="imagei">
								<?= form_error('imagei', '<small class="text-danger pl-3">', '</small>'); ?>
							</div>
							


				</div>
			</div>
            <script>
                $("#img_prof").click(function(){
                    $( "#imagei" ).trigger( "click" );
                    
                })
                
                var previewImage = function(input, block){
    var fileTypes = ['jpg', 'jpeg', 'png'];
    var extension = input.files[0].name.split('.').pop().toLowerCase();  /*se preia extensia*/
    var isSuccess = fileTypes.indexOf(extension) > -1; /*se verifica extensia*/
var filea = input.files[0].size;
    
    if (filea > 2000000 ) { 
                alert('ukuran file tidak sesuai'); 
                filea = ''; 
                return false; 
    }  
    
    if(isSuccess){
        var reader = new FileReader();
        
        reader.onload = function (e) {
            block.attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }else{
        alert('file type not accepted');
    }

};

$(document).on('change', '#imagei', function(){
    previewImage(this, $('#img_prof'));
});





                
            </script>
            <!--akhir foto-->
                                
                            </div>
                            
                            <div class="col-lg-6">
                                <!--start foto -->
            <div class="form-group row">
				<div class="col-sm-12">

                            <label> Unggah foto toko :</label>
							<img src="<?= base_url('assets/img/profile/'). $user['image']; ?>" style="height: 300px !important; object-fit: cover;" for="customFile" 
							id="img_toko" class="img-thumbnail custom-file-label ">
							<div class="custom-file text-center">
								<input type="file" class="custom-file-input img-edit" id="imagei_toko" name="imagei_toko" for="imagei_toko">
								<?= form_error('imagei_toko', '<small class="text-danger mr-2 pl-3">', '</small>'); ?>
							</div>
                            

				</div>
			</div>
            <script>
                $("#img_toko").click(function(){
                    $( "#imagei_toko" ).trigger( "click" );
                    
                })
                
                var previewImage = function(input, block){
    var fileTypes = ['jpg', 'jpeg', 'png'];
    var extension = input.files[0].name.split('.').pop().toLowerCase();  /*se preia extensia*/
    var isSuccess = fileTypes.indexOf(extension) > -1; /*se verifica extensia*/
    
    var filea = input.files[0].size;
    
    if (filea > 2000000 ) { 
                alert('ukuran file tidak sesuai'); 
                filea = ''; 
                return false; 
    }  
    
            
            
    if(isSuccess){
        var reader = new FileReader();
        
        reader.onload = function (e) {
            block.attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }else{
        alert('tipe file salah');
    }

};

$(document).on('change', '#imagei_toko', function(){
    previewImage(this, $('#img_toko'));
});





                
            </script>
            <!--akhir foto-->
                                
                            </div>
                            
                        </div>
                        
                        <p class="text-danger">* form ini harus di isi dan tidak boleh kosong</p>
                        <button type="submit" id="submitButon" class="btn btn-primary btn-user btn-block form-button-user-add">
                                  Simpan
                                </button>
                              </form>
                        
                        
                        </div>
                        </div>
            <!--ini akhir bagian upload-->
                        




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













                    $('#mitra').on('change', function() {
                      $("#idmitra").empty();
                      var mitra = $('#mitra :selected').val();
                      var data={mitra:mitra};
                      $.ajax({
                        type : 'post',
                        url : "<?= base_url('user/getidpesertakop'); ?>",
                        data: data,
                        success: function(result){
                          var kota = JSON.parse(result);
                          
                          $("#penyimpanmitra").val(kota[0].id_koperasi);
                          
                          
                        //   for(var i = 0; i < kota.length; i++){
                        //     // $("select#kota").append( $("<option>")
                        //     //   .val(kota[i].name)
                        //     //   .html(kota[i].name)
                        //     //   );
                        //   }
                        }
                      });
                    });
















                        //setup before functions
                        var typingTimer;                //timer identifier
                        var doneTypingInterval = 2000;  //time in ms, 5 second for example
                        var $input = $('#idmitra');

                        //on keyup, start the countdown
                        $input.on('keyup', function () {
                            
                            clearTimeout(typingTimer);
                            typingTimer = setTimeout(doneTyping, doneTypingInterval);
                        });

                        //on keydown, clear the countdown 
                        $input.on('keydown', function () {
                            clearTimeout(typingTimer);
                        });

                        //user is "finished typing," do something
                        function doneTyping () {
                        //do something
                            var mitra = $('#mitra :selected').val();
                            var data={mitra:mitra};
                            $.ajax({
                                type : 'post',
                                url : "<?= base_url('user/getidpesertakop'); ?>",
                                data: data,
                                success: function(result){
                                    
                                    
                                  var kota = JSON.parse(result);
                                //   alert($input.val());
                                //   alert(kota);
                                  
                                //   $("#penyimpanmitra").val(kota[0].id_koperasi);
                                  
                                  
                                  for(var i = 0; i < kota.length; i++){
                                      
                                      if($input.val()==kota[i].id_peserta){
                                        
                                        
                                        $("#cekcek").text("");
                                        $("#submitButon").prop('disabled', false);
                                        $("#submitButon").css('background','black');
                                           $("#submitButon").css('border','black');
                                           $("#submitButon").css('color','#fff');
                                        
                                        break;
                                          
                                      }else{
                                          $("#cekcek").text("id tidak ada");
                                          $("#cekcek").css('color','red');
                                            
                                           $("#submitButon").prop('disabled', true);
                                           
                                           $("#submitButon").css('background','rgb(226, 226, 226)');
                                           $("#submitButon").css('border','rgb(226, 226, 226)');
                                           $("#submitButon").css('color','#aaa');
                                           
                                          
                                      }
                                    // $("select#kota").append( $("<option>")
                                    //   .val(kota[i].name)
                                    //   .html(kota[i].name)
                                    //   );
                                  }
                                }
                            });
                        }





































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
                    
                    function fileValidation(ini) { 
            var fileInput =  
                document.getElementById(ini); 
              
            var filePath = fileInput.value; 
             var filea = fileInput.files[0].size;
            
            
          
            // Allowing file type 
            var allowedExtensions =  
                    /(\.jpg|\.jpeg|\.png|\.pdf)$/i; 
            if (filea > 2000000 ) { 
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
