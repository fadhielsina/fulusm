<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Fulusme - Login</title>

  <!-- Custom fonts for this template-->
  <link rel="icon" type="image/ico" href="<?= base_url('assets/'); ?>img/ico.ico">
  <link href="<?= base_url('assets/'); ?> vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/login_7/fonts/icomoon/style.css">

  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/login_7/css/owl.carousel.min.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/login_7/css/bootstrap.min.css">

  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/login_7/css/style.css">

</head>

<body>



  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="text-center">
                <a href="<?= base_url('welcome'); ?>"><img src="<?= base_url(); ?>assetsprofile/asset/images/dealfintech.jpg" width="70"></a>
                <h1 class="h4 text-gray-900 mb-4">Halaman Login</h1>
              </div>

              <?= $this->session->flashdata('message'); ?>
              <form class="user" method="post" action="<? base_url('auth') ?>">
                <div class="form-group first">
                  <input type="text" class="form-control form-control-user" id="email" placeholder="Alamat Email" name="email" value="<?= set_value('email') ?>">
                  <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group last mb-4">
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
        <div class="col-md-3">
        </div>
      </div>
    </div>
  </div>


  <script src="<?php echo base_url() ?>/assets/login_7/js/jquery-3.3.1.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/login_7/js/popper.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/login_7/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/login_7/js/main.js"></script>
</body>

</html>