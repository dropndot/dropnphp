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
<?php if (!empty($menus_add) && $menus_add == true) {?>
<div class="addSearch">
    <div class="addarea">
        <a href="index.php?controller=menus&action=add">+ Add New Menu</a>
    </div>
</div>
<!--addSearch-->
<?php }?>
<div class="content">
    <form name="Form_check" method="post" action="<?php echo BASE_URL  ?>admin/index.php?controller=menus&action=index&page=<?php echo $page_no ?>&status=<?php echo $page_status ?>">
        <table class="contentList">
            <thead>
                <tr>
                    <th width="50">ID</th>
                    <th class="notCenter">Menu Title</th>  
                    <th width="100">Status</th>
                    <th width="200">Created</th>
					<?php if ((!empty($menus_delete) && $menus_delete == true) || (!empty($menus_edit) && $menus_edit == true)) { ?>
                    <th width="100">Action</th>
					<?php } ?>
                </tr>
            </thead>

            <tbody>

                <?php
                if (!empty($data)) {
                    foreach ($data as $key => $values) {
                        ?>                        
                        <tr>
                            <td><?php echo $values['id'] ?></td>
                            <td class="notCenter"><a href="index.php?controller=menu_item&amp;menus_id=<?php echo $values['id'] ?>"><?php echo $values['title'] ?></a></td> 
                            <td><?php echo $values['status'] ?></td>
                            <td><?php echo $values['created'] ?></td>
							<?php if ((!empty($menus_delete) && $menus_delete == true) || (!empty($menus_edit) && $menus_edit == true)) { ?>
                            <td>
							<?php if (!empty($menus_edit) && $menus_edit == true) { ?>
                                <a href="index.php?controller=menus&amp;action=edit&amp;id=<?php echo$values['id'] ?>"><img src="<?php echo $theme_root; ?>layout/images/action_add.png" Alt="Edit" /></a>
								<?php } ?>
								<?php if (!empty($menus_delete) && $menus_delete == true) { ?>
                                <a href="index.php?controller=menus&amp;action=delete&amp;id=<?php echo$values['id'] ?>&amp;status=<?php echo$page_status ?>" onclick="return window.confirm('Are you sure delete this item?');"><img src="<?php echo $theme_root; ?>layout/images/action_delete.png" Alt="Delete" /></a>
								<?php } ?>
                            </td>
							<?php } ?>
                        </tr>
                        <?php
                    }
                    ?>                  
                </tbody>

                <tfoot>
                    <?php if (!empty($paging)) { ?>
                        <tr><td colspan="9" class="foot" align="center"><?php echo $paging ?></td></tr>
                    <?php } ?>
                </tfoot>
            <?php } else { ?>
                <tr>
                    <td colspan="9"><h2 style="text-align: center;padding: 15px 0;">No menu available.</h2></td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>                