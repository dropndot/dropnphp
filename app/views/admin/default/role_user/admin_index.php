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
<?php if (!empty($user_role_add) && $user_role_add == true) {?>
<div class="addSearch">
    <div class="addarea">
        <a href="<?php echo BASE_URL; ?>admin/index.php?controller=role_user&action=add">+ Add New Item</a>
    </div>
</div>
<!--addSearch-->
<?php } ?>
<div class="content">
    <form name="Form_check" method="post" action="<?php echo BASE_URL; ?>admin/index.php?controller=role_user">
        <table class="contentList">
            <thead>
                <tr>
                    <th width="50"><input type="checkbox" name="check_All" class="dpFormCheckAllxx"></th>
                    <th class="notCenter">Title</th>
                    <th width="100">Status</th>
                    <th width="200">Created</th>
					<?php if ((!empty($user_role_delete) && $user_role_delete == true) || (!empty($user_role_edit) && $user_role_edit == true)) { ?>
                    <th width="50">Action</th>
					<?php } ?>
                </tr>
            </thead>
            <tbody>

                <?php
                if (!empty($data)) { 
                    foreach ($data as $key => $values) {
                        ?>                        
                        <tr>
                            <td><input type="checkbox" name="check_list[]" value="<?php echo $values['id'] ?>"></td>
                            <td class="notCenter"><?php echo $values['name'] ?></td>
                            <td><?php echo $values['status'] ?></td>
                            <td><?php echo $values['created'] ?></td>
							<?php if ((!empty($user_role_delete) && $user_role_delete == true) || (!empty($user_role_edit) && $user_role_edit == true)) { ?>
                            <td>
								<?php if (!empty($user_role_edit) && $user_role_edit == true) { ?>
                                <a href="index.php?controller=role_user&amp;action=edit&amp;id=<?php echo $values['id'] ?>" class="edit"><img src="<?php echo $theme_root; ?>layout/images/action_add.png" Alt="Edit" /></a>
								<?php }?>
								<?php if (!empty($user_role_delete) && $user_role_delete == true) { ?>
                                <a href="index.php?controller=role_user&amp;action=delete&amp;id=<?php echo $values['id'] ?>" class="delete" onclick="return window.confirm('Are you sure delete this item?');"><img src="<?php echo $theme_root; ?>layout/images/action_delete.png" Alt="Delete" /></a>
								<?php } ?>
                            </td>
					<?php }?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="5">
							<?php if (!empty($user_role_edit) && $user_role_edit == true) { ?>
							<input type="hidden" value="true" name="admin_index_submite" /> 
                            <input type="submit" name="status" class="submit submitbutton" value="Active" />
                            <input type="submit" name="status" class="submit submitbutton" value="Inactive" />
							<?php } ?>
							<?php if (!empty($user_role_delete) && $user_role_delete == true) { ?>
                            <input onclick="return window.confirm('Are you sure delete this item?');" type="submit" name="status" class="submit submitbutton" value="Delete" />
                            <?php } ?>
                        </td>
                    </tr>
                </tfoot>
            <?php } else { ?>
                <tr>
                    <td colspan="9"><h2 style="text-align: center;padding: 15px 0;">No item available.</h2></td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>                
