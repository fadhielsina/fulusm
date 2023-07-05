<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 4.1.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
	<meta charset="utf-8" />
	<title>FulusMeBackend</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/metronic/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/metronic/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/metronic/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="<?php echo base_url(); ?>assets/metronic/admin/pages/css/lock2.css" rel="stylesheet" type="text/css" />
	<!-- END PAGE LEVEL STYLES -->
	<!-- BEGIN THEME STYLES -->
	<link href="<?php echo base_url(); ?>assets/metronic/global/css/components.css" id="style_components" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/metronic/global/css/plugins.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/metronic/admin/layout/css/layout.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/metronic/admin/layout/css/themes/blue.css" rel="stylesheet" type="text/css" id="style_color" />
	<link href="<?php echo base_url(); ?>assets/metronic/admin/layout/css/custom.css" rel="stylesheet" type="text/css" />
	<!-- END THEME STYLES -->
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body style="background: url(<?php echo base_url(); ?>assets/metronic/admin/pages/media/bg/1.jpg) no-repeat center center fixed; -webkit-background-size: cover;  -moz-background-size: cover;  -o-background-size: cover;  background-size: cover;">
	<div class="page-lock">

		<div class="page-body">

			<?php
			echo form_open('login/login_exec', 'class="login100-form validate-form"'); ?>
			<img src="<?= base_url('assets/img/FMlogonew1.jpg') ?>" alt="" height="200px;" width="180px;">
			<div class="page-lock-info">
				<h4 style="color:#fff;font-weight:bolder">SURPLUS FINANCE SYSTEM</h4>
				<hr />
				<form class="form-inline" action="index.html">
					<div class="input-group input-medium">
						<div class="form-group">
							<input type="text" name="username" class="form-control" placeholder="Username" />
						</div><br />
						<div class="form-group">
							<input type="password" name="password" class="form-control" placeholder="Password" />
						</div>
						<hr />
						<button type="submit" class="btn bg-red btn-block">Log In</button>
					</div>
					<!-- /input-group -->

				</form>
			</div>
			</form>
		</div>

	</div>
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->
	<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
	<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<script src="<?php echo base_url(); ?>assets/metronic/global/scripts/metronic.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/metronic/admin/layout/scripts/layout.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/metronic/admin/layout/scripts/demo.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/metronic/admin/pages/scripts/lock.js"></script>
	<script>
		jQuery(document).ready(function() {
			Metronic.init(); // init metronic core components
			Layout.init(); // init current layout
			Lock.init();
			Demo.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>