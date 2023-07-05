<!-- Begin Page Content -->
<div class="container-fluid">
  <h1><?= $title; ?> Debtor</h1>

  <?php if($project): ?>

    <?php if((!$this->session->userdata('token_project')) || sizeof($project)>1): ?>

    <div class="row">
      <div class="col-lg-8">
        <?= $this->session->flashdata('message'); ?>
      </div>
    </div>

    <div class="row" style="background: #f0f2f6; "> 
      <div class="col-lg-3 mb-5 mt-5">
        <div class="card cardDash">
          <div class="card-body">
            <h5 class="card-title">Pembiayaan Tertunda</h5>
            you have <?=  sizeof($pending_project) ?> Pembiayaan Tertunda <br>
            <a href="<?= base_url('user/pendingLoan') ?>"> Lihat Detail</a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-5 mt-5">
        <div class="card cardDash">
          <div class="card-body">
            <h5 class="card-title">Pembiayaan Berjalan</h5>
            you have <?=  sizeof($ongoing_project) ?> Pembiayaan Berjalan <br>
            <a href="<?= base_url('user/ongoingLoan') ?>"> Lihat Detail</a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-5 mt-5">
        <div class="card cardDash">
          <div class="card-body">
            <h5 class="card-title">Pembiayaan Ditolak</h5>
            you have <?=  sizeof($rejected_project) ?> Pembiayaan Ditolak <br>
            <a href="<?= base_url('user/rejectedLoan') ?>"> Lihat Detail</a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-5 mt-5">
        <div class="card cardDash">
          <div class="card-body">
            <h5 class="card-title">Pembiayaan Berhasil</h5>
            you have <?=  sizeof($finished_project) ?> Pembiayaan Berhasil <br>
            <a href="<?= base_url('user/historyLoan') ?>"> Lihat Detail</a>
          </div>
        </div>
      </div>
    </div>



    <table id="example" class="display" style="display: none;" cellspacing="0" width="100%"></table>
    <div id="new-list" class="row" style="display: none;" ></div>







  <?php else: 

    redirect('project/addproyek');
    ?>

  <?php endif ?>
  <?php else: ?>
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h6 >Anda belum memiliki proyek untuk didanai, klik untuk memulai proyek anda</h6>
        <a href="<?= base_url('project/addproyek') ?>" class="btn btn-success"><i class="far fa-plus-square"></i>     mulai proyek baru</a>
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


<script src="<?= base_url('assets/');?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/');?>js/simple.money.format.js"></script>
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




  $(document).ready(function(){
    // $('.rupiah').simpleMoneyFormat();
    $('#example').dataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "columns": [
      { "title": "Engine" },
      { "title": "Browser" }
      ],
      "ajax": {
        url: "<?php echo base_url('user/ambil_data') ?>",
        type:'POST',
      },
      "initComplete": function(settings, json) {
    // show new container for data
    $('#new-list').insertBefore('#example');
    $('#new-list').show();
  },
  "rowCallback": function( row, data ) {
    // on each row callback
    var div = $(document.createElement('div'));
    div.addClass("col-lg-4");

    var ul = $(document.createElement('div'));
    ul.addClass("card mt-5");


    ul.prepend('<img class="card-img-top" style="width: 100%;height: 300px;background-position: center center;background-repeat: no-repeat;" src="'+'<?= base_url('assets/img/project/'); ?>'+data[2]+'" />');

    var li = $(document.createElement('div'));

    li.addClass("card-body");
    

    li.append('<h5 class="card-title">'+data[1]+'</h5>');
    li.append('<h5 class="card-text" style="font-size:12px">'+data[5]+'</h5>');

    li.append('<h5 class="card-text" style="font-size:12px"> <b> uang terkumpul</b> </h5> <div class="progress rupiah"><div class="progress-bar" role="progressbar" style="color:#b3b3b3; width: '+data[3]/data[4]*100+'%;" aria-valuenow="'+data[3]/data[4]*100+'" aria-valuemin="0" aria-valuemax="100"> Rp. '+formatMoney(data[3])+'</div></div> <h5 class="card-text text-right" style="font-size:8px"> dana yang diperlukan : Rp.'+ formatMoney(data[4]) +' </h5>')

    li.append('<h5 class="card-text" style="font-size:12px"> <b> sisa waktu</b> </h5> <div class="progress rupiah"><div class="progress-bar" role="progressbar" style="color:#b3b3b3; width: '+data[8]+'%;" aria-valuenow="'+data[3]/data[4]*100+'" aria-valuemin="0" aria-valuemax="100">'+data[9]+' hari tersisa </div></div> <h5 class="card-text text-right" style="font-size:8px"> deadline : '+ data[6] +' </h5>')


    li.appendTo(ul);
    ul.appendTo(div);

    div.appendTo('#new-list');
    $("a.paginate_button.current").attr("id", "white");
  },
  "preDrawCallback": function( settings ) {
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