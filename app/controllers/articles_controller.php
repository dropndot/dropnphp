<?php 

class articles_controller extends appcontroller {
    var $additionalController = array('pages');
    
    /*
    * admin_index
    * 
    * admin viewer for article controller
    * 
    * no parameter & no return type
    */
    public function admin_index() {
        
		//Permission start 
        $this->app->role_user->check_permission($this->articles, $this->permision_arr);
        //Permission end
        $valid_time = 60*60*24*30+time();
        if(isset($_POST['change_status'])){
			//Permission start 
            if (!empty($_POST['status']) && $_POST['status'] == 'Delete') {
                $this->app->role_user->check_permission($this->articles, array($this->permision_arr[3]));
            } else {
                $this->app->role_user->check_permission($this->articles, array($this->permision_arr[2]));
            }
            //Permission end
            if(!empty($_POST['check_list'])){
                $this->app->articles->update_status($_POST);  
                $this->app->view->msg = $this->app->lang['SUCCESS_ARTICLE_STATUS'];
            }else   
                $this->app->view->err='No data is checked.';
        }
            
		if (isset($_GET['st'])) {
			//Permission start 
			$this->app->role_user->check_permission($this->articles, array($this->permision_arr[2]));
			//Permission end
            $this->app->articles->featute_article_status($_GET['st'], $_GET['f_id']);
            if ($this->app->articles->err) {
                $this->app->view->err = $this->app->articles->err;
            } else {
                $this->app->view->msg = 'Featured status updated successfully.';
            }
        }
		
        if(!isset($_COOKIE['pageStatus'])){
            if(empty($_GET['status'])){
                setcookie("pageStatus","active",$valid_time);
                $page_status = 'active';
            }   
        }
        else{
            if(!empty($_GET['status']) && ($_GET['status'] == 'active' || $_GET['status'] == 'archive' || $_GET['status'] == 'delete')){
                $temp = $_GET['status'];
                setcookie("pageStatus",$temp,$valid_time);
               $page_status = $temp;
            }
            else{   
                setcookie("pageStatus","active",$valid_time);
                $page_status = 'active';
            }
        }        
        
		if (!empty($_REQUEST['c_id'])) { 
            $c_id = $_REQUEST['c_id'];
            $url = 'index.php?controller=articles&c_id=' . $c_id . '&status=' . $page_status . '&';
        } else {
			$c_id = '';
            $url = 'index.php?controller=articles&status=' . $page_status . '&';
        }
        $paging_string = $this->app->articles->paging($this->app->config['db_prefix']."articles", $this->app->config['db_prefix']."categories", $this->app->settings['admin_page_factor'], $url, $c_id, $page_status);
        $articles = $this->app->articles->paging_data;      
        
        $this->app->view->data = $articles;
        $this->app->view->paging = $paging_string;
        $this->app->view->page_no = $this->app->articles->page_no;
        $this->app->view->page_status = $page_status;        
        
		$category_id = $this->app->articles->get_id_categories();
        $this->app->view->category_id = $category_id;
        $this->app->view->site_title = 'Articles';
        $this->app->view->article_selected = ' class="selected"';
        
        $this->app->view->display('admin_index');
    }
    
    /*
    * admin_add
    * 
    * insert data for article 
    * 
    * no parameter & no return type
    */   
    public function admin_add() {
        
        //Permission start 
			$this->app->role_user->check_permission($this->articles, array($this->permision_arr[1]));
		//Permission end
        if(!empty($_POST['submit'])){   //Form submitted
            $err='';
            if(empty($err) && empty($_POST['category_id']))
                $err='Please select category.';
                
            if(empty($err) && empty($_POST['title']))
                $err='Articles title field can not be blank.';  
                
                
            if(empty($err) && empty($_POST['description']))
                $err='Articles description field can not be blank.';
                
            if(empty($err)){    //Form valid
                $this->app->articles->insert_data( $_POST );
                if(empty($this->app->articles->err)){
                    $this->app->view->msg =  $this->app->lang['SUCCESS_ARTICLE_SAVE'];
					$this->admin_index();
					exit;
                }else
                    $this->app->view->err = $this->app->articles->err;
                        
            } else {
                $this->app->view->err = $err;
            }    
        }
        
        $category_id = $this->app->articles->get_id_categories();
        $this->app->view->site_title = 'Add New Articles';
        $this->app->view->article_selected = ' class="selected"';
        
        $this->app->view->category_id = $category_id;
        $this->app->view->display('admin_add');
    }
    
    /*
    * admin_edit
    * 
    * edit data for article 
    * 
    * no parameter & no return type
    */    
    public function admin_edit() {
        
        //Permission start 
			$this->app->role_user->check_permission($this->articles, array($this->permision_arr[2]));
		//Permission end
        if(!empty($_POST['submit'])){   //Form submitted
            $err='';
            if(empty($err) && empty($_POST['category_id']))
                $err='Please select category.';
            if(empty($err) && empty($_POST['title']))
                $err='Article title field can not be blank.';  
            if(empty($err) && empty($_POST['description']))
                $err='Article description field can not be blank.';
                
            if(empty($err)){    //Form valid
                $this->app->articles->update_data( $_POST );
                if(empty($this->app->articles->err)){
                    $this->app->view->msg =  $this->app->lang['SUCCESS_ARTICLE_UPDATE'];
                    $this->admin_index();
                    exit;
                } else {
                    $row = $this->app->articles->get_row($_REQUEST['id']);
                    $this->app->view->row =  $row;
                    $this->app->view->err = $this->app->articles->err;
                }
                    
                        
            } else {
                $row = $this->app->articles->get_row($_REQUEST['id']);
                $this->app->view->row =  $row;
                $this->app->view->err = $err;
            }
        } else {
            $row = $this->app->articles->get_row($_REQUEST['id']);
            if(empty($this->app->articles->err)){
                $this->app->view->row =  $row;
            } else {
                $this->app->view->row =  $row;
                $this->app->view->err = $this->app->articles->err;
            }
        }
        
        
        
        $category_id = $this->app->articles->get_id_categories();
        $this->app->view->site_title = 'Edit - ';
        $this->app->view->article_selected = ' class="selected"';
        $this->app->view->category_id = $category_id;
        
        $this->app->view->display('admin_edit');
    }
    
    /*
    * admin_delet
    * 
    * delet data for article 
    * 
    * no parameter & no return type
    */   
    public function admin_delete() {
		
		//Permission start 
			$this->app->role_user->check_permission($this->articles, array($this->permision_arr[3]));
		//Permission end
        if(empty($_REQUEST['id'])){
            $this->admin_index();
            exit;
        }
        
        $this->app->articles->delete_trash($_REQUEST['id']);
        if(!empty($this->app->articles->err)){
            $this->app->view->err = $this->app->articles->err;
        } else {
            $this->app->view->msg = $this->app->lang['SUCCESS_ARTICLE_DELETE'];
        }
    
        $this->admin_index();
        exit;
            
    }
    
    
    /*
    * index
    * 
    * article data viewer
    * 
    * no parameter & no return type
    */   
    public function index(){
        
         $this->beforeLoadFrontEnd();
         
         $url = 'index.php?controller=articles&status=active&';
        $paging_string = $this->app->articles->paging($this->app->config['db_prefix']."articles", $this->app->config['db_prefix']."categories", 10, $url ,"active");
        
        
        $articles = $this->app->articles->paging_data;
        
        $this->app->view->data = $articles;
        $this->app->view->paging = $paging_string;
        $this->app->view->page_no = $this->app->articles->page_no;   
        $this->app->view->site_title = 'Articles';
        $this->app->view->content_selected = ' class="selected"';
        
        $img_path = array();
        $thmb_str = array();
        $index = 0;
        
        foreach($articles as $key => $value){        
             if(!empty($articles[$index]['photo'])){   
                $folder_address = BASE .'app'.DS.'resources'.DS.'images'.DS.'articles'.DS ;
                $full_path = $folder_address . $articles[$index]['photo'];
                
                $img_path[$index] = "http://".$full_path;
                $thmb_str[$index] = $this->app->articles->imageResize($full_path, 100);
            }
            else{   
                $img_path[$index] = null;
                $thmb_str[$index] = null;
            }
            $index++;
        }
        
        $this->app->view->img_path = $img_path;
        $this->app->view->thmb_str = $thmb_str;
       
          
         $this->app->view->display();
    }
}


?>