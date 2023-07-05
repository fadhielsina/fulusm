


<style>
.dataTables_wrapper    {
  width:100%;
}

</style>
        <h2 style="margin-left: 25px;"> Video CMS</h2>
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
<a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Tambah Video Baru</a>

         <div class="row">
             <table id="tName" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Video</th>
                    <th scope="col">Video</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>
                  <?php foreach($video_all as $r) : ?>
                  <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= $r['nama'] ?></td>
                    <td> <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="
<?= base_url('assets/')?><?= $r['url'] ?>" allowfullscreen></iframe>
        



                    <td>

                       <a href="" data-toggle="modal" 
                      data-role="<?= $r['id'] ?>" data-target="#deleteRoleModal" 
                      data-name="<?= $r['nama'] ?>" 
                      data-id="<?= $r['id'] ?>" 
                      ><span class="badge badge-pill badge-danger">Hapus</span></a>
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

<!-- Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Video Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php base_url('admin/video') ?>" enctype="multipart/form-data" method="post">
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Video">
        </div>
        <div class="form-group row">
                                <div class="col-lg-12 mb-3 mb-sm-0">
                                 <label style="
                                 color: black;
                                 font-size: 14px;
                                 "> Unggah Video</label>
                                 <div class="custom-file">

                                  <input type="file" class="custom-file-input img-edit" id="video" name="video" for="video"/>
                                  <label style="white-space: nowrap;
                                  padding-right: 87px;
                                  overflow: hidden;
                                  text-overflow: ellipsis;
                                  height: 33px;
                                  font-size: .8rem;" 
                                  class="custom-file-label img-label" for="spk">Unggah Video</label>
                                  <small style="color: blue; font-size: 10px;">*Hanya mengizinkan dokumen mp4 dengan maksimal ukuran dokumen 30mb</small>
                                  <?= form_error('video', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                              </div>
                            </div>


       

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"> Tambah </button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal delete-->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <input type="text" class="form-control" id="menu_tag" name="menu_tag" readonly="readonly">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php base_url('menu/submenu') ?>" method="post">
      <div class="modal-body">
         <div style="visibility: hidden; height: 0px;" class="form-group">
          <input type="hidden" class="form-control" id="del" name="del" >
          <input type="hidden" class="form-control" id="id" name="id" >
          <input type="hidden" class="form-control" id="menu" name="menu" value="0">
          <input type="hidden" class="form-control" id="name" name="name" value="0" placeholder="User name">
          <input type="password" class="form-control" id="password1" value="11111" name="password1" placeholder="User password">
          <input type="password" class="form-control" id="password2" value="11111" name="password2" placeholder="Retype password">
          <input type="text" class="form-control" id="email" name="email"  value="11111@jdjd.cd" placeholder="User email">
          <select name="role" id="role" class="form-control">
              <option value="666">Select Role</option>
            </select>

            <div class="form-check">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
          </div>
        </div>
        are you sure want to delete this user? 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"> Delete </button>
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
$('#deleteRoleModal').on('show.bs.modal', function(e){
   var idx = $(e.relatedTarget).data('menu');
   var data={menu:idx};
   $.ajax({
    type : 'post',
    url : "<?= base_url('admin/menuname'); ?>",
    data: data,
    success: function(data){
   var id = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    
    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="name"]').val(name);
    var str1 = "Delete User ";
    $(e.currentTarget).find('input[name="menu_tag"]').val(str1.concat(name));
    $(e.currentTarget).find('input[name="del"]').val(str1.concat(name));
    }

   })



  })

  $('#editRoleModal').on('show.bs.modal', function(e){



   var idx = $(e.relatedTarget).data('menu');
   var data={menu:idx};
   $.ajax({
    type : 'post',
    url : "<?= base_url('admin/menuname'); ?>",
    data: data,
    success: function(data){

    var id = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    var email = $(e.relatedTarget).data('email');
    var role = $(e.relatedTarget).data('role');
    var is_active = $(e.relatedTarget).data('is_active');



    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="name"]').val(name);
    $(e.currentTarget).find('input[name="email"]').val(email);
    $(e.currentTarget).find('option[value="'+role+'"]').attr('selected','selected');
    if (is_active == '1') {
      $(e.currentTarget).find('input[name="is_active"]').prop('checked', true);
       $(e.currentTarget).find('input[name="is_active"]').val(is_active);
    }else{
       $(e.currentTarget).find('input[name="is_active"]').prop('checked', false);
       $(e.currentTarget).find('input[name="is_active"]').val(is_active);
    }

    $(e.currentTarget).find('input[name="is_active"]').change(function(){
     
         cb = $(this);

         if (cb.prop('checked') == true) {
          cb.val('1');
         }else{
          cb.val('0');
         }
         
     });
    

    
      
    



      
    }

   })



  })
})


</script>