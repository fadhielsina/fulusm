 <?php  $this->load->view("template/header"); ?>
 <?php  $this->load->view("template/topnav_admin"); ?>
 <?php  $this->load->view("template/sidebaradmin"); ?> 

<div class="page-wrapper">
	<div class="container-fluid">
		<?php if( 'home' != $this->uri->segment(1) && ! is_null( $this->uri->segment(1) ) ): ?>
		<div class="row page-titles">
            <div class="col-md-12 col-12 align-self-center">
                <h3 class="text-themecolor mb-0 mt-0"><?php echo $this->uri->segment(1); ?></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo $this->uri->segment(1); ?></li>
                    <?php if( $this->uri->segment(2) ): ?>
                    <li class="breadcrumb-item active"><?php echo $this->uri->segment(2); ?></li>
                	<?php endif; ?>
                </ol>
            </div>
        </div>
    	<?php endif; ?>

    	<?php
		if($this->session->flashdata('message') !="")
		{
			echo '
			<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			<h5 class="text-info"><i class="fa fa-exclamation-circle"></i>Notifikasi :</h5> '.$this->session->flashdata('message').'
			</div>
			';
		}
		?>

		<?php $this->load->view($main_content); ?>
	 </div>
 </div>

 <?php  $this->load->view("template/footer_admin"); ?>