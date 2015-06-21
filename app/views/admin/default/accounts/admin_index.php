<div class="top-content">    
    <div class="uppart">
        <h2><?php echo $site_title; ?></h2>
        <p>Welcome to <?php echo $this->app->settings['site_title']; ?></p>
    </div>
    <?php if (!empty($err)) { ?> 
        <p class="err"><?php echo $err ?></p> 
    <?php } ?>
    <div class="bellowpart"> 
        <?php if (!empty($pages_allow) && $pages_allow == true) { ?>
            <div class="settblock">
                <div align="center">
                    <a href="index.php?controller=pages"><img src="<?php echo $theme_root ?>layout/images/datatable.png" alt="data table" /></a>
                    <p>Data Table</p>
                </div>
            </div> 
        <?php } ?>
        <?php if (!empty($menus_allow) && $menus_allow == true) { ?>
            <div class="settblock">
                <div align="center">
                    <a href="index.php?controller=menus"><img src="<?php echo $theme_root ?>layout/images/menuicon.png" alt="menuicon" /></a>
                    <p>Menu</p>
                </div>
            </div>
        <?php } ?>
        <?php if (!empty($settings_allow) && $settings_allow == true) { ?>
            <div class="settblock">
                <div align="center">
                    <a href="index.php?controller=default_setting"><img src="<?php echo $theme_root ?>layout/images/scrow.png" alt="datatable" /></a>
                    <p>Settings</p>
                </div>    
            </div> 
        <?php } ?>
        <?php if (!empty($newslatter_allow) && $newslatter_allow == true) { ?>
            <div class="settblock">
                <div align="center">
                    <a href="index.php?controller=newslatter"><img src="<?php echo $theme_root ?>layout/images/msgbox.png" alt="data table" /></a>
                    <p>Newslatter</p>
                </div>
            </div>
        <?php } ?>
        <div class="settblock">
            <div align="center">
                <a href="index.php?controller=profile&id=<?php echo $this->app->session->get_var('user_id'); ?>"><img src="<?php echo $theme_root ?>layout/images/manimg.png" alt="datatable" /></a>
                <p>Profile</p>
            </div> 
        </div>
    </div>
</div>
<?php if ((!empty($dashboard_allow) && $dashboard_allow == true) && ($this->app->session->get_var('group_id') != 4)) { ?>
    <div class="bottom-content">
        <div class="headline">
            <h2>Right Now</h2>
        </div>
        <div class="bellowcont-left">
            <h2 class="nowhead">Content</h2>
            <?php if (!empty($count_pages)) { ?>
                <p class="nowpage">pages<span class="nownum"><?php echo $count_pages ?></span></p>
            <?php } ?>
            <?php if (!empty($count_categories)) { ?>
                <p class="nowpage">Categories<span class="nownum"><?php echo $count_categories ?></span></p>
            <?php } ?>
            <?php if (!empty($count_articles)) { ?>
                <p class="nowpage">Articles<span class="nownum"><?php echo $count_articles ?></span></p>
            <?php } ?>             
            <?php if (!empty($count_block)) { ?>
                <p class="nowpage">Blocks<span class="nownum"><?php echo $count_block ?></span></p>
            <?php } ?>  
            <?php if (!empty($count_menus)) { ?>
                <p class="nowpage">Menus<span class="nownum"><?php echo $count_menus ?></span></p>
            <?php } ?>
        </div>
        <div class="bellowcont-right">
            <div class="present-info">
                <p class="status-info">Theme <a target="_blank" href="<?php echo BASE_URL; ?>"><?php echo $this->app->settings['site_title']; ?></a> with <span><?php echo $count_menus ?> Menus</span>
                    You are using dropnphp v.1.3</p>
            </div>
        </div>
    </div>
<?php } ?>