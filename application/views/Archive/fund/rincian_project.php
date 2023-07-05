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

 <div class="col-lg-4">
  <small>Range Proyek</small>
  <h5><?= $project[0]["range_project"] ?> hari </h5>
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
  } else{
    echo "finish";
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

  <a class="btn btn-success" style="color: white"  data-toggle="modal" 
  data-target="#approveModal"
  data-role="<?= $project[0]['project_id'] ?>"
  data-name="<?= $project[0]['nama_project']?>">Disetujui</a>
  <a style="margin-left: 10px; color: white;" 
  class="btn btn-danger" data-toggle="modal" 
  data-target="#rejectModal"
  data-role="<?=$project[0]['project_id'] ?>"
  data-name="<?= $project[0]['nama_project']?>">Ditolak</a>

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

      <form action="<?php base_url('fund/approve') ?>" method="post">



        <div class="modal-body" style="
        ">
        Ceklis bila data sudah diupload oleh pengaju, lalu klik disetujui untuk menyetujui proyek       
        <div style="visibility: hidden" class="form-group">
          <input type="hidden" class="form-control" id="id" name="id" >
        </div> 

        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" name="spk" id="spk">
          <label class="custom-control-label" for="spk">SPK</label>
        </div>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" name="bast" id="bast">
          <label class="custom-control-label" for="bast">BAST</label>
        </div>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" name="kontrak" id="kontrak">
          <label class="custom-control-label" for="kontrak">Dokumen Kontrak</label>
        </div>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" name="invoice" id="invoice">
          <label class="custom-control-label" for="invoice">Dokumen Invoice</label>
        </div>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" name="rekening_koran" id="rekening_koran">
          <label class="custom-control-label" for="rekening_koran">Rekening Koran</label>
        </div>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" name="profil_perusahaan" id="profil_perusahaan">
          <label class="custom-control-label" for="profil_perusahaan">Profil Perusahaan</label>
        </div>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" name="laporan_keuangan" id="laporan_keuangan">
          <label class="custom-control-label" for="laporan_keuangan">Laporan Keuangan</label>
        </div>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" name="dokumen_pendukung" id="dokumen_pendukung">
          <label class="custom-control-label" for="dokumen_pendukung">Dokumen Pendukung</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success"> Approve </button>
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