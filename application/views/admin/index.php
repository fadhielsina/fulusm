<h2 style="margin-left: 25px;"> Pengelolaan User</h2>
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
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Tambah User Baru</a>

    <div class="row">
      <table id="tName" class="table table-hover">
        <thead>
          <tr>
            <th scope="col">User ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Role</th>
            <th scope="col">Date Created</th>
            <th scope="col">Action</th>
            <th scope="col">Status</th>
            <th scope="col">Link Aktivasi</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($user_all as $r) : ?>
            <?php $query = $this->db->get_where('user_token', ['email' => $r['email']])->row(); ?>
            <tr>
              <th scope="row"><?= $r['userID'] ?></th>
              <td><?= $r['name'] ?></td>
              <td><?= $r['email'] ?></td>
              <td><?= $r['phone'] ?></td>
              <td><?= $r['role'] ?></td>
              <td><?= date('d-m-Y', $r['date_created']) ?></td>

              <td>
                <a href="" data-toggle="modal" data-target="#editRoleModal" data-role="<?= $r['role_id'] ?>" data-name="<?= $r['name'] ?>" data-id="<?= $r['email'] ?>" data-is_active="<?= $r['is_active'] ?>" data-email="<?= $r['email'] ?>">
                  <span class="badge badge-pill badge-success">ubah</span></a>
                <a href="" data-toggle="modal" data-role="<?= $r['role_id'] ?>" data-target="#deleteRoleModal" data-name="<?= $r['name'] ?>" data-id="<?= $r['email'] ?>"><span class="badge badge-pill badge-danger">hapus</span></a>
              </td>

              <?php if ($r['is_active'] == 1) : ?>
                <td><?= "active" ?></td>
              <?php else : ?>
                <td><?= "not active" ?></td>
              <?php endif ?>

              <?php if ($query) : ?>
                <td><input type="text" value="<?= base_url('auth/verify?email=' . $r["email"] . '&token=' . urlencode($query->token) . '') ?>"></td>
              <?php else : ?>
                <td>-</td>
              <?php endif; ?>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah User Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php base_url('admin') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="name" name="name" placeholder="User name">
          </div>

          <div class="form-group">
            <input type="password" class="form-control" id="password1" name="password1" placeholder="User password">
          </div>

          <div class="form-group">
            <input type="password" class="form-control" id="password2" name="password2" placeholder="Retype password">
          </div>

          <div class="form-group">
            <input type="text" class="form-control" id="email" name="email" placeholder="User email">
          </div>

          <div class="form-group">
            <select name="role" id="role" class="form-control">
              <option value="">Select Role</option>
              <?php foreach ($role as $m) : ?>
                <option value="<?= $m['id'];  ?>"><?= $m['role'];  ?></option>
              <?php endforeach; ?>
            </select>
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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary"> Tambah </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal edit-->
<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ubah User Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?php base_url('admin') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" class="form-control" id="id" name="id">
            <input type="text" class="form-control" id="name" name="name" placeholder="User name">
          </div>

          <div class="form-group">
            <input type="password" class="form-control" id="password1" name="password1" placeholder="User password">
          </div>

          <div class="form-group">
            <input type="password" class="form-control" id="password2" name="password2" placeholder="Retype password">
          </div>

          <div class="form-group">
            <input type="text" class="form-control" id="email" name="email" placeholder="User email">
          </div>

          <div class="form-group">
            <select name="role" id="role" class="form-control">
              <option value="">Select Role</option>
              <?php foreach ($role as $m) : ?>
                <option value="<?= $m['id'];  ?>"><?= $m['role'];  ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="0">
              <label class="form-check-label" for="is_active">
                Active?
              </label>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary"> Ubah </button>
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
            <input type="hidden" class="form-control" id="del" name="del">
            <input type="hidden" class="form-control" id="id" name="id">
            <input type="hidden" class="form-control" id="menu" name="menu" value="0">
            <input type="hidden" class="form-control" id="name" name="name" value="0" placeholder="User name">
            <input type="password" class="form-control" id="password1" value="11111" name="password1" placeholder="User password">
            <input type="password" class="form-control" id="password2" value="11111" name="password2" placeholder="Retype password">
            <input type="text" class="form-control" id="email" name="email" value="11111@jdjd.cd" placeholder="User email">
            <select name="role" id="role" class="form-control">
              <option value="666">Select Role</option>
            </select>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
            </div>
          </div>
          Apakah Anda akan menghapus User ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary"> Hapus </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-35VN14CNFE"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'G-35VN14CNFE');
</script>

<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#tName').DataTable();
    $('#deleteRoleModal').on('show.bs.modal', function(e) {
      var idx = $(e.relatedTarget).data('menu');
      var data = {
        menu: idx
      };
      $.ajax({
        type: 'post',
        url: "<?= base_url('admin/menuname'); ?>",
        data: data,
        success: function(data) {
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

    $('#editRoleModal').on('show.bs.modal', function(e) {



      var idx = $(e.relatedTarget).data('menu');
      var data = {
        menu: idx
      };
      $.ajax({
        type: 'post',
        url: "<?= base_url('admin/menuname'); ?>",
        data: data,
        success: function(data) {

          var id = $(e.relatedTarget).data('id');
          var name = $(e.relatedTarget).data('name');
          var email = $(e.relatedTarget).data('email');
          var role = $(e.relatedTarget).data('role');
          var is_active = $(e.relatedTarget).data('is_active');



          $(e.currentTarget).find('input[name="id"]').val(id);
          $(e.currentTarget).find('input[name="name"]').val(name);
          $(e.currentTarget).find('input[name="email"]').val(email);
          $(e.currentTarget).find('option[value="' + role + '"]').attr('selected', 'selected');
          if (is_active == '1') {
            $(e.currentTarget).find('input[name="is_active"]').prop('checked', true);
            $(e.currentTarget).find('input[name="is_active"]').val(is_active);
          } else {
            $(e.currentTarget).find('input[name="is_active"]').prop('checked', false);
            $(e.currentTarget).find('input[name="is_active"]').val(is_active);
          }

          $(e.currentTarget).find('input[name="is_active"]').change(function() {

            cb = $(this);

            if (cb.prop('checked') == true) {
              cb.val('1');
            } else {
              cb.val('0');
            }
          });
        }
      })
    })
  })
</script>