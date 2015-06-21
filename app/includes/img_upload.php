<?php
    function img_upload($dir, $file, $file_type){
        if(!empty($dir) && !empty($file)){
            $upload_address = BASE .DS.'app'.DS.'resources'.DS.'images'.DS. $dir .DS ;
            $upload_file = $upload_address . $file;
            if($file_type == 'image/gif' || $file_type == 'image/jpg' || $file_type == 'image/jpeg'|| $file_type == 'image/bmp' || $file_type == 'image/png'){
                 if(move_uploaded_file($_FILES['product_img']['tmp_name'],$upload_file)){
                 }
            }
        }
    }
?>