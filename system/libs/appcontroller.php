<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

abstract class appcontroller {

    protected $app;

    public function __construct($app) {
        $this->app = $app;


        foreach ($this->app->lang as $key => $value) {
            $this->app->view->$key = $value;
        }


        foreach ($this->app->settings as $key => $value) {
            $this->app->view->$key = $value;
        }

        /* Commopn variable for admin panel */
        $this->app->view->site_url = $this->app->settings['site_url'];
        $admin_login_data = $this->app->pages->admin_login_data($this->app->session->get_var('user_id'));
        $this->app->view->admin_login_data = $admin_login_data;        
        //Permission start
        $this->permision_arr = array('read', 'add', 'edit', 'delete', 'backup');
        $permission_items = $this->app->role_user->get_permission_item();
		$permision_data_set = array();
        foreach ($permission_items as $key => $value) {
            $p_type = $value['item_key'];
            $permition_one = $value['item_key'] . '_allow';
            $permision_data = $this->app->role_user->get_permission($this->app->session->get_var('group_id'), $value['p_type_id']);
            $this->app->view->$p_type = $permision_data;
            $this->$p_type = $permision_data;
            $permision_data_set[$p_type] = $permision_data;
            $this->app->view->$permition_one = $this->app->role_user->check_permission_one($permision_data, $this->permision_arr);
            $this->$permition_one = $this->app->role_user->check_permission_one($permision_data, $this->permision_arr);
            if (!empty($permision_data)) {
                foreach ($permision_data as $key => $p) {
                    $permision_list = $value['item_key'] . '_' . $p; 
                    $this->app->view->$permision_list = $this->app->role_user->check_permission_one(array($p), $this->permision_arr);
                    $this->$permision_list = $this->app->role_user->check_permission_one(array($p), $this->permision_arr);
                }
            }
        }
        //Permission end
		//Admin menu 
		$admin_nav = $this->app->pages->admin_nav($permision_data_set, $this->permision_arr);
        $this->app->view->admin_nav = $admin_nav;
        /* Commopn variable for admin panel */
    }

    public function beforeLoadFrontEnd() {

        $this->app->view->site_url = $this->app->settings['site_url'];
        $this->app->view->logo = $this->app->settings['site_logo'];
        $this->app->view->site_title = $this->app->settings['site_title'];
        $this->app->view->footer_txt = $this->app->settings['footer_txt'];
        $this->app->view->header_main_nav = $this->app->router->additional_obj['pages']->main_menu_bootstrap(array('identifier' => 'header-menu', 'content_id' => '', 'content_class' => 'nav navbar-nav', 'print_title' => false));
        $this->app->view->footer_menu = $this->app->router->additional_obj['pages']->menu(array('identifier' => 'footer-menu', 'content_id' => '', 'content_class' => '', 'print_title' => false));
		
		//Layout
		if (!empty($_REQUEST['page'])) {
            $page_identifier = $_REQUEST['page'];
        } else {
            $page_identifier = 'home';
        }
        $page_id = $this->app->pages->get_page_id($page_identifier);
		$this->app->view->layout = $page_id['layout'];
    }

    public function set_err($msg) {
        $this->app->view->err = $msg;
    }

    public function redirect($controller, $action, $params=array()) {
        $this->app->router->redirect($controller, $action, $params);
    }

    abstract function index();
}