<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?php echo $site_title;?></h3>
    </div>
</div>

<?php if(!empty($err)) { ?> 
        <p class="err"><?php echo $err?></p>
<?php } ?>


<?php if(!empty($msg)) { ?> 
        <p class="msg"><?php echo $msg?></p>
<?php } ?>

<a class="cancelEdit" href="index.php?controller=block_area">Cancel</a>
<div class="content">
    <div class="form">
        <form name="add_articles" action="<?php echo BASE_URL ?>admin/index.php?controller=block_area&action=add" method="post" enctype="multipart/form-data">
                         
            <p><label>Title : </label><input type="text" name="title" value="<?php echo !empty($_POST['title'])?$_POST['title']:''?>" class="medium"></p>
<!--            <p><label>Identifier: *</label><input type="text" name="identifier" value="<?php echo !empty($_POST['identifier'])?$_POST['identifier']:''?>" class="medium"></p>-->
<!--            <p><label>Description: </label><textarea name="description" class="large" cols="40" rows="10"><?php echo !empty($_POST['description'])?$_POST['description']:''?></textarea></p>-->
            <input type="hidden" name="description" value="" class="medium">
            <p><label>Status : </label>
            
            <select name="status" class="medium">
                <option value="active" <?php if(!empty($_POST['status']) && $_POST['status']=='active') { ?> selected="selected" <?php } ?>>Active</option>
                <option value="inactive" <?php if(!empty($_POST['status']) && $_POST['status']=='inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
            </select>
            
            </p>
            
            <p><input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT?>" class="submit"></p>
        </form>
    </div>
</div>                