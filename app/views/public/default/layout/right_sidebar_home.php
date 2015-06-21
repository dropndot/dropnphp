<div class="rightSidebar">
    <div class="latestNews">
        <h2>Latest News & Events</h2>                        
        <?php if (!empty($latest_news)) { ?>
            <dl>
                <?php
                foreach ($latest_news as $key => $val) {
                    $description = strip_tags($val['description']);
                    ?>
                    <dd>
                        <ul class="dateFormate">
                            <li>
                                <span class="dateMonth"><?php echo date("M", strtotime($val['created'])); ?></span>
                                <span class="dateDay"><?php echo date("d", strtotime($val['created'])); ?></span>
                                <span class="dateYear"><?php echo date("Y", strtotime($val['created'])); ?></span>
                            </li>
                        </ul>
                        <h4><a href="<?php echo $site_url ; ?>index.php?controller=news_single&page=news&p_id=<?php echo $val['id']; ?>"><?php echo substr($val['title'], 0, 40); ?> </a></h4>
                        <p><?php echo substr($description, 0, 60) . '...' ?><a class="more" href="<?php echo $site_url ; ?>index.php?controller=news_single&page=news&p_id=<?php echo $val['id']; ?>">More</a></p>
                    </dd>
                <?php } ?>
            </dl> 
            <a style="color: #ff0000; text-decoration: underline;" href="index.php?controller=news_management&page=news">View More</a>
        <?php } else { ?>
            <h3>No latest news available !!</h3>
        <?php } ?>
    </div>
    <!--latestNews-->
</div>
<!--rightSidebar-->