<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="google-site-verification" content="9PE0TRI4F4YkjKEX-uDNFRwPwp0IZJn-uNFFe3t_SrA" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />
	
	<title>.:: FulusMe  ::.</title>
	<link rel="icon" type="image/ico" href="<?= base_url('assetsprofile/')?>pic/ico.ico" />
	

	<!-- <link rel="stylesheet" href="<?= base_url('assetsprofile/')?>asset/css/bootstrap.css"> -->
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url('assetsprofile/')?>asset/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="<?= base_url('assetsprofile/')?>asset/css/neon.css">
	<link rel="stylesheet" href="<?= base_url('assetsprofile/')?>asset/css/project.css">



	<script src="<?= base_url('assetsprofile/')?>asset/js/jquery-1.11.0.min.js"></script>

	<!--[if lt IE 9]><script src="asset/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	
</head>
<body>
	<div class="wrap">


		<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">keluar?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Apakah anda yakin akan keluar? </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
        <a class="btn btn-primary" href="<?= base_url('auth/logout')?>">Ya</a>
      </div>
    </div>
  </div>
</div>


		<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tingkat Keberhasilan 90
</h4>
      </div>
      <div class="modal-body" style="font-size: 13px;padding: 60px;color: black;">
                <div class="text-center mb-3" style="
    margin-bottom: 40px;
">
                    <img src="http://localhost:8080/fulusme/assetsprofile/assets/images/logo-ojk.png">
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
    </div>
  </div>
</div>