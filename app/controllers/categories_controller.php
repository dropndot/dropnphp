<?php

class categories_controller extends appcontroller {

    var $additionalController = array('pages', 'banner_management', 'product_item', 'news_management', 'product', 'organizer_management');
    var $page_title = '';

    public function admin_index() {

        //Permission start 
        $this->app->role_user->check_permission($this->categories, $this->permision_arr);
        //Permission end
        $valid_time = 60 * 60 * 24 * 30 + time();
        if (isset($_POST['change_status'])) {
            //Permission start 
            if (!empty($_POST['status']) && $_POST['status'] == 'Delete') {
                $this->app->role_user->check_permission($this->categories, array($this->permision_arr[3]));
            } else {
                $this->app->role_user->check_permission($this->categories, array($this->permision_arr[2]));
            }
            //Permission end
            if (!empty($_POST['check_list'])) {
                $this->app->category->update_status($_POST);
                $this->app->view->msg = $this->app->lang['SUCCESS_CATEGORY_STATUS'];
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

        $url = 'index.php?controller=categories&status=' . $page_status . '&';
        $paging_string = $this->app->category->paging($this->app->config['db_prefix'] . "categories", $this->app->settings['admin_page_factor'], $url, $page_status);

        $categories = $this->app->category->paging_data;
        $this->app->view->data = $categories;
        $this->app->view->paging = $paging_string;
        $this->app->view->page_no = $this->app->category->page_no;
        $this->app->view->page_status = $page_status;
        $this->app->view->site_title = 'Categories';
        $this->app->view->shop_selected = ' class="selected"';

        $this->app->view->display('admin_index');
    }

    public function admin_add() {

        //Permission start 
        $this->app->role_user->check_permission($this->categories, array($this->permision_arr[1]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['title']))
                $err = 'Category title field can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->category->insert_data($_POST);
                if (empty($this->app->category->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_CATEGORY_SAVE'];
                    $this->admin_index();
                    exit;
                }else
                    $this->app->view->err = $this->app->category->err;
            } else {
                $this->app->view->err = $err;
            }
        }

        $this->app->view->site_title = 'Add New Category';
        $this->app->view->category_selected = ' class="selected"';

        $this->app->view->display('admin_add');
    }

    public function admin_edit() {

        //Permission start 
        $this->app->role_user->check_permission($this->categories, array($this->permision_arr[2]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['title']))
                $err = 'Category title field can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->category->update_data($_POST);
                if (empty($this->app->category->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_CATEGORY_UPDATE'];
                    $this->admin_index();
                    exit;
                } else {
                    $row = $this->app->category->get_row($_REQUEST['id']);
                    $this->app->view->row = $row;
                    $this->app->view->err = $this->app->category->err;
                }
            } else {
                $row = $this->app->category->get_row($_REQUEST['id']);
                $this->app->view->row = $row;
                $this->app->view->err = $err;
            }
        } else {
            $row = $this->app->category->get_row($_REQUEST['id']);
            if (empty($this->app->category->err)) {
                $this->app->view->row = $row;
            } else {
                $this->app->view->err = $this->app->category->err;
            }
        }
        $this->app->view->site_title = 'Edit - ' . $row['title'];
        $this->app->view->category_selected = ' class="selected"';

        $this->app->view->display('admin_edit');
    }

    public function admin_delete() {
        
        //Permission start 
        $this->app->role_user->check_permission($this->categories, array($this->permision_arr[3]));
        //Permission end
        
        if (empty($_REQUEST['id'])) {
            $this->admin_index();
            exit;
        }

        $this->app->category->delete_trash($_REQUEST['id']);
        if (!empty($this->app->category->err)) {
            $this->app->view->err = $this->app->category->err;
        } else {
            $this->app->view->msg = $this->app->lang['SUCCESS_CATEGORY_DELETE'];
        }
        $this->admin_index();
        exit;
    }

    public function index() {
        $this->beforeLoadFrontEnd();
        $c_id = $_REQUEST['c_id'];
        $this->app->view->site_title = 'catagory';
        $cat_title = $this->app->category->cat_title($c_id);
        $this->app->view->page_title = $cat_title['title'];
        $post_type = $cat_title['post_type'];
        if ($post_type == 'news') {
            $redirect_to = $this->app->settings['site_url'] . 'index.php?controller=news_management&page=news';
            header("Location: $redirect_to");
            exit;
        } else {
            $redirect_to = $this->app->settings['site_url'] . 'index.php?controller=products&page=products&c_id=' . $c_id;
            header("Location: $redirect_to");
            exit;
        }

        $url = 'index.php?controller=categories&page=category&c_id=' . $c_id . '&';
        $paging_string = $this->app->category->data_list($this->app->config['db_prefix'] . "articles", $this->app->config['db_prefix'] . "categories", $this->app->settings['public_page_factor'], $c_id, $url);

        $data = $this->app->category->paging_data;
        $this->app->view->page_no = $this->app->category->page_no;
        $this->app->view->data = $data;
        $this->app->view->paging = $paging_string;
        $this->app->view->display();
    }

}
