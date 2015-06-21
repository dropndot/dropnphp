<section id="signup" class="signup-newsletter">
	   <div class="container">
            <div class="row">

                <div class="col-sm-8 col-md-8">
                    <div class="signup wow fadeInDown">
                        <div class="pull-left">
                            <img class="img-responsive" src="<?php echo $theme_root; ?>layout/images/signup-icon.png">
                        </div>
                        <div class="sign-body">
                            <h3 class="sign-heading">Sign up for media alerts </h3>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                        </div>
                    </div>
                </div>
				<div class="col-sm-4 col-md-4">
                    <div class="wow fadeInDown">
                        <div class="pull-left">
                            <img class="img-responsive" src="<?php echo $theme_root; ?>layout/images/rss.png">
                        </div>
                        <div class="sign-body">
                            <div class="input-group">
							  <input type="text" class="form-control" placeholder="Enter your email">
							  <span class="input-group-btn">
								<button class="btn btn-default" type="button">SUBMIT</button>
							  </span>
							</div><!-- /input-group -->
                        </div>
                    </div>
                </div>

                                                
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#services-->

   

    <section id="bottom-content">
        <div class="container wow fadeInDown">
            <div class="row">
                <div class="col-xs-12 col-sm-4 wow fadeInDown">
					<div class="content-link">
						<div class="title">
							<h2  class="main-heading">who is TCA</h2>
						</div>
						<ul>
							<li><a href="#">TCA Corporate</a> </li>
							<li><a class="active" href="#">Media Interview Opportunities</a></li>
							<li><a href="#">Press Releases</a></li>
							<li><a href="#">Media Kits</a></li>
							<li><a href="#">Fact Sheets</a></li>
							<li><a href="#">Data and Statistics</a></li>
						</ul>
					</div>
                </div>

                <div class="col-xs-12 col-sm-4 wow fadeInDown">
                    <div class="content-link custom-carousel">
						<div class="title">
							<h2  class="main-heading">press registration</h2>
						</div>
						<div class="content">
							<div class="carousel slide" data-ride="carousel" id="registration-carousel">
								<!-- Carousel Slides / Quotes -->
								<div class="carousel-inner text-center">	
									
									<div class="item active">
										<div class="row">
											 <img src="<?php echo $theme_root; ?>layout/images/press.jpg" class="img-responsive">
										</div>
									</div>
									
									<div class="item">
										<div class="row">
											 <img src="<?php echo $theme_root; ?>layout/images/video2.jpg" class="img-responsive">
										</div>
									</div>
									
								</div>
								 
								<a data-slide="prev" href="#registration-carousel" class="left carousel-control"><i class="fa fa-angle-left"></i></a>
								<a data-slide="next" href="#registration-carousel" class="right carousel-control"><i class="fa fa-angle-right"></i></i></a>
							</div>
							<p>Sed ut perspiciatis unde omnis iste natus error sit accusantium doloremque laudantium. Sed ut perspiciatis unde omnis iste natus error sit voluptatem.</p>
						</div>						
					</div>
                </div>
				
				<div class="col-xs-12 col-sm-4 wow fadeInDown">
                    <div class="content-link">
						<div class="ad-space">
							<img src="<?php echo $theme_root; ?>layout/images/add-space.jpg" alt="">
						</div>
					</div>
					
					<div class="content-link sponsor">
						<div class="spansor-space">
							<img src="<?php echo $theme_root; ?>layout/images/sponsor.jpg" alt="">
						</div>
					</div>
                </div>

            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#content-->

    <section id="corporates">
        <div class="container">
			<div class="row">
				<div class="partners">
					<ul>
						
						<li class="doc wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms" > 
							<a href="#">
								<strong>Request a quote</strong>
								<span>Click here</span>
							</a>
						</li>
						<li class="doller wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms" > 
							<a href="#">
								<strong>Our Pricing</strong>
								<span>Click here</span>
							</a>
						</li>
						
						<li class="shopping wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="900ms" > 
							<a href="#">
								<strong>Buy Products</strong>
								<span>Click here</span>
							</a>
						</li>
						<li class="bono wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="1200ms" > 
							<a href="#">
								<strong>pro bono/free pr</strong>
								<span>Click here</span>
							</a>
						</li>
						<li class="testimonial wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="1500ms" > 
							<a href="#">
								<strong>Testimonials</strong>
								<span>Click here</span>
							</a>
						</li>
					</ul>
				</div>
			</div>	
        </div><!--/.container-->
    </section><!--/#partner-->
 
    
    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">			
                <div class="col-sm-12 footer-logo wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
				<?php if(!empty($this->app->settings['footer_logo'])){ ?>
                      <a href="<?php echo BASE_URL; ?>"><img src="<?php echo 'app/resources/document/settings/' . $this->app->settings['footer_logo']; ?>" alt=""></a>
					  <?php }else{?>
                      <a href="index.html"><img src="<?php echo $theme_root; ?>layout/images/logo-footer.png" alt=""></a>
					  <?php } ?>
                </div>				
				<?php if(!empty($footer_menu)){?>
                <div class="col-sm-12 footer-nav wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
					<?php echo $footer_menu; ?>
                </div>
				<?php }?>
				<?php if(!empty($footer_menu)){?>
				<div class="col-sm-12 copyright wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="900ms">
                      <?php echo $this->app->settings['footer_txt'];?>
                </div>
				<?php } ?>
            </div>
        </div>
    </footer><!--/#footer-->
	<!-- Core js -->
	<script type="text/javascript" language="javascript" src="<?php echo $theme_root; ?>layout/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $theme_root; ?>layout/bootstrap/js/bootstrap.min.js"></script>	
	<script type="text/javascript" language="javascript" src="<?php echo $theme_root; ?>layout/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $theme_root; ?>layout/js/jquery.isotope.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $theme_root; ?>layout/js/main.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $theme_root; ?>layout/js/wow.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $theme_root; ?>layout/bootstrap/js/custom.js"></script>
	<!-- Core js -->

</body>
</html>
