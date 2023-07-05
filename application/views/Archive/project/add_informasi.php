
        <div class="container-fluid">
          <h1><?= $title; ?></h1>

          <div class="row">
            <div class="col-lg-8 " style="margin-left: 30px;" >
              <?= $this->session->flashdata('message'); ?>
            </div>
          </div>

<div class="row">
  <div class="col-lg-10">


<form style="margin-top: 30px;" class="user" method="post" action="<?= base_url('project/addinformasi') ?>">
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
               <button type="submit" class="btn btn-primary btn-user btn-block form-button-user-add">
                  Add
                </button>
          </div>
        </form>
      </div>
      </div>
      </div>

