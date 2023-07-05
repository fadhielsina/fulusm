<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-35VN14CNFE"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-35VN14CNFE');
</script>


        <!-- Begin Page Content -->
        <div class="container-fluid">
          <h1><?= $title; ?></h1>

          <div class="row">
            <div class="col-lg-8">
              <?= $this->session->flashdata('message'); ?>
            </div>
          </div>

         <div class="card mb-3 col-lg-8" style="max-width: 540px;">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="<?= base_url('assets/img/profile/'). $user['image']; ?>" class="card-img" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title"><?= $user['name'];?></h5>
                  <p class="card-text"><?= $user['email'];?></p>
                  <p class="card-text"><small class="text-muted"><?= $user_all['role'] ?> since <?= date('d F Y', $user['date_created']);?></small></p>
                </div>
              </div>
            </div>
          </div>

      </div>
      <!-- End of Main Content -->