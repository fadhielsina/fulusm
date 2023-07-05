<!-- Begin Page Content -->
<div class="container-fluid">
  <h1><?= $title; ?> Retail</h1>

  <?php if($project): ?>

    <div class="row">
      <div class="col-lg-8">
        <?= $this->session->flashdata('message'); ?>
      </div>
    </div>
    <div class="row" style="background: #fbfbfb;
    border: 1px #e8e8e8 solid;
    border-radius: 7px;"> 
      <div class="col-lg-3 mb-5 mt-5">
        <div class="card cardDash">
          <div class="card-body">
            <h5 class="card-title">Retail Tertunda</h5>
            Anda memiliki <?=  sizeof($pending_project) ?> pengajuan pulsa tertunda <br>
            <a href="<?= base_url('user/pendingRetail') ?>"> lihat detail</a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-5 mt-5">
        <div class="card cardDash">
          <div class="card-body">
            <h5 class="card-title">Retail Berjalan</h5>
            Anda memiliki <?=  sizeof($ongoing_project) ?> pengajuan pulsa berjalan <br>
            <a href="<?= base_url('user/ongoingRetail') ?>"> lihat detail</a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-5 mt-5">
        <div class="card cardDash">
          <div class="card-body">
            <h5 class="card-title">Retail Ditolak</h5>
            Anda memiliki <?=  sizeof($rejected_project) ?> pengajuan pulsa ditolak <br>
            <a href="<?= base_url('user/rejectedRetail') ?>"> lihat detail</a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-5 mt-5">
        <div class="card cardDash">
          <div class="card-body">
            <h5 class="card-title">Retail Berhasil</h5>
            Anda memiliki <?=  sizeof($finished_project) ?> pengajuan pulsa berhasil <br>
            <a href="<?= base_url('user/successRetail') ?>"> lihat detail</a>
          </div>
        </div>
      </div>
     
     
     <?php
     if (sizeof($is_eligible) == 0){?>
     <a style="    margin-left: 15px;
    margin-top: -30px;
    margin-bottom: 30px;" href="<?= base_url('project/addproyekretail') ?>" class="btn btn-success"><i class="far fa-plus-square"></i>     Buat pengajuan pulsa baru</a>
     
     <?php
     }else{
     ?>
     <a style="    margin-left: 15px;
    margin-top: -30px;
    margin-bottom: 30px;pointer-events: none; cursor: default;" data-toggle="tooltip" data-placement="right" title="Tooltip on right" href="<?= base_url('project/addproyekretail') ?>" class="btn btn-secondary"><i class="far fa-plus-square"></i>     Buat pengajuan pulsa baru</a>
     
     
      <?php }?>
    
    
    

    </div>




    <table id="example2" class="display" style="display: none;" cellspacing="0" width="100%"></table>
<div id="new-list2" class="row" style="display: none;" ></div>

  <?php else: ?>
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h6 >Anda belum memiliki pengajuan pulsa, klik untuk memulai pengajuan pulsa</h6>
        <a href="<?= base_url('project/addproyekretail') ?>" class="btn btn-success"><i class="far fa-plus-square"></i>     Ajukan sekarang</a>
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
   
$('#example2').dataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "columns": [
      { "title": "Engine" },
      { "title": "Browser" }
      ],
      "ajax": {
        url: "<?php echo base_url('user/ambil_data_all_retail_khusus') ?>",
        type:'POST',
      },
      "initComplete": function(settings, json) {
          
          
          


         $(".btnDanai2").click(function(){
         
          
          window.location.href = '<?= base_url('user/formDanaiRetail')?>?id_project='+$(this).parent().children(".idproj2").text().trim()+'&dana='+$(this).parent().parent().children(".nominal2").children("select.unit12").children("option:selected").val().trim()+'&user='+<?=$user['id']?>
        });


       $(".min-btn2").click(function(){

        // $(this).parent().children(".btnDanai").css("background-color", "red")



        var hargaperlot2 = parseInt($(this).parent().parent().parent().parent().children(".perlotdiv2").children(".hargalot2").text())
        var hargaberubah2 = parseInt($(this).parent().parent().children(".nominal2").children("#val12").text().replace(".", "").replace(".", "").replace(".", "").replace(".", ""))
        var unit2 = $(this).parent().parent().children(".nominal2").children(".unit12").val()


        if(hargaberubah2 > hargaperlot2 ){
          hargaberubah2 = numberWithCommas(hargaberubah2 - hargaperlot2)
          unit2--
          $(this).parent().parent().children(".nominal2").children(".unit12").val(unit2)
          $(this).parent().parent().children(".nominal2").children("#val12").text(hargaberubah2)
          $(this).parent().children(".hargakirim2").text(hargaberubah2)


        }
        // $(this).parent().parent().children(".nominal").children("#val1").text("cek")

      });
       $(".plus-btn2").click(function(){
        var hargaperlot2 = parseInt($(this).parent().parent().parent().parent().children(".perlotdiv2").children(".hargalot2").text())
        var hargaberubah2 = parseInt($(this).parent().parent().children(".nominal2").children("#val12").text().replace(".", "").replace(".", "").replace(".", "").replace(".", ""))
        var hargamax2 = parseInt($(this).parent().parent().parent().parent().children(".perlotdiv2").children(".jumlahpendanaan2").text())
        var unit2 = $(this).parent().parent().children(".nominal2").children(".unit12").val()
        var jumlahLot2 = parseInt($(this).parent().parent().children(".nominal2").children(".jumlahlot2").text());
        var sisaLot2 = parseInt($(this).parent().parent().children(".nominal2").children(".sisalot2").text());
        

        if(unit2 < sisaLot2 ){
          hargaberubah2 = numberWithCommas(hargaberubah2 + hargaperlot2)
          unit2++
          $(this).parent().parent().children(".nominal2").children(".unit12").val(unit2)
          $(this).parent().parent().children(".nominal2").children("#val12").text(hargaberubah2)
          $(this).parent().children(".hargakirim2").text(hargaberubah2)

        }

      });

       $(".unit12").change(function(){

         var hargaperlot2 = parseInt($(this).parent().parent().parent().parent().children(".perlotdiv2").children(".hargalot2").text())
          var hargaberubah2 = parseInt($(this).parent().parent().children(".nominal2").children("#val12").text().replace(".", "").replace(".", "").replace(".", "").replace(".", ""))
          var hargamax2 = parseInt($(this).parent().parent().parent().parent().children(".perlotdiv2").children(".jumlahpendanaan2").text())
          var unit2 = $(this).val()
          var jumlahLot2 = parseInt($(this).parent().children(".jumlahlot2").text());
          var sisaLot2 = parseInt($(this).parent().children(".sisalot2").text());

          if(unit2 < 1 ){
              $(this).val(1);
              $(this).parent().children("#val12").text(numberWithCommas(hargaperlot2*1))

          } 
          else if (unit2 > sisaLot2){
              $(this).val(sisaLot2);
              var totalUnit2 = numberWithCommas(hargaperlot2*sisaLot2)
              $(this).parent().children("#val12").text(totalUnit2)
          }else{
            var totalUnit2 = numberWithCommas(hargaperlot2*unit2)
              $(this).parent().children("#val12").text(totalUnit2)

          }
       })
    // show new container for data
    $('#new-list2').insertBefore('#example2');
    $('#new-list2').show();
  },
  "rowCallback": function( row, data ) {
    // on each row callback
    var div = $(document.createElement('div'));
    div.addClass("col-lg-6");
    var a = $(document.createElement('a'));
   
    a.css("color", 'black');
    
    a.css("text-decoration","none", "important")
                                      
   
    var ul = $(document.createElement('div'));
    ul.addClass("card_holder mt-5");
    ul.attr('id', 'card');


    ul.prepend('<img class="card_holder_img" src="'+'<?= base_url('assets/img/profile/'); ?>'+data[2]+'" />');

    var li = $(document.createElement('div'));

    li.addClass("card_holder_body");
    li.css("padding", "5px");
    

    li.append('<h5 class="card-title mb-1">'+data[1]+'</h5>');

    var isi2 = $(document.createElement('div'));
    isi2.addClass("row");

    var isisatu2 = $(document.createElement('div'));
    isisatu2.addClass("col-lg-12 mt-1 perlotdiv2");
    if(data[11]==data[5]){
        isisatu2.append('<img style="display: inline-block;top: -36px;right: 7px;position: absolute;     width: 23%;" src="'+'<?= base_url('assetsprofile/asset/images/'); ?>terdanai.jpeg" />');
    }else{
        
    }
    isisatu2.append('<h5 class="card-title" style="color: green;font-size:10px"> Id Proyek: '+data[15]+'</h5>');
    isisatu2.append('<h5 class="card-title " style="font-size:12px"> Jangka Waktu (Tenor/Hari) : '+data[6]+'</h5>');

    isisatu2.append('<h5 class="card-title " style="font-size:12px">Estimasi Net Profit Rp. ' + numberWithCommas(data[20])+ ' </h5>');
     isisatu2.append('<h5 class="card-title " style="font-size:12px">Jumlah Kebutuhan ' + numberWithCommas(data[5])+ ' </h5>');
    
    
    
    
    isisatu2.append('<h5 style="display: none;" class="hidden hargalot2">'+ 1000000 + ' </h5>');
    isisatu2.append('<h5 style="display: none;" class="hidden jumlahpendanaan2">'+ data[16] + ' </h5>');
    isisatu2.append('<p style="margin-bottom:0px;color:black; font-size:12px; margin-top:0px;">Uang Terkumpul : </p>')
    isisatu2.append('<div class="progress" style="margin-bottom:5px;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style=" width:'+data[13]+'%;"> '+data[13]+'%</div></div>')
    isisatu2.append('<p style="margin-bottom:0px;color:black; font-size:12px;">Sisa Waktu : <span style="float: right!important;">berakhir pada '+data[7]+'</span> </p>')
    isisatu2.append('<div class="progress" style="margin-bottom:7px;"><div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style=" width:'+data[10]+'%">'+data[8]+' hari </div></div>')
    isisatu2.append('<h5 class="card-title mt-3" style="color:green;font-size:10px; margin-bottom:0px"> Ujrah (Jasa Platform 1%) Rp. '+numberWithCommas(data[18])+' </h5>');
    isisatu2.append('<h5 class="card-title" style="color:green;font-size:10px; margin-bottom:0px"> Denom yang di terima Rp. '+numberWithCommas(data[19])+' </h5>');
    isisatu2.append('<h5 class="card-title" style="color:green;font-size:10px; margin-bottom:0px"> Pengembalian Dana Rp. '+numberWithCommas(data[21])+' </h5>');
    
  
   
    var pendanaan2 = $(document.createElement('div'));
    pendanaan2.addClass("row");
    
    var nilai_loop = "ini";
    
    for(var k = 0; k < (data[5]-data[11])/1000000-data[16]/1000000; k++){
        nilai_loop = nilai_loop + " <option value='"+(k+1)+"000000'>Rp. "+(k+1)+".000.000</option> ";
        
    }

    
    var isipendanaan2 = $(document.createElement('div'));
    isipendanaan2.addClass("col-lg-6 nominal2");
    isipendanaan2.append('<h5 style="display: none;" class="jumlahlot2">'+ data[20] + ' </h5>');
    isipendanaan2.append('<h5 style="display: none;" class="sisalot2">'+ data[22] + ' </h5>');


    var tersedia2 = $(document.createElement('div'));
    tersedia2.addClass("col-lg-6");
    
    
    
    tersedia2.append('<h5 style="display: none;" class="hidden idproj2">'+ data[15] + ' </h5>');
    tersedia2.append('<h5 style="display: none;" class="hidden hargakirim2">'+ data[13] + ' </h5>');
    tersedia2.append('<h5 style="display: none;" class="sisalot2">'+ data[22] + ' </h5>');

    

// href="<?= base_url('user/formDanai')?>?id_project='+data[11]+'&nilai="

    isipendanaan2.appendTo(pendanaan2);
    tersedia2.appendTo(pendanaan2);
    
    pendanaan2.appendTo(isisatu2);

    isisatu2.appendTo(isi2);

    isi2.appendTo(li);
    li.appendTo(ul);
    ul.appendTo(a);
    a.appendTo(div);

    div.appendTo('#new-list2');

  },
  "preDrawCallback": function( settings ) {
    // clear list before draw
    $('#new-list2').empty();
  },
  "pageLength": 2
});

$('#example2_length').hide();
$('#example2_filter').hide();

})
  
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }
</script>