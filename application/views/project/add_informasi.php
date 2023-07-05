
<div class="container-fluid">
  <h1><?= $title; ?></h1>

  <div class="row">
    <div class="col-lg-8 " style="margin-left: 30px;" >
      <?= $this->session->flashdata('message'); ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-10">


      <form style="margin-top: 30px;" enctype="multipart/form-data" class="user" method="post" action="<?= base_url('project/addinformasi') ?>">
        <div class="form-group">

          <input type="hidden" value="<?=$project['id']; ?>" class="form-control form-control-user-add" id="id" name="id">



        </div>
        <div class="form-group">
          <input type="text" class="form-control form-control-user-add" id="pemberi_project" name="pemberi_project" placeholder="Instansi Pemberi Project" value="<?
          if(set_value('pemberi_project')){
            echo set_value('pemberi_project'); 
            }else{

            }
            ?>">

            <?= form_error('pemberi_project', '<small class="text-danger pl-3">', '</small>'); ?>

          </div>
          <div class="form-group">

            <input type="text" class="form-control form-control-user-add" id="jenis_instansi_project" name="jenis_instansi_project" placeholder="Jenis Instansi Pemberi Project" value="<?
            if(set_value('jenis_instansi_project')){
              echo set_value('jenis_instansi_project'); 
              }else{

              }
              ?>">
              <?= form_error('jenis_instansi_project', '<small class="text-danger pl-3">', '</small>'); ?>

            </div>

            <div class="form-group">


             <input type="text" class="form-control form-control-user-add" id="kota_pemberi_project" name="kota_pemberi_project" placeholder="Asal Kota Pemberi Project" value="<?
             if(set_value('kota_pemberi_project')){
              echo set_value('kota_pemberi_project'); 
              }else{

              }
              ?>"
              >
              <?= form_error('kota_pemberi_project', '<small class="text-danger pl-3">', '</small>'); ?>

            </div>

            <div class="form-group">


             <input type="text" class="form-control form-control-user-add" id="alamat_pemberi_project" name="alamat_pemberi_project" placeholder="Alamat Pemberi Project" value="<?
             if(set_value('alamat_pemberi_project')){
              echo set_value('alamat_pemberi_project'); 
              }else{

              }
              ?>"
              >
              <?= form_error('alamat_pemberi_project', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>

            <div class="form-group">


              <input type="text" class="form-control form-control-user-add" id="web_pemberi_project" name="web_pemberi_project" placeholder="Website Pemberi Project" value="<?
              if(set_value('web_pemberi_project')){
                echo set_value('web_pemberi_project'); 
                }else{

                }
                ?>"
                >
                <?= form_error('web_pemberi_project', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>

              <div class="form-group row">
                <div class="col-lg-12 mb-3 mb-sm-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input img-edit" id="spk" name="spk" for="spk"/>
                    <label style="white-space: nowrap;
                    padding-right: 87px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    height: 33px;
                    font-size: .8rem;" 
                    class="custom-file-label img-label" for="spk">Upload SPK file</label>
                    <small style="color: blue; font-size: 10px;">*only allow PDF and jpg file with max 2mb</small>
                    <?= form_error('spk', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-lg-12 mb-3 mb-sm-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input img-edit" id="loa" name="loa" for="loa"/>
                    <label style="white-space: nowrap;
                    padding-right: 87px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    height: 33px;
                    font-size: .8rem;" 
                    class="custom-file-label img-label" for="loa">Upload LOA file</label>
                    <small style="color: blue; font-size: 10px;">*only allow PDF and jpg file with max 2mb</small>
                    <?= form_error('loa', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-lg-12 mb-3 mb-sm-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input img-edit" id="kontrak" name="kontrak" for="kontrak"/>
                    <label style="white-space: nowrap;
                    padding-right: 87px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    height: 33px;
                    font-size: .8rem;" 
                    class="custom-file-label img-label" for="kontrak">Upload Contract file</label>
                    <small style="color: blue; font-size: 10px;">*only allow PDF and jpg file with max 2mb</small>
                    <?= form_error('kontrak', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-lg-12 mb-3 mb-sm-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input img-edit" id="rekening_koran" name="rekening_koran" for="rekening_koran"/>
                    <label style="white-space: nowrap;
                    padding-right: 87px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    height: 33px;
                    font-size: .8rem;" 
                    class="custom-file-label img-label" for="rekening_koran">Upload Bank Statement file</label>
                    <small style="color: blue; font-size: 10px;">*only allow PDF and jpg file with max 2mb</small>
                    <?= form_error('rekening_koran', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
              </div>


              <div class="form-group row">
                <div class="col-lg-12 mb-3 mb-sm-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input img-edit" id="profil_perusahaan" name="profil_perusahaan" for="profil_perusahaan"/>
                    <label style="white-space: nowrap;
                    padding-right: 87px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    height: 33px;
                    font-size: .8rem;" 
                    class="custom-file-label img-label" for="profil_perusahaan">Upload Company Profile file</label>
                    <small style="color: blue; font-size: 10px;">*only allow PDF and jpg file with max 2mb</small>
                    <?= form_error('profil_perusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-lg-12 mb-3 mb-sm-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input img-edit" id="laporan_keuangan" name="laporan_keuangan" for="laporan_keuangan"/>
                    <label style="white-space: nowrap;
                    padding-right: 87px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    height: 33px;
                    font-size: .8rem;" 
                    class="custom-file-label img-label" for="laporan_keuangan">Upload Financial Report file</label>
                    <small style="color: blue; font-size: 10px;">*only allow PDF and jpg file with max 2mb</small>
                    <?= form_error('laporan_keuangan', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-lg-12 mb-3 mb-sm-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input img-edit" id="dokumen_pendukung" name="dokumen_pendukung" for="dokumen_pendukung"/>
                    <label style="white-space: nowrap;
                    padding-right: 87px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    height: 33px;
                    font-size: .8rem;" 
                    class="custom-file-label img-label" for="dokumen_pendukung">Upload Support Document (proposal) file</label>
                    <small style="color: blue; font-size: 10px;">*only allow PDF and jpg file with max 2mb</small>
                    <?= form_error('dokumen_pendukung', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-user btn-block form-button-user-add">
                Add
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

