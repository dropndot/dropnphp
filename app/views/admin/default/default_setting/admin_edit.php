<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?php echo $site_title; ?> <?php echo !empty($row['set_key']) ? $row['set_key'] : '' ?></h3>
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
        <form name="add_setting" action="<?php echo BASE_URL  ?>admin/index.php?controller=default_setting&action=edit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo !empty($row['id']) ? $row['id'] : '' ?>">

            <p>
                <label>Kay : </label>
                <input readonly="readonly" type="text" name="set_key" value="<?php echo !empty($row['set_key']) ? $row['set_key'] : '' ?>" class="medium" />
            </p>
            <?php if ($row['type'] == 'text') { ?>
                <p>
                    <label>Value : </label>
                    <input type="hidden" name="type" value="<?php echo $row['type']; ?>" />
                    <?php if ($row['set_key'] == 'site_lang' || $row['set_key'] == 'public_theme') { ?>
                        <input readonly="readonly" type="text" name="set_txt_value" value="<?php echo !empty($row['value']) ? $row['value'] : '' ?>" class="medium" />
                    <?php } else { ?>
                        <input type="text" name="set_txt_value" value="<?php echo !empty($row['value']) ? $row['value'] : '' ?>" class="medium" />
                    <?php } ?>
                </p>
            <?php } ?>
            <?php if ($row['type'] == 'textarea') { ?>
                <p>
                    <label>Value : </label>
                    <input type="hidden" name="type" value="<?php echo $row['type']; ?>" />
                    <textarea class="large" name="set_txtarea_value"><?php echo !empty($row['value']) ? $row['value'] : '' ?></textarea>
                </p>
            <?php } ?>
            <?php if ($row['type'] == 'image') { ?>
                <p>
                    <input type="hidden" name="type" value="<?php echo $row['type']; ?>" />
                    <input type="hidden" name="old_image" value="<?php echo $row['value']; ?>" />
                    <input type="file" name="image" /><br />
                    <img style="margin: 5px 0 0 0; max-width:150px;" src="app/resources/document/settings/<?php echo $row['value']; ?>" alt=""/>
                </p>  
            <?php } ?>
            <p>
                <input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit" />
            </p>
        </form>
    </div>
</div>                