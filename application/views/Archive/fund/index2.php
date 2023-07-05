   
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
                    <th scope="col">Modal Proyek</th>
                    <th scope="col">Range Proyek</th>
                    <th scope="col">Persetujuan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>
                  <?php foreach($project as $r) : ?>
                  <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= $r['nama_project'] ?></td>
                    <td><?= $r['lokasi_project'] ?></td>
                    <td><?= $r['nilai_project'] ?></td>
                    <td><?= $r['modal_project'] ?></td>
                    <td><?= $r['range_project'] ?> % </td>


                    <td>
                      <a href="" 
                      data-toggle="modal" 
                      data-target="#approveModal"
                      data-role="<?= $r['id'] ?>"
                      data-name="<?= $r['nama_project'] ?>">
                      
                      <span class="badge badge-pill badge-success">
                      Disetujui
                      </span>
                      </a>
                      <a href="" 
                      data-toggle="modal" 
                      data-target="#rejectModal"
                      data-role="<?= $r['id'] ?>"
                      data-name="<?= $r['nama_project'] ?>">
                      
                      <span class="badge badge-pill badge-danger">
                      Ditolak
                      </span>
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
    height: 60px;
">
        Apakah anda yakin akan menyetujui pengajuan ini ?
        <div style="visibility: hidden" class="form-group">
          <input type="hidden" class="form-control" id="id" name="id" >
        </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"> Approve </button>
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
           <input type="hidden" class="form-control" id="reject" name="reject" >
        </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"> Reject </button>
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
   


   $('#tName').DataTable(
    {
      dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });



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