  <!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar fixed">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#">
                  <i class="fa  fa-asterisk"></i>
                  <span>Master Data</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
					<li><?php echo anchor(site_url()."user", '<i class="fa fa-chevron-circle-right"></i> Pengguna '); ?></li>
					<li><?php echo anchor(site_url()."pajak", '<i class="fa fa-chevron-circle-right"></i> Data Wajib Pajak '); ?></li>
					<li><?php echo anchor(site_url()."akun", '<i class="fa fa-chevron-circle-right"></i> Akun '); ?></li>												
					<li><?php echo anchor(site_url()."akun/saldo_awal", '<i class="fa fa-chevron-circle-right"></i> Saldo Awal '); ?></li>	
                </ul>
            </li>
        </ul>

    </section>

    <!-- /.sidebar -->
</aside>