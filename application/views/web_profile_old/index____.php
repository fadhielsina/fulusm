<?php 

// 			print_r($project[0]['nominal']);
// 			die();	
if(count($project)>3){
	$loop = 2;
}else{
	$loop = 1;
}

// print_r($loop);
// 			die();	
?>
<!-- Logo and Navigation -->
<div class="site-header-container container">

	<div class="row">

		<div class="col-md-12">

			<header class="site-header">

				<section class="site-logo">

					<a href="index.php">
						<img src="<?= base_url('assetsprofile/')?>asset/images/dealfintech.jpg" width="75" style="
						margin-left: 60px;
						">
					</a>


				</section>

				<nav class="site-nav">

					<ul class="main-menu hidden-xs" id="main-menu">
						<li>
							<a href="<?= base_url('welcome')?>">
								<span>Home</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span>Tentang Kami</span>
							</a>

							<ul>

								<li>
									<a href="<?= base_url('welcome/perusahaan')?>">
										<span>Perusahaan</span>
									</a>
								</li>

								<li>
									<a href="<?= base_url('welcome/ceodantim')?>">
										<span>Ceo dan tim</span>
									</a>
								</li>
								<li>
									<a href="<?= base_url('welcome/perusahaanpartner')?>">
										<span>Perusahaan partner</span>
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a target="_blank" href="https://fintekmumtaaz.wordpress.com/">
								<span>Blog/Testimoni</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span>Alur bisnis</span>
							</a>

							<ul>
								<li>
									<a href="<?= base_url('welcome/alurbisnispengeloladana')?>">
										<span>Enterprise</span>
									</a>
								</li>
								<li>
									<a href="<?= base_url('welcome/alurbisnispendana')?>">
										<span>Retail</span>
									</a>
								</li>
								<li>
									<a href="<?= base_url('welcome/resikoinvestasi')?>">
										<span>Proses Pemodalan</span>
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#">
								<span>Bantuan</span>
							</a>
							<ul>
								<li>
									<a href="<?= base_url('welcome/helpdesk')?>">
										<span>Helpdesk</span>
									</a>
								</li>
								<li>
									<a href="<?= base_url('welcome/faq')?>">
										<span>FAQ</span>
									</a>
								</li>
								<li>
									<a href="<?= base_url('welcome/sk')?>">
										<span>Syarat & Ketentuan</span>
									</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#">
								<span>Keanggotaan</span>
							</a>

							<ul>
								<li>
									<a href="<?= base_url('auth/registration')?>">
										<span>Daftar</span>
									</a>
								</li>

								<li>
									<a href="<?= base_url('auth')?>">
										<span>Login</span>
									</a>
								</li>
							</ul>
						</li>

						<li class="search">
							<a href="#">
								<i class="entypo-search"></i>
							</a>

							<form method="get" class="search-form" action="#" enctype="application/x-www-form-urlencoded">
								<input type="text" class="form-control" name="q" placeholder="Type to search..." />
							</form>
						</li>
					</ul>


					<div class="visible-xs">

						<a href="#" class="menu-trigger">
							<i class="entypo-menu"></i>
						</a>

					</div>
				</nav>

			</header>

		</div>

	</div>

</div>	


<!-- Main Slider -->
<section style="margin: auto;" class="features-blocks">

	<div class="container container-fluid">
		<div class="row" style="margin-bottom: 100px ">
			<div class="col-md-5 " style="text-align: right;">

				<h2 style="font-size: 77px;color: #288672;">Fulusme </h2> 
				<h2 style="">Layanan Urun Dana Berbasis Teknologi </h2>



				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1"></li>
						<li data-target="#myCarousel" data-slide-to="2"></li>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner">

						<div class="item active">
							<p style="
							margin-top: 36px;
							font-size: 18px;
							font-weight: 200;
							margin-bottom: 50px;
							">Hi, selamat datang di jaman now, dimana kecepatan dan instant sudah menjadi bagian dari keseharian kita, dimana investasi dan pembiayaan tidak lagi dibatasi oleh ruang dan waktu</p>
						</div>

						<div class="item">
							<p style="
							margin-top: 36px;
							font-size: 18px;
							font-weight: 200;
							margin-bottom: 50px;
							">Kami senantiasa mendukung investasi dan bisnis anda melalui Layanan Urun Dana Berbasis Teknologi (Securities Crowd Funding) terkini dan beradaptasi selalu dari waktu ke waktu.</p>
						</div>

						<div class="item">
							<p style="
							margin-top: 36px;
							font-size: 18px;
							font-weight: 200;
							margin-bottom: 50px;
							">Fulusme  adalah Layanan Urun Dana berbasis teknologi (Securities Crowd Funding), yang kami bangun untuk kemaslahatan dan kemakmuran seluruh umat tanpa terkecuali.</p>
						</div>

					</div>

					<!-- Left and right controls -->
					<a style="
					color: black;
					opacity: 1;
					display: inline-block;
					float: left;
					left: -40px;
					top: -90px;
					position: relative;
					" href="#myCarousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a style="
				color: black;
				position: relative;
				display: inline-block;
				opacity: 1;
				float: right;
				top: -90px;
				right: -40px;
				" href="#myCarousel" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>

	<div class="col-md-7">
		<img style="
		width: 90%;
		margin: auto;
		position: relative;
		display: block; 
		" src="<?= base_url('assetsprofile/')?>asset/images/halaman_utama.png">
	</div>
</div>
</div>

</section>

<!-- Features Blocks -->

<section class="features-blocks " >

	<div class="container" style="    padding: 0;">

		<div class="row vspace" style="margin-bottom: 0px"><!-- "vspace" class is added to distinct this row -->			
			<div class="col-sm-4" style="padding: 20px">

				<div class="feature-block" 
				style="box-shadow: 0 1px 6px 0 rgba(49, 53, 59, 0.12);
				background-color: #fff;
				padding: 16px 24px 24px;
				color: #288672;
				margin-bottom: 0px;
				border-radius: 12px;
				min-height: 290px;"
				>
				<h3 style="    color: #288672;">
					<i class="entypo-cog"></i>
					Layanan Urun Dana
				</h3>

				<p>
					Fulusme  Layanan Urun Dana adalah salah satu wadah tempat bertemunya Pemodal dan Penerbit yang dihubungkan dengan teknologi aplikasi.
				</p>
			</div>

		</div>

		<div class="col-sm-4" style="padding: 20px">

			<div class="feature-block" 
			style="box-shadow: 0 1px 6px 0 rgba(49, 53, 59, 0.12);
			background-color: #fff;
			padding: 16px 24px 24px;
			color: #288672;
			margin-bottom: 0px;
			border-radius: 12px;
			min-height: 290px;">
			<h3 style="    color: #288672;">
				<i class="entypo-gauge"></i>
				Securities Crowd Funding
			</h3>

			<p>
				Fulusme  adalah Layanan Urun Dana Berbasis Teknologi (Securities Crowd Funding), yang kami bangun untuk dapat bermanfaat bagi dunia bisnis di Indonesia.


			</p>
			<ol style="padding-left: 69px;
			text-align: justify;
			padding-right: 21px;
			color: #999999;">
			<li> Semua prosesnya transparan dan terbuka diawal sehingga tidak ada biaya yang tersembunyi</li>
			<li> Tidak ada pemberlakuan penalty</li>
			<li> Lebih berkah,manusiawi dan Halal</li>
			<li> Lebih menguntungkan semua pihak</li>
		</ol>
	</div>

</div>

<div class="col-sm-4" style="padding: 20px">

	<div class="feature-block" 
	style="box-shadow: 0 1px 6px 0 rgba(49, 53, 59, 0.12);
	background-color: #fff;
	padding: 16px 24px 24px;
	margin-bottom: 0px;
	color: #288672;
	border-radius: 12px;
	min-height: 290px;">
	<h3 style="    color: #288672;">
		<i class="entypo-lifebuoy"></i>
		24/7 Support
	</h3>

	<p>
		Kami, selalu ada dan siap mendampingi anda 24 jam sehari, 7 kali seminggu dan 365 hari non-stop melalui web kami. 
	</p>
</div>

</div>

</div>

</div>

</section>
<!-- produk -->
<section class="portfolio-widget" style="margin-top: 0; margin-bottom:0px; padding-top:30px;">

	<div class="container">

		<div class="row" style="box-shadow: 0 1px 6px 0 rgba(49, 53, 59, 0.12);
		background-color: #fff;
		margin-bottom: 32px;
		border-radius: 12px;
		padding: 30px;">

		<div class="col-sm-3">

			<div class="portfolio-info">
				<h3 style="
				margin-top: 19px;
				">
				Produk Kami
			</h3>
		</div>

	</div>

	<div class="col-sm-3">

		<!-- Portfolio Item in Widget -->				
		<div class="">
			<a  class="image">
				<h2 style="
				font-size: 20px;
				font-weight: bold;
				color: #288672;
				">Mudharabah</h2>
				<img src="<?= base_url('assets/')?>img/koin.jpg" class="img-rounded" style="
				object-fit: cover;
				width: 100%;
				height: 100px;
				/* margin-right: 0px; */
				">
			</a>
			<h4>
				<p style="
				font-size: 16px;
				text-align: left;
				"> Adalah kerjasama pembiayaan proyek dengan konsep bagi hasil sesuai syariah </p>
			</h4>
		</div>

	</div>

	<div class="col-sm-3">

		<!-- Portfolio Item in Widget -->				
		<div class="">
			<a  class="image">
				<h2 style="
				font-size: 20px;
				font-weight: bold;
				color: #288672;
				">Murabahah</h2>
				<img src="<?= base_url('assets/')?>img/kalkulator.jpg" class="img-rounded" style="
				object-fit: cover;
				width: 100%;
				height: 100px;
				/* margin-right: 0px; */
				">
			</a>
			<h4>
				<p style="
				font-size: 16px;
				text-align: left;
				"> Adalah transaksi jual beli objek dengan konsep syariah</p>
			</h4>
		</div>

	</div>

	<div class="col-sm-3">

		<!-- Portfolio Item in Widget -->				
		<div class="">
			<a  class="image">
				<h2 style="
				font-size: 20px;
				font-weight: bold;
				color: #288672;
				">Musyarakah</h2>
				<img src="<?= base_url('assets/')?>img/grafik.jpg" class="img-rounded" style="
				object-fit: cover;
				width: 100%;
				height: 100px;
				/* margin-right: 0px; */
				">
			</a>
			<h4>
				<p style="
				font-size: 16px;
				text-align: left;
				"> Adalah konsep kerjasama pembiayaan proyek secara bersama sama </p>
			</h4>
		</div>

	</div>
	
	
	
	
	



</div>

</div>



</section>


<section class="portfolio-widget" style="margin-top: -22px;     margin-bottom: 0px;">
    	<div class="container">

		<div class="row" style="box-shadow: 0 1px 6px 0 rgba(49, 53, 59, 0.12);
		background-color: #fff;
		margin-bottom: 32px;
		border-radius: 12px;
		padding: 30px;">
    <div class="col-sm-4 video_cek">
	    <div class="embed-responsive embed-responsive-16by9">
            <video class="embed-responsive-item item" src="
<?= base_url('assets/')?><?= $video_cms[0]['url']?>" type="video/mp4"  controls="controls" allowfullscreen></video>
        </div>
	</div>
	<div class="col-sm-4 video_cek">
	    <div class="embed-responsive embed-responsive-16by9">
            <video class="embed-responsive-item item" type="video/mp4"  controls="controls" src="<?= base_url('assets/')?><?= $video_cms[1]['url']?>" allowfullscreen></video>
        </div>
	</div>
	<div class="col-sm-4 video_cek">
	    <div class="embed-responsive embed-responsive-16by9">
           <video class="embed-responsive-item item" type="video/mp4"  controls="controls" src="<?= base_url('assets/')?><?= $video_cms[2]['url']?>" allowfullscreen></video>
        </div>
	</div>
	</div></div>
</section>

<script>
var vid = $(".video_cek").children().children().get(0);
vid.onplay = function() {
    $(this).parent().parent().siblings().children().children().get(0).pause();
    $(this).parent().parent().siblings().children().children().get(1).pause();
};
var vid = $(".video_cek").children().children().get(1);
vid.onplay = function() {
    $(this).parent().parent().siblings().children().children().get(0).pause();
    $(this).parent().parent().siblings().children().children().get(1).pause();
};
var vid = $(".video_cek").children().children().get(2);
vid.onplay = function() {
    $(this).parent().parent().siblings().children().children().get(0).pause();
    $(this).parent().parent().siblings().children().children().get(1).pause();
};

   
</script>

<section class="portfolio-widget" style="    margin-bottom: 0px; margin-top:0px;">

	<div class="row">
		<div class="container-fluid" style="    padding-right: 0px;">

			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<?php 
					if (count($project) > 0) {
						?>
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<?php

						if (count($project) > 1) {

							for ($i = 1; $i <= $loop; $i++) {
								?>
								<li data-target="#myCarousel" data-slide-to="<?php echo $i ?>"></li>
								<?php
							}
						}
					}
					?>
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					<?php 
					if (count($project) > 0) {
						?>
						<div class="item active">
							<div style="background-color:#f5f5f5; width:100%; height: 100%; padding: 50px; padding-top: 0px; ">
								<div class="row" style="height: 100%">
									<h2 style="color: black; text-shadow: none; margin-top: 30px; margin-bottom: 30px; text-align: center;">PROYEK BERJALAN</h2>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 block_project">
										<img class="content_project_img" 
										style="
										<?php if((14-ceil((($project[0]["end_ts"]-time())/86400)))> 14){
											?>
											filter: saturate(0.2) brightness(96%);

											<?php
										} ?>
										"
										src="<?= base_url('assets/')?>img/profile/<?php echo $project[0]["image"] ?>">
										<div class="thumbnail content_project" style="
										<?php if ((14-ceil((($project[0]["end_ts"]-time())/86400)))> 14) {
											?>
											filter: saturate(0.2) brightness(96%);

										<?php } ?>



										">

										<div class="row" style="margin-bottom: 20px">
											<h3 class="text_project"><?php echo $project[0]["nama_project"] ?></h3>

										</div>
										<div class="col-lg-6" style="font-size: 16px">
											<p style="margin-top:-27px;color:green;">Id Proyek: <?php echo $project[0]["id"] ?></p>
											<p style="color:black;">Jumlah Pendanaan : Rp. <?php echo number_format($project[0]["modal_project"],0,",",".");
											?></p>
											<p style="color:black;">Jangka Waktu (Tenor) : <?php echo $project[0]["tenor"] ?> Hari</p>
											<p style="color:black;">Harga Per Lot: Rp. <?php echo number_format($project[0]["harga_perlot"],0,",",".")?></p>
											<p style="color:black;">Jumlah Lot : <?php echo $project[0]["jumlah_lot"]  ?></p>
											<span class="sr-only" 
											id="jumlot0"> <?php echo $project[0]["jumlah_lot"]  ?></span>
											<p style="color:black;"> Jasa Platform 5% (lima persen)</p>
											<p style="color:black;">Estimasi Net Profit Rp.<?php echo number_format(($project[0]["modal_project"]*$project[0]["keuntungan"]/100),0,",","."); ?></p>

										</div>
										<div class="col-lg-6" style="font-size: 16px">
											<p class="project_profile">Profil Proyek : <span class="label label-success">      unduh          </span></p>
											<p class="rating_profile">Rating : <span class="label label-success"><?php echo $project[0]["rating"] ?></span></p>
											<p style="clear: both"></p>
											<p style="margin-bottom:0px;color:black; margin-top:0px;">Dana Terkumpul : </p>
											<div class="progress" style="margin-bottom:5px;">
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90"
												aria-valuemin="0" aria-valuemax="100" style=" width:<?php echo $project[0]['nominal']/$project[0]['modal_project']* 100 ?>%;"> <?php echo $project[0]['nominal']/$project[0]['modal_project']* 100 ?>%
											</div>
										</div>
										<p style="margin-bottom:0px;color:black;">Sisa Waktu : <span class="pull-right"><?php 


										if(ceil((($project[0]["end_ts"]-time())/86400)) < 0 ){
											echo 0;
										}else{
											echo ceil((($project[0]["end_ts"]-time())/86400));
										}


										?> hari</span> </p>
										<div class="progress" style="margin-bottom:7px;">
											<div class="progress-bar" role="progressbar" aria-valuenow="70"
											aria-valuemin="0" aria-valuemax="100" style=" width:<?php echo 100 - ceil((($project[0]["end_ts"]-time())/86400)/14*100) ?>%">
											<?php 




											if ((14-ceil((($project[0]["end_ts"]-time())/86400)))> 14) {
												echo "14 hari";
											}else{
												echo 14-ceil((($project[0]["end_ts"]-time())/86400))." hari";
											}
											?>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6"><p style="color:black;     margin-bottom: 17px;">Nilai Pendanaan</p>

											<span id="val0" style="    padding: 5px;padding-top: 10px;padding-bottom: 8px;" 
											class="label label-warning">Rp.<?php echo number_format($project[0]["harga_perlot"],0,",",".")?></span>
											<input type="number" max="<?php echo $project[0]["jumlah_lot"]  ?>" min="1" value="1" name="unit0" id="unit0" class="text_unit form-control">
										</div>
										<span id="nilaiLot0" class="sr-only"> <?php echo $project[0]["harga_perlot"]; ?></span>

										<div class="col-lg-6"><p class="tersedia" style="margin-bottom:0px;color: black">Tersedia

										</p>
										<p style="font-size: 12px;color:black; margin-bottom: 0px"><?php echo $project[0]["jumlah_lot"]-$project[0]["jumlah_pendanaan"]?>/<?php echo $project[0]["jumlah_lot"] ?></p>

										<?php if ((14-ceil((($project[0]["end_ts"]-time())/86400)))> 14) {

											?>
											<button type="button" style="background-color: #ddd;color: #999; cursor: not-allowed;" class="btn  btn-md">-</button>
											<button type="button" style="background-color: #ddd; color: #999; border:none;cursor: not-allowed;" class="btn btn-success btn-md">Beli</button>
											<button type="button" style="background-color: #ddd;color: #999;cursor: not-allowed;" class="btn  btn-md">+</button>

										<?php } else{

											if($this->session->userdata('role_id') == 3){
												?>
												<button type="button" id="min0" class="btn btn-success btn-md">-</button>
												<?php $ininih = $project[0]["id"] ?>
												<a type="button" href="<?= base_url('user/formDanai')?>?id_project=<?php echo $project[0]["id"] ?>" class="btn btn-success btn-md">Beli</a>
												<button type="button" id="add0" class="btn btn-success btn-md">+</button>								
											<?php } else{

												?>
												<button type="button" id="min0" class="btn btn-success btn-md">-</button>
												<a type="button" href="<?= base_url('auth/registration')?>" class="btn btn-success btn-md">Beli</a>
												<button type="button" id="add0" class="btn btn-success btn-md">+</button>
												<?php
											}

										} ?>

									</div>
								</div>

							</div>

							<div class="caption">



							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



		<?php
		if (count($project) > 1) {



			for ($i = 1; $i <= $loop; $i++) {

				?>
				<div class="item">

					<div style="background-color:#f5f5f5; width:100%; height: 100%; padding: 50px; padding-top: 0px;">
						<div class="row" style="height: 100%">
							<h2 style="color: black; text-shadow: none; margin-top: 30px; margin-bottom: 30px; text-align: center;">PROYEK BERJALAN</h2>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 block_project">
								<img class="content_project_img" 
								style="
								<?php if((14-ceil((($project[0]["end_ts"]-time())/86400)))> 14){
									?>
									filter: saturate(0.2) brightness(96%);

									<?php
								} ?>
								"
								src="<?= base_url('assets/')?>img/profile/<?php echo $project[$i]["image"] ?>">
								<div class="thumbnail content_project" style="
								<?php if((14-ceil((($project[0]["end_ts"]-time())/86400)))> 14){
									?>
									filter: saturate(0.2) brightness(96%);

									<?php
								} ?>


								">

								<div class="row" style="margin-bottom: 20px">
									<h3 class="text_project"><?php echo $project[$i]["nama_project"] ?></h3>

								</div>
								<div class="col-lg-6" style="font-size: 16px">
									<p style="margin-top:-27px;color:green;">Id Proyek: <?php echo $project[$i]["id"] ?></p>
									<p style="color:black;">Jumlah Pendanaan : Rp. <?php echo number_format($project[$i]["modal_project"],0,",",".");
									?></p>
									<p style="color:black;">Jangka Waktu (Tenor) : <?php echo $project[$i]["tenor"] ?> Hari</p>
									<p style="color:black;">Harga Per Lot: Rp. <?php echo number_format($project[$i]["harga_perlot"],0,",",".")?></p>
									<p style="color:black;">Jumlah Lot : <?php echo $project[$i]["jumlah_lot"]  ?></p>
									<span class="sr-only" 
									id="jumlot<?php echo $i ?>"> <?php echo $project[$i]["jumlah_lot"]  ?></span>
									<p style="color:black;">Jasa Platform 5% </p>
									<p style="color:black;">Estimasi Net Profit Rp.<?php echo number_format(($project[$i]["modal_project"]*$project[$i]["keuntungan"]/100),0,",","."); ?></p>

								</div>
								<div class="col-lg-6" style="font-size: 16px">
									<p class="project_profile">Profil Proyek : <span class="label label-success">      unduh          </span></p>
									<p class="rating_profile">Rating : <span class="label label-success"><?php echo $project[$i]["rating"] ?></span></p>
									<p style="clear: both"></p>
									<p style="margin-bottom:0px;color:black; margin-top:0px;">Uang Terkumpul : </p>
									<div class="progress" style="margin-bottom:5px;">
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90"
										aria-valuemin="0" aria-valuemax="100" style=" width:<?php echo $project[$i]['nominal']/$project[$i]['modal_project']* 100 ?>%;"> <?php echo $project[$i]['nominal']/$project[$i]['modal_project']* 100 ?>%
									</div>
								</div>
								<p style="margin-bottom:0px;color:black;">Sisa Waktu : <span class="pull-right"><?php 
								if(ceil((($project[$i]["end_ts"]-time())/86400)) < 0 ){
									echo 0;
								}else{
									echo ceil((($project[$i]["end_ts"]-time())/86400));
								}
								?> hari</span> </p>
								<div class="progress" style="margin-bottom:7px;">
									<div class="progress-bar" role="progressbar" aria-valuenow="70"
									aria-valuemin="0" aria-valuemax="100" style=" width:<?php echo 100 - ceil((($project[$i]["end_ts"]-time())/86400)/14*100) ?>%">
									<?php 

									if ((14-ceil((($project[$i]["end_ts"]-time())/86400)))> 14) {
										echo "14 hari";
									}else{
										echo 14-ceil((($project[$i]["end_ts"]-time())/86400))." hari";
									}



									?>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6"><p style="color:black;     margin-bottom: 17px;">Nilai Pendanaan</p>

									<span id="val<?php echo $i ?>" style="    padding: 5px;padding-top: 10px;padding-bottom: 8px;" 
										class="label label-warning">Rp.<?php echo number_format($project[$i]["harga_perlot"],0,",",".")?></span>
										<input type="number" max="<?php echo $project[$i]["jumlah_lot"]  ?>" min="1" value="1" name="unit0" id="unit<?php echo $i ?>" class="text_unit form-control">
									</div>
									<span id="nilaiLot<?php echo $i ?>" class="sr-only"> <?php echo $project[$i]["harga_perlot"]; ?></span>
									
									<div class="col-lg-6"><p class="tersedia" style="margin-bottom:0px;color: black">Tersedia

									</p>
									<p style="font-size: 12px;color:black; margin-bottom: 0px"><?php echo $project[$i]["jumlah_lot"]-$project[$i]["jumlah_pendanaan"]?>/<?php echo $project[$i]["jumlah_lot"] ?></p>
									<?php if ((14-ceil((($project[0]["end_ts"]-time())/86400)))> 14) {
										?>
										<button type="button" style="background-color: #ddd;color: #999; cursor: not-allowed;" class="btn  btn-md">-</button>
										<button type="button" style="background-color: #ddd; color: #999; border:none;cursor: not-allowed;" class="btn btn-success btn-md">Beli</button>
										<button type="button" style="background-color: #ddd;color: #999;cursor: not-allowed;" class="btn  btn-md">+</button>

									<?php } else{
										
										if($this->session->userdata('role_id') == 3){
											?>
											<button type="button" id="min0" class="btn btn-success btn-md">-</button>
											<a type="button" href="<?= base_url('user/formDanai')?>?id_project=<?php echo $project[0]["id"] ?>" class="btn btn-success btn-md">Beli</a>
											<button type="button" id="add0" class="btn btn-success btn-md">+</button>								
										<?php } else{

											?>
											<button type="button" id="min0" class="btn btn-success btn-md">-</button>
											<a type="button" href="<?= base_url('auth/registration')?>" class="btn btn-success btn-md">Beli</a>
											<button type="button" id="add0" class="btn btn-success btn-md">+</button>
											<?php
										}

									} ?></div>
								</div>

							</div>

							<div class="caption">



							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php


	}


}

}
?>




</div>

</div>

<!-- Left and right controls -->
<a href="#myCarousel" data-slide="prev">
	<span class="sr-only">Previous</span>
</a>
<a href="#myCarousel" data-slide="next">
	<span class="sr-only">Next</span>
</a>
</div>
</div>

</div>


</section>




<section class="portfolio-widget" style="    margin-bottom: 0px; margin-top:0px;">

	<div class="row">
		<div class="container-fluid" style="    padding-right: 0px;">

			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<?php 
					if (count($project) > 0) {
						?>
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<?php

						if (count($project) > 1) {

							for ($i = 1; $i <= $loop; $i++) {
								?>
								<li data-target="#myCarousel" data-slide-to="<?php echo $i ?>"></li>
								<?php
							}
						}
					}
					?>
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					<?php 
					if (count($project) > 0) {
						?>
						<div class="item active">
							<div style="background-color:#f5f5f5; width:100%; height: 100%; padding: 50px; padding-top: 0px; ">
								<div class="row" style="height: 100%">
									<h2 style="color: black; text-shadow: none; margin-top: 30px; margin-bottom: 30px; text-align: center;">PROYEK RETAIL BERJALAN</h2>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 block_project">
										<img class="content_project_img" style="
																				" src="https://www.devfront.fulusme.com/assets/img/profile/pulsadata.jpg">
										<div class="thumbnail content_project" style="
										


										">

										<h5 class="card-title">pinagsia cell</h5><div class="row"><div class="col-lg-12 mt-1 perlotdiv2"><h5 class="card-title" style="color: green;font-size:10px"> Id Proyek: 839555685755</h5><h5 class="card-title" style="font-size:12px"> Jangka Waktu (Tenor) : 60</h5><h5 class="card-title" style="font-size:12px">Estimasi Net Profit Rp. 40.000 </h5><h5 style="display: none;" class="hidden hargalot2">1000000 </h5><h5 style="display: none;" class="hidden jumlahpendanaan2">0.0000 </h5><p style="margin-bottom:0px;color:black; font-size:12px; margin-top:0px;">Uang Terkumpul : </p><div class="progress" style="margin-bottom:5px;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style=" width:0%;"> 0%</div></div><p style="margin-bottom:0px;color:black; font-size:12px;">Sisa Waktu : <span style="float: right!important;">3 hari</span> </p><div class="progress" style="margin-bottom:7px;"><div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style=" width:0%">3 hari </div></div><h5 class="card-title" style="font-size:10px; margin-bottom:0px"> Jasa Platform 5% </h5><div class="row"><div class="col-lg-6 nominal2"><p style="color:black;     margin-bottom: 17px; font-size:12px;">Nilai Pendanaan</p>  
 <select id="cars" name="unit0" class="unit12" style="display: inline-block; font-size:12px;padding: 5px; font-size: 14px; line-height: 1.65; color: #555; 
 background-color: #fff; background-image: none; border: 1px solid #ccc; border-radius: 4px; ">ini <option value="1000000">Rp. 1.000.000</option>  <option value="2000000">Rp. 2.000.000</option>  </select><h5 style="display: none;" class="jumlahlot2">undefined </h5><h5 style="display: none;" class="sisalot2">undefined </h5></div><div class="col-lg-6"><p class="tersedia" style="font-size:12px; margin-bottom:0px;color: black">Tersedia</p><p style="font-size: 12px;color:black; margin-bottom: 0px">0/2</p> <button class="btnDanai2 btn btn-success btn-md" type="button" style="font-size:12px;margin-left:6px; margin-right:6px;">Danai</button><h5 style="display: none;" class="hidden idproj2">0 </h5><h5 style="display: none;" class="hidden hargakirim2">0 </h5><h5 style="display: none;" class="sisalot2">undefined </h5></div></div></div></div>
							
						</div>
					</div>
				</div>
			</div>
		</div>



		<?php
		if (count($project) > 1) {



			for ($i = 1; $i <= $loop; $i++) {

				?>
				<div class="item">

					<div style="background-color:#f5f5f5; width:100%; height: 100%; padding: 50px; padding-top: 0px;">
						<div class="row" style="height: 100%">
							<h2 style="color: black; text-shadow: none; margin-top: 30px; margin-bottom: 30px; text-align: center;">PROYEK BERJALAN</h2>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 block_project">
								<img class="content_project_img" 
								style="
								<?php if((14-ceil((($project[0]["end_ts"]-time())/86400)))> 14){
									?>
									filter: saturate(0.2) brightness(96%);

									<?php
								} ?>
								"
								src="<?= base_url('assets/')?>img/profile/<?php echo $project[$i]["image"] ?>">
								<div class="thumbnail content_project" style="
								<?php if((14-ceil((($project[0]["end_ts"]-time())/86400)))> 14){
									?>
									filter: saturate(0.2) brightness(96%);

									<?php
								} ?>


								">

								<div class="row" style="margin-bottom: 20px">
									<h3 class="text_project"><?php echo $project[$i]["nama_project"] ?></h3>

								</div>
								<div class="col-lg-6" style="font-size: 16px">
									<p style="margin-top:-27px;color:green;">Id Proyek: <?php echo $project[$i]["id"] ?></p>
									<p style="color:black;">Jumlah Pendanaan : Rp. <?php echo number_format($project[$i]["modal_project"],0,",",".");
									?></p>
									<p style="color:black;">Jangka Waktu (Tenor) : <?php echo $project[$i]["tenor"] ?> Hari</p>
									<p style="color:black;">Harga Per Lot: Rp. <?php echo number_format($project[$i]["harga_perlot"],0,",",".")?></p>
									<p style="color:black;">Jumlah Lot : <?php echo $project[$i]["jumlah_lot"]  ?></p>
									<span class="sr-only" 
									id="jumlot<?php echo $i ?>"> <?php echo $project[$i]["jumlah_lot"]  ?></span>
									<p style="color:black;">Jasa Platform 5% </p>
									<p style="color:black;">Estimasi Net Profit Rp.<?php echo number_format(($project[$i]["modal_project"]*$project[$i]["keuntungan"]/100),0,",","."); ?></p>

								</div>
								<div class="col-lg-6" style="font-size: 16px">
									<p class="project_profile">Profil Proyek : <span class="label label-success">      unduh          </span></p>
									<p class="rating_profile">Rating : <span class="label label-success"><?php echo $project[$i]["rating"] ?></span></p>
									<p style="clear: both"></p>
									<p style="margin-bottom:0px;color:black; margin-top:0px;">Uang Terkumpul : </p>
									<div class="progress" style="margin-bottom:5px;">
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90"
										aria-valuemin="0" aria-valuemax="100" style=" width:<?php echo $project[$i]['nominal']/$project[$i]['modal_project']* 100 ?>%;"> <?php echo $project[$i]['nominal']/$project[$i]['modal_project']* 100 ?>%
									</div>
								</div>
								<p style="margin-bottom:0px;color:black;">Sisa Waktu : <span class="pull-right"><?php 
								if(ceil((($project[$i]["end_ts"]-time())/86400)) < 0 ){
									echo 0;
								}else{
									echo ceil((($project[$i]["end_ts"]-time())/86400));
								}
								?> hari</span> </p>
								<div class="progress" style="margin-bottom:7px;">
									<div class="progress-bar" role="progressbar" aria-valuenow="70"
									aria-valuemin="0" aria-valuemax="100" style=" width:<?php echo 100 - ceil((($project[$i]["end_ts"]-time())/86400)/14*100) ?>%">
									<?php 

									if ((14-ceil((($project[$i]["end_ts"]-time())/86400)))> 14) {
										echo "14 hari";
									}else{
										echo 14-ceil((($project[$i]["end_ts"]-time())/86400))." hari";
									}



									?>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6"><p style="color:black;     margin-bottom: 17px;">Nilai Pendanaan</p>

									<span id="val<?php echo $i ?>" style="    padding: 5px;padding-top: 10px;padding-bottom: 8px;" 
										class="label label-warning">Rp.<?php echo number_format($project[$i]["harga_perlot"],0,",",".")?></span>
										<input type="number" max="<?php echo $project[$i]["jumlah_lot"]  ?>" min="1" value="1" name="unit0" id="unit<?php echo $i ?>" class="text_unit form-control">
									</div>
									<span id="nilaiLot<?php echo $i ?>" class="sr-only"> <?php echo $project[$i]["harga_perlot"]; ?></span>
									
									<div class="col-lg-6"><p class="tersedia" style="margin-bottom:0px;color: black">Tersedia

									</p>
									<p style="font-size: 12px;color:black; margin-bottom: 0px"><?php echo $project[$i]["jumlah_lot"]-$project[$i]["jumlah_pendanaan"]?>/<?php echo $project[$i]["jumlah_lot"] ?></p>
									<?php if ((14-ceil((($project[0]["end_ts"]-time())/86400)))> 14) {
										?>
										<button type="button" style="background-color: #ddd;color: #999; cursor: not-allowed;" class="btn  btn-md">-</button>
										<button type="button" style="background-color: #ddd; color: #999; border:none;cursor: not-allowed;" class="btn btn-success btn-md">Danai</button>
										<button type="button" style="background-color: #ddd;color: #999;cursor: not-allowed;" class="btn  btn-md">+</button>

									<?php } else{
										
										if($this->session->userdata('role_id') == 3){
											?>
											<button type="button" id="min0" class="btn btn-success btn-md">-</button>
											<a type="button" href="<?= base_url('user/formDanai')?>?id_project=<?php echo $project[0]["id"] ?>" class="btn btn-success btn-md">Danai</a>
											<button type="button" id="add0" class="btn btn-success btn-md">+</button>								
										<?php } else{

											?>
											<button type="button" id="min0" class="btn btn-success btn-md">-</button>
											<a type="button" href="<?= base_url('auth/registration')?>" class="btn btn-success btn-md">Danai</a>
											<button type="button" id="add0" class="btn btn-success btn-md">+</button>
											<?php
										}

									} ?></div>
								</div>

							</div>

							<div class="caption">



							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php


	}


}

}
?>




</div>

</div>

<!-- Left and right controls -->
<a href="#myCarousel" data-slide="prev">
	<span class="sr-only">Previous</span>
</a>
<a href="#myCarousel" data-slide="next">
	<span class="sr-only">Next</span>
</a>
</div>
</div>

</div>


</section>

<!-- Portfolio -->
<section class="portfolio-widget">

	<div class="container">

		<div class="row" style="box-shadow: 0 1px 6px 0 rgba(49, 53, 59, 0.12);
		background-color: #fff;
		margin-bottom: 32px;
		border-radius: 12px;
		padding: 30px;">

		<div class="col-sm-3">

			<div class="portfolio-info">
				<h3>
					Daftar Sekarang Juga
				</h3>

				<p>Daftarkan diri dan perusahaan anda, dan dapatkan kemudahan dalam berinvestasi dan pemodalan.</p>
			</div>

		</div>

		<div class="col-sm-3">

			<!-- Portfolio Item in Widget -->				<div class="portfolio-item">
				<a href="<?= base_url('auth/registration')?>" class="image">
					<img src="<?= base_url('assetsprofile/')?>asset/images/investors.jpg" class="img-rounded" />

				</a>

				<h4>
					<a href="<?= base_url('auth/registration')?>" class="name">Registrasi Pemodal</a>
				</h4>
			</div>

		</div>

		<div class="col-sm-3">

			<!-- Portfolio Item in Widget -->				<div class="portfolio-item">
				<a href="<?= base_url('auth/registration')?>" class="image">
					<img src="<?= base_url('assetsprofile/')?>asset/images/debitur.jpg" class="img-rounded" />

				</a>

				<h4>
					<a href="<?= base_url('auth/registration')?>" class="name">Registrasi Penerbit</a>
				</h4>
			</div>

		</div>

		<div class="col-sm-3">

			<!-- Portfolio Item in Widget -->				<div class="portfolio-item">
				<a href="<?= base_url('auth')?>" class="image">
					<img src="<?= base_url('assetsprofile/')?>asset/images/login.jpg" class="img-rounded" />

				</a>

				<h4>
					<a href="<?= base_url('auth')?>" class="name">Login</a>
				</h4>
			</div>

		</div>
	</div>

</div>

</section>


<!-- Client Logos -->
