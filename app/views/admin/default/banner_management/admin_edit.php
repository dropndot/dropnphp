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

<a class="cancelEdit" href="index.php?controller=banner_management">Cancel</a>
<div class="content">
    <div class="form">
        <form name="add_category" action="<?php echo BASE_URL  ?>admin/index.php?controller=banner_management&action=edit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo !empty($row['id']) ? $row['id'] : '' ?>">

            <p>
                <label>Title : </label>
                <input type="text" name="title" value="<?php echo !empty($row['title']) ? $row['title'] : '' ?>" class="medium" />
            </p>

            <p>
                <label>Caption:</label>
                <textarea name="caption" class="large mceEditor" cols="40" rows="10"><?php echo !empty($row['caption']) ? $row['caption'] : '' ?></textarea>
            </p>

            <p>
                <label>Photo :</label>
                <input type="hidden" name="photo" value="<?php echo $row['photo']; ?>" />
                <input type="file" name="banner_img" /><br/>
                <img style="margin: 10px 0 0 0; width:150px;" src="<?php echo BASE_URL  . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'banner_management' . DS . $row['photo']; ?>"  alt="" />
            </p>

            <p>
                <label>Ordering : </label>
                <input type="text" name="ordering" value="<?php echo !empty($row['ordering']) ? $row['ordering'] : '' ?>" class="medium" />
            </p>

            <p>
                <label>Status: </label>            
                <select name="status" class="medium">
                    <option value="active" <?php if (!empty($row['status']) && $row['status'] == 'active') { ?> selected="selected" <?php } ?>>Active</option>
                    <option value="inactive" <?php if (!empty($row['status']) && $row['status'] == 'inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
                </select>            
            </p>
            <p>
                <label>&nbsp;</label>
                <input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit" />
            </p>
        </form>
    </div>
</div>                