 
<? 
$retail_data = $this->db->get_where('retail',["user_id" => $user['id']])->result_array()[0];
$user_data = $this->db->get_where('user',["email" => $retail_data['email']])->result_array()[0];

?> 
<div class="container-fluid">


  <div class="row">
    <div class="col-lg-8 " style="margin-left: 30px;" >
      <?= $this->session->flashdata('message'); ?>
    </div>
    
  </div>

  <div class="row">
    <div class="col-lg-12" style="    padding: 0 70px;">
      <h3 style="padding-left: 40px"><?= $title; ?></h3>

      <form style="margin-top: 30px;" enctype="multipart/form-data" class="user" method="post" action="<?= base_url('project/addproyekretail') ?>">
        <div style="background: #f4f4f4;
        padding: 40px 58px;
        border-radius: 6px;
        box-shadow: 0 4px 4px rgba(0,0,0,.09), 0 1px 1px rgba(0,0,0,.13); ">

        <div class="form-group">
          <input type="hidden" value="<?=$retail_data['id']; ?>" class="form-control form-control-user-add" id="id" name="id">
          
          <input type="hidden" class="form-control form-control-user-add" id="ujrah_pro" name="ujrah_pro">
          <input type="hidden" class="form-control form-control-user-add" id="denom_pro" name="denom_pro">
          <input type="hidden" class="form-control form-control-user-add" id="nisbah_pro" name="nisbah_pro">
          <input type="hidden" class="form-control form-control-user-add" id="pengembalian_dana_pro" name="pengembalian_dana_pro">
          
          
          
          
          <input type="hidden" value="<?=$retail_data['foto_toko']; ?>" class="form-control form-control-user-add" id="foto_toko" name="foto_toko">
          <input type="hidden" value="<?=$user['id_anggota']; ?>" class="form-control form-control-user-add" id="id_anggota" name="id_anggota">
        </div>
        
        <div class="form-group">
          <label style="
          color: black;
          font-size: 14px;
          "> Nama Pemilik Toko</label>
          <input type="text" class="form-control form-control-user-add" id="nama_pemilik" name="nama_pemilik" placeholder="Nama Pemilik Toko" value="<?=$retail_data["name"]?>" readonly >

        </div>
        
        <div class="form-group">
          <label style="
          color: black;
          font-size: 14px;
          "> Nama Toko</label>
          <input type="text" class="form-control form-control-user-add" id="nama_toko" name="nama_toko" placeholder="Nama Toko" value="<?=$retail_data["nama_toko"]?>" readonly >

        </div>
        
        <div class="form-group">
          <label style="
          color: black;
          font-size: 14px;
          "> Nomor Ponsel</label>
          <input type="text" class="form-control form-control-user-add" id="no_hp" name="no_hp" placeholder="Nomor Ponsel" value="<?=$retail_data["phone"]?>" readonly >

        </div>

        
             
             
             
             <div class="form-group">
          <label style="
          color: black;
          font-size: 14px;
          "> Tenor(Hari)</label>
          <input type="text" class="form-control form-control-user-add" id="tenor" name="tenor" placeholder="Tenor" value="7" readonly >

        </div>
        <?php  
          $namakoperasi = $this->db->get_where('koperasi', ['id_koperasi' => $retail_data['id_koperasi']])->row_array();
          ?>
        <div class="form-group">
          <label style="
          color: black;
          font-size: 14px;
          "> Nama Mitra</label>
          <input type="text" class="form-control form-control-user-add" id="id_koperasi" name="id_koperasi" placeholder="" value="<?= $namakoperasi["nama_koperasi"]; ?>" readonly >

        </div>
        
        <div class="form-group">
          <label style="
          color: black;
          font-size: 14px;
          "> ID Peserta</label>
          <input type="text" class="form-control form-control-user-add" id="id_anggota_koperasi" name="id_anggota_koperasi" placeholder="ID Peserta" value="<?=$retail_data["id_anggota_koperasi"]?>" readonly >

        </div>
        
        
                      
                      
                      <div class="form-group">
                      <label style="
                      color: black;
                      font-size: 14px;
                      "> Nominal Pulsa </label>


                          <select name="jumlah_pinjaman" id="jumlah_pinjaman" class="custom-select form-control-user-add" >
                            <option value="">Nominal Pulsa</option>
                            <option value="2000000">Rp. 2.000.000</option>
                            <option value="3000000">Rp. 3.000.000</option>
                            <option value="4000000">Rp. 4.000.000</option>
                            <option value="5000000">Rp. 5.000.000</option>
                            
                          </select>

                          <?= form_error('jumlah_pinjaman', '<small class="text-danger pl-3">', '</small>'); ?>

                        
                      </div>
                      
                      
                      
                      
                      
                      <div class="form-group">
          <label style="
          color: black;
          font-size: 14px;
          "> Ujrah Mumtaaz</label>
          <input type="text" class="form-control form-control-user-add" id="ujrah" name="ujrah" placeholder="ujrah" readonly >

        </div>


    <div class="form-group">
          <label style="
          color: black;
          font-size: 14px;
          "> Denom yang Diterima</label>
          <input type="text" class="form-control form-control-user-add" id="nilaitransfer" name="nilaitransfer" placeholder="Denom yang diterima" readonly >

        </div>
        
        
         <div class="form-group">
          <label style="
          color: black;
          font-size: 14px;
          "> Imbal Hasil (Nisbah) Pendana</label>
          <input type="text" class="form-control form-control-user-add" id="imbalpendana" name="imbalpendana" placeholder="Imbal (Nisbah) Pendana  " readonly >

        </div> 
        
        
        <div class="form-group">
          <label style="
          color: black;
          font-size: 14px;
          "> Nilai Pengembalian Dana</label>
          <input type="text" class="form-control form-control-user-add" id="nilaipengembalian" name="nilaipengembalian" placeholder="Nilai Pengembalian Dana" readonly >

        </div> 
        
        
        
        
        
                      
                      <button type="submit" class="btn btn-primary btn-user btn-block form-button-user-add">
                            Ajukan
                          </button>
                    </div>
                  </form>
                </div>
              </div>
              </div>




              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
              
              
              <script>
              
              
              
              /* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
              
              
              
              
                $( "#jumlah_pinjaman" ).change(function() {
                    
                    var tambahan = parseInt($( "#jumlah_pinjaman" ).val()) + $( "#jumlah_pinjaman" ).val()*13/10/100;
                    
                    var ujrahPro = parseInt($( "#jumlah_pinjaman" ).val()*1/100);
                    
                    var denomPro = parseInt($( "#jumlah_pinjaman" ).val()-$( "#jumlah_pinjaman" ).val()*1/100);
                    
                    var nisbahPro = parseInt($( "#jumlah_pinjaman" ).val()*13/10/100);
                    
                    
                    
                    $( "#ujrah_pro" ).val(ujrahPro);
                        
                    $( "#denom_pro" ).val(denomPro);
                    
                    $( "#nisbah_pro" ).val(nisbahPro);
                    
                    $( "#pengembalian_dana_pro" ).val(tambahan);
                    
                    
                    
                     $( "#ujrah" ).val(   formatRupiah(   (   $( "#jumlah_pinjaman" ).val()*1/100   )   , 'Rp. ')   );
                     $( "#nilaitransfer" ).val(formatRupiah($( "#jumlah_pinjaman" ).val()-$( "#jumlah_pinjaman" ).val()*1/100, 'Rp. '));
                     $( "#imbalpendana" ).val(formatRupiah(($( "#jumlah_pinjaman" ).val()*13/10/100), 'Rp. '));
                     $( "#nilaipengembalian" ).val(formatRupiah(tambahan, 'Rp. '));
                    
                    
                    
                });
                  
              </script>




