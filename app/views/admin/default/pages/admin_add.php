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

<a class="cancelEdit" href="index.php?controller=pages">Cancel</a>
<div class="content">
    <div class="form">
        <form name="add_articles" action="<?php echo BASE_URL  ?>admin/index.php?controller=pages&action=add" method="post" enctype="multipart/form-data">

            <p><label>Title : </label><input type="text" name="title" value="<?php echo !empty($_POST['title']) ? $_POST['title'] : '' ?>" class="medium"></p>

            <p><label>Description : </label><textarea name="description" class="large mceEditor" cols="40" rows="10"><?php echo !empty($_POST['description']) ? $_POST['description'] : '' ?></textarea></p>
            <p><label>Meta key : </label><textarea name="meta_key" class="large" cols="40" rows="10"><?php echo !empty($_POST['meta_key']) ? $_POST['meta_key'] : '' ?></textarea></p>
            <p><label>Meta desc : </label><textarea name="meta_desc" class="large" cols="40" rows="10"><?php echo !empty($_POST['meta_desc']) ? $_POST['meta_desc'] : '' ?></textarea></p>
            <?php if($this->app->session->get_var('group_id') == 2){ ?>
			<p><label>Controller: </label><input type="text" name="controller" value="<?php echo !empty($_POST['controller']) ? $_POST['controller'] : '' ?>" class="medium"></p>
			<?php } ?>
			<p><label>Featured Photo : </label><input type="file" name="feature_img" /></p>
			<p>
                <label>Layout : </label>
                <select name="layout" class="medium">
                    <option value="yes" <?php if (!empty($_POST['layout']) && $_POST['layout'] == 'yes') { ?> selected="selected" <?php } ?>>With Sidebar</option>
                    <option value="no" <?php if (!empty($_POST['layout']) && $_POST['layout'] == 'no') { ?> selected="selected" <?php } ?>>Full Width</option>
                </select>
            </p>			
            <p><label>Status: </label>

                <select name="status" class="medium">
                    <option value="active" <?php if (!empty($_POST['status']) && $_POST['status'] == 'active') { ?> selected="selected" <?php } ?>>Active</option>
                    <option value="inactive" <?php if (!empty($_POST['status']) && $_POST['status'] == 'inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
                </select>

            </p> 

            <p><input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit"></p>
        </form>
    </div>
</div>                