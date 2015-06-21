<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?=$site_title;?></h3>
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
        <form name="add_news_management" action="<?=$site_url?>admin/index.php?controller=news_management&action=add" method="post" enctype="multipart/form-data">
            
            
            <p><label>Title: *</label><input type="text" name="title" value="<?=!empty($_POST['title'])?$_POST['title']:''?>" class="medium"></p>
            <p><label>Description: *</label><textarea name="description" class="large" cols="40" rows="10"><?=!empty($_POST['description'])?$_POST['description']:''?></textarea></p>
            <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
            <!--<p><label>Photo</label><input type="file" name="news_img" /></p>-->
            <p><label>Ordering: </label><input type="text" name="ordering" value="<?=!empty($_POST['ordering'])?$_POST['ordering']:''?>" class="medium"></p>
            
            <p><label>Status: </label>
            
            <select name="status" class="medium">
                <option value="active" <?php if(!empty($_POST['status']) && $_POST['status']=='active') { ?> selected="selected" <?php } ?>>Active</option>
                <option value="inactive" <?php if(!empty($_POST['status']) && $_POST['status']=='inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
            </select>
            
            </p>
            
            <p><label>&nbsp;</label><input type="submit" name="submit" value="<?=$BUTTON_SUBMIT?>" class="submit"></p>
        </form>
    </div>
</div>                