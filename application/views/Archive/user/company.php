   
        <h2 style="margin-left: 25px;"> <?= $title; ?></h2>
        <!-- Begin Page Content -->
        <div class="container-fluid ">
        <div class="shadow" style="padding-left: 30px;margin-bottom: 50px;">

        <div class="row" style="margin-top: 50px; padding: 50px 10px ; padding-bottom: 0px;">
          <div class="col-lg">
          </div>
        </div>
        <div class="row" style="margin-top: 30px; padding: 50px 10px ; padding-top: 0px;padding-bottom: 20px;">
          <div class="col-lg-4">
           <small>Nama Perusahaan</small>
           <h5><?= $company["nama_perusahaan"] ?></h5>
           </div>

          <div class="col-lg-4">
           <small>Tipe Perusahaan</small>
           <h5><?= $company["tipe_perusahaan"] ?></h5>
           </div>

          <div class="col-lg-4">
            <small>Kategori Bisnis</small>
            <h5><?= $company["kategori_bisnis"] ?></h5>
           </div>
          

        </div>

        <div class="row" style="padding: 0px 10px ; padding-bottom: 20px;">
          <div class="col-lg-4">
           <small>Tipe Bisnis</small>
           <h5><?= $company["tipe_bisnis"] ?></h5>
           </div>

          <div class="col-lg-4">
           <small>Status Kantor</small>
           <h5><?= $company["status_kantor"] ?></h5>
           </div>

          <div class="col-lg-4">
            <small>Jumlah Karyawan</small>
            <h5><?= $company["jumlah_karyawan"] ?></h5>
           </div>
          


        </div>

        <div class="row" style="padding: 0px 10px ; padding-bottom: 20px;">
          <div class="col-lg-4">
           <small>Tahun Berdiri</small>
           <h5><?= $company["tahun_berdiri"] ?></h5>
           </div>

          <div class="col-lg-4">
           <small>Alamat Website</small>
           <h5><?= $company["alamat_website"]?></h5>
           </div>

          <div class="col-lg-4">
            <small>Nomor Telepon</small>
           <h5><?= $company["no_tlp"]?></h5>
           
           </div>
          


        </div>

         <div class="row" style="padding: 0px 10px ; padding-bottom: 20px;">
          <div class="col-lg-4">
           <small>Provinsi</small>
           <h5><?= $company["provinsi"] ?></h5>
           </div>

          <div class="col-lg-4">
           <small>Kota/Kabupaten</small>
           <h5><?= $company["kota"]?></h5>
           </div>

          <div class="col-lg-4">
            <small>Kecamatan</small>
           <h5><?= $company["kecamatan"]?></h5>
           
           </div>
          


        </div>

         <div class="row" style="padding: 0px 10px ; padding-bottom: 20px;">
          <div class="col-lg">
           <small>Deskripsi Website</small>
           <h5><?= $company["deskripsi_perusahaan"] ?></h5>
           </div>
         
        </div>
        <!-- /.container-fluid -->
</div>
      </div>
      <!-- End of Main Content -->


</script>