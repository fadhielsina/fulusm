<!DOCTYPE html>
<html lang="en">

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

<!-- begin::Head -->

<head>
  <base href="">
  <meta charset="utf-8" />
  <title>Fulusme </title>
  <style>
    .foot {
      color: white;
    }
  </style>
  <meta name="description" content="Support center home example">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!--begin::Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">


  <!--end::Global Theme Styles -->

  <!--begin::Layout Skins(used by all pages) -->

  <!--end::Layout Skins -->
  <link rel="shortcut icon" href="<?= base_url('assetsprofile/') ?>asset/images/FMlogo.jpg" />

  <link rel="stylesheet" href="<?php echo base_url(); ?>assetsprofile/assetsbaru/fonts/icomoon/style.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assetsprofile/assetsbaru/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assetsprofile/assetsbaru/css/magnific-popup.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assetsprofile/assetsbaru/css/jquery-ui.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assetsprofile/assetsbaru/css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assetsprofile/assetsbaru/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assetsprofile/assetsbaru/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assetsprofile/assetsbaru/css/animate.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/mediaelementplayer.min.css">


  <link rel="stylesheet" href="<?php echo base_url(); ?>assetsprofile/assetsbaru/fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assetsprofile/assetsbaru/css/aos.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assetsprofile/assetsbaru/css/style.css">
</head>


<!-- begin::Body -->

<body style="background-image: url('<?php echo base_url(); ?>assetsprofile/assetsbaru/images/bg.jpg');">

  <div class="site-wrap">



    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->


    <div class="site-navbar-wrap js-site-navbar bg-white ">

      <div class="container">
        <div class="site-navbar bg-light">
          <div class="row align-items-center">
            <div class="col-2">
              <img class="mb-0 site-logo" src="<?php echo base_url(); ?>assets/img/dealfintech.jpg" width="90px">

            </div>
            <div class="col-10">
              <img style="margin-top:2%;" src="<?php echo base_url(); ?>assetsprofile/assetsbaru/images/ojk_white.png" width="109px" align="left">
              <nav class="site-navigation text-right" role="navigation">
                <div class="container">
                  <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

                  <ul class="site-menu js-clone-nav d-none d-lg-block">
                    <li class="active"><a href="<?= base_url('welcome') ?>">Beranda</a></li>
                    <li class="has-children">
                      <a>Tentang</a>
                      <ul class="dropdown arrow-top">
                        <li><a href="<?= base_url('welcome/perusahaan') ?>">Perusahaan</a></li>
                        <li><a href="<?= base_url('welcome/ceodantim') ?>">CEO dan Team</a></li>
                      </ul>
                    </li>
                    <li class="has-children">
                      <a>Alur Bisnis</a>
                      <ul class="dropdown arrow-top">
                        <li><a href="<?= base_url('welcome/alurbisnispeminjam') ?>">Proses Pemodalan</a></li>
                      </ul>
                    </li>
                    <li class="has-children">
                      <a>Bantuan</a>
                      <ul class="dropdown arrow-top">
                        <li><a href="<?= base_url('welcome/helpdesk') ?>">Helpdesk</a></li>
                        <li><a href="<?= base_url('welcome/faq') ?>">FAQ</a></li>
                        <li><a href="<?= base_url('welcome/sk') ?>">Syarat dan Ketentuan</a></li>
                      </ul>
                    </li>

                    <?php
                    if (isset($user)) {
                    ?>

                      <li class="has-children">
                        <a><?= $user['id_anggota']; ?>-<?= $user['name']; ?></a>
                        <ul class="dropdown arrow-top">
                          <li><a href="<?= base_url('user/profile') ?>">Lihat Profil</a></li>
                          <li><a href="<?= base_url('user/edit') ?>">Edit Profil</a></li>
                          <li><a href="<?= base_url('auth/logout') ?>">Logout</a></li>
                        </ul>
                      </li>
                    <?php

                    } else {

                    ?>
                      <li><a href="<?= base_url('auth') ?>" class="btn bg-success btn-sm"><span class="d-inline-block p-2 text-white">Login</span></a></li>
                      <li><a href="<?= base_url('auth/registration') ?>"><span class="d-inline-block p-2 font-weight-bold" style="color:#0078a8;">Daftar</span></a></li>
                    <?php } ?>
                  </ul>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br /><br /><br />