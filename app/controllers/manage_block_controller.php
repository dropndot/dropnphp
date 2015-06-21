<?php

class manage_block_controller extends appcontroller {

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
                $this->app->manage_block->update_status($_POST);
                $this->app->view->msg = $this->app->lang['SUCCESS_BLOCK_STATUS'];
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
        if (empty($_REQUEST['block_id'])) {


            $url = 'index.php?controller=manage_block&status=' . $page_status . '&';
            $paging_string = $this->app->manage_block->paging($this->app->config['db_prefix'] . "blocks", $this->app->config['db_prefix'] . "block_area", $this->app->settings['admin_page_factor'], $url, $page_status);


            $articles = $this->app->manage_block->paging_data;

            $this->app->view->block_id = $this->app->manage_block->block_id;
            $this->app->view->data = $articles;
            $this->app->view->paging = $paging_string;
            $this->app->view->page_no = $this->app->manage_block->page_no;
            $this->app->view->page_status = $page_status;
            $this->app->view->site_title = 'Blocks';
            $this->app->view->block_selected = ' class="selected"';
            $block_area_id = $this->app->manage_block->get_id_block_area();
            $this->app->view->block_area_id = $block_area_id;
            $this->app->view->display('admin_index');
        } else {
            $this->admin_view_single($_REQUEST['block_id']);
        }
    }

    public function admin_add() {

		//Permission start 
        $this->app->role_user->check_permission($this->blocks, array($this->permision_arr[1]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';

            if (empty($err) && empty($_POST['block_area_id']))
                $err = 'Please select a block area';

            if (empty($err) && empty($_POST['title']))
                $err = 'Block title field can not be blank.';


            if (empty($err) && empty($_POST['description']))
                $err = 'Block description field can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->manage_block->insert_data($_POST);
                if (empty($this->app->manage_block->err)){
                    $this->app->view->msg = $this->app->lang['SUCCESS_BLOCK_SAVE'];
                    $this->admin_index();
                    exit;
                }else
                    $this->app->view->err = $this->app->manage_block->err;
            } else {
                $this->app->view->err = $err;
            }
        }

        $block_area_id = $this->app->manage_block->get_id_block_area();
        $this->app->view->site_title = 'Add New Block';
        $this->app->view->block_selected = 'class="selected"';
        $this->app->view->block_area_id = $block_area_id;
        $this->app->view->display('admin_add');
    }

    public function admin_edit() {

		//Permission start 
        $this->app->role_user->check_permission($this->blocks, array($this->permision_arr[2]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && $_POST['block_area_id'] == 'select')
                $err = 'Please select a block area';
            if (empty($err) && empty($_POST['title']))
                $err = 'Block title field can not be blank.';
            
            if (empty($err)) {    //Form valid
                $this->app->manage_block->update_data($_POST);
                if (empty($this->app->manage_block->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_BLOCK_UPDATE'];
                    $this->app->view->row = $this->app->manage_block->get_row($_REQUEST['id']);
                } else {
                    $this->app->view->err = $this->app->manage_block->err;
                    $this->app->view->row = $this->app->manage_block->get_row($_REQUEST['id']);
                }
            } else {
                $this->app->view->row = $this->app->manage_block->get_row($_REQUEST['id']);
                $this->app->view->err = $err;
            }
        } else {
            $row = $this->app->manage_block->get_row($_REQUEST['id']);
            if (empty($this->app->manage_block->err)) {
                $this->app->view->row = $row;
            } else {
                $this->app->view->err = $this->app->manage_block->err;
            }
        }


        $this->app->view->site_title = 'Edit Block - ';
        $this->app->view->block_selected = ' class="selected"';
        $block_area_id = $this->app->manage_block->get_id_block_area();
        $this->app->view->block_area_id = $block_area_id;
        $this->app->view->block_id = $this->app->manage_block->block_id;
        $this->app->view->display('admin_edit');
    }

    public function admin_delete() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->blocks, array($this->permision_arr[3]));
        //Permission end
        if (empty($_REQUEST['id'])) {
            $this->admin_index();
            exit;
        }

        $this->app->manage_block->block_id = $_REQUEST['block_id'];
        $this->app->manage_block->delete_trash($_REQUEST['id']);
        if (!empty($this->app->manage_block->err)) {
            $this->app->view->err = $this->app->manage_block->err;
        } else {
            $this->app->view->msg = $this->app->lang['SUCCESS_BLOCK_DELETE'];
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

        $url = 'index.php?controller=manage_block&status=' . $page_status . '&block_id=' . $_REQUEST['block_id'] . '&';
        $paging_string = $this->app->manage_block->paging($this->app->config['db_prefix'] . "blocks", $this->app->config['db_prefix'] . "block_area", 10, $url, $page_status, $fk_id, "block_area_id");


        $articles = $this->app->manage_block->paging_data;

        $this->app->view->block_id = $this->app->manage_block->block_id;
        $this->app->view->data = $articles;
        $this->app->view->paging = $paging_string;
        $this->app->view->page_no = $this->app->manage_block->page_no;
        $this->app->view->page_status = $page_status;
        $this->app->view->site_title = 'Blocks';
        $this->app->view->block_selected = ' class="selected"';
        $block_area_id = $this->app->manage_block->get_id_block_area();
        $this->app->view->block_area_id = $block_area_id;
        $this->app->view->display('admin_index');
    }

    public function get_block_content($block_title) {
        $sql = "select * from " . $this->app->config['db_prefix'] . "blocks where title = '$block_title'";
        $result = mysql_query($sql);

        while ($row = mysql_fetch_assoc($result)) {
            $return_data = $row['description'];
        }
        return $return_data;
    }

    public function index() {
        echo 'manage block index...';
        $this->app->view->site_title = 'manage block';
        $this->app->view->display();
    }

}

?>