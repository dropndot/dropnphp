<?php

class menus_controller extends appcontroller {

    public function admin_index() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->menus, $this->permision_arr);
        //Permission end
        $valid_time = 60 * 60 * 24 * 30 + time();
        if (!empty($_POST['status'])) {
            if (!empty($_POST['check_list'])) {
                $this->app->menus->update_status($_POST);
                $this->app->view->msg = $this->app->lang['SUCCESS_MENU_STATUS'];
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

        $url = 'index.php?controller=menus&status=' . $page_status . '&';
        $paging_string = $this->app->menus->paging($this->app->config['db_prefix'] . "menus", $this->app->settings['admin_page_factor'], $url, $page_status);


        $menus = $this->app->menus->paging_data;

        $this->app->view->data = $menus;
        $this->app->view->paging = $paging_string;
        $this->app->view->page_no = $this->app->menus->page_no;
        $this->app->view->page_status = $page_status;
        $this->app->view->site_title = 'Menus';
        $this->app->view->menus_selected = ' class="selected"';

        $this->app->view->display('admin_index');
    }

    public function admin_add() {

		//Permission start 
        $this->app->role_user->check_permission($this->menus, array($this->permision_arr[1]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';

            if (empty($err) && empty($_POST['title']))
                $err = 'Title field can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->menus->insert_data($_POST);
                if (empty($this->app->menus->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_MENU_SAVE'];
                    $this->admin_index();
                    exit;
                }else
                    $this->app->view->err = $this->app->menus->err;
            } else {
                $this->app->view->err = $err;
            }
        }
        $this->app->view->site_title = 'Add New Menu';
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

            if (empty($err)) {    //Form valid
                $this->app->menus->update_data($_POST);
                if (empty($this->app->menus->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_MENU_UPDATE'];
                } else {
                    $this->app->view->err = $this->app->menus->err;
                }
            } else {
                $this->app->view->row = $this->app->menus->get_row($_REQUEST['id']);
                $this->app->view->err = $err;
            }
        } else {
            $row = $this->app->menus->get_row($_REQUEST['id']);
            if (empty($this->app->menus->err)) {
                $this->app->view->row = $row;
            } else {
                $this->app->view->err = $this->app->menus->err;
            }
        }
        $row = $this->app->menus->get_row($_REQUEST['id']);
        $this->app->view->row = $row;
        $this->app->view->site_title = 'Edit Menu';
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

        $this->app->menus->delete_trash($_REQUEST['id']);
        if (!empty($this->app->menus->err)) {
            $this->app->view->err = $this->app->menus->err;
        } else {
            $this->app->view->msg = $this->app->lang['SUCCESS_PAGE_DELETE'];
        }

        $this->admin_index();
        exit;
    }

    public function index() {
        echo 'menus index...';
        $this->app->view->site_title = 'menus';
        $this->app->view->display();
    }

}

?>