<?php
if( ! defined( '_VALIDACCESS' ) ) { die( 'Sorry to say, you can not access this page on this way!' ); }

class media{
    
    private $app;
    
    
    
    public function __construct( $app ) {
        $this->app = $app;
    }
    
    
    
    function get_file_info($path, $filter = false){
        if(is_file($path)){
            $file_info = array();
            $subdirectories = explode('/',$path);
            
            $extension = end(explode('.',end($subdirectories)));

            if($filter === FALSE || $filter == $extension){
                
                /*$script_name = $_SERVER['SCRIPT_NAME'];
                $script = explode('/',$script_name);
                $url = 'http://'.$_SERVER['HTTP_HOST'].*/
                //print_r($script);
                //$url = $script[0].$path;
                $size = filesize($path);
                if($size>1024){
                    $size = round($size/1024);
                    $size = $size.'kb';
                }
                else{
                    $size = $size.'b';
                }
                $file_info = array(
                    'path'      => $path,
                    'name'      => end($subdirectories),
                    'extension' => $extension,
                    'size'      => $size,
                    'kind'      => 'file',
                    //'modify'    => date ("F d Y H:i:s.", filemtime(end($subdirectories)))
                    );
                    
                    return $file_info;
            }
        }
        return false;
    }                                     
  
  
  
  function scan_directory($directory, $filter=FALSE)
  {
    if(substr($directory,-1) == '/')
    {
        $directory = substr($directory,0,-1);
    }

    
    if(!file_exists($directory) || !is_dir($directory))
    {
        
        return FALSE;

    
    }elseif(is_readable($directory))
    {
        
        $directory_tree = array();

        
        $directory_list = opendir($directory);

        
        while (FALSE !== ($file = readdir($directory_list)))
        {
            if($file != '.' && $file != '..')
            {
                $path = $directory.'/'.$file;

                if(is_readable($path))
                {
                    $subdirectories = explode('/',$path);

                    if(is_file($path))
                    {
                        $extension = end(explode('.',end($subdirectories)));

                        if($filter === FALSE || $filter == $extension)
                        {
                            $size = filesize($path);
                            if($size>1024){
                                $size = round($size/1024);
                                $size = $size.'kb';
                            }
                            else{
                                $size = $size.'b';
                            }
                            $directory_tree[] = array(
                                'path'      => $path,
                                'name'      => end($subdirectories),
                                'extension' => $extension,
                                'size'      => $size,
                                'kind'      => 'file',
                                //'modify'    => date ("F d Y H:i:s.", filemtime(end($subdirectories)))
                                );
                        }
                    }
                }
            }
        }
        closedir($directory_list);
        return $directory_tree;

    }else{
        return FALSE;
    }
}
    
    
    
function scan_directory_recursively($directory, $filter=FALSE)
{     
    if(substr($directory,-1) == '/')
    {
        $directory = substr($directory,0,-1);
    }

    
    if(!file_exists($directory) || !is_dir($directory))
    {
        
        return FALSE;

    
    }elseif(is_readable($directory))
    {
        
        $directory_tree = array();

        
        $directory_list = opendir($directory);

        
        while (FALSE !== ($file = readdir($directory_list)))
        {
            if($file != '.' && $file != '..')
            {
                $path = $directory.'/'.$file;

                if(is_readable($path))
                {
                    $subdirectories = explode('/',$path);

                    if(is_dir($path))
                    {
                        $directory_tree[] = array(
                            'path'    => $path,
                            'name'    => end($subdirectories),
                            'kind'    => 'directory',
                            'content' => $this->scan_directory_recursively($path, $filter)
                            );
                            
                            /*echo '<li><a class="folderClose" href="index.php?path='.$path.'">'.end($subdirectories).'</a>';
                            $zero = 0;
                            
                            if(!empty($c_path) && isset($sub_c_path[$label])){
                                if($zero==strcasecmp($sub_c_path[$label],end($subdirectories))){
                                    scan_directory_recursively($path, $c_path , $label+1 ,$filter);
                                }
                            }*/
                            

                    }elseif(is_file($path))
                    {
                        $extension = end(explode('.',end($subdirectories)));

                        if($filter === FALSE || $filter == $extension)
                        {
                            $size = filesize($path);
                            if($size>1024){
                                $size = round($size/1024);
                                $size = $size.'kb';
                            }
                            else{
                                $size = $size.'b';
                            }
                            $directory_tree[] = array(
                                'path'      => $path,
                                'name'      => end($subdirectories),
                                'extension' => $extension,
                                'size'      => $size,
                                'kind'      => 'file');
                            
                           // echo '<li><a class="file" href="index.php?path='.$path.'">'.end($subdirectories).'</a></li>';
                        }
                    }
                }
            }
        }
        closedir($directory_list);
        return $directory_tree;
        /*echo '</li></ul>';
        return true;*/

    }else{
        return FALSE;
    }
}

function upload_media($c_path){
    if(!empty($_FILES['up-media']['name'])){
         $upload_address = BASE.$c_path;    
         $file_name = basename($_FILES['up-media']['name']);
         $upload_file = $upload_address.DS.$file_name;
         
         if(move_uploaded_file($_FILES['up-media']['tmp_name'],$upload_file)){
             $this->app->view->msg = $this->app->lang['SUCCESS_MEDIA_SAVE'];
         }else{
            $this->err = "Can't upload Image file."; 
         }
    }
}

function delete_media($c_path){
    if(is_file($c_path)){
        unlink($c_path);
        $this->app->view->msg = $this->app->lang['SUCCESS_MEDIA_DELETE'];
    }else
        $this->err="Can't delete the media.";
}
  
  
}
?>