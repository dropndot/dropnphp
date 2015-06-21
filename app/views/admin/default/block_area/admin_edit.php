<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?php echo $site_title;?> <?php echo !empty($row['title'])?$row['title']:''?></h3>
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
        <form name="add_category" action="<?php echo BASE_URL ?>admin/index.php?controller=block_area&action=edit" method="post">
            <input type="hidden" name="id" value="<?php echo !empty($row['id'])?$row['id']:''?>">
            <input type="hidden" name="description" value="<?php echo !empty($row['description'])?$row['description']:''?>" class="medium">
            
            <p><label>Title : </label><input type="text" name="title" value="<?php echo !empty($row['title'])?$row['title']:''?>" class="medium"></p>
<!--            <p><label>Identifier: *</label><input type="text" name="identifier" value="<?php echo !empty($row['identifier'])?$row['identifier']:''?>" class="medium"></p>-->
<!--            <p><label>Description: </label><textarea name="description" class="large" cols="40" rows="10"><?php echo !empty($row['description'])?$row['description']:''?></textarea></p>-->
            
            
            <p><label>Status : </label>
            
            <select name="status" class="medium">
                <option value="active" <?php if(!empty($row['status']) && $row['status']=='active') { ?> selected="selected" <?php } ?>>Active</option>
                <option value="inactive" <?php if(!empty($row['status']) && $row['status']=='inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
            </select>
            
            </p>
            
            <p><input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT?>" class="submit"></p>
        </form>
    </div>
</div>                