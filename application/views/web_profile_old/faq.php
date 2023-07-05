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

                <!-- Breadcrumb -->
                <section class="breadcrumb">

                    <div class="container">

                        <div class="row">

                            <div class="col-sm-12">

                                <h1>FAQ</h1>


                                </li>
                                </ol>

                            </div>

                        </div>

                    </div>

                </section>


                <!-- About Us Text -->
                <section class="content-section">

                    <div class="container">

                        <div class="row">

                            <div class="col-sm-12">
                                <p style="font-size: 30px" align="center"><b>Pertanyaan yang sering ditanyakan (UMUM)</b></p>

                                <p style="font-size: 16px;
color: #65a2f3;"><b>1. Apa itu Fulusme ?</b></p>
                                </p align="justify">Fulusme penyedia layanan Securities Crowd Funding (Layanan Urun Dana ), yaitu tempat bertemunya Pemodal dan Penerbit dalam 1 marketplace (platform)..</p>
                                <p style="font-size: 16px;
color: #65a2f3;"><b>2. Apakah Fulusme memiliki izin dari OJK ?</b></p>
                                </p align="justify">Fulusme sejak tanggal 04 Juli 2022, NOMOR KEP-45 /D.04/2022, telah terdaftar dan berizin serta diawasi oleh Otoritas Jasa Keuangan (OJK).</p>
                                <p style="font-size: 16px;
color: #65a2f3;"><b>3. Berapa Batasan Pembelian Efek di Fulusme ?</b></p>
                                </p align="justify">
                                <li>mengikuti POJK No 57/POJK.04/2020
                                <li>Setiap Pemodal dengan penghasilan sampai dengan Rp500.000.000 (lima ratus juta rupiah) per tahun, dapat membeli Efek melalui Layanan Urun Dana paling banyak sebesar 5% (lima persen) dari penghasilan per tahun; dan
                                <li>Setiap Pemodal dengan penghasilan lebih dari Rp500.000.000 (lima ratus juta rupiah) per tahun, dapat membeli Efek melalui Layanan Urun Dana paling banyak sebesar 10% (sepuluh persen) dari penghasilan per tahun </p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>4. Apa itu Dividen?</b></p>
                                    </p align="justify">Dividen adalah nilai tambah dari angka modal pokok yang ditanamkan pihak Pemodal kepada Penerbit . Nilai ini bisa berarti keuntungan atau bagi hasil untuk Pemodal di periode waktu tertentu.</p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>5. Bagaimana jika pemodal ingin membatalkan pembelian Efek ?</b></p>
                                    </p align="justify">Pemodal dapat membatalkan rencana pembelian Efek melalui Layanan Urun Dana paling lambat dalam waktu 48 (empat puluh delapan) jam setelah melakukan pembelian Efek. Penyelenggara wajib mengembalikan Dana kepada Pemodal selambatnya 2 (dua) Hari Kerja setelah pembatalan pemesanan. Pengembalian tersebut akan masuk ke dalam menu deposit didalam aplikasi Penyelenggara yang sewaktu-waktu dapat ditarik oleh Pemodal.</p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>6. Apakah Fulusme merupakan bank atau perusahaan finansial lainnya?</b></p>
                                    </p align="justify">Fulusme bukanlah bank. Fulusme adalah Penyelenggara yang hanya menyalurkan pembiayaan yang didanai oleh Pemodal untuk proyek yang spesifik saja dan tidak ada proses penyimpanan uang seperti bank. Fulusme SCF bisa dijadikan alternatif bisnis yang menguntungkan seperti layaknya Pendanaan di pasar modal, karena selain aman, juga memiliki tingkat bagi hasil (dividen) yang menarik.</p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>7. Jika bukan bank, apakah aman mendanai di Fulusme ?</b></p>
                                    </p align="justify">Meskipun Fulusme bukan bank, tetapi memiliki sistem yang ketat dalam melakukan verifikasi proyek sebelum di danai. Fulusme juga memilki tim yang melakukan analisa resiko berdasarkan hasil kompilasi dan verifikasi data untuk memastikan bahwa proyek yang akan didanai adalah valid dan menguntungkan bagi Pemodal. </p>

                                    <p style="font-size: 16px;
color: #65a2f3;"><b>8. Mengapa harus mendanai dan mengajukan pembiayaan permodalan di Fulusme ?</b></p>
                                    </p align="justify">Dibandingkan lembaga keuangan konvensional, proses pengajuan pembiayaan di Fulusme lebih fleksibel, mudah dan akan dibantu oleh tim kami yang berpengalaman dalam membantu penyiapan dokumen apabila diperlukan. Kecepatan respon terhadap kebutuhan calon Penerbit dan syarat yang mudah, juga merupakan kunci utama. Selain hal tersebut, yang paling penting juga adalah keamanan Pendanaan bagi Pemodal dan imbal hasil (dividen) yang menarik.</p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>9. Apakah ada denda jika terjadi keterlambatan pembayaran?</b></p>
                                    </p align="justify">Tidak ada denda atas keterlambatan pembayaran.</p>

                                    <p style="font-size: 16px;
color: #65a2f3;"><b>10. Apakah mungkin terjadi gagal bayar (default) ?</b></p>
                                    </p align="justify">Segala kemungkinan bisa saja terjadi pada setiap alternatif model Pendanaan . Sedari awal, Fulusme berusaha memitigasi segala resiko yang mungkin timbul. Fulusme SCF sedapat mungkin juga melakukan screening yang ketat sebelum memberikan permodalan. </p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>11. Apakah Fulusme dapat membantu semua kebutuhan permodalan??</b></p>
                                    </p align="justify">Ya, tetapi untuk saat ini hanya membiayai kebutuhan permodalan untuk bisnis (B2B) dan tidak pembiayaan konsumtif (perseorangan) serta melalui proses assesmen tim terlebih dahulu. </p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>12. Berapa besar pembiayaan yang bisa di ajukan?</b></p>
                                    </p align="justify">Peminjaman bisa dimulai dari Rp 100 juta hingga maksimal Rp 10 milyar </p>

                                    <br>
                                    <p align="center" style="font-size: 30px"><b>Pertanyaan yang sering ditanyakan (PEMODAL)</b></p>

                                    <p style="font-size: 16px;
color: #65a2f3;"><b>1. Siapa saja yang bisa menjadi Pemodal di Layanan Urun Dana?</b></p>
                                    </p>Berikut ini adalah klasifikasi jenis Pemodal sebagaimana di prasyaratkan oleh Pasal 56 ayat (4) POJK No.57/POJK.04/2020 :
                                    a). Badan hukum
                                    b). Pihak yang mempunyai pengalaman berinvestasi di pasar modal yang dibuktikan dengan kepemilikan rekening Efek paling sedikit 2 (dua) tahun sebelum penawaran Efek
                                    .</p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>2. Apakah di perlukan suatu konfirmasi untuk memastikan bahwa saya telah memenuhi persyaratan sebagai Pemodal yang dapat berinvestasi melalui Layanan Urun Dana? </b></p>
                                    </p>Pertama kali harus mendaftar di bagian registrasi Pendanaan . Isi data-data yang diminta, kemudian klik “daftar”.
                                <li>ya, anda harus melakukan centang di box pernyataan deklarasi bahwa anda telah memenuhi kriteria :
                                    1. Setiap Pemodal dengan penghasilan sampai dengan Rp500.000.000,00 (lima ratus juta rupiah) per tahun, dapat membeli Efek melalui Layanan Urun Dana paling banyak sebesar 10% (sepuluh persen) dari penghasilan per tahun; dan
                                    2. Setiap Pemodal dengan penghasilan lebih dari Rp500.000.000,00 (lima ratus juta rupiah) per tahun, dapat membeli Efek melalui Layanan Urun Dana paling banyak sebesar 10% (sepuluh persen) dari penghasilan per tahun.
                                    Sekaligus melakukan upload foto/ hasil scan slip gaji terbaru (opsional/pilihan)
                                    </P>
                                <li>Selanjutnya periksa email anda dan klik link verifikasi yang dikirimkan Fulusme , untuk memastikan bahwa email itu adalah benar milik anda</P>
                                <li>Berikutnya anda akan memiliki akun pribadi di Fulusme . Di akun itu anda dapat melihat semua profile proyek yang siap untuk didanai</P>

                                    <p style="font-size: 16px;
color: #65a2f3;"><b>3. Apakah bisa mendanai beberapa proyek dalam satu waktu?</b></p>
                                    </p>Ya, siapapun bisa mendanai beberapa proyek dalam waktu yang bersamaan.</p>

                                    <p style="font-size: 16px;
color: #65a2f3;"><b>4. Apakah sebagai Penerbit efek yang bersifat ekuitas di Fulusme dapat juga mengajukan ekuitasnya ke Penyelenggara Layanan Urun Dana yang lain?</b></p>
                                    </p>Tidak bisa, Penerbit Efek bersifat ekuitas dilarang menggunakan jasa Layanan Urun Dana melalui lebih dari 1 (satu) Penyelenggara.
                                    </p>

                                    <p style="font-size: 16px;
color: #65a2f3;"><b>5. Bagaimana nilai perhitungan Dividen untuk Pemodal?</b></p>
                                    </p>Nilai persentase bagi hasil dapat dilihat langsung di setiap marketplace yang ditayangkan. Tetapi nilai tersebut sangat bergantung dari hasil akhir pengelolaan proyek yang dihitung dari pendapatan bersih perusahaan setelah dipotong biaya-biaya operasional (net profit). </p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>6. Apakah ada jangka waktu dan batas nilai maksimum penghimpunan dana bagi Penerbit?
                                    </p>Jangka waktu dan batas penghimpunan dana sebagaimana Pasal 33 POJK No. 57/POJK.04/2020 :</b></p>
                                    1). Batas penghimpunan dana melalui Layanan Urun Dana oleh setiap Penerbit dalam jangka waktu 12 (dua belas) bulan paling banyak Rp10.000.000.000,00 (sepuluh miliar rupiah).</b></p>
                                    2). Penghimpunan dana sebagaimana dimaksud pada ayat</b></p>
                                    (1) dapat dilakukan dalam 1 (satu) kali penawaran atau lebih.</b></p>
                                    </p>Model Pendanaan di Fulusme menggunakan istilah Lot, yang nilainya bisa dilihat di halaman marketplace. 1 Lot berisi beberapa lembar Efek, tergantung dari jumlah Efek yang di terbitkan oleh Penerbit. Jumlah Lot bisa dilihat di tiap halaman proyek di marketplace.</p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>7. Berapa nilai minimal dan maksimal yang ditetapkan
                                            untuk Pendanaan di Fulusme ?</b></p>
                                    </p>Untuk saat ini, tidak ada pungutan atau biaya apapun ke pihak Pemodal</p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>8. Apakah setiap Pemodal bisa menggunakan rekening pribadinya untuk berinvestasi di Layanan Urun Dana Fulusme?</b></p>
                                    </p>Tidak bisa, karena Pemodal yang akan berinvestasi melalui Layanan Urun Dana harus telah memiliki rekening Efek yang khusus untuk menyimpan Efek dan/atau dana melalui Layanan Urun Dana</b></p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>9. Berapa lama masa penawaran penghimpunan dana di Layanan Urun Dana Fulusme?</b></p>
                                    </p>Paling lama 45 hari</p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>10. Apakah ada risiko mendanai di Fulusme ?</b></p>
                                    </p>Skenario terburuk tetap mungkin terjadi dan perlu dipertimbangkan. Fulusme menyarankan calon Pemodal untuk berkonsultasi dengan penasihat keuangan sebelum mengambil keputusan. </p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>11. Apakah memungkinkan jika Pemodal sudah membeli efek melalui Layanan Urun Dana dapat membatalkan pembeliannya?</b></p>
                                    </p>Ya, bisa saja. Berikut adalah prosedur pembatalan rencana pembelian efek sebagaimana Pasal 58 POJK 57/POJK.04/2020 :
                                    • Pemodal dapat membatalkan rencana pembelian Efek melalui Layanan Urun Dana paling lambat dalam waktu 48 (empat puluh delapan) jam setelah melakukan pembelian Efek
                                    • Dalam hal Pemodal membatalkan rencana pembelian Efek sebagaimana dimaksud pada ayat (1), Penyelenggara wajib mengembalikan dana kepada Pemodal paling lambat 2 (dua) hari kerja setelah pembatalan pemesanan Pemodal
                                    </p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>12. Bagaimana antisipasi untuk menekan terjadinya kerugian Pemodal akibat Penerbit yang mengalami kegagalan pembayaran?</b></p>
                                    </p>Untuk meminimalisasi risiko kegagalan, Fulusme akan melakukan analisis, seleksi, dan persetujuan berdasarkan sistem credit-scoring terhadap setiap pembiayaan yang diajukan. </p>
                                    <br>
                                    <p align="center" style="font-size: 30px"><b>Pertanyaan yang sering ditanyakan (PENERBIT )</b></p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>1. Apakah yang dimaksud dengan Penerbit ?</b></p>
                                    </p>Yang dimaksud dengan Penerbit adalah badan usaha yang memilki proyek atau usaha yang layak untuk dikerjakan dan memiliki nilai bisnis tetapi terkendala dengan permodalan, sehingga membutuhkan dana untuk dikelola sehingga menghasilkan keuntungan secara bisnis </p>
                                    </p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>2. Siapa sajakah yang berhak sebagai Penerbit ?</b></p>
                                    </p>Semua perusahaan yang memiliki badan hukum di wilayah negara Republik Indonesia dan dibuktikan dengan dokumen lengkap perusahaan yang sah.</p>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>3. Bagaimanakah proses untuk mendapatkan pembiayaan?</b></p>
                                    </ul>
                                <li>Pertama kali harus mendaftar di bagian registrasi Penerbit . Isi data-data yang diminta, kemudian klik “daftar”.</p>
                                <li>Selanjutnya periksa email anda dan klik link verifikasi yang dikirimkan Fulusme , untuk memastikan bahwa email itu adalah benar milik anda</p>
                                <li>Berikutnya anda akan memiliki akun pribadi di Fulusme </p>
                                <li>Setelah itu anda dapat mengajukan pembiayaan permodalan dengan mengisi aplikasi dan syarat – syarat yang dibutuhkan</p>

                                    </ul>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>4. Apa saja syarat untuk menjadi Penerbit ?</b></p>
                                    </ul>
                                <li>Mengisi form Pengajuan Pembiayaan.
                                <li>Melengkapi dokumen tanda pengenal yang dibutuhkan, seperti KTP/SIM.</p>
                                <li>Melengkapi dokumen perusahaan seperti SIUP dll.</p>
                                    </ul>
                                    <p style="font-size: 16px;
color: #65a2f3;"><b>5. Berapa lama proses dari mulai submit dokumen hingga pencairan dana?</b></p>
                                    </ul>
                                <li>Sejak dari form aplikasi di submit, maka tim kami akan segera mengunjungi perusahaan anda untuk melakukan pencocokan data dan verifikasi.</p>
                                <li>Jika sudah lolos verifikasi, maka tim internal kami akan melakukan kredit analis untuk menentukan scoring proyek anda.</p>
                                <li>Proses dari mulai aplikasi di submit hingga tayang di marketplace membutuhkan waktu sekitar 4 hari. Jika proyek anda telah lolos verifikasi dan analisis kredit, maka Fulusme akan menayangkan proyek anda di marketplace selama kurang lebih 45 hari. Jika sudah mencukupi, maka di hari berikutnya kami akan mentransfernya ke rekening Penerbit . Jadi proses yang dibutuhkan adalah sekitar 49 hari.</p>
                                <li>Apabila sebelum masa tayang 45 hari selesai tetapi dana sudah terkumpul, maka pihak Fulusme akan langsung mentransfer ke pihak Penerbit paling lambat 2 hari setelah dana terkumpul.</p>
                                    </ul>

                                    <p style="font-size: 16px;
color: #65a2f3;"><b>6. Apakah ada fee/biaya untuk mendapatkan pembiayaan bagi Penerbit ?</b></p>
                                    </ul>
                                    </p>Ada. Sejak awal proses pengajuan pembiayaan, semua biaya yang akan dikenakan ke pihak Penerbit adalah biaya yang sudah tersebut di awal dan tidak ada biaya tiba-tiba atau yang disembunyikan. Biaya – biaya tersebut adalah:</p>
                                <li>Fee untuk Penyelenggara Fulusme Sekurtas sebagai penyelenggara layanan pembiayaan urun Dana, sebesar 10% (sepuluh persen) dari total nilai pembiayaan yang disetujui, sebelum di transfer ke Penerbit .</p>


                                    <p style="font-size: 16px;
color: #65a2f3;"><b>7. Apakah bisa mengajukan pembiayaan lagi di saat pembiayaan proyek sedang berjalan?</b></p>
                                    </P>Ya, anda tetap bisa mengajukan pembiayaan proyek lain, meskipun saat ini proyek anda sedang dalam proses pembiayaan atau pengelolaan, tetapi tetap dengan prosedur dan verifikasi sebagaimana layaknya pembiayaan baru.</p>
                                    </ul>

                                    <p style="font-size: 16px;
color: #65a2f3;"><b>8. Apakah seluruh jenis bisnis dapat mengajukan pembiayaan di Fulusme ?</b></p>
                                    </p>ya. setelah dilakukan assesment oleh Team Fulusme dan hasilnya tidak dapat diganggu gugat .</p>
                                    </ul>

                                    <p style="font-size: 16px;
color: #65a2f3;"><b>9. Siapa saja instansi yang proyeknya berpotensi memiliki peluang untuk bisa mendapatkan pembiayaan di Fulusme ?</b></p>
                                    </p>Beberapa contoh proyek yang berasal dari instansi yang memiliki peluang besar untuk bisa didanai oleh Fulusme adalah Perusahaan Multinasional, perusahaan yang terdaftar di bursa Efek, Instansi Pemerintah, Perusahaan swasta dengan riwayat pembayaran yang terkenal baik, dan lain lain. </p>
                                    </ul>

                                    <p style="font-size: 16px;
color: #65a2f3;"><b>10. Apakah saya harus memberikan jaminan agar bisa memperoleh pembiayaan di Fulusme ?</b></p>
                                    </p>Ya. Selain menggunakan jaminan aset (collateral), kami akan meminta calon Penerbit untuk memberikan giro mundur dan jaminan pribadi (personal guarantee) sebagai jaminan tambahan. Untuk lebih mengetahui lebih dalam tentang Fulusme , silakan mengirimkan pesan melalui Contact Us .</p>






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