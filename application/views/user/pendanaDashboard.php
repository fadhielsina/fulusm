<?php
$pendana = $this->db->get_where('pendana', ['user_id' => $user['id']])->row();
$total_gaji = $pendana->total_gaji;
$active = $pendana->active;
$input_button = '';
$persent = '5%';
if ($total_gaji == 2) :
  $persent = '10%';
endif;
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <h1><?= $title; ?> Pemodal</h1>
  <div class="row">
    <div class="col-lg">
      <?= $this->session->flashdata('message'); ?>
      <?php if ($active == 0) : ?>
        <div class="alert alert-warning" role="alert">
          Maaf anda belum bisa melakukan pendanaan karena akun sedang di review.
        </div>
      <?php $input_button = 'disabled';
      endif; ?>
    </div>
  </div>

  <div class="row" style="background: #f0f2f6; ">
    <div class="col-lg-4 mb-5 mt-5">
      <div class="card cardDash">
        <div class="card-body">
          <h5 class="card-title">Pendanaan Tertunda</h5>
          Anda Memiliki <?= sizeof($pending_project) ?> Pendanaan Tertunda <br>
          <a href="<?= base_url('user/pendingFunding') ?>"> Lihat Detail</a>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mb-5 mt-5">
      <div class="card cardDash">
        <div class="card-body">
          <h5 class="card-title">Pendanaan Berjalan</h5>
          Anda Memiliki <?= sizeof($ongoing_project) ?> Pendanaan Berjalan <br>
          <a href="<?= base_url('user/ongoingFunding') ?>"> Lihat Detail</a>
        </div>
      </div>
    </div>

    <div class="col-lg-4 mb-5 mt-5">
      <div class="card cardDash">
        <div class="card-body" style="background: #ddd;
        color: #bbb;">
          <h5 class="card-title">Pengembalian Dana</h5>
          Anda Memiliki <?= sizeof($returned_project) ?> Pengembalian Dana <br>
          <a style="pointer-events: none; 
        cursor: default; color: #bbb" href="<?= base_url('user/returnedFunding') ?>"> Lihat Detail</a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12 mt-5" style="    padding: 30px;
    background: linear-gradient(90deg,#3baa34,#322783);
    box-shadow: rgb(219, 222, 226) 0px 2px 4px 2px;
    border-radius: 7px;
    margin: 0px;">
    <h2 class="text-center mb-0" style="color:white">Marketplace</h2>
  </div>

  <!-- <?= var_dump($project) ?> -->
  <?= form_open('user/formDanai') ?>
  <div class="mt-2">
    <div class="row">
      <?php $i = 1;
      $input_form = ''; ?>
      <?php foreach ($project as $proj) : ?>
        <?php $hargaperlot =  (int) $proj['harga_perlot'];
        $foto_project = unserialize($proj['image']);
        $query_waktu = $this->db->select("(datediff(FROM_UNIXTIME(`project`.end_ts, '%Y-%m-%d'), 
        FROM_UNIXTIME(`project`.scoring_ts, '%Y-%m-%d'))-datediff(FROM_UNIXTIME(`project`.end_ts, '%Y-%m-%d'), current_date())) as sisawaktu, 
        datediff(FROM_UNIXTIME(`project`.end_ts, '%Y-%m-%d'), FROM_UNIXTIME(`project`.scoring_ts, '%Y-%m-%d')) as totalhari")
          ->from('project')
          ->where('id', $proj['id'])->where('end_ts >=', time())->where('version', 1)->where('status', 1)
          ->get()->row();
        $total_lot = $proj['jumlah_lot'] - $proj['jumlah_pendanaan'];
        if ($total_lot < 1) :
          $total_lot = 0;
          $input_form = 'disabled';
        endif;
        $lot_perusahaan = $total_lot * $hargaperlot;
        $uang_terkumpul = $this->db->select('sum(nominal) as uang_terkumpul')->from('pendanaan')
          ->where('paid_ts !=', 0)->where('project_id', $proj['id'])->get()->row()->uang_terkumpul;
        ?>
        <div class="col-4 mb-2">
          <div class="card w-200">
            <h5 class="card-title text-center" style="height: 72px; padding-top: 8px;"><b><?= $proj['nama_project'] ?></b></h5>
            <img class="card-img-top" src="<?= ($foto_project[0]) ? base_url('assets/img/profile/') . $foto_project[0] : base_url('assets/img/noimage.png'); ?>" alt="Project" style="height:250px">
            <div class="card-body" style="padding-top: 5px;">
              <div class="row">
                <div class="col">
                  <!-- Button Document -->
                  <?php $query_dokumen = $this->db->get_where('project_document', ['project_id' => $proj['id']])->row(); ?>
                  <a class="nav-link dropdown-toggle text-center" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Priview Dokumen
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <!--<a class="dropdown-item" href="<?= ($query_dokumen->rekening_koran) ? base_url('assets/img/profile/' . $query_dokumen->rekening_koran . '') : "#"; ?>" target="_blank">Rekening Koran</a>-->
                    <!--<a class="dropdown-item" href="<?= ($query_dokumen->profil_perusahaan) ? base_url('assets/img/profile/' . $query_dokumen->profil_perusahaan . '') : "#"; ?>" target="_blank">Profil Perusahaan</a>-->
                    <!--<a class="dropdown-item" href="<?= ($query_dokumen->laporan_keuangan) ? base_url('assets/img/profile/' . $query_dokumen->laporan_keuangan . '') : "#"; ?>" target="_blank">Laporan Keuangan</a>-->
                    <!--<a class="dropdown-item" href="<?= ($query_dokumen->dokumen_pendukung) ? base_url('assets/img/profile/' . $query_dokumen->dokumen_pendukung . '') : "#"; ?>" target="_blank">Dokumen Pendukung</a>-->
                    <a class="dropdown-item" href="<?= ($query_dokumen->prospektus) ? base_url('assets/file_user/prospektus/' . $query_dokumen->prospektus . '') : "#"; ?>" target="_blank">Prospektus</a>
                  </div>
                  <!-- End Document -->
                  <h6>ID Proyek : <span class="badge badge-success"><?= $proj['id'] ?></span></h6>
                  <h6>Kode Efek : <span class="badge badge-success"><?= $proj['code_saham_alias'] ?></span></h6>
                  <h6>Modal Proyek : Rp. <?= number_format($proj['modal_project']) ?></h6>
                  <?php if ($pendana->type == 1) : ?>
                    <h6>Maksimal Pendanaan : <?= 'Rp. ' . number_format($pendana->max_pendanaan); ?></h6>
                    <h6>Sisa Kuota Pendanaan : <span class="badge badge-info"><?= 'Rp. ' . number_format($pendana->sisa_pendanaan); ?></span></h6>
                  <?php else : ?>
                    <h6>Maksimal Pendanaan : - </h6>
                    <h6>Sisa Kuota Pendanaan : - </h6>
                  <?php endif; ?>
                  <!-- <h6>Sisa Waktu : <?= ($proj['end_ts'] - time() / 86400) < 0 ? 0 : floor(($proj['end_ts'] - time()) / 86400); ?> Hari</h6> -->
                  <h6>Sisa Waktu : <?= $query_waktu->totalhari - $query_waktu->sisawaktu ?> Hari</h6>
                  <h6>Harga Per Lot : Rp. <?= number_format($proj['harga_perlot']) ?></h6>
                  <h6>Uang Terkumpul : Rp. <?= number_format($uang_terkumpul) ?></h6>
                  <h6>Jumlah Pendanaan / Lot : <br>
                    <div class="row">
                      <div class="col-8">
                        <?php if ($pendana->type == 1) : ?>
                          <input class="form-control" <?= $input_form ?> type="number" onkeyup="hitung_lot(<?= $hargaperlot ?>, <?= $pendana->sisa_pendanaan ?>, <?= $total_lot ?>, <?= $i ?>)" id="jumlah_lot<?= $i ?>">
                        <?php else : ?>
                          <input class="form-control" <?= $input_form ?> type="number" onkeyup="hitung_lot(<?= $hargaperlot ?>, <?= $lot_perusahaan ?>, <?= $total_lot ?>, <?= $i ?>)" id="jumlah_lot<?= $i ?>">
                        <?php endif; ?>
                      </div>
                      <div class="col" style="padding-top: 8px; padding-left: 0px;">
                        / <?= $total_lot; ?>
                      </div>
                    </div>
                    <div id="divTotal<?= $i ?>" style="color:dodgerblue;">Rp. 0</div>
                  </h6>
                  <?php if ($pendana->type == 1) : ?>
                    <p style="font-size: 11px; color: blue;">*Total efek yang dapat dibeli hanya <?= $persent ?> dari Penghasilan</p>
                  <?php endif; ?>
                </div>
              </div>
              <input type="hidden" value="<?= $proj['id'] ?>" name="id_project<?= $i ?>">
              <input type="hidden" value="<?= $user['id'] ?>" name="user">
              <input type="hidden" id="dana<?= $i ?>" name="dana<?= $i ?>">
              <div class="text-center"><button <?= $input_button ?> name="button" type="submit" value="<?= $i ?>" class="btn btn-primary">Beli</button></div>
            </div>
          </div>
        </div>
      <?php $i += 1;
        $input = '';
      endforeach; ?>
    </div>
  </div>
  <?php form_close(); ?>

  <script>
    function hitung_lot(data, maks, totalLot, index) {
      var jumlahLot = $('#jumlah_lot' + index).val();
      var dana = jumlahLot * data;
      var hasil = addCommas(dana);
      var input = $('#dana' + index);

      $('#divTotal' + index).empty();
      input.val('');
      if (dana <= maks) {
        if (jumlahLot <= totalLot) {
          $('#divTotal' + index).append("Rp. " + hasil);
        } else {
          alert('Maaf, Anda telah melebihi batas Pendanaan')
          var jumlahLot = $('#jumlah_lot' + index).val(0);
          $('#divTotal' + index).append("Rp. 0")
        }
      } else {
        alert('Maaf, Anda telah melebihi batas Pendanaan')
        var jumlahLot = $('#jumlah_lot' + index).val(0);
        $('#divTotal' + index).append("Rp. 0")
      }
      input.val(parseInt(input.val() + dana));
    }

    function addCommas(nStr) {
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      return x1 + x2;
    }
  </script>