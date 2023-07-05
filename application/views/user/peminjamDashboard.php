<!-- Begin Page Content -->
<div class="container-fluid">
  <h1><?= $title; ?> Penerbit </h1>

  <?php if ($project) : ?>

    <div class="row">
      <div class="col-lg-8">
        <?= $this->session->flashdata('message'); ?>
      </div>
    </div>
    <div class="row" style="background: #f0f2f6; ">
      <div class="col-lg-3 mb-5 mt-5">
        <div class="card cardDash">
          <div class="card-body">
            <h5 class="card-title">Proyek Tertunda</h5>
            Anda Memiliki <?= sizeof($pending_project) ?> peroyek tertunda <br>
            <a href="<?= base_url('user/pendingLoan') ?>">lihat detail</a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-5 mt-5">
        <div class="card cardDash">
          <div class="card-body">
            <h5 class="card-title">Proyek Berjalan</h5>
            Anda Memiliki <?= sizeof($ongoing_project) ?> proyek berjalan <br>
            <a href="<?= base_url('user/ongoingLoan') ?>"> lihat detail</a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-5 mt-5">
        <div class="card cardDash">
          <div class="card-body">
            <h5 class="card-title">Proyek di Tolak</h5>
            Anda Memiliki <?= sizeof($rejected_project) ?> proyek ditolak <br>
            <a href="<?= base_url('user/rejectedLoan') ?>"> lihat detail</a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-5 mt-5">
        <div class="card cardDash">
          <div class="card-body">
            <h5 class="card-title">Proyek Berhasil</h5>
            Anda Memiliki <?= sizeof($finished_project) ?> proyek berhasil<br>
            <a href="<?= base_url('user/historyLoan') ?>"> lihat detail</a>
          </div>
        </div>
      </div>
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-success" style="margin-left: 15px;margin-top: -30px;margin-bottom: 30px;" data-toggle="modal" data-target="#exampleModal">
        <i class="far fa-plus-square"></i> Buat Proyek Baru
      </button>
    </div>

    <table id="example" class="display" style="display: none;" cellspacing="0" width="100%"></table>
    <div id="new-list" class="row" style="display: none;"></div>

  <?php else : ?>
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h6>Anda belum memiliki Pengajuan Proyek untuk didanai, klik untuk memulai Pengajuan Anda</h6>
        <a href="<?= base_url('project/addproyek') ?>" class="btn btn-success"><i class="far fa-plus-square"></i> Mulai Proyek Baru</a>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <?= $this->session->flashdata('message'); ?>
      </div>
    </div>

  <?php endif ?>
</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Silahkan Pilih proyek yang akan dilakukan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="text-center mt-2 mb-2">
        <a href="<?= base_url('project/addProyek/1') ?>" type="button" class="btn btn-secondary">Efek Ekuitas</a>
        <a href="<?= base_url('project/addProyek/2') ?>" type="button" class="btn btn-primary">Efek Hutang</a>
      </div>
    </div>
  </div>
</div>


<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/simple.money.format.js"></script>
<script type="text/javascript">
  function formatMoney(n, c, d, t) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
      d = d == undefined ? "." : d,
      t = t == undefined ? "," : t,
      s = n < 0 ? "-" : "",
      i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
      j = (j = i.length) > 3 ? j % 3 : 0;

    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
  };




  $(document).ready(function() {
    // $('.rupiah').simpleMoneyFormat();
    $('#example').dataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "columns": [{
          "title": "Engine"
        },
        {
          "title": "Browser"
        }
      ],
      "ajax": {
        url: "<?php echo base_url('user/ambil_data') ?>",
        type: 'POST',
      },
      "initComplete": function(settings, json) {
        // show new container for data
        $('#new-list').insertBefore('#example');
        $('#new-list').show();
      },
      "rowCallback": function(row, data) {
        // on each row callback
        // alert(data);
        var div = $(document.createElement('div'));
        div.addClass("col-lg-4");

        var ul = $(document.createElement('div'));
        ul.addClass("card mt-5");


        ul.prepend('<img class="card-img-top" style="width: 100%;height: 300px;background-position: center center;background-repeat: no-repeat;" src="' + '<?= base_url('assets/img/profile/'); ?>' + data[2] + '" />');

        var li = $(document.createElement('div'));

        li.addClass("card-body");


        li.append('<h5 class="card-title">' + data[1] + '</h5>');
        li.append('<h5 class="card-text" style="font-size:12px"> Id Project : ' + data[11] + '</h5>');
        li.append('<h5 class="card-text" style="font-size:12px">' + data[5] + '</h5>');

        li.append('<h5 class="card-text" style="font-size:12px"> <b> uang terkumpul</b> </h5> <div class="progress rupiah"><div class="progress-bar" role="progressbar" style="color:#b3b3b3; width: ' + data[3] / data[4] * 100 + '%;" aria-valuenow="' + data[3] / data[4] * 100 + '" aria-valuemin="0" aria-valuemax="100"> Rp. ' + formatMoney(data[3]) + '</div></div> <h5 class="card-text text-right" style="font-size:8px"> dana yang diperlukan : Rp.' + formatMoney(data[4]) + ' </h5>')

        li.append('<h5 class="card-text" style="font-size:12px"> <b> sisa waktu</b> </h5> <div class="progress rupiah"><div class="progress-bar" role="progressbar" style="color:#b3b3b3; width: ' + data[8] + '%;" aria-valuenow="' + data[8] * 100 + '" aria-valuemin="0" aria-valuemax="100">' + data[9] + ' hari tersisa </div></div> <h5 class="card-text text-right" style="font-size:8px"> deadline : ' + data[6] + ' </h5>')


        li.appendTo(ul);
        ul.appendTo(div);

        div.appendTo('#new-list');
        $("a.paginate_button.current").attr("id", "white");
      },
      "preDrawCallback": function(settings) {
        // clear list before draw
        $('#new-list').empty();
        $("a.paginate_button.current").attr("id", "white");
      },
      "pageLength": 9
    });
    $("a.paginate_button.current").attr("id", "white");
    $('#example_length').hide();
    $('#example_filter').hide();

  })
</script>