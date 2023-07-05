   
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
             <table id="tName" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Proyek</th>
                    <th scope="col">Lokasi Proyek</th>
                    <th scope="col">Nilai Proyek</th>
                    <th scope="col">Pengaju Proyek</th>
                    <th scope="col">Range Proyek</th>
                    <th scope="col">Pemberi Proyek</th>
                    <th scope="col">Lihat Rinci</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=0; ?>
                  <?php foreach($project as $r) : ?>
                  <tr>
                    <th scope="row"><?= $i+1 ?></th>
                    <td><?= $r['nama_project'] ?></td>
                    <td><?= $r['lokasi_project'] ?></td>
                    <td><?= $r['nilai_project'] ?></td>
                    <td><?= $r['name'] ?></td>
                    <td><?= $r['range_project'] ?> % </td>
                    <td><?= $r['pemberi_project'] ?></td>


                    <td>
                      <a href='<?= base_url('fund/rincianproject').'?id='.$r['project_id'] ?>'>
                    lihat rinci
                      </a>
                    </td>

                    <?php $i++; ?>
                  </tr>
                <?php endforeach ?>
                </tbody>
              </table>
           </div>
         </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->


      <!-- Button trigger modal -->



<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>



<script type="text/javascript">
  
$(document).ready(function(){
   


   $('#tName').DataTable(
    {
      dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

})


</script>