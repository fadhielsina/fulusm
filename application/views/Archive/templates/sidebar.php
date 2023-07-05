    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion white_spacebar" style="height:100%;" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center " href="index.html">
        <div class="sidebar-brand-icon">
          <img src="<?= base_url('assets/');?>img/fulusme.jpg" width="50">
        </div>
        <div class="sidebar-brand-text mx-3">Fulusme</div>
      </a>
      <!-- Divider -->
      <hr class="sidebar-divider mt-3">

      <!-- ? -->
      <?php 
      $role_id = $this->session->userdata('role_id');

      $queryMenu = "SELECT `user_menu`.`id`, `menu`
      FROM user_menu JOIN `user_access_menu`
      ON `user_menu`.`id` = `user_access_menu`.`menu_id`
      WHERE `user_access_menu`.`role_id` = $role_id
      ORDER BY `user_access_menu`.`menu_id` ASC
      ";
      $menu = $this->db->query($queryMenu)->result_array();
      ?>

      <?php foreach ($menu as $m) :?>
        <!-- Heading -->
        <div class="sidebar-heading ">
          <?= $m['menu']; ?>

          <?php 
          $menuId = $m['id'];
          $querySubMenu = "SELECT * 
          FROM `user_sub_menu` WHERE `menu_id` = $menuId 
          AND `is_active` = 1 ";
          $subMenu = $this->db->query($querySubMenu)->result_array();
          ?>

          <?php foreach ($subMenu as $sm) :  ?>

            <?php if ($role_id == 3): ?>

              <?php 
              $user_id= $this->session->userdata('id');
              $querySubMenu = "SELECT * 
              FROM `perusahaan_pendana` WHERE `pendana_id` = $user_id";
              $company = $this->db->query($querySubMenu)->row_array();
              ?>
              <?php if($company['pendana_id']): ?>
                <?php if ($title == $sm['title']) : ?>
                 <!-- Nav Item - Dashboard -->
                 <li class="nav-item active">
                  <?php else :  ?>      
                    <li class="nav-item">
                    <?php endif;  ?>    
                    <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                      <i class="<?= $sm['icon'] ?>"></i>
                      <span>
                        <?= $sm['title'] ?>
                      </span></a>
                    </li>
                    <?php else: ?>


                    <?php if($sm['title'] != "Edit Company Profile"): ?>
                      <?php if ($title == $sm['title']) : ?>
                       <!-- Nav Item - Dashboard -->
                       <li class="nav-item active">
                        <?php else :  ?>      
                          <li class="nav-item">
                          <?php endif;  ?>    
                          <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                            <i class="<?= $sm['icon'] ?>"></i>
                            <span>
                              <?= $sm['title'] ?>
                            </span></a>
                          </li>
                        <?php endif; ?>



                      <?php endif; ?>

                      <?php else: ?>
                       <?php if ($title == $sm['title']) : ?>
                         <!-- Nav Item - Dashboard -->
                         <li class="nav-item active">
                          <?php else :  ?>      
                            <li class="nav-item">
                            <?php endif;  ?>    
                            <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                              <i class="<?= $sm['icon'] ?>"></i>
                              <span>
                                <?= $sm['title'] ?>
                              </span></a>
                            </li>

                          <?php endif; ?>



                        <?php endforeach; ?>
                        <hr class="sidebar-divider mt-3">

                      </div>
                    <?php endforeach; ?>

                    <!-- Heading -->
                    <li class="nav-item" style="margin-left: 16px;">
                      <a class="nav-link" href="<?= base_url('auth/logout')?>">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>Logout</span></a>
                      </li>

                      <!-- Sidebar Toggler (Sidebar) -->
                      <div class="text-center d-none d-md-inline">
                        <button class="rounded-circle border-0" id="sidebarToggle"></button>
                      </div>

                    </ul>
    <!-- End of Sidebar -->