
        <div class="container-fluid">
          <h1><?= $title; ?></h1>

          <div class="row">
            <div class="col-lg-8 " style="margin-left: 30px;" >
              <?= $this->session->flashdata('message'); ?>
            </div>
          </div>

<div class="row">
  <div class="col-lg-10">

<form style="margin-top: 30px;" class="user" method="post" enctype="multipart/form-data" accept-charset="utf-8"action="<?= base_url('project/adddokumen') ?>">
                <div class="form-group">

                  <input type="hidden" value="<?=$project['id']; ?>" class="form-control form-control-user-add" id="id" name="id">


                  <div class="row">
                      <div class="form-group col-lg-6">
                         <p>Upload SPK</p>
                        <div class="custom-file">
                           
                            <input type="file" class="custom-file-input" id="spk" name="spk">
                            <label class="custom-file-label" for="spk">Choose file</label>
                        </div>
                        <?= form_error('spk', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>


                      <div class="form-group col-lg-6">
                        <p>Upload BAST</p>
                        <div class="custom-file">
                            
                            <input type="file" class="custom-file-input" id="bast" name="bast">
                            <label class="custom-file-label" for="bast">Choose file</label>
                        </div>
                        <?= form_error('bast', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>

                  </div>


                  <div class="row">
                      <div class="form-group col-lg-6">
                         <p>Upload Kontrak</p>
                        <div class="custom-file">
                           
                            <input type="file" class="custom-file-input" id="kontrak" name="kontrak">
                            <label class="custom-file-label" for="kontrak">Choose file</label>
                        </div>
                        <?= form_error('kontrak', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>


                      <div class="form-group col-lg-6">
                        <p>Upload Invoice</p>
                        <div class="custom-file">
                            
                            <input type="file" class="custom-file-input" id="invoice" name="invoice">
                            <label class="custom-file-label" for="invoice">Choose file</label>
                        </div>
                        <?= form_error('invoice', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>

                  </div>
               
                  <div class="row">
                      <div class="form-group col-lg-6">
                         <p>Upload Rekening Koran</p>
                        <div class="custom-file">
                           
                            <input type="file" class="custom-file-input" id="rekening_koran" name="rekening_koran">
                            <label class="custom-file-label" for="rekening_koran">Choose file</label>
                        </div>
                        <?= form_error('rekening_koran', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>


                      <div class="form-group col-lg-6">
                        <p>Upload Profil Perusahaan</p>
                        <div class="custom-file">
                            
                            <input type="file" class="custom-file-input" id="profil_perusahaan" name="profil_perusahaan">
                            <label class="custom-file-label" for="profil_perusahaan">Choose file</label>
                        </div>
                        <?= form_error('profil_perusahaan', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>

                  </div>

                <div class="row">
                      <div class="form-group col-lg-6">
                         <p>Upload Laporan Keuangan</p>
                        <div class="custom-file">
                           
                            <input type="file" class="custom-file-input" id="laporan_keuangan" name="laporan_keuangan">
                            <label class="custom-file-label" for="laporan_keuangan">Choose file</label>
                        </div>
                        <?= form_error('laporan_keuangan', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>


                      <div class="form-group col-lg-6">
                        <p>Upload Dokumen Pendukung</p>
                        <div class="custom-file">
                            
                            <input type="file" class="custom-file-input" id="dokumen_pendukung" name="dokumen_pendukung">
                            <label class="custom-file-label" for="dokumen_pendukung">Choose file</label>
                        </div>
                        <?= form_error('dokumen_pendukung', '<small class="text-danger pl-3">', '</small>'); ?>
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

