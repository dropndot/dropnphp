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

<a class="cancelEdit" href="index.php?controller=manage_block">Cancel</a>
<div class="content">
    <div class="form">
        <form name="add_category" action="<?php echo BASE_URL  ?>admin/index.php?controller=manage_block&action=edit&" method="post">
            <input type="hidden" name="id" value="<?php echo !empty($row['id']) ? $row['id'] : '' ?>">

            <p><label>Select a Block Area : </label><select name="block_area_id" class="medium">
                    <option selected="selected" value="select">-----Select One-----</option>
                    <?php
                    foreach ($block_area_id as $key => $values) {
                        ?>
                        <option value="<?php echo $values['id'] ?>" <?php
                    if (!empty($row['block_area_id']) && ($values['id'] == $row['block_area_id'])) {
                        echo "selected='selected'";
                    }
                        ?>><?php echo $values['title'] ?></option>
                                <?php
                            }
                            ?>
                </select></p>

            <p><label>Title : </label><input type="text" name="title" value="<?php echo !empty($row['title']) ? $row['title'] : '' ?>" class="medium"></p>
            <p><label>Description : </label><textarea name="description" class="large mceEditor" cols="40" rows="10"><?php echo !empty($row['description']) ? $row['description'] : '' ?></textarea></p>

            <p><label>Ordering : </label><input style="width: 253px;" type="text" name="ordering" value="<?php echo !empty($row['ordering']) ? $row['ordering'] : '' ?>" class="medium"></p>
            <p><label>Status : </label>

                <select name="status" class="medium">
                    <option value="active" <?php if (!empty($row['status']) && $row['status'] == 'active') { ?> selected="selected" <?php } ?>>Active</option>
                    <option value="inactive" <?php if (!empty($row['status']) && $row['status'] == 'inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
                </select>

            </p>

            <p><input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit"></p>
        </form>
    </div>
</div>                