<?php
    function image_resize($width, $height, $target) { 
        
        
        if ($width > $height) 
            $percentage = ($target / $width);
        else 
            $percentage = ($target / $height);
        
        $width = round($width * $percentage);
        $height = round($height * $percentage); 
        
        echo "width=\"$width\" height=\"$height\""; 
  }
  
  function get_image_resize($file, $target) { 
        
        $img_info = getimagesize($file);
        $width = $img_info[0];
        $height = $img_info[1];
        if ($width > $height) 
            $percentage = ($target / $width);
        else 
            $percentage = ($target / $height);
        
        $width = round($width * $percentage);
        $height = round($height * $percentage); 
        
        echo "width=\"$width\" height=\"$height\""; 
  }
?>