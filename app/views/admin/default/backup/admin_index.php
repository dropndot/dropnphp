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

<div class="content">
    <div style="width:830px;" class="inputForm">
        <form action="<?php echo BASE_URL ?>admin/index.php?controller=backup&action=index" name="db_backup" method="post">
            <label>Database version comment: *</label>
            <input type="text" name="db_comment">
            <input class="backupBtn" type="submit" value="Creat A New Backup" name="backup_button">
        </form>
    </div>
    <form name="Form_check" method="post" action="<?php echo BASE_URL ?>admin/index.php?controller=default_setting&action=index&page=<?//=$page_no?>&status=<?//=$page_status?>">
                <table class="contentList">
                    <thead>
                        <tr>
                            <th class="center"><input type="checkbox" name="check_All" class="dpFormCheckAll"></th>
                            <th class="left">Version Comment</th>
                            <th>Title</th>
                            <th>Created By</th>
                            <th>Created</th>
                            <th class="right" align="center">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        
                        <?php
                        if (!empty($data)) {
                            foreach($data as $key=>$values){
                        ?>                        
                        <tr>
                            <td class="center"><input type="checkbox" name="check_list[]" value="<?php echo $values['id']?>"></td>
                            <td><?php echo $values['version_comment']?></td>
                            <td><?php echo $values['title']?></td>
                            <td><?php echo $values['created_by']?></td>
                            <td><?php echo $values['created']?></td>
                            <td align="center"><a href="index.php?controller=backup&amp;action=delete&amp;id=<?php echo $values['id']?>" class="delete" onclick="return window.confirm('Are you sure delete this item?');"><img src="<?php echo $theme_root; ?>layout/images/action_delete.png" Alt="Delete" /></a></td>
                        </tr>
                        <?php } ?>  
						<?php if (!empty($paging)) { ?>
                        <tr>
                            <td colspan="8" class="foot" align="center">
                                <?php echo $paging ?>
                            </td>
                        </tr>
                    <?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="11"><h2 style="text-align: center;padding: 15px 0;"> No backup available.</h2></td>
					</tr>
				<?php } ?>
                    </tbody>
                </table>    
    </form>
</div>                