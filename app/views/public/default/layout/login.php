<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $page_title; ?> :: <?php echo $site_title; ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_root ?>layout/admin_login/style.css">
    </head>
    <body>
        <div id="wrap">
            <!-- header -->
            <div id="inner" class="ddlogin-wrap">
                <div id="contents-sidebar-wrap">
                    <div id="contents">
                        <div class="logoblock-header" align="center">
						<?php if(!empty($this->app->settings['site_logo'])){?>
                            <a target="_blank" class="ddlogo" href="<?php echo BASE_URL ; ?>"><img src="app/resources/document/settings/<?php echo $this->app->settings['site_logo']; ?>" alt="admin logo" /></a>
							<?php }else{?>
                            <p class="ddlogo-textheader"><?php echo $this->app->settings['site_title']; ?></p>
							<?php } ?>
                        </div>
                        <div class="ddlogin-form" align="center">
                            <?php include($display_view_file); ?>
                        </div>
                        <!--ddlogin-form-->
                    </div>
                    <!-- contents -->
                </div>
                <!-- end #contents-sidebar-wrap -->				
            </div>
            <!-- end #inner -->
        </div>
        <!-- wrapper -->
        <div class="footwrap">
            <div id="footer">
                <div class="logoblock-footer">
                    <a target="_blank" class="ddlogo" href="<?php echo $site_url ; ?>"><img style="float: left;margin: 0 10px 0 0;" src="app/resources/document/settings/<?php echo $this->app->settings['admin_site_logo']; ?>" alt="admin logo" /></a>
                    <p style="line-height: 14px;" class="ddlogo-textfooter"><?php echo $this->app->settings['admin_footer_copy_right_txt']; ?></p>
                </div>
            </div>
            <!-- end #footer -->
        </div>
    </body>
</html>
