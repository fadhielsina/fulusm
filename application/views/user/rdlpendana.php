   

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <h1><?= $title; ?></h1>

          <div class="row">
            <div class="col-lg-8">
              <?= $this->session->flashdata('message'); ?>
            </div>
          </div>
        <div class="row" style="padding-right: 30px;">
         <div class="card mb-3 col-lg-4" style="min-height: unset;
    height: fit-content;
    padding: 15px;padding-bottom: 30px;">
            <div class="row no-gutters">
              <div class="col-md-2">
                <img src="<?= base_url('assets/img/profile/'). "rplogo.png"; ?>" style="    position: relative;
    margin-top: 20px;
    padding: 0.25rem;" class="card-img" alt="...">
              </div>
              <div class="col-md-10">
                <div class="card-body">
                  <p class="card-text" style="margin-bottom: 0;"><small class="text-muted">Total Saldo Aktif</small></p>
                  <h4 class="card-title" style="color:black; font-weight:bold;">Rp1.000.000</h4>
                
                </div>
              </div>
              <div class="col-md-12">
                   <hr style="margin-top:5px" >
                   <div class="row">
                    <div class="col-md-6">
                    <p class="card-text" style="margin-bottom: 0;"><small class="text-muted">Total Saldo masuk </small></p>
                    </div>
                    
                    <div class="col-md-6">
                        <p class="card-text text-right" style="margin-bottom: 0;"><small class="text-muted">Rp3.000.000 </small></p>
                    </div>
                       
                        <div class="col-md-6">
                    <p class="card-text" style="margin-bottom: 0;"><small class="text-muted">Total Saldo digunakan </small></p>
                    </div>
                    
                    <div class="col-md-6">
                        <p class="card-text text-right" style="margin-bottom: 0;"><small class="text-muted">Rp2.000.000 </small></p>
                    </div>
                   </div>  
                  
                 
              </div>   
            </div>
          </div>
          
          <div class="card mb-3 col-lg-8" style="margin-left:15px; margin-right:-30px;">
            <div class="row no-gutters">
              <div class="col-md-12 card-body">
                  <div class="row">
                      <div class="col-md-9">
                          <h4 class="card-title" style="color:black; font-weight:bold;">Riwayat Transaksi</h4>
                      </div>
                      
                      <div class="col-md-3">
                          <div class="form-group">
  <select class="form-control" id="sel1">
    <option>3 bulan terakhir</option>
    <option>1 bulan terakhir</option>
    <option>30 hari terakhir</option>
    <option>1 minggu terakhir</option>
    <option>hari ini</option>
  </select>
</div>
                      </div>
                      
                  </div>   
                  
                  
                  <hr style="margin-top:5px" >
                  
                  <h4 class="card-title" style="color: #33ae42;
    font-size: medium;
    background: beige;
    border: aliceblue 1px solid;
    padding: 6px 8px;">Dana Masuk</h4>
    
                <div class="row">
                    <div class="col-md-6">
                    <p class="card-text" style="margin-bottom: 0;"><small class="text-muted">27 September 2020 </small></p>
                    </div>
                    
                    <div class="col-md-6">
                        <p class="card-text text-right" style="margin-bottom: 0;"><small class="text-muted">Rp1.500.000 </small></p>
                    </div>
                       
                        <div class="col-md-6">
                    <p class="card-text" style="margin-bottom: 0;"><small class="text-muted">04 Oktober 2020</small></p>
                    </div>
                    
                    <div class="col-md-6">
                        <p class="card-text text-right" style="margin-bottom: 0;"><small class="text-muted">Rp1.000.000 </small></p>
                    </div>
                    <div class="col-md-6">
                    <p class="card-text" style="margin-bottom: 0;"><small class="text-muted">16 November 2020</small></p>
                    </div>
                    
                    <div class="col-md-6">
                        <p class="card-text text-right" style="margin-bottom: 0;"><small class="text-muted">Rp500.000 </small></p>
                    </div>
                </div>  
    
    
    <hr style="margin-top:30px" >
             
                  <h4 class="card-title" style="color: #33ae42;
    font-size: medium;
    background: beige;
    margin-top: 30px;
    border: aliceblue 1px solid;
    padding: 6px 8px;">Dana Keluar</h4>
    
                <div class="row">
                    <div class="col-md-6">
                    <p class="card-text" style="margin-bottom: 0;"><small class="text-muted">29 September 2020 </small></p>
                    </div>
                    
                    <div class="col-md-6">
                        <p class="card-text text-right" style="margin-bottom: 0;"><small class="text-muted">Rp500.000 </small></p>
                    </div>
                       
                        <div class="col-md-6">
                    <p class="card-text" style="margin-bottom: 0;"><small class="text-muted">15 Oktober 2020</small></p>
                    </div>
                    
                    <div class="col-md-6">
                        <p class="card-text text-right" style="margin-bottom: 0;"><small class="text-muted">Rp1.500.000 </small></p>
                    </div>
                    
                </div>  
    
    
    
              </div>
              
              
            </div>
          </div>
          </div>

      </div>
      <!-- End of Main Content -->