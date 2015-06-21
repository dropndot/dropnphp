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

<a class="cancelEdit" href="index.php?controller=menus">Cancel</a>
<div class="content">
    <div class="form">
        <form name="add_articles" action="<?php echo BASE_URL ?>admin/index.php?controller=menus&action=add" method="post">
                         
            <p><label>Title : </label><input type="text" name="title" value="<?php echo !empty($_POST['title'])?$_POST['title']:''?>" class="medium"></p>
            <p><input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT?>" class="submit"></p>
        </form>
    </div>
</div>                