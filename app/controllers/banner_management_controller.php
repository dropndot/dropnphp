<?php

class banner_management_controller extends appcontroller {

    public function admin_index() {

		//Permission start 
        $this->app->role_user->check_permission($this->slider, $this->permision_arr);
        //Permission end
        $valid_time = 60 * 60 * 24 * 30 + time();
        if (isset($_POST['admin_index_submite'])) {
			//Permission start 
            if (!empty($_POST['status']) && $_POST['status'] == 'Delete') {
                $this->app->role_user->check_permission($this->slider, array($this->permision_arr[3]));
            } else {
                $this->app->role_user->check_permission($this->slider, array($this->permision_arr[2]));
            }
            //Permission end
            if (!empty($_POST['check_list'])) {
                $this->app->banner_management->update_status($_POST);
                $this->app->view->msg = $this->app->lang['SUCCESS_BANNER_STATUS'];
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


        $url = 'index.php?controller=banner_management&status=' . $page_status . '&';
        $paging_string = $this->app->banner_management->paging($this->app->config['db_prefix'] . "banner_management", $this->app->settings['admin_page_factor'], $url, $page_status);


        $banner_data = $this->app->banner_management->paging_data;
        $this->app->view->data = $banner_data;
        $this->app->view->paging = $paging_string;
        $this->app->view->page_no = $this->app->banner_management->page_no;
        $this->app->view->page_status = $page_status;
        $this->app->view->site_title = 'Slider';
        $this->app->view->banner_selected = ' class="selected"';

        $this->app->view->display('admin_index');
    }

    public function admin_add() {

		//Permission start 
        $this->app->role_user->check_permission($this->slider, array($this->permision_arr[1]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['title']))
                $err = 'Title field can not be blank.';

            if (empty($_FILES['banner_img']['name']) && empty($err))
                $err = 'Photo field can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->banner_management->insert_data($_POST);
                if (empty($this->app->banner_management->err))
                    $this->app->view->msg = $this->app->lang['SUCCESS_BANNER_SAVE'];
                else
                    $this->app->view->err = $this->app->banner_management->err;
            } else {
                $this->app->view->err = $err;
            }
            //print_r($this->app->view);
        }


        $this->app->view->site_title = 'Add New Slide';
        $this->app->view->banner_selected = ' class="selected"';

        $this->app->view->display('admin_add');
    }

    public function admin_edit() {

		//Permission start 
        $this->app->role_user->check_permission($this->slider, array($this->permision_arr[2]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['title']))
                $err = 'Title field can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->banner_management->update_data($_POST);
                if (empty($this->app->banner_management->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_BANNER_UPDATE'];
                    $this->admin_index();
                    exit;
                } else {
                    $this->app->view->err = $this->app->banner_management->err;
                    $this->app->view->row = $_POST;
                }
            } else {
                $this->app->view->row = $_POST;
                $this->app->view->err = $err;
            }
        } else {
            $row = $this->app->banner_management->get_row($_REQUEST['id']);
            if (empty($this->app->banner_management->err)) {
                $this->app->view->row = $row;
            } else {
                $this->app->view->err = $this->app->banner_management->err;
            }
        }




        $this->app->view->site_title = 'Edit - ';
        $this->app->view->banner_selected = ' class="selected"';

        $this->app->view->display('admin_edit');
    }

    public function admin_delete() {
		
		//Permission start 
        $this->app->role_user->check_permission($this->slider, array($this->permision_arr[3]));
        //Permission end
        if (empty($_REQUEST['id'])) {
            $this->admin_index();
            exit;
        }

        $this->app->banner_management->delete_trash($_REQUEST['id']);
        if (!empty($this->app->banner_management->err)) {
            $this->app->view->err = $this->app->banner_management->err;
        } else {
            $this->app->view->msg = $this->app->lang['SUCCESS_BANNER_DELETE'];
        }

        $this->admin_index();
        exit;
    }

    public function get_banner_img() {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "banner_management where status='active' order by ordering asc LIMIT 0, 7";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $index = 0;
        $banner_images = array();
        while ($row = mysql_fetch_assoc($result)) {
            $banner_images[$index]['title'] = $row['title'];
            $banner_images[$index]['photo'] = $row['photo'];
            $banner_images[$index]['caption'] = $row['caption'];
            $index++;
        }
        return $banner_images;
    }

    public function index() {
        echo 'default category index...';
        $this->app->view->site_title = 'Banner Management';
        $this->app->view->display();
    }

}

?>