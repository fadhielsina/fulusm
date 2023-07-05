   
        <h2 style="margin-left: 25px;"> <?= $title; ?></h2>
        <!-- Begin Page Content -->
        <div class="container-fluid ">
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
            <h5><?= $project[0]["range_project"] ?> hari</h5>
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
           <h5><?= $project_information[0]["pemberi_proyek"] ?></h5>
           </div>

          <div class="col-lg-4">
           <small>Jenis Instansi Pemberi Proyek</small>
           <h5><?= $project_information[0]["jenis_instansi_proyek"] ?></h5>
           </div>

          <div class="col-lg-4">
            <small>Kota Instansi Pemberi Proyek</small>
            <h5><?= $project_information[0]["kota_pemberi_proyek"] ?></h5>
           </div>
          


        </div>

                <div class="row" style="padding: 0px 10px ; padding-bottom: 20px;">
          <div class="col-lg-4">
           <small>Alamat Pemberi Proyek</small>
           <h5><?= $project_information[0]["alamat_pemberi_proyek"] ?></h5>
           </div>

          <div class="col-lg-4">
           <small>Website Instansi Pemberi Proyek</small>
           <h5><?= $project_information[0]["web_pemberi_proyek"] ?></h5>
           </div>

          <div class="col-lg-4">
           
           </div>
          


        </div>
        <!-- /.container-fluid -->
</div>
      </div>
      <!-- End of Main Content -->

<!-- <td scope="col"><?= $project[$i]['nama_project'];?></td>
                    <td scope="col"><?= $project[$i]['lokasi_proyek'];?> </td>
                    <td scope="col"><?= $project[$i]['nilai_proyek'];?></td>
                    <td scope="col"><?= $project[$i]['modal_proyek'];?></td>
                    <td scope="col"><?= $project[$i]['range_proyek'];?></td>
                    <td scope="col"><?= $project[$i]['keuntungan'];?></td> -->
     


<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>

<script type="text/javascript">
  
$(document).ready(function(){
   $('#tName').DataTable();
})


</script>