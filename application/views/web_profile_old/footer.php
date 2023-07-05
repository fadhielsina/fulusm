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
        <a class="btn btn-primary" href="<?= base_url('auth/logout')?>">Ya</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/');?>vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url('assets/');?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/');?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/');?>js/sb-admin-2.min.js"></script>

<script type="text/javascript">

  $('.custom-file-input').on('change', function(){
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("Selected").html(fileName);
  });




  $('.access_role').on('click', function(){

    const menuId = $(this).data('menu');
    const roleId = $(this).data('role');

    $.ajax({
      url: "<?= base_url('admin/changeaccess');?>",
      type: 'post',
      data: {
        menuId: menuId,
        roleId: roleId

      },
      success: function(){
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
<script src="<?= base_url('assets/');?>js/change.js"></script>

<script type="text/javascript">

  var deadline = $('#deadline').change(function() {
              // alert($('#deadline').val());
              // moment($('#deadline').val()).subtract(10, 'days').calendar()

              m = moment($('#deadline').val(), 'YYYY/MM/DD');
              var tanggalAkhir = m.add($('#range').val(), 'days');

              $('#akhir').val(tanggalAkhir.format('YYYY/MM/DD'));
            });


  var range = $('#range').change(function() {
              // alert($('#deadline').val());
              // moment($('#deadline').val()).subtract(10, 'days').calendar()

              m = moment($('#deadline').val(), 'YYYY/MM/DD');
              var tanggalAkhir = m.add($('#range').val(), 'days');

              $('#akhir').val(tanggalAkhir.format('YYYY/MM/DD'));
            });



          // $('#akhir').val("hai");


          $('#keuntungan').on('input', function () {
            var value = $(this).val();
            if ((value !== '') && (value.indexOf('.') === -1)) {
             $(this).val(Math.max(Math.min(value, 100), 0));
           }
         });
          $('#range').on('input', function () {
            var value = $(this).val();
            if ((value !== '') && (value.indexOf('.') === -1)) {
             $(this).val(Math.max(Math.min(value, 500), 0));
           }
         });
          $('#modal_project').on('input', function () {
            var value = $(this).val();
            if ((value !== '') && (value.indexOf('.') === -1)) {
             $(this).val(Math.max(Math.min(value, 2000000000), 0));
           }
         });
          $('#nilai_project').on('input', function () {
            var value = $(this).val();
            if ((value !== '') && (value.indexOf('.') === -1)) {
             $(this).val(Math.max(Math.min(value, 2000000000), 0));
           }
         });
          $('#keuntungan').on('input', function() {

            if($('#nilai_project').val() && $('#keuntungan').val()){
              $nominal =  (parseInt($('#keuntungan').val())/100)*parseInt($('#nilai_project').val());
              $('#nominal_keuntungan').text("Keuntungan = Rp. "+ $nominal)

            }else{
              $('#nominal_keuntungan').text("Keuntungan : Rp.");

            }


          });


          $('#nilai_project').on('input', function() {

            if($('#nilai_project').val() && $('#keuntungan').val()){
              $nominal =  (parseInt($('#keuntungan').val())/100)*parseInt($('#nilai_project').val());
              $('#nominal_keuntungan').text("Keuntungan = Rp. "+ $nominal);

            }else{
              $('#nominal_keuntungan').text("Keuntungan : Rp.");
            }


          });







          $('#provinsi').on('change', function() {
            $("#kota").empty();
            var provinsi = $('#provinsi :selected').val();
            var data={province:provinsi};
            $.ajax({
              type : 'post',
              url : "<?= base_url('user/setkota'); ?>",
              data: data,
              success: function(result){
                var kota = JSON.parse(result);
                for(var i = 0; i < kota.length; i++){
                  $("select#kota").append( $("<option>")
                    .val(kota[i].name)
                    .html(kota[i].name)
                    );
                }
              }
            });
          });


          $(document).ready(function(){

              var date_input=$('#deadline'); //our date input has the name "date"
              var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
              var options={
                format: 'yyyy/mm/dd',
                container: container,
                todayHighlight: true,
                autoclose: true,
                startDate: new Date()
              };
              date_input.datepicker(options);
            })
          </script>



        </body>

        </html>
