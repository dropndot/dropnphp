<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?php echo  $site_title; ?></h3>
    </div>
</div>
<?php if (!empty($err)) { ?> 
    <p class="err"><?php echo  $err ?></p>
<?php } ?>
<?php if (!empty($msg)) { ?> 
    <p class="msg"><?php echo  $msg ?></p>
<?php } ?>

<?php if ((!empty($settings_add) && $settings_add == true)) { ?>
<div class="addSearch">
    <div class="addarea">
        <a href="index.php?controller=default_setting&action=add">+ Add New Item</a>
    </div>
</div>
<!--addSearch-->
<?php } ?>

<div class="content settings">
    <form name="Form_check" method="post" action="<?php echo  BASE_URL  ?>admin/index.php?controller=default_setting&action=index&page=<?php echo  $page_no ?>&status=<?php echo  $page_status ?>">
        <table class="contentList">
            <thead>
                <tr>
                    <th width="50"><a href="<?php echo  BASE_URL  ?>admin/index.php?controller=default_setting&action=index&page=<?php echo  $page_no ?>&sort=id">ID</a></th>
                    <th width="150" class="notCenter"><a href="<?php echo  BASE_URL  ?>admin/index.php?controller=default_setting&action=index&page=<?php echo  $page_no ?>&sort=set_key">Key</a></th>   
                    <th class="notCenter"><a href="<?php echo  BASE_URL  ?>admin/index.php?controller=default_setting&action=index&page=<?php echo  $page_no ?>&sort=value">Value</a></th> 
                    <th width="50"><a href="<?php echo  BASE_URL  ?>admin/index.php?controller=default_setting&action=index&page=<?php echo  $page_no ?>&sort=type">Type</a></th>
                    <th width="50"><a href="<?php echo  BASE_URL  ?>admin/index.php?controller=default_setting&action=index&page=<?php echo  $page_no ?>&sort=component">Component</a></th>
					<?php if ((!empty($settings_edit) && $settings_edit == true)) { ?>
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
                            <td><?php echo  $values['id'] ?></td>
                            <td class="notCenter"><?php echo  $values['set_key'] ?></td>
                            <?php if ($values['type'] == 'image') { ?>
                                <td class="notCenter">
                                    <img style="max-width:150px;" src="app/resources/document/settings/<?php echo $values['value']; ?>" alt=""/>
                                </td>
                            <?php } else { ?>
                                <td class="notCenter"><?php echo  $values['value'] ?></td>
                            <?php } ?>
                            <td><?php echo  $values['type'] ?></td>
                            <td><?php echo  $values['component'] ?></td>
							<?php if ((!empty($settings_edit) && $settings_edit == true)) { ?>
                            <td>							
							<a href="index.php?controller=default_setting&amp;action=edit&amp;id=<?php echo  $values['id'] ?>" class="edit"><img src="<?php echo $theme_root; ?>layout/images/action_add.png" Alt="Edit" /></a>
							</td>
							<?php } ?>
                        </tr>
                        <?php
                    }
                    ?>                        

                </tbody>

                <tfoot>
                    <!--<tr>
                        <td colspan="9"><input type="submit" name="status" class="submit submitbutton" value="Active">
                        <input type="submit" name="status" class="submit submitbutton" value="Inactive">
                        <input type="submit" name="status" class="submit submitbutton" value="Archive">
                        <input type="submit" name="status" class="submit submitbutton" value="Delete"></td>
                    </tr>-->
                    <tr><td colspan="6" class="foot" align="center"><?php echo  $paging ?></td></tr>
                </tfoot>
            <?php } else { ?>
                <tr>
                    <td colspan="6"><h2 style="text-align: center;padding: 15px 0;"> No Settings available.</h2></td>
                </tr>
            <?php } ?>

        </table>
    </form>
</div>                