   <h2 style="margin-left: 25px;"> <?= $title; ?></h2>
   <!-- Begin Page Content -->
   <div class="container-fluid">



     <div class="col-lg-12">
       <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
       <?php if (validation_errors()) : ?>
         <div class="alert alert-danger mb-3" role="alert">
           <?= validation_errors(); ?>
         </div>
       <?php endif; ?>
       <?= $this->session->flashdata('message'); ?>
       <div class="row">
         <table id="tName" class="table table-hover mt-5">
           <thead>
             <tr>
               <th scope="col">#</th>
               <th scope="col">Id Proyek </th>
               <th scope="col">Nama Proyek</th>
               <th scope="col">Modal Proyek</th>
               <th scope="col">Nilai Pendanaan</th>
               <th scope="col">Total Lot</th>
               <th scope="col">No Virtual Account</th>
               <th scope="col">Lihat Rincian Proyek</th>

             </tr>
           </thead>
           <tbody>

             <?php $i = 0;
              foreach ($project as $p) : ?>
               <tr>
                 <td scope="col"><?= $i + 1; ?></th>
                 <td scope="col"><?= $project[$i]['project_id']; ?> </td>
                 <td scope="col"><?= $project[$i]['nama_project']; ?></td>
                 <td scope="col"><?= number_format($project[$i]['modal_project']); ?></td>
                 <td scope="col"><?= number_format($project[$i]['nominal']); ?></td>
                 <td scope="col"><?= $project[$i]['total_lot']; ?></td>
                 <td scope="col"><?= $project[$i]['nomor_va']; ?></td>
                 <td scope="col">

                   <?php

                    if ($this->db->get_where('project_information', ['project_id' => $project[$i]['id']])->row_array()) {
                    ?>
                     <a href="<?= base_url('user/rincianLoan') . '?id=' . $project[$i]['id'] ?>">
                       Lihat Rincian
                     </a>

                   <?php
                    } else {
                    ?>
                     <a style="background: pink" href="<?= base_url('project/addinformasi') . '?id=' . $project[$i]['id'] ?>">
                       lengkapi data
                     </a>
                   <?php
                    } ?>

                 </td>
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





   <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

   <script type="text/javascript">
     $(document).ready(function() {
       $('#tName').DataTable();
     })
   </script>