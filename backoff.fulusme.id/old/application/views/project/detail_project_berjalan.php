<style>
  h4 {
    font-family: 'Open Sans';
    margin: 0;
  }

  .modal,
  body.modal-open {
    padding-right: 0 !important
  }

  body.modal-open {
    overflow: auto
  }

  body.scrollable {
    overflow-y: auto
  }

  .modal-footer {
    display: flex;
    justify-content: flex-start;
  }
</style>

<script>
  function formatNumber(input) {

    var num = input.value.replace(/\,/g, '');

    if (!isNaN(num)) {

      if (num.indexOf('.') > -1) {

        num = num.split('.');

        num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1,').split('')

          .reverse().join('').replace(/^[\,]/, '');

        if (num[1].length > 2) {

          alert('You may only enter two decimals!');

          num[1] = num[1].substring(0, num[1].length - 1);

        }

        input.value = num[0] + '.' + num[1];

      } else {

        input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1,').split('')

          .reverse().join('').replace(/^[\,]/, '')

      };

    } else {

      alert('Anda hanya diperbolehkan memasukkan angka!');

      input.value = input.value.substring(0, input.value.length - 1);

    }

  }



  function hitung() {

    var total = parseInt(document.getElementById('nominal_pengembalian').value.replace(/[$,]+/g, ""));

    var cicilan = parseInt(<?= $project->angsuran ?>);

    var hasil = total / cicilan;

    document.getElementById('cicilan').value = hasil.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

  }
</script>


<div class="card">
  <h1><a href="<?= base_url('project/marketplace') ?>"><i class="mdi mdi-chevron-double-left float-right"></i></a></h1>

  <div class="card-body pt-0">

    <div class="row">

      <div class="col">

        <div class="container mb-3">

          <ul class="list-group">

            <li class="list-group-item d-flex justify-content-between align-items-center">

              Nama Project

              <h4><span><?= $project->nama_project ?></span></h4>

            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center">

              ID Project

              <h4><span><?= $project->id_project ?></span></h4>

            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center">

              Image Project

              <h4><span><a class="btn waves-effect waves-light btn-outline-info" data-target="#modalIMG" data-toggle="modal" href="#">View Image</a></span></h4>

            </li>

          </ul>

        </div>

        <div class="container mb-3">

          <ul class="list-group">

            <li class="list-group-item d-flex justify-content-between align-items-center">

              Harga PerLot

              <h4><span><?= number_format($datproject->harga_perlot) ?></span></h4>

            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center">

              Jumlah Lot Terdanai
              <?php $harper = $datproject->harga_perlot;
              if ($harper <= 0) $harper = 1; ?>
              <h4><span><?= $dana_terkumpul->nominal / $harper ?>/<?= $datproject->jumlah_lot ?></span></h4>

            </li>

            <a href="<?= base_url('project/detailDanaTerkumpul') ?>/<?= $project->id_project ?>" class="list-group-item list-group-item-action">Dana Terkumpul

              <h4 class="float-right"><span id="dana_terkumpul"><?= number_format($dana_terkumpul->nominal) ?></span></h4>

            </a>

            <li class="list-group-item d-flex justify-content-between align-items-center">

              Nisbah

              <h4><span><?= $project->persentasi_keuntungan ?>%</span></h4>

            </li>

          </ul>

        </div>

        <div class="container mb-3">

          <ul class="list-group">

            <li class="list-group-item d-flex justify-content-between align-items-center">

              Modal Project

              <h4><span><?= number_format($datproject->modal_project) ?></span></h4>

            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center">

              Tanggal Approve Project

              <h4><span><?= $project->tgl_app ?></span></h4>

            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center">

              Lama Proyek (Tenor)

              <h4><span><?= $project->tenor ?> Hari</span></h4>

            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center">

              Tipe Pembayaran

              <h4><span><?= $project->tipe ?></span></h4>

            </li>

          </ul>

        </div>

      </div>

      <div class="col-lg-6">

        <div class="container mb-3">

          <form action="<?= base_url('project/marketplace_detail') ?>/<?= $project->id_project  ?>" method="post">

            <?php $keuntungan = $dana_terkumpul->nominal * ($project->persentasi_keuntungan / 100);

            $lender = $keuntungan * ($project->lender / 100); ?>

            <ul class="list-group">

              <span class="list-group-item d-flex justify-content-between align-items-center">

                Virtual Account

                <span style="width:160px;"><input type="text" class="form-control text-center" value="<?= $project->virtual_account ?>" readonly style="font-size:15px; color:black;" name="virtual_account" id="virtual_account"></span>

              </span>

              <span class="list-group-item d-flex justify-content-between align-items-center">

                Pinjaman Di Transfer

                <span style="width:160px;"><input type="text" class="form-control text-center" value="<?= number_format($dana_terkumpul->nominal * (97 / 100)); ?>" readonly style="font-size:15px; color:black;" name="pinjam_di_tf" id="pinjam_di_tf"></span>

              </span>

              <span class="list-group-item d-flex justify-content-between align-items-center">

                Ujrah

                <span style="width:160px;"><input type="text" class="form-control text-center" value="<?= number_format($dana_terkumpul->nominal * (3 / 100)); ?>" readonly style="font-size:15px; color:black;" name="ujrah" id="ujrah"></span>

              </span>

              <li class="list-group-item d-flex justify-content-between align-items-center">

                Estimasi Keuntungan

                <span style="width:160px;"><input type="text" class="form-control text-center" value="<?= number_format($keuntungan); ?>" readonly style="font-size:15px; color:black;" name="keuntungan" id="keuntungan"></span>

              </li>

              <li class="list-group-item d-flex justify-content-between align-items-center">

                Pembagian Lender

                <span style="width:160px;"><input type="text" class="form-control text-center" value="<?= number_format($lender); ?>" readonly style="font-size:15px; color:black;" name="lender" id="lender"></span>

              </li>

              <li class="list-group-item d-flex justify-content-between align-items-center">

                Pembagian Borrower

                <span style="width:160px;"><input type="text" class="form-control text-center" value="<?= number_format($keuntungan * ($project->borrower / 100)); ?>" readonly style="font-size:15px; color:black;" name="borrower" id="borrower"></span>

              </li>

              <?php $stat = "readonly";

              $total = $dana_terkumpul->nominal;

              if ($project->status == 1) {

                $stat = "";
              } ?>

              <li class="list-group-item d-flex justify-content-between align-items-center">

                Total Pengembalian

                <span style="width:160px;"><input class="form-control text-center" type="text" <?= $stat ?> onkeyup="formatNumber(this); hitung();" value="<?= number_format($total); ?>" style="font-size:15px; color:black;" name="nominal_pengembalian" id="nominal_pengembalian"><small class="text-danger"> <?= form_error('nominal_pengembalian'); ?> </small></span>

              </li>

              <?php if ($project->angsuran <= 12) : ?>

                <li class="list-group-item d-flex justify-content-between align-items-center">

                  Cicilan X <?= $project->angsuran ?>

                  <span style="width:160px;"><input type="text" class="form-control text-center" onkeyup="formatNumber(this);" value="<?= number_format($total / $project->angsuran); ?>" style="font-size:15px; color:black;" <?= $stat ?> name="cicilan" id="cicilan"></span>

                </li>

              <?php endif; ?>

              <?php if ($tgl_transfer) : ?>

                <li class="list-group-item d-flex justify-content-between align-items-center">

                  Tanggal Transfer Ke Pengelola Dana

                  <span style="width:160px;"><input type="text" class="form-control text-center" value="<?= $tgl_transfer->tgl_pinjam ?>" readonly style="font-size:15px; color:black;"></span>

                </li>

              <?php endif; ?>

            </ul>

        </div>

        <?php if ($project->status == 1) : ?>

          <?php if ($dana_terkumpul->nominal >= $datproject->modal_project) : ?>

            <?php $status_ijarah = $this->db->get_where('scr_status', ['id_project' => $project->id_project])->row()->status_ijarah; ?>

            <?php $warna = 'warning';

            if ($status_ijarah == 1) {

              $warna = 'success';
            } ?>

            <div>

              <button type="submit" name="send_akad" class="btn btn-<?= $warna; ?>" onclick="return confirm('Kirim Akad?')"><i class="mdi mdi-email"></i> Kirim Akad Ijarah</button>

            </div>

          <?php endif; ?>

          <div class="row mt-2">
            <?php if ($project->tipe == 'Murabahah') : ?>

              <div class="col">

                <a href="<?= base_url('Project/pembelian') ?>/<?= $project->id_project ?>" class="btn btn-primary" onclick="return confirm('Beli Asset?')"> <i class="mdi mdi-shopping"></i> Beli Asset</a>

              </div>

            <?php endif; ?>
          </div>
      </div>

    </div>

    <div class="row">
      <div class="col">
        <?php if (date('Y-m-d', time()) >= $project->tgl_deadline && $project->status == 1) : ?>
          <a href="<?= base_url('project/tambahDurasi') ?>/<?= $datproject->id ?>" class="btn btn-warning" onclick="return confirm('Tambah Durasi?')">Tambah Durasi Promosi</a>
        <?php endif; ?>
      </div>

      <div class="col">
        <button type="submit" class="btn btn-primary" onclick="return confirm('Post Ke Pra Jurnal?')"><i class="mdi mdi-file"></i> Start Project & Send Akad</button>
        </form>
      </div>

      <div class="col">
        <a href="<?= base_url('project/cancel') ?>/<?= $project->id_project ?>" class="btn btn-danger float-right" onclick="return confirm('Anda akan cancel project?')"><i class="mdi mdi-window-close"></i> Cancel Project</a>
      <?php endif; ?>
      </div>
    </div>

  </div>

</div>

</div>



<!-- Modal Image -->

<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="modalIMG" role="dialog" tabindex="-1">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-body mb-0 p-0">

        <!-- <img src="<?= base_url('assets/img') ?>/<?= $datproject->image ?>" alt="" style="width:100%"> -->

        <img src="https://www.fulusme.id/assets/img/profile/<?= $datproject->image ?>">

      </div>

      <div class="modal-footer">

        <button class="btn btn-outline-primary btn-rounded btn-md ml-4 text-center" data-dismiss="modal" type="button">Close</button>

      </div>

    </div>

  </div>

</div>



<script>
  $('a a').remove();



  document.documentElement.setAttribute("lang", "en");

  document.documentElement.removeAttribute("class");



  axe.run(function(err, results) {

    console.log(results.violations);

  });
</script>