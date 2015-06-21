<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<?php if(!empty($this->app->settings['favicon_icon'])){?>
		<link rel="icon" type="image/png" href="<?php echo 'app/resources/document/settings/' . $this->app->settings['favicon_icon']; ?>">
		<?php }?>
        <title><?php echo $page_title ?> :: <?php echo $site_title ?></title>
        <?php
        if ((!empty($_REQUEST['controller']) && $_REQUEST['controller'] == 'product_details') || (!empty($_REQUEST['controller']) && $_REQUEST['controller'] == 'news_single')) {
            if (!empty($post_content['meta_key'])) {
                ?>
                <meta name="keywords" content="<?php echo strip_tags($post_content['meta_key']) ?>">
                <?php } else { ?>
                    <meta name="keywords" content="<?php echo $this->app->settings['site_meta_key'] ?>">
                    <?php } ?>
                    <?php if (!empty($post_content['meta_desc'])) { ?>
                        <meta name="description" content="<?php echo strip_tags($post_content['meta_desc']) ?>">
                        <?php } else { ?>
                            <meta name="description" content="<?php echo $this->app->settings['site_meta_description'] ?>">
                                <?php
                            }
                        } else {
                            if (!empty($page_content['meta_key'])) {
                                ?>
                                <meta name="keywords" content="<?php echo strip_tags($page_content['meta_key']) ?>"> 
                                <?php } else { ?>    
                                    <meta name="keywords" content="<?php echo $this->app->settings['site_meta_key'] ?>"> 
                                    <?php } ?>
                                    <?php if (!empty($page_content['meta_desc'])) { ?>
                                        <meta name="description" content="<?php echo strip_tags($page_content['meta_desc']) ?>">
                                        <?php } else { ?>
                                            <meta name="description" content="<?php echo $this->app->settings['site_meta_description'] ?>">
                                            <?php } ?>
                                            <?php
                                        }
                                        ?> 
										<!-- core css -->
										<link href="<?php echo $theme_root; ?>layout/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
										<link href="<?php echo $theme_root; ?>layout/font_awesome/font-awesome.min.css" rel="stylesheet" type="text/css" />
										<link href="<?php echo $theme_root; ?>layout/bootstrap/css/animate.min.css" rel="stylesheet" type="text/css" />
										<link href="<?php echo $theme_root; ?>layout/bootstrap/css/prettyPhoto.css" rel="stylesheet" type="text/css" />
										<link href="<?php echo $theme_root; ?>layout/styles/style.css" rel="stylesheet" type="text/css" />
										<link href="<?php echo $theme_root; ?>layout/bootstrap/css/responsive.css" rel="stylesheet" type="text/css" />
										<link href="<?php echo $theme_root; ?>layout/styles/custom.css" rel="stylesheet" type="text/css" />
										<!-- core css -->
                                       
                                        </head>
                                        <body>
                                            <header id="header">
        <div class="top-bar">
            <div class="container main-nav">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-4">
					<?php if (!empty($logo)) { ?>
                        <a class="navbar-brand" href="<?php echo BASE_URL ; ?>"><img src="<?php echo 'app/resources/document/settings/' . $logo; ?>" alt="Site Logo" /></a> 
                    <?php } else { ?>   
                    <a class="logo" href="<?php echo BASE_URL ; ?>"><img src="<?php echo $theme_root; ?>layout/images/logo.png" alt="Site Logo" /></a>	
                    <?php } ?>
                    </div>
					 <div class="header-add col-md-4 col-sm-6 col-xs-4">
					 <?php if($this->app->settings['header_add_space']){?>
						<img src="<?php echo 'app/resources/document/settings/' . $this->app->settings['header_add_space']; ?>" alt="add">
						<?php }else{ ?>
						<img src="<?php echo $theme_root; ?>layout/images/add.jpg" alt="add">
						<?php } ?>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-8">
                       <div class="social">
                            <ul class="social-share">
                                
                                <li><a class="android" href="#"><i class="fa fa-android"></i></a></li>
								<li><a class="apple" href="#"><i class="fa fa-apple"></i></a></li>
                                <li>
								<a class="facebook" href="<?php echo $this->app->settings['facebook_url'];?>"><i class="fa fa-facebook"></i></a>
								</li>
                                <li>
								<a class="twitter" href="<?php echo $this->app->settings['twitter_url'];?>"><i class="fa fa-twitter"></i></a>
								</li>
                                <li>
								<a class="google" href="<?php echo $this->app->settings['google_plus_url'];?>"><i class="fa fa-google-plus"></i></a>
								</li>
                                <li>
								<a class="linkedin" href="<?php echo $this->app->settings['linkedin_url'];?>"><i class="fa fa-linkedin"></i></a>
								</li> 
                                <li><a class="instagram" href="#"><i class="fa fa-instagram"></i></a></li> 
                                <li><a class="youtube" href="#"><i class="fa fa-youtube"></i></a></li>
                                <li><a class="pinterest" href="#"><i class="fa fa-pinterest"></i></a></li>
                                <li><a class="rss" href="#"><i class="fa fa-rss"></i></a></li>
                            </ul>
                            
                       </div>
					   <div class="media-login">
							<a href="#">Media Log-in</a>
					   </div>
                    </div>
                </div>
            </div><!--/.container-->
        </div><!--/.top-bar-->
<?php if(!empty($header_main_nav)){ ?>
        <nav class="navbar navbar-inverse" role="banner">
            <div class="container main-nav">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
                </div>
				
                <div class="collapse navbar-collapse navbar-right">
					<?php echo $header_main_nav;?>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
		<?php } ?>		
    </header><!--/header-->