<script>
	 $( "#dialog_mut_aset:ui-dialog" ).dialog( "remove" );
    $("#dialog_mut_aset").dialog({
            autoOpen: false,
			title: "MUTASI ASET",
			 width: "40%",
        });
       // $(".btnShow").live("click",function(){
        $('body').on('click', '#btnShowasetmut', function(){
          var asetID = $(this).attr("asetID");
          var asetlocID = $(this).attr("asetlocID");
		   var asetCode = $(this).attr("asetCode");
          var asetName = $(this).attr("asetName");
    	
    	   $('#asetID').val(asetID);
       	  $('#asetlocID').val(asetlocID);
		    $('#asetCode').val(asetCode);
       	  $('#asetName').val(asetName);
          $('#dialog_mut_aset').dialog('open');
          return false;
        });
</script>

<script>
	 $( "#dialog_additem_prod:ui-dialog" ).dialog( "remove" );
    $("#dialog_additem_prod").dialog({
            autoOpen: false,
			title: "RENCANA PRODUKSI",
			 width: "40%",
        });
       // $(".btnShow").live("click",function(){
        $('body').on('click', '#btnShowproduksi', function(){
          var produkID = $(this).attr("produkID");
          var produkName = $(this).attr("produkName");
    	
    	   $('#produkID').val(produkID);
       	  $('#produkName').val(produkName);
          $('#dialog_additem_prod').dialog('open');
          return false;
        });
</script>

<script>
	 $( "#dialog_dis_paket:ui-dialog" ).dialog( "remove" );
    $("#dialog_dis_paket").dialog({
            autoOpen: false,
			title: "DISTRIBUSI PAKETAN",
			 width: "40%",
        });
       // $(".btnShow").live("click",function(){
        $('body').on('click', '#btnDisPak', function(){
          var paketID = $(this).attr("paketID");
          var paketname = $(this).attr("paketname");
    	
    	   $('#paketID').val(paketID);
       	  $('#paketname').val(paketname);
          $('#dialog_dis_paket').dialog('open');
          return false;
        });
</script>


<script>

    $(function () {
      $("#example1").DataTable({          
        "language": {
          "url": "<?php echo base_url(); ?>assets/plugins/datatables/Indonesian.json",
          "sEmptyTable": "Tidak ada data di database"
        }
      });
    });
    $(function () {
      $("#example2").DataTable({          
        "language": {
          "url": "<?php echo base_url(); ?>assets/plugins/datatables/Indonesian.json",
          "sEmptyTable": "Tidak ada data di database"
        }
      });
    });
    $(function() {
      $( "#tgl_surat" ).datepicker({ 
        autoclose: true 
      });
    });
</script>
<script>
    $('#terminpjdate').datepicker({
      dateFormat: 'yy-mm-dd'
    });
    $('#tgllahir').datepicker({
      dateFormat: 'yy-mm-dd'
    });
    
    $('#diskondatestop').datepicker({
      dateFormat: 'yy-mm-dd'
    });
    $('#diskondatestart').datepicker({
      dateFormat: 'yy-mm-dd'
    });
    
    $('#promodatestart').datepicker({
      dateFormat: 'yy-mm-dd'
    });
    $('#promodatestop').datepicker({
      dateFormat: 'yy-mm-dd'
    });
</script>
<script>
    $('#idenhead').hide();
    $('#termindate').hide();
    $('#memberaddtrx').hide();
    $('#proyekaddtrx').hide();
    $('#kantorcabang').hide();
    $('#promodiv').hide();
    $('#is_pertama').hide();
    $('#cekbarangaddjustdiv').hide();
    
    
    $('#identitytype').on('change', function() {
      if($(this).val() == '1') {
       $('#idenhead').slideDown('slow');
       $('#divpemilik').show();
       $('#idenhead').hide();
     } else {
       $('#idenhead').slideDown('slow');
       $('#idenhead').show();
       $('#divpemilik').hide();
     }
    });
    
    
    $('#jenisbayar').on('change', function() {
      if($(this).val() == '1') {
       $('#is_pertama').show();
        $('#is_pertama').slideDown('slow');
     } else {
       $('#is_pertama').hide();
     }
    });
    
    $(document).ready(function(){
        $('#cekbarangaddjust').change(function(){
            if(this.checked)
                $('#cekbarangaddjustdiv').fadeIn('slow');
            else
                $('#cekbarangaddjustdiv').fadeOut('slow');
    
        });
    });
    
    $('#kantorlevel').on('change', function() {
      if($(this).val() == '1') {
       $('#kantorcabang').hide();
     } else {
       $('#kantorcabang').slideDown('slow');
       $('#kantorcabang').show();
     }
    });
    
    $('#identitytype').on('change', function() {
      if($(this).val() == '1') {
       $('#termindate').slideDown('slow');
       $('#termindate').hide();
     } else {
       $('#termindate').slideDown('slow');
       $('#termindate').show();
     }
    });
    $('#showmembertrx').on('click', function() {
     $('#memberaddtrx').slideDown('slow');
     $('#memberaddtrx').togle();
    
    });
    
    $('#tipebayar').on('change', function() {
      if($(this).val() == '1') {
       $('#termindate').slideDown('slow');
       $('#termindate').hide();
     } else {
       $('#termindate').slideDown('slow');
       $('#termindate').show();
     }
    });
    
    $('#showproyektrx').on('click', function() {
     $('#proyekaddtrx').slideDown('slow');
     $('#proyekaddtrx').togle();
    
    });
    
    $('#banktipe').hide();
    $('#tipebank').on('change', function() {
      if($(this).val() == 'tunai') {
       $('#banktipe').slideDown('slow');
       $('#banktipe').hide();
     } else {
       $('#banktipe').slideDown('slow');
       $('#banktipe').show();
     }
    });
    
    $('#tipepromo').on('change', function() {
      if($(this).val() == '1') {
       $('#promodiv').hide();
     } else {
       $('#promodiv').slideDown('slow');
       $('#promodiv').show();
     }
    });
    $("#tipepromo").trigger("change");
    $("#promo_get_type").change(function(){
    	 var promo_type = $("#promo_get_type").val();		
    	 if(promo_type==1){
    		 $("#promo_produk_gratis").show();
    		 $("#promo_diskon").hide();
    	 }else if(promo_type==2){
    		 $("#promo_produk_gratis").hide();
    		 $("#promo_diskon").show();
    	 }
     })
     $("#promo_get_type").trigger("change");
</script>

<script>
    $( "#dialog:ui-dialog" ).dialog( "remove" );
       // $(".btnShow").live("click",function(){
        $('body').on('click', '.btnShow', function(){
          var ideditpro = $(this).attr("ideditpro");
          var editmemberid = $(this).attr("editmemberid");
          var nampro = $(this).attr("nampro");
          var harpro = $(this).attr("harpro");
          var qtypro = $(this).attr("qtypro");
          var bonus = $(this).attr("bonus");
          var productbarcode = $(this).attr("productbarcode");
    
          $('#productbarcode').val(productbarcode);
          $('#ideditpro').val(ideditpro);
          $('#editmemberid').val(editmemberid);
          $('#nampro').val(nampro);
          $('#harpro').val(harpro);
          $('#harpro').number( true, 0 );
          $('#qtypro').val(qtypro);
          $('#bonus').val(bonus);
          $('#dialog').dialog('open');
          return false;
        });
</script>


<script>
    $(function () {
      $("#dialog").dialog({
        modal: true,
        autoOpen: false,
        title: "Edit Transaksi"
      });
    });
</script>



<script>
    $( "#dialogcek:ui-dialog" ).dialog( "remove" );
       // $(".btnShow").live("click",function(){
        $('body').on('click', '.btnShowcek', function(){
          var ideditpro = $(this).attr("ideditpro");
          var editmemberid = $(this).attr("editmemberid");
          var nampro = $(this).attr("nampro");
          var harpro = $(this).attr("harpro");
          var qtypro = $(this).attr("qtypro");
          var bonus = $(this).attr("bonus");
          var productbarcode = $(this).attr("productbarcode");
    	   var identityID = $(this).attr("identityID");
    	   
          $('#identityID').val(identityID);
          $('#productbarcode').val(productbarcode);
          $('#ideditpro').val(ideditpro);
          $('#editmemberid').val(editmemberid);
          $('#nampro').val(nampro);
          $('#harpro').val(harpro);
          $('#harpro').number( true, 0 );
          $('#qtypro').val(qtypro);
          $('#bonus').val(bonus);
          $('#dialogcek').dialog('open');
          return false;
        });
</script>


<script>
    $(function () {
      $("#dialogcek").dialog({
        modal: true,
        autoOpen: false,
		 width: "40%",
        title: "Cek Barang Masuk"
      });
    });
</script>

<script>
    $(function () {
      $("#dialogret").dialog({
        modal: true,
        autoOpen: false,
		width: "30%",
        title: "RETUR PEMBELIAN"
      });
    });
</script>

<script>
    $( "#dialogret:ui-dialog" ).dialog( "remove" );
       // $(".btnShow").live("click",function(){
        $('body').on('click', '.btnShowret', function(){
          var detailID = $(this).attr("detailID");
          var bahanName = $(this).attr("bahanName");
          var detailBuyQty = $(this).attr("detailBuyQty");
          var productbarcode = $(this).attr("productbarcode");
    	  var bahanID = $(this).attr("bahanID");
    
          $('#productbarcode').val(productbarcode);
          $('#ideditpro').val(detailID);
          $('#namabahan').val(bahanName);
    	  $('#bahanID').val(bahanID);
          $('#qtypro').val(detailBuyQty);
          $('#dialogret').dialog('open');
          return false;
        });
</script>



<script>
    $(function () {
      $("#kodebarang").autocomplete({    
        minLength:0,
        delay:0,
        source:'<?php echo site_url('auto/get_produk'); ?>',   
        select:function(event, ui){
          $('#nama').val(ui.item.nama);
          $('#kdproduk').val(ui.item.kdproduk);
          $('#stokproduk').val(ui.item.stokproduk);
        }
      });
    
    $("#kodebarangpromo").autocomplete({    
        minLength:0,
        delay:0,
        source:'<?php echo site_url('auto/get_produk'); ?>',   
        select:function(event, ui){
		  $('#productSelect').val($('#productSelect').val()+","+ui.item.kdproduk);
		  $('.productSelect').html($('#productSelect').val());
          $('#kdproduk').val(ui.item.kdproduk);
          $('#stokproduk').val(ui.item.stokproduk);
        }
      });
	  $("#promo_product_get").autocomplete({    
        minLength:0,
        delay:0,
        source:'<?php echo site_url('auto/get_produk'); ?>',   
        select:function(event, ui){
          $('#promo_product_get_barcode').val(ui.item.kdproduk);
        }
      });
    
    
    $("#kodebahan").autocomplete({    
        minLength:0,
        delay:0,
        source:'<?php echo site_url('auto/get_bahan'); ?>',   
        select:function(event, ui){
          $('#nama').val(ui.item.nama);
          $('#kdbahan').val(ui.item.idbahan);
		  $('#kdproduk_ret').val(ui.item.bahanBarcode);
          $('#stokbahan').val(ui.item.stokbahan);
        }
      });
	  
	   $("#kodebahan_so").autocomplete({    
        minLength:0,
        delay:0,
        source:'<?php echo site_url('auto/get_bahan_so'); ?>',   
        select:function(event, ui){
          $('#nama').val(ui.item.nama);
          $('#kdproduk').val(ui.item.idbahan);
		  $('#kdproduk_ret').val(ui.item.bahanBarcode);
          $('#stokbahan').val(ui.item.stokbahan);
        }
      });
	  
	   $("#pengguna_auto").autocomplete({    
        minLength:0,
        delay:0,
        source:'<?php echo site_url('auto/get_pengguna'); ?>',   
        select:function(event, ui){
          $('#userid').val(ui.item.userid);
        }
      });
	  
	   $("#kodebahaninv").autocomplete({    
        minLength:0,
        delay:0,
        source:'<?php echo site_url('auto/get_bahan'); ?>',   
        select:function(event, ui){
          $('#nama').val(ui.item.nama);
          $('#kdbahan').val(ui.item.idbahan	);
          $('#stokbahan').val(ui.item.stokbahan);
        }
      });
	  
	$("#nmspp").autocomplete({    
        minLength:0,
        delay:0,
        source:'<?php echo site_url('auto/get_supplier'); ?>',   
        select:function(event, ui){
		  $('#supplierID').val(ui.item.supplierID);
		  $('#supplierName').val(ui.item.supplierName);
          $('#supplierAddress').val(ui.item.alamatkirim);
		  $('#supplierCPHp').val(ui.item.cp);
		  $('#supplieremail').val(ui.item.email);
		  debugger;
        }
      });
	  
	  $("#nopo").autocomplete({    
        minLength:0,
        delay:0,
        source:'<?php echo site_url('auto/get_tagihan'); ?>',   
        select:function(event, ui){
		  $('#invoiceID').val(ui.item.invoiceOrderID);
          $('#supplier').val(ui.item.trxFullName);
		  $('#jumlahtagihan').val(ui.item.trxTotal);
		  $('#jumlahbayar').val(ui.item.trxTotal);
		  $('#jatuhtempoo').val(ui.item.trxTerminDate);
		  debugger;
        }
      });
	  
      $('#warningstok').hide();
      $('#qty').on('keyup',function(){

       var qty = parseInt($('#qty').val(),10);
       var stok = parseInt($('#stokproduk').val(),10);
       if (qty > stok) {
         $('#warningstok').show();
         $("#submittambahproduk").attr("disabled", true);
       }
       else
       {
         $('#warningstok').hide();
         $("#submittambahproduk").attr("disabled", false);
       }
     });
    });

    $(function () {
      $("#kodemember").autocomplete({  
        minLength:0,
        delay:0,
        source:'<?php echo site_url('auto/get_member'); ?>',   
        select:function(event, ui){
         $('#idmember').val(ui.item.idmember);
         $('#namamember').val(ui.item.nama);
         $('#alamat').val(ui.item.alamat);
         $('#telp').val(ui.item.telp);

       }
     });

      $("#kodeproyek").autocomplete({  
        minLength:0,
        delay:0,
        source:'<?php echo site_url('auto/get_proyek'); ?>',   
        select:function(event, ui){
         $('#idproyek').val(ui.item.idproyek);
         $('#namaproyek').val(ui.item.namaproyek);
         $('#alamatproyek').val(ui.item.alamatproyek);
         $('#telpproyek').val(ui.item.telpproyek);

       }
     });

    });
</script>
<script>
    function parseCurrency( num ) {
      return parseFloat( num.replace( /,/g, '') );
    }

    $(function(){
        // Set up the number formatting.
        
        $('#bayar').on('change',function(){
          console.log('Change event.');
          var val = $('#bayar').val();
          $('#kembali').text( val !== '' ? val : '(empty)' );
        });
        
        $('#bayar').change(function(){
          console.log('Second change event...');
        });
        
        $('#bayar').number( true, 0 );
        
        
        
        $('#bayar').on('keyup',function(){
          
          var bayar = $('#bayar').val();
          var total = $('#total').val();
          var val=parseCurrency(bayar)-parseCurrency(total);
          $("#kembali").val(val);
          $("#kembali").number( true, 0 );
          
        });

      });
</script>

<script>
    $(document).ready(function() {
        $("#btnpot_harga").click(function(){
    		 $('#pot_harga').number( true, 0 );
             var pot_harga = $('#pot_harga').val();
              var total = $('#total').val();
              var val=parseCurrency(total)-parseCurrency(pot_harga);
              $("#total").val(val);
              $("#total").number( true, 0 );
        }); 
    });
</script>
<script>
    $(document).ready(function() {
        $("#btnpot_disc").click(function(){
             var disc_harga = $('#disc_harga').val();
              var total = $('#total').val();
              var val=parseCurrency(total)-(disc_harga*parseCurrency(total))/100;
              $("#total").val(val);
              $("#total").number( true, 0 );
        }); 
    });
</script>

<script>
    $(document).ready(function() {
      $("#formtrxid").validate({
        rules:{ 
         kodeproduk:"required",
         bayar:{required:true,number: true},
         qty:{required:true,number: true}
       },
       messages:{ 
        kodeproduk:{required:'Tidak Boleh Kosong'},
        bayar:{
          required:'Tidak Boleh Kosong',
          number  :'Hanya boleh di isi Angka'},
          qty:{
            required:'Tidak Boleh Kosong',
            number  :'Hanya boleh di isi Angka'},
            
          },
          success: function(label) {
            label.text('').addClass('valid');}
          });
    });
</script>
<script>
    $('#qty').on('keyup',function(){

     var valqty = $('#qty').val();
     $("#qtyremove").val(valqty);

   });
</script>

<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- datepicker -->
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<!-- Webcam       -->

</body>

</html>