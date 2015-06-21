<div id="sidebar">
    <ul class="adminNav">
        <?php
        $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $sub_current_url = '';
        foreach ($admin_nav as $key => $parent) {
            if (!empty($parent['submenu'])) {
                $sub_current_url = '';
                foreach ($parent['submenu'] as $key => $val) {
                    if ($current_url == $val['url'] || strpos($current_url, $val['access_url'])) {
                        $sub_current_url = $val['url'];
                    }
                }
            }
			if(!empty($parent['permision']) && $parent['permision'] == true){
            ?>
            <li <?php if ($sub_current_url) { ?> class="selectednav" <?php } ?>>
                <a href="<?php echo $parent['url']; ?>"><?php echo $parent['title']; ?></a>
                <?php if (!empty($parent['submenu'])) { ?>
                    <span class="ddsub-container"></span> 
                    <ul>
                        <?php
                        foreach ($parent['submenu'] as $key => $child) {
							if(!empty($child['permision']) && $child['permision'] == true){
                            ?>
                            <li>
                                <a <?php if ($current_url == $child['url']) { ?> class="currentnav" <?php } ?> href="<?php echo $child['url']; ?>"><?php echo $child['title']; ?></a>
                            </li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </li>
        <?php } ?>
        <?php } ?>
    </ul>
</div>
