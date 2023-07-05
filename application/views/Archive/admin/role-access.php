   
        <h2 style="margin-left: 25px;"> Halaman Menu</h2>
        <!-- Begin Page Content -->
        <div class="container-fluid">

         
           
           <div class="col-lg-6">

              <?= $this->session->flashdata('message'); ?>

              <h5>Role : <?=$role['role'] ?></h5>

         <div class="row">
             <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Menu</th>
                    <th scope="col">Access</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>
                  <?php foreach($menu as $m) : ?>
                  <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= $m['menu'] ?></td>
                    <td>
                    <div class="form-check">
                      <input class="form-check-input access_role" type="checkbox" <?= check_access($role['id'], $m['id'])  ?> data-role="<?= $role['id'] ?>" data-menu="<?= $m['id'] ?>">
                    </div>
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