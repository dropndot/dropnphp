<?php

class role_user_controller extends appcontroller {

    public function admin_index() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->user_role, $this->permision_arr);
        //Permission end
        $valid_time = 60 * 60 * 24 * 30 + time();
        if (isset($_POST['admin_index_submite'])) {
			//Permission start 
            if (!empty($_POST['status']) && $_POST['status'] == 'Delete') {
                $this->app->role_user->check_permission($this->user_role, array($this->permision_arr[3]));
            } else {
                $this->app->role_user->check_permission($this->user_role, array($this->permision_arr[2]));
            }
            //Permission end
            if (!empty($_POST['check_list'])) {
                $status = strtolower($_POST['status']);
                if ($status == 'inactive' || $status == 'delete') {
                    $group_user_list = $this->app->role_user->check_user_list($_POST);
                    if ($group_user_list > 0) {
                        $this->app->view->err = "Now $group_user_list user are exist on the user role please delete before them !!.";
                    } else {
                        $this->app->role_user->update_status($_POST);
                        $this->app->view->msg = $this->app->lang['SUCCESS_USER_ROLE_STATUS'];
                    }
                } else {
                    $this->app->role_user->update_status($_POST);
                    $this->app->view->msg = $this->app->lang['SUCCESS_USER_ROLE_STATUS'];
                }
            }else
                $this->app->view->err = 'No data is checked.';
        }

        $role_user_data = $this->app->role_user->get_role_user();

        $this->app->view->data = $role_user_data;
        $this->app->view->site_title = 'User Role';
        $this->app->view->role_user_selected = ' class="selected"';

        $this->app->view->display('admin_index');
    }

    public function admin_add() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->user_role, array($this->permision_arr[1]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['title']))
                $err = 'Title field can not be blank.';
			
			if (empty($err) && empty($_POST['group_type']))
                $err = 'User role type can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->role_user->insert_data($_POST);
                if (empty($this->app->role_user->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_USER_ROLE_SAVE'];
                    $this->admin_index();
                    exit;
                }else
                    $this->app->view->err = $this->app->role_user->err;
            } else {
                $this->app->view->err = $err;
            }
        }

        $this->app->view->permission_types = $this->app->role_user->get_permission_item();
        $this->app->view->site_title = 'Add New User Role';
        $this->app->view->role_user_selected = ' class="selected"';
        $this->app->view->display('admin_add');
    }

    public function admin_edit() {

		//Permission start 
        $this->app->role_user->check_permission($this->user_role, array($this->permision_arr[2]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['name']))
                $err = 'Title field can not be blank.';
			
			if (empty($err) && empty($_POST['group_type']))
                $err = 'User role type can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->role_user->update_data($_POST);
                if (empty($this->app->role_user->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_USER_ROLE_UPDATE'];
                    $row = $this->app->role_user->get_row($_REQUEST['id']);
                    $this->app->view->row = $row;
                } else {
                    $this->app->view->err = $this->app->role_user->err;
                }
            } else {
                $row = $this->app->role_user->get_row($_REQUEST['id']);
                $this->app->view->row = $this->app->role_user->get_row($_REQUEST['id']);
                $this->app->view->err = $err;
            }
        } else {
            $row = $this->app->role_user->get_row($_REQUEST['id']);
            if (empty($this->app->role_user->err)) {
                $this->app->view->row = $row;
            } else {
                $this->app->view->err = $this->app->role_user->err;
            }
        }

        $this->app->view->permission_types = $this->app->role_user->get_edit_permission_item($_REQUEST['id']);
        $this->app->view->site_title = 'Edit User Role [' . $row['name'] . ']';
        $this->app->view->role_user_selected = ' class="selected"';
        $this->app->view->display('admin_edit');
    }

    public function admin_delete() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->user_role, array($this->permision_arr[3]));
        //Permission end
        if (empty($_REQUEST['id'])) {
            $this->admin_index();
            exit;
        }
		$group_user_list = $this->app->role_user->check_user_list_delete($_REQUEST['id']);
        if ($group_user_list > 0) {
			$this->app->view->err = "Now $group_user_list user are exist on the user role please delete before them !!.";
        } else {
            $this->app->role_user->delete_trash($_REQUEST['id']);
			$this->app->view->msg = $this->app->lang['SUCCESS_USER_ROLE_DELETE'];
        }

        $this->admin_index();
        exit;
    }

    public function index() {
        echo 'menu item index...';
        $this->app->view->site_title = 'menu item';
        $this->app->view->display();
    }

}

?>