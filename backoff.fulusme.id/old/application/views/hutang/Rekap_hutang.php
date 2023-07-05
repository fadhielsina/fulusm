
<?php
echo "<div id='error' class='error-message' ";
if($this->session->userdata('ERRMSG_ARR'))
{
  echo ">";
  echo $this->session->userdata('ERRMSG_ARR');
  $this->session->unset_userdata('ERRMSG_ARR');
}
else
{
  echo "style='display:none'>";
}
echo "</div>";
$data['class'] = 'input'; 

?>
<style type="text/css">
  .tabelItems {
    font-size: 12px;
    font-family: arial, sans-serif;
    border-collapse: collapse;
    border-spacing: 0;
    margin-top: 10px;
    width: 90%;
}

</style>

<div class="card" style="padding-top:25px">
<div class="card-body" style="padding-top:30px">
<div class="post-title" style="margin-top: 20px;">
<h4 class="card-title"><?php echo $title ?></h4>
</div>
  <form id="form_laporan" method="POST"> 
  <?php echo form_hidden('nama_laporan', $nama_laporan); ?>
  <table  cellpadding="2" cellspacing="0" style="width:100%;height: auto;">         
    <tr>
      <th><?php echo form_label('Jenis Laporan','jenis_laporan'); ?></th>
      <td>
        <?php 
          $data['id'] = 'jenis_laporan';
          $data['class'] = "form-control";
          $selected = 'laporan_neraca';
          $options = array( 'laporan_harian' => 'Harian',
                      'laporan_bulanan' => 'Bulanan'
                    );
          echo form_dropdown('jenis_laporan', $options, $selected, $data);
        ?>          
      </td>
    </tr>   
    <tr>
      <th><?php echo form_label('Tgl Laporan','tgl_laporan'); ?></th>
      <td >
        <div class="input-daterange input-group" id="datepicker" >
            <input type="text" class="input-sm form-control" name="start" />
            <span class="input-group-addon">to</span>
            <input type="text" class="input-sm form-control" name="end" />
        </div>
      </td>
    </tr>
  </table>
  </form>
  <div class="buttons">
    <?php
      echo form_button(array('id' => 'button-save', 'content' => 'Buat Laporan'));
      echo form_button('reset','Reset', "id = 'button-reset'" );
    ?>
  </div>
</div>
</div>
<div id="content_area">
  
</div>


<script type="text/javascript" charset="utf-8">
  $(function() {
    $('#button-save').click(function() {
      var jenis_laporan = $('#jenis_laporan').val();
      var bulan = $('#bulan').val();
      var tahun = $('#tahun').val();

      $.post("<?php echo site_url()."laporan/"?>"+jenis_laporan,$("#form_laporan").serialize(),function(result){
        $("#content_area").html(result);
      });
      //location.href = '<?php echo site_url();?>laporan_keuangan/'+jenis_laporan+'/'+bulan+'/'+tahun;
    });
  });
  
    $('.input-daterange').datepicker({
       orientation: "bottom left"
  });

</script>



<div class="card" style="padding-top:25px">
<div class="card-body" style="padding-top:30px">

<table border="0" style="border-collapse:collapse; border-spacing:10px;width:100%">

    <colgroup><col style="width: 15%;vertical-align:top;">

    <col style="width: 65%">

    <col style="width: 20%">
        </colgroup><tbody><tr>

            <td rowspan="4" style="vertical-align:top;">

                <div id="logo">

                 <img src="<?php echo base_url().'assets/img/logo_katingan.jpg' ?>" alt="Logo" width="85" height="90">

                </div>

            </td>

            <td style="text-align:center;font-size:18px;"><b>PEMERINTAH KABUPATEN KATINGAN</b></td>

            <td rowspan="4" style="margin:auto;vertical-align:top;">

                <div id="kode">Buku Bantu Hutang (Detail)</div>            

            </td>

            </tr>
        <tr>
            <td style="text-align:center;font-size:20px;"><b>KABUPATEN KATINGAN</b></td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:18px;"><b>RSUD KASONGAN</b></td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:14px;">JL. Rumah Sakit, No.01</td>

        </tr>
</tbody></table>

<hr>
    <div style="color:red;font-family:arial;font-size:13px;border-style:none;text-align: center;font-weight: bold;margin-bottom:3px;">BUKU BANTU HUTANG (DETAIL)</div>

      
     <table class="content" style="min-height:0 !important">
        <tbody><tr><td colspan="6" style="font-family:arial;font-size:12px;border-style:none;text-align: center;font-weight: bold;margin-bottom:3px;">Per <?php echo $this->customlib->date_indo(date("Y-m-d")) ?></td></tr>
     </tbody></table>
     <br>
     

     <table class="tabelItems"> 
          <colgroup><col style="width: 10%">
          <col style="width: 12%">
          <col style="width: 15%">
          <col style="width: 27%">
          <col style="width: 12%">
          <col style="width: 12%">
          <col style="width: 12%">

          </colgroup><thead>
            <tr class="textLeft">
                                <th style="border:1px solid black;">Kode</th><th style="border:1px solid black;">001</th><th>PT. ARRAHMAN</th><th style="border:1px solid black;"></th><th style="border:1px solid black;"></th><th style="border:1px solid black;">Saldo Awal</th><th style="border:1px solid black;" class="textRight">0.00</th>
            </tr>
            <tr class="textLeft"><th style="border:1px solid black;">Tanggal</th><th style="border:1px solid black;" class="textLeft">Sumber</th><th style="border:1px solid black;" class="textLeft">Nomor Sumber</th><th style="border:1px solid black;" class="textLeft">Keterangan</th><th style="border:1px solid black;" class="textRight">Debet</th><th style="border:1px solid black;" class="textRight">Kredit</th><th style="border:1px solid black;" class="textRight">Saldo Akhir</th></tr>
          </thead>
          
          <tbody><tr><td style="border:1px solid black;" colspan="6" class="textRight"><b>Total Pengurangan</b></td><td style="border:1px solid black;" class="textRight" colspan="1"><b><u>0.00</u></b></td></tr><tr><td style="border:1px solid black;" colspan="6" class="textRight"><b>Total Penambahan</b></td><td style="border:1px solid black;" class="textRight" colspan="1"><b><u>0.00</u></b></td></tr><tr><td style="border:1px solid black;" colspan="6" class="textRight"><b>Saldo Akhir</b></td><td style="border:1px solid black;" class="textRight" colspan="1"><b><u>0.00</u></b></td></tr>
    </tbody></table>

 </page>  

</div>
</div>
</div>