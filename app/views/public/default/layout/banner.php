<?php if (!empty($banner_images)) { ?>
<section id="main-slider" class="no-margin">
        <div class="carousel slide">
            <ol class="carousel-indicators">
                <li data-target="#main-slider" data-slide-to="0" class="active"></li>
                <li data-target="#main-slider" data-slide-to="1"></li>
                <li data-target="#main-slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
				<?php      
					$active = 'active';
                    foreach ($banner_images as $key => $value) {
					if(!empty($value['photo'])){
						$img_url = BASE_URL . 'app' . DS . 'resources' . DS . 'document' . DS . 'banner_management' . DS .$value['photo'] ; 
                ?>
                <div class="item <?php echo $active;?>" style="background-image: url(<?php echo $img_url; ?>)">
                        <div class="row slide-margin">
                            <div class="col-sm-7">
                                <div class="carousel-content">
									<div class="content-text ">
										<h2 class="animation animated-item-1"><?php echo $value['caption'];?></h2>
									</div>
							   </div>
                            </div>                        
                        </div>
                </div><!--/.item-->
					<?php 
					}
					$active = '';
					}
					?>                
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="fa fa-chevron-right"></i>
        </a>
    </section><!--/#main-slider-->
	<?php } ?>