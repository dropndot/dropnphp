<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?php echo $site_title; ?></h3>
    </div>
</div>
<?php if (!empty($err)) { ?> 
    <p class="err"><?php echo $err ?></p>
<?php } ?>


<?php if (!empty($msg)) { ?> 
    <p class="msg"><?php echo $msg ?></p>
<?php } ?>

<a class="cancelEdit" href="index.php?controller=articles">Cancel</a>
<div class="content">
    <div class="form">
        <form name="add_articles" action="<?php echo BASE_URL ?>admin/index.php?controller=articles&action=add" method="post" enctype="multipart/form-data">

            <p>
                <label>Categories : </label><select name="category_id" class="medium">
                    <option selected="selected" value="">-----Select One-----</option>
                    <?php
                    foreach ($category_id as $key => $values) {
                        ?>
                        <option value="<?php echo $values['id'] ?>" <?php if (!empty($_POST['category_id']) && $_POST['category_id'] == $values['id']) { ?> selected="selected" <?php } ?>><?php echo $values['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </p>

            <p>
                <label>Name :</label>
                <input type="text" name="title" value="<?php echo !empty($_POST['title']) ? $_POST['title'] : '' ?>" class="medium" />
            </p>

            <p>
                <label>Description :</label>
                <textarea name="description" class="large mceEditor" cols="40" rows="10"><?php echo !empty($_POST['description']) ? $_POST['description'] : '' ?></textarea>
            </p>            

            <p>
                <label>Featured Image :</label>
                <input type="file" name="article_image" />
            </p>  
            <p>
                <label>Featured : </label>
                <select name="featured" class="medium">
                    <option value="no" <?php if (!empty($_POST['featured']) && $_POST['featured'] == 'no') { ?> selected="selected" <?php } ?>>No</option>
                    <option value="yes" <?php if (!empty($_POST['featured']) && $_POST['featured'] == 'yes') { ?> selected="selected" <?php } ?>>Yes</option>
                </select>            
            </p>
            <p>
                <label>Meta key: </label>
                <textarea name="meta_key" class="large" cols="40" rows="5"><?php echo !empty($_POST['meta_key']) ? $_POST['meta_key'] : '' ?></textarea>
            </p>
            <p>
                <label>Meta desc: </label>
                <textarea name="meta_desc" class="large" cols="40" rows="5"><?php echo !empty($_POST['meta_desc']) ? $_POST['meta_desc'] : '' ?></textarea>
            </p>            
            <p>
                <label>Ordering : </label>
                <input style="width: 253px" type="text" name="ordering" value="<?php echo !empty($_POST['ordering']) ? $_POST['ordering'] : '' ?>" class="medium">
            </p>
            <p>
                <label>Status : </label>
                <select name="status" class="medium">
                    <option value="active" <?php if (!empty($_POST['status']) && $_POST['status'] == 'active') { ?> selected="selected" <?php } ?>>Active</option>
                    <option value="inactive" <?php if (!empty($_POST['status']) && $_POST['status'] == 'inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
                </select>            
            </p>
            <p><input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit"></p>
        </form>
    </div>
</div>                