  <header class="topbar">
      <?php
        $language = $this->athoslib->listLanguage();
        $active = $this->athoslib->activeLang();
        ?>
      <nav class="navbar top-navbar navbar-expand-md navbar-light">
          <!-- ============================================================== -->
          <!-- Logo -->
          <!-- ============================================================== -->
          <div class="navbar-header">
              <a class="navbar-brand" href="<?php echo site_url(); ?>">
                  <!-- Logo icon --><b>
                      <span class="text-white m-b-0 font-light">FULUSME SCF</span>
                  </b>
              </a>
          </div>
          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->
          <div class="navbar-collapse">
              <ul class="navbar-nav mr-auto mt-md-0">
                  <!-- This is  -->
                  <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                  <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>

              </ul>
              <div class="col-md-8 col-8 align-self-right">
                  <div class="d-flex m-t-8 justify-content-end">
                      <span class="text-white">
                          <div id="clock"></div>
                          <?php if ($active['label'] == 'Indonesia') { ?>
                              <?php
                                $tgl = date('Y-m-d');
                                echo longdate_indo($tgl);
                                ?>
                          <?php } else { ?>
                              <?php
                                echo date('l, d F Y');
                                ?>
                          <?php } ?>
                      </span>
                  </div>
              </div>
              <ul class="navbar-nav my-lg-0">
                  <!-- Language -->
                  <!-- ============================================================== -->
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="flag-icon <?php echo $active['icon'] ?>"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right scale-up">
                          <?php
                            foreach ($language as $index => $item) {
                                echo '<a class="dropdown-item" href="' . base_url("home/change_lang/" . $index) . '">
                                        <i class="flag-icon ' . $item['icon'] . '"></i> ' . $item['label'] . '</a>';
                            }
                            ?>
                      </div>
                  </li>
              </ul>
          </div>
      </nav>
  </header>