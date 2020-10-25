<?php

	require_once "config.php";
	require_once "vendor/autoload.php";
	
	User::acesso();
	$info = Site::slider();
	$listResumes = Site::resumes();
	$listPortifolios = Portifolio::listProtifolios();
	$aboutMe = About::selectedAbout();
	$listTestimonial = Testimonial::listTestimonial();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Rezume Free Template by Colorlib</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="asset/site/css/animate.css">
	<link rel="stylesheet" href="asset/site/css/flexslider.css">
	<link rel="stylesheet" href="asset/site/fonts/icomoon/style.css">

	<link rel="stylesheet" href="asset/site/css/bootstrap.css">
	<link rel="stylesheet" href="asset/site/css/style.css">

	<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700" rel="stylesheet">


</head>
<body data-spy="scroll" data-target="#pb-navbar" data-offset="200">



	<nav class="navbar navbar-expand-lg site-navbar navbar-light bg-light" id="pb-navbar">

		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>


			<div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample09">
				<ul class="navbar-nav">
					<li class="nav-item"><a class="nav-link" href="#section-home">Home</a></li>
					<li class="nav-item"><a class="nav-link" href="#section-portfolio">Portfolio</a></li>
					<li class="nav-item"><a class="nav-link" href="#section-resume">Resumo</a></li>
					<li class="nav-item"><a class="nav-link" href="#section-about">Sobre</a></li>
				</ul>
			</div>
		</div>
	</nav>




	<section class="site-hero" style="background-image: url(painel/<?= $info[0]['image'] ?>);" id="section-home" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="row intro-text align-items-center justify-content-center">
				<div class="col-md-10 text-center pt-5">

					<h1 class="site-heading site-animate"><?= $info[0]['title'] ?><strong class="d-block"></strong></h1>
					<strong class="d-block text-white text-uppercase letter-spacing"><?= $info[0]['subtitle']?></strong>

				</div>
			</div>
		</div>
	</section> <!-- section -->






	<section class="site-section" id="section-portfolio">
		<div class="container">
			<div class="row">
				<div class="section-heading text-center col-md-12">
					<h2>Featured <strong>Portfolio</strong></h2>
				</div>
			</div>
			<div class="filters">
				<ul>
					<li class="active" data-filter="*">Totos</li>
					<?php
						foreach ($listPortifolios as $key => $value) {
							echo '
							<li class="" data-filter=".'.$value['category'].'">'.$value['category'].'</li>';
						}
					?> 
				</ul>
			</div>

			<div class="filters-content">
				<div class="row grid">
					<?php
						foreach ($listPortifolios as $key => $value) {
							echo '<div class="single-portfolio col-sm-4 all '.$value['category'].'">
							<div class="relative">
								<div class="thumb">
									<div class="overlay overlay-bg"></div>
									<img class="image img-fluid" src="painel/'.$value['image'].'" alt="">
								</div>
								<a href="asset/site/images/p1.jpg" class="img-pop-up">  
									<div class="middle">
										<div class="text align-self-center d-flex"><img src="asset/site/images/preview.png" alt=""></div>
									</div>
								</a>                                  
							</div>
							<div class="p-inner">
								<h4>'.$value['title'].'</h4>
								<div class="cat">'.$value['category'].'</div>
							</div>                                         
						</div>';
						}
					?> 
			</div>
		</div>
	</section>
	<!-- .section -->

	
	<section class="site-section " id="section-resume">
		<div class="container">
			<div class="row">
				<div class="col-md-12 mb-5">
					<div class="section-heading text-center">
						<h2>My <strong>Resume</strong></h2>
					</div>
				</div>
				<div class="col-md-6">
					<h2 class="mb-5">Education</h2>

					<?php
						foreach ($listResumes as $key => $value) {
							if($value['category'] == 'Educação'){
								echo '<div class="resume-item mb-4">
								<span class="date"><span class="icon-calendar"></span> '.$value['create_at'].'</span>
								<h3>'.$value['title'].'</h3>
								<p>'.$value['body'].'</p>
								<span class="school">'.$value['location'].'</span>
							</div>';
							}
						}
					?>
				</div>
				<div class="col-md-6">
					<h2 class="mb-5">Experience</h2>
					<?php
						foreach ($listResumes as $key => $value) {
							if($value['category'] == 'Experiência'){
								echo '<div class="resume-item mb-4">
								<span class="date"><span class="icon-calendar"></span> '.$value['create_at'].'</span>
								<h3>'.$value['title'].'</h3>
								<p>'.$value['body'].'</p>
								<span class="school">'.$value['location'].'</span>
							</div>';
							}
						}
					?>
				</div>
			</div>
		</div>
	</section> <!-- .section -->

	<section class="site-section" id="section-about">
		<div class="container">
			<div class="row mb-5 align-items-center">
				<?php 
					if(isset($aboutMe)){
						?>
							<div class="col-lg-7 pr-lg-5 mb-5 mb-lg-0">
								<img src="<?= isset($aboutMe[0]['photo']) ? 'painel/'.$aboutMe[0]['photo'] : 'asset/site/images/image_1.jpg' ?>" alt="Image placeholder" class="img-fluid">
							</div>
						<?php
					}
						
				?>
				
				<div class="col-lg-5 pl-lg-5">
					<?php
						if(isset($aboutMe)){
							echo '<div class="section-heading">
							<h2>'.$aboutMe[0]['title'] .'</h2>
						</div>
						<p class="lead">Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
						<p class="mb-5  ">'. $aboutMe[0]['body'] .'</p>';
						}
					?>

					<p>
						<a href="#section-contact" class="btn btn-primary px-4 py-2 btn-sm smoothscroll">Hire Me</a>
						<a href="#" class="btn btn-secondary px-4 py-2 btn-sm">Download CV</a>
					</p>
				</div>
			</div>


		</div>
	</section>

	<section class="site-section">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12">
					<div class="section-heading text-center">
						<h2>Client <strong>Testimonial</strong></h2>
					</div>
				</div>
			</div>
			<div class="row">
				<?php
					foreach ($listTestimonial as $key => $value) {
						echo '<div class="col-md-6">

								<div class="block-47 d-flex mb-5">
									<div class="block-47-image">
										<img src="painel/'.$value['photo'].'" alt="Image placeholder" class="img-fluid">
									</div>
									<blockquote class="block-47-quote">
										<p>&ldquo;'.$value['testimonial'].'&rdquo;</p>
										<cite class="block-47-quote-author">&mdash; '.$value['name'].' </cite>
									</blockquote>
								</div>
			
							</div>';
					}
				?>
			</div>
		</div>
	</section>


	<footer class="site-footer">
		<div class="container">
			
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<p>
						<a href="#" class="social-item"><span class="icon-facebook2"></span></a>
						<a href="#" class="social-item"><span class="icon-twitter"></span></a>
						<a href="#" class="social-item"><span class="icon-instagram2"></span></a>
						<a href="#" class="social-item"><span class="icon-linkedin2"></span></a>
					</p>
				</div>
			</div>
			
		</div>
	</footer>




	<script src="asset/site/js/vendor/jquery.min.js"></script>
	<script src="asset/site/js/vendor/jquery-migrate-3.0.1.min.js"></script>
	<script src="asset/site/js/vendor/popper.min.js"></script>
	<script src="asset/site/js/vendor/bootstrap.min.js"></script>

	<script src="asset/site/js/vendor/jquery.easing.1.3.js"></script>

	<script src="asset/site/js/vendor/jquery.stellar.min.js"></script>
	<script src="asset/site/js/vendor/jquery.waypoints.min.js"></script>

	<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
	<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
	<script src="asset/site/js/custom.js"></script>

	<!-- Google Map -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    	<script src="js/google-map.js"></script> -->

    </body>
    </html>