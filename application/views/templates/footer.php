<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">

      <span>Copyright &copy; fulusme.id <?php echo date("Y"); ?></span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Logout?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Apakah anda yakin akan keluar?</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
        <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Ya</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<!-- Logout Otomatis -->
<script>
  let log_off = new Date();
  log_off.setSeconds(log_off.getSeconds() + 300)
  log_off = new Date(log_off)

  let int_logoff = setInterval(function() {
    let now = new Date();
    if (now > log_off) {
      window.location.assign("<?= base_url() ?>auth/logout");
      clearInterval(int_logoff);
    }
  }, 5000);

  $('body').on('click', function() {
    log_off = new Date();
    log_off.setSeconds(log_off.getSeconds() + 300)
    log_off = new Date(log_off)
  })
</script>

<script type="text/javascript">
  $('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("Selected").html(fileName);
  });




  $('.access_role').on('click', function() {

    const menuId = $(this).data('menu');
    const roleId = $(this).data('role');

    $.ajax({
      url: "<?= base_url('admin/changeaccess'); ?>",
      type: 'post',
      data: {
        menuId: menuId,
        roleId: roleId

      },
      success: function() {
        document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
      }

    });
  });
</script>


<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
<script src="<?= base_url('assets/'); ?>js/change.js"></script>

<script type="text/javascript">
  var deadline = $('#deadline').change(function() {
    // alert($('#deadline').val());
    // moment($('#deadline').val()).subtract(10, 'days').calendar()

    m = moment($('#deadline').val(), 'DD/MM/YYYY');
    var tanggalAkhir = m.add($('#range').val(), 'days');

    $('#akhir').val(tanggalAkhir.format('DD/MM/YYYY'));
  });


  var range = $('#range').change(function() {
    // alert($('#deadline').val());
    // moment($('#deadline').val()).subtract(10, 'days').calendar()

    m = moment($('#deadline').val(), 'DD/MM/YYYY');
    var tanggalAkhir = m.add($('#range').val(), 'days');

    $('#akhir').val(tanggalAkhir.format('DD/MM/YYYY'));
  });



  // $('#akhir').val("hai");


  $('#keuntungan').on('input', function() {
    var value = $(this).val();
    if ((value !== '') && (value.indexOf('.') === -1)) {
      $(this).val(Math.max(Math.min(value, 100), 0));
    }
  });
  $('#range').on('input', function() {
    var value = $(this).val();
    if ((value !== '') && (value.indexOf('.') === -1)) {
      $(this).val(Math.max(Math.min(value, 500), 0));
    }
  });



  $('#keuntungan').on('input', function() {

    if ($('#modal_project').val() && $('#keuntungan').val()) {

      $nominal = (parseInt($('#keuntungan').val()) / 100) * parseInt($('#modal_project').val().replace(".", "").replace(".", "").replace(".", ""));
      $('#nominal_keuntungan').text("Keuntungan untuk Pendana : Rp. " + $nominal.toLocaleString("id-ID"))

    } else {
      $('#nominal_keuntungan').text("Keuntungan untuk Pendana : Rp.");

    }


  });


  $('#provinsi').on('change', function() {
    $("#kota").empty();
    var provinsi = $('#provinsi :selected').val();
    var data = {
      province: provinsi
    };
    $.ajax({
      type: 'post',
      url: "<?= base_url('user/setkota'); ?>",
      data: data,
      success: function(result) {
        var kota = JSON.parse(result);
        for (var i = 0; i < kota.length; i++) {
          $("select#kota").append($("<option>")
            .val(kota[i].name)
            .html(kota[i].name)
          );
        }
      }
    });
  });


  $(document).ready(function() {

    $("#modal_project").change(function() {
      var nilaiii = $("#modal_project").val();
      if (nilaiii > 2000000000) {

        $("#modal_project").val('2.000.000.000');
      } else {
        var inputt = parseInt(nilaiii, 0).toLocaleString("id-ID");
        $("#modal_project").val(inputt);
      }
      // alert($("#modal_project").val());
    });

    //           $("#modal_project").on( "keyup", function( event ) {

    //     // 1.
    //     var selection = window.getSelection().toString();
    //     if ( selection !== '' ) {
    //       return;
    //     }

    //     // 2.
    //     if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
    //       return;
    //     }
    //     // 1
    //     var $this = $( this );
    //     var input = $this.val();


    // // 2
    // var input = input.replace(/[\D\s\._\-]+/g, "");

    // // // 3
    // input = input ? parseInt( input, 0 ) : 0;

    // // // 4



    // $this.val( function() {
    // //   return alert(this.val());
    //   return ( input < 2000000000 ) ? ( input === 0 ) ? "" : input.toLocaleString( "id-ID" ) : input = "2.000.0000.000";
    // } );






    // } );



    var date_input = $('#deadline'); //our date input has the name "date"
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    var options = {
      format: 'dd/mm/yyyy',
      container: container,
      toggleActive: true,
      beforeShowDay: function(date) {
        //  if (date == myDate) {
        return [true, 'css-class-to-highlight', 'tooltipText'];

        //   }
      },
      autoclose: true,
      startDate: moment().add(19, 'days')._d
    };
    date_input.datepicker(options);
  })
</script>



</body>

</html>