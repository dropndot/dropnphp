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

<a class="cancelEdit" href="index.php?controller=user">Cancel</a>
<div class="content">
    <div class="form">
        <form name="" action="<?php echo BASE_URL ?>admin/index.php?controller=user&action=add" method="post" enctype="multipart/form-data">

            <p><label>Name : *</label><input type="text" name="name" value="<?php echo!empty($_POST['name']) ? $_POST['name'] : '' ?>" class="medium"></p>
            <p><label>User Name : * </label><input type="text" name="username" value="<?php echo!empty($_POST['username']) ? $_POST['username'] : '' ?>" class="medium"></p>                          
            <p><label>Email :* </label><input type="text" name="email" value="<?php echo!empty($_POST['email']) ? $_POST['email'] : '' ?>" class="medium"></p>
            <p><label>User Role: * </label>
                <?php
                if (!empty($user_group)) {
                    ?>
                    <select name="group_id" class="medium">
                        <option value="">Select any one</option>
                        <?php foreach ($user_group as $key => $values) { ?>
                            <option value="<?php echo $values['id']; ?>" <?php if (!empty($_POST['group_id']) && $_POST['group_id'] == $values['id']) { ?> selected="selected" <?php } ?>><?php echo $values['name']; ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>
            </p>
            <p><label>Password : * </label><input type="password" name="password" value="" class="medium"></p>
            <p><label>Confirm Password : * </label><input type="password" name="re_password" value="" class="medium"></p> 
            <p><label>Phone : </label><input type="text" name="phone" value="<?php echo!empty($_POST['phone']) ? $_POST['phone'] : '' ?>" class="medium"></p>
            <p><label>Location : </label><input type="text" name="location" value="<?php echo!empty($_POST['location']) ? $_POST['location'] : '' ?>" class="medium"></p>
            <p><label>Details : </label><textarea class="large" name="details" cols="30" rows="7"><?php echo!empty($_POST['details']) ? $_POST['details'] : '' ?></textarea></p>
            <p>
                <label>Profile Photo :</label>
                <input class="medium" type="file" name="profile_image" />                
            </p>
            <p><label>Status: </label>
                <select name="status" class="medium">
                    <option value="active" <?php if (!empty($_POST['status']) && $_POST['status'] == 'active') { ?> selected="selected" <?php } ?>>Active</option>
                    <option value="inactive" <?php if (!empty($_POST['status']) && $_POST['status'] == 'inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
                </select>
            </p>
            <p><label>&nbsp;</label><input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit"></p>
        </form>
    </div>
</div>                