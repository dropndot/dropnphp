<?php
class make_thumb{
    var $err = '';
    
  function make_thumb_func($src = '', $dest = '', $desired_width = '')
{

    if(!empty($src) || !empty($dest) || !empty($desired_width)){
        $exts = array();
        $exts = explode(".",$file);
        $count = count($exts);
        $ext = $exts[$count-1];
        
        /* read the source image */
        switch ($ext)
         {case 'gif':   //   gif -> jpg
            $img_src = imagecreatefromgif($file_src);
            break;
          case 'jpeg':   //   jpeg -> jpg
            $img_src = imagecreatefromjpeg($file_src); 
            break;
          case 'png':  //   png -> jpg
            $img_src = imagecreatefrompng($file_src);
            break;
         }
        
        $source_image = imagecreatefromjpeg($src);
        if(!$source_image){
            $this->err = "Can't creat source image";
            return false;
        }
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        
        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height*($desired_width/$width));
        
        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width,$desired_height);
        if(!$virtual_image){
            $this->err = "Can't creat virtual image";
            return false;
        }
        
        /* copy source image at a resized size */
        if(!imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height)){
            $this->err = "can't resize virtual image";
            return false;
        }
        /* create the physical thumbnail image to its destination */
        if(imagejpeg($virtual_image,$dest)){
            return true;
        }
    }
    return false;
}
}
?>
