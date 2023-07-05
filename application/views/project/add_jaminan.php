
<div class="container-fluid">
  <h1><?= $title; ?></h1>

  <div class="row">
    <div class="col-lg-8 " style="margin-left: 30px;" >
      <?= $this->session->flashdata('message'); ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-10">


      <form style="margin-top: 30px;" class="user" method="post" action="<?= base_url('project/addproyek') ?>">
        <div class="form-group">

          <input type="hidden" value="<?=$user['id']; ?>" class="form-control form-control-user-add" id="id" name="id">



        </div>
        <div class="form-group">
          <input type="text" class="form-control form-control-user-add" id="nama_project" name="nama_project" placeholder="Nama Project" value="<?
          if(set_value('nama_project')){
            echo set_value('nama_project'); 
            }else{

            }
            ?>">

            <?= form_error('nama_project', '<small class="text-danger pl-3">', '</small>'); ?>

          </div>
          <div class="form-group">
            <input maxlength="150" type="text" class="form-control form-control-user-add" id="deskripsi_project" name="deskripsi_project" placeholder="Deskripsi Project" value="<?
            if(set_value('deskripsi_project')){
              echo set_value('deskripsi_project'); 
              }else{

              }
              ?>">
              <small style="color:#4e73df!important" >*max input 150</small>
              <?= form_error('deskripsi_project', '<small class="text-danger pl-3">', '</small>'); ?>

            </div>

            <div class="form-group">
              <input type="text" class="form-control form-control-user-add" id="deadline" name="deadline" placeholder="Deadline Project MM/DD/YYY" autocomplete="off" value="<?
              if(set_value('deadline')){
                echo set_value('deadline'); 
                }else{

                }
                ?>">
                <?= form_error('deadline', '<small class="text-danger pl-3">', '</small>'); ?>

              </div>


              <div class="form-group">

                <input type="text" class="form-control form-control-user-add" id="range" name="range" placeholder="Durasi peminjaman" value="<?
                if(set_value('range')){
                  echo set_value('range'); 
                  }else{

                  }
                  ?>"
                  >
                  <p class="text-primary"> <small>*Durasi peminjaman (dalam satuan hari)</small></p>
                  <?= form_error('range', '<small class="text-danger pl-3">', '</small>'); ?>


                </div>


                <div class="form-group">

                  <input type="text" class="form-control form-control-user-add" id="akhir" name="akhir" placeholder="Batas Akhir Pengerjaan"
                    disabled >
                  </div>


                  <div class="form-group">

                    <input type="text" class="form-control form-control-user-add" id="lokasi_project" name="lokasi_project" placeholder="Lokasi Project" value="<?
                    if(set_value('lokasi_project')){
                      echo set_value('lokasi_project'); 
                      }else{

                      }
                      ?>">
                      <?= form_error('lokasi_project', '<small class="text-danger pl-3">', '</small>'); ?>

                    </div>

                    <div class="form-group">


                     <input type="text" class="form-control form-control-user-add" id="nilai_project" name="nilai_project" placeholder="Nilai Project" value="<?
                     if(set_value('nilai_project')){
                      echo set_value('nilai_project'); 
                      }else{

                      }
                      ?>"
                      >
                      <?= form_error('nilai_project', '<small class="text-danger pl-3">', '</small>'); ?>

                    </div>

                    <div class="form-group">


                     <input type="text" class="form-control form-control-user-add" id="modal_project" name="modal_project" placeholder="Modal Project" value="<?
                     if(set_value('modal_project')){
                      echo set_value('modal_project'); 
                      }else{

                      }
                      ?>"
                      >

                      <p class="text-primary"> <small>*maksimum pembiayaan modal kerja adalah Rp.2.000.000.000,<br>untuk pinjaman di atas Rp. 500.000.000, peminjam harus menambahkan jaminan </small></p>
                      <?= form_error('modal_project', '<small class="text-danger pl-3">', '</small>'); ?>

                    </div>

                    <div class="form-group row">

                      <div class="col-lg"> 
                        <input type="text" class="form-control form-control-user-add" id="keuntungan" name="keuntungan" placeholder="Presentasi Keuntungan dalam persen (%)" value="<?
                        if(set_value('keuntungan')){
                          echo set_value('keuntungan'); 
                          }else{

                          }
                          ?>"
                          ><p id="nominal_keuntungan" class="text-primary"> <small>Keuntungan : Rp. </small></p>
                          <?= form_error('keuntungan', '<small class="text-danger pl-3">', '</small>'); ?>
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




            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>


            <script type="text/javascript">


              // $("#modal_project").value();

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





          </script>


