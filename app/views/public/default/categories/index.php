<div class="outerBanner">
    <div class="innerBanner">
        <div class="wrap">
            <div class="bannerArea subpageBannerArea">
                <img src="<?php echo $image_path; ?>images/sub-banner.jpg" alt="" />
            </div>
            <!--bannerArea-->
        </div>
    </div>
</div>
<div class="mainbody">
    <div class="wrap">
        <div class="contentArea">
            <div class="content">
                <?php echo stripslashes($page_content['description']) ?>
            </div>
            <div class="leftSidebar">
                <div class="leftSidebarMenu">
                    <?php if (!empty($shop_categories)) { ?>
                        <h2>Shop listing</h2>
                        <ul>
                            <?php foreach ($shop_categories as $key => $val) { ?>
                                <li><a href="<?php echo $site_url ; ?>index.php?controller=categories&page=shop&c_id=<?php echo $val['id']; ?>"><?php echo $val['title']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <!--leftSidebarMenu-->
                <div class="sorting">
                    <h2>Sort By</h2>
                    <ul>
                        <li><a href="<?php echo $site_url ; ?>index.php?controller=categories&page=shop&c_id=<?php echo $_GET['c_id']; ?>">Last Added</a></li>
                        <li class="last"><a href="<?php echo $site_url ; ?>index.php?controller=categories&page=shop&c_id=<?php echo $_GET['c_id']; ?>&sr=al">Alphabetically</a></li>
                    </ul>
                </div>
            </div>
            <!--leftsidebar-->
            <div class="pageContentCon">
                <?php if (!empty($shop_list)) { ?>
                    <div class="pageCon">
                        <dl>
                            <?php foreach ($shop_list as $key => $val) { ?>
                                <dd>
                                    <h2><?php echo $val['title']; ?></h2>
                                    <?php echo substr($val['description'], 0, 65); ?>
                                    <p>
                                        <a class="fl" href="#"><img src="<?php echo $image_path; ?>images/store-locatorbtn.gif" alt="" /></a>
                                        <a class="fr" href="<?php echo $site_url ; ?>index.php?controller=single&page=shop&p_id=<?php echo $val['id']; ?>"><img src="<?php echo $image_path; ?>images/view-detailsbtn.gif" alt="" /></a>
                                    </p>
                                </dd>
                            <?php } ?>
                        </dl>
                        <?php echo $paging; ?> 		
                        <!--pagination-->
                    </div>
                <?php } ?>
            </div>	
            <!--pageContent-->
        </div>