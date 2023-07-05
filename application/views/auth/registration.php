<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5 col-lg-6 mx-auto">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5">

            <div class="text-center">
              <a href="<?= base_url('welcome'); ?>"><img src="<?= base_url(); ?>assetsprofile/asset/images/dealfintech.jpg" width="70"></a>
              <h1 class="h4 text-gray-900 mb-4">Buat Akun Baru </h1>
            </div>
            <form class="user" method="post" action="<?= base_url('auth/registration') ?>">
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="name" onkeypress="return hanyaHuruf(event);" placeholder="Nama Lengkap" name="name" value="<?= set_value('name'); ?>">
                <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                <script>
                  function hanyaHuruf(evt) {
                    var charCode = (evt.which) ? evt.which : event.keyCode
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) return true;
                    return false;
                  }
                </script>

              </div>
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Alamat Email" value="<?= set_value('email'); ?>">

                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>

              </div>

              <div class="form-group">
                <input type="phone" class="form-control form-control-user" id="phone" placeholder="Nomor Telepon" name="phone" value="<?= set_value('phone'); ?>">

                <?= form_error('phone', '<small class="text-danger pl-3">', '</small>'); ?>

              </div>


              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="password" class="form-control form-control-user" id="password1" name="password1" minlength="8" placeholder="Password">
                  <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-sm-6">
                  <input type="password" class="form-control form-control-user" id="password2" minlength="8" name="password2" placeholder="Ulangi Password">
                </div>
              </div>

              <div class="form-group">
                <select name="role_id" id="role_id" class="form-control" style="font-size: .8rem;
              border-radius: 2px !important;">
                  <option value="3">Pemodal</option>
                  <option value="2">Penerbit</option>

                </select>

                <?= form_error('role_id', '<small class="text-danger pl-3">', '</small>'); ?>

              </div>

              <div id="step2Disclaimer" style="    border: 1px solid #ddd;
          margin-top: 20px;
          font-size: 12px;
          height: 100px;
          padding: 13px;
          overflow-y: scroll;">
                <p style="font-size: 16px"><b>Syarat dan Ketentuan Fulusme </b></p>
                <p align="center"><b>Umum</b></p>
                <ol type="1">
                  <li>
                    <p>Judul yang digunakan dalam S&K ini adalah dalam bentuk notifikasi dan tidak untuk mempengaruhi dan mengubah penafsiran</p>
                  </li>
                  <li>
                    <p>Jika terdapat perbedaan antara akad perjanjian dan S&K, maka yang berlaku adalah akad perjanjian</p>
                  </li>
                  <li>
                    <p>S&K ini bisa direvisi maupun di amandemen sesuai dengan kebutuhan dan kemudian disetujui para Pengguna</p>
                  </li>
                </ol>
                <br>
                <p align="center"><b>Definisi</b></p>
                <ol type="1">
                  <li>
                    <p>Fulusme adalah penyedia layanan Urun Dana ( SCF ), yaitu tempat bertemunya Pemodal dan Penerbit dalam 1 marketplace (platform)</p>
                  </li>
                  <li>
                    <p>Fulusme berikutnya didefinisikan sebagai Platform atau penyedia layanan</p>
                  </li>
                  <li>
                    <p>Fulusme hanya terdaftar sebagai platform Urun Dana dan tidak menjalankan kegiatan perbankan, asuransi atau yang setara dan sejenisnya</p>
                  </li>
                  <li>
                    <p>Fulusme bukan nama perusahaan melainkan merk dagang dari PT Fintek Andalan Solusi Teknologi yang berlokasi di Jakarta</p>
                  </li>
                  <li>
                    <p>Yang dimaksud dengan Pemodal adalah entiti atau perseorangan yang menginvestasikan uangnya didalam suatu project dalam bentuk Saham yang disajikan pihak Fulusme </p>
                  </li>
                  <li>
                    <p>Yang dimaksud dengan Penerbit adalah badan usaha yang memiliki dokumen legal diwilayah NKRI yang ditandasahkan oleh badan yang berwenang</p>
                  </li>

                </ol>
                <br>

                <p align="center"><b>Dividen</b></p>
                <ol type="1">
                  <li>
                    <p>Yang dimaksud dengan Dividen adalah nilai tambah dari angka Nilai lembar saham yang dimiliki dari pihak pemodal kepada pemilik project (Penerbit). Nilai ini bisa berarti keuntungan atau bagi hasil untuk Pemodal </p>
                  </li>

                  <li>
                    <p>Dengan pertimbangan tertentu dari pihak Platform sehingga calon Penerbit dan Pemodal tidak berhak dalam daftar Pengguna di Fulusme , maka pihak Platform tidak akan membebankan kewajiban atau biaya apapun </p>
                  </li>
                </ol>
                <br>
                <p align="center"><b>Persetujuan Penerbit</b></p>
                <ol type="1">
                  <li>
                    <p>Platform berkewajiban mencari dan memberikan profil informasi yang detil dan jelas tentang proyek yang diajukan oleh calon Penerbit, kepada Pemodal</p>
                  </li>
                  <li>
                    <p>Proyek yang diputuskan akan didanai oleh Pemodal, merupakan tanggung jawab Pemodal sepenuhnya.</p>
                  </li>
                  <li>
                    <p>Dalam proses analisa dan kompilasi data berdasarkan hasil survey dan pengajuan via web, platform memiliki pertimbangan absolut untuk menentukan apakah calon masuk dalam daftar Penerbit atau pemodal</p>
                  </li>
                </ol>
                <br>
                <p align="center"><b>Rekening Bank Kustodian</b></p>
                <ol type="1">
                  <li>
                    <p>Fulusme sudah dilengkapi dengan fasilitas Rekening Bank Kustodian (BK), yang merupakan rekening untuk melakukan transaksi pemodalan dan wajib dimiliki oleh Pemodal maupun Penerbit</p>
                  </li>
                  <li>
                    <p>BK merupakan rekening bank tersendiri atas nama pemodal/Penerbit, dimana ia dapat melakukan monitoring saldo dan mutasi rekening melalui dashboard di Fulusme </p>
                  </li>
                  <li>
                    <p>Dengan Penggunaan BK ini semua transaksi yang dilakukan terjamin faktor keamanan nya</p>
                  </li>
                </ol>
                <br>
                <p align="center"><b>Data Pribadi</b></p>
                <ol type="1">
                  <li>
                    <p>Didalam proses verifikasi data, pihak Platform berhak untuk memproses, menganalisa semua informasi data pribadi mengenai calon Penerbit maupun Pemodal, baik yang langsung berasal dari Pengguna maupun yang didapat dari sumber lain sesuai dengan hukum yang berlaku</p>
                  </li>
                  <li>
                    <p>Fulusme akan merahasiakan semua data pribadi dan tidak menggunakan data tersebut untuk maksud lain selain untuk proses pemberian fasilitas Pembiayaan </p>
                  </li>

                </ol>
              </div>

              <div style="    margin-top: 20px;" class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="setuju" name="setuju">
                <label style="font-size: 12px;" class="form-check-label" for="setuju">saya telah membaca dan menyetujui syarat dan ketentuan di atas </label>
                <br>
                <?= form_error('setuju', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>


              <button id="masukbutton" class="btn btn-primary btn-user btn-block">
                Daftar
              </button>
            </form>
            <hr>
            <div class="text-center">
              <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Lupa Password?</a>
            </div>
            <div class="text-center">
              <a class="small" href="<?= base_url('auth'); ?>">Sudah punya akun? Masuk!</a>
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


<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script>
  $("#masukbutton").attr('disabled', 'disabled');

  // if (($('#step2Disclaimer').scrollTop() + $('#step2Disclaimer').innerHeight() > $('#step2Disclaimer')[0].scrollHeight)) {
  //     alert("hi");
  //   $("#masukbutton").removeAttr("disabled");
  //   $('input[name="setuju"]').prop('checked', true);
  // }

  $('input[name="setuju"]').attr('disabled', 'disabled');
  jQuery(function($) {
    $('#step2Disclaimer').on('scroll', function() {
      if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
        $("#masukbutton").removeAttr("disabled");
        $('input[name="setuju"]').removeAttr("disabled");
        $('input[name="setuju"]').prop('checked', true);
      }
    })
  });





  (function($) {
    $.fn.inputFilter = function(inputFilter) {
      return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      });
    };
  }(jQuery));


  $("#noktp").inputFilter(function(value) {
    return /^-?\d*$/.test(value) && (value === "" || value.length <= 16);
  });


  $("#phone").inputFilter(function(value) {
    return /^-?\d*[+]?\d*$/.test(value) && (value === "" || value.length <= 16);
  });
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-35VN14CNFE"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-35VN14CNFE');
</script>