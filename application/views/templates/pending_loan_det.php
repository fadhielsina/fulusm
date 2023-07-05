   
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
    <small>Tenor Proyek</small>
    <h5><?= $project[0]["range_project"] ?> hari </h5>
  </div>



</div>

<div class="row" style="padding: 50px 10px ; padding-top: 0px;">
  <div class="col-lg-4">
   <small>Nilai Proyek</small>
   <h5 class="nilai_p"><?= $project[0]["nilai_project"] ?></h5>
 </div>

 <div class="col-lg-4">
   <small>Modal Proyek</small>
   <h5 class="modal_p"><?= $project[0]["modal_project"] ?></h5>
 </div>

 <div class="col-lg-4">
   <small>Keuntungan Proyek</small>
   <h5 class="keuntungan_p"><?= $project[0]["keuntungan"] ?></h5>
 </div>




</div>

<div class="row" style="padding: 0px 10px ; padding-bottom: 20px;">
  <div class="col-lg-4">
   <small>Persentasi Keuntungan</small>
   <h5><?= $project[0]["keuntungan"] ?>%</h5>
 </div>

 <div class="col-lg-4">
   <small>Status Proyek</small>
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
 <small>Periode Pengumpulan Dana</small>
 <h5><?= date('d F Y', $project[0]["create_ts"]) ?> - <?=  date('d F Y', strtotime($project[0]["deadline"]))?></h5>
</div>
</div>

<div class="row" style="margin-top: 40px; padding: 50px 10px ; padding-bottom: 0px;padding-top: 0px;">
  <div class="col-lg">
    <small>Deskripsi Proyek</small>
    <h5><?= $project[0]["deskripsi_project"]?></h5>
  </div>
</div>


<hr>
<div class="row" style="margin-top: 40px; margin-bottom: 40px; padding: 50px 10px ; padding-bottom: 0px;padding-top: 0px;">
  <div class="col-lg">
    <h3>Detail Penerbit Proyek</h3>
  </div>
</div>



<div class="row" style="margin-top: 50px; padding: 50px 10px ; padding-top: 0px;">
  <div class="col-lg-4">
   <small>Instansi Penerbit Proyek</small>
   <h5><?= $project_information[0]["pemberi_project"] ?></h5>
 </div>

 <div class="col-lg-4">
   <small>Jenis Instansi Penerbit Proyek</small>
   <h5><?= $project_information[0]["jenis_instansi_project"] ?></h5>
 </div>

 <div class="col-lg-4">
  <small>Kota Instansi Penerbit Proyek</small>
  <h5><?= $project_information[0]["kota_pemberi_project"] ?></h5>
</div>



</div>

<div class="row" style="padding: 0px 10px ; padding-bottom: 20px;">
  <div class="col-lg-4">
   <small>Alamat Penerbit Proyek</small>
   <h5><?= $project_information[0]["alamat_pemberi_project"] ?></h5>
 </div>

 <div class="col-lg-4">
   <small>Website Instansi Penerbit Proyek</small>
   <h5><?= $project_information[0]["web_pemberi_project"] ?></h5>
 </div>

 <div class="col-lg-4">
 </div>
</div>
<!-- /.container-fluid -->
</div>
</div>
<!-- End of Main Content -->

<!-- <td scope="col"><?= $project[$i]['nama_project'];?></td>
                    <td scope="col"><?= $project[$i]['lokasi_project'];?> </td>
                    <td scope="col"><?= $project[$i]['nilai_project'];?></td>
                    <td scope="col"><?= $project[$i]['modal_project'];?></td>
                    <td scope="col"><?= $project[$i]['range_project'];?></td>
                    <td scope="col"><?= $project[$i]['keuntungan'];?></td> -->



                    <script
                    src="https://code.jquery.com/jquery-3.1.1.min.js"
                    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
                    crossorigin="anonymous"></script>

                    <script type="text/javascript">

                      $(document).ready(function(){
                       $('#tName').DataTable({
                        initComplete: function(settings, json) {
                          alert( 'DataTables has finished its initialisation.' );
                          $("#tName_length").hide();
                          $("#tName_filter").hide();
                        },
                        drawCallback: function(settings) {
                          alert( 'DataTables has finished its initialisation.' );
                          $("#tName_length").hide();
                          $("#tName_filter").hide();
                        }
                      });
                     });
                      

                   </script>