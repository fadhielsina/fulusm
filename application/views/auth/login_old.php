  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-lg-6">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              
              <div class="col-lg">
                <div class="p-5">
                  <div class="text-center">
                    <a href="<?= base_url('welcome'); ?>"><img src="<?= base_url(); ?>assetsprofile/asset/images/dealfintech.jpg" width="70"></a>
                    <h1 class="h4 text-gray-900 mb-4">Halaman Login</h1>
                  </div>

                  <?= $this->session->flashdata('message'); ?>
                  <form class="user" method="post" action="<? base_url('auth')?>">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="email" placeholder="Alamat Email" name="email" value="<?= set_value('email')?>">
                      <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="password">
                      <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Lupa Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('auth/registration'); ?>">Belum punya akun? Daftar</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('welcome'); ?>">Kembali ke Awal</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-35VN14CNFE"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-35VN14CNFE');
</script>


