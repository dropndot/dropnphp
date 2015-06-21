<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?php echo $site_title; ?> <?php echo !empty($row['title']) ? $row['title'] : '' ?></h3>
    </div>
</div>
<br clear="all" />

<?php if (!empty($err)) { ?> 
    <p class="err"><?php echo $err ?></p>
<?php } ?>


<?php if (!empty($msg)) { ?> 
    <p class="msg"><?php echo $msg ?></p>
<?php } ?>

<a class="cancelEdit" href="index.php?controller=pages">Cancel</a>
<div class="content">
    <div class="form">
        <form name="add_category" action="<?php echo BASE_URL  ?>admin/index.php?controller=pages&action=edit" method="post"enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo !empty($row['id']) ? $row['id'] : '' ?>">
            <input type="hidden" name="old_feature_img" value="<?php echo $row['photo']; ?>" />

            <p><label>Title : </label><input type="text" name="title" value="<?php echo !empty($row['title']) ? stripslashes($row['title']) : '' ?>" class="medium"></p>
            <p><label>Description : </label><textarea name="description" class="large mceEditor" cols="40" rows="10"><?php echo !empty($row['description']) ? stripslashes($row['description']) : '' ?></textarea></p>
            <p><label>Meta key : </label><textarea name="meta_key" class="large" cols="40" rows="10"><?php echo !empty($row['meta_key']) ? stripslashes($row['meta_key']) : '' ?></textarea></p>            
            <p><label>Meta desc : </label><textarea name="meta_desc" class="large" cols="40" rows="10"><?php echo !empty($row['meta_desc']) ? stripslashes($row['meta_desc']) : '' ?></textarea></p>
            <?php if($this->app->session->get_var('group_id') == 2){ ?>
			<p><label>Controller: </label><input type="text" name="controller" value="<?php echo !empty($row['controller']) ? $row['controller'] : '' ?>" class="medium"></p>
			<?php } ?>
			<p>
                <label>Featured Photo : </label><input type="file" name="feature_img" /><br/>
                <?php
                if (!empty($row['photo'])) {
                    $img_file = BASE_URL  . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'pages' . DS . $row['photo'];
                    ?>
                    <img style="margin: 5px 0 0 0; max-width:150px;" src="<?php echo $img_file; ?>" alt="" />
                    <?php
                } else {
                    echo 'No image available';
                }
                ?>
            </p>
			<p>
                <label>Layout: </label>            
                <select name="layout" class="medium">
                    <option value="yes" <?php if (!empty($row['layout']) && $row['layout'] == 'yes') { ?> selected="selected" <?php } ?>>With Sidebar</option>
                    <option value="no" <?php if (!empty($row['layout']) && $row['layout'] == 'no') { ?> selected="selected" <?php } ?>>Full Width</option>
                </select>            
            </p>			
            <p><label>Status: </label>
                <select name="status" class="medium">
                    <option value="active" <?php if (!empty($row['status']) && $row['status'] == 'active') { ?> selected="selected" <?php } ?>>Active</option>
                    <option value="inactive" <?php if (!empty($row['status']) && $row['status'] == 'inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
                </select>

            </p>

            <p><input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit"></p>
        </form>
    </div>
</div>                