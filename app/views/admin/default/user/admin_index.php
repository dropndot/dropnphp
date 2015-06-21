<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <?php if ((!empty($_GET['status']) && $_GET['status'] == 'banned') || (!empty($_GET['status']) && $_GET['status'] == 'delete')) { ?>
            <?php if ($_GET['status'] == 'banned') { ?>
                <h3>Archived <?php echo $site_title; ?></h3>
            <?php } ?>
            <?php if ((!empty($_GET['status']) && $_GET['status'] == 'delete')) { ?>
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
        <?php if ((!empty($_GET['status']) && $_GET['status'] == 'banned') || (!empty($_GET['status']) && $_GET['status'] == 'delete')) { ?>
            <a href="index.php?controller=user"><- Back</a>
        <?php
		} else {
			if (!empty($users_add) && $users_add == true) {
		?>
            <a href="index.php?controller=user&action=add">+ Add New User</a>
        <?php } ?>
        <?php } ?>
    </div>
    <div class="SearchArea">
        <form action="index.php?controller=user" method="post">
            <input type="text" name="key" value="<?php echo!empty($_POST['key']) ? $_POST['key'] : '' ?>" placeholder="Enter Search Key" />
            <input class="searchbtn" type="submit" name="search" value="Search" />
        </form>
    </div>
</div>
<!--addSearch-->
<div class="content">
    <form name="Form_check" method="post" action="<?php echo BASE_URL ?>admin/index.php?controller=user&action=index&page=<?php echo $page_no ?>&status=<?php echo $page_status ?>">
        <table class="contentList">
            <thead>
                <tr>
                    <th width="50"><input type="checkbox" name="check_All" class="dpFormCheckAll"></th>
                    <th class="notCenter">Name</th>
                    <th width="100">Email</th> 
                    <th width="100">Phone</th>
                    <th width="200">User Group</th>
                    <th width="100">Status</th>
					<?php if ((!empty($users_edit) && $users_edit == true) || (!empty($users_delete) && $users_delete == true)) { ?>
                    <th width="100">Action</th>
					<?php }?>
                </tr>
            </thead>

            <tbody>

                <?php
                if (!empty($data)) {
                    foreach ($data as $key => $values) {
						$sql = "SELECT name FROM " . $this->app->config['db_prefix'] . "groups WHERE id = " . $values['group_id'];
						$result = mysql_query($sql);
						$row = mysql_fetch_assoc($result);
						$user_group = $row['name'];
                        ?>                        
                        <tr>
                            <td class="center"><input type="checkbox" name="check_list[]" value="<?php echo $values['id'] ?>"></td>
                            <td class="notCenter"><?php echo $values['name'] ?></td>
                            <td><?php echo $values['email'] ?></td>
                            <td><?php echo $values['phone'] ?></td>
                            <td><?php echo $user_group; ?></td>
                            <td><?php echo $values['status'] ?></td>
							<?php if ((!empty($users_edit) && $users_edit == true) || (!empty($users_delete) && $users_delete == true)) { ?>
                            <td>
								<?php if (!empty($users_edit) && $users_edit == true) { ?>
                                <a title="Edit" href="index.php?controller=user&amp;action=edit&amp;id=<?php echo $values['id'] ?>"><img src="<?php echo $theme_root; ?>layout/images/action_add.png" Alt="Edit" /></a>
								<?php }?>
								<?php if (!empty($users_delete) && $users_delete == true) { ?>
                                <a title="Delete" href="index.php?controller=user&amp;action=delete&amp;id=<?php echo $values['id'] ?>&amp;status=<?php echo $page_status ?>" onclick="return window.confirm('Are you sure delete this item?');"><img src="<?php echo $theme_root; ?>layout/images/action_delete.png" Alt="Delete" /></a>
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
                        <td colspan="7">
							<?php if (!empty($users_edit) && $users_edit == true) { ?>
							<input type="hidden" value="true" name="admin_index_submite">
                            <input type="submit" name="status" class="submit submitbutton" value="Active">
                            <input type="submit" name="status" class="submit submitbutton" value="Inactive">
                            <input type="submit" name="status" class="submit submitbutton" value="Banned">
							<?php }?>
							<?php if (!empty($users_delete) && $users_delete == true) { ?>
                            <input onclick="return window.confirm('Are you sure delete this item?');" type="submit" name="status" class="submit submitbutton" value="Delete" />
							<?php }?>
                            <?php if ((!empty($_GET['status']) && $_GET['status'] == 'banned') || (!empty($_GET['status']) && $_GET['status'] == 'delete')) { ?>
                                <a class="archive" href="index.php?controller=user">Back</a>
                            <?php } else { ?>
								<?php if (!empty($users_edit) && $users_edit == true) { ?>
                                <a class="archive" title="Banned" href="index.php?controller=user&status=banned">Banned</a>
								<?php } ?>
								<?php if (!empty($users_delete) && $users_delete == true) { ?>
                                <a class="trash" title="Trash" href="index.php?controller=user&status=delete">Trash</a>
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
            <?php } else { ?>
                <tr>
                    <td colspan="7"><h2 style="text-align: center;padding: 15px 0;">No data available.</h2></td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>                