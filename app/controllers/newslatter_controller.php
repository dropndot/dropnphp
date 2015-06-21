<?php
class newslatter_controller extends appcontroller {
    var $additionalController = array('pages', 'news_management', 'product', 'product_item', 'organizer_management' );
    
    var $paging_data;
    var $err;
    
    public function admin_index() {
        
		 //Permission start 
        $this->app->role_user->check_permission($this->newslatter, $this->permision_arr);
        //Permission end
        $valid_time = 60*60*24*30+time();
        if(isset($_POST['admin_index_submite'])){
            if(!empty($_POST['check_list'])){
                $this->app->news_management->update_status($_POST);
                $this->app->view->msg = $this->app->lang['SUCCESS_NEWS_STATUS'];
            }else   
                $this->app->view->err='No data is checked.';
        }
            
        if(!isset($_COOKIE['pageStatus'])){
            if(empty($_GET['status'])){
                setcookie("pageStatus","subscribe",$valid_time);
                $page_status = 'subscribe';
            }   
        }
        else{
            if(!empty($_GET['status']) && ($_GET['status'] == 'subscribe' || $_GET['status'] == 'unsubscribe')){
                $temp = $_GET['status'];
                setcookie("pageStatus",$temp,$valid_time);
               $page_status = $temp;
            }
            else{   
                setcookie("pageStatus","subscribe",$valid_time);
                $page_status = 'subscribe';
            }
        }
        
        
        $url = 'index.php?controller=newslatter&status='.$page_status.'&';
       
        $paging_string = $this->app->newslatter->paging($this->app->config['db_prefix']."newslatter", $this->app->settings['admin_page_factor'], $url ,$page_status);
        
        
        $news_data = $this->app->newslatter->paging_data;
        $this->app->view->data = $news_data;
        $this->app->view->paging = $paging_string;
        $this->app->view->page_no = $this->app->newslatter->page_no;
        $this->app->view->page_status = $page_status;
        $this->app->view->site_title = 'Newslater';
        $this->app->view->newslatter_selected = ' class="selected"';
        
        $this->app->view->display('admin_index');
    }
    
   
    
    
    
    
     public function index(){
        echo 'news later index...';
        $this->app->view->site_title = 'newslatter';
        $this->app->view->display();
    }
}
?>
