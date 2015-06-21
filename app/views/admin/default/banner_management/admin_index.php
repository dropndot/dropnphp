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
            <a href="index.php?controller=banner_management"><- Back</a>
        <?php } else { ?>
		<?php if (!empty($slider_add) && $slider_add == true) {?>
            <a href="<?php echo BASE_URL  ?>admin/index.php?controller=banner_management&action=add">+ Add New Slide</a>
        <?php } ?>
        <?php } ?>
    </div>
</div>
<!--addSearch-->

<div class="content">
    <form name="Form_check" method="post" action="<?php echo BASE_URL  ?>admin/index.php?controller=banner_management&action=index&page=<?php echo $page_no ?>&status=<?php echo $page_status ?>">
        <table class="contentList">
            <thead>
                <tr>
                    <th width="50"><input type="checkbox" name="check_All" class="dpFormCheckAll"></th>
                    <th width="100" class="notCenter">Title</th>
                    <th>Image</th>
                    <th width="100">Ordering</th>
                    <th width="100">Status</th>
                    <th width="100">Created</th>
					<?php if ((!empty($slider_delete) && $slider_delete == true) || (!empty($slider_edit) && $slider_edit == true)) { ?>
                    <th width="100">Action</th>
					<?php }?>
                </tr>
            </thead>

            <tbody>

                <?php
                if (!empty($data)) {
                    foreach ($data as $key => $values) {
                        ?>                        
                        <tr>
                            <td><input type="checkbox" name="check_list[]" value="<?php echo $values['id'] ?>"></td>
                            <td class="notCenter"><?php echo $values['title'] ?></td>
                            <td><img style="width:150px;" src="<?php echo BASE_URL  . 'app' . DS . 'resources' . DS . 'document' . DS . 'banner_management' . DS . $values['photo']; ?>"  alt="" /></td>
                            <td><?php echo $values['ordering'] ?></td>
                            <td><?php echo $values['status'] ?></td>
                            <td><?php echo $values['created'] ?></td>
							<?php if ((!empty($slider_delete) && $slider_delete == true) || (!empty($slider_edit) && $slider_edit == true)) { ?>
                            <td align="center">
							<?php if (!empty($slider_edit) && $slider_edit == true) { ?>
                                <a href="index.php?controller=banner_management&amp;action=edit&amp;id=<?php echo $values['id'] ?>" class="edit"><img src="<?php echo $theme_root; ?>layout/images/action_add.png" Alt="Edit" /></a>
								<?php }?>
								<?php if (!empty($slider_delete) && $slider_delete == true) { ?>
                                <a href="index.php?controller=banner_management&amp;action=delete&amp;id=<?php echo $values['id'] ?>&amp;status=<?php echo $page_status ?>" class="delete" onclick="return window.confirm('Are you sure delete this item?');"><img src="<?php echo $theme_root; ?>layout/images/action_delete.png" Alt="Delete" /></a>
					<?php }?>
                            </td>
							<?php }?>
                        </tr>
                        <?php
                    }
                    ?>

                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="10">
							<?php if (!empty($slider_edit) && $slider_edit == true) { ?>
							<input type="hidden" value="true" name="admin_index_submite">
                            <input type="submit" name="status" class="submit submitbutton" value="Active">
                            <input type="submit" name="status" class="submit submitbutton" value="Inactive">
                            <input type="submit" name="status" class="submit submitbutton" value="Archive">
					<?php } ?>
					<?php if (!empty($slider_delete) && $slider_delete == true) { ?>
                            <input onclick="return window.confirm('Are you sure delete this item?');" type="submit" name="status" class="submit submitbutton" value="Delete" />
							<?php } ?>
                            <?php if ((!empty($_GET['status']) && $_GET['status'] == 'archive') || (!empty($_GET['status']) && $_GET['status'] == 'delete')) { ?>
                                <a class="archive" href="index.php?controller=banner_management">Back</a>
                            <?php } else { ?>
							<?php if (!empty($slider_edit) && $slider_edit == true) { ?>
                                <a class="archive" title="Archived" href="index.php?controller=banner_management&status=archive">Archived</a>
								<?php } ?>
								<?php if (!empty($slider_delete) && $slider_delete == true) { ?>
                                <a class="trash" title="Trash" href="index.php?controller=banner_management&status=delete" class="button">Trash</a>
                            <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php if (!empty($paging)) { ?>
                        <tr>
                            <td colspan="7" class="foot" align="center">
                                <?php echo $paging ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tfoot>
                <?php
            } else {
                ?>
                <tr>
                    <td colspan="7"><h2 style="text-align: center;padding: 15px 0;">No slide available.</h2></td>
                </tr> 
            <?php } ?>

        </table>
    </form>
</div>                