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
    <meta name="description" content="Support center home example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

    <!--end::Fonts -->

    <!--begin::Page Custom Styles(used by this page) -->
    <link href="<?= base_url('assetsprofile/') ?>assetsbaru/css/pages/support-center/home-2.css" rel="stylesheet" type="text/css" />

    <!--end::Page Custom Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="<?= base_url('assetsprofile/') ?>assetsbaru/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assetsprofile/') ?>assetsbaru/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="<?= base_url('assetsprofile/') ?>asset/images/FMlogo.jpg" />

    <link rel="icon" type="image/ico" href="<?= base_url('assetsprofile/') ?>pic/ico.ico" />


    <!-- <link rel="stylesheet" href="<?= base_url('assetsprofile/') ?>asset/css/bootstrap.css"> -->
    <link rel="stylesheet" href="<?= base_url('assetsprofile/') ?>asset/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?= base_url('assetsprofile/') ?>asset/css/neon.css">

    <script src="<?= base_url('assetsprofile/') ?>asset/js/jquery-1.11.0.min.js"></script>
</head>


<!-- begin::Body -->

<body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--transparent kt-aside--enabled kt-aside--left kt-aside--fixed kt-page--loading">

    <!-- begin::Page loader -->

    <!-- end::Page Loader -->

    <!-- begin:: Page -->

    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="index.html">
                <img alt="Logo" style="width: 50px;" src="<?= base_url('assetsprofile/') ?>asset/images/mumtaaz.jpg" />
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more-1"></i></button>
        </div>
    </div>
    <!-- end:: Header Mobile -->



    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

                <div id="kt_header" class="kt-header  kt-header--fixed " style="margin-top: 0px;" data-ktheader-minimize="on">
                    <div class="kt-container  kt-container--fluid ">

                        <!-- begin: Header Menu -->
                        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                        <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">

                            <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
                                <ul class="kt-menu__nav ">


                                    <li class="kt-menu__item  
										kt-menu__item--here 
										kt-menu__item--rel  kt-menu__item--here">
                                        <img style="margin-right: 40px;     width: 50px;" alt="Logo" <img src="<?= base_url('assetsprofile/') ?>asset/images/dealfintech.jpg" width="75" style="
								margin-left: 60px;
								">

                                    </li>
                                    <li class="kt-menu__item   
										kt-menu__item--rel">
                                        <a href="<?= base_url('welcome/index') ?>" class="kt-menu__link">

                                            <span class="kt-menu__link-text">Beranda</span>
                                            <i class="kt-menu__ver-arrow la la-angle-right">

                                            </i>
                                        </a>

                                    </li>
                                    <li class="kt-menu__item kt-menu__item--here kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                            <span class="kt-menu__link-text">Tentang</span>
                                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                                            <ul class="kt-menu__subnav">
                                                <li class="kt-menu__item " aria-haspopup="true">
                                                    <a href="<?= base_url('welcome/perusahaan') ?>" class="kt-menu__link ">
                                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">Perusahaan</span>
                                                    </a>
                                                </li>
                                                <li class="kt-menu__item " aria-haspopup="true">
                                                    <a href="<?= base_url('welcome/ceodantim') ?>" class="kt-menu__link ">
                                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">CEO dan Team</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                            <span class="kt-menu__link-text">Alur Bisnis</span>
                                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                                            <ul class="kt-menu__subnav">
                                                <li class="kt-menu__item " aria-haspopup="true">
                                                    <a href="<?= base_url('welcome/alurbisnispeminjam') ?>" class="kt-menu__link ">
                                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">Enterprise</span>
                                                    </a>
                                                </li>
                                                <li class="kt-menu__item " aria-haspopup="true">
                                                    <a href="<?= base_url('welcome/alurbisnispendana') ?>" class="kt-menu__link ">
                                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">UKM</span>
                                                    </a>
                                                </li>
                                                <li class="kt-menu__item " aria-haspopup="true">
                                                    <a href="<?= base_url('welcome/resikoinvestasi') ?>" class="kt-menu__link ">
                                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">Proses Pemodalan</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>


                                    <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                            <span class="kt-menu__link-text">Bantuan</span>
                                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                                            <ul class="kt-menu__subnav">
                                                <li class="kt-menu__item " aria-haspopup="true">
                                                    <a href="<?= base_url('welcome/helpdesk') ?>" class="kt-menu__link ">
                                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">Help Desk</span>
                                                    </a>
                                                </li>
                                                <li class="kt-menu__item " aria-haspopup="true">
                                                    <a href="<?= base_url('welcome/faq') ?>" class="kt-menu__link ">
                                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">FAQ</span>
                                                    </a>
                                                </li>
                                                <li class="kt-menu__item " aria-haspopup="true">
                                                    <a href="<?= base_url('welcome/sk') ?>" class="kt-menu__link ">
                                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="kt-menu__link-text">Syarat dan Ketentuan</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>





                                </ul>
                            </div>
                        </div>

                        <!-- end: Header Menu -->


                        <!-- begin:: Header Topbar -->
                        <div class="kt-header__topbar kt-grid__item">
                            <img src="<?= base_url('assetsprofile/') ?>assetsbaru/media/logos/ojk-logo.png" style="margin-right: 20px;" class="imgnew">

                            <!--begin: Language bar -->
                            <div class="kt-header__topbar-item kt-header__topbar-item--langs">
                                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">

                                    <?php
                                    if (!isset($user)) {
                                    ?>
                                        <span class="kt-header__topbar-username" style="
    color: #3a248f!important;
    font-weight: 500;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-item-align: center;
    align-self: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    "> Daftar / Login</span>
                                    <?php

                                    }

                                    ?>



                                    <span class="kt-header__topbar-icon">


                                        <?php
                                        if (!isset($user)) {
                                        ?>

                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                                </g>
                                            </svg>



                                        <?php

                                        } else {

                                        ?>


                                            <img class="img-profile rounded-circle" src="<?= base_url('assets/img/profile/') . $user['image'] ?>">

                                        <?php
                                        }

                                        ?>

                                    </span>

                                </div>
                                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim">

                                    <?php
                                    if (isset($user)) {
                                    ?>
                                        <span style="    margin: 22px 22px 0 22px;
    color: #000!important;
    display: inline-block;"> <?= $user['id_anggota']; ?>-<?= $user['name']; ?></span>

                                        <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
                                            <li class="kt-nav__item">
                                                <a href="<?= base_url('user/profile') ?>" class="kt-nav__link">
                                                    <span class="kt-nav__link-text"> <i class="fas fa-fw fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                                        Lihat Profil</span>
                                                </a>
                                            </li>

                                            <li class="kt-nav__item">
                                                <a href="<?= base_url('user/edit') ?>" class="kt-nav__link">
                                                    <span class="kt-nav__link-text"><i class="fas fa-fw fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                                                        Edit Profil</span>
                                                </a>
                                            </li>


                                            <li class="kt-nav__item">
                                                <a href="<?= base_url('auth/logout') ?>" class="kt-nav__link">
                                                    <span class="kt-nav__link-text"> <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                                        Logout</span>
                                                </a>
                                            </li>

                                        </ul>

                                    <?php

                                    } else {

                                    ?>
                                        <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
                                            <li class="kt-nav__item kt-nav__item--active">
                                                <a href="<?= base_url('auth') ?>" class="kt-nav__link">
                                                    <span class="kt-nav__link-text">Masuk</span>
                                                </a>
                                            </li>
                                            <li class="kt-nav__item">
                                                <a href="<?= base_url('auth/registration') ?>" class="kt-nav__link">
                                                    <span class="kt-nav__link-text">Daftar</span>
                                                </a>
                                            </li>
                                        </ul>

                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <!--end: Language bar -->
                        </div>
                        <!-- end:: Header Topbar -->
                    </div>
                </div>

                <!-- CONTENT -->

                <section class="breadcrumb">

                    <div class="container">

                        <div class="row">

                            <div class="col-sm-12">

                                <h1>CEO dan Tim</h1>


                                </li>
                                </ol>

                            </div>

                        </div>

                    </div>

                </section>


                <!-- About Us Text -->



                <!-- Members -->

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 align="center">Board of Commisioner</h3>
                            <br />
                        </div>
                    </div>
                </div>
                <section class="content-section">

                    <div class="container">

                        <div class="row">

                            <div class="col-sm-3">

                                <div class="staff-member">

                                    <a class="image" href="#">
                                        <img style="width: 200px;
    height: 250px;
    object-fit: cover;
    background-repeat: no-repeat;" src="<?= base_url('assetsprofile/') ?>asset/images/Pak Donald Akbar1.jpg" class="img-box" />
                                    </a>

                                    <h4>
                                        <a href="#">1. Donald Akbar </a>
                                        <small>President Commisioner</small>
                                    </h4>

                                    <p>Berkecimpung sebagai komisaris dan komisaris utama di beberapa perusahaan multi industri, membuatnya memiliki pengalaman yang panjang dan tajam sebagai pengawas jalannya Fulusme . Dengan memiliki visi dan misi untuk memajukan bisnis dengan konsep Urun Dana/ securities crowd funding bagi seluruh masyarakat, diharapkan Fulusme dapat bermanfaat bagi dunia bisnis di Indonesia. </p>

                                </div>

                            </div>



                            <div class="col-sm-3">

                                <div class="staff-member">

                                    <a class="image" href="#">
                                        <img style="width: 200px;
    height: 250px;
    object-fit: cover;
    background-repeat: no-repeat;" src="<?= base_url('assetsprofile/') ?>asset/images/Pak Helmi Yusuf1.jpg" style="
									width: 128px;" class="img-box" />
                                    </a>

                                    <h4>
                                        <a href="#">2. Helmi Yusuf </a>
                                        <small>Commisioner</small>
                                    </h4>

                                    <p>Memiliki pengalaman yang panjang dalam dunia telekomunikasi dan pernah berdinas di perusahaan operator selular terkemuka di Indonesia selama beberapa tahun. Saat ini masih menjabat sebagai komisaris di beberapa perusahaan. Dengan adanya beliau, memungkinkan Fulusme untuk memiliki pengawas yang handal untuk lebih berkembang kedalam bisnis Securities Crowd Funding</p>

                                </div>

                            </div>
                            <div class="col-sm-3">

                                <div class="staff-member">

                                    <a class="image" href="#">
                                        <img style="width: 200px;
    height: 250px;
    object-fit: cover;
    background-repeat: no-repeat;" src="<?= base_url('assetsprofile/') ?>asset/images/Pak Dony Yuliardi.jpg" style="
									width: 128px;" class="img-box" />
                                    </a>

                                    <h4>
                                        <a href="#">3. Dony Yuliardi </a>
                                        <small>Commisioner</small>
                                    </h4>

                                    <p>Saat ini masih menjabat sebagai komisaris dan direktur di beberapa perusahaan. Dengan pengalaman multi talenta dan multi industri, menjadikannya matang sebagai pengawas di Fulusme . Selain berpengalaman sebagai teknokrat, juga berpengalaman dalam bisnis praktis dan enterpreneur. Di sela kesibukannya, masih sempat mengajar sebagai dosen di Universitas Bina Nusantara</p>

                                </div>

                            </div>



                            <div class="col-sm-3">

                                <div class="staff-member">

                                    <a class="image" href="#">
                                        <img style="width: 200px;
    height: 250px;
    object-fit: cover;
    background-repeat: no-repeat;" src="<?= base_url('assetsprofile/') ?>asset/images/Pak Cacan Somantri1.jpg" style="
									width: 128px;" class="img-box" />
                                    </a>

                                    <h4>
                                        <a href="#">4. Cacan Somantri Agis </a>
                                        <small>Commisioner</small>
                                    </h4>

                                    <p>Berpengalaman selama bertahun – tahun di dunia keuangan dan asuransi. Saat ini masih menjabat sebagai direktur dan komisaris di beberapa perusahaan serta menjadi pengajar untuk pelatihan dan pengembangan manajemen dan SDM. Karena pengalaman di bidang bisnis dan keuangan inilah menjadikan beliau sebagai pengawas di Fulusme </p>

                                </div>

                            </div>


                        </div>

                    </div>

                </section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 align="center">Board of Directors</h3>
                            <br />
                        </div>
                    </div>
                </div>
                <section class="content-section">

                    <div class="container">

                        <div class="row">

                            <div class="col-sm-3">

                                <div class="staff-member">

                                    <a class="image" href="#">
                                        <img style="width: 200px;
    height: 250px;
    object-fit: cover;
    background-repeat: no-repeat;" src="<?= base_url('assetsprofile/') ?>asset/images/Pak_chris.png" class="img-box" />
                                    </a>

                                    <h4>
                                        <a href="#">Chris Agustono W </a>
                                        <small>CEO / Chief Executive Officer</small>
                                    </h4>

                                    <p>Berpengalaman lebih dari 20 tahun sebagai praktisi, konsultan dan Auditor IT. Beberapa kali menjadi pembicara dan moderator untuk event IT nasional. </p>
                                    <p>
                                        Pengalamannya menjadi dasar bagi pengembangan finansial berbasis teknologi saat ini dengan membangun platform Securities Crowd Funding, utamanya utk memenuhi kebutuhan akan Pendanaan dan Pemodalan yang tepat sasaran dan memberikan kontribusi bagi seluruh lapisan masyarakat tanpa dibatasi oleh ruang dan waktu
                                    </p>

                                </div>

                            </div>

                            <div class="col-sm-3">

                                <div class="staff-member">

                                    <a class="image" href="#">
                                        <img style="width: 200px;
    height: 250px;
    object-fit: cover;
    background-repeat: no-repeat;" src="<?= base_url('assets/') ?>img/picNanda.png" style="
									width: 128px;" class="img-box" />
                                    </a>

                                    <h4>
                                        <a href="#">Nandana Pawitra </a>
                                        <small>COO / Chief Operation Officer</small>
                                    </h4>

                                    <p>Berpengalaman lebih dari 20 tahun sebagai profesional, pelaku pasar di Bursa Efek dan pemilik Anggota Bursa Berjangka Jakarta.</p>
                                    <p>Juga pendiri The Jakarta Commodity Exchange.</p>
                                    <p>Pengalaman yang cukup dalam industri Capital Market dapat menjadi landasan dalam mengembangkan industri Securities Crowd Funding yang Insya AlLah dapat menjadi manfaat bagi sebanyak-banyak umat.
                                    </p>

                                </div>

                            </div>

                            <div class="col-sm-3">

                                <div class="staff-member">

                                    <a class="image" href="#">
                                        <img style="width: 200px;
    height: 250px;
    object-fit: cover;
    background-repeat: no-repeat;" src="<?= base_url('assetsprofile/') ?>asset/images/Ibu Ramaida1.jpg" style="
									width: 128px;" class="img-box" />
                                    </a>

                                    <h4>
                                        <a href="#">Ramaida </a>
                                        <small>CFO / Chief Finance Officer</small>
                                    </h4>

                                    <p>Memiliki pengalaman bertahun – tahun di beberapa industri. Sempat berkarier di dunia telekomunikasi dan switching sebelum akhirnya menjabat sebagai direktur keuangan di Fulusme </p>

                                </div>

                            </div>

                            <div class="col-sm-3">

                                <div class="staff-member">

                                    <a class="image" href="#">
                                        <img style="width: 200px;
    height: 250px;
    object-fit: cover;
    background-repeat: no-repeat;" src="<?= base_url('assetsprofile/') ?>asset/images/chesyah.png" style="
									width: 128px;" class="img-box" />
                                    </a>

                                    <h4>
                                        <a href="#">Andi Chesyah Mapanyompa </a>
                                        <small>CTO / Chief Technology Officer</small>
                                    </h4>

                                    <p>Berkecimpung di dunia IT dan Perbankan selama lebih dari 12 tahun membuat Saya tertantang melakukan hal baru:
                                        mencari dan menentukan posisi teknologi dalam menjalankan bisnis dan
                                        memaksimalkan Jaringan internet,komunikasi serta Aplikasi.
                                        Bergabung di jajaran direksi Fulusme untuk membangun aktivitas Bisnis Securities Crowd Funding yang simpel dengan memanfaatkan perkembangan teknologi.</p>
                                </div>

                            </div>




                        </div>

                    </div>

                </section>

                <!-- CONTENT -->

                <!-- begin:: Footer -->
                <div class="kt-footer kt-grid__item" id="kt_footer">


                    <!-- end:: Footer -->
                </div>
            </div>
        </div>


        <div>

            <section class="footer-widgets" style="font-size: 11px; background:white; padding-top:50px; padding-bottom:50px;">

                <div class="container">

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-2">
                                    <a href="index.php">
                                        <img src="<?= base_url('assetsprofile/') ?>asset/images/dealfintech.jpg" width="85" />
                                    </a>
                                </div>

                                <div class="col-sm-10">
                                    <p style="
margin-top: 25px;
">
                                        Fulusme adalah Layanan Urun Dana Berbasis Teknologi (Securities Crowd Funding), yang kami bangun untuk dapat bermanfaat bagi dunia bisnis di Indonesia.
                                    </p>
                                </div>



                            </div>
                        </div>

                        <div class="col-sm-3">

                            <h5>Alamat</h5>

                            </p>
                            </p>PT. Fintek Andalan Solusi Teknologi <br>
                            Jl. Bendungan Hilir IV No.6 <br>
                            Kecamatan Tanah Abang <br>
                            Jakarta Pusat,10210 <br>
                            Indonesia <br></p>
                            </p>

                        </div>

                        <div class="col-sm-3">

                            <h5>Hubungi Kami</h5>

                            </p>
                            Phone: +62 21 2520-934<br>
                            Penerbit: +62 21 2555-8986<br>
                            Pemodal: +62 21 2555-8986<br>
                            UKM: +62 21 2555-8986<br>
                            E-mail: <a href="#">info@fulusme.id </a></p>
                            <img src="<?= base_url('assetsprofile/') ?>asset/images/wa.png" width="13" />
                            <a href="https://api.whatsapp.com/send?phone=6282299996862&text=&source=&data=">+62 822 9999 6862</a>
                            <br>
                            <img src="<?= base_url('assetsprofile/') ?>asset/images/instagram.png" width="14" />
                            <a href="https://www.instagram.com/fulusme/">@fulusme</a>

                        </div>

                    </div>
                    <div class="col-sm-6">
                        <span>Copyright &copy; fulusme.id <?php echo date("Y"); ?></span>

                    </div>
            </section>



        </div>









        <!-- end:: Page -->


        <!-- begin::Scrolltop -->
        <div id="kt_scrolltop" class="kt-scrolltop">
            <i class="fa fa-arrow-up"></i>
        </div>

        <!-- end::Scrolltop -->


        <!-- begin::Global Config(global config for global JS sciprts) -->
        <script>
            var KTAppOptions = {
                "colors": {
                    "state": {
                        "brand": "#591df1",
                        "light": "#ffffff",
                        "dark": "#282a3c",
                        "primary": "#5867dd",
                        "success": "#34bfa3",
                        "info": "#36a3f7",
                        "warning": "#ffb822",
                        "danger": "#fd3995"
                    },
                    "base": {
                        "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                        "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
                    }
                }
            };
        </script>

        <!-- end::Global Config -->

        <!--begin::Global Theme Bundle(used by all pages) -->
        <script src="<?= base_url('assetsprofile/') ?>assetsbaru/plugins/global/plugins.bundle.js" type="text/javascript"></script>
        <script src="<?= base_url('assetsprofile/') ?>assetsbaru/js/scripts.bundle.js" type="text/javascript"></script>

        <!--end::Global Theme Bundle -->


        <div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tingkat Keberhasilan 90</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body" style="font-size: 13px;padding: 60px;color: black;">
                        <div class="text-center mb-3" style="
margin-bottom: 40px;
">
                            <img src="https://mumtaaz.id/assetsprofile/asset/images/logo-ojk.png">
                        </div>
                        <p>
                            Dalam rangka menjalankan prinsip transparansi sesuai dengan Pasal 29 huruf a Peraturan Otoritas Jasa Keuangan Nomor 77/POJK.01/2016 tentang Layanan Pembiayaan Berbasis Teknologi Informasi, Penyelenggara Layanan Pembiayaan Berbasis Teknologi Informasi wajib mempublikasikan tingkat keberhasilan Penyelenggara dalam memfasilitasi penyelesaian kewajiban Pembiayaan antara Penerima Pembiayaan dengan Pemberi Pembiayaan dalam jangka waktu sampai dengan 90 hari terhitung sejak jatuh tempo (“Tingkat Keberhasilan 90 atau TKB90”).
                        </p>
                        <p>
                            Rumus perhitungan yang digunakan untuk menentukan TKB90 adalah sebagai berikut :
                        </p>
                        <p class="text-center font-weight-bold">
                            TKB90 = 100% - NPL90
                        </p>
                        <p style="
margin-bottom: 30px;
">
                            NPL90 ditentukan menggunakan rumus perhitungan:
                        </p>
                        <table style="width: 100%; max-width: 100%;">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold" rowspan="2">NPL90 = </td>
                                    <td class="text-center font-weight-bold">Outstanding pembiayaan macet di atas 90 hari</td>
                                    <td class="font-weight-bold" rowspan="2"> &nbsp; x 100%</td>
                                </tr>
                                <tr>
                                    <td class="text-center font-weight-bold" style="border-top: 1px solid #000;">Outstanding keseluruhan</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="mt-3" style="
margin-top: 30px;
">
                            Semakin tinggi persentase TKB90 yang dimiliki oleh Penyelenggara, maka semakin baik pula Penyelenggara dalam menjalankan Layanan Pembiayaan Berbasis Teknologi Informasi.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=f50a8472-49e9-41b0-8efe-fbd25b64576e"> </script>
</body>

<!-- end::Body -->

</html>