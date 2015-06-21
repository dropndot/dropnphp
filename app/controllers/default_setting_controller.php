<?php

class default_setting_controller extends appcontroller {

    public function admin_index() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->settings, $this->permision_arr);
        //Permission end
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


        $url = 'index.php?controller=default_setting&';
        empty($_GET['sort']) ? $sort = null : $sort = $_GET['sort'];
        $paging_string = $this->app->default_setting->paging($this->app->config['db_prefix'] . "settings", $this->app->settings['admin_page_factor'], $url, $page_status, $sort);


        $settings = $this->app->default_setting->paging_data;

        $this->app->view->data = $settings;
        $this->app->view->paging = $paging_string;
        $this->app->view->page_no = $this->app->default_setting->page_no;
        $this->app->view->page_status = $page_status;
        $this->app->view->site_title = 'Settings';
        //$this->app->view->site_title = 'Settings';

        $this->app->view->default_setting_selected = ' class="selected"';

        $this->app->view->display('admin_index');
    }

    public function admin_add() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->settings, array($this->permision_arr[1]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (!empty($_POST['type'])) {
                $type = $_POST['type'];
            } else {
                $type = 'text';
            }
            if (empty($err) && empty($_POST['set_key']))
                $err = 'Settings Key field can not be blank.';
            if (empty($err) && empty($_POST['set_txt_value']) && $type == 'text')
                $err = 'Value field can not be blank.';
            if (empty($err) && empty($_POST['set_txtarea_value']) && $type == 'textarea')
                $err = 'Value field can not be blank.';
            if (empty($err) && empty($_FILES['image']['name']) && $type == 'image')
                $err = 'The image field can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->default_setting->insert_data($_POST);
                if (empty($this->app->default_setting->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_SETTINGS_SAVE'];
                    $this->admin_index();
                    exit;
                }else
                    $this->app->view->err = $this->app->default_setting->err;
            } else {
                $this->app->view->err = $err;
            }
        }


        $this->app->view->site_title = 'Add New Item';
        $this->app->view->default_setting_selected = ' class="selected"';

        $this->app->view->display('admin_add');
    }

    public function admin_edit() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->settings, array($this->permision_arr[2]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (!empty($_POST['type'])) {
                $type = $_POST['type'];
            }
            if (empty($err) && empty($_POST['set_txt_value']) && $type == 'text')
                $err = 'Value field can not be blank.';
            if (empty($err) && empty($_POST['set_txtarea_value']) && $type == 'textarea')
                $err = 'Value field can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->default_setting->update_data($_POST);
                if (empty($this->app->default_setting->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_SETTINGS_UPDATE'];
                    $this->admin_index();
                    exit;
                } else {
                    $this->app->view->err = $this->app->default_setting->err;
                }
            } else {
                $this->app->view->row = $this->app->default_setting->get_row($_REQUEST['id']);
                $this->app->view->err = $err;
            }
        } else {
            $row = $this->app->default_setting->get_row($_REQUEST['id']);
            if (empty($this->app->default_setting->err)) {
                $this->app->view->row = $row;
            } else {
                $this->app->view->err = $this->app->default_setting->err;
            }
        }

        $this->app->view->site_title = 'Edit - ';
        $this->app->view->default_setting_selected = ' class="selected"';

        $this->app->view->display('admin_edit');
    }

    public function index() {
        echo 'default settings index...';
        $this->app->view->site_title = 'settings';

        $this->app->view->display();
    }

}
