<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?=$site_title;?> <?=!empty($row['title'])?$row['title']:''?></h3>
    </div>
    <div class="toolbar toolbar_icon">
        <div class="toolbar_button_set">
            <a href="<?=$site_url?>admin/index.php?controller=news_management" class="button">Cancel</a>
        </div>
    </div>
</div>
<br clear="all" />

<?php if(!empty($err)) { ?> 
        <p class="err"><?=$err?></p>
<?php } ?>


<?php if(!empty($msg)) { ?> 
        <p class="msg"><?=$msg?></p>
<?php } ?>


<div class="content">
    <div class="form">
        <form name="add_category" action="<?=$site_url?>admin/index.php?controller=news_management&action=edit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=!empty($row['id'])?$row['id']:''?>">
            
            <p><label>Title: </label><input type="text" name="title" value="<?=!empty($row['title'])?$row['title']:''?>" class="medium"></p>
            <p><label>Description: </label><textarea name="description" class="large" cols="40" rows="10"><?=!empty($row['description'])?$row['description']:''?></textarea></p>
            <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
            <!--<p><label>Photo</label><input type="file" name="news_img" /></p>-->
            <p><label>Ordering: </label><input type="text" name="ordering" value="<?=!empty($row['ordering'])?$row['ordering']:''?>" class="medium"></p>
            
            <p><label>Status: </label>
            
            <select name="status" class="medium">
                <option value="active" <?php if(!empty($row['status']) && $row['status']=='active') { ?> selected="selected" <?php } ?>>Active</option>
                <option value="inactive" <?php if(!empty($row['status']) && $row['status']=='inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
            </select>
            
            </p>
            <p><label>&nbsp;</label><input type="submit" name="submit" value="<?=$BUTTON_SUBMIT?>" class="submit"></p>
        </form>
    </div>
</div>                