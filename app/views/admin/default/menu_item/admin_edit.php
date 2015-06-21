<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?php echo $site_title . '- '; ?> <?php echo !empty($row['title']) ? $row['title'] : '' ?></h3>
    </div>
</div>

<?php if (!empty($err)) { ?> 
    <p class="err"><?php echo $err ?></p>
<?php } ?>


<?php if (!empty($msg)) { ?> 
    <p class="msg"><?php echo $msg ?></p>
<?php } ?>

<a class="cancelEdit" href="index.php?controller=menu_item&menus_id=<?php echo empty($menus_id) ? $_REQUEST['menus_id'] : $menus_id ?>">Cancel</a>
<div class="content">
    <div class="form">
        <form name="add_category" action="<?php echo BASE_URL  ?>admin/index.php?controller=menu_item&action=edit&menus_id=<?php echo empty($menus_id) ? $_REQUEST['menus_id'] : $menus_id ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo !empty($row['id']) ? $row['id'] : '' ?>">
            <input type="hidden" name="menus_id" value="<?php echo $menus_id; ?>" />           

            <p>
                <label>Parent menu</label>
                <select name="parent_id" class="medium parentMenu">
                    <option value="">-----No Parent-----</option>
                    <?php
                    foreach ($menu_item_ids as $key => $values) {
                        ?>
                        <option value="<?php echo $values['id'] ?>" <?php
                    if (!empty($row['parent_id']) && ($values['id'] == $row['parent_id'])) {
                        echo "selected='selected'";
                    }
                        ?>>
                            <?php echo $values['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </p>
            <p><label>Title : </label><input type="text" name="title" value="<?php echo !empty($row['title']) ? $row['title'] : '' ?>" class="medium"></p>
            <p>
                <label>Menu Type : </label>
                <input class="editmenuType" <?php if (!empty($row['menu_type']) && $row['menu_type'] == 'page') { ?> checked="checked" <?php } ?> style="float: left;" type="radio" name="menu_type" value="page" />
                <label style="float: left; line-height: 20px; margin: 0 5px 0;" >Pages</label>
                <input class="editmenuType" <?php if (!empty($row['menu_type']) && $row['menu_type'] == 'category') { ?> checked="checked" <?php } ?> style="float: left;" type="radio" name="menu_type" value="category" />
                <label style="float: left; line-height: 20px; margin: 0 5px 0;">Category</label>
                <input class="editmenuType" <?php if (!empty($row['menu_type']) && $row['menu_type'] == 'url') { ?> checked="checked" <?php } ?> style="float: left;" type="radio" name="menu_type" value="url" />
                <label style="line-height: 20px; margin: 0 5px 0;">URL</label>
            </p>  
            <div <?php if ($row['menu_type'] == 'page') { ?> style="display: block;" <?php } ?> id="editpageArea">
                <p>
                    <label>Pages :</label>
                    <select name="page_id" class="medium">
                        <?php
                        foreach ($pages_list as $key => $values) {
                            ?>
                            <option value="<?php echo $values['id'] ?>" <?php
                        if ($row['page_id'] == $values['id']) {
                            echo "selected='selected'";
                        }
                            ?>><?php echo $values['title'] ?></option>
                                    <?php
                                }
                                ?>
                    </select>
                </p>            
            </div>
            <div <?php if ($row['menu_type'] == 'category') { ?> style="display: block;" <?php } ?>  id="editcategoryArea">
                <p>
                    <label>Category:</label>
                    <select name="cat_id" class="medium">
                        <?php
                        foreach ($cat_list as $key => $values) {
                            ?>
                            <option value="<?php echo $values['id'] ?>" <?php
                        if (!empty($row['cat_id']) && ($values['id'] == $row['cat_id'])) {
                            echo "selected='selected'";
                        }
                            ?>><?php echo $values['title'] ?></option>
                                    <?php
                                }
                                ?>
                    </select>
                </p>
            </div>
            <div <?php if ($row['menu_type'] == 'url') { ?> style="display: block;" <?php } ?> id="editurlArea">
                <p>
                    <label>URL :</label>
                    <input class="medium" type="text" name="url" value="<?php echo !empty($row['url']) ? $row['url'] : '' ?>" />
                </p>   
            </div> 
            <p>
                <label>Target : </label>
                <input <?php if (!empty($row['target']) && $row['target'] == 'same') { ?> checked="checked" <?php } ?> checked="checked" style="float: left;" type="radio" name="target" value="same" />
                <label style="float: left; line-height: 20px; margin: 0 5px 0;" >Same Window</label>
                <input <?php if (!empty($row['target']) && $row['target'] == 'new') { ?> checked="checked" <?php } ?> style="float: left;" type="radio" name="target" value="new" />
                <label style="float: left; line-height: 20px; margin: 0 5px 0;">New Window</label>
            </p>
            <p><label>Ordering:</label>
                <input style="width: 253px;" class="medium" type="text" name="ordering" value="<?php echo !empty($row['ordering']) ? $row['ordering'] : '' ?>">
            </p>

            <p><label>Status: </label>

                <select name="status" class="medium">
                    <option value="active" <?php if (!empty($row['status']) && $row['status'] == 'active') { ?> selected="selected" <?php } ?>>Active</option>
                    <option value="inactive" <?php if (!empty($row['status']) && $row['status'] == 'inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
                </select>

            </p>
            <p><input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit"></p>
        </form>
    </div>
</div>                