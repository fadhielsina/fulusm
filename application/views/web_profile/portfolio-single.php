<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dealfintech.com/portfolio-single.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 27 Mar 2019 10:25:55 GMT -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />
	
	<title>Neon | Portfolio Item</title>
	

	<link rel="stylesheet" href="asset/css/bootstrap.css">
	<link rel="stylesheet" href="asset/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="asset/css/neon.css">

	<script src="asset/js/jquery-1.11.0.min.js"></script>

	<!--[if lt IE 9]><script src="asset/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	
</head>
<body>

<div class="wrap">
	
	<!-- Logo and Navigation --><div class="site-header-container container">

	<div class="row">
	
		<div class="col-md-12">
			
			<header class="site-header">
			
				<section class="site-logo">
				
					<a href="index.php">
								<img src="<?= base_url('assetsprofile/')?>asset/images/dealfintech.jpg" width="75" style="
								margin-left: 60px;
								">
								<br> 
								<img src="<?= base_url('assetsprofile/')?>asset/images/tag.png" width="200">
							</a>
					
				</section>
				
				<nav class="site-nav">
					
					<ul class="main-menu hidden-xs" id="main-menu">
						<li>
							<a href="index-2.html">
								<span>Home</span>
							</a>
						</li>
						<li>
							<a href="about.html">
								<span>Pages</span>
							</a>
							
							<ul>
								<li>
									<a href="about.html">
										<span>About Us</span>
									</a>
								</li>
								<li class="active">
									<a href="#">
										<span>Active Menu Item</span>
									</a>
								</li>
								<li>
									<a href="gallery.html">
										<span>Gallery</span>
									</a>
									
									<ul>
										<li>
											<a href="indexc81e.html?2">
												<span>Sub 1</span>
											</a>
										</li>
										<li>
											<a href="about.html">
												<span>Sub 2</span>
											</a>
											
											<ul>
												<li>
													<a href="contact.html">
														<span>Sub of sub 1</span>
													</a>
												</li>
												<li>
													<a href="portfolio.html">
														<span>Sub of sub 2</span>
													</a>
												</li>
											</ul>
										</li>
										<li>
											<a href="#">
												<span>Sub 3</span>
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="blog-post.html">
										<span>Blog Post</span>
									</a>
								</li>
								<li>
									<a href="portfolio-single.html">
										<span>Portfolio Item</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="active">
							<a href="portfolio.html">
								<span>Portfolio</span>
							</a>
						</li>
						<li>
							<a href="blog.html">
								<span>Blog</span>
							</a>
						</li>
						<li>
							<a href="contact.html">
								<span>Contact</span>
							</a>
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
	<!-- Breadcrumb --><section class="portfolio-item-details">
	
	<div class="container">
		
		<!-- Title and Item Details -->		<div class="row item-title">
			
			<div class="col-sm-9">
				<h1>
					<a href="#">Athletica - Fitness Center</a>
				</h1>
				
				<div class="categories">
					<a href="#">Branding</a>
				</div>
			</div>
			
			<div class="col-sm-3">
				
				<div class="text-right">
					<div class="item-detail">
						<span>Date:</span>
						20 January 2014
					</div>
					
					<div class="item-detail">
						<a href="#" class="liked">
							Liked
							<i class="entypo-heart"></i>
						</a>
					</div>
				</div>
				
			</div>
			
		</div>
		
		<!-- Portfolio Images Gallery -->		<div class="row">
			<div class="col-md-12">
				
				<div class="item-images">
				
					<a href="#">
						<img src="asset/images/portfolio-img-large.png" class="img-rounded" />
					</a>
					
					<a href="#">
						<img src="asset/images/portfolio-img-large.png" class="img-rounded" />
					</a>
					
					<a href="#">
						<img src="asset/images/portfolio-img-large.png" class="img-rounded" />
					</a>
					
					<a href="#">
						<img src="asset/images/portfolio-img-large.png" class="img-rounded" />
					</a>
					
					<a href="#">
						<img src="asset/images/portfolio-img-large.png" class="img-rounded" />
					</a>
					
					<div class="next-prev-nav">
						<a href="#" class="prev"></a>
						<a href="#" class="next"></a>
					</div>
					
					<div class="items-nav">
					</div>
				</div>
				
			</div>
		</div>
		
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{
				$(".item-images").cycle({
					slides: '> a',
					prev: '.next-prev-nav .prev',
					next: '.next-prev-nav .next',
					pager: '.items-nav',
					pagerActiveClass: 'active',
					pagerTemplate: '<a href="#">{{slideNum}}</a>',
					swipe: true
				});
			});
		</script>
		
		<!-- Portfolio Description and Other Details -->		<div class="row item-description">
			
			<div class="col-sm-8">
				
				<p class="text-justify">SiO Athletica is the sport and fitness centre run and by the Oslo Student Welfare Organization. In the Oslo and Akershus region it is a major competitor with its 15 000 members. SiO Athletica has 4 gyms located in Nydalen, Blinderen, Domus Athletica and the city centre. It was of paramount importance to revitalize the athletic offers to keep up with the competitors. Changing the name to SiO Athletica was the start in May 2013.</p>

				<p class="text-justify">SiO Athletica appears as a brand new fitness centre. The students are happy. A small survey taken after the opening of the refurbished centre in Nydalen, shows that all of the members were inspired to workout more because of the new design.</p>
				
			</div>
			
			<div class="col-sm-4">
				
				<dl>
					<dt>Client:</dt>
						<dd>Athletica</dd>
						
					<dt>Category:</dt>
						<dd>Branding</dd>
						
					<dt>Website:</dt>
						<dd>
							<a href="#" class="secondary">www.athletica.se</a>
						</dd>
				</dl>
				
			</div>
			
		</div>
		
	</div>
	
</section>

<section class="portfolio-container">
	
	<div class="container">
		
		<div class="row">
			<div class="col-md-12">
				<h3>Recent Work</h3>
			</div>
		</div>
		
		<div class="row">
			
			<div class="col-sm-4 col-xs-6">
				
				<div class="portfolio-item">
					<a href="portfolio-single.html" class="image">
						<img src="asset/images/portfolio-thumb.png" class="img-rounded" />
						<span class="hover-zoom"></span>
					</a>
					
					<h4>
						<a href="portfolio-single.html" class="like">
							<i class="entypo-heart"></i>
						</a>
						
						<a href="portfolio-single.html" class="name">Package Design</a>
					</h4>
					
					<div class="categories">
						<a href="portfolio-single.html">Branding</a>
					</div>
				</div>
				
			</div>
			
			<div class="col-sm-4 col-xs-6">
				
				<div class="portfolio-item">
					<a href="portfolio-single.html" class="image">
						<img src="asset/images/portfolio-thumb.png" class="img-rounded" />
						<span class="hover-zoom"></span>
					</a>
					
					<h4>
						<a href="portfolio-single.html" class="like">
							<i class="entypo-heart"></i>
						</a>
						
						<a href="portfolio-single.html" class="name">Google+</a>
					</h4>
					
					<div class="categories">
						<a href="portfolio-single.html">Printing</a>
					</div>
				</div>
				
			</div>
			
			<div class="col-sm-4 col-xs-6">
				
				<div class="portfolio-item">
					<a href="portfolio-single.html" class="image">
						<img src="asset/images/portfolio-thumb.png" class="img-rounded" />
						<span class="hover-zoom"></span>
					</a>
					
					<h4>
						<a href="portfolio-single.html" class="like">
							<i class="entypo-heart"></i>
						</a>
						
						<a href="portfolio-single.html" class="name">Origami</a>
					</h4>
					
					<div class="categories">
						<a href="portfolio-single.html">Package Design</a>
					</div>
				</div>
				
			</div>
			
		</div>
		
	</div>
	
</section>	
	<!-- Footer Widgets --><section class="footer-widgets">
	
	<div class="container">
		
		<div class="row">
			
			<div class="col-sm-6">
				
				<a href="#">
					<img src="asset/images/logo%402x.html" width="100" />
				</a>
				
				<p>
					Vivamus imperdiet felis consectetur onec eget orci adipiscing nunc. <br />
					Pellentesque fermentum, ante ac interdum ullamcorper.
				</p>
				
			</div>
			
			<div class="col-sm-3">
				
				<h5>Address</h5>
				
				<p>
					Loop, Inc. <br />
					795 Park Ave, Suite 120 <br />
					San Francisco, CA 94107
				</p>
				
			</div>
			
			<div class="col-sm-3">
				
				<h5>Contact</h5>
				
				<p>
					Phone: +1 (52) 2215-251 <br />
					Fax: +1 (22) 5138-219 <br />
					info@laborator.al
				</p>
				
			</div>
			
		</div>
		
	</div>
	
</section>

<!-- Site Footer --><footer class="site-footer">

	<div class="container">
	
		<div class="row">
			
			<div class="col-sm-6">
				Copyright &copy; Neon - All Rights Reserved. 
			</div>
			
			<div class="col-sm-6">
				
				<ul class="social-networks text-right">
					<li>
						<a href="#">
							<i class="entypo-instagram"></i>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="entypo-twitter"></i>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="entypo-facebook"></i>
						</a>
					</li>
				</ul>
				
			</div>
			
		</div>
		
	</div>
	
</footer>	
</div>


	<!-- Bottom Scripts -->
	<script src="asset/js/gsap/main-gsap.js"></script>
	<script src="asset/js/bootstrap.js"></script>
	<script src="asset/js/joinable.js"></script>
	<script src="asset/js/resizeable.js"></script>
	<script src="asset/js/jquery.cycle2.min.js"></script>
	<script src="asset/js/neon-custom.js"></script>

</body>

<!-- Mirrored from dealfintech.com/portfolio-single.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 27 Mar 2019 10:26:09 GMT -->
</html>