<?php

class block_area_controller extends appcontroller {
    /*
     * admin_index
     * 
     * admin viewer for block area 
     * 
     * no parameter & no return type
     */

    public function admin_index() {

		//Permission start 
        $this->app->role_user->check_permission($this->blocks, $this->permision_arr);
        //Permission end
        $valid_time = 60 * 60 * 24 * 30 + time();
        if (isset($_POST['admin_index_submite'])) {
			//Permission start 
            if (!empty($_POST['status']) && $_POST['status'] == 'Delete') {
                $this->app->role_user->check_permission($this->blocks, array($this->permision_arr[3]));
            } else {
                $this->app->role_user->check_permission($this->blocks, array($this->permision_arr[2]));
            }
            //Permission end
            if (!empty($_POST['check_list'])) {
                $this->app->block_area->update_status($_POST);
                $this->app->view->msg = $this->app->lang['SUCCESS_BLOCK_AREA_STATUS'];
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


        $url = 'index.php?controller=block_area&status=' . $page_status . '&';
        $paging_string = $this->app->block_area->paging($this->app->config['db_prefix'] . "block_area", $this->app->settings['admin_page_factor'], $url, $page_status);



        $this->app->view->data = $this->app->block_area->paging_data;
        $this->app->view->paging = $paging_string;
        $this->app->view->page_no = $this->app->block_area->page_no;
        $this->app->view->page_status = $page_status;
        $this->app->view->site_title = 'Block Area';
        $this->app->view->block_selected = ' class="selected"';

        $this->app->view->display('admin_index');
    }

    /*
     * admin_add
     * 
     * insert data for block area 
     * 
     * no parameter & no return type
     */

    public function admin_add() {

		//Permission start 
        $this->app->role_user->check_permission($this->blocks, array($this->permision_arr[1]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';

            if (empty($err) && empty($_POST['title']))
                $err = 'Block Area title field can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->block_area->insert_data($_POST);
                if (empty($this->app->block_area->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_BLOCK_AREA_SAVE'];
                    $this->admin_index();
                    exit;
                }else
                    $this->app->view->err = $this->app->block_area->err;
            } else {
                $this->app->view->err = $err;
            }
        }


        $this->app->view->site_title = 'Add New Block Area';
        $this->app->view->block_selected = 'class="selected"';

        $this->app->view->display('admin_add');
    }

    /*
     * admin_edit
     * 
     * edit data for block area 
     * 
     * no parameter & no return type
     */

    public function admin_edit() {

		//Permission start 
        $this->app->role_user->check_permission($this->blocks, array($this->permision_arr[2]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['title']))
                $err = 'Block Area title field can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->block_area->update_data($_POST);
                if (empty($this->app->block_area->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_BLOCK_AREA_UPDATE'];
                    $this->app->view->row = $this->app->block_area->get_row($_REQUEST['id']);
                } else {
                    $this->app->view->row = $this->app->block_area->get_row($_REQUEST['id']);
                    $this->app->view->err = $this->app->block_area->err;
                }
            } else {
                $this->app->view->row = $this->app->block_area->get_row($_REQUEST['id']);
                $this->app->view->err = $err;
            }
        } else {
            $row = $this->app->block_area->get_row($_REQUEST['id']);
            if (empty($this->app->block_area->err)) {
                $this->app->view->row = $row;
            } else {
                $this->app->view->err = $this->app->block_area->err;
            }
        }



        $this->app->view->site_title = 'Edit Block Area- ';
        $this->app->view->block_selected = ' class="selected"';

        $this->app->view->display('admin_edit');
    }

    /*
     * admin_delet
     * 
     * delet data for block area 
     * 
     * no parameter & no return type
     */

    public function admin_delete() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->blocks, array($this->permision_arr[3]));
        //Permission end
        if (empty($_REQUEST['id'])) {
            $this->admin_index();
            exit;
        }

        $this->app->block_area->delete_trash($_REQUEST['id']);
        if (!empty($this->app->block_area->err)) {
            $this->app->view->err = $this->app->block_area->err;
        } else {
            $this->app->view->msg = $this->app->lang['SUCCESS_BLOCK_AREA_DELETE'];
        }

        $this->admin_index();
        exit;
    }

    /*
     * index
     * 
     * data viewer for block area 
     * 
     * no parameter & no return type
     */

    public function index() {
        echo 'block area index...';
        $this->app->view->site_title = 'block area';
        $this->app->view->display();
    }

}

?>