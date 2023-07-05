 <aside class="left-sidebar">
   <!-- Sidebar scroll-->
   <div class="scroll-sidebar">
     <nav class="sidebar-nav">
       <ul id="sidebarnav">
         <?php
          $menu = (array)json_decode($this->session->userdata("menu_akses"), TRUE);
          //var_dump($menu);
          //var_dump($this->session->userdata("menu_akses"));
          if (count($menu) <= 0) {
            $menu = array('');
          }
          $dataParentMenu = $this->menu_model->get_parent_menu($menu);
          $active = $this->athoslib->activeLang();

          if (is_array($dataParentMenu)) {
            foreach ($dataParentMenu as $item) {
              $childMenu = $this->menu_model->get_child_menu($item['id_menu'], $menu);

              if ($item['url'] == "#" || $item['url'] == "")
                $url =  "#";
              else
                $url = site_url() . $item['url'];

              if ($active['label'] == 'Indonesia') {
                $menu_label = $item['menu_label'];
              } else {
                $menu_label = $item['english_label'];
              }

              echo '<li>
                               <a class="' . $item['class'] . '" href="' . $url . '" aria-expanded="false">' . $item['icon'] . '</i><span class="hide-menu" style="font-size:13px;">' . $menu_label . '</span></a>';

              //sub menu ke 1
              if (is_array($childMenu) && count($childMenu) > 0) {
                echo ' <ul class="">';
                foreach ($childMenu as $child_item) {
                  //untuk mengcover menu yang tidak ada target urlnya 
                  if ($child_item['url'] == "#" || $child_item['url'] == "") {
                    $urlchild =  uri_string();
                  } else {
                    $urlchild = site_url() . $child_item['url'];
                  }
                  if ($active['label'] == 'Indonesia') {
                    $menu_child_item = $child_item['menu_label'];
                  } else {
                    $menu_child_item = $child_item['english_label'];
                  }
                  echo '<li class="">' . anchor($urlchild, $menu_child_item . ' &#187;', '');
                  //sub menu ke 2
                  $childMenu2 = $this->menu_model->get_child_menu($child_item['id_menu'], $menu);
                  if (is_array($childMenu2) && count($childMenu2) > 0) {
                    echo ' <ul class="">';
                    foreach ($childMenu2 as $child_item2) {
                      if ($child_item2['url'] == "#" || $child_item2['url'] == "") {
                        $urlchild2 =  uri_string();
                      } else {
                        $urlchild2 = site_url() . $child_item2['url'];
                      }
                      if ($active['label'] == 'Indonesia') {
                        $menu_child_item2 = $child_item2['menu_label'];
                      } else {
                        $menu_child_item2 = $child_item2['english_label'];
                      }
                      echo '<li class="">' . anchor($urlchild2, $menu_child_item2, '');
                      echo '</li>';
                    }
                    echo '</ul>';
                  }

                  echo '</li>';
                }
                echo '</ul>';
              }
              echo '</li>';
            }
          } else {
            //die($dataParentMenu['message']);
          }

          ?>
         <!--<li >
                        <a class="waves-effect waves-dark" href="<?php echo site_url(); ?>home" aria-expanded="false">
                            <i class="mdi mdi-gauge"></i><span class="hide-menu">DASHBOARD </span>
                        </a>
                        </li>
           <li class="">
                        <a href="#" class="has-arrow waves-effect waves-dark"><i class="mdi mdi-apps"></i><span class="hide-menu">Master Data</span></a>
                        <ul class="collapse">
                           <li><?php echo anchor(site_url() . "user", 'Pengguna &#187;', 'class="more"'); ?></li>
              <li><?php echo anchor(site_url() . "pajak", 'Data Wajib Pajak &#187;', 'class="more"'); ?></li>
              <li><?php echo anchor(site_url() . "akun", 'Akun &#187;', 'class="more"'); ?></li>                        
              <li><?php echo anchor(site_url() . "akun/saldo_awal", 'Saldo Awal &#187;', 'class="more"'); ?></li> 
                        </ul>
                    </li>
           <li class="">
                        <a href="#" class="has-arrow waves-effect waves-dark"><i class="mdi mdi-apps"></i><span class="hide-menu">Invoice</span></a>
                        <ul class="collapse">
                          <li><?php echo anchor(site_url() . "invoice", 'Invoice IP &#187;', 'class="more"'); ?></li>
              <li><?php echo anchor(site_url() . "invoice", 'Invoice OP &#187;', 'class="more"'); ?></li>
                        </ul>
                    </li>
           <li class="">
                        <a href="#" class="has-arrow waves-effect waves-dark"><i class="mdi mdi-apps"></i><span class="hide-menu">Transaksi KAS</span></a>
                        <ul class="collapse">
                          <li><?php echo anchor(site_url() . "kas/transfer_kas", 'Transfer Kas &#187;', 'class="more"'); ?></li>
              <li><?php echo anchor(site_url() . "kas/kas_masuk", 'Kas Masuk &#187;', 'class="more"'); ?></li>
              <li><?php echo anchor(site_url() . "kas/kas_keluar", 'Kas Keluar &#187;', 'class="more"'); ?></li>    
                        </ul>
                    </li>
           <li class="">
                        <a href="#" class="has-arrow waves-effect waves-dark"><i class="mdi mdi-apps"></i><span class="hide-menu">Transaksi AKUN</span></a>
                        <ul class="collapse">
                         <li><?php echo anchor(site_url() . "akun/detail_akun", 'Buku Besar &#187;', 'class="more"'); ?></li>
              <li><?php echo anchor(site_url() . "jurnal/jurnal_penggajian", 'Data Jurnal Unpost &#187;', 'class="more"'); ?></li>
                        <li><?php echo anchor(site_url() . "jurnal", 'Data Jurnal &#187;', 'class="more"'); ?></li>
              <li><?php echo anchor(site_url() . "jurnal/jurnal_umum", 'Jurnal Umum &#187;', 'class="more"'); ?></li>
              <li><?php echo anchor(site_url() . "jurnal/jurnal_penyesuaian", 'Jurnal Penyesuaian &#187;', 'class="more"'); ?></li>
              <li><?php echo anchor(site_url() . "jurnal/jurnal_penutup", 'Jurnal Penutup &#187;', 'class="more"'); ?></li>   
                        </ul>
                    </li>-->
       </ul>
     </nav>
     <!-- End Sidebar navigation -->
   </div>
   <!-- End Sidebar scroll-->
   <!-- Bottom points-->
   <div class="sidebar-footer">

     <!-- item--><a href="<?php echo site_url(); ?>login/logout" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
     <a href="<?php base_url(); ?>ubahmail" class="link"><i class="fa fa-envelope"></i> </a>
     <a href="<?php base_url(); ?>ubahsandi" class="link"><i class="fa fa-key"></i> </a>
   </div>
   <!-- End Bottom points-->
 </aside>