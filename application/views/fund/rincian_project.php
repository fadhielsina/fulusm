<h2 style="margin-left: 25px;"> <?= $title; ?></h2>
<!-- Begin Page Content -->
<div class="container-fluid ">
 <div class="row">

   <div class="col-lg">
     <?php if (validation_errors()): ?>
      <div class="alert alert-danger mb-3" role="alert" >
        <?= validation_errors();?>
      </div>
    <?php endif; ?>
    <?= $this->session->flashdata('message'); ?>
  </div>
</div>

<div class="shadow" style="padding-left: 30px;margin-bottom: 50px;">

  <div class="row" style="margin-top: 50px; padding: 50px 10px ; padding-bottom: 0px;">
    <div class="col-lg">
      <h3>Detail Proyek</h3>
    </div>
  </div>
  <div class="row" style="margin-top: 50px; padding: 50px 10px ; padding-top: 0px;">
    <div class="col-lg-4">
     <small>Nama Proyek</small>
     <h5><?= $project[0]["nama_project"] ?></h5>
   </div>

   <div class="col-lg-4">
     <small>Lokasi Proyek</small>
     <h5><?= $project[0]["lokasi_project"] ?></h5>
   </div>

   <div class="col-lg-4">
    <small>Modal Proyek</small>
    <h5><?= $project[0]["nilai_project"] ?></h5>
  </div>


</div>

<div class="row" style="padding: 50px 10px ; padding-top: 0px;">
  <div class="col-lg-4">
   <small>Nilai Proyek</small>
   <h5><?= $project[0]["nilai_project"] ?></h5>
 </div>

 <div class="col-lg-4">
   <small>Modal Proyek</small>
   <h5><?= $project[0]["modal_project"] ?></h5>
 </div>




</div>

<div class="row" style="padding: 0px 10px ; padding-bottom: 20px;">
  <div class="col-lg-4">
   <small>Persentasi Keuntungan</small>
   <h5><?= $project[0]["keuntungan"] ?>%</h5>
 </div>

 <div class="col-lg-4">
   <small>Modal Proyek</small>
   <h5><?php
   if ($project[0]["status"] == 0) {
    echo "pending";
  } elseif ($project[0]["status"] == 1){
    echo "ongoing";
  } elseif ($project[0]["status"] == 2){
    echo "finish";
  }else{
    echo "rejected";
  }
  ?></h5>
</div>

<div class="col-lg-4">

</div>



</div>
<hr>
<div class="row" style="margin-top: 40px; padding: 50px 10px ; padding-bottom: 0px;padding-top: 0px;">
  <div class="col-lg">
    <h3>Detail Pemberi Proyek</h3>
  </div>
</div>



<div class="row" style="margin-top: 50px; padding: 50px 10px ; padding-top: 0px;">
  <div class="col-lg-4">
   <small>Instansi Pemberi Proyek</small>
   <h5><?= $project[0]["pemberi_project"] ?></h5>
 </div>

 <div class="col-lg-4">
   <small>Jenis Instansi Pemberi Proyek</small>
   <h5><?= $project[0]["jenis_instansi_project"] ?></h5>
 </div>

 <div class="col-lg-4">
  <small>Kota Instansi Pemberi Proyek</small>
  <h5><?= $project[0]["kota_pemberi_project"] ?></h5>
</div>



</div>

<div class="row" style="padding: 0px 10px ; padding-bottom: 20px;">
  <div class="col-lg-4">
   <small>Alamat Pemberi Proyek</small>
   <h5><?= $project[0]["alamat_pemberi_project"] ?></h5>
 </div>

 <div class="col-lg-4">
   <small>Website Instansi Pemberi Proyek</small>
   <h5><?= $project[0]["web_pemberi_project"] ?></h5>
 </div>

 <div class="col-lg-4">

 </div>



</div>


<div class="row" style="margin-bottom: 40px">
  <div class="col align-self-end" style="    margin-bottom: 49px;
  margin-top: 40px;">

  <!--<a class="btn btn-success" style="color: white"  data-toggle="modal" -->
  <!--data-target="#approveModal"-->
  <!--data-role="<?= $project[0]['project_id'] ?>"-->
  <!--data-name="<?= $project[0]['nama_project']?>">Approve</a>-->
  <!--<a style="margin-left: 10px; color: white;" -->
  <!--class="btn btn-danger" data-toggle="modal" -->
  <!--data-target="#rejectModal"-->
  <!--data-role="<?=$project[0]['project_id'] ?>"-->
  <!--data-name="<?= $project[0]['nama_project']?>">Reject</a>-->

</div>


</div>
<!-- /.container-fluid -->
</div>
</div>
<!-- End of Main Content -->
<!-- Modal Approve-->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <input type="text" class="form-control" id="title" name="title" placeholder="title" readonly="readonly">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php base_url('fund/approve') ?>" enctype="multipart/form-data" method="post">
        <div class="modal-body" style="
        ">
        Silahkan isi jika ada perubahan data :         
        <div style="visibility: hidden" class="form-group">
          <input type="hidden" class="form-control" id="id" name="id" >
        </div> 

        <div class="form-group row">
          <div class="col-lg-12">
            <label>modal proyek</label>
            <input type="text" class="form-control form-control-user-add" id="modal_project" name="modal_project" placeholder="modal project" value="<?
            if(set_value('modal_project')){
              echo set_value('modal_project'); 
              }else{
                echo $project[0]["modal_project"];
              }
              ?>">
              <?= form_error('modal_project', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-12">
              <label>range proyek</label>
              <input type="text" class="form-control form-control-user-add" id="range_project" name="range_project" placeholder="range project" value="<?
              if(set_value('range_project')){
                echo set_value('range_project'); 
                }else{
                  echo $project[0]["range_project"];
                }
                ?>">
                <?= form_error('range_project', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-lg-12">
                <div class="row">
                  <div class="col-lg-11">
                    <label>Persentasi Keuntungan</label>
                    <input type="text" class="form-control form-control-user-add" id="presentasi_keuntungan" name="presentasi_keuntungan" placeholder="presentasi keuntungan" value="<?
                    if(set_value('presentasi_keuntungan')){
                      echo set_value('presentasi_keuntungan'); 
                      }else{
                        echo $project[0]["keuntungan"];
                      }
                      ?>">
                      <?= form_error('presentasi_keuntungan', '<small class="text-danger pl-3">', '</small>'); ?></div>
                      <div style="
                      margin-top: 38px;
                      " class="col-lg-1">%</div>
                    </div>
                  </div>
                </div>  
                <div class="form-group row">
                  <div class="col-lg-12 mb-3 mb-sm-0">
                    <label>Upload Foto Proyek</label>
                    <div class="custom-file">

                      <input type="file" class="custom-file-input img-edit" id="image" name="image" for="image"/>
                      <label style="white-space: nowrap;
                      padding-right: 87px;
                      overflow: hidden;
                      text-overflow: ellipsis;
                      height: 33px;
                      font-size: .8rem;" 
                      class="custom-file-label img-label" for="image">Upload Photo file</label>
                      <small style="color: blue; font-size: 10px;">*only allow PDF and jpg file with max 2mb</small>
                      <?= form_error('image', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                <!--<button type="submit" class="btn btn-success"> Approve </button>-->
              </div>
            </form>
          </div>
        </div>
      </div>


      <!-- Modal Reject-->
      <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
             <input type="text" class="form-control" id="title" name="title" placeholder="title" readonly="readonly">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="<?php base_url('fund/reject') ?>" method="post">



            <div class="modal-body" style="
            height: 60px;
            ">
            Apakah anda yakin akan menolak pengajuan ini ?
            <div style="visibility: hidden" class="form-group">
              <input type="hidden" class="form-control" id="id" name="id" >
              <input type="hidden" class="form-control" id="reject" name="reject">
              <input type="hidden" class="custom-control-input" name="spk" id="spk" value="0">
              <input type="hidden" class="custom-control-input" name="presentasi_keuntungan" id="presentasi_keuntungan" value="0">
              <input type="hidden" class="custom-control-input" name="image" id="image" value="0">
              <input type="hidden" class="custom-control-input" name="range_project" id="range_project" value="0">
              <input type="hidden" class="custom-control-input" name="modal_project" id="modal_project" value="0">
            </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger"> Reject </button>
          </div>
        </form>
      </div>
    </div>
  </div>



  <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>

  <script type="text/javascript">

    $(document).ready(function(){
     $('#tName').DataTable();


     $('#approveModal').on('show.bs.modal', function(e){
       var id = $(e.relatedTarget).data('role');
       var name = $(e.relatedTarget).data('name');
       var data={id:id};
       $.ajax({
        type : 'post',
        url : "<?= base_url('fund/app'); ?>",
        data: data,
        success: function(data){
          $(e.currentTarget).find('input[name="id"]').val(id);
          $(e.currentTarget).find('input[name="title"]').val("Project "+name);
        }

      })



     })

     $('#rejectModal').on('show.bs.modal', function(e){
       var id = $(e.relatedTarget).data('role');
       var name = $(e.relatedTarget).data('name');
       var data={id:id};
       $.ajax({
        type : 'post',
        url : "<?= base_url('fund/app'); ?>",
        data: data,
        success: function(data){
          $(e.currentTarget).find('input[name="id"]').val(id);
          $(e.currentTarget).find('input[name="reject"]').val(id);
          $(e.currentTarget).find('input[name="title"]').val("Project "+name);
        }

      })



     })



   })


 </script>