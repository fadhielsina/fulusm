   
        <h2 style="margin-left: 25px;"> Halaman Menu</h2>
        <!-- Begin Page Content -->
        <div class="container-fluid">

         
           
           <div class="col-lg-6">
             <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
              <?php if (validation_errors()): ?>
              <div class="alert alert-danger mb-3" role="alert" >
                <?= validation_errors();?>
              </div>
             <?php endif; ?>

              <?= $this->session->flashdata('message'); ?>

         <div class="row">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenu">Add New Menu</a>
             <table id="tableMenu" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Menu</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>
                  <?php foreach($menu as $m) : ?>
                  <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= $m['menu'] ?></td>
                    <td>
                      <a href="" data-toggle="modal" data-target="#editMenu" data-menu="<?= $m['menu'] ?>" data-id="<?= $m['id'] ?>"><span class="badge badge-pill badge-success">edit</span></a>
                      <a href="" data-toggle="modal" data-target="#deleteMenu" data-menu="<?= $m['menu'] ?>" data-id="<?= $m['id'] ?>" ><span class="badge badge-pill badge-danger">delete</span></a>
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
<div class="modal fade" id="newMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php base_url('menu/submenu') ?>" method="post">
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu name">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"> Add </button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal edit-->
<div class="modal fade" id="editMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php base_url('menu/submenu') ?>" method="post">
      <div class="modal-body">
        
        <div class="form-group">
          <input type="hidden" class="form-control" id="id" name="id" >
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="menu" name="menu">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"> Edit </button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal delete-->
<div class="modal fade" id="deleteMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        
        <div class="form-group">
        </div>
         <div class="form-group">
          <input type="hidden" class="form-control" id="del" name="del" >
          <input type="hidden" class="form-control" id="id" name="id" >
          <input type="hidden" class="form-control" id="menu" name="menu">
        </div>
        are you sure want to delete this menu? 
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
   $('#tableMenu').DataTable();
$('#deleteMenu').on('show.bs.modal', function(e){
   var idx = $(e.relatedTarget).data('menu');
   var data={menu:idx};
   $.ajax({
    type : 'post',
    url : "<?= base_url('admin/menuname'); ?>",
    data: data,
    success: function(data){

    var id = $(e.relatedTarget).data('id');
    var menu = $(e.relatedTarget).data('menu');
    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="menu"]').val(menu);
    var str1 = "Delete Menu ";
    $(e.currentTarget).find('input[name="menu_tag"]').val(str1.concat(menu));
    $(e.currentTarget).find('input[name="del"]').val(str1.concat(menu));

      
    }

   })



  })

  $('#editMenu').on('show.bs.modal', function(e){
   var idx = $(e.relatedTarget).data('menu');
   var data={menu:idx};
   $.ajax({
    type : 'post',
    url : "<?= base_url('admin/menuname'); ?>",
    data: data,
    success: function(data){

    var id = $(e.relatedTarget).data('id');
    var menu = $(e.relatedTarget).data('menu');
    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="menu"]').val(menu);



      
    }

   })



  })
})


</script>