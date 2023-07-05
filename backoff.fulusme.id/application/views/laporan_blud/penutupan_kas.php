<?php
$PecahanKertas = array("100000","50000","20000","10000","5000","2000","1000");
$PecahanKoin = array("1000","500","200","100","50","25");
?>
<div class="col-lg-12 mt-2">	
    <h3 class="pull-left"> <i class="fa fa-windows"></i> <?php echo $title; ?></h3>
<br/>
<div class="post-body">
<?php 	echo form_open('laporan/proses_penutupan_kas', array('id' => 'jurnal_form','class' => 'form-material m-t-40', 'onsubmit' => 'laporan/penutupan_kas'));

echo "<div id='error' class='error-message' ";

if($this->session->userdata('ERRMSG_ARR'))
{
        echo ">";
        echo $this->session->userdata('ERRMSG_ARR');
        $this->session->unset_userdata('ERRMSG_ARR');
}
else
{
    $this->session->flashdata('message');
}
echo "</div>"; ?>
<div class="card">
  <div class="card-body">
        <div class="row-md-3">
            <div class="col-12 text-center mt-3">
                <h2><?php echo $title; ?></h2>
                <br></br>
            </div>
            <div class="col-12 text-left">
                <div class="row"> 
                    <div class="col-4">Tanggal Penutupan Kas</div>
                    <div class="col-0.5">:</div>
                    <div class="col-7"><input type="date" name="tgl_penutupan" id="xx" class="form-control"></div>
                </div>
                <div class="row"> 
                    <div class="col-4">Nama Penutup Kas</div>
                    <div class="col-0.5">:</div>
                    <div class="col-7"><input type="text" name="nama_petugas" id="xx" class="form-control"></div>
                </div>
                <div class="row"> 
                    <div class="col-4">Tanggal Penutupan Kas yang lalu</div>
                    <div class="col-0.5">:</div>
                    <div class="col-7"><input type="date" name="tgl_penutupan_lalu" id="xx" class="form-control"></div>
                </div>
                
            </div>
            <div class="col-12 text-left">
                Jumlah transaksi s/d bulan
            </div>
             <div class="col-12 text-left">
                <div class="row"> 
                    <div class="col-4">─ Jumlah Penerimaan s/d tanggal</div>
                    <div class="col-0.5">:</div>
                    <div class="col-5"><input type="text" name="periode_penerimaan" id="xx" class="form-control"></div>
                    <div class="form-group m-b-0">
                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                    <span class="input-group-text">Rp</span></span>
                                    <input id="jml_penerimaan" type="text" value="0" name="jml_penerimaan" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                            </div> 
                        </div>
                </div>
                <div class="row"> 
                    <div class="col-4">─ Jumlah Pengeluaran s/d tanggal</div>
                    <div class="col-0.5">:</div>
                    <div class="col-5"><input type="text" name="periode_pengeluaran" id="xx" class="form-control"></div>
                    <div class="form-group m-b-0">
                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                            <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                <span class="input-group-text">Rp</span></span>
                                <input id="jml_pengeluaran" type="text" value="0" name="jml_pengeluaran" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                        </div> 
                    </div>
                </div>
                 <div class="row"> 
                    <div class="col-4">Saldo Buku</div>
                    <div class="col-0.5"></div>
                    <div class="col-5"></div>
                    <div class="col-3">
                       <div class="form-group m-b-0">
                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                    <span class="input-group-text">Rp</span></span>
                                    <input id="saldo_buku" type="text" value="0" name="saldo_buku" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                            </div> 
                        </div>
                    </div>
                </div>
                 <div class="row"> 
                    <div class="col-4">Saldo Bank</div>
                    <div class="col-0.5"></div>
                    <div class="col-5"></div>
                    <div class="col-3">
                        <div class="form-group m-b-0">
                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                    <span class="input-group-text">Rp</span></span>
                                    <input id="saldo_bank" type="text" value="0" name="saldo_bank" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                            </div> 
                        </div>
                    </div>
                </div>
                 <div class="row"> 
                    <div class="col-4">Saldo Tunai</div>
                    <div class="col-0.5"></div>
                    <div class="col-5"></div>
                    <div class="col-3">
                        <div class="form-group m-b-0">
                            
                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                    <span class="input-group-text">Rp</span></span>
                                    <input id="saldo_tunai" type="text" value="0" name="saldo_tunai" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-4">Panjar</div>
                   <div class="col-0.5"></div>
                    <div class="col-5"></div>
                    <div class="col-3">
                        <div class="form-group m-b-0">
                            
                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                    <span class="input-group-text">Rp</span></span>
                                    <input id="saldo_panjar" type="text" value="0" name="saldo_panjar" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-4"></div>
                   <div class="col-0.5"></div>
                    <div class="col-5 text-right"  >Jumlah</div>
                    <div class="col-3">
                        <div class="form-group m-b-0">
                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                    <span class="input-group-text">Rp</span></span>
                                    <input id="jml_transaksi" type="text" value="0" name="jml_transaksi" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-left">
               Saldo Kas terdiri atas :
               <ol>
                   <li>Uang Kertas
                       <div class="row">
                       <?php
                        foreach ($PecahanKertas as $value) {
                            echo '<div class="col-3">─ Pecahan Rp. </div>';
                            echo '<div  class="col-2 text-right"> '.number_format($value).' </div>';    
                            echo '<div  class="col-1 text-left"> = </div>';     
                            echo '<div class="col-3"><div class="form-group m-b-0">
                                    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                            <input id="pecahan_'.$value .'" type="text" value="0" name="pecahan_'.$value .'" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                                            <span class="input-group-addon bootstrap-touchspin-postfix input-group-append"><span class="input-group-text">Lembar</span></span>
                                    </div> 
                                </div></div>';
                            echo '<div class="col-3"><div class="form-group m-b-0">
                                    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                        <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                            <span class="input-group-text">Rp.</span></span>
                                            <input id="tot_pecahan_'.$value .'" type="text" value="0" name="tot_pecahan_'.$value .'" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                                    </div> 
                                </div></div>';
                        }
                       ?>
                       </div>
                   </li>
                <div class="row mt-3">
                   <li>Uang Logam
                       <div class="row">
                        <?php
                        foreach ($PecahanKoin as $value) {
                            echo '<div class="col-3">─ Pecahan Rp. </div>';
                            echo '<div  class="col-2 text-right"> '.number_format($value).' </div>';    
                            echo '<div  class="col-1 text-left">= </div>';    
                            echo '<div class="col-3"><div class="form-group m-b-0">
                                    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                            <input id="pecahan_koin_'.$value .'" type="text" value="0" name="pecahan_koin_'.$value .'" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                                            <span class="input-group-addon bootstrap-touchspin-postfix input-group-append"><span class="input-group-text">Keping</span></span>
                                    </div> 
                                </div></div>';
                            echo '<div class="col-3"><div class="form-group m-b-0">
                                    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                        <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                            <span class="input-group-text">Rp.</span></span>
                                            <input id="tot_pecahan_'.$value .'" type="text" value="0" name="tot_pecahan_'.$value .'" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                                    </div> 
                                </div></div>';
                        }
                       ?>
                       </div>
                       <div class="row"> 
                        <div class="col-4"></div>
                        <div class="col-0.5"></div>
                        <div class="col-5 text-right"></div>
                        <div class="col-3">
                            <div class="form-group m-b-0">
                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                        <span class="input-group-text">Rp</span></span>
                                        <input id="jml_transaksi" type="text" value="0" name="jml_transaksi" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                                </div> 
                            </div>
                        </div>
                    </div>
                   </li>
                   </div>
                   <li>
                       <div class="row">
                           <div class="col-md-9">
                            Kertas berharga dan bagian kas yang diizinkan
                            <br>ordonasi/SP2D, Wesel, Cek, Saldo Bank, Materai
                            <br>dan sebagainya …
                           </div>
                           <div class="col-3"><br><br><div class="form-group m-b-0">
                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                        <span class="input-group-text">Rp.</span></span>
                                        <input id="total_lain_lain" type="text" value="0" name="total_lain_lain" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                                </div> 
                            </div>
                        </div>
                       </div>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-5 text-center"><b>JUMLAH</b></div>
                            <div class="col-3"><div class="form-group m-b-0">
                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                        <span class="input-group-text">Rp.</span></span>
                                        <input id="total_keseluruhan" type="text" value="0" name="total_keseluruhan" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                                </div> 
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-5"><b>Perbedaan Positif / Negatif</b></div>
                            <div class="col-md-3">
                                <div class="form-group m-b-0">
                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                        <span class="input-group-text">Rp.</span></span>
                                        <input id="perbedaan" type="text" value="0" name="perbedaan" class="form-control text-right" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline">
                                </div> 
                            </div>
                        </div>
                        </div>
                   </li>
                   <li>Penjelasan perbedaan baik positif maupun negatif : - </li>
               </ol>
               <div class="row">
                    <div class="col-6"></div>
                   <div class="col-6 text-center">Bandung, <?php echo date("d M Y") ?></div>
               </div>
               <br>
               <div class="row">
                   <div class="col-md-6 text-center">
                       Mengetahui,<br>
                       Pimpinan<br>
                       Selaku Pengguna Anggaran		

                   </div>
                   <div class="col-md-6 text-center">
                       Bendahara Pengeluaran
                   </div>
               </div>
               <br><br><br>
               <div class="row">
                   <div class="col-md-6 text-center">NIP </div>
                   <div class="col-md-6 text-center">NIP </div>
               </div>
               <div class="row">
                   <div class="col-md-6 text-left">
                       <button type="submit" class="btn btn-primary" id = 'button-save'>Simpan</button>
                   </div>
                   <div class="col-md-6 text-center"> </div>
               </div>
            </div>
        </div>
  </div>
</div>
<?php form_close() ?>
</div>