<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?php echo $site_title . $menus_title; ?></h3>
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
        <form name="add_articles" action="<?php echo BASE_URL  ?>admin/index.php?controller=menu_item&action=add&menus_id=<?php echo empty($menus_id) ? $_REQUEST['menus_id'] : $menus_id ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="menus_id" value="<?php echo $menus_id; ?>" /> 

            <p><label>Parent Menu</label>
                <select name="parent_id" class="medium parentMenu">
                    <option value="">-----No Parent-----</option>
                    <?php
                    foreach ($menu_item_id as $key => $values) {
                        ?>
                        <option value="<?php echo $values['id'] ?>" 
                        <?php
                        if (!empty($_POST['parent_id']) && ($values['id'] == $_POST['parent_id'])) {
                            echo "selected='selected'";
                        }
                        ?>><?php echo $values['title'] ?></option>
                                <?php
                            }
                            ?>
                </select>
            </p>
            <p>
                <label>Title : </label>
                <input type="text" name="title" value="<?php echo !empty($_POST['title']) ? $_POST['title'] : '' ?>" class="medium" />
            </p>
            <p>
                <label>Menu Type: </label>
                <input class="menuType" checked="checked" style="float: left;" type="radio" name="menu_type" value="page" />
                <label style="float: left; line-height: 20px; margin: 0 5px 0;" >Pages</label>
                <input class="menuType" style="float: left;" type="radio" name="menu_type" value="category" />
                <label style="float: left; line-height: 20px; margin: 0 5px 0;">Category</label>
                <input class="menuType" style="float: left;" type="radio" name="menu_type" value="url" />
                <label style="line-height: 20px; margin: 0 5px 0;">URL</label>
            </p>
            <div id="pageArea">
                <p>
                    <label>Pages :</label>
                    <select name="page_id" class="medium">
                        <?php
                        foreach ($pages_list as $key => $values) {
                            ?>
                            <option value="<?php echo $values['id'] ?>" <?php
                        if (!empty($_POST['url']) && ($values['id'] == $_POST['url'])) {
                            echo "selected='selected'";
                        }
                            ?>><?php echo $values['title'] ?></option>
                                    <?php
                                }
                                ?>
                    </select>
                </p>            
            </div>
            <div id="categoryArea">
                <p>
                    <label>Categories :</label>
                    <select name="cat_id" class="medium">
                        <?php
                        foreach ($cat_list as $key => $values) {
                            ?>
                            <option value="<?php echo $values['id'] ?>"><?php echo $values['title'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </p>     
            </div>
            <div id="urlArea">
                <p>
                    <label>URL : </label>
                    <input class="medium" type="text" name="url" value="" />
                </p>   
            </div>
            <p>
                <label>Target : </label>
                <input <?php if (!empty($_POST['target']) && $_POST['target'] == 'same') { ?> checked="checked" <?php } ?> style="float: left;" type="radio" name="target" value="same" />
                <label style="float: left; line-height: 20px; margin: 0 5px 0;" >Same Window</label>
                <input <?php if (!empty($_POST['target']) && $_POST['target'] == 'new') { ?> checked="checked" <?php } ?> style="float: left;" type="radio" name="target" value="new" />
                <label style="float: left; line-height: 20px; margin: 0 5px 0;">New Window</label>
            </p>
            <p><label>Ordering:</label>
                <input style="width: 253px;" class="medium" type="text" name="ordering" value="<?php echo !empty($_POST['ordering']) ? $_POST['ordering'] : '' ?>">
            </p>
            <p><label>Status: </label>

                <select name="status" class="medium">
                    <option value="active" <?php if (!empty($_POST['status']) && $_POST['status'] == 'active') { ?> selected="selected" <?php } ?>>Active</option>
                    <option value="inactive" <?php if (!empty($_POST['status']) && $_POST['status'] == 'inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
                </select>

            </p>
            <p><input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit"></p>
        </form>
    </div>
</div>                