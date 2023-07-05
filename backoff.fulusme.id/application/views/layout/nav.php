  <div class="wrapper">

          <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo base_url(); ?>admin/index" class="logo">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini"><b>P</b>B</span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg"><b>PRO</b> Bussiness</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
              </a>
              <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell"></i>
                                
                               
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">PEMBERITAHUAN !!</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="<?php echo base_url(); ?>product/plan_cek_save_view">
                                                <i class="fa fa-warning danger"></i> <!--<?php echo $key->statustot;?>--> &nbsp;
                                            </a>
                                        </li>
                                       
                                    
                                        
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo strtoupper($this->session->userdata('admin_nama'));?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-yellow">
                                  <img src="<?php echo base_url(); ?>assets/img/logo1.png" class="img-circle" alt=""/>
                                    <p>
                                        <?php echo strtoupper($this->session->userdata('admin_nama'));?>
                                        <small>Amor Group</small>
                                    </p>
                                </li>
                               
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url(); ?>admin/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
             
          </nav>
        </header>