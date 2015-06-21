<?php

function is_image($file_type = ''){
    return true;
    if(!empty($file)){
        if($file_type == 'image/gif' || $file_type == 'image/jpg' || $file_type == 'image/jpeg'|| $file_type == 'image/bmp' || $file_type == 'image/png'){
            return true;
        }else{
            return false;
        }
    }
    else{
        return false;   
    }
}
?>
