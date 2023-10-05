<?php
// var_dump($project_retail);
function rupiah($angka)
{
  $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
  return $hasil_rupiah;
};

function ribuan($angka)
{
  $hasil_rupiah = number_format($angka, 0, ',', '.');
  return $hasil_rupiah;
}
// echo time();
// var_dump(count($project));
// exit;
?>

<style>
  @media only screen and (max-width: 600px) {
    .border-right {
      border-style: solid;
      border-color: black;
      padding-top: 10px;
      padding-bottom: 10px;
    }
  }
</style>

<div class="slide-one-item home-slider owl-carousel">
  <div class="site-blocks-cover inner-page overlay" style="background-image: url(<?php echo base_url(); ?>assetsprofile/assetsbaru/images/bg2.jpg);" data-aos="fade" data-stellar-background-ratio="0.3">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-8 text-center" data-aos="fade">
          <h1 class="font-secondary font-weight-bold text-uppercase">Fulusme</h1>
          <h2 style="color:#ff8f3d;" class="font-secondary font-weight-bold">Layanan Urun Dana</h2>
          <span class=" d-block text-white" style="font-size:18px;">Hai, Selamat datang di jaman now. Dimana kecepatan dan Instan sudah menjadi keseharian kita. Dimana Investasi dan Usaha tidak dibatasi lagi oleh ruang dan waktu. Kini saatnya bergabung bersama FULUSME</span><br />
          <h5 style="color:#fff;" class="font-secondary font-weight-bold">
            Fulusme Terdaftar dan Diawasi Oleh Otoritas Jasa Keuangan </h5>
        </div>
      </div>
    </div>
  </div>

</div>

<div class="site-section">
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-12 text-center">
        <span class="caption d-block mb-2 font-secondary font-weight-bold">Berizin dan diawasi oleh Otoritas Jasa Keuangan ( OJK )</span>
      </div>
    </div>
    <div class="row border-responsive">
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0 border-right">
        <div class="text-center">
          <span class="flaticon-customer-service display-4 d-block mb-3 text-primary"></span>
          <h3 class="text-uppercase h4 mb-3">24/7 Support</h3>
          <p>Kami, selalu ada dan siap mendampingi anda 24 jam sehari, 7 kali seminggu dan 365 hari non-stop melalui web kami</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0 border-right">
        <div class="text-center">
          <span class="flaticon-group display-4 d-block mb-3 text-primary"></span>
          <h3 class="text-uppercase h4 mb-3">Pasar Sekunder</h3>
          <p>Layanan Jual Beli Efek antar Pemodal</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
        <div class="text-center">
          <span class="flaticon-agreement display-4 d-block mb-3 text-primary"></span>
          <h3 class="text-uppercase h4 mb-3">Layanan Urun Dana</h3>
          <p>Fulusme adalah Layanan Urun Dana berbasis teknologi (securities crowdfunding) yang membantu permodalan bagi UKM</p>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="site-half" style="background-color:#0b8500;">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h4 style='color:#fff; margin-left: auto;margin-right: auto;margin-top: 2%;text-align: center;font-weight: 400'> Fulusme adalah Layanan Urun Dana berbasis teknologi <span style='color:#ff8f3d; '> (securities crowdfunding)</span>
          <br />yang membantu <span style='color:#ff8f3d; '> permodalan bagi UKM</span>
        </h4>
      </div>
      <br /><br />
      <div class="col-lg-2 text-center" style="padding: 20px;">
        <div style="background:#ff8f3d; width:20px; border-radius:30px; color:white; margin:auto; text-align:center;">1</div>
        <img style="
										border: white 3px solid;
                                        border-radius: 38px 0;
                                        width: 150px;
										margin-left: auto;
										margin-right:auto;
                                        height: 150px;
                                        object-fit: cover;
                                        object-position: center;
                                        image-orientation: inherit;
                                        margin-top: 20px;" src="<?= base_url('assetsprofile/') ?>asset/images/gambar1.jpeg">

        <p style="margin-top: 10px;
                                        color: #fff;
                                        font-weight: 400;
                                        margin-bottom: 1rem;
                                        text-align: center;">
          Calon penerbit memiliki Usaha namun tidak memiliki modal.</p>

      </div>
      <div class="col-lg-2 text-center" style="padding: 20px;">
        <div style="background:#ff8f3d; width:20px; border-radius:30px; color:white; margin:auto; text-align:center;">2</div>
        <img style="
										border: white 3px solid;
                                        border-radius: 38px 0;
                                        width: 150px;
                                        height: 150px;
                                        object-fit: cover;
                                        object-position: center;
                                        image-orientation: inherit;
                                        margin-top: 20px;" src="<?= base_url('assetsprofile/') ?>asset/images/gambar2.jpeg">

        <p style="margin-top: 10px;
                                        color: #fff;
                                        font-weight: 400;
                                        margin-bottom: 1rem;
                                        text-align: center;">
          Calon penerbit melakukan pengajuan pendanaan melalui platform.
        </p>
      </div>
      <div class="col-lg-2 text-center" style="padding: 20px;">
        <div style="background:#ff8f3d; width:20px; border-radius:30px; color:white; margin:auto; text-align:center;">3</div>
        <img style="
										border: white 3px solid;
                                        border-radius: 38px 0;
                                        width: 150px;
                                        height: 150px;
                                        object-fit: cover;
                                        object-position: center;
                                        image-orientation: inherit;
                                        margin-top: 20px;" src="<?= base_url('assetsprofile/') ?>asset/images/gambar3.jpeg">

        <p style="margin-top: 10px;
                                        color: #fff;
                                        font-weight: 400;
                                        margin-bottom: 1rem;
                                        text-align: center;">
          Fulusme melakukan analisa data.
        </p>
      </div>
      <div class="col-lg-2 text-center" style="padding: 20px;">
        <div style="background:#ff8f3d; width:20px; border-radius:30px; color:white; margin:auto; text-align:center;">4</div>
        <img style="
										border: white 3px solid;
                                        border-radius: 38px 0;
                                        width: 150px;
                                        height: 150px;
                                        object-fit: cover;
                                        object-position: center;
                                        image-orientation: inherit;
                                        margin-top: 20px;" src="<?= base_url('assetsprofile/') ?>asset/images/gambar4.jpeg">

        <p style="margin-top: 10px;
                                        color: #fff;
                                        font-weight: 400;
                                        margin-bottom: 1rem;
                                        text-align: center;">
          Pemodal memilih jenis usaha.
        </p>
      </div>
      <div class="col-lg-2 text-center" style="padding: 20px;">
        <div style="background:#ff8f3d; width:20px; border-radius:30px; color:white; margin:auto; text-align:center;">5</div>
        <img style="
										border: white 3px solid;
                                        border-radius: 38px 0;
                                        width: 150px;
                                        height: 150px;
                                        object-fit: cover;
                                        object-position: center;
                                        image-orientation: inherit;
                                        margin-top: 20px;" src="<?= base_url('assetsprofile/') ?>asset/images/gambar5.jpeg">

        <p style="margin-top: 10px;
                                        color: #fff;
                                        font-weight: 400;
                                        margin-bottom: 1rem;
                                        text-align: center;">
          Penerbit mendapatkan pemodalan.

        </p>
      </div>
      <div class="col-lg-2 text-center" style="padding: 20px;">
        <div style="background:#ff8f3d; width:20px; border-radius:30px; color:white; margin:auto; text-align:center;">6</div>
        <img style="
										border: white 3px solid;
                                        border-radius: 38px 0;
                                        width: 150px;
                                        height: 150px;
                                        object-fit: cover;
                                        object-position: center;
                                        image-orientation: inherit;
                                        margin-top: 20px;" src="<?= base_url('assetsprofile/') ?>asset/images/gambar6.jpeg">

        <p style="margin-top: 10px;
                                        color: #fff;
                                        font-weight: 400;
                                        margin-bottom: 1rem;
                                        text-align: center;">
          Pemodal mendapatkan dividen dan keuntungan.
        </p>
      </div>
    </div>

  </div>
</div>

<!-- project-->
<div class="site-section" style="padding-top: 50px;">
  <div class="container">
    <div class="row border-responsive">
      <?php foreach ($project as $obj) { ?>

        <?php
        $idp = $obj['id'];
        $query_pendanaan = $this->db->select('COALESCE(sum(pendanaan.nominal), 0) as nominal, COALESCE(sum(pendanaan.nominal)/project.modal_project, 0) as jumlah_pendanaan,')
          ->from('pendanaan')->join('project', 'project.id = pendanaan.project_id')
          ->where('project.version', 1)
          ->where('project.id', $idp)
          ->group_start()
          ->where('pendanaan.status', 0)->or_where('pendanaan.status', 1)
          ->group_end()
          ->get()->row();
        ?>

        <?php if ($obj["totalhari"] - $obj["sisawaktu"] > 0 || $query_pendanaan->jumlah_pendanaan >= 1) : ?>

          <div class="col-md-6 col-lg-3 mt-5 mb-4 mb-lg-0 border-right" style="font-size:13px;">
            <img <?php if ($obj["image"]) { ?> src="<?php echo base_url('assets/') . "img/profile/" . $obj["image"] ?> " style="border-bottom:4px #ff6f05 solid;border-top:4px #ff6f05 solid;margin-bottom:15px;width: 90%;height: 250px;border-radius:0 0 10% 10%; margin-left: auto;
  margin-right: auto;" <?php } else { ?> src="<?php echo base_url('assets/') ?>img/noimage.png" <?php } ?> style="border-bottom:4px #ff6f05 solid;margin-bottom:15px;width:70%;border-radius:0 0 20% 20%; margin-left: auto;
  margin-right: auto;">
            <a href="#" class="kt-widget__title" style=" color: #040538; font-size: 15px;display: inline-block;
    padding: 0px;height: 50px;margin-bottom: 24% !important;margin-top: 16px;"><?php echo $obj["nama_project"] ?></a>



            <?php if ($query_pendanaan->jumlah_pendanaan >= 1) { ?>
              <a href="#" class="kt-widget__title">
                <img class="card_holder_img" style="
                        max-width: 100%;
                        height: 86px;
                        object-fit: cover;
                        right: 22px;
                        position: absolute;
                        display: inline-block;
                        border-radius: 8px;
                        " src="https://www.fulusme.id/assets/img/lunas.jpeg">
              </a>
            <?php } ?>
            <p style=" color: black;"> Efek Bersifat Utang </p>
            <p>ID Proyek : <span style=" color: #fd7e14;"><?php echo $obj["id"] ?></span></p>
            <?php if ($obj["code_saham_alias"]) {

              $inikodealias = $obj["code_saham_alias"];
            } else {
              $inikodealias = "-";
            } ?>
            <p>Kode Efek : <span style=" color: #040538;"><?php echo $inikodealias ?></span></p>
            <div class="kt-widget__text">
              Efek Terjual
            </div>
            <div class="progress" style="height: 5px;width: 100%;">
              <?php if ($query_pendanaan->jumlah_pendanaan > 1) : ?>
                ?>
                <div class="progress-bar kt-bg-success" role="progressbar" style="width: <?php echo 100 ?>%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget__stats">
              <?php echo  100 ?>%
            </div>
          <?php else : ?>
            <div class="progress-bar kt-bg-success" role="progressbar" style="width: <?php echo $query_pendanaan->jumlah_pendanaan * 100 ?>%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <div class="kt-widget__stats">
            <span style=" color: #040538;"><?php echo $query_pendanaan->jumlah_pendanaan * 100 ?>%</span>
          </div>
        <?php endif; ?>
        <div class="kt-widget__text">
          Sisa Waktu
        </div>
        <?php if ($query_pendanaan->jumlah_pendanaan >= 1) { ?>
          <div class="progress" style="height: 5px;width: 100%;">
            <div class="progress-bar kt-bg-success" role="progressbar" style="width:100%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <div class="kt-widget__stats">
            <span style=" color: #040538;"> - Hari</span>
          </div>
        <?php } else { ?>
          <div class="progress" style="height: 5px;width: 100%;">
            <div class="progress-bar kt-bg-success" role="progressbar" style="width: <?php echo $obj["persensisa"] * 100 ?>%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <div class="kt-widget__stats">
            <span style=" color: #040538;"><?php echo $obj["totalhari"] - $obj["sisawaktu"] ?> Hari</span>
          </div>
        <?php } ?>
        <div class="kt-widget__item">
          <span class="kt-widget__date">
            Rating Proyek :
          </span>
          <div class="kt-widget__label-success">
            <span class="btn btn-label-brand btn-sm btn-bold btn-upper btn-info" style="margin-bottom:10px;">
              <?php if ($query_pendanaan->jumlah_pendanaan != 1) : ?>
                <? if ($obj["prospektus"]) { ?>
                  <a href="<?= base_url('assets/file_user/prospektus/') ?><?= $obj["prospektus"] ?>" target="_blank"> <span style=" color: #040538;"> Proposal Bisnis </span></a>
                <? } else { ?>
                  <a href="#" onClick="alert('Project ini tidak memiliki prospektus')"> Proposal Bisnis </a>
                <? } ?><br />
            </span>
          <?php endif; ?>

          <?php if ($query_pendanaan->jumlah_pendanaan == 1) { ?>
            <!-- <button type="button" style="display: inline;background-color:#fd7e14;border-radius: 15px;" class="btn btn-brand btn-sm btn-upper" onClick="alert('Project ini sudah terdanai, tunggu project lainnya')">Beli</button> -->
          <?php } else { ?>
            <a href="<?= base_url('auth') ?>">
              <button type="button" style="display: inline;background-color:#fd7e14;color:#fff;border-radius: 15px;" class="btn btn-block btn-sm ">Beli</button></a>
          <?php } ?>
          </div>
        </div>

        <!-- bottom -->
        <div class="accordion" id="accordionExample" style="margin-top:13%;">
          <div class="card">
            <div class="card-header" id="headingOne" style="padding:0px;background-color:#040538;border-radius: 15px;text-align:center;">
              <h2 class="mb-0">
                <a class="btn" type="button" data-toggle="collapse" data-target="#collapseOne<?php echo $obj["id"] ?>" aria-expanded="true" aria-controls="collapseOne" style="color:#fff;">
                  Detail
                </a>
              </h2>
            </div>
            <div id="collapseOne<?php echo $obj["id"] ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="card-body" style="border:none;">
                <div class="kt-widget__bottom">
                  <div class="kt-widget__item">
                    <div class="kt-widget__details">
                      <span class="kt-widget__title">Total Pemodalan</span><br />
                      <span class="kt-widget__value"><?php echo rupiah($obj["modal_project"]) ?>
                    </div>
                  </div>

                  <div class="kt-widget__item" style="margin: 0;padding: 0;">
                    <div class="kt-widget__details">
                      <span class="kt-widget__title">Jumlah Efek yang diterbitkan</span><br />
                      <span class="kt-widget__value" style="height: 50px;"><?php echo ribuan($obj["jumlah_lembar_shm"]) ?> Lembar Efek</span>
                    </div>
                  </div>

                  <div class="kt-widget__item" style="margin: 0;padding: 0;">
                    <div class="kt-widget__details">
                      <span class="kt-widget__title">Harga Per Lembar Efek</span><br />
                      <span class="kt-widget__value"><?php echo rupiah($obj["harga_perlembar_shm"]) ?></span>(Minimum Pembelian 1 Lot)
                    </div>
                  </div>

                  <div class="kt-widget__item" style="margin: 0;padding: 0;">
                    <div class="kt-widget__details">
                      <span class="kt-widget__title">Harga Per 1 Lot Efek</span><br />
                      <span class="kt-widget__value"><?php echo rupiah(100 * $obj["harga_perlembar_shm"]) ?></span>(Per 1 Lot 100 Lembar Efek)
                    </div>
                  </div>

                  <div class="kt-widget__item" style="margin: 0;padding: 0;">
                    <div class="kt-widget__details">
                      <span class="kt-widget__title">Jumlah Lot</span><br />
                      <span class="kt-widget__value"><?php echo (number_format($obj["jumlah_lot"])) ?></span>
                    </div>
                  </div>

                  <div class="kt-widget__item" style="margin: 0;padding: 0;">
                    <div class="kt-widget__details">
                      <span class="kt-widget__title">Periode Dividen</span><br />
                      <?php if ($obj['type'] == 2) : ?>
                        <span class="kt-widget__value">3 bulan</span>
                      <?php else : ?>
                        <span class="kt-widget__value">6 bulan</span>
                      <?php endif; ?>
                    </div>
                  </div>

                </div>
                <!-- end bottom detail -->
              </div>
            </div>
          </div>
        </div>
    </div>
  <?php endif; ?>
<?php } ?>
  </div>
  <div style="text-align:center;">
    <a href="<?= site_url('welcome/list_project') ?>" class="btn bg-info btn-sm" style="color: white; margin-top: 50px;">Lihat Semua Project</a>
  </div>
</div>
<!-- end project-->


</div>

<div class="site-section" style="background-image: url('<?php echo base_url(); ?>assetsprofile/assetsbaru/images/topography.png'); background-attachment: fixed; padding-top:5px;">
  <div class="container">
    <div class="row no-gutters align-items-stretch">
      <div class="col-md-12 ml-md-auto py-5">
        <h3 class="site-section-heading text-uppercase font-secondary mb-5 text-center">Perhatian</h3>
        <div style="height:420px; overflow-y: scroll;background-color:white;padding:18px;border-radius: 30px 30px 30px 30px;border:thin solid #dee2e6;">
          <ol style="text-align: justify;">
            <li>Anda perlu mempertimbangkan dengan cermat, teliti dan seksama setiap investasi bisnis yang akan Anda lakukan di Fulusme, berdasarkan pengetahuan, keilmuan serta pengalaman yang Anda miliki dalam hal keuangan dan bisnis. Dibutuhkan kajian/penelaahan laporan keuangan, target tujuan investasi, kemampuan analisis, serta pertimbangan risiko yang akan Anda ambil.</p>
              Anda menyadari bahwa setiap bisnis pasti memiliki risikonya masing-masing. Untuk itu, dengan berinvestasi melalui Fulusme, Anda sudah mengerti akan segala resiko yang dapat terjadi di kemudian hari, seperti penurunan performa bisnis, hingga kebangkrutan dari bisnis yang anda investasikan tersebut.</p>
              <b>Fulusme TIDAK BERTANGGUNG JAWAB terhadap risiko kerugian dan gugatan hukum serta segala bentuk risiko lain yang timbul dikemudian hari atas hasil investasi bisnis yang anda tentukan sendiri saat ini. Beberapa risiko yang dapat terjadi saat Anda berinvestasi yaitu :</b></p>

              <b>Risiko Usaha</b></p>
              Risiko adalah suatu hal yang tidak dapat dihindari dalam suatu usaha/bisnis. Beberapa risiko bisa terjadi karena berubahnya permintaan pasar dan proyeksi keuangan bisnis bisa saja tidak sesuai dengan proposal bisnis ketika dijalankan</p>

              <b>Kerugian Investasi </b></p>
              Setiap investasi memiliki tingkat risiko yang bervariasi seperti tidak terkumpulnya dana investasi yang dibutuhkan selama proses pengumpulan dana atau proyek yang dijalankan tidak menghasilkan keuntungan sesuai yang diharapkan.</p>

              <b>Kekurangan Likuiditas</b></p>
              Investasi Anda di suatu Penerbit, mungkin saja tidak likuid dan tidak mudah dijual kembali karena Efek yang ditawarkan tidak terdaftar di bursa umum secara publik. Ini berarti bahwa Anda mungkin tidak dapat dengan mudah menjual Efek Anda di bisnis tertentu atau Anda mungkin tidak dapat menemukan pembeli sebelum berakhirnya jangka waktu investasi di pasar sekunder.</p>

              <b>Kelangkaan Pembagian Dividen</b></p>
              Setiap Pemodal yang ikut berinvestasi berhak untuk mendapatkan dividen sesuai dengan jumlah kepemilikan Efek. Dividen (imbal hasil) ini akan diberikan oleh Penerbit dengan jadwal pembagian yang telah disepakati di awal dan dapat dicek di detail bisnis. Kelangkaan pembagian dividen bahkan gagal bayar dapat terjadi karena kinerja bisnis yang Anda investasikan bisa jadi kurang berjalan dengan baik.</p>

              <b>Dilusi Kepemilikan Efek</b></p>
              Dilusi kepemilikan Efek adalah penurunan persentase kepemilikan Efek yang terjadi karena bertambahnya total jumlah Efek yang beredar, dimana Investor yang bersangkutan tidak ikut membeli Efek yang baru diterbitkan tersebut. Penerbit dapat menerbitkan Efek baru jika jumlah penawaran yang diajukan masih dibawah batas maksimum. Jika Penerbit mengadakan urun dana lagi dan terjadi penerbitan Efek baru, maka Fulusme akan membuka bisnis tersebut di website Fulusme.id dan menginformasikan kepada semua pemegang Efek.</p>

              <b>Kegagalan Sistem Elektronik</b></p>
              Fulusme telah menerapkan sistem teknologi informasi dan keamanan data yang handal. Namun bagaimanapun juga tetap memungkinkan jika terjadi gangguan sistem teknologi informasi dan kegagalan sistem, jika ini terjadi maka akan menyebabkan aktivitas bisnis Anda di platform Fulusme menjadi tertunda.</p>
              .
            </li>
            <li>HARAP MENGGUNAKAN PERTIMBANGAN EKSTRA DALAM MEMBUAT KEPUTUSAN UNTUK MEMBELI Efek. ADA KEMUNGKINAN ANDA TIDAK BISA MENJUAL KEMBALI Efek BISNIS DENGAN CEPAT.</li>
            <li>LAKUKAN DIVERSIFIKASI INVESTASI, HANYA GUNAKAN DANA YANG SIAP ANDA LEPASKAN (AFFORS TO LOOSE) DAN ATAU DISIMPAN DALAM JANGKA PANJANG.</li>
            <li>FULUSME TIDAK MEMAKSA PENGGUNA UNTUK MEMBELI Efek BISNIS SEBAGAI INVESTASI.SEMUA KEPUTUSAN PEMBELIAN MERUPAKAN KEPUTUSAN INDEPENDEN OLEH PENGGUNA.</li>
            <li>FULUSME BERTINDAK SEBAGAI PENYELENGGARA URUN DANA YANG MEMPERTEMUKAN PEMODAL DAN PENERBIT, BUKAN SEBAGAI PIHAK YANG MENJALANKAN BISNIS (PENERBIT). OTORITAS JASA KEUANGAN BERTINDAK SEBAGAI REGULATOR DAN PEMBERI IZIN, BUKAN SEBAGAI PENJAMIN INVESTASI.</li>
            <li>KEPUTUSAN PEMBELIAN Efek, SEPENUHNYA MERUPAKAN HAK DAN TANGGUNG JAWAB PEMODAL (INVESTOR).DENGAN MEMBELI Efek DI FULUSME BERARTI ANDA SUDAH MENYETUJUI SELURUH SYARAT DAN KETENTUAN SERTA MEMAHAMI SEMUA RISIKO INVESTASI TERMASUK RESIKO KEHILANGAN SEBAGIAN ATAU SELURUH MODAL.</li>
            <li>OTORITAS JASA KEUANGAN TIDAK MEMBERIKAN PERNYATAAN MENYETUJUI ATAU TIDAK MENYETUJUI EFEK INI, TIDAK JUGA MENYATAKAN KEBENARAN ATAU KECUKUPAN INFORMASI DALAM LAYANAN URUN DANA INI. SETIAP PERNYATAAN YANG BERTENTANGAN DENGAN HAL TERSEBUT ADALAH PERBUATAN MELANGGAR HUKUM.</li>
            <li>INFORMASI DALAM LAYANAN URUN DANA INI PENTING DAN PERLU MENDAPAT PERHATIAN SEGERA. APABILA TERDAPAT KERAGUAN PADA TINDAKAN YANG AKAN DIAMBIL, SEBAIKNYA BERKONSULTASI DENGAN PENYELENGGARA.</li>
            <li>PENERBIT DAN PENYELENGGARA, BAIK SENDIRI-SENDIRI MAUPUN BERSAMA-SAMA, BERTANGGUNG JAWAB SEPENUHNYA ATAS KEBENARAN SEMUA INFORMASI YANG TERCANTUM DALAM LAYANAN URUN DANA INI.</li>
          </ol>
        </div>

      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-1 text-center">
        <img src="<?= base_url('assetsprofile/') ?>assetsbaru/media/logos/kominfo.jpeg" alt="Image" class="img-fluid" style="width:150px;margin-bottom:15px;">
      </div>
      <div class="col-md-1 text-center">
        <img src="<?= base_url('assetsprofile/') ?>assetsbaru/media/logos/danamon1.png" alt="Image" class="img-fluid" style="width:150px;margin-bottom:15px;">
      </div>
      <div class="col-md-1 text-center">
        <img src="<?= base_url('assetsprofile/') ?>assetsbaru/media/logos/Pefindo1.png" alt="Image" class="img-fluid" style="width:150px;margin-bottom:15px;">
      </div>
      <div class="col-md-1 text-center">
        <img src="<?= base_url('assetsprofile/') ?>assetsbaru/media/logos/PSe.jpeg" alt="Image" class="img-fluid" style="width:150px;margin-bottom:15px;">
      </div>
      <div class="col-md-1 text-center">
        <img src="<?= base_url('assetsprofile/') ?>assetsbaru/media/logos/aludi.jpeg" alt="Image" class="img-fluid" style="width:150px;margin-bottom:15px;">
      </div>


      <div class="col-md-1 text-center">
        <img src="<?= base_url('assetsprofile/') ?>assetsbaru/media/logos/ksei.jpeg" alt="Image" class="img-fluid" style="width:150px;margin-bottom:15px;">
      </div>
      <div class="col-md-1 text-center">
        <img src="<?= base_url('assetsprofile/') ?>assetsbaru/media/logos/fintechindo.jpeg" alt="Image" class="img-fluid" style="width:150px;margin-bottom:15px;">
      </div>
      <div class="col-md-1 text-center">
        <img src="<?= base_url('assetsprofile/') ?>assetsbaru/media/logos/rapidssl.jpeg" alt="Image" class="img-fluid" style="width:150px;margin-bottom:15px;">
      </div>
      <div class="col-md-1 text-center">
        <img src="<?= base_url('assetsprofile/') ?>assetsbaru/media/logos/get_in_on.png" alt="Image" class="img-fluid" style="width:150px;margin-bottom:15px;">
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-12 text-center">
        <!-- <span class="caption d-block mb-2 font-secondary font-weight-bold">VIDIO</span> -->
      </div>
    </div>
    <div class="row border-responsive">
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0 border-right">
        <div class="text-center">
          <h3 class="text-uppercase h4 mb-3">Welcome Fulusme</h3>
          <iframe src="https://www.youtube.com/embed/rzt7s9_CNuc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0 border-right">
        <div class="text-center">
          <h3 class="text-uppercase h4 mb-3">Pemodal</h3>
          <iframe src="https://www.youtube.com/embed/bARTt97D8gA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
        <div class="text-center">
          <h3 class="text-uppercase h4 mb-3">Penerbit</h3>
          <iframe src="https://www.youtube.com/embed/Wv602bVtnIE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>