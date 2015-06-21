<?php
class media_controller extends appcontroller {
    
    public function admin_index() {
        
		//Permission start 
        $this->app->role_user->check_permission($this->media_manager, $this->permision_arr);
        //Permission end
        $root = 'app'.DS.'resources'.DS.'document';
        if(!empty($_POST['upload_media'])){
			//Permission start 
			$this->app->role_user->check_permission($this->media_manager, array($this->permision_arr[1]));
			//Permission end
            if(isset($_GET['path'])){
                $this->app->media->upload_media($_GET['path']);
            }else
                $this->app->media->upload_media($root);
        }
        
        if(isset($_GET['delete'])){
			//Permission start 
			$this->app->role_user->check_permission($this->media_manager, array($this->permision_arr[3]));
			//Permission end
            if($_GET['delete']=='y'){ 
                if(isset($_GET['file']))
                    $this->app->media->delete_media($_GET['file']); 
            }
        }
        
        
        $dir_tree = $this->app->media->scan_directory_recursively($root);
        
        $this->app->view->dir_tree = $dir_tree;
        //$this->app->view->c_path =isset($_GET['path'])?$_GET['path']:'';
                    
        if(isset($_GET['path'])){
            $this->app->view->c_path=$_GET['path'];
            if(is_dir($_GET['path'])){   
                $this->app->view->dir_content = $this->app->media->scan_directory($_GET{'path'});
            }
            elseif(is_file($_GET['path'])){  
                $this->app->view->file_info = $this->app->media->get_file_info($_GET['path']);
            }
        }
        else{  
            $this->app->view->c_path='';    
            $this->app->view->dir_content = $this->app->media->scan_directory($root);
        }
        
        
        $this->app->view->site_title = 'Media Manager';
        $this->app->view->media_selected = ' class="selected"';
        $this->app->view->MEDIA = 'Media';
        
        $this->app->view->display('admin_index');
    }
    
    
    
    
    
    public function index(){
        echo 'default Media index...';
        $this->app->view->site_title = 'Media';
        $this->app->view->display();
    }
}
?>