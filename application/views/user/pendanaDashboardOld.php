
<!-- Begin Page Content -->
<div class="container-fluid">
  <h1><?= $title; ?> Pemodal</h1>
  <div class="row">
    <div class="col-lg">
      <?= $this->session->flashdata('message'); ?>
    </div>
  </div>

  <div class="row" style="background: #f0f2f6; "> 
    <div class="col-lg-4 mb-5 mt-5">
      <div class="card cardDash">
        <div class="card-body">
          <h5 class="card-title">Pendanaan Tertunda</h5>
          Anda Memiliki <?=  sizeof($pending_project) ?> Pendanaan Tertunda <br>
          <a href="<?= base_url('user/pendingFunding') ?>"> Lihat Detail</a>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mb-5 mt-5">
      <div class="card cardDash">
        <div class="card-body">
          <h5 class="card-title">Pendanaan Berjalan</h5>
          Anda Memiliki <?=  sizeof($ongoing_project) ?> Pendanaan Berjalan <br>
          <a href="<?= base_url('user/ongoingFunding') ?>"> Lihat Detail</a>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4 mb-5 mt-5">
      <div class="card cardDash">
        <div class="card-body" style="    background: #ddd;
        color: #bbb;">
        <h5 class="card-title">Pengembalian Dana</h5>
        Anda Memiliki <?=  sizeof($returned_project) ?> Pengembalian Dana <br>
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
    margin: 0px;"><h2 class="text-center mb-0" style="color:white">Marketplace</h2></div>

<table id="example" class="display" style="display: none;" cellspacing="0" width="100%"></table>
<div id="new-list" class="row" style="display: none;" ></div>

<div class="col-lg-12 mt-5" style="    padding: 30px;
    background: linear-gradient(90deg,#3baa34,#322783);
    box-shadow: rgb(219, 222, 226) 0px 2px 4px 2px;
    border-radius: 7px;
    margin: 0px;"><h2 class="text-center mb-0" style="color:white">Marketplace UMKM</h2></div>

<table id="example2" class="display" style="display: none;" cellspacing="0" width="100%"></table>
<div id="new-list2" class="row" style="display: none;" ></div>

</div>
<!-- End of Main Content -->
<script src="<?= base_url('assets/');?>vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }
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
        url: "<?php echo base_url('user/ambil_data_all') ?>",
        type:'POST',
      },
      "initComplete": function(settings, json) {


         $(".btnDanai").click(function(){
          // console.log("<?= $user['id'] ?>");
          // alert($(this).parent().children(".idproj").text())
          // alert($(this).parent().children(".hargakirim").text())
          
          window.location.href = '<?= base_url('user/formDanai')?>?id_project='+$(this).parent().children(".idproj").text().trim()+'&dana='+$(this).parent().children(".hargakirim").text().trim()+'&user='+<?=$user['id']?>
        });


       $(".min-btn").click(function(){

        // $(this).parent().children(".btnDanai").css("background-color", "red")



        var hargaperlot = parseInt($(this).parent().parent().parent().parent().children(".perlotdiv").children(".hargalot").text())
        var hargaberubah = parseInt($(this).parent().parent().children(".nominal").children("#val1").text().replace(".", "").replace(".", "").replace(".", "").replace(".", ""))
        var unit = $(this).parent().parent().children(".nominal").children(".unit1").val()


        if(hargaberubah > hargaperlot ){
          hargaberubah = numberWithCommas(hargaberubah - hargaperlot)
          unit--
          $(this).parent().parent().children(".nominal").children(".unit1").val(unit)
          $(this).parent().parent().children(".nominal").children("#val1").text(hargaberubah)
          $(this).parent().children(".hargakirim").text(hargaberubah)


        }
        // $(this).parent().parent().children(".nominal").children("#val1").text("cek")

      });
       $(".plus-btn").click(function(){
        var hargaperlot = parseInt($(this).parent().parent().parent().parent().children(".perlotdiv").children(".hargalot").text())
        var hargaberubah = parseInt($(this).parent().parent().children(".nominal").children("#val1").text().replace(".", "").replace(".", "").replace(".", "").replace(".", ""))
        var hargamax = parseInt($(this).parent().parent().parent().parent().children(".perlotdiv").children(".jumlahpendanaan").text())
        var unit = $(this).parent().parent().children(".nominal").children(".unit1").val()
        var jumlahLot = parseInt($(this).parent().parent().children(".nominal").children(".jumlahlot").text());
        var sisaLot = parseInt($(this).parent().parent().children(".nominal").children(".sisalot").text());
        

        if(unit < sisaLot ){
          hargaberubah = numberWithCommas(hargaberubah + hargaperlot)
          unit++
          $(this).parent().parent().children(".nominal").children(".unit1").val(unit)
          $(this).parent().parent().children(".nominal").children("#val1").text(hargaberubah)
          $(this).parent().children(".hargakirim").text(hargaberubah)
          

        }

      });

       $(".unit1").change(function(){

         var hargaperlot = parseInt($(this).parent().parent().parent().parent().children(".perlotdiv").children(".hargalot").text())
          var hargaberubah = parseInt($(this).parent().parent().children(".nominal").children("#val1").text().replace(".", "").replace(".", "").replace(".", "").replace(".", ""))
          var hargamax = parseInt($(this).parent().parent().parent().parent().children(".perlotdiv").children(".jumlahpendanaan").text())
          var unit = $(this).val()
          var jumlahLot = parseInt($(this).parent().children(".jumlahlot").text());
          var sisaLot = parseInt($(this).parent().children(".sisalot").text());
          

          if(unit < 1 ){
              $(this).val(1);
              $(this).parent().children("#val1").text(numberWithCommas(hargaperlot*1));
              

          } 
          else if (unit > sisaLot){
              $(this).val(sisaLot);
              var totalUnit = numberWithCommas(hargaperlot*sisaLot)
              $(this).parent().children("#val1").text(totalUnit)
          }else{
               
               
                var totalUnit = numberWithCommas(hargaperlot*unit);
                $(this).parent().children("#val1").text(totalUnit);
                $(this).parent().parent().children(".tersedia").children(".hargakirim").text(totalUnit);
                

          }





        //   if(unit < 0){

        //   unit = 1;
        //   hargaberubah = hargaperlot
        //   $(this).val(unit);
          
        // }else if(hargaberubah < hargamax){

        //   $(this).val(unit);
        // }
        //   $(this).parent().parent().children(".nominal").children(".unit1").val(unit)
        //   $(this).parent().parent().children(".nominal").children("#val1").text(hargaberubah)
        //   $(this).parent().children(".hargakirim").text(hargaberubah)

          // alert($(this).val());


       })



    // show new container for data
    $('#new-list').insertBefore('#example');
    $('#new-list').show();
  },
  "rowCallback": function( row, data ) {
    // on each row callback
    var div = $(document.createElement('div'));
    div.addClass("col-lg-12");
    var a = $(document.createElement('a'));
    // a.attr("href", '<?= base_url("user/rinciDash") ?>'+"?id="+data[11]);
    a.css("color", 'black');
    // a.mouseover(function() {
    //   $(this).find(" > div").css("background-color","red");
    // }).mouseout(function() {
    //   $(this).find(" > div").css("background-color","transparent");
    // });
    a.css("text-decoration","none", "important")
    // var h = $(document.createElement("H2"));                // Create a <h1> element
    // h.addClass("text-center mt-5");
    // var t = $(document.createTextNode("Marketplace Enterprise"));     // Create a text node
    // h.append(t);                                   // Append the text to <h1>
    
    
    // div.append(h);



    var ul = $(document.createElement('div'));
    ul.addClass("card_holder mt-5");
    ul.attr('id', 'card');
if(data[2]){
     ul.prepend('<img class="card_holder_img" src="'+'<?= base_url('assets/img/profile/'); ?>'+data[2]+'" />');
    
    
}else{
     ul.prepend('<img class="card_holder_img" src="'+'<?= base_url('assets/img/'); ?>'+'noimage.png" />');
    
}

   

    var li = $(document.createElement('div'));

    li.addClass("card_holder_body");
    

    li.append('<h5 class="card-title">'+data[1]+'</h5>');

    var isi = $(document.createElement('div'));
    isi.addClass("row");

    var isisatu = $(document.createElement('div'));
    isisatu.addClass("col-lg-6 mt-1 perlotdiv");

    isisatu.append('<h5 class="card-title" style="color: green;font-size:16px"> Id Proyek: '+data[11]+'</h5>');
    if(parseInt(data[4])<=parseInt(data[3])){
        isisatu.append('<img style="display: inline-block;top: -36px;right: 7px;position: absolute;     width: 23%;" src="'+'<?= base_url('assets/img/'); ?>lunas.jpeg" />');
    }
    
    
    isisatu.append('<h5 class="card-title" style="font-size:16px; z-index: 70;position: inherit;"> Jumlah Pendanaan : Rp. '+numberWithCommas(data[4])+'</h5>');
    isisatu.append('<h5 class="card-title" style="font-size:16px"> Periode Deviden  : '+"6 Bulan"+'</h5>');
    // isisatu.append('<h5 class="card-title" style="font-size:16px"> Harga Per Lot : Rp. '+numberWithCommas(data[25])+'</h5>');
    // isisatu.append('<h5 class="card-title" style="font-size:16px"> Jasa Platform 5% </h5>');
    isisatu.append('<h5 class="card-title" style="font-size:16px">Estimasi Net Profit Rp. ' + numberWithCommas(data[14]*data[4]/100)+ ' </h5>');
    isisatu.append('<h5 style="display: none;" class="hidden hargalot">'+ data[25] + ' </h5>');
    isisatu.append('<h5 style="display: none;" class="hidden jumlahpendanaan">'+ data[4] + ' </h5>');
    
    var isidua = $(document.createElement('div'));
    isidua.addClass("col-lg-6 mt-1");
    isidua.append('<p style="color: black; margin-top: -57px; margin-bottom: 38px;float: left;">Profil Proyek : <span style="display: inline; padding: .2em .6em .3em; font-size: 75%; font-weight: 700; line-height: 1; color: #fff;    background-color: #5cb85c;text-align: center;white-space: nowrap;vertical-align: baseline;border-radius: .25em;">   <a style= "    color: white;" href="<?php echo base_url(); ?>assets/file_user/prospektus/'+data[19]+'" download> unduh </a>         </span></p>');
    
    isidua.append('<p style="color: black; margin-top: -57px; margin-bottom: 38px; float: right;">Kode Saham  : <span style="display: inline; padding: .2em .6em .3em; font-size: 75%; font-weight: 700; line-height: 1; color: #fff;    background-color: #5cb85c;text-align: center;white-space: nowrap;vertical-align: baseline;border-radius: .25em;">'+ data[24]+'</span></p>');
    isidua.append('<p style="clear: both"></p>')
    isidua.append('<p style="margin-bottom:0px;color:black; margin-top:0px;">Uang Terkumpul : <span style="float: right!important;"> Rp. '+numberWithCommas(data[3])+'</span> </p>')
    
    var isianbaru=0;
    if(data[23] >= 100){
        isianbaru = 100;
        
    }else{
        isianbaru = data[23];
    }
    
    isidua.append('<div class="progress" style="margin-bottom:5px;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style=" width:'+data[23].toFixed(2)+'%;"> '+isianbaru.toFixed(2)+'%</div></div>')
    
    
    isidua.append('<p style="margin-bottom:0px;color:black;">Sisa Waktu : <span style="float: right!important;">'+data[16]+' hari</span> </p>')
    isidua.append('<div class="progress" style="margin-bottom:7px;"><div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style=" width:'+data[17]+'%">'+data[18]+' hari </div></div>')

    var pendanaan = $(document.createElement('div'));
    pendanaan.addClass("row");

    var isipendanaan = $(document.createElement('div'));
    isipendanaan.addClass("col-lg-6 nominal");
    isipendanaan.append('<p style="color:black;     margin-bottom: 17px;">Nilai Pendanaan</p> <span id="val1" style="    padding: 5px;padding-top: 10px;padding-bottom: 8px; display: inline;font-size: 75%;font-weight: 700;line-height: 1;color: #fff; text-align: center;white-space: nowrap;vertical-align: baseline;border-radius: .25em;background-color: #f0ad4e;">'+numberWithCommas(data[25])+'</span> <input type="number" max="100" min="1" value="1" name="unit0" id="unit1" class="unit1" style="display: inline-block; width: 70px;padding: 5px; font-size: 14px; line-height: 1.65; color: #555; background-color: #fff; background-image: none; border: 1px solid #ccc; border-radius: 4px; transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;">')
    isipendanaan.append('<h5 style="display: none;" class="jumlahlot">'+ data[20] + ' </h5>');
    isipendanaan.append('<h5 style="display: none;" class="sisalot">'+ data[22] + ' </h5>');


    var tersedia = $(document.createElement('div'));
    tersedia.addClass("col-lg-6 tersedia");
    tersedia.append('<p class="tersedia" style="margin-bottom:0px;color: black">Lot Terjual/Tersedia</p><p style="font-size: 12px;color:black; margin-bottom: 0px">'+ (data[20]-data[22])+'/' + data[22]+ '</p> <button type="button" class="min-btn btn btn-success btn-md">-</button><button class="btnDanai btn btn-success btn-md"  type="button" style="margin-left:6px; margin-right:6px;">Danai</button><button type="button" class="plus-btn btn btn-success btn-md">+</button>')
    tersedia.append('<h5 style="display: none;" class="hidden idproj">'+ data[11] + ' </h5>');
    tersedia.append('<h5 style="display: none;" class="hidden hargakirim">'+ data[25] + ' </h5>');
    tersedia.append('<h5 style="display: none;" class="sisalot">'+ data[22] + ' </h5>');

    

// href="<?= base_url('user/formDanai')?>?id_project='+data[11]+'&nilai="

    isipendanaan.appendTo(pendanaan);
    tersedia.appendTo(pendanaan);
    
    pendanaan.appendTo(isidua);

    isisatu.appendTo(isi);
    isidua.appendTo(isi);

    isi.appendTo(li);
    li.appendTo(ul);
    ul.appendTo(a);
    a.appendTo(div);

    div.appendTo('#new-list');

  },
  "preDrawCallback": function( settings ) {
    // clear list before draw
    $('#new-list').empty();
  },
  "pageLength": 9
});

$('#example_length').hide();
$('#example_filter').hide();

})














///////////////////////////////////////////kedua
 $(document).ready(function(){
    // $('.rupiah').simpleMoneyFormat();
    $('#example2').dataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "columns": [
      { "title": "Engine" },
      { "title": "Browser" }
      ],
      "ajax": {
        url: "<?php echo base_url('user/ambil_data_all_retail') ?>",
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
    isisatu2.append('<h5 class="card-title mb-0" style="font-size:12px"> Periode Deviden  : '+"6 Bulan"+'</h5>');
    
    
    //   isisatu2.append('<h5 class="card-title mb-0" style="font-size:12px"> Periode Deviden : '+data[6]+'</h5>');

    isisatu2.append('<h5 class="card-title mb-0" style="font-size:12px">Estimasi Net Profit Rp. ' + numberWithCommas(data[20])+ ' </h5>');
     isisatu2.append('<h5 class="card-title mb-0" style="font-size:12px">Jumlah Kebutuhan ' + numberWithCommas(data[5])+ ' </h5>');
    
    
    
    
    isisatu2.append('<h5 style="display: none;" class="hidden hargalot2">'+ 1000000 + ' </h5>');
    isisatu2.append('<h5 style="display: none;" class="hidden jumlahpendanaan2">'+ data[16] + ' </h5>');
    isisatu2.append('<p style="margin-bottom:0px;color:black; font-size:12px; margin-top:0px;">Uang Terkumpul : </p>')
    isisatu2.append('<div class="progress" style="margin-bottom:5px;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style=" width:'+data[13]+'%;"> '+data[13]+'%</div></div>')
    isisatu2.append('<p style="margin-bottom:0px;color:black; font-size:12px;">Sisa Waktu : <span style="float: right!important;">berakhir pada '+data[7]+'</span> </p>')
    isisatu2.append('<div class="progress" style="margin-bottom:7px;"><div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style=" width:'+data[10]+'%">'+data[8]+' hari </div></div>')
    isisatu2.append('<h5 class="card-title" style="font-size:10px; margin-bottom:0px"> Jasa Platform 5% Rp. '+numberWithCommas(data[18])+' </h5>');
    isisatu2.append('<h5 class="card-title" style="font-size:10px; margin-bottom:0px"> Denom yang di terima Rp. '+numberWithCommas(data[19])+' </h5>');
    isisatu2.append('<h5 class="card-title" style="font-size:10px; margin-bottom:0px"> Pengembalian Dana Rp. '+numberWithCommas(data[21])+' </h5>');
    
  
   
    var pendanaan2 = $(document.createElement('div'));
    pendanaan2.addClass("row");
    
    var nilai_loop = "ini";
    
    for(var k = 0; k < (data[5]-data[11])/1000000-data[16]/1000000; k++){
        nilai_loop = nilai_loop + " <option value='"+(k+1)+"000000'>Rp. "+(k+1)+".000.000</option> ";
        
    }

    
    var isipendanaan2 = $(document.createElement('div'));
    isipendanaan2.addClass("col-lg-6 nominal2");
    isipendanaan2.append('<p style="color:black;     margin-bottom: 17px; font-size:12px;">Nilai Pendanaan</p>  \n'
    + ' <select id="cars" name="unit0" id="unit12" class="unit12" \n'
    + ' style="display: inline-block; font-size:12px;padding: 5px; font-size: 14px; line-height: 1.65; color: #555; \n'
    + ' background-color: #fff; background-image: none; border: 1px solid #ccc; border-radius: 4px; ">' + nilai_loop + ' </select>')
    isipendanaan2.append('<h5 style="display: none;" class="jumlahlot2">'+ data[20] + ' </h5>');
    isipendanaan2.append('<h5 style="display: none;" class="sisalot2">'+ data[22] + ' </h5>');


    var tersedia2 = $(document.createElement('div'));
    tersedia2.addClass("col-lg-6");
    tersedia2.append('<p class="tersedia" style="font-size:12px; margin-bottom:0px;color: black">Terdanai</p><p style="font-size: 12px;color:black; margin-bottom: 0px">'+ data[16]+'/' + data[5]/1000000+ '</p> ')
    if(data[11]!=data[5]){
        tersedia2.append('<button class="btnDanai2 btn btn-success btn-md"  type="button" style="font-size:12px;margin-left:6px; margin-right:6px;">Danai</button>');
    }else{
        tersedia2.append('<button class="btnDanai2 btn btn-success btn-md"  type="button" style="font-size:12px;margin-left:6px; margin-right:6px;     background-color: grey; border: none;" disabled>Danai</button>');
    }
    
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



















</script>