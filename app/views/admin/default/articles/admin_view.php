<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?= $site_title; ?> <?= !empty($row['title']) ? $row['title'] : '' ?></h3>
    </div>
</div>
<div class="addSearch">
    <div class="addarea">
        <a href="index.php?controller=products">Back to Product</a>
    </div>
</div>
<!--addSearch-->

<div class="content">
    <div class="form">
        <p>
            <label>Categories : </label>
            <?php
            foreach ($category_id as $key => $values) {
                if (!empty($row['category_id']) && ($values['id'] == $row['category_id'])) {
                    $cat_title = $values['title'];
                }
            }
            ?>
            <input type="text" name="" value="<?php echo stripslashes($cat_title); ?>" class="medium" />
        </p>
        <p>
            <label>Title : </label>
            <input type="text" name="" value="<?php echo stripslashes($row['title']); ?>" class="medium" />
        </p> 
        <p>
            <label>Description : </label>
            <textarea name="" class="large mceEditor" cols="40" rows="10"><?php echo $row['description']; ?></textarea>
        </p>
<!--        <p>
            <label>Short Description :</label>
            <textarea name="" class="large" cols="40" rows="10"><?php echo $row['short_description']; ?></textarea>
        </p>-->

        <p>
            <label>Performance Range :</label>
            <textarea name="" class="large" cols="40" rows="10"><?php echo $row['performance']; ?></textarea>
        </p>

        <p>
            <label>Application Limit :</label>
            <textarea name="" class="large" cols="40" rows="10"><?php echo $row['application']; ?></textarea>
        </p>
        <p>
            <label>Brand : </label>
            <?php
            foreach ($brands as $key => $values) {
                if (!empty($row['brand']) && $row['brand'] == $values['id']) {
                    $brand_title = $values['title'];
                }
            }
            ?>
            <input type="text" name="" value="<?php echo $brand_title; ?>" class="medium" />
        </p>
        <p>
            <label>Range : </label>
            <?php
            foreach ($series as $key => $values) {
                if (!empty($row['series']) && $row['series'] == $values['id']) {
                    $series_title = $values['title'];
                }
            }
            ?>
            <input type="text" name="" value="<?php echo $series_title; ?>" class="medium" />
        </p>
        <p>
            <label>Usages : </label>
            <?php
            foreach ($usages as $key => $values) {
                if (!empty($row['usages']) && $row['usages'] == $values['id']) {
                    $usages_title = $values['title'];
                }
            }
            ?>
            <input type="text" name="" value="<?php echo $usages_title; ?>" class="medium" />
        </p>
<!--        <p>
            <label>HP : </label>
            <?php
            foreach ($hp as $key => $values) {
                if (!empty($row['hp']) && $row['hp'] == $values['id']) {
                    $hp_title = $values['title'];
                }
            }
            ?>
            <input type="text" name="" value="<?php echo $hp_title; ?>" class="medium" />
        </p>-->
        <p>
            <label>Liquide : </label>
            <?php
            foreach ($liquide as $key => $values) {
                if (!empty($row['liquide']) && $row['liquide'] == $values['id']) {
                    $liquide_title = $values['title'];
                }
            }
            ?>
            <input type="text" name="" value="<?php echo $liquide_title; ?>" class="medium" />
        </p>
<!--        <p>
            <label>Material : </label>
            <input type="text" name="" value="<?php echo $row['material']; ?>" class="medium" />
        </p>
        <p>
            <label>Color : </label>
            <input type="text" name="" value="<?php echo $row['color']; ?>" class="medium" />
        </p>
        <p>
            <label>Weight : </label>
            <input type="text" name="" value="<?php echo $row['weight']; ?>" class="medium" />
        </p>
        <p>
            <label>Price(TK) : </label>
            <input type="text" name="" value="<?php echo $row['price']; ?>" class="medium" />
        </p>-->
        <p>
            <label>Product Image :</label>
            <?php
            if (!empty($row['photo'])) {
                $img_file = $site_url . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'products' . DS . $row['photo'];
                ?>
                <img style="margin: 0;" src="<?php echo $resize_image_path; ?>src=<?= $img_file ?>&w=150&h=100&zc=1" alt="" />
                <?php
            } else {
                echo 'No image available';
            }
            ?>
        </p>
        <p>
            <label>Product Data Sheet :</label>
            <?php if (!empty($row['product_data_sheet'])) { ?>
                <span style="font-size: 13px;">Product data sheet available.</span>
            <?php } else { ?>
                <span style="font-size: 13px; color: #ff0000;">No Product data sheet available !!!</span>
            <?php } ?>
        </p>
        <p>
            <label>Featured : </label>
            <input type="text" name="" value="<?php echo $row['featured']; ?>" class="medium" />
        </p>
        <p>
            <label>Meta key: </label>
            <textarea name="" class="large" cols="40" rows="5"><?php echo $row['meta_key']; ?></textarea>
        </p>
        <p>
            <label>Meta desc: </label>
            <textarea name="" class="large" cols="40" rows="5"><?php echo $row['meta_desc']; ?></textarea>
        </p>
    </div>
</div>                