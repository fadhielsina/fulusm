<!-- Begin Page Content -->
<div class="container-fluid ">
  <div class="container-fluid ">
    <div class="row justify-content-md-center">
      <div class="shadow col-lg-6" style="padding-left: 30px;margin-bottom: 50px;">
        <div class="row" style="margin-top: 20px; padding: 0px 10px ; padding-bottom: 20px;">
          <div class="col-lg">
            <h6>Anda akan membeli efek di proyek ini:</h6>
            <h3><b><?= $project[0]["nama_project"] . " <br> Id Proyek : " . $id_p ?></b></h3>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-md-center" style="margin-top: -27px;">
      <div class="shadow col-lg-6" style="padding-left: 30px;margin-bottom: 50px;">
        <div style="margin-top: 50px; padding: 50px 10px ; padding-top: 0px;">
          <form method="post" action="<?= base_url('user/ ') ?>">
            <div class="form-group">

              <p>Jumlah Dana yang dibayarkan</p>
              <p style="color: black"> Rp. <?= $dana_koma ?></p>
              <small class="danai" style="color: #333;">jumlah dana yang diperlukan : <?= number_format($project[0]["modal_project"]) ?></small>
              <br>
              <small class="keuntungan" style="color: #5142d0;"></small>
            </div>
            <div> <img src="<?= base_url('assets/img/danamon.png'); ?>" width="50px">
              <p><?php echo $va  ?></p>
            </div>

            <small style="color: #333; display: block; margin-bottom: 20px"><?= $message; ?></small>


            <button class="btn btn-primary " type="submit"> Kembali ke Marketplace </button>
          </form>

          <!-- /.container-fluid -->
        </div>
      </div>
    </div>


  </div>
  <!-- End of Main Content -->
  <!-- Modal Approve-->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.js"></script>
  <script type="text/javascript">
    const myOptions = {
      digitGroupSeparator: '.',
      decimalCharacter: ',',
      maximumValue: <?= $project[0]["modal_project"] ?>,
      minimumValue: '0',
      decimalPlaces: '0',
      currencySymbol: 'Rp. '
    };
    new AutoNumeric('#jumlah_dana', myOptions);
  </script>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>


  <script type="text/javascript">
    function setInputFilter(textbox, inputFilter) {
      ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
          if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
          } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
          }
        });
      });
    }

    $(document).ready(function() {


      function formatMoney(n, c, d, t) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
          d = d == undefined ? "." : d,
          t = t == undefined ? "," : t,
          s = n < 0 ? "-" : "",
          i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
          j = (j = i.length) > 3 ? j % 3 : 0;

        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
      };

      $(".danai").text("jumlah dana yang diperlukan Rp. " + formatMoney(<?= $project[0]["modal_project"] ?>));
      $('#jumlah_dana').change(function() {
        $(".keuntungan").text("Keuntungan : Rp. " + formatMoney(<?= $project[0]["modal_project"] ?>));
        // $(".keuntungan").text("Keuntungan : Rp. "+ Number($('#jumlah_dana').val().replace(/[^0-9\.-]+/g,"")));
        var inputdana = $('#jumlah_dana').val().split(" ")[1].replace(/[^0-9\-]+/g, "");
        var modal = <?= $project[0]["modal_project"] ?>;
        var keuntungan = inputdana / modal * <?= $project[0]["keuntungan"] ?>;

        var nominalkeuntungan = keuntungan / 100 * modal;
        $(".keuntungan").text("Keuntungan : Rp. " + formatMoney(nominalkeuntungan));


      });


      // setInputFilter(document.getElementById("jumlah_dana"), function(value) {
      //   return /^-?\d*$/.test(value);
      // });

      $('#jumlah_dana').on('input', function() {
        var value = $(this).val();
        if ((value !== '') && (value.indexOf('.') === -1)) {
          $(this).val(Math.max(Math.min(value, 2000000000), 0));
        }
      });

      $('#approveModal').on('show.bs.modal', function(e) {
        var id = $(e.relatedTarget).data('role');
        var name = $(e.relatedTarget).data('name');
        var data = {
          id: id
        };
        $.ajax({
          type: 'post',
          url: "<?= base_url('fund/app'); ?>",
          data: data,
          success: function(data) {
            $(e.currentTarget).find('input[name="id"]').val(id);
            $(e.currentTarget).find('input[name="title"]').val("Project " + name);
          }
        })
      })
    })
  </script>