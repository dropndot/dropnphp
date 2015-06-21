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

<a class="cancelEdit" href="index.php?controller=banner_management">Cancel</a>
<div class="content">
    <div class="form">
        <form name="add_banner_management" action="<?php echo BASE_URL  ?>admin/index.php?controller=banner_management&action=add" method="post" enctype="multipart/form-data">

            <p>
                <label>Title : </label>
                <input type="text" name="title" value="<?php echo !empty($_POST['title']) ? $_POST['title'] : '' ?>" class="medium" />
            </p>
            
            <p>
                <label>Caption:</label>
                <textarea name="caption" class="large mceEditor" cols="40" rows="10"><?php echo !empty($_POST['caption']) ? $_POST['caption'] : '' ?></textarea>
            </p>

            <p>
                <label>Photo : </label>
                <input type="file" name="banner_img" />
            </p>

            <p>
                <label>Ordering : </label>
                <input style="width: 253px;" type="text" name="ordering" value="<?php echo !empty($_POST['ordering']) ? $_POST['ordering'] : '' ?>" class="medium" />
            </p>

            <p>
                <label>Status : </label>            
                <select name="status" class="medium">
                    <option value="active" <?php if (!empty($_POST['status']) && $_POST['status'] == 'active') { ?> selected="selected" <?php } ?>>Active</option>
                    <option value="inactive" <?php if (!empty($_POST['status']) && $_POST['status'] == 'inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
                </select>            
            </p>

            <p>
                <input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit" />
            </p>
        </form>
    </div>
</div>                