<?php 
    function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
?>    
        <h2 style="margin-left: 25px;"> <?= $title; ?></h2>
        <!-- Begin Page Content -->
        <div class="container-fluid">

         
           
           <div class="col-lg-12">
             <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
              <?php if (validation_errors()): ?>
              <div class="alert alert-danger mb-3" role="alert" >
                <?= validation_errors();?>
              </div>
             <?php endif; ?>
              <?= $this->session->flashdata('message'); ?>

         <div class="row">
             <table id="tName" class="table table-hover mt-5">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID Proyek</th>
                    <th scope="col">Nama Toko</th>
                    <th scope="col">Pemilik Toko </th>
                    <th scope="col">Tenor</th>
                    <th scope="col">Jumlah Pengajuan</th>
                  </tr>
                </thead>
                <tbody>


                  <?php $i = 0;
                  foreach ($project as $p) : ?>
                  <tr>
                    <td scope="col"><?= $i+1; ?></th>
                    <td scope="col"><?= $project[$i]['id_project'];?></td>
                    <td scope="col"><?= $project[$i]['nama_toko'];?></td>
                    <td scope="col"><?= $project[$i]['nama_pemilik'];?> </td>
                    <td scope="col"><?= $project[$i]['tenor'];?></td>
                    <td scope="col"><?= rupiah($project[$i]['jumlah_pinjaman']);?></td>
                  </tr>
                  <?php $i++ ?>
                  <?php endforeach; ?>

                </tbody>
              </table>
           </div>
         </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->


     


<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>

<script type="text/javascript">
  
$(document).ready(function(){
   $('#tName').DataTable();
})


</script>