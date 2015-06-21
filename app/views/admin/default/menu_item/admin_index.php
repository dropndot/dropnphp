<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <?php if ((!empty($_GET['status']) && $_GET['status'] == 'archive') || (!empty($_GET['status']) && $_GET['status'] == 'delete')) { ?>
            <?php if ($_GET['status'] == 'archive') { ?>
                <h3>Archived <?php echo $site_title; ?></h3>
            <?php } ?>
            <?php if ($_GET['status'] == 'delete') { ?>
                <h3>Trash <?php echo $site_title; ?></h3>
            <?php } ?>
        <?php } else { ?>
            <h3><?php echo $site_title; ?></h3>
        <?php } ?>
    </div>
</div>

<?php if (!empty($err)) { ?> 
    <p class="err"><?php echo $err ?></p>
<?php } ?>


<?php if (!empty($msg)) { ?> 
    <p class="msg"><?php echo $msg ?></p>
<?php } ?>
<div class="addSearch">
    <div class="addarea">
        <?php if ((!empty($_GET['status']) && $_GET['status'] == 'archive') || (!empty($_GET['status']) && $_GET['status'] == 'delete')) { ?>
            <a href="index.php?controller=menu_item&amp;menus_id=<?php echo $menus_id ?>"><- Back</a>
        <?php } else { ?>
		<?php if (!empty($menus_add) && $menus_add == true) {?>
            <a href="<?php echo BASE_URL  ?>admin/index.php?controller=menu_item&action=add&menus_id=<?php echo $menus_id ?>">+ Add New Menu Item</a>
        <?php } ?>
        <?php } ?>
    </div>
</div>
<!--addSearch-->

<div class="content">
    <form name="Form_check" method="post" action="<?php echo BASE_URL  ?>admin/index.php?controller=menu_item&action=index&page=<?php echo $page_no ?>&status=<?php echo $page_status ?>&menus_id=<?php echo $menus_id ?>">
        <table class="contentList">
            <thead>
                <tr>
                    <th width="50"><input type="checkbox" name="check_All" class="dpFormCheckAll"></th>
                    <th class="notCenter">Title</th>
                    <th class="notCenter">Parent Menu</th>
                    <th width="100">Menu Type</th>
                    <th width="50">Ordering</th>
                    <th width="50">Status</th>
                    <th width="150">Created</th>
					<?php if ((!empty($menus_delete) && $menus_delete == true) || (!empty($menus_edit) && $menus_edit == true)) { ?>
                    <th width="50">Action</th>
					<?php }?>
                </tr>
            </thead>
            <tbody>

                <?php
                if (!empty($data)) {
                    $index = 0;
                    foreach ($data as $key => $values) {
                        ?>                        
                        <tr>
                            <td><input type="checkbox" name="check_list[]" value="<?php echo $values['id'] ?>"></td>
                            <td class="notCenter"><?php echo $values['title'] ?></td>                            
                            <td class="notCenter"><?php echo $parent_titles[$index]; ?></td>                            
                            <td><?php echo $values['menu_type'] ?></td>
                            <td><?php echo $values['ordering'] ?></td>
                            <td><?php echo $values['status'] ?></td>
                            <td><?php echo $values['created'] ?></td>
							<?php if ((!empty($menus_delete) && $menus_delete == true) || (!empty($menus_edit) && $menus_edit == true)) { ?>
                            <td>
							<?php if (!empty($menus_edit) && $menus_edit == true) { ?>
                                <a href="index.php?controller=menu_item&amp;action=edit&amp;id=<?php echo $values['id'] ?>&amp;menus_id=<?php echo $menus_id ?>" class="edit"><img src="<?php echo $theme_root; ?>layout/images/action_add.png" Alt="Edit" /></a>
								<?php } ?>
								<?php if (!empty($menus_delete) && $menus_delete == true) { ?>
                                <a href="index.php?controller=menu_item&amp;action=delete&amp;id=<?php echo $values['id'] ?>&amp;status=<?php echo $page_status ?>&amp;menus_id=<?php echo $menus_id ?>" class="delete" onclick="return window.confirm('Are you sure delete this item?');"><img src="<?php echo $theme_root; ?>layout/images/action_delete.png" Alt="Delete" /></a>
								<?php } ?>
                            </td>
					<?php } ?>
                        </tr>
                        <?php
                        $index++;
                    }
                    ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="9">
							<?php if (!empty($menus_edit) && $menus_edit == true) { ?>
							<input type="hidden" value="true" name="admin_index_submite">
                            <input type="submit" name="status" class="submit submitbutton" value="Active">
                            <input type="submit" name="status" class="submit submitbutton" value="Inactive">
                            <input type="submit" name="status" class="submit submitbutton" value="Archive">
					<?php }?>
					<?php if (!empty($menus_delete) && $menus_delete == true) { ?>
                            <input onclick="return window.confirm('Are you sure delete this item?');" type="submit" name="status" class="submit submitbutton" value="Delete" />
					<?php } ?>
                            <?php if ((!empty($_GET['status']) && $_GET['status'] == 'archive') || (!empty($_GET['status']) && $_GET['status'] == 'delete')) { ?>
                                <a class="archive" href="index.php?controller=menu_item&amp;menus_id=<?php echo $menus_id ?>">Back</a>
                            <?php } else { ?>
							<?php if (!empty($menus_edit) && $menus_edit == true) { ?>
                                <a class="archive" title="Archived" href="index.php?controller=menu_item&status=archive&menus_id=<?php echo $menus_id ?>">Archived</a>
								<?php } ?>
								<?php if (!empty($menus_delete) && $menus_delete == true) { ?>
                                <a class="trash" title="Trash" href="index.php?controller=menu_item&status=delete&menus_id=<?php echo $menus_id ?>">Trash</a>
                            <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php if (!empty($paging)) { ?>
                        <tr>
                            <td colspan="9" class="foot" align="center">
                                <?php echo $paging ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tfoot>
            <?php } else { ?>
                <tr>
                    <td colspan="9"><h2 style="text-align: center;padding: 15px 0;">No menu item available.</h2></td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>                
