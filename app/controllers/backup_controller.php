<?php
class backup_controller extends appcontroller {
    
    public function admin_index() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->database_backup, $this->permision_arr);
        //Permission end
		
        if(isset($_POST['backup_button'])){
            $err='';
            if(empty($err) && empty($_POST['db_comment'])){
                $err='Database backup version comment field can not be blank.';
            }
            if(empty($err)){
                $this->app->backup->backup_comment = $_POST['db_comment'];
                if($this->app->backup->export()){
                    $this->app->view->msg = "Database Backup Saved Successfully";
                }
                else{
                    $this->app->view->err = "Can't Creat Database Backup, Please Try Again Later";
                }
            }
            else{
                $this->app->view->err = $err;
            }
                
        }
        
        $url = 'index.php?controller=backup&';
        $paging_string = $this->app->backup->paging($this->app->config['db_prefix']."backup", $this->app->settings['admin_page_factor'], $url);
        $this->app->view->data = $this->app->backup->paging_data;
        $this->app->view->paging = $paging_string;
        $this->app->view->site_title = 'Manage Database Backup';
        $this->app->view->backup_selected = ' class="selected"';
        
        $this->app->view->display('admin_index');
    }
    
	public function admin_delete() {

		//Permission start 
        $this->app->role_user->check_permission($this->database_backup, $this->permision_arr);
        //Permission end
        if (empty($_REQUEST['id'])) {
            $this->admin_index();
            exit;
        }

        $this->app->backup->delete_trash($_REQUEST['id']);
        if (!empty($this->app->backup->err)) {
            $this->app->view->err = $this->app->backup->err;
        } else {
            $this->app->view->msg = 'Backup has been deleted successfully.';
        }

        $this->admin_index();
        exit;
    }
    
    
    
    
    public function index(){
        echo 'default category index...';
        $this->app->view->site_title = 'catagory';
        $this->app->view->display();
    }
}
?>