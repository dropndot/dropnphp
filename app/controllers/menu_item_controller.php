<?php

class menu_item_controller extends appcontroller {

    public function admin_index() {

		//Permission start 
        $this->app->role_user->check_permission($this->menus, $this->permision_arr);
        //Permission end
        $valid_time = 60 * 60 * 24 * 30 + time();
        if (isset($_POST['admin_index_submite'])) {
			//Permission start 
            if (!empty($_POST['status']) && $_POST['status'] == 'Delete') {
                $this->app->role_user->check_permission($this->menus, array($this->permision_arr[3]));
            } else {
                $this->app->role_user->check_permission($this->menus, array($this->permision_arr[2]));
            }
            //Permission end
            if (!empty($_POST['check_list'])) {
                $this->app->menu_item->update_status($_POST);
                $this->app->view->msg = $this->app->lang['SUCCESS_MENU_ITEM_STATUS'];
            }else
                $this->app->view->err = 'No data is checked.';
        }

        if (!isset($_COOKIE['pageStatus'])) {
            if (empty($_GET['status'])) {
                setcookie("pageStatus", "active", $valid_time);
                $page_status = 'active';
            }
        } else {
            if (!empty($_GET['status']) && ($_GET['status'] == 'active' || $_GET['status'] == 'archive' || $_GET['status'] == 'delete')) {
                $temp = $_GET['status'];
                setcookie("pageStatus", $temp, $valid_time);
                $page_status = $temp;
            } else {
                setcookie("pageStatus", "active", $valid_time);
                $page_status = 'active';
            }
        }
        if (empty($_REQUEST['menus_id'])) {

            $url = 'index.php?controller=menu_item&status=' . $page_status . '&';
            $paging_string = $this->app->menu_item->paging($this->app->config['db_prefix'] . "menu_item", $this->app->config['db_prefix'] . "menus", $this->app->settings['admin_page_factor'], $url, $page_status);


            $menu_item_data = $this->app->menu_item->paging_data;

            $this->app->view->menus_id = $this->app->menu_item->menus_id;
            $this->app->view->data = $menu_item_data;
            $this->app->view->paging = $paging_string;
            $this->app->view->page_no = $this->app->menu_item->page_no;
            $this->app->view->page_status = $page_status;
            $this->app->view->parent_titles = $this->app->menu_item->parent_title;
            $this->app->view->err = $this->app->view->err;
            $this->app->view->site_title = 'Menu Item';
            $this->app->view->menus_selected = ' class="selected"';

            $this->app->view->display('admin_index');
        } else {
            $this->admin_view_single($_REQUEST['menus_id']);
        }
    }

    public function admin_add() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->menus, array($this->permision_arr[1]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['title']))
                $err = 'Title field can not be blank.';
            if (empty($err) && ($_POST['menu_type'] == 'url' && empty($_POST['url'])))
                $err = 'URL can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->menu_item->insert_data($_POST, $_REQUEST['menus_id']);
                if (empty($this->app->menu_item->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_MENU_ITEM_SAVE'];
                    $this->admin_index();
                    exit;
                }else
                    $this->app->view->err = $this->app->menu_item->err;
            } else {
                $this->app->view->err = $err;
            }
        }

        $menus_id = $_REQUEST['menus_id'];
        $menus_title = $this->app->menu_item->get_title_menus($menus_id);
        $this->app->view->site_title = 'Add New Menu Item';
        $this->app->view->menus = 'class="selected"';
        $this->app->view->pages_list = $this->app->menu_item->get_page_list();
        $this->app->view->cat_list = $this->app->menu_item->get_cat_list();
        $this->app->view->menu_item_id = $this->app->menu_item->get_id_menu_item($menus_id);
        $this->app->view->menus_title = $menus_title;
        $this->app->view->menus_id = $menus_id;
        $this->app->view->site_title = 'Add New Menu Item - ';
        $this->app->view->menus_selected = ' class="selected"';
        $this->app->view->display('admin_add');
    }

    public function admin_edit() {

		//Permission start 
        $this->app->role_user->check_permission($this->menus, array($this->permision_arr[2]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['title']))
                $err = 'Title field can not be blank.';
            if (empty($err) && ($_POST['menu_type'] == 'url' && empty($_POST['url'])))
                $err = 'URL can not be blank.';
            
            if (empty($err)) {    //Form valid
                $this->app->menu_item->update_data($_POST, $_REQUEST['id']);
                if (empty($this->app->menu_item->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_MENU_ITEM_UPDATE'];
                    $menu_item_id = $_REQUEST['id'];
                    $row = $this->app->menu_item->get_row($menu_item_id);
                    $this->app->view->row = $row;
                } else {
                    $this->app->view->err = $this->app->menu_item->err;
                }
            } else {
                $menu_item_id = $_REQUEST['id'];
                $this->app->view->row = $this->app->menu_item->get_row($menu_item_id);
                $this->app->view->err = $err;
            }
        } else {
            $menu_item_id = $_REQUEST['id'];
            $row = $this->app->menu_item->get_row($menu_item_id);
            if (empty($this->app->menu_item->err)) {
                $this->app->view->row = $row;
            } else {
                $this->app->view->err = $this->app->menu_item->err;
            }
        }

        $menus_id = $_REQUEST['menus_id'];
        $menus_title = $this->app->menu_item->get_title_menus($menus_id);
        $this->app->view->all_menus_id = $this->app->menu_item->get_menus_id();
        $this->app->view->menu_item_ids = $this->app->menu_item->get_id_menu_item($menus_id);
        $this->app->view->pages_list = $this->app->menu_item->get_page_list();
        $this->app->view->cat_list = $this->app->menu_item->get_cat_list();
        $this->app->view->cat_list = $this->app->menu_item->get_cat_list();
        $this->app->view->site_title = 'Edit Menu Item [' . $menus_title . ']';
        $this->app->view->menus_selected = ' class="selected"';

        $this->app->view->menus_id = $_REQUEST['menus_id'];
        $this->app->view->menus_title = $menus_title;
        $this->app->view->menu_item_id = $menu_item_id;
        $this->app->view->display('admin_edit');
    }

    public function admin_delete() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->menus, array($this->permision_arr[3]));
        //Permission end
        if (empty($_REQUEST['id'])) {
            $this->admin_index();
            exit;
        }

        $this->app->menu_item->menus_id = $_REQUEST['menus_id'];
        $this->app->menu_item->delete_trash($_REQUEST['id']);
        if (!empty($this->app->menu_item->err)) {
            $this->app->view->err = $this->app->menu_item->err;
        } else {
            $this->app->view->msg = $this->app->lang['SUCCESS_MENU_ITEM_DELETE'];
        }

        $this->admin_index();
        exit;
    }

    public function admin_view_single($fk_id) {

        $valid_time = 60 * 60 * 24 * 30 + time();
        if (!isset($_COOKIE['pageStatus'])) {
            if (empty($_GET['status'])) {
                setcookie("pageStatus", "active", $valid_time);
                $page_status = 'active';
            }
        } else {
            if (!empty($_GET['status']) && ($_GET['status'] == 'active' || $_GET['status'] == 'archive' || $_GET['status'] == 'delete')) {
                $temp = $_GET['status'];
                setcookie("pageStatus", $temp, $valid_time);
                $page_status = $temp;
            } else {
                setcookie("pageStatus", "active", $valid_time);
                $page_status = 'active';
            }
        }

        $url = 'index.php?controller=menu_item&status=' . $page_status . '&menus_id=' . $_REQUEST['menus_id'] . '&';
        $paging_string = $this->app->menu_item->paging($this->app->config['db_prefix'] . "menu_item", $this->app->config['db_prefix'] . "menus", $this->app->settings['admin_page_factor'], $url, $page_status, $fk_id, "menus_id");


        $menu_item_data = $this->app->menu_item->paging_data;

        $this->app->view->menus_id = $this->app->menu_item->menus_id;
        $this->app->view->data = $menu_item_data;
        $this->app->view->paging = $paging_string;
        $this->app->view->page_no = $this->app->menu_item->page_no;
        $this->app->view->parent_titles = $this->app->menu_item->parent_title;
        $this->app->view->page_status = $page_status;
        $main_menu = $this->app->menu_item->get_title_menus($_REQUEST['menus_id']);
        $this->app->view->site_title = $main_menu;
        $this->app->view->menus_selected = ' class="selected"';

        $this->app->view->display('admin_index');
    }

    public function index() {
        echo 'menu item index...';
        $this->app->view->site_title = 'menu item';
        $this->app->view->display();
    }

}

?>