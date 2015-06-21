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
            <a href="index.php?controller=manage_block"><- Back</a>
        <?php } else { ?>
		<?php if (!empty($blocks_add) && $blocks_add == true) {?>
            <a href="index.php?controller=manage_block&action=add">+ Add New Block</a>
        <?php } ?>
        <?php } ?>
    </div>
    <div class="SearchArea">
        <form action="index.php?controller=manage_block" method="post">
            <select name="block_id">
                <option value="">Choose Block Area</option>
                <?php foreach ($block_area_id as $key => $value) { ?>
                    <option <?php if (!empty($_POST['block_id']) && $_POST['block_id'] == $value['id']) { ?> selected="selected" <?php } ?> value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
                <?php } ?>
            </select>
            <input class="searchbtn" type="submit" name="search" value="Search" />
        </form>
    </div>
</div>
<!--addSearch-->

<div class="content">
    <form name="Form_check" method="post" action="<?php echo BASE_URL  ?>admin/index.php?controller=manage_block&action=index&page=<?php echo $page_no ?>&status=<?php echo $page_status ?>&block_id=<?php echo $block_id ?>">
        <table class="contentList">
            <thead>
                <tr>
                    <th width="50"><input type="checkbox" name="check_All" class="dpFormCheckAll"></th>
                    <th class="notCenter">Block Title</th>
                    <th width="50">Ordering</th>
                    <th width="50">Status</th>
                    <th width="150">Created</th>
					<?php if ((!empty($blocks_delete) && $blocks_delete == true) || (!empty($blocks_edit) && $blocks_edit == true)) { ?>
                    <th width="50">Action</th>
					<?php }?>
                </tr>
            </thead>

            <tbody>

                <?php
                if (!empty($data)) {
                    foreach ($data as $key => $values) {
                        ?>                        
                        <tr>
                            <td class="center"><input type="checkbox" name="check_list[]" value="<?php echo $values['id'] ?>"></td>
                            <td class="notCenter"><?php echo $values['title'] ?></td>
                            <td><?php echo $values['ordering'] ?></td>
                            <td><?php echo $values['status'] ?></td>
                            <td><?php echo $values['created'] ?></td>
							<?php if ((!empty($blocks_delete) && $blocks_delete == true) || (!empty($blocks_edit) && $blocks_edit == true)) { ?>
                            <td>
								<?php if (!empty($blocks_edit) && $blocks_edit == true) { ?>
                                <a href="index.php?controller=manage_block&amp;action=edit&amp;id=<?php echo $values['id'] ?>" class="edit"><img src="<?php echo $theme_root; ?>layout/images/action_add.png" Alt="Edit" /></a>
								<?php }?>
								<?php if (!empty($blocks_delete) && $blocks_delete == true) { ?>
                                <a href="index.php?controller=manage_block&amp;action=delete&amp;id=<?php echo $values['id'] ?>&amp;status=<?php echo $page_status ?>" class="delete" onclick="return window.confirm('Are you sure delete this item?');"><img src="<?php echo $theme_root; ?>layout/images/action_delete.png" Alt="Delete" /></a>
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
                        <td colspan="6">
							<?php if (!empty($blocks_edit) && $blocks_edit == true) { ?>
							<input type="hidden" value="true" name="admin_index_submite">
                            <input type="submit" name="status" class="submit submitbutton" value="Active">
                            <input type="submit" name="status" class="submit submitbutton" value="Inactive">
                            <input type="submit" name="status" class="submit submitbutton" value="Archive">
							<?php }?>
							<?php if (!empty($blocks_delete) && $blocks_delete == true) { ?>
                            <input onclick="return window.confirm('Are you sure delete this item?');" type="submit" name="status" class="submit submitbutton" value="Delete">
							<?php }?>
                            <?php if ((!empty($_GET['status']) && $_GET['status'] == 'archive') || (!empty($_GET['status']) && $_GET['status'] == 'delete')) { ?>
                                <a class="archive" href="index.php?controller=manage_block">Back</a>
                            <?php } else { ?>
							<?php if (!empty($blocks_edit) && $blocks_edit == true) { ?>
                                <a class="archive" title="Archived" href="index.php?controller=manage_block&status=archive">Archived</a>
							<?php }?>
							<?php if (!empty($blocks_delete) && $blocks_delete == true) { ?>
                                <a class="trash" title="Trash" href="index.php?controller=manage_block&status=delete">Trash</a>
                            <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php if (!empty($paging)) { ?>
                        <tr>
                            <td colspan="6" class="foot" align="center">
                                <?php echo $paging ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tfoot>
                <?php
            } else {
                ?>
                <tr>
                    <td colspan="6"><h2 style="text-align: center;padding: 15px 0;">No block available.</h2></td>
                </tr> 
            <?php } ?>
        </table>
    </form>
</div>                
