<?php
    function dir_listing($dir_tree, $c_path=null, $label=0, $site_url ){
        if(!empty($c_path))
        $sub_c_path = explode('/',$c_path);
        $zero = 0;
?>
    <ul>
    <?php foreach($dir_tree as $key => $value): ?>
        <? if($value['kind'] == 'directory'): ?>
            <li><a class="folderClose" href="<?=$site_url ?>admin/index.php?controller=media&path=<?=$value['path']?>"><?=$value['name']?></a>
            <? if(!empty($c_path) && isset($sub_c_path[$label])){
                if($zero==strcasecmp($sub_c_path[$label],$value['name'])){
                    if(!empty($value['content'])){         
                        dir_listing($value['content'],$c_path,$label+1,$site_url );
                    }
                }
            }  ?>           
            </li>
         <? else: ?>
            <li><a class="file" href="<?=$site_url ?>admin/index.php?controller=media&path=<?=$value['path']?>"><?=$value['name']?></a>
         <? endif; ?> 
    <?php endforeach; ?>
    </ul>
<?php
    }
?>