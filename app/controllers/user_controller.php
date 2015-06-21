<?php

class user_controller extends appcontroller {

    var $additionalController = array('pages', 'news_management', 'product', 'product_item', 'organizer_management');
    var $paging_data;
    var $err;

    public function admin_index() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->users, $this->permision_arr);
        //Permission end
        $valid_time = 60 * 60 * 24 * 30 + time();
        if (isset($_POST['admin_index_submite'])) {
			//Permission start 
            if (!empty($_POST['status']) && $_POST['status'] == 'Delete') {
                $this->app->role_user->check_permission($this->users, array($this->permision_arr[3]));
            } else {
                $this->app->role_user->check_permission($this->users, array($this->permision_arr[2]));
            }
            //Permission end
            if (!empty($_POST['check_list'])) {
                $this->app->user->update_status($_POST);
                $this->app->view->msg = $this->app->lang['SUCCESS_USER_STATUS'];
            }else
                $this->app->view->err = 'No data is checked.';
        }

        if (!isset($_COOKIE['pageStatus'])) {
            if (empty($_GET['status'])) {
                setcookie("pageStatus", "active", $valid_time);
                $page_status = 'active';
            }
        } else {
            if (!empty($_GET['status']) && ($_GET['status'] == 'active' || $_GET['status'] == 'banned' || $_GET['status'] == 'delete')) {
                $temp = $_GET['status'];
                setcookie("pageStatus", $temp, $valid_time);
                $page_status = $temp;
            } else {
                setcookie("pageStatus", "active", $valid_time);
                $page_status = 'active';
            }
        }

        if (!empty($_POST['key'])) {
            $this->app->view->data = $this->app->user->search_users($_POST['key']);
            $this->app->view->page_no = 1;
            $this->app->view->page_status = $page_status;
            $this->app->view->site_title = 'Search Result';
        } else {
            $url = 'index.php?controller=user&status=' . $page_status . '&';
            $paging_string = $this->app->user->paging($this->app->config['db_prefix'] . "users", $this->app->settings['admin_page_factor'], $url, $page_status);
            $this->app->view->data = $this->app->user->paging_data;
            $this->app->view->paging = $paging_string;
            $this->app->view->page_no = $this->app->user->page_no;
            $this->app->view->page_status = $page_status;
            $this->app->view->site_title = 'Admin Users';
            $this->app->view->user_selected = ' class="selected"';
        }
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
        $this->app->role_user->check_permission($this->users, array($this->permision_arr[1]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['name']))
                $err = 'Name field can not be blank.';

            elseif (empty($err) && empty($_POST['username']))
                $err = 'User name can not be blank.';

            elseif (empty($err) && (strlen($_POST['username']) <= 2))
                $err = 'Please enter your user name minimum 3 characters.';

            elseif (empty($err) && !preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", trim($_POST['email'])))
                $err = 'Email can not be valid.';

            elseif (empty($err) && empty($_POST['group_id']))
                $err = 'User role can not be blank.';

            elseif (empty($err) && empty($_POST['password']))
                $err = 'Password can not be blank.';

            elseif (empty($err) && (strlen($_POST['password']) <= 5))
                $err = 'Please enter your password minimum 6 characters.';

            elseif (empty($err) && $_POST['password'] != $_POST['re_password'])
                $err = 'password did not match.';


            if (empty($err)) {    //Form valid
                $this->app->user->insert_data($_POST);
                if (empty($this->app->user->err))
                    $this->app->view->msg = $this->app->lang['SUCCESS_USER_SAVE'];
                else
                    $this->app->view->err = $this->app->user->err;
            } else {
                $this->app->view->err = $err;
            }
        }
        $this->app->view->user_group = $this->app->user->get_user_group();
        $this->app->view->site_title = 'Add New User';
        $this->app->view->user_selected = ' class="selected"';
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
        $this->app->role_user->check_permission($this->users, array($this->permision_arr[2]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['name']))
                $err = 'Name field can not be blank.';

            elseif (empty($err) && !preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", trim($_POST['email'])))
                $err = 'Email can not be valid.';

            elseif (empty($err) && empty($_POST['group_id']))
                $err = 'User role can not be blank.';            

            if (empty($err)) {    //Form valid
                $this->app->user->update_data($_POST);
                if (empty($this->app->user->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_USER_UPDATE'];
                    $row = $this->app->user->get_row($_REQUEST['id']);
                    $this->app->view->row = $row;
                    $this->app->view->user_group = $this->app->user->get_user_group();
                    $this->app->view->site_title = 'Edit - ' . $row['name'];
                    $this->app->view->user_selected = ' class="selected"';
                    $this->app->view->display('admin_edit');
                    exit;
                } else {
                    $this->app->view->user_group = $this->app->user->get_user_group();
                    $row = $this->app->user->get_row($_REQUEST['id']);
                    $this->app->view->row = $row;
                    $this->app->view->err = $this->app->user->err;
                }
            } else {
                $this->app->view->user_group = $this->app->user->get_user_group();
                $row = $this->app->user->get_row($_REQUEST['id']);
                $this->app->view->row = $row;
                $this->app->view->err = $err;
            }
        } else {
            $row = $this->app->user->get_row($_REQUEST['id']);
            if (empty($this->app->user->err)) {
                $this->app->view->row = $row;
            } else {
                $this->app->view->row = $row;
                $this->app->view->err = $this->app->user->err;
            }
        }

        $this->app->view->user_group = $this->app->user->get_user_group();
        $this->app->view->site_title = 'Edit - ' . $row['name'];
        $this->app->view->user_selected = ' class="selected"';
        $this->app->view->display('admin_edit');
    }

    /*
     * admin_permission
     * 
     * edit data for article 
     * 
     * no parameter & no return type
     */

    public function admin_permission() {

        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';

            if (empty($err)) {    //Form valid
                $this->app->user->update_permission($_POST);
                if (empty($this->app->user->err)) {
                    $this->app->view->msg = 'User permission has been updated.';
                    $row = $this->app->user->get_row($_REQUEST['id']);
                    $this->app->view->row = $row;
                    $permission_types = $this->app->user->get_permission_item();
                    $this->app->view->permission_types = $permission_types;
                    $permission = $this->app->user->get_permission($_REQUEST['id']);
                    $this->app->view->permission = $permission;
                    $this->app->view->site_title = 'Edit - ' . $row['name'];
                    $this->app->view->user_selected = ' class="selected"';
                    $this->app->view->display('admin_permission');
                    exit;
                } else {
                    $row = $this->app->user->get_row($_REQUEST['id']);
                    $this->app->view->row = $row;
                    $permission_types = $this->app->user->get_permission_item();
                    $this->app->view->permission_types = $permission_types;
                    $permission = $this->app->user->get_permission($_REQUEST['id']);
                    $this->app->view->permission = $permission;
                    $this->app->view->err = $this->app->user->err;
                }
            } else {
                $row = $this->app->user->get_row($_REQUEST['id']);
                $this->app->view->row = $row;
                $permission_types = $this->app->user->get_permission_item();
                $this->app->view->permission_types = $permission_types;
                $permission = $this->app->user->get_permission($_REQUEST['id']);
                $this->app->view->permission = $permission;
                $this->app->view->err = $err;
            }
        } else {
            $row = $this->app->user->get_row($_REQUEST['id']);
            $permission = $this->app->user->get_permission($_REQUEST['id']);
            if (empty($this->app->user->err)) {
                $this->app->view->row = $row;
                $this->app->view->permission = $permission;
            } else {
                $this->app->view->row = $row;
                $this->app->view->permission = $permission;
                $this->app->view->err = $this->app->user->err;
            }
        }
        $permission_types = $this->app->user->get_permission_item();
        $this->app->view->permission_types = $permission_types;

        $this->app->view->site_title = 'Edit - ' . $row['name'];
        $this->app->view->user_selected = ' class="selected"';
        $this->app->view->display('admin_permission');
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
        $this->app->role_user->check_permission($this->users, array($this->permision_arr[3]));
        //Permission end
        if (empty($_REQUEST['id'])) {
            $this->admin_index();
            exit;
        }

        $this->app->user->delete_trash($_REQUEST['id']);
        if (!empty($this->app->user->err)) {
            $this->app->view->err = $this->app->user->err;
        } else {
            $this->app->view->msg = $this->app->lang['SUCCESS_USER_DELETE'];
        }

        $this->admin_index();
        exit;
    }

    public function index() {

        /*         * *******Common Veriabls******** */
        $this->beforeLoadFrontEnd();
        /*         * *******Common Veriabls******** */

        if (isset($_REQUEST['page'])) {
            $p_ident = $_REQUEST['page'];
        } else {
            $p_ident = 'home';
        }
    }

}

?>
