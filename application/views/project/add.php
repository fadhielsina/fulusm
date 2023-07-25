<div class="container-fluid">
  <div class="row">
    <div class="col-lg-8 " style="margin-left: 30px;">
      <?= $this->session->flashdata('message'); ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12" style="    padding: 0 70px;">
      <h3 style="padding-left: 40px"><?= $title; ?></h3>

      <form style="margin-top: 30px;" enctype="multipart/form-data" class="user" method="post" action="<?= base_url('project/addproyek/' . $type . '') ?>">
        <div style="background: #f4f4f4;
        padding: 40px 58px;
        border-radius: 6px;
        box-shadow: 0 4px 4px rgba(0,0,0,.09), 0 1px 1px rgba(0,0,0,.13); ">

          <div class="form-group">
            <input type="hidden" value="<?= $user['id']; ?>" class="form-control form-control-user-add" id="id" name="id">
            <input type="hidden" value="<?= $type ?>" class="form-control form-control-user-add" id="type" name="type">
          </div>

          <p style="color: #717171;font-size: 12px;background: #e6e6e6;padding: 12px;border: #c7c6c6 1px solid;border-radius: 6px;"><b>Catatan : Pengajuan pendanaan paling lambat 18 hari sebelum proyek dimulai. </b>
          </p>
          <div class="form-group">
            <label style="
          color: black;
          font-size: 14px;
          "> Nama Proyek</label>
            <input type="text" class="form-control form-control-user-add" id="nama_project" name="nama_project" placeholder="Nama Proyek" value="<?
                                                                                                                                                  if (set_value('nama_project')) {
                                                                                                                                                    echo set_value('nama_project');
                                                                                                                                                  } else {
                                                                                                                                                  }
                                                                                                                                                  ?>">

            <?= form_error('nama_project', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>

          <div class="form-group">
            <label style="
            color: black;
            font-size: 14px;
            "> Deskripsi Proyek</label>
            <input maxlength="150" type="text" class="form-control form-control-user-add" id="deskripsi_project" name="deskripsi_project" placeholder="Penjelasan Proyek" value="<?
                                                                                                                                                                                  if (set_value('deskripsi_project')) {
                                                                                                                                                                                    echo set_value('deskripsi_project');
                                                                                                                                                                                  } else {
                                                                                                                                                                                  }
                                                                                                                                                                                  ?>">
            <small style="color:#4e73df!important">*max input 150</small>
            <?= form_error('deskripsi_project', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>

          <div class="form-group">
            <label style="
              color: black;
              font-size: 14px;
              "> Awal Mula Proyek</label>
            <input type="text" class="form-control form-control-user-add" id="deadline" name="deadline" placeholder="Awal Mula Proyek DD/MM/YYY" autocomplete="off" value="<?
                                                                                                                                                                            if (set_value('deadline')) {
                                                                                                                                                                              echo set_value('deadline');
                                                                                                                                                                            } else {
                                                                                                                                                                            }
                                                                                                                                                                            ?>">
            <?= form_error('deadline', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>


          <div class="form-group">
            <label style="
                color: black;
                font-size: 14px;
                "> Tenor Pinjaman</label>
            <input type="number" max="180" class="form-control form-control-user-add" id="range" name="range" placeholder="Tenor Pinjaman" value="<?
                                                                                                                                                  if (set_value('range')) {
                                                                                                                                                    echo set_value('range');
                                                                                                                                                  } else {
                                                                                                                                                  }
                                                                                                                                                  ?>">
            <small style="color:#4e73df!important">*Jangka Waktu peminjaman (dalam satuan hari)</small>
            <?= form_error('range', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>

          <div class="form-group">
            <label style="
                  color: black;
                  font-size: 14px;
                  "> Batas Akhir Pengerjaan </label>
            <input type="text" class="form-control form-control-user-add" id="akhir" name="akhir" placeholder="Batas Akhir Pengerjaan" disabled>
          </div>


          <div class="form-group">
            <label style="
                  color: black;
                  font-size: 14px;
                  "> Lokasi Proyek</label>
            <input type="text" class="form-control form-control-user-add" id="lokasi_project" name="lokasi_project" placeholder="Lokasi Proyek" value="<?
                                                                                                                                                        if (set_value('lokasi_project')) {
                                                                                                                                                          echo set_value('lokasi_project');
                                                                                                                                                        } else {
                                                                                                                                                        }
                                                                                                                                                        ?>">
            <?= form_error('lokasi_project', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>

          <div class="form-group">
            <label style="
                    color: black;
                    font-size: 14px;
                    "> Modal Proyek</label>
            <input type="text" class="form-control form-control-user-add" id="modal_project" name="modal_project" placeholder="Modal Proyek" value="<?
                                                                                                                                                    if (set_value('modal_project')) {
                                                                                                                                                      echo set_value('modal_project');
                                                                                                                                                    } else {
                                                                                                                                                    }
                                                                                                                                                    ?>">

            <small class="text-primary">*maksimum pinjaman modal kerja adalah Rp.10.000.000.000</small>
            <?= form_error('modal_project', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>


          <!-- //////// -->


          <div class="form-group">
            <label style="
                      color: black;
                      font-size: 14px;
                      "> Jaminan Proyek</label>
            <div class="row">

              <div class="col-lg-4">

                <select name="jenis_jaminan" id="jenis_jaminan" class="custom-select form-control-user-add">
                  <?php if (set_value('jenis_jaminan')) { ?>
                    <option selected value="<?php echo set_value('jenis_jaminan');  ?>"> <?php echo set_value('jenis_jaminan');  ?></option>
                  <?php } ?>
                  <option value="">Jenis Jaminan</option>
                  <option value="bangunan">Bangunan</option>
                  <option value="tanah">Tanah</option>
                </select>

                <?= form_error('jenis_jaminan', '<small class="text-danger pl-3">', '</small>'); ?>

              </div>



              <div class="col-lg-4">

                <input type="text" class="form-control form-control-user-add" id="nomor_sertifikat" name="nomor_sertifikat" placeholder="Nomor Sertifikat" value="<?
                                                                                                                                                                  if (set_value('nomor_sertifikat')) {
                                                                                                                                                                    echo set_value('nomor_sertifikat');
                                                                                                                                                                  } else {
                                                                                                                                                                  }
                                                                                                                                                                  ?>">
                <?= form_error('nomor_sertifikat', '<small class="text-danger pl-3">', '</small>'); ?>

              </div>


              <div class="col-lg-4">


                <input type="file" class="custom-file-input form-control-user-add" onchange="return fileValidation('sert_file')" id="sert_file" name="sert_file">
                <label class="custom-file-label form-control-user-add" for="sert_file">Upload File</label>

                <?= form_error('sert_file', '<small class="text-danger pl-3">', '</small>'); ?>


              </div>

            </div>
            <p class="text-primary"> <small>*Jaminan berupa sertifikat tanah / rumah</small></p>

          </div>



          <!-- //////////// -->








          <div class="form-group row">

            <div class="col-lg">
              <label style="
                          color: black;
                          font-size: 14px;
                          "> Persentasi Keuntungan</label>
              <input type="text" class="form-control form-control-user-add" id="keuntungan" name="keuntungan" placeholder="Presentasi Keuntungan dalam persen (%)" value="<?
                                                                                                                                                                          if (set_value('keuntungan')) {
                                                                                                                                                                            echo set_value('keuntungan');
                                                                                                                                                                          } else {
                                                                                                                                                                          }
                                                                                                                                                                          ?>"> <small id="nominal_keuntungan" class="text-primary">Keuntungan untuk Pemodal : Rp. </small>
              <?= form_error('keuntungan', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>

          </div>

        </div>


        <!-- ============================================================================================= -->

        <div style="background: #f4f4f4;
                      padding: 40px 58px;
                      border-radius: 6px;
                      box-shadow: 0 4px 4px rgba(0,0,0,.09), 0 1px 1px rgba(0,0,0,.13); 
                      margin-top: 30px;
                      margin-bottom: 30px;">
          <h4 style="color: black; text-transform: capitalize; " class="mb-5"> Tambahkan Detail Proyek</h4>

          <?php if ($type == 2) : ?>

            <div class="form-group">
              <label style="
                        color: black;
                        font-size: 14px;
                        "> Instansi Pemberi Proyek</label>
              <input type="text" class="form-control form-control-user-add" id="pemberi_project" name="pemberi_project" placeholder="Instansi Pemberi Proyek" value="<?
                                                                                                                                                                      if (set_value('pemberi_project')) {
                                                                                                                                                                        echo set_value('pemberi_project');
                                                                                                                                                                      } else {
                                                                                                                                                                      }
                                                                                                                                                                      ?>">

              <?= form_error('pemberi_project', '<small class="text-danger pl-3">', '</small>'); ?>

            </div>
            <div class="form-group">
              <label style="
                          color: black;
                          font-size: 14px;
                          "> Jenis Instansi Pemberi Proyek</label>
              <input type="text" class="form-control form-control-user-add" id="jenis_instansi_project" name="jenis_instansi_project" placeholder="Jenis Instansi Pemberi Proyek" value="<?
                                                                                                                                                                                          if (set_value('jenis_instansi_project')) {
                                                                                                                                                                                            echo set_value('jenis_instansi_project');
                                                                                                                                                                                          } else {
                                                                                                                                                                                          }
                                                                                                                                                                                          ?>">
              <?= form_error('jenis_instansi_project', '<small class="text-danger pl-3">', '</small>'); ?>

            </div>

            <div class="form-group">
              <label style="
                           color: black;
                           font-size: 14px;
                           "> Asal Kota Pemberi Proyek</label>

              <input type="text" class="form-control form-control-user-add" id="kota_pemberi_project" name="kota_pemberi_project" placeholder="Asal Kota Pemberi Proyek" value="<?
                                                                                                                                                                                if (set_value('kota_pemberi_project')) {
                                                                                                                                                                                  echo set_value('kota_pemberi_project');
                                                                                                                                                                                } else {
                                                                                                                                                                                }
                                                                                                                                                                                ?>">
              <?= form_error('kota_pemberi_project', '<small class="text-danger pl-3">', '</small>'); ?>

            </div>

            <div class="form-group">
              <label style="
                            color: black;
                            font-size: 14px;
                            "> Alamat Pemberi Proyek</label>

              <input type="text" class="form-control form-control-user-add" id="alamat_pemberi_project" name="alamat_pemberi_project" placeholder="Alamat Pemberi Proyek" value="<?
                                                                                                                                                                                  if (set_value('alamat_pemberi_project')) {
                                                                                                                                                                                    echo set_value('alamat_pemberi_project');
                                                                                                                                                                                  } else {
                                                                                                                                                                                  }
                                                                                                                                                                                  ?>">
              <?= form_error('alamat_pemberi_project', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>

            <div class="form-group">
              <label style="
                              color: black;
                              font-size: 14px;
                              "> Website Pemberi Proyek</label>

              <input type="text" class="form-control form-control-user-add" id="web_pemberi_project" name="web_pemberi_project" placeholder="Website Pemberi Proyek" value="<?
                                                                                                                                                                            if (set_value('web_pemberi_project')) {
                                                                                                                                                                              echo set_value('web_pemberi_project');
                                                                                                                                                                            } else {
                                                                                                                                                                            }
                                                                                                                                                                            ?>">
              <?= form_error('web_pemberi_project', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>

            <div class="form-group row">
              <div class="col-lg-12 mb-3 mb-sm-0">
                <label style="
                                 color: black;
                                 font-size: 14px;
                                 "> Unggah dokumen SPK</label>
                <div class="custom-file">

                  <input type="file" class="custom-file-input img-edit" id="spk" onchange="return fileValidation('spk')" name="spk" for="spk" />
                  <label style="white-space: nowrap;
                                  padding-right: 87px;
                                  overflow: hidden;
                                  text-overflow: ellipsis;
                                  height: 33px;
                                  font-size: .8rem;" class="custom-file-label img-label" for="spk">Unggah dokumen SPK</label>
                  <small style="color: blue; font-size: 10px;">*Hanya mengizinkan dokumen PDF dan jpg dengan maksimal ukuran dokumen 6mb</small>
                  <?= form_error('spk', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-lg-12 mb-3 mb-sm-0">
                <label style="
                               color: black;
                               font-size: 14px;
                               "> Unggah dokumen LOA</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input img-edit" id="loa" onchange="return fileValidation('loa')" name="loa" for="loa" />
                  <label style="white-space: nowrap;
                                padding-right: 87px;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                height: 33px;
                                font-size: .8rem;" class="custom-file-label img-label" for="loa">Unggah dokumen LOA</label>
                  <small style="color: blue; font-size: 10px;">*Hanya mengizinkan dokumen PDF dan jpg dengan maksimal ukuran dokumen 6mb</small>
                  <?= form_error('loa', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-lg-12 mb-3 mb-sm-0">
                <label style="
                              color: black;
                              font-size: 14px;
                              "> Unggah dokumen kontrak</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input img-edit" id="kontrak" onchange="return fileValidation('kontrak')" name="kontrak" for="kontrak" />
                  <label style="white-space: nowrap;
                                padding-right: 87px;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                height: 33px;
                                font-size: .8rem;" class="custom-file-label img-label" for="kontrak">Unggah dokumen kontrak</label>
                  <small style="color: blue; font-size: 10px;">*Hanya mengizinkan dokumen PDF dan jpg dengan maksimal ukuran dokumen 6mb</small>
                  <?= form_error('kontrak', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
            </div>

          <?php endif; ?>

          <!-- Ekuitas -->

          <div class="form-group row">
            <div class="col-lg-12 mb-3 mb-sm-0">
              <label style="
                              color: black;
                              font-size: 14px;
                              "> Unggah dokumen rekening koran</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input img-edit" id="rekening_koran" onchange="return fileValidation('rekening_koran')" name="rekening_koran" for="rekening_koran" />
                <label style="white-space: nowrap;
                                padding-right: 87px;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                height: 33px;
                                font-size: .8rem;" class="custom-file-label img-label" for="rekening_koran">Unggah dokumen rekening koran</label>
                <small style="color: blue; font-size: 10px;">*Hanya mengizinkan dokumen PDF dan jpg dengan maksimal ukuran dokumen 6mb</small>
                <?= form_error('rekening_koran', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
          </div>


          <div class="form-group row">
            <div class="col-lg-12 mb-3 mb-sm-0">
              <label style="
                              color: black;
                              font-size: 14px;
                              "> Unggah dokumen profil perusahaan</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input img-edit" id="profil_perusahaan" onchange="return fileValidation('profil_perusahaan')" name="profil_perusahaan" for="profil_perusahaan" />
                <label style="white-space: nowrap;
                                padding-right: 87px;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                height: 33px;
                                font-size: .8rem;" class="custom-file-label img-label" for="profil_perusahaan">Unggah dokumen profil perusahaan</label>
                <small style="color: blue; font-size: 10px;">*Hanya mengizinkan dokumen PDF dan jpg dengan maksimal ukuran dokumen 6mb</small>
                <?= form_error('profil_perusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-lg-12 mb-3 mb-sm-0">
              <label style="
                              color: black;
                              font-size: 14px;
                              "> Unggah dokumen Laporan Keuangan</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input img-edit" id="laporan_keuangan" onchange="return fileValidation('laporan_keuangan')" name="laporan_keuangan" for="laporan_keuangan" />
                <label style="white-space: nowrap;
                                padding-right: 87px;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                height: 33px;
                                font-size: .8rem;" class="custom-file-label img-label" for="laporan_keuangan">Unggah dokumen Laporan Keuangan </label>
                <small style="color: blue; font-size: 10px;">*Hanya mengizinkan dokumen PDF dan jpg dengan maksimal ukuran dokumen 6mb</small>
                <?= form_error('laporan_keuangan', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-12 mb-3 mb-sm-0">
              <label style="
                              color: black;
                              font-size: 14px;
                              "> Unggah dokumen Pendukung (proposal)</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input img-edit" id="dokumen_pendukung" onchange="return fileValidation('dokumen_pendukung')" name="dokumen_pendukung" for="dokumen_pendukung" />
                <label style="white-space: nowrap;
                                padding-right: 87px;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                height: 33px;
                                font-size: .8rem;" class="custom-file-label img-label" for="dokumen_pendukung">Unggah dokumen Pendukung (proposal)</label>
                <small style="color: blue; font-size: 10px;">*Hanya mengizinkan dokumen PDF dan jpg dengan maksimal ukuran dokumen 6mb</small>
                <?= form_error('dokumen_pendukung', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-user btn-block form-button-user-add">
            Simpan
          </button>
        </div>


    </div>

    <!-- =========================================================================================================================== -->

  </div>




  </form>

</div>
</div>




<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />


<script type="text/javascript">
  document.getElementById("modal_project").onchange = function() {
    myFunction()
  };

  function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
      textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        }
      });
    });
  }


  setInputFilter(document.getElementById("keuntungan"), function(value) {
    return /^\d*\.?\d*$/.test(value);
  });

  setInputFilter(document.getElementById("range"), function(value) {
    return /^-?\d*$/.test(value);
  });
  setInputFilter(document.getElementById("modal_project"), function(value) {
    return /^\d*\.?\d*$/.test(value);
  });
  setInputFilter(document.getElementById("nilai_project"), function(value) {
    return /^\d*\.?\d*$/.test(value);
  });

  function fileValidation(ini) {
    var fileInput =
      document.getElementById(ini);

    var filePath = fileInput.value;

    // Allowing file type 
    var allowedExtensions =
      /(\.jpg|\.jpeg|\.png|\.pdf)$/i;

    if (!allowedExtensions.exec(filePath)) {
      alert('Tipe file tidak sesuai');
      fileInput.value = '';
      return false;
    }
  }
</script>