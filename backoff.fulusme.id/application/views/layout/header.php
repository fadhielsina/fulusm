<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">

<head>
	<link rel="shortcut icon" href="<?php echo base_url();?>images/favicon.ico" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta name="description" content="/>
	<meta name="keywords" content=" />
	<meta name="author" content=" />
	
	<base href="<?php echo $this->config->item('base_url') ?>" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ionicons.min.css">
	<style type="text/css" title="currentStyle">
			@import "<?php echo base_url();?>css/style.css";
			@import "<?php echo base_url();?>css/demo_page.css";
			@import "<?php echo base_url();?>css/demo_table.css";
			@import "<?php echo base_url();?>css/demo_table_jui.css";
			@import "<?php echo base_url();?>css/gf-theme/jquery.ui.all.css";
			@import "<?php echo base_url();?>css/demos.css";
		</style>
		<script type="text/javascript" src="<?php echo base_url();?>js/action.js"></script>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.datepicker.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.datepicker-id.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.button.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.dialog.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/additional-methods.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-1.8rc3.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/swfobject.js"></script>
			
		<script type="text/javascript">
		$(function() {
			var dates = $('#datepicker-from, #datepicker-to').datepicker({
				defaultDate: "+1w",
				dateFormat: "yy-mm-dd",
				regional: "id",
				changeMonth: true,
				numberOfMonths: 3,
				onSelect: function(selectedDate) {
					var option = this.id == "datepicker-from" ? "minDate" : "maxDate";
					var instance = $(this).data("datepicker");
					var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
					dates.not(this).datepicker("option", option, date);
				}
			});
		});
		</script>
		<script type="text/javascript" charset="utf-8">
		$(function() {
				$('#button-view').button({
					icons: {
						primary: 'ui-icon-document'
					}
				});
				$('#button-edit').button({
					icons: {
						primary: 'ui-icon-pencil'
					}
				});
				$('#button-delete').button({
					icons: {
						primary: 'ui-icon-trash'
					}
				});
				$('#button-addnew').button({
					icons: {
						primary: 'ui-icon-plus'
					}
				});
				$('#button-save').button();
				$('#button-cancel').button();
				$('#button-print').button();
				$('#button-reset').button();
			});
		</script>
		<script type="text/javascript" charset="utf-8">
			var oTable;
			var oDialog;

			$(document).ready(function() {

				oTable = $('#display_table').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});

				oDialog = $('<div></div>')
					.dialog({
						autoOpen: false,
						title: 'Konfirmasi',
						resizable: false,
						width: 500,
						height: 150,
						modal: true,
						buttons: {
							OK: function() {
								$(this).dialog('close');
							}
						}
					});
			} );

		</script>
		
	<title>SURPLUS</title>
</head>

<body>

<div id="site-wrapper">
<nav class="navbar navbar-default navbar-fixed-top">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url(); ?>/home" style="color:#fff;">SURPLUS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<?php if($this->session->userdata('ADMIN')) { ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle " style="color:#fff;font-size:1.3em;">Manajemen <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                           <li><?php echo anchor(site_url()."user", 'Pengguna &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."pajak", 'Data Wajib Pajak &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."akun", 'Akun &#187;', 'class="more"'); ?></li>												
					<li><?php echo anchor(site_url()."akun/saldo_awal", 'Saldo Awal &#187;', 'class="more"'); ?></li>	
                        </ul>
                    </li>
                </ul>
				<?php } ?>

				 <?php

                       $dataParentMenu = $this->menu_model->get_parent_menu();
                       
                       if(is_array($dataParentMenu)) {
                            foreach($dataParentMenu as $item){
                               $childMenu = $this->menu_model->get_child_menu($item['id_menu']);    
                              	echo '<ul class="nav navbar-nav">
                    			<li class="dropdown"><a href="'.$item['url'].'" data-toggle="dropdown" class="dropdown-toggle " style="color:#fff;font-size:1.3em;">'.$item['menu_label'].' <b class="caret"></b></a>';
                                //var_dump($childMenu);
                                if(is_array($childMenu) && count($childMenu) >0){
                                    echo '<ul class="dropdown-menu">';
                                    foreach($childMenu as $child_item){    
                                     echo '<li>'.anchor(site_url()."".$child_item['url'], $child_item['menu_label'].' &#187;',$child_item['class']) .'</li>';
                                    }
                                    echo '</ul>';
                                }
                                echo '</li>';    

                            }
                        }else{
                            //die($dataParentMenu['message']);
                        }
                    
                     ?>   
				 <!--<ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle " style="color:#fff;font-size:1.3em;">Master <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                   		<li><?php echo anchor(site_url()."klien", 'Klien &#187;', 'class="more"'); ?></li>	
						<li><?php echo anchor(site_url()."vehicles", 'Kendaraan &#187;', 'class="more"'); ?></li>						
						</ul>
                    </li>
                </ul>
				<ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle " style="color:#fff;font-size:1.3em;">Transaksi <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                   			<li><?php echo anchor(site_url()."invoice", 'Penjualan &#187;', 'class="more"'); ?></li>
							<?php if($this->session->userdata('ADMIN')) { ?>
							<li><?php echo anchor(site_url()."purchasing", 'Pembelian &#187;', 'class="more"'); ?></li>
							<?php } ?>
				</ul>
                    </li>
                </ul>
				<ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle " style="color:#fff;font-size:1.3em;">Kas <b class="caret"></b></a>
                        <ul class="dropdown-menu">
					<li><?php echo anchor(site_url()."kas/transfer_kas", 'Transfer Kas &#187;', 'class="more"'); ?></li>
             		<li><?php echo anchor(site_url()."kas/kas_masuk", 'Kas Masuk &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."kas/kas_keluar", 'Kas Keluar &#187;', 'class="more"'); ?></li>					
					</ul>
                    </li>
                </ul>
				<ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle " style="color:#fff;font-size:1.3em;">Akuntansi <b class="caret"></b></a>
                        <ul class="dropdown-menu">
             			<li><?php echo anchor(site_url()."akun/detail_akun", 'Buku Besar &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."jurnal", 'Data Jurnal &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."jurnal/jurnal_umum", 'Jurnal Umum &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."jurnal/jurnal_penyesuaian", 'Jurnal Penyesuaian &#187;', 'class="more"'); ?></li>
					<li><?php echo anchor(site_url()."jurnal/jurnal_penutup", 'Jurnal Penutup &#187;', 'class="more"'); ?></li>							
				</ul>
                    </li>
                </ul>
				<ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle " style="color:#fff;font-size:1.3em;">Laporan <b class="caret"></b></a>
                        <ul class="dropdown-menu">
             			<li><?php echo anchor(site_url()."laporan_keuangan/lap_pendapatan", 'Laporan KAS &#187;', 'class="more"'); ?></li>	
					<li><?php echo anchor(site_url()."laporan_keuangan/lap_pendapatan_bank", 'Laporan Pendapatan &#187;', 'class="more"'); ?></li>		</ul>
				</ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
				<li><a style="color:#fff;font-size:1.6em;" href="<?php echo current_url(); ?>#"><?php echo $this->session->userdata('SESS_FIRST_NAME'); ?> </a></li>
                    <li class="dropdown">
                        <a style="color:#fff;font-size:1.3em;" href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-info"><i class="fa fa-user"></i>  <b class="caret"></b></a>
                        <ul class="dropdown-menu">
				<li><?php echo anchor('user/edit/'.$this->session->userdata('SESS_USER_ID'), 'Ubah Profil'); ?></li>
                           		<li><?php echo anchor('login/logout', 'Logout'); ?></li>
		
                        </ul>
                    </li>
                </ul>-->
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
	<div class="main" >

		<div class="col-lg-12">

			<div class="section">

				<div class="section-content">

					<div class="post">
