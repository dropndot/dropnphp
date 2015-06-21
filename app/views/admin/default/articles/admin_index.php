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
            <a href="index.php?controller=articles"><- Back</a>
        <?php 
		} else { 
			if (!empty($articles_add) && $articles_add == true) {
		?>
            <a href="index.php?controller=articles&action=add">+ Add New Article</a>
        <?php 
		}
			}
		?>
    </div>
    <div class="SearchArea">
        <form action="index.php?controller=articles" method="post">
            <select name="c_id">
                <option value="">Choose Category</option>
                <?php foreach ($category_id as $key => $value) { ?>
                    <option <?php if (!empty($_POST['c_id']) && $_POST['c_id'] == $value['id']) { ?> selected="selected" <?php } ?> value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
                <?php } ?>
            </select>
            <input class="searchbtn" type="submit" name="search" value="Search" />
        </form>
    </div>
</div>
<!--addSearch-->

<div class="content">
    <form name="Form_check" method="post" action="<?php echo BASE_URL ?>admin/index.php?controller=articles&action=index&page=<?php echo $page_no ?>&status=<?php echo $page_status ?>">
        <table class="contentList">
            <thead>
                <tr>
                    <th width="20"><input type="checkbox" name="check_All" class="dpFormCheckAll"></th>
                    <th widt="80" class="notCenter">Category</th>
                    <th class="notCenter">Title</th>
					<?php if (!empty($articles_edit) && $articles_edit == true) { ?>
                    <th class="notCenter" width="50">Featured</th>
					<?php } ?>
                    <th width="20">Ordering</th>
                    <th width="20">Status</th>
                    <th width="70">Created</th>
				<?php if ((!empty($articles_edit) && $articles_edit == true) || (!empty($articles_delete) && $articles_delete == true)) { ?>
                    <th width="60">Action</th>
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
                            <td class="notCenter"><?php echo $values['category_title'] ?></td>
                            <td class="notCenter"><?php echo $values['title'] ?></td>
							<?php if (!empty($articles_edit) && $articles_edit == true) { ?>
                            <td>
                                <?php if ($values['featured'] == 'yes') { ?>
                                    <a title="Cancel Featured" href="index.php?controller=articles&amp;f_id=<?php echo $values['id'] ?>&amp;st=no" class="delete"><img src="<?php echo $theme_root; ?>layout/images/ok.png" Alt="Delete" /></a>
                                <?php } else { ?>
                                    <a title="Set Featured" href="index.php?controller=articles&amp;f_id=<?php echo $values['id'] ?>&amp;st=yes" class="delete"><img src="<?php echo $theme_root; ?>layout/images/action_delete.png" Alt="Delete" /></a>
                                <?php } ?>
                            </td>
							<?php } ?>
                            <td><?php echo $values['ordering'] ?></td>
                            <td><?php echo $values['status'] ?></td>
                            <td><?php echo $values['modified'] ?></td>
						<?php if ((!empty($articles_edit) && $articles_edit == true) || (!empty($articles_delete) && $articles_delete == true)) { ?>
                            <td>
							<?php if (!empty($articles_edit) && $articles_edit == true) { ?>
								<a title="Edit" href="index.php?controller=articles&amp;action=edit&amp;id=<?php echo $values['id'] ?>" class="edit"><img src="<?php echo $theme_root; ?>layout/images/action_add.png" Alt="Edit" /></a>
							<?php }?>
							<?php if (!empty($articles_delete) && $articles_delete == true) { ?>
								<a title="Delete" href="index.php?controller=articles&amp;action=delete&amp;id=<?php echo $values['id'] ?>&amp;status=<?php echo $page_status ?>" class="delete" onclick="return window.confirm('Are you sure delete this item?');"><img src="<?php echo $theme_root; ?>layout/images/action_delete.png" Alt="Delete" /></a>
                            <?php }?>
							</td>
						<?php } ?>
                        </tr>
                        <?php } ?>

                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="8">
						<?php if (!empty($articles_edit) && $articles_edit == true) { ?>
							<input type="submit" name="change_status" class="submit submitbutton" value="Active">
                            <input type="submit" name="change_status" class="submit submitbutton" value="Inactive">
                            <input type="submit" name="change_status" class="submit submitbutton" value="Archive">
						<?php }?>
						<?php if (!empty($articles_delete) && $articles_delete == true) { ?>
                            <input onclick="return window.confirm('Are you sure delete this item?');" type="submit" name="change_status" class="submit submitbutton" value="Delete">
                        <?php }?>
							<?php if ((!empty($_GET['status']) && $_GET['status'] == 'archive') || (!empty($_GET['status']) && $_GET['status'] == 'delete')) { ?>
                                <a class="archive" href="index.php?controller=articles">Back</a>
                            <?php } else { ?>
							<?php if (!empty($articles_edit) && $articles_edit == true) { ?>
                                <a class="archive" title="Archived" href="index.php?controller=articles&status=archive">Archived</a>
							<?php } ?>
							<?php if (!empty($articles_delete) && $articles_delete == true) { ?>
                                <a class="trash" title="Trash" href="index.php?controller=articles&status=delete">Trash</a>
                            <?php } ?>
							<?php } ?>
                        </td>
                    </tr>
                    <?php if (!empty($paging)) { ?>
                        <tr>
                            <td colspan="8" class="foot" align="center">
                                <?php echo $paging ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tfoot>
            <?php } else { ?>
                <tr>
                    <td colspan="11"><h2 style="text-align: center;padding: 15px 0;"> No articles available.</h2></td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>                