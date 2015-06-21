<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?php echo $site_title; ?> <?php echo !empty($row['title']) ? $row['title'] : '' ?></h3>
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
        <form name="add_category" action="<?php echo BASE_URL ?>admin/index.php?controller=articles&action=edit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo !empty($row['id']) ? $row['id'] : '' ?>">

            <p>
                <label>Categories : </label>
                <select name="category_id" class="medium">
                    <option value="">-----Select One-----</option>
                    <?php
                    foreach ($category_id as $key => $values) {
                        ?>
                        <option value="<?php echo $values['id'] ?>" <?php
                    if (!empty($row['category_id']) && ($values['id'] == $row['category_id'])) {
                        echo "selected='selected'";
                    }
                        ?>><?php echo $values['title'] ?></option>
                                <?php
                            }
                            ?>
                </select>
            </p>
            <p>
                <label>Name : </label>
                <input type="text" name="title" value="<?php echo !empty($row['title']) ? stripslashes($row['title']) : '' ?>" class="medium" />
            </p> 
            <p>
                <label>Description : </label>
                <textarea name="description" class="large mceEditor" cols="40" rows="10"><?php echo !empty($row['description']) ? $row['description'] : '' ?></textarea>
            </p>

            <p>
                <label>Featured Image :</label><input type="file" name="article_image" /><br/>
                <?php
                if (!empty($row['photo'])) {
                    $img_file = BASE_URL . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'articles' . DS . $row['photo'];
                    ?>
                    <img style="margin: 10px 0 0px 0; width:150px;" src="<?php echo $img_file ?>" alt="" />
                    <?php
                } else {
                    echo 'No image available';
                }
                ?>
            </p>
            <p>
                <label>Featured : </label>
                <select name="featured" class="medium">
                    <option value="no" <?php if (!empty($row['featured']) && $row['featured'] == 'no') { ?> selected="selected" <?php } ?>>No</option>
                    <option value="yes" <?php if (!empty($row['featured']) && $row['featured'] == 'yes') { ?> selected="selected" <?php } ?>>Yes</option>
                </select>            
            </p>
            <p>
                <label>Meta key: </label>
                <textarea name="meta_key" class="large" cols="40" rows="5"><?php echo !empty($row['meta_key']) ? $row['meta_key'] : '' ?></textarea>
            </p>
            <p>
                <label>Meta desc: </label>
                <textarea name="meta_desc" class="large" cols="40" rows="5"><?php echo !empty($row['meta_desc']) ? $row['meta_desc'] : '' ?></textarea>
            </p>
            <p>
                <label>Ordering : </label>
                <input style="width: 253px;"type="text" name="ordering" value="<?php echo !empty($row['ordering']) ? $row['ordering'] : '' ?>" class="medium" />
            </p>

            <p>
                <label>Status : </label>
                <select name="status" class="medium">
                    <option value="active" <?php if (!empty($row['status']) && $row['status'] == 'active') { ?> selected="selected" <?php } ?>>Active</option>
                    <option value="inactive" <?php if (!empty($row['status']) && $row['status'] == 'inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
                </select>            
            </p>
            <p><input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit"></p>
        </form>
    </div>
</div>                