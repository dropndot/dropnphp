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
    <div class="mainbody">
        <div class="sidebar">
            <h1>Folder : <?php echo !empty($c_path) ? $c_path : 'root/' ?></h1>
            <? //print_r($dir_tree); ?>
            <? if (!empty($c_path)): ?>
                <? dir_listing($dir_tree, $c_path, 3, BASE_URL ) ?>
            <? else: ?>                                         
                <? dir_listing($dir_tree, '', 2, BASE_URL ) ?>
            <? endif; ?>
        </div>
        <div class="maincon">
            <? if (isset($dir_content)): ?>
                <? if (!empty($dir_content)): ?>
                    <form name="Form_check" method="post" action="">
                        <table cellspacing="0" cellpadding="0" border="0">
                            <tr>
        <!--                                <th width="50px"><input type="checkbox" name="check_All" class="dpFormCheckAll"></th>-->
                                <th>Name</th>
                                <th width="90px">Size</th>
        <!--                                <th>Last modified</th>-->
								<?php if (!empty($media_manager_delete) && $media_manager_delete == true) {?>
                                <th width="50px">Actions</th>
								<?php } ?>
                            </tr>
                            <? foreach ($dir_content as $key => $value): ?>
                                <tr>
            <!--                                    <td><input type="checkbox" name="check_list[]" value=""></td>-->
                                    <td><a href="<?php echo BASE_URL  ?>admin/index.php?controller=media&path=<?php echo $value['path'] ?>"><?php echo $value['name'] ?></a></td>
                                    <td><?php echo $value['size'] ?></td>
            <!--                                    <td><?php echo '&nbsp;' //$value['modify']  ?></td>-->
									<?php if (!empty($media_manager_delete) && $media_manager_delete == true) {?>
                                    <td>
									<a href="<?php echo BASE_URL  ?>admin/index.php?controller=media&path=<?php echo $c_path ?>&file=<?php echo $value['path'] ?>&delete=y" onclick="return window.confirm('Are you sure delete this item?');">Delete</a>
									</td>
									<?php } ?>
                                </tr>
                            <? endforeach; ?>
                        </table>
                    </form>
                <? else: ?>
                    <div class="noMedia">
                        <span>No Media file found!!!</span>
                    </div>
                <? endif; ?>
				<?php if (!empty($media_manager_add) && $media_manager_add == true) {?>
                <div class="uploadMedia">
                    <form name="upload-media" method="post" action="" enctype="multipart/form-data">
    <!--                        <input type="hidden" name="MAX_FILE_SIZE" value="500000" />-->
    <!--                        <p><label>Select Media</label><b>&nbsp;</b><input type="file" name="up-media" /></p>-->
                        <p><input type="file" name="up-media" /></p>
                        <p><input style="padding:5px 10px;" type="submit" value="Upload" name="upload_media" /></p>
                    </form> 
                </div> 
				<?php } ?>
            <? elseif (isset($file_info)): ?>
                <?
                if (
                        $file_info['extension'] == 'png' ||
                        $file_info['extension'] == 'PNG' ||
                        $file_info['extension'] == 'JPG' ||
                        $file_info['extension'] == 'jpg' ||
                        $file_info['extension'] == 'jpeg' ||
                        $file_info['extension'] == 'JPEG' ||
                        $file_info['extension'] == 'GIF' ||
                        $file_info['extension'] == 'gif' ||
                        $file_info['extension'] == 'BNP' ||
                        $file_info['extension'] == 'bmp') {
                    list($width, $height, $type, $attr) = getimagesize($file_info['path']);
                }
                ?>
                <div class="fileInfoOutter">
                    <div class="fileInfo">
                        <? if (isset($width)): ?>
                            <img src="<?php echo $file_info['path'] ?>" alt="" <?php image_resize($width, $height, 100) ?> />
                        <? endif; ?>
                        <div class="fileInfoTxt">
                            <p><b>Name : </b><i><?php echo $file_info['name'] ?></i></p>
                            <p><b>File Path : </b><i><?php echo $file_info['path'] ?></i></p>
                            <p><b>File Full Path : </b><i><?php echo getcwd() . '/' . $file_info['path'] ?></i></p>
                            <p><b>File URL : </b><i><a href="<?php echo BASE_URL  . $file_info['path'] ?>" target="_blank"><?php echo BASE_URL  . $file_info['path'] ?></a></i></p>
                            <? if (isset($width)): ?><p><b>Dimensions : </b><i><?php echo $width . 'x' . $height ?></i></p><? endif; ?>
                            <p><b>Size : </b><i><?php echo $file_info['size'] ?></i></p>
                        </div>
                    </div>
                </div>
            <? endif; ?>     
        </div>
    </div>  
</div>                