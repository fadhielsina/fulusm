<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-35VN14CNFE"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-35VN14CNFE');
</script>

<div style="background: white;
padding-top: 1px;
padding-bottom: 1px;
box-shadow: 0px 0px 20px #d4d4d4;
margin-top: -50px;" class="jumbotron jumbotron-fluid">
    <div class="container">

        <h6 class="text-center mb-4">
            <img class="mx-auto " style="margin-top: 25px" src="<?= base_url(); ?>assetsprofile/asset/images/dealfintech.jpg" width="100"><br>
            Silahkan lengkapi data pribadi Anda
        </h6>
    </div>
</div>


<button id="nyalakan" style="display: none;" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#ambilFotoModal">Nyalakan Kamera</button>
<canvas style="display: none;" id="canvas" width=320 height=240></canvas>

<div class="row">

    <div class="col-lg-9 mx-auto">
        <div class="card o-hidden border-0 shadow-lg my-9">
            <!--??????????????????????????????????????-->
            <div class="card-body">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <h2 class="text-center">
                        Data Pribadi
                    </h2>

                    <form style="margin-top: 30px;" enctype="multipart/form-data" class="user" method="post" action="<?= base_url('user') ?>">
                        <div class="form-group">

                            <input type="hidden" value="<?= $user['id']; ?>" class="form-control form-control-user-add" id="id" name="id">

                            <div class="row">
                                <div class="col-lg-2 col-sm-12">
                                    <select name="gender" id="gender" class="custom-select form-control-user-add">
                                        <?php if (set_value('gender')) {
                                            if (set_value('gender') == 'p') { ?>
                                                <option selected value="<?php echo set_value('gender');  ?>"> Ibu</option>

                                            <?php
                                            } else {
                                            ?>
                                                <option selected value="<?php echo set_value('gender');  ?>"> Bapak</option>
                                            <?php
                                            }
                                            ?>
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
                                                                                                                                                            }
                                                                                                                                                            ?>">

                                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>

                            </div>




                        </div>

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

                        <div class="row">
                            <div class="col">
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

                                <div class="form-group row">
                                    <div class="col-sm-8 mb-3 mb-sm-0">

                                        <input type="text" class="form-control form-control-user-add" id="phone" name="phone" placeholder="Nomor Telepon" value="<?
                                                                                                                                                                    if (set_value('phone')) {
                                                                                                                                                                        echo set_value('phone');
                                                                                                                                                                    } else {
                                                                                                                                                                    }
                                                                                                                                                                    ?>">
                                        <?= form_error('phone', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-user-add" id="extention" name="extention" placeholder="Ekstensi" value="<?
                                                                                                                                                                    if (set_value('extention')) {
                                                                                                                                                                        echo set_value('extention');
                                                                                                                                                                    } else {
                                                                                                                                                                    }
                                                                                                                                                                    ?>">
                                        <?= form_error('extention', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                </div>

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
                                        <input type="date" class="form-control form-control-user-add" id="birthdate" name="birthdate" placeholder="Tanggal Lahir" value="<?
                                                                                                                                                                            if (set_value('birthdate')) {
                                                                                                                                                                                echo set_value('birthdate');
                                                                                                                                                                            } else {
                                                                                                                                                                            }
                                                                                                                                                                            ?>">
                                        <?= form_error('birthdate', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                </div>
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
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <select name="agama" id="agama" class="custom-select form-control-user-add">\
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



                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 mb-3 mb-sm-0">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input img-edit" required id="image" onchange="return fileValidation('image')" name="image" for="image" />
                                    <label style="white-space: nowrap;
                        padding-right: 87px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        height: 33px;
                        font-size: .8rem;" class="custom-file-label img-label" for="image">Unggah KTP</label>
                                    <small style="color: blue; font-size: 10px;">*Gunakan File PDF atau JPG dengan ukuran Maksimal 2 Mb</small>
                                    <?= form_error('image', '<br><small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3 mb-sm-0">

                                <input type="text" class="form-control form-control-user-add" id="noktp" maxlength="16" name="noktp" placeholder="Nomor KTP" value="<?
                                                                                                                                                                    if (set_value('noktp')) {
                                                                                                                                                                        echo set_value('noktp');
                                                                                                                                                                    } else {
                                                                                                                                                                    }
                                                                                                                                                                    ?>">
                                <?= form_error('noktp', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <select name="pekerjaan" id="pekerjaan" class="custom-select form-control-user-add">
                                    <?php if (set_value('pekerjaan')) { ?>
                                        <option selected value="<?php echo set_value('pekerjaan');  ?>"><?php echo set_value('pekerjaan');  ?></option>
                                    <?php } ?>
                                    <option value="">Pekerjaan</option>
                                    <option value="pns">PNS</option>
                                    <option value="bumn">BUMN</option>
                                    <option value="swasta">Swasta</option>
                                    <option value="wiraswasta">Wirausaha</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                                <?= form_error('jenispekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <select name="jenispekerjaan" id="jenispekerjaan" class="custom-select form-control-user-add">
                                    <option value="">Bidang Pekerjaan</option>
                                    <?php if (set_value('jenispekerjaan')) { ?>
                                        <option selected value="<?php echo set_value('jenispekerjaan');  ?>"><?php echo set_value('jenispekerjaan');  ?></option>
                                    <?php } ?>
                                    <option value="pemerintahan">Pemerintahan</option>
                                    <option value="swasta">Swasta</option>
                                    <option value="freelance">Kerja Lepas</option>
                                </select>
                                <?= form_error('jenispekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
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

                </div>

                <!--?????????????????????-->
            </div>

        </div>
        <div class="card o-hidden border-0 shadow-lg my-5">


            <div class="card-body">
                <!--////////////////////////////////////////-->





                <div class="tab-pane" id="pills-profile" role="tabpanel" aria-labelledby="pills-home-tab">
                    <h2 class="text-center">
                        Data Perusahaan
                    </h2>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <input type="text" class="form-control form-control-user-add" id="idperusahaan" name="idperusahaan" placeholder="No Akta Perusahaan" value="<?
                                                                                                                                                                        if (set_value('idperusahaan')) {
                                                                                                                                                                            echo set_value('idperusahaan');
                                                                                                                                                                        } else {
                                                                                                                                                                        }
                                                                                                                                                                        ?>">
                            <?= form_error('idperusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4 mb-3 mb-sm-0">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input img-edit" required onchange="return fileValidation('image3')" id="image3" name="image3" for="image3" />
                                <label style="white-space: nowrap;
                                  padding-right: 87px;
                                  overflow: hidden;
                                  text-overflow: ellipsis;
                                  height: 33px;
                                  font-size: .8rem;" class="custom-file-label img-label" for="image3">Unggah Akta Perusahaan</label>
                                <small style="color: blue; font-size: 10px;">*Gunakan File PDF atau JPG dengan ukuran Maksimal 2 Mb</small>
                                <?= form_error('image3', '<br> <small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3 mb-sm-0">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input img-edit" required id="image4" onchange="return fileValidation('image4')" name="image4" for="image4" />
                                <label style="white-space: nowrap;
                                  padding-right: 87px;
                                  overflow: hidden;
                                  text-overflow: ellipsis;
                                  height: 33px;
                                  font-size: .8rem;" class="custom-file-label img-label" for="image4">Unggah SIUP</label>
                                <small style="color: blue; font-size: 10px;">*Gunakan File PDF atau JPG dengan ukuran Maksimal 2 Mb</small>
                                <?= form_error('image4', '<br><small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3 mb-sm-0">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input img-edit" required id="image5" onchange="return fileValidation('image5')" name="image5" for="image5" />
                                <label style="white-space: nowrap;
                                  padding-right: 87px;
                                  overflow: hidden;
                                  text-overflow: ellipsis;
                                  height: 33px;
                                  font-size: .8rem;" class="custom-file-label img-label" for="image5">Unggah TDP</label>
                                <small style="color: blue; font-size: 10px;">*Gunakan File PDF atau JPG dengan ukuran Maksimal 2 Mb</small>
                                <?= form_error('image5', '<br><small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <select name="type" id="type" class="custom-select form-control-user-add">
                                <?php if (set_value('type')) { ?>
                                    <option selected value="<?= set_value('type');  ?>"><?= set_value('type');  ?></option>
                                <?php } ?>
                                <option value="">Jenis Perusahaan</option>
                                <option value="PT">PT</option>
                                <option value="cv">CV</option>
                                <option value="koprasi">Koperasi</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <?= form_error('type', '<br><small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-user-add" id="perusahaan" name="perusahaan" placeholder="Nama Perusahaan" value="<?
                                                                                                                                                                    if (set_value('perusahaan')) {
                                                                                                                                                                        echo set_value('perusahaan');
                                                                                                                                                                    } else {
                                                                                                                                                                    }
                                                                                                                                                                    ?>">
                            <?= form_error('perusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input img-edit" id="image6" required onchange="return fileValidation('image6')" name="image6" for="image6" />
                                <label style="white-space: nowrap;
                                  padding-right: 87px;
                                  overflow: hidden;
                                  text-overflow: ellipsis;
                                  height: 33px;
                                  font-size: .8rem;" class="custom-file-label img-label" for="image6">Unggah Profil Perusahaan</label>
                                <small style="color: blue; font-size: 10px;">*Gunakan File PDF atau JPG dengan ukuran Maksimal 2 Mb</small>
                                <?= form_error('image6', '<br><small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <select name="kategoribisnis" id="kategoribisnis" class="custom-select form-control-user-add">
                                <?php if (set_value('kategoribisnis')) { ?>
                                    <option selected value="<?= set_value('kategoribisnis');  ?>"><?= set_value('kategoribisnis');  ?></option>
                                <?php } ?>
                                <option value="">Kategori Perusahaan</option>

                                <option value="agrikultur">Agrikultur</option>
                                <option value="teknologi">Teknologi</option>
                                <option value="infrastuktur">Infrastuktur</option>
                                <option value="ekonomi kreatif">Ekonomi Kreatif</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <?= form_error('kategoribisnis', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>




                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 mb-3 mb-sm-0">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input img-edit" required onchange="return fileValidation('image2')" id="image2" name="image2" for="image2" />
                                <label style="white-space: nowrap;
                                  padding-right: 87px;
                                  overflow: hidden;
                                  text-overflow: ellipsis;
                                  height: 33px;
                                  font-size: .8rem;" class="custom-file-label img-label" for="image2">Unggah NPWP</label>
                                <small style="color: blue; font-size: 10px;">*Gunakan File PDF atau JPG dengan ukuran Maksimal 2 Mb</small>
                                <?= form_error('image2', '<br><small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3 mb-sm-0">

                            <input type="text" class="form-control form-control-user-add" id="nonpwp" maxlength="15" name="nonpwp" placeholder="Nomor NPWP" value="<?
                                                                                                                                                                    if (set_value('nonpwp')) {
                                                                                                                                                                        echo set_value('nonpwp');
                                                                                                                                                                    } else {
                                                                                                                                                                    }
                                                                                                                                                                    ?>">
                            <?= form_error('nonpwp', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <select name="status_kantor" id="status_kantor" class="custom-select form-control-user-add">
                                <?php if (set_value('status_kantor')) { ?>
                                    <option selected value="<?= set_value('status_kantor');  ?>"><?= set_value('status_kantor');  ?></option>
                                <?php } ?>
                                <option value="">Status Kantor</option>
                                <option value="sewa">Sewa</option>
                                <option value="kepemilikan sendiri">Kepemilikan Sendiri</option>
                            </select>
                            <?= form_error('status_kantor', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control form-control-user-add" id="jumlah_karyawan" name="jumlah_karyawan" placeholder="Jumlah Karyawan" value="<?

                                                                                                                                                                            if (set_value('jumlah_karyawan')) {
                                                                                                                                                                                echo set_value('jumlah_karyawan');
                                                                                                                                                                            } else {
                                                                                                                                                                            }
                                                                                                                                                                            ?>">
                            <?= form_error('jumlah_karyawan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control form-control-user-add" id="tahun_berdiri" name="tahun_berdiri" placeholder="Berdiri Sejak " value="<?

                                                                                                                                                                        if (set_value('tahun_berdiri')) {
                                                                                                                                                                            echo set_value('tahun_berdiri');
                                                                                                                                                                        } else {
                                                                                                                                                                        }
                                                                                                                                                                        ?>">
                            <?= form_error('tahun_berdiri', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <select name="provinsi" id="provinsi" class="custom-select form-control-user-add">
                                <option value="">Propinsi</option>
                                <?php foreach ($provinces as $p) :
                                    if (set_value('provinsi')) {
                                        if (set_value('provinsi') == $p['name']) { ?>
                                            <option selected value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                                        <?php }
                                    } else { ?>
                                        <option value="<?= $p['name'];  ?>"><?= $p['name'];  ?></option>
                                <?php }
                                endforeach; ?>

                            </select>
                            <?= form_error('provinsi', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-lg-4">
                            <select name="kota" id="kota" class="custom-select form-control-user-add">
                                <option value="">Kota/Kabupaten</option>
                                <?php if (set_value('kota')) { ?>
                                    <option selected value="<?php echo set_value('kota');  ?>"> <?php echo set_value('kota');  ?></option>
                                <?php } ?>

                            </select>
                            <?= form_error('kota', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-lg-4">
                            <select name="kecamatan" id="kecamatan" class="custom-select form-control-user-add">
                                <option value="">Kecamatan</option>
                                <?php if (set_value('kecamatan')) { ?>
                                    <option selected value="<?php echo set_value('kecamatan');  ?>"> <?php echo set_value('kecamatan');  ?></option>
                                <?php } ?>
                            </select>
                            <?= form_error('kecamatan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <input type="text" id="tlpPerusahaan" class="form-control form-control-user-add" name="tlpPerusahaan" id="tlpPerusahaan" class="custom-select form-control-user-add" placeholder="Nomor Telepon Perusahaan" value="<?

                                                                                                                                                                                                                                                if (set_value('tlpPerusahaan')) {
                                                                                                                                                                                                                                                    echo set_value('tlpPerusahaan');
                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                ?>">
                            <?= form_error('tlpPerusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control form-control-user-add" name="alamatWeb" id="alamatWeb" class="custom-select form-control-user-add" placeholder="Situs Perusahaan" value="<?

                                                                                                                                                                                                            if (set_value('alamatWeb')) {
                                                                                                                                                                                                                echo set_value('alamatWeb');
                                                                                                                                                                                                            } else {
                                                                                                                                                                                                            }
                                                                                                                                                                                                            ?>">
                            <?= form_error('alamatWeb', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>





                    <div class="form-group row">
                        <div class="col-lg-12">
                            <input type="text" class="form-control form-control-user-add" id="rekening_perusahaan" name="rekening_perusahaan" placeholder="Nomor Rekening Bank Perusahaan" value="<?
                                                                                                                                                                                                    if (set_value('rekening_perusahaan')) {
                                                                                                                                                                                                        echo set_value('rekening_perusahaan');
                                                                                                                                                                                                    } else {
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?>">
                            <?= form_error('rekening_perusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <input type="text" class="form-control form-control-user-add" id="rekening_perusahaan_nama" name="rekening_perusahaan_nama" placeholder="Nama Rekening Perusahaan" value="<?
                                                                                                                                                                                                        if (set_value('rekening_perusahaan_nama')) {
                                                                                                                                                                                                            echo set_value('rekening_perusahaan_nama');
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                        }
                                                                                                                                                                                                        ?>">
                            <?= form_error('rekening_perusahaan_nama', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <input type="text" class="form-control form-control-user-add" id="bank_name" name="bank_name" placeholder="Nama Bank" value="<?
                                                                                                                                                            if (set_value('bank_name')) {
                                                                                                                                                                echo set_value('bank_name');
                                                                                                                                                            } else {
                                                                                                                                                            }
                                                                                                                                                            ?>">
                            <?= form_error('bank_name', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary btn-user btn-block form-button-user-add">
                        Simpan
                    </button>
                    </form>

                </div>









                <!--/////////////////////////////////////-->
            </div>
        </div>




    </div>


</div>


<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

<script type="text/javascript">
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





    $("#rekening_perusahaan").inputFilter(function(value) {
        return /^-?\d*$/.test(value) && (value === "" || value.length <= 16);
    });


    $("#phone").inputFilter(function(value) {
        return /^-?\d*[+]?\d*$/.test(value) && (value === "" || value.length <= 16);
    });

    $("#tlpPerusahaan").inputFilter(function(value) {
        return /^-?\d*[+]?\d*$/.test(value) && (value === "" || value.length <= 16);
    });


    $('[data-trigger="tab"]').click(function(e) {

        var href = $(this).attr('href');
        e.preventDefault();
        $('[data-toggle="tab"][href="' + href + '"]').trigger('click');


    });


    $('#provinsi').on('change', function() {
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

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-35VN14CNFE"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-35VN14CNFE');
</script>