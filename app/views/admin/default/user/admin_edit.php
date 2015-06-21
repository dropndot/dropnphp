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

<!--addSearch-->
<div class="content">
    <div class="form">
        <form name="add_category" action="<?php echo BASE_URL ?>admin/index.php?controller=user&action=edit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo!empty($row['id']) ? $row['id'] : '' ?>">
            <p><label>Name : *</label><input type="text" name="name" value="<?php echo!empty($row['name']) ? $row['name'] : '' ?>" class="medium"></p>
            <p><label>User Name : * </label><input disabled="disabled" type="text" name="username" value="<?php echo!empty($row['username']) ? $row['username'] : '' ?>" class="medium"></p>
            <p><label>Email: </label><input type="text" name="email" value="<?php echo!empty($row['email']) ? $row['email'] : '' ?>" class="medium"></p>
            <p><label>User Role: * </label>
                <?php
                if (!empty($user_group)) {
                    ?>
                    <select name="group_id" class="medium">
                        <option value="">Select any one</option>
                        <?php foreach ($user_group as $key => $values) { ?>
                            <option value="<?php echo $values['id']; ?>" <?php if (!empty($row['group_id']) && $row['group_id'] == $values['id']) { ?> selected="selected" <?php } ?>><?php echo $values['name']; ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>
            </p>
            <p>
                <label> New Password : </label>
                <input type="password" name="password" value="" class="medium" />
                <input type="hidden" name="old_password" value="<?php echo!empty($row['password']) ? $row['password'] : '' ?>" class="medium" />
            </p>            
            <p><label>Phone : </label><input type="text" name="phone" value="<?php echo!empty($row['phone']) ? $row['phone'] : '' ?>" class="medium"></p>
            <p><label>Location : </label><input type="text" name="location" value="<?php echo!empty($row['location']) ? $row['location'] : '' ?>" class="medium"></p>
            <p><label>Details : </label><textarea class="large" name="details" cols="30" rows="7"><?php echo!empty($row['details']) ? $row['details'] : '' ?></textarea></p>
            <p>
                <label>Profile Photo :</label>
                <input type="hidden" name="old_profile_image" value="<?php echo $row['profile_image']; ?>" />               
                <input type="file" name="profile_image" />
                <?php if (!empty($row['profile_image'])) { ?>
                    <br/>
                    <img style="margin: 0" src="app/resources/document/users/<?php echo $row['profile_image']; ?>"  alt="" width="50px" height="50px"/>
                <?php } ?>
            </p>
            <p>
                <label>Status: </label>
                <select name="status" class="medium">
                    <option value="active" <?php if (!empty($row['status']) && $row['status'] == 'active') { ?> selected="selected" <?php } ?>>Active</option>
                    <option value="inactive" <?php if (!empty($row['status']) && $row['status'] == 'inactive') { ?> selected="selected" <?php } ?>>Inctive</option>
                </select>            
            </p>
            <p><label>&nbsp;</label><input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit"></p>
        </form>
    </div>
</div>                