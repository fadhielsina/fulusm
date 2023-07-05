   
        <h2 style="margin-left: 25px;"> Halaman Menu</h2>
        <!-- Begin Page Content -->
        <div class="container-fluid">

         
           
           <div class="col-lg">
             <?php if (validation_errors()): ?>
              <div class="alert alert-danger mb-3" role="alert" >
                <?= validation_errors();?>
              </div>
             <?php endif; ?>
              <?= $this->session->flashdata('message'); ?>

         <div class="row">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenu">Add New Submenu</a>
             <table id="tableMenu" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Menu</th>
                    <th scope="col">Url</th>
                    <th scope="col">Icon</th>
                    <th scope="col">Active</th>
                    <th scope="col">Action</th>

                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>
                  <?php foreach($subMenu as $sm) : ?>
                  <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= $sm['title'] ?></td>
                    <td><?= $sm['menu'] ?></td>
                    <td><?= $sm['url'] ?></td>
                    <td><?= $sm['icon'] ?></td>
                    <td><?= $sm['is_active'] ?></td>
                    <td>
                       <a href="" data-toggle="modal" data-target="#editMenu" 
                       data-submenu="<?= $sm['menu'] ?>" 
                       data-id="<?= $sm['id'] ?>"
                       data-title="<?= $sm['title'] ?>"
                       data-url="<?= $sm['url'] ?>"
                       data-menu_id="<?= $sm['menu_id'] ?>"
                       data-icon="<?= $sm['icon'] ?>"
                       data-is_active="<?= $sm['is_active'] ?>"
                       ><span class="badge badge-pill badge-success">edit</span></a>


                      <a href="" data-toggle="modal" data-target="#deleteMenu" 
                      data-submenu="<?= $sm['menu'] ?>" 
                       data-id="<?= $sm['id'] ?>"
                       data-title="<?= $sm['title'] ?>"
                       data-url="<?= $sm['url'] ?>"
                       data-menu_id="<?= $sm['menu_id'] ?>"
                       data-icon="<?= $sm['icon'] ?>"
                       data-is_active="<?= $sm['is_active'] ?>"
                       data-menu="<?= $sm['menu'] ?>" data-id="<?= $sm['id'] ?>" ><span class="badge badge-pill badge-danger">delete</span></a>



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
        <h5 class="modal-title" id="exampleModalLabel">Add New Submenu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php base_url('menu/submenu') ?>" method="post">
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="title" name="title" placeholder="Submenu Title">
        </div>
        <div class="form-group">
            <select name="menu_id" id="menu_id" class="form-control">
              <option value="">Select Menu</option>
              <?php foreach ($menu as $m) : ?>
                <option value="<?= $m['id'];  ?>"><?= $m['menu'];  ?></option>
              <?php endforeach;?>
            </select>
          
        </div>

        <div class="form-group">
          <input type="text" class="form-control" id="url" name="url" placeholder="Submenu Url">
        </div>

        <div class="form-group">
          <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu Icon">
        </div>

        <div class="form-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
            <label class="form-check-label" for="is_active">
            Active?
            </label>
          </div>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Submenu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php base_url('menu/submenu') ?>" method="post">
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" class="form-control" id="id" name="id" >
          <input type="text" class="form-control" id="title" name="title" placeholder="Submenu Title">
        </div>
        <div class="form-group">
            <select name="menu_id" id="menu_id" class="form-control">
              <option value="">Select Menu</option>
              <?php foreach ($menu as $m) : ?>
                <option value="<?= $m['id'];  ?>"><?= $m['menu'];  ?></option>
              <?php endforeach;?>
            </select>
          
        </div>

        <div class="form-group">
          <input type="text" class="form-control" id="url" name="url" placeholder="Submenu Url">
        </div>

        <div class="form-group">
          <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu Icon">
        </div>

        <div class="form-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
            <label class="form-check-label" for="is_active">
            Active?
            </label>
          </div>
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
        <input type="text" class="form-control" id="title" name="title" placeholder="Submenu Title" readonly="readonly">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php base_url('menu/submenu') ?>" method="post">


        
      <div class="modal-body" style="
    height: 60px;
">
        Are you sure want to delete this Sub Menu?
        <div style="visibility: hidden" class="form-group">
          <input type="hidden" class="form-control" id="id" name="id" >
          <input type="hidden" class="form-control" id="del" name="del" value="del">
          <input type="hidden" class="form-control" id="title" name="title" placeholder="Submenu Title">
        </div>
        <div style="visibility: hidden" class="form-group">
            <select name="menu_id" id="menu_id" class="form-control">
              <option value="">Select Menu</option>
              <?php foreach ($menu as $m) : ?>
                <option value="<?= $m['id'];  ?>"><?= $m['menu'];  ?></option>
              <?php endforeach;?>
            </select>
          
        </div>

        <div style="visibility: hidden" class="form-group">
          <input type="hidden" class="form-control" id="url" name="url" placeholder="Submenu Url">
        </div>

        <div style="visibility: hidden" class="form-group">
          <input type="hidden" class="form-control" id="icon" name="icon" placeholder="Submenu Icon">
        </div>

        <div style="visibility: hidden" class="form-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
            <label class="form-check-label" for="is_active">
            Active?
            </label>
          </div>
        </div>  
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
      var subm = $(e.relatedTarget).data('submenu');

   var data={submenu:subm};
   $.ajax({
    type : 'post',
    url : "<?= base_url('admin/menuname'); ?>",
    data: data,
    success: function(data){


    var id = $(e.relatedTarget).data('id');
    var sub = $(e.relatedTarget).data('submenu');
    var tit = $(e.relatedTarget).data('title');
    var men = $(e.relatedTarget).data('menu_id');
    var url = $(e.relatedTarget).data('url');
    var ico = $(e.relatedTarget).data('icon');
    var isa = $(e.relatedTarget).data('is_active');
    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="submenu"]').val(sub);
     var str1 = "Delete Sub Menu ";

    $(e.currentTarget).find('option[value="'+men+'"]').attr('selected','selected');
    $(e.currentTarget).find('input[name="title"]').val(str1.concat(tit));
    $(e.currentTarget).find('input[name="url"]').val(url);
    $(e.currentTarget).find('input[name="icon"]').val(ico);
    $(e.currentTarget).find('input[name="is_active"]').val(isa);
      
    }

   })



  })

  $('#editMenu').on('show.bs.modal', function(e){

    var subm = $(e.relatedTarget).data('submenu');

   var data={submenu:subm};
   $.ajax({
    type : 'post',
    url : "<?= base_url('admin/menuname'); ?>",
    data: data,
    success: function(data){

    var id = $(e.relatedTarget).data('id');
    var sub = $(e.relatedTarget).data('submenu');
    var tit = $(e.relatedTarget).data('title');
    var men = $(e.relatedTarget).data('menu_id');
    var url = $(e.relatedTarget).data('url');
    var ico = $(e.relatedTarget).data('icon');
    var isa = $(e.relatedTarget).data('is_active');
    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="submenu"]').val(sub);

    $(e.currentTarget).find('option[value="'+men+'"]').attr('selected','selected');
    $(e.currentTarget).find('input[name="title"]').val(tit);
    $(e.currentTarget).find('input[name="url"]').val(url);
    $(e.currentTarget).find('input[name="icon"]').val(ico);
    $(e.currentTarget).find('input[name="is_active"]').val(isa);




      
    }

   })



  })
})


</script>