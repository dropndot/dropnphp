<div class="outerBanner">
    <div class="innerBanner">
        <div class="wrap">
            <div class="bannerArea">
                <div class="contentArea">
                    <?php if (!empty($banner_images)) { ?>
                        <div class="sliderArea">
                            <div class="slider-wrapper theme-default">
                                <div class="ribbon"></div>             
                                <div id="slider" class="nivoSlider">
                                    <?php
                                    $base_address_images = $site_url  . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'banner_management' . DS;
                                    foreach ($banner_images as $key => $value) {
                                        ?>
                                        <img src="<?php echo $base_address_images . 'thmb' . DS . $value['photo']; ?>" alt="<?php echo $value['title']; ?>" title="" />
                                    <?php }; ?>  
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(window).load(function() {
                                    $('#slider').nivoSlider({
                                        controlNav: false,
                                        animSpeed: 300,
                                        directionNavHide: false
                                    });
                                });
                            </script>
                        </div>
                        <!--sliderArea-->
                    <?php } ?>
                </div>
                <!--contentArea-->
                <div class="rightSidebar">
                    <?php echo $banner_right_block; ?>                    	
                </div>
                <!--rightSidebar-->
            </div>
            <!--bannerArea-->
        </div>
    </div>
</div>
<div class="mainbody">
    <div class="wrap">
        <div class="contentArea">
            <div class="homeContentTop">
                <div class="welcome">
                    <div class="content">
                        <?php echo $page_content['description']; ?>
                    </div>
                    <!--content-->
                </div>	
                <div class="homeVideo">
                    <?php echo $Home_video; ?>
                </div>
            </div>	
            <!--homeContentTop-->
            <dl class="homeContentMiddle">
                <dd>
                    <div class="shopView">
                        <img src="<?php echo $image_path; ?>images/shop-img1.jpg" alt="" />
                        <div class="shopViewInfo">
                            <h4>Premier <span class="sp2">Shop</span></h4>
                            <a href="#"><img src="<?php echo $image_path; ?>images/view-shopbtn.png" alt="" /></a>
                        </div>
                    </div>                		
                </dd>
                <dd>
                    <a href="#"><img src="<?php echo $image_path; ?>images/dining.jpg" alt="" /></a>
                </dd>
                <dd>
                    <a href="#"><img src="<?php echo $image_path; ?>images/gift-card.jpg" alt="" /></a>	
                </dd>	
            </dl>
            <!--homeContentMiddle-->
            <dl class="homeContentBottom">
                <dd>
                    <div class="mallHour">
                        <?php echo $mall_hours; ?>	
                    </div>
                </dd>
                <dd>
                    <div class="newsLater">
                        <?php if (!empty($success)) { ?>
                            <h3 style="color:#10eb13; font-size: 16px; padding: 0 0 5px 30px; margin: -10px 0 0 0;"><?php echo $success ?></h3>
                        <?php } ?>
                        <?php if (!empty($err)) { ?>
                            <h3 style="color:#f25904; font-size: 16px; padding: 0 0 5px 30px; margin: -10px 0 0 0;"><?php echo $err ?></h3>
                        <?php } ?>
                        <h4>Join Our Mailing List</h4>
                        <p>Enter to recieve exclusive offers,<br  />updates and new product information! </p>
                        <div class="newslaterForm">                            
                            <form action="<?php echo $site_url  ?>" method="post">
                                <label>Email Address</label>
                                <input type="text" name="email" />
                                <input type="hidden" value="Submit" name="submit" />
                            </form>
                            <span class="sp3"></span>
                        </div>	
                    </div>
                </dd>
            </dl>
        </div>