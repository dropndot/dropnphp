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

<a class="cancelEdit" href="index.php?controller=default_setting">Cancel</a>
<div class="content">
    <div class="form">
        <form name="add_setting" action="<?php echo BASE_URL  ?>admin/index.php?controller=default_setting&action=add" method="post" enctype="multipart/form-data">

            <p>
                <label>Key : </label>
                <input type="text" name="set_key" value="<?php echo !empty($_POST['set_key']) ? $_POST['set_key'] : '' ?>" class="medium" />
            </p> 
            <p>
                <label>Type : </label>
                <input class="settings_type" style="float: left;" type="radio" name="type" value="text" />
                <label style="float: left; line-height: 20px; margin: 0 5px 0;" >Text</label>
                <input class="settings_type" style="float: left;" type="radio" name="type" value="textarea" />
                <label style="float: left; line-height: 20px; margin: 0 5px 0;" >Textarea</label>
                <input class="settings_type" style="float: left;" type="radio" name="type" value="image" />
                <label style="line-height: 20px; margin: 0 5px 0;">Image</label>
            </p> 
            <p id="txtVal">
                <label>Value : </label>
                <input type="text" name="set_txt_value" value="" class="medium" />
            </p>
            <p id="txtareaVal">
                <label>Value : </label>
                <textarea class="large" name="set_txtarea_value"></textarea>
            </p>
            <p id="upload_image">
                <label>Image</label>
                <input type="file" name="image" />
            </p>             
            <p>
                <input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit" />
            </p>
        </form>
    </div>
</div>                