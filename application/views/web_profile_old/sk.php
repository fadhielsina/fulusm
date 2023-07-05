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
                                    <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
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


                                    <li class="kt-menu__item kt-menu__item--here kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
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

                                <h1>Syarat & Ketentuan</h1>

                                </li>
                                </ol>

                            </div>

                </section>


                <!-- About Us Text -->
                <section class="content-section">

                    <div class="container">

                        <br>
                        <p style="font-size: 20px; color: #008000;" align="center"><b>Umum</b></p>
                        <ol type="1">
                            <li>
                                </p>Judul yang digunakan dalam S&K ini adalah dalam bentuk notifikasi dan tidak untuk mempengaruhi dan mengubah penafsiran.</b>
                            </li>
                            <li>
                                </p>Jika terdapat perbedaan antara akad perjanjian dan S&K, maka yang berlaku adalah akad perjanjian.</p>
                            </li>
                            <li>
                                </p>S&K ini bisa direvisi maupun di amandemen sesuai dengan kebutuhan dan kemudian disetujui para pemangku kepentingan..</p>
                            </li>
                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Definisi</b></p>
                        <ol type="1">
                            <li>
                                </p>Layanan Urun Dana adalah suatu program layanan pendanaan bersama yang diselenggarakan oleh Penyelenggara dengan melakukan penawaran Efek milik Penerbit kepada Pemodal atau masyarakat umum melalui penawaran Efek dengan jaringan sistem elektronik, Layanan Urun Dana berbasis teknologi informasi (Securities crowdfunding) milik Penyelenggara yang bersifat terbuka sebagaimana diatur dalam POJK Layanan Urun Dana .</p>
                            </li>
                            <li>
                                </p>POJK Layanan Urun Dana adalah Peraturan Otoritas Jasa Keuangan Nomor : 57/POJK.04/2020 beserta perubahan-perubahannya.</p>
                            </li>
                            <li>
                                </p>Efek adalah nilai permodalan yang dibutuhkan dan dikeluarkan oleh Penerbit.</p>
                            </li>
                            <li>
                                </p>Fulusme SCF adalah penyedia layanan Securities Crowd Funding (Layanan Urun Dana ), yaitu tempat bertemunya Pemodal dan Penerbit dalam 1 marketplace (platform.</p>
                            </li>
                            <li>
                                </p>Fulusme berikutnya didefinisikan sebagai Platform atau Penyelenggara layanan.</p>
                            </li>
                            <li>
                                </p>Fulusme hanya terdaftar sebagai platform Securities Crowd Funding dan tidak menjalankan kegiatan perbankan, asuransi atau yang setara dan sejenisnya.</p>
                            </li>
                            <li>
                                </p>Fulusme bukan nama perusahaan melainkan merk dagang dari PT Fintek Andalan Solusi Teknologi yang berlokasi di Jakarta.</p>
                            </li>
                            <li>
                                </p>Yang dimaksud dengan Pemodal adalah entiti atau perseorangan yang menginvestasikan uangnya dalam bentuk Efek didalam suatu proyek dalam kurun waktu tertentu berdasarkan informasi profil yang disajikan pihak Penyelenggara.</p>
                            </li>
                            <li>
                                </p>Yang dimaksud dengan Penerbit adalah badan usaha yang memiliki dokumen legal diwilayah NKRI yang ditandasahkan oleh badan yang berwenang</p>
                            </li>
                            <li>
                                </p>Yang dimaksud dengan stakeholder pada S&K ini adalah para pemangku kepentingan atau mitra bisnis bagi Penyelenggara, yaitu pihak Penerbit dan Pemodal, dan tidak terkait maksudnya dengan para shareholder (pemegang Efek) di internal Penyelenggara</li>
                            <p />
                            <li>
                                </p>Buyback adalah proses dimana Penerbit melakukan pembelian kembali Efek yang telah dijual oleh Penerbit kepada Pemodal
                                <p />
                            </li>
                            <li>
                                </p>Yang dimaksud dengan dividen adalah nilai tambah dari angka modal pokok yang ditanamkan pihak Pemodal kepada Penerbit . Nilai ini bisa berarti keuntungan atau bagi hasil untuk Pemodal di periode waktu tertentu
                                <p />
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>PROSEDUR PELAYANAN TERHADAP PENERBIT</b></p>
                        <ol type="1">
                            <li>
                                </p>Penyelenggara memiliki kewajiban untuk melakukan penelaahan/penilaian dan pengkajian kepada calon penerbit paling lambat 2 hari kerja setelah calon Penerbit mengajukan permohonan kebutuhan pendanaan ke Penyelenggara. Mekanisme penelaahan dilakukan dengan cara online, diskusi, asesmen dengan managerial tim maupun visit ke Penerbit jika diperlukan. Adapun dokumen yang akan di telaah meliputi :
                            </li>
                            </p>- Pendirian badan hukum atau dokumen yang membuktikan keabsahan pendirian badan usaha</p>
                            </li>
                            </li>
                            </p>- Profil pengurus badan hukum atau badan usaha.</p>
                            </li>
                            </li>
                            </p>- Segala Aspek hukum yang terkait dengan kebutuhan permodalan Penerbit</p>
                            </li>
                            </li>
                            </P>- Batasan Penerbit, apakah memenuhi kriteria atau tidak
                            </li>
                            </P>- Perizinan yang berkaitan dengan kegiatan usaha Penerbit dan/atau Proyek yang akan didanai dengan dana hasil penawaran Efek atau menjadi dasar penerbitan Efek melalui Layanan Urun Dana
                            </li>
                            </p>- Dokumen dan/atau informasi lain yang wajib disampaikan oleh Penerbit kepada Penyelenggara</p>
                            <li>
                                </p>Penyelenggara akan mengunggah dokumen dan/atau informasi yang terkait dengan proposal kebutuhan pendanaan calon Penerbit melalui situs web Penyelenggara paling lambat 2 (dua) hari kerja sebelum dimulainya masa penawaran efek.</p>
                            <li>
                                </p>Penyelenggara akan membatasi penghimpunan dana melalui Layanan Urun Dana bagi setiap Penerbit tidak melampaui batas kebutuhan pendanaan Penerbit dan/atau batas aturan sesuai POJK 57/POJK.04/2020, yaitu sebesar Rp 10.000.000.000 (Sepuluh Milyar Rupiah)
                            <li>
                                </p>Penyelenggara akan menyediakan fasilitas komunikasi secara daring antara Pemodal dengan Penerbit yang akan diinformasikan di tiap proposal masing-masing Penerbit
                            <li>
                                </p>Penerbit Efek bersifat ekuitas dilarang menggunakan jasa Layanan Urun Dana melalui lebih dari 1 (satu) Penyelenggara.
                            <li>
                                </p>Penerbit Efek bersifat utang dilarang melakukan penghimpunan dana baru melalui Layanan Urun Dana sebelum Penerbit memenuhi seluruh kewajiban kepada Pemodal, kecuali penawaran Efek bersifat utang dilakukan secara bertahap.
                            <li>
                                </p>Syarat batas waktu penghimpunan dana oleh setiap Penerbit adalah dalam jangka waktu 12 (dua belas) bulan paling banyak Rp10.000.000.000 (sepuluh miliar rupiah) dan penghimpunan dana sebagaimana dimaksud dapat dilakukan dalam 1 (satu) kali penawaran atau lebih.</p>
                            </li>
                            <li>
                                </p>Penerbit dapat menetapkan jumlah minimum dana yang harus diperoleh dalam penawaran Efek melalui Layanan Urun Dana berdasarkan kesepakatan yang dimuat dalam perjanjian penyelenggaraan Layanan Urun Dana.
                            <li>
                                </p>Penerbit dapat membatalkan penawaran Efek melalui Layanan Urun Dana sebelum berakhirnya masa penawaran dengan membayar denda sejumlah yang ditetapkan dalam perjanjian penyelenggaraan Layanan Urun Dana kepada Penyelenggara
                            <li>
                                </p>Dalam hal Penerbit menetapkan jumlah minimum kebutuhan pendanaan nya, Penerbit wajib mengungkapkan:
                            </li>
                            </p>- Rencana penggunaan dana sehubungan dengan perolehan dana minimum
                            </li>
                            </p>- Sumber dana lain untuk melaksanakan rencana penggunaan dana (jika ada).
                            </li>
                            </p>- Penerbit dilarang mengubah jumlah minimum dana sebagaimana dimaksud pada ayat (1) dalam masa penawaran Efek.</p>
                            </li>
                            </li>
                            </p>- Jika jumlah minimum dana sebagaimana dimaksud tidak terpenuhi, penawaran Efek melalui Layanan Urun Dana tersebut batal demi hukum.</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Prosedur komunikasi layanan konsumen (Penyampaian Informasi)</b></p>
                        <ol type="1">
                            <li>
                                </p>Prosedur penerimaan penanganan pengaduan
                            <li>
                                </p>Pengguna mengajukan keluhan atau pengaduan dengan menghubungi layanan Contact Center Fulusme, melalui media telepon dan email.</p>
                            </li>
                            </li>
                            </p>Pencatatan data pengguna dan kebutuhan informasi Pada saat customer berinteraksi dengan Contact Center Fulusme maka agen akan mencatat informasi dari pengguna.</p>
                            </li>
                            </li>
                            </p>Jika pengaduan diluar fitur yang ada di fulusme, maka permintaan pengaduan akan ditolak.</p>
                            </li>
                            <li>
                                </P>Prosedur penanganan
                            </li>
                            </P>- Tindakan dalam penanganan pengaduan :
                            </li>
                            </p>- Pemeriksaan internal secara benar dan objektif</p>
                            </li>
                            </p>- Perusahaan akan meminta tambahan data atau dokumen pendukung apabila diperlukan.</p>
                            </li>
                            </p>- Tindakan dalam penolakan menangani pengaduan :
                            </li>
                            </p>- Apabila terjadi pengaduan terkait dengan fulusme atau potensi materiil, maka secara langsung telah tercantum dalam perjanjian/ dokumen pendukung lainnya.
                            </li>
                            </p>- Media penyampaian informasi perihal penolakan pemberi informasi kepada pengguna telah diakomodir dalam aplikasi.
                            </li>
                            </p>- Penyampaian ketidaktersedia nya informasi
                            </li>
                            </p>- Pada saat pengguna dapat menerima alasan penolakan pemberian informasi yang diberikan oleh fulusme.</p>
                            </li>
                            <li>
                                </p>Tata tertib penanganan
                            </li>
                            </p>- Penyelesaian masalah atau pengaduan dapat disampaikan secara lisan maupun tertulis.
                            </li>
                            </p>- Jika belum bisa diselesaikan secara langsung, maka Agen akan melakukan eskalasi ke team leader maksimum 1x24 jam
                            </li>
                            </p>- Penyelesaian pengaduan (resolution time) paling lambat dilakukan 2 x 24 jam.
                            </li>
                            </p>- Penambahan waktu diperlukan apabila masalah atau kasus belum terselesaikan, fulusme akan konfirmasi terlebih dahulu kepada pengguna.
                            </li>
                            </p>- Fulusme mengutamakan prinsip musyawarah dan kekeluargaan dalam penyelesaian masalah/pengaduan.</p>
                            </li>


                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Beban dan Biaya</b></p>
                        <ol type="1">

                            <li>
                                </p>Platform dalam kapasitasnya memberikan layanan marketplace, akan mengutip komisi yang besarnya 10% (sepuluh persen) dari total pendanaan yang disetujui untuk Penerbit.</p>
                            </li>
                            <li>
                                </p>Dengan pertimbangan tertentu dari pihak Platform sehingga calon Penerbit dan Pemodal tidak berhak dalam daftar pengguna di Fulusme , maka pihak Platform tidak akan membebankan kewajiban atau biaya apapun. </p>
                            </li>
                            <li>
                                </p>Biaya lain yang timbul secara tidak langsung dan menjadi beban Penerbit dalam terlaksananya kerjasama ini adalah :</p>

                                a. Pemeriksaan keabsahan SHM surat jaminan di BPN </p>
                                b. Pengecekan nilai harga pasaran dari SHM jaminan (appraisal) oleh KJPP </p>
                                c. Biaya kenotariatan oleh notaris </p>
                                d. Biaya gabung awal di KSEI </p>
                                e. Biaya tahunan KSEI </p>
                                </p>Biaya lain yang timbul secara tidak langsung dan menjadi beban Pemodal dalam terlaksananya kerjasama ini adalah :</p>
                                a. Biaya per transaksi yang akan dikenakan oleh KSEI sebesar Rp.20.000 per transaksi ke Pemodal </p>
                                b. Biaya transfer atau pemindah bukuan akan dikenakan ke Pemodal sesuai kebijakan masing-masing Bank




                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Masa Penawaran Efek</b></p>
                        <ol type="1">
                            <li>
                                </p>Penyelenggara melakukan penawaran Efek Penerbit selama masa penawaran Efek oleh Penerbit yang dilakukan paling lama 45 (empat puluh lima hari) Hari Kalender</p>
                            </li>
                            <li>
                                </p>Pemodal mengerti dan memahami bahwa Penerbit dapat membatalkan penawaran Efek melalui Layanan Urun Dana sebelum berakhirnya masa penawaran Efek dengan konsekuensi membayar sejumlah denda kepada Penyelenggara</p>
                            </li>
                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Persetujuan Penerbit</b></p>
                        <ol type="1">
                            <li>
                                </p>Platform berkewajiban mencari dan memberikan profil informasi yang detil dan jelas tentang proyek yang diajukan oleh calon Penerbit, kepada Pemodal.</p>
                            </li>
                            <li>
                                </p>Proyek yang diputuskan akan didanai oleh Pemodal, merupakan tanggung jawab Pemodal sepenuhnya.</p>
                            </li>
                            <li>
                                </p>Dalam proses analisa dan kompilasi data berdasarkan hasil survey dan pengajuan via web, platform memiliki pertimbangan absolut untuk menentukan apakah calon masuk dalam daftar Penerbit atau Pemodal.</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Pembelian Efek</b></p>
                        <ol type="1">
                            <li>
                                </p>Pembelian Efek oleh Pemodal dalam penawaran Efek melalui Layanan Urun Dana dilakukan dengan menyetorkan sejumlah Dana pada escrow account</p>
                            </li>
                            <li>
                                </p>Batasan pembelian Efek oleh Pemodal dalam Layanan Urun Dana adalah sebagai berikut:</P>
                            </li>
                            </p>a. Setiap Pemodal dengan penghasilan sampai dengan Rp500.000.000,00 (lima ratus juta rupiah) per tahun, dapat membeli Efek melalui Layanan Urun Dana paling banyak sebesar 5% (lima persen) dari penghasilan per tahun; dan</p>
                            </li>
                            </p>b. Setiap Pemodal dengan penghasilan lebih dari Rp500.000.000,00 (lima ratus juta rupiah) per tahun, dapat membeli Efek melalui Layanan Urun Dana paling banyak sebesar 10% (sepuluh persen) dari penghasilan per tahun.
                            .</p>
                            </li>
                            <li>
                                </p>Batasan pembelian Efek oleh Pemodal tidak berlaku dalam hal Pemodal merupakan badan hukum; dan pihak yang mempunyai pengalaman berinvestasi di Pasar Modal yang dibuktikan dengan kepemilikan rekening efek paling sedikit 2 (dua) tahun sebelum penawaran Efek.</p>
                            </li>
                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Penyerahan Dana dan Efek</b></p>
                        <ol type="1">
                            <li>
                                </p>Pemodal mengerti dan memahami bahwa Penyelenggara wajib menyerahkan Dana dari Pemodal kepada Penerbit melalui Penyelenggara, paling lambat 2 (dua) Hari Kerja setelah berakhirnya masa penawaran Efek.</p>
                            </li>
                            <li>
                                </p>Manfaat bersih dari penempatan Dana dikembalikan kepada Pemodal secara proporsional.</p>
                            </li>
                            <li>
                                </p>Berakhirnya masa penawaran adalah:
                                </p>a. Tanggal tertentu yang telah ditetapkan dan disepakati oleh Para Pihak; atau
                                </p>b. Tanggal tertentu sebelum berakhirnya masa penawaran Efek namun seluruh Efek yang ditawarkan melalui Layanan Urun Dana telah dibeli oleh Pemodal
                                </p>
                            </li>
                            <li>
                                </p>Pemodal mengerti dan memahami bahwa Penerbit wajib menyerahkan Efek kepada Penyelenggara untuk didistribusikan kepada Pemodal paling lambat 2 (dua) Hari Kerja setelah Penerbit menerima Dana Pemodal dari Penyelenggara</p>
                            </li>
                            <li>
                                </p>Pemodal mengerti dan memahami bahwa Penyelenggara wajib mendistribusikan Efek kepada Pemodal paling lambat 2 (dua) Hari Kerja setelah menerima Efek dari Penerbit </p>
                            </li>
                            <li>
                                </p>Pendistribusian Efek kepada Pemodal oleh Penyelenggara dapat dilakukan secara elektronik melalui penitipan kolektif pada kustodian atau pendistribusian secara fisik melalui pengiriman sertifikat Efek</p>
                            </li>
                            <li>
                                </p>Pemodal mengerti dan memahami bahwa Penerbit diwajibkan menetapkan jumlah minimum Dana yang harus diperoleh dalam penawaran Efek melalui Layanan Urun Dana , dan apabila jumlah minimum Dana yang telah ditentukan oleh Penerbit tersebut tidak terpenuhi, maka penawaran Efek melalui Layanan Urun Dana tersebut dinyatakan batal demi hukum</p>
                            </li>
                            <li>
                                </p>Pemodal mengerti dan memahami bahwa dalam hal penawaran Efek batal demi hukum, maka Penyelenggara wajib mengembalikan Dana beserta seluruh manfaat yang timbul dari Dana tersebut ke dalam saldo deposit Pemodal diplatform Penyelenggara secara proporsional kepada Pemodal paling lambat 2 (dua) Hari Kerja setelah penawaran Efek dinyatakan batal demi hukum</p>
                            </li>
                            <li>
                                </p>Bagi Pemodal yang transaksinya tidak valid atau valid sebagian, maka pihak Fulusme akan menghubungi Pemodal untuk melakukan konfirmasi. Apabila Pemodal tidak melakukan konfirmasi balik selama 5 (lima) Hari Kerja kepada Penyelenggara, maka transaksi Pemodal tersebut dimasukkan ke dalam Rekening Escrow Pemodal diplatform Penyelenggara yang sewaktu-waktu dapat ditarik oleh Pemodal</p>
                            </li>
                            <li>
                                </p>Dalam hal transaksi pembelian Efek Pemodal dilakukan pada saat Efek telah dinyatakan habis/soldout, maka Pemodal berhak atas pengembalian pembelian Efek dengan melakukan konfirmasi kepada Penyelenggara melalui media komunikasi yang telah disediakan oleh Penyelenggara. Pengembalian pembayaran pembelian Efek tersebut akan masuk ke dalam Rekening Escrow Pemodal diplatform Penyelenggara yang sewaktu-waktu dapat ditarik oleh Pemodal</p>
                            </li>
                            <li>
                                </p>Pemodal dapat membatalkan rencana pembelian Efek melalui Layanan Urun Dana paling lambat dalam waktu 48 (empat puluh delapan) jam setelah melakukan pembelian Efek. Dalam hal Pemodal membatalkan rencana pembelian Efek, Penyelenggara wajib mengembalikan Dana kepada Pemodal selambatnya 2 (dua) Hari Kerja setelah pembatalan pemesanan Pemodal. Pengembalian tersebut akan masuk ke dalam menu Rekening Escrow didalam aplikasi Penyelenggara yang sewaktu-waktu dapat ditarik oleh Pemodal</p< /li>
                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Daftar Pemegang Efek</b></p>
                        <ol type="1">
                            <li>
                                </p>Pemodal mengerti dan memahami bahwa Penerbit wajib mencatatkan kepemilikan Efek Pemodal dalam daftar pemegang Efek</p>
                            </li>

                            <li>
                                </p>Persetujuan Pemodal terhadap syarat dan ketentuan ini berarti Pemodal setuju dan sepakat bahwa Pemodal memberikan kuasa kepada Penyelenggara untuk mewakili Pemodal sebagai pemegang Efek Penerbit termasuk dalam Rapat Umum Pemegang Efek (RUPS) Penerbit dan penandatanganan akta serta dokumen terkait lainnya</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Penghimpunan Dana</b></p>
                        <ol type="1">
                            <li>
                                </p>Pemodal mengerti dan memahami bahwa pembagian dividen kepada para pemegang Efek tidak bersifat lifetime karena Penerbit merupakan badan usaha berbadan hukum berhak melakukan Buyback sebagaimana diatur dalam akta anggaran dasar Penerbit dan peraturan perundang-undangan yang berlaku</p>
                            </li>
                            <li>
                                </p>Pemodal mengerti dan memahami bahwa pembagian dividen Penerbit diinformasikan di dalam kebijakan dividen dan didasarkan pada laba bersih Penerbit setelah dikurangi dengan pencadangan. Mekanisme pembagian dividen lainnya (termasuk pembagian dividen interim) mengacu pada anggaran dasar Penerbit dan peraturan perundang-undangan yang berlaku</p>
                            </li>
                            <li>
                                </p>Pemodal mengerti dan memahami bahwa pembagian dividen final Penerbit mengacu pada persetujuan Rapat Umum Pemegang Efek (“RUPS”) Penerbit </p>
                            </li>
                            <li>
                                </p>Pemodal mengerti dan memahami bahwa apabila terdapat beban operasional usaha yang harus dikeluarkan setiap periode tertentu, Penerbit tidak memiliki hak untuk membebankannya kepada Pemodal, melainkan beban tersebut dimasukkan ke dalam penghitungan biaya operasional yang kemudian dilaporkan dalam laporan keuangan periode tersebut</li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Kewajiban Pemodal</b></p>
                        <ol type="1">
                            Tanpa mengurangi hak dan kewajiban lainnya sebagaimana telah tersebut dalam Perjanjian ini, maka kewajiban Pemodal adalah sebagai berikut:</p>

                            a. Pemodal wajib menjaga nama baik dan reputasi Penyelenggara dengan tidak melakukan aktifitas yang mengandung unsur suku, agama dan ras, atau tidak melakukan penyebaran informasi yang tidak benar dengan mengatasnamakan Penyelenggara.</p>

                            b. Pemodal wajib tunduk dan patuh pada ketentuan Syarat dan Ketentuan yang tercantum dalam website Penyelenggara serta tunduk dan patuh pada POJK Layanan Urun Dana dan peraturan perundang-undangan yang berlaku di Negara Republik Indonesia</p>

                            c. Pemodal wajib setuju dan sepakat bersedia untuk memberikan akses audit internal maupun audit eksternal yang ditunjuk Penyelenggara serta audit Otoritas Jasa Keuangan (OJK) atau regulator berwenang lainnya setiap kali dibutuhkan terkait pelaksanaan Layanan Urun Dana ini</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Hak Pemodal</b></p>
                        <ol type="1">
                            Tanpa megurangi hak dan kewajiban lainnya sebagaimana telah tersebut dalam Perjanjian ini, maka hak Pemodal adalah sebagai berikut:</p>

                            a. Pemodal berhak untuk melakukan pembelian Efek yang ditawarkan Penerbit melalui Layanan Urun Dana yang diselenggarakan Penyelenggara</p>
                            b. Keputusan pembelian Efek oleh para Pemodal, merupakan tanggung jawab Pemodal sepenuhnya</p>
                            c. Pemodal berhak mendapat manfaat atas pembagian dividen yang dilakukan oleh Penerbit melalui Penyelenggara</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Kewajiban Penyelenggara</b></p>
                        <ol type="1">
                            Tanpa mengurangi hak dan kewajiban lainnya sebagaimana telah tersebut dalam Perjanjian ini, maka kewajiban Penyelenggara adalah sebagai berikut :</p>
                            a. Penyelenggara wajib memenuhi seluruh hak-hak Pemodal</p>
                            b. Penyelenggara memonitor, menganalisa, dan memastikan bahwa Pengguna berada di jalur yang sesuai dengan visi misi Penyelenggara dan Layanan Urun Dana</p>
                            c. Penyelenggara bertanggung jawab melakukan ganti rugi atas setiap kerugian Pemodal yang timbul disebabkan oleh kelalaian karyawan ataupun direksi Penyelenggara</p>
                            d. Penyelenggara berkewajiban mencari dan memberikan profil informasi yang detil dan jelas tentang proyek yang diajukan oleh calon Penerbit , kepada Pemodal</p>
                            </li>
                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Hak Penyelenggara</b></p>
                        <ol type="1">

                            Tanpa mengurangi hak dan kewajiban lainnya sebagaimana telah tersebut dalam Perjanjian ini, maka hak Penyelenggara adalah :</p>
                            a. Penyelenggara berhak atas manfaat dari Pemodal atas Layanan Urun Dana yang sedang berlangsung</p>
                            b. Penyelenggara dalam kapasitasnya memberikan layanan marketplace, akan mengutip komisi yang besarnya 10% dari total nilai penawaran Efek Penerbit yang disetujui.</p>
                            c. Dalam proses analisa dan kompilasi data berdasarkan hasil survey dan pengajuan via web, Penyelenggara memiliki pertimbangan absolut untuk menentukan apakah calon masuk dalam daftar Penerbit atau Pemodal</p>
                            d. Dengan pertimbangan tertentu dari pihak Penyelenggara sehingga calon Penerbit dan Pemodal tidak berhak dalam daftar stakeholder di Fulusme maka pihak Platform tidak akan membebankan kewajiban atau biaya apapun</p>
                            </li>
                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Perpajakan</b></p>
                        <ol type="1">
                            <li>
                                </p>Pembebanan pajak yang timbul dalam Layanan Urun Dana ini menjadi beban masing-masing pihak sesuai dengan ketentuan hukum perpajakkan yang berlaku di wilayah Negara Republik Indonesia</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Hak Atas Kekayaan Intelektual</b></p>
                        <ol type="1">
                            <li>
                                </p>Hak atas kekayaan intelektual yang timbul atas pelaksanaan Layanan Urun Dana dan izin Penyelenggara, beserta fasilitas-fasilitas lain yang dimiliki Penyelenggara dan digunakan dalam Layanan Urun Dana ini adalah tetap dan seterusnya milik Penyelenggara dan tidak ada penyerahan hak dari Penyelenggara kepada Pemodal dalam Layanan Urun Dana ini</p>
                            </li>
                            <li>
                                </p>Pemodal tidak berhak untuk mengubah, mengembangkan, membagikan dan/atau menjual baik seluruh maupun sebagian hak atas kekayaan intelektual yang timbul atas pengembangan, inovasi, perubahan berupa fitur dan/atau fungsi terhadap sistem teknologi informasi</p>
                            </li>
                            <li>
                                </p>Penyelenggara dengan ini menjamin bahwa hak atas kekayaan intelektual yang terkandung dalam pelaksanaan Layanan Urun Dana ini tidak melanggar hak atas kekayaan intelektual milik pihak manapun, dan Penyelenggara membebaskan Pemodal dari segala tuntutan, gugatan dari pihak manapun, sehubungan dengan pelanggaran terhadap hak atas kekayaan intelektual yang terkandung dalam Layanan Urun Dana sesuai dengan Syarat dan Ketentuan ini</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Jangka Waktu Pengakhiran</b></p>
                        <ol type="1">
                            <li>
                                </p>Jangka waktu Layanan Urun Dana antara Penyelenggara dan Pemodal ini berlaku selama Penerbit turut serta dalam Layanan Urun Dana </p>
                            </li>
                            <li>
                                </p>Layanan Urun Dana ini berakhir dengan sendirinya, apabila :
                                </p> a.Penerbit melakukan Buyback Efek;
                                </p> b.Diakhiri oleh Penyelenggara.
                                </p>
                            </li>
                            <li>
                                </p>Dalam hal Layanan Urun Dana ini berakhir dan/atau dinyatakan berakhir, maka Para Pihak sepakat bahwa ketentuan Informasi Rahasia sebagaimana diatur dalam Syarat dan Ketentuan ini tetap berlaku dan mengikat Para Pihak hingga kapanpun meskipun Layanan Urun Dana telah berakhir</p>
                            </li>
                            <li>
                                </p>Pengakhiran/pembatalan Layanan Urun Dana ini tidak menghapuskan kewajiban-kewajiban masing-masing Pihak yang telah atau akan timbul dan belum dilaksanakan pada saat berakhirnya Layanan Urun Dana ini</p>
                            </li>
                            <li>
                                </p>Dalam hal pengakhiran/pembatalan Layanan Urun Dana ini, Para Pihak sepakat untuk mengesampingkan keberlakuan ketentuan Pasal 1266 Kitab Undang-Undang Hukum Perdata, sepanjang ketentuan tersebut mensyaratkan adanya suatu putusan atau penetapan pengadilan untuk menghentikan atau mengakhiri suatu perjanjian, sehingga pengakhiran/pembatalan Layanan Urun Dana ini cukup dilakukan dengan pemberitahuan tertulis dari salah satu Pihak</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Perlindungan Data Pribadi</b></p>
                        <ol type="1">
                            <li>
                                </p>Pemodal dan/atau Penerbit memberikan kuasa kepada Fulusme Layanan Urun Dana untuk:</p>
                            </li>
                            <li>
                                </p>Melaksanakan pengecekan dan penilaian pembiayaan kepada Penerbit termasuk melakukan asesmen atau validasi terhadap setiap Data Pribadi dan dokumen atau informasi apapun yang diperoleh dari atau disingkapkan oleh Penerbit</p>
                            </li>
                            <li>
                                </p>Mendapatkan dan melakukan verifikasi informasi mengenai Pemodal dan/atau Penerbit, sesuai dengan pertimbangan tunggal dan absolut Fulusme Layanan Urun Dana jika dianggap Perlu</p>
                            </li>
                            <li>
                                </p>Pemodal dan Penerbit setuju untuk datanya didaftarkan di Digisign dan Bank Danamon Indonesia sebagai Bank Kustodian</p>
                            </li>
                            <li>
                                </p>Menggunakan semua sumber relevan, yang dapat digunakan oleh Fulusme Layanan Urun Dana , untuk menyediakan informasi yang dibutuhkan oleh Fulusme Layanan Urun Dana terkait dengan fasilitas Pembiayaan yang diberikan</p>
                            </li>
                            <li>
                                </p>Dengan ini, Para Pemodal dan Penerbit menyetujui bahwa Fulusme Layanan Urun Dana dapat mengumpulkan, menyimpan, memproses, membuka informasi, mengakses, mengkaji, dan/atau menggunakan data pribadi (termasuk informasi pribadi yang sensitif) tentang Para Pemodal dan Penerbit, baik yang didapatkan melalui Para Pemodal dan Penerbit ataupun melalui sumber lain yang sesuai dengan Hukum yang berlaku (Data Pribadi) dan Para Pemodal dan Penerbit menyatakan setuju dengan ketentuan Data Pribadi yang diatur dalam Kebijakan Privasi sebagaimana telah dibaca dan dipahami oleh Para Pemodal dan Penerbit yang tersedia pada Penyelenggara Fulusme Layanan Urun Dana </p>
                            </li>
                            <li>
                                </p>Mengungkapkan informasi dan/atau data terkait Pemodal dan/atau Penerbit dan rekening-rekeningnya, dan/atau kartu kredit yang dimiliki (jika ada dan sebagaimana relevan) kepada Fulusme Layanan Urun Dana , atau informasi lainnya yang dipandang penting oleh Fulusme Layanan Urun Dana kepada:</p>
                            </li>
                            <li>
                                </p>Kantor perwakilan dan cabang dan/atau perusahaan atau perusahaan asosiasi terkait Pemodal dan/atau Penerbit, yang ada pada yurisdiksi manapun</p>
                            </li>
                            </p>b) Pemerintah atau badan pemerintahan atau badan otoritas.
                            </p>c) Setiap calon pengalihan hak Penerbit atau pihak yang telah atau dapat memiliki hubungan kontraktual dengan Penerbit dalam kaitannya dengan kerjasama bisnisnya;
                            </p>d) Biro kredit, termasuk anggota biro kredit tersebut (sebagaimana relevan);
                            </p>e) Setiap pihak ketiga, penyedia jasa, agen, atau partner bisnis (termasuk, tidak terbatas pada, referensi kredit atau agen evaluasi) dimanapun situasinya mungkin terjadi; dan
                            </p>f) Kepada pihak yang membuka informasi yang diperbolehkan oleh Hukum untuk membuka informasi.
                            </p>
                            </li>
                            <li>
                                </p>Masing-masing Pihak berkewajiban untuk menyimpan segala rahasia data atau sistem yang diketahuinya baik secara langsung maupun tidak langsung sehubungan Layanan Urun Dana yang dilaksanakan sesuai dengan Syarat dan Ketentuan ini dan bertanggung jawab atas segala kerugian yang diakibatkan karena pembocoran Informasi Rahasia tersebut, baik oleh masing-masing Pihak maupun karyawannya maupun perwakilannya</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Perjanjian Pengikatan</b></p>
                        <ol type="1">
                            <li>
                                </p>Pemodal wajib untuk membaca secara seksama dan menyetujui Perjanjian Pengikatan sebelum dapat menggunakan layanan Fulusme Layanan Urun Dana </p>
                            </li>
                            <li>
                                </p>Fulusme Layanan Urun Dana berhak dari waktu ke waktu sesuai diskresinya merubah termasuk menambahkan maupun mengurangi isi dan bagian Perjanjian Pengikatan yang mengikat Pemodal dengan Fulusme Layanan Urun Dana sebagai dasar hukum untuk pemanfaatan jasa dan penggunaan Penyelenggara Fulusme Layanan Urun Dana </p>
                            </li>
                            <li>
                                </p>Diwajibkan berdasarkan ketentuan hukum dan/atau peraturan perundang-undangan yang berlaku (Ketentuan Hukum) atau sewajarnya diperlukan menurut diskresi atau pertimbangan Fulusme Layanan Urun Dana dalam mendukung upayanya untuk mematuhi Ketentuan Hukum atau mengadakan penyesuaian secara operasional maupun transaksional terhadap syarat atau ketentuan sebagaimana diatur Ketentuan Hukum tersebut</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Pembaharuan Data</b></p>
                        <ol type="1">
                            <li>
                                </p>Fulusme Layanan Urun Dana dapat sewaktu-waktu melakukan modifikasi data Penerbit dan/atau Pemodal (Modifikasi) yang terdapat dalam database Penyelenggara Fulusme Layanan Urun Dana . Hal ini termasuk, namun tidak terbatas pada, pembaharuan informasi Penerbit dan/atau Pemodal, Data Pribadi, dan mengunggah dokumen tambahan yang berkaitan dengan data Para Pemodal dan Penerbit. Para Pemodal dan Penerbit akan diberikan pemberitahuan dalam kurun waktu tertentu sebagaimana ditentukan Fulusme Layanan Urun Dana (Periode Pemberitahuan) untuk menerima atau menolak Modifikasi. Para Pemodal dan Penerbit dianggap mengetahui Modifikasi yang dilakukan, apabila tidak ada respon yang diberikan kepada Fulusme Layanan Urun Dana selama Periode Pemberitahuan. Para Pemodal dan Penerbit dapat mengajukan Modifikasi atas Data Pribadi Para Pemodal dan Penerbit sesuai dengan ketentuan yang terdapat pada Prosedur Manajemen Data Pribadi yang tersedia di Penyelenggara Fulusme Layanan Urun Dana</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Keadaan Kahar (Force Majeure)</b></p>
                        <ol type="1">
                            <li>
                                </p>Keadaan Kahar atau Force Majeure adalah kejadian-kejadian yang terjadi diluar kemampuan dan kekuasaan Para Pihak sehingga menghalangi Para Pihak untuk melaksanakan Layanan Urun Dana ini, termasuk namun tidak terbatas pada adanya kebakaran, banjir, gempa bumi, likuifaksi, badai, huru-hara, peperangan, epidemi, pertempuran, pemogokan, sabotase, embargo, peledakan yang mengakibatkan kerusakan sistem teknologi informasi yang menghambat pelaksanaan Layanan Urun Dana ini, serta kebijaksanaan pemerintah Republik Indonesia yang secara langsung berpengaruh terhadap pelaksanaan Layanan Urun Dana ini</p>
                            </li>
                            <li>
                                </p>Masing-masing Pihak dibebaskan untuk membayar denda apabila terlambat dalam melaksanakan kewajibannya dalam Layanan Urun Dana ini, karena adanya hal-hal keadaan Memaksa</p>
                            </li>
                            <li>
                                </p>Keadaan Memaksa sebagaimana dimaksud harus diberitahukan oleh Pihak yang mengalami Keadaan Memaksa kepada Pihak lainnya dalam Layanan Urun Dana ini paling lambat 7 (tujuh) Hari Kalender dengan melampirkan pernyataan atau keterangan tertulis dari pemerintah untuk dipertimbangkan oleh Pihak lainnya beserta rencana pemenuhan kewajiban yang tertunda akibat terjadinya Keadaan Memaksa</p>
                            </li>
                            <li>
                                </p>Keadaan Memaksa yang menyebabkan keterlambatan pelaksanaan Layanan Urun Dana ini baik untuk seluruhnya maupun sebagian bukan merupakan alasan untuk pembatalan Layanan Urun Dana ini sampai dengan diatasinya Keadaan Memaksa tersebut</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Pengalihan Layanan Urun Dana</b></p>
                        <ol type="1">
                            <li>
                                </p>Pemodal setuju dan sepakat untuk tidak mengalihkan sebagian atau keseluruhan hak dan kewajiban Penerbit dalam Layanan Urun Dana ini kepada pihak lainnya atau pihak manapun</p>
                            </li>
                            <li>
                                </p>Dalam hal adanya permintaan peralihan atas hak kepemilikan Efek dikarenakan Pemodal meninggal dunia, maka ahli waris mengajukan permohonan perubahan kepemilikan Efek kepada Penyelenggara dengan melengkapi dokumen sebagai sebagai berikut :
                                </p>a.Surat permohonan peralihan kepemilikan Efek dikarenakan Pemodal meninggal dunia.
                                </p>b.Softcopy surat kematian dari instansi berwenang.
                                </p>c.Softcopy surat keterangan ahli waris dari instansi berwenang dan/atau surat penetapan pengadilan tentang ahli waris.
                                </p>d.Softcopy E-KTP Pemodal (almarhum/almarhumah) dan ahli waris.
                                </p>e.Softcopy Kartu Keluarga (KK) Pemodal (almarhum/almarhumah).
                                </p>f.Surat Penunjukan dan/atau Surat Kuasa dari ahli waris (apabila ahli waris lebih dari satu) untuk menunjuk dan/atau menguasakan peralihan kepemilikan Efek kepada salah satu ahli waris.
                                </p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Domisili Hukum Dan Penyelesaian Sengketa</b></p>
                        <ol type="1">
                            <li>
                                </p>Layanan Urun Dana ini dibuat, ditafsirkan dan dilaksanakan berdasarkan hukum negara Republik Indonesia</p>
                            </li>
                            <li>
                                </p>Setiap perselisihan yang timbul sehubungan dengan Layanan Urun Dana ini, akan diupayakan untuk diselesaikan terlebih dahulu oleh Para Pihak dengan melaksanakan musyawarah untuk mufakat</p>
                            </li>
                            <li>
                                </p>Apabila penyelesaian perselisihan secara musyawarah tidak berhasil mencapai mufakat sampai dengan 30 (tiga puluh) Hari Kalender sejak dimulainya musyawarah tersebut, maka Para Pihak sepakat untuk menyelesaikan perselisihan tersebut melalui proses pengadilan</p>
                            </li>
                            <li>
                                </p>Para Pihak sepakat untuk menyelesaikan perselisihan di Pengadilan Jakarta Pusat tanpa mengurangi hak dari salah satu untuk mengajukan gugatan pada domisili pengadilan lainnya (non-exlusive jurisdiction)</p>
                            </li>
                            <li>
                                </p>Tanpa mengesampingkan penyelesaian sengketa atau perselisihan melalui pengadilan negeri, Para Pihak setuju dan sepakat apabila penyelesaian sengketa atau perselisihan di badan arbitrase dan badan alternatif penyelesaian sengketa yang ditunjuk oleh Otoritas Jasa Keuangan maupun regulator berwenang lainnya</p>
                            </li>
                            <li>
                                </p>Hasil putusan pengadilan negeri maupun badan arbitrase dan badan alternatif penyelesaian sengketa yang ditunjuk oleh Otoritas Jasa Keuangan maupun regulator berwenang lainnya bersifat final dan mempunyai kekuatan hukum tetap dan mengikat bagi Para Pihak</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Kelalaian / Wanprestasi</b></p>
                        <ol type="1">
                            <li>
                                </p>Dalam hal terjadi salah satu hal atau peristiwa yang ditetapkan di bawah ini, maka merupakan suatu kejadian kelalaian (wanprestasi) terhadap Layanan Urun Dana ini:
                                </p>a.Kelalaian dalam Layanan Urun Dana Dalam hal salah satu Pihak terbukti sama sekali tidak melaksanakan kewajiban, atau melaksanakan kewajiban tetapi tidak sebagaimana disepakati, atau melaksanakan kewajiban tetapi tidak sesuai dengan waktu yang disepakati, atau melakukan sesuatu yang tidak diperbolehkan dalam terms and conditions.
                                </p>b.Pernyataan Tidak Benar Dalam hal ternyata bahwa sesuatu pernyataan atau jaminan yang diberikan oleh salah satu Pihak kepada Pihak lainnya dalam Layanan Urun Dana ini terbukti tidak benar atau tidak sesuai dengan kenyataannya dan menimbulkan kerugian langsung yang diderita salah satu Pihak.
                                </p>c.Kepailitan, Dalam hal ini salah satu Pihak dalam Layanan Urun Dana ini oleh instansi yang berwenang dinyatakan berada dalam keadaan pailit atau diberikan penundaan membayar hutang-hutang (surseance van betaling).
                                </p>d.Permohonan Kepailitan, Dalam hal ini salah satu Pihak dalam Layanan Urun Dana ini mengajukan permohonan kepada instansi yang berwenang untuk dinyatakan pailit atau untuk diberikan penundaan membayar hutang-hutang (surseance van betaling) atau dalam hal pihak lain mengajukan permohonan kepada instansi yang berwenang agar salah satu Pihak dalam Layanan Urun Dana ini dinyatakan dalam keadaan pailit.
                            </li>
                            <li>
                                </p>Dalam hal suatu kejadian kelalaian terjadi dan berlangsung, maka Pihak yang tidak lalai berhak menyampaikan peringatan sebanyak 3 (tiga) kali dengan tenggang waktu 7 (tujuh) Hari Kalender diantara masing-masing peringatan</p>
                            </li>
                            <li>
                                </p>Setelah menyampaikan 3 (tiga) kali peringatan, Pihak yang tidak lalai berhak mengajukan tuntutan berupa meminta pemenuhan prestasi dilakukan atau meminta prestasi dilakukan disertai ganti kerugian atau meminta ganti kerugian saja atau menuntut pembatalan Layanan Urun Dana disertai ganti kerugian</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Penalti</b></p>
                        <ol type="1">
                            <li>
                                </p>Apabila dalam Layanan Urun Dana ini, Pemodal melanggar ketentuan dalam Layanan Urun Dana ini maka Penyelenggara berhak menon-aktifkan atau membekukan akun Pemodal, bahkan pengakhiran Layanan Urun Dana Pemodal oleh Penyelenggara dalam Layanan Urun Dana ini</p>
                            </li>

                        </ol>
                        <br>

                        <p style="font-size: 20px; color: #008000;" align="center"><b>Mekanisme Dalam Hal Penyelenggara Tidak Dapat Menjalankan Operasionalnya</b></p>
                        <ol type="1">
                            Mekanisme penyelesaian Layanan Urun Dana dalam hal Penyelenggara tidak dapat menjalankan operasional adalah sebagai berikut :</p>
                            a. Penyelenggara melakukan pemberitahuan atau pengumuman secara tertulis di website Penyelenggara dan media sosial lainnya kepada seluruh Pengguna atau khalayak umum bahwa Penyelenggara tidak dapat memberitahukan operasionalnya dengan mencantumkan alasan jelas</p>
                            b. Bahwa pengaturan tata cara Buyback mengacu pada akta anggaran dasar Penerbit dan undang-undang dasar tentang perseroan terbatas yang berlaku di Negara Republik Indonesia</p>
                            c. Buyback seluruh Efek yang dimiliki Pemodal dengan harga pasar atau disepakati secara tertulis oleh Para Pihak di kemudian hari</p>
                            d. Menunjuk Penyelenggara lain yang telah mendapat izin dari Otoritas Jasa Keuangan seperti Penyelenggara, dengan syarat dan ketentuan yang sudah disepakati bersama dengan Pemodal</p>
                            </li>




                        </ol>
                        <br>
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

        <section class="footer-widgets" style="font-size:11px; color:white; background:grey; padding-top:50px; padding-bottom:50px;">

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
													margin-left: 10px;
													color:white;
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
                        Phone:+62 21 2520-934<br>
                        Penerbit:+62 21 2520-934<br>
                        Pemodal:+62 21 2520-934<br>
                        UKM:+62 21 2520-934<br>
                        E-mail: <a href="#" class="foot">info@fulusme.id </a></p>
                        <img src="<?= base_url('assetsprofile/') ?>asset/images/wa.png" width="15" />
                        <a href="https://api.whatsapp.com/send?phone=6282299996862&text=&source=&data=" class="foot">+62 822 9999 6862</a>
                        <br>
                        <img src="<?= base_url('assetsprofile/') ?>asset/images/instagram.png" width="14" />
                        <a href="https://www.instagram.com/fulusme/" class="foot">@fulusme</a>

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