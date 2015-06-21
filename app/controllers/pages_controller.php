<?php

class pages_controller extends appcontroller {

    var $additionalController = array('pages', 'banner_management', 'product_item', 'news_management', 'product', 'organizer_management');
    var $page_title = '';

    public function admin_index() {
        //Permission start 
        $this->app->role_user->check_permission($this->pages, $this->permision_arr);
        //Permission end

        $valid_time = 60 * 60 * 24 * 30 + time();
        if (isset($_POST['admin_index_submite'])) {
            //Permission start 
            if (!empty($_POST['status']) && $_POST['status'] == 'Delete') {
                $this->app->role_user->check_permission($this->pages, array($this->permision_arr[3]));
            } else {
                $this->app->role_user->check_permission($this->pages, array($this->permision_arr[2]));
            }
            //Permission end
            if (!empty($_POST['check_list'])) {
                $this->app->pages->update_status($_POST);
                $this->app->view->msg = $this->app->lang['SUCCESS_PAGE_STATUS'];
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

        if (!empty($_POST['key'])) {
            $this->app->view->data = $this->app->pages->search_pages($_POST['key']);
            $this->app->view->page_no = 1;
            $this->app->view->page_status = $page_status;
            $this->app->view->site_title = 'Search Result';
        } else {
            $url = 'index.php?controller=pages&status=' . $page_status . '&';
            $paging_string = $this->app->pages->paging($this->app->config['db_prefix'] . "pages", $this->app->settings['admin_page_factor'], $url, $page_status);
            $this->app->view->data = $this->app->pages->paging_data;
            $this->app->view->paging = $paging_string;
            $this->app->view->page_no = $this->app->pages->page_no;
            $this->app->view->page_status = $page_status;
            $this->app->view->site_title = 'Pages';
            $this->app->view->page_selected = ' class="selected"';
        }
        $this->app->view->display('admin_index');
    }

    public function admin_add() {
        //Permission start 
        $this->app->role_user->check_permission($this->pages, array($this->permision_arr[1]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';

            if (empty($err) && empty($_POST['title']))
                $err = 'Page title field can not be blank.';
            if (empty($err) && empty($_POST['description']))
                $err = 'Page description field can not be blank.';


            if (empty($err)) {    //Form valid
                $this->app->pages->insert_data($_POST);
                if (empty($this->app->pages->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_PAGE_SAVE'];
                    $this->admin_index();
                    exit;
                }else
                    $this->app->view->err = $this->app->pages->err;
            } else {
                $this->app->view->err = $err;
            }
        }


        $this->app->view->site_title = 'Add New Page';
        $this->app->view->page_selected = 'class="selected"';
        $this->app->view->display('admin_add');
    }

    public function admin_edit() {

        //Permission start 
        $this->app->role_user->check_permission($this->pages, array($this->permision_arr[2]));
        //Permission end
        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['title']))
                $err = 'Page title field can not be blank.';
            if (empty($err) && empty($_POST['description']))
                $err = 'Page description field can not be blank.';


            if (empty($err)) {    //Form valid
                $this->app->pages->update_data($_POST);
                if (empty($this->app->pages->err)) {
                    $this->app->view->msg = $this->app->lang['SUCCESS_PAGE_UPDATE'];
                    $this->admin_index();
                    exit;
                } else {
                    $this->app->view->row = $this->app->pages->get_row($_REQUEST['id']);
                    $this->app->view->err = $this->app->pages->err;
                }
            } else {
                $this->app->view->row = $this->app->pages->get_row($_REQUEST['id']);
                $this->app->view->err = $err;
            }
        } else {
            $row = $this->app->pages->get_row($_REQUEST['id']);
            if (empty($this->app->pages->err)) {
                $this->app->view->row = $row;
            } else {
                $this->app->view->err = $this->app->pages->err;
            }
        }



        $this->app->view->site_title = 'Edit - ' . $row['title'];
        $this->app->view->page_selected = ' class="selected"';

        $this->app->view->display('admin_edit');
    }

    public function admin_delete() {

        //Permission start 
        $this->app->role_user->check_permission($this->pages, array($this->permision_arr[3]));
        //Permission end

        if (empty($_REQUEST['id'])) {
            $this->admin_index();
            exit;
        }

        $this->app->pages->delete_trash($_REQUEST['id']);
        if (!empty($this->app->pages->err)) {
            $this->app->view->err = $this->app->pages->err;
        } else {
            $this->app->view->msg = $this->app->lang['SUCCESS_PAGE_DELETE'];
        }

        $this->admin_index();
        exit;
    }

    //Header menu
    public function menu($options) {// $main_id = null, $main_class=null, $sub_id = null, $menu_title=null ,$extra_style = "foldout") {
        $this->app->pages->get_menu($options['identifier']);
        $parent_array = $this->app->pages->parent_menu;
        $sub_array = $this->app->pages->sub_menu;

        if (isset($_GET['page'])) {
            $crnt_page = $_GET['page'];
        } else {
            $crnt_page = 'home';
        }
        if (!empty($parent_array)) {
            $menu = "";
            if ($options['print_title']) {
                $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "menus WHERE identifier='" . $options['identifier'] . "'";
                $result = mysql_query($sql);
                if (!$result) {
                    $message = 'Invalid query: ' . mysql_error() . "\n";
                    $message .= 'Whole query: ' . $sql;
                    $this->err = $message;
                    return false;
                }
                $row = mysql_fetch_assoc($result);
                $menu_title = $row['title'];
                $menu = "<h3>" . $menu_title . "</h3>\n";
            }
            $menu .= "<ul";
            if (!empty($options['content_id']))
                $menu .= " id=\"" . $options['content_id'] . "\"";
            if (!empty($options['content_class']))
                $menu .= " class=\"" . $options['content_class'] . "\"";
            $menu .= ">\n";
            $crnt_parent = '';
            foreach ($sub_array as $sval) {
                if (isset($sval['page'])) {
                    if ($sval['page'] == $crnt_page) {
                        $crnt_parent = $sval['parent'];
                    }
                }
            }

            $parent_end = end($parent_array);
            $last_pid = $parent_end['id'];
            foreach ($parent_array as $pkey => $pval) {
                if (!empty($pval['count'])) {
                    if ($crnt_parent == $pval['id']) {
                        if ($pval['target'] == 'new') {
                            $menu .= "  <li><a target=\"_blank\" id=\" current\" >";
                        } else {
                            $menu .= "  <li><a id=\" current\" >";
                        }
                        if (!empty($options['link_before']))
                            $menu .= $options['link_before'];
                        $menu .= $pval['title'];
                        if (!empty($options['link_after']))
                            $menu .= $options['link_after'];
                        $menu .= "</a>\n";
                        $crnt_parent = false;
                    }else {
                        if ($pval['page'] == $crnt_page) {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <li><a target=\"_blank\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "  <li><a id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a>\n";
                        }else {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <li><a target=\"_blank\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "  <li><a href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a>\n";
                        }
                    }
                    $menu .= "<ul class=\"subnav\">\n";
                    foreach ($sub_array as $sval) {
                        if (isset($sval['page']) && $pval['id'] == $sval['parent']) {
                            if ($sval['page'] == $crnt_page) {
                                if ($pval['target'] == 'new') {
                                    $menu .= "  <li><a target=\"_blank\" id=\"current-page\" href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                                } else {
                                    $menu .= "  <li><a id=\"current-page\" href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                                }
                                if (!empty($options['link_before']))
                                    $menu .= $options['link_before'];
                                $menu .= $sval['title'];
                                if (!empty($options['link_after']))
                                    $menu .= $options['link_after'];
                                $menu .= "</a></li>\n";
                                $this->page_title = $sval['title'];
                            }else {
                                if ($pval['target'] == 'new') {
                                    $menu .= "  <li><a target=\"_blank\" href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                                } else {
                                    $menu .= "  <li><a href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                                }
                                if (!empty($options['link_before']))
                                    $menu .= $options['link_before'];
                                $menu .= $sval['title'];
                                if (!empty($options['link_after']))
                                    $menu .= $options['link_after'];
                                $menu .= "</a></li>\n";
                            }
                        }
                        elseif (isset($sval['url']) && $pval['id'] == $sval['parent']) {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <li><a target=\"_blank\" href=\"" . $sval['url'] . "\">";
                            } else {
                                $menu .= "  <li><a href=\"" . $sval['url'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $sval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }
                    }
                    $menu .="</ul></li>\n";
                }
                else {
                    if ($pval['id'] == $last_pid)
                        $menu .= "<li class=\"last\">";
                    else
                        $menu .="<li>";

                    if (isset($pval['page'])) {
                        if ($pval['page'] == $crnt_page) {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "  <a id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                            $this->page_title = $pval['title'];
                        }else {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "  <a href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }
                    }
                    elseif (isset($pval['url'])) {
                        if ($pval['target'] == 'new') {
                            $menu .= "  <a target=\"_blank\" href=\"" . $pval['url'] . "\">";
                        } else {
                            $menu .= "  <a href=\"" . $pval['url'] . "\">";
                        }
                        if (!empty($options['link_before']))
                            $menu .= $options['link_before'];
                        $menu .= $pval['title'];
                        if (!empty($options['link_after']))
                            $menu .= $options['link_after'];
                        $menu .= "</a></li>\n";
                    }
                }
            }
            $menu .= "</ul>\n";
        }
        return $menu;
    }

    //Header menu
    public function main_menu_bootstrap($options) {// $main_id = null, $main_class=null, $sub_id = null, $menu_title=null ,$extra_style = "foldout") {
        $this->app->pages->get_main_menu($options['identifier']);
        $parent_array = $this->app->pages->parent_menu;
        $sub_array = $this->app->pages->sub_menu;
        //$entertainment_sub_menu = $this->app->pages->entertainment_sub_menu;
		
        if (isset($_GET['page'])) {
            $crnt_page = $_GET['page'];
        } else {
            $crnt_page = 'home';
        }
		$menu = '';
        if (!empty($parent_array)) {
            $menu = "";
            if ($options['print_title']) {
                $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "menus WHERE identifier='" . $options['identifier'] . "'";
                $result = mysql_query($sql);
                if (!$result) {
                    $message = 'Invalid query: ' . mysql_error() . "\n";
                    $message .= 'Whole query: ' . $sql;
                    $this->err = $message;
                    return false;
                }
                $row = mysql_fetch_assoc($result);
                $menu_title = $row['title'];
                $menu = "<h3>" . $menu_title . "</h3>\n";
            }
            $menu .= "<ul";
            if (!empty($options['content_id']))
                $menu .= " id=\"" . $options['content_id'] . "\"";
            if (!empty($options['content_class']))
                $menu .= " class=\"" . $options['content_class'] . "\"";
            $menu .= ">\n";
            $crnt_parent = '';
            foreach ($sub_array as $sval) {
                if (isset($sval['page'])) {
                    if ($sval['page'] == $crnt_page) {
                        $crnt_parent = $sval['parent'];
                    }
                }
            }

            $parent_end = end($parent_array);
            $last_pid = $parent_end['id'];

            foreach ($parent_array as $pkey => $pval) {
                if (!empty($pval['count'])) {
                    if ($crnt_parent == $pval['id']) {
                        if ($pval['target'] == 'new') {
                            $menu .= "<li class=\"dropdown\"><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" target=\"_blank\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                        } else {
                            $menu .= "<li class=\"dropdown\"><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                        }
                        if (!empty($options['link_before']))
                            $menu .= $options['link_before'];
                        $menu .= $pval['title'] . "&nbsp;&nbsp;<i class=\"fa fa-angle-down\"></i>";
                        if (!empty($options['link_after']))
                            $menu .= $options['link_after'];
                        $menu .= "</a>\n";
                        $crnt_parent = false;
                    }else {
                        if ($pval['page'] == $crnt_page) {
                            if ($pval['target'] == 'new') {
                                $menu .= "<li class=\"dropdown\"><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" target=\"_blank\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "<li class=\"dropdown\"><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'] . "&nbsp;&nbsp;<i class=\"fa fa-angle-down\"></i>";;
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a>\n";
                        }else {
                            if ($pval['target'] == 'new') {
                                $menu .= "<li class=\"dropdown\"><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" target=\"_blank\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "<li class=\"dropdown\"><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'] . "&nbsp;&nbsp;<i class=\"fa fa-angle-down\"></i>";
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a>\n";
                        }
                    }
                    $menu .= "<ul class=\"dropdown-menu\">\n";
                    
                    foreach ($sub_array as $sval) {
                        if (isset($sval['page']) && $pval['id'] == $sval['parent']) {
                            if ($sval['page'] == $crnt_page) {
                                if ($sval['target'] == 'new') {
                                    $menu .= "<li><a target=\"_blank\" title=\"" . $sval['title'] . "\" id=\"current-page\" href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                                } else {
                                    $menu .= "<li><a title=\"" . $sval['title'] . "\" id=\"current-page\" href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                                }
                                if (!empty($options['link_before']))
                                    $menu .= $options['link_before'];
                                $menu .= substr($sval['title'], 0, 24);
                                if (!empty($options['link_after']))
                                    $menu .= $options['link_after'];
                                $menu .= "</a></li>\n";
                                $this->page_title = $sval['title'];
                            } else {
                                if ($sval['target'] == 'new') {
                                    $menu .= "<li><a target=\"_blank\" title=\"" . $sval['title'] . "\" href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                                } else {
                                    $menu .= "<li><a title=\"" . $sval['title'] . "\" href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                                }
                                if (!empty($options['link_before']))
                                    $menu .= $options['link_before'];
                                $menu .= substr($sval['title'], 0, 24);
                                if (!empty($options['link_after']))
                                    $menu .= $options['link_after'];
                                $menu .= "</a></li>\n";
                            }
                        } elseif (isset($sval['url']) && $pval['id'] == $sval['parent']) {
                            if ($sval['target'] == 'new') {
                                $menu .= "<li><a target=\"_blank\" title=\"" . $sval['title'] . "\"href=\"" . $sval['url'] . "\">";
                            } else {
                                $menu .= "<li><a title=\"" . $sval['title'] . "\"href=\"" . $sval['url'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= substr($sval['title'], 0, 24);
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }
                    }
                    
                    $menu .="</ul></li>\n";
                } else {
                    if ($pval['id'] == $last_pid)
                        $menu .= "<li class=\"last\">";
                    else
                        $menu .="<li>";

                    if (isset($pval['page'])) {
                        if ($pval['page'] == $crnt_page) {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "  <a id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                            $this->page_title = $pval['title'];
                        }else {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "  <a href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }
                    }elseif (isset($pval['url'])) {
                        if (($pval['identifier'] == 'home') && (empty($_GET['page']))) {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\" id=\"current\" href=\"" . $pval['url'] . "\">";
                            } else {
                                $menu .= "  <a id=\"current\" href=\"" . $pval['url'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }else {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\"  href=\"" . $pval['url'] . "\">";
                            } else {
                                $menu .= "  <a href=\"" . $pval['url'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }
                    }
                }
            }
            $menu .= "</ul>\n";
        }
        return $menu;
    }

	//Header menu
    public function main_menu($options) {// $main_id = null, $main_class=null, $sub_id = null, $menu_title=null ,$extra_style = "foldout") {
        $this->app->pages->get_main_menu($options['identifier']);
        $parent_array = $this->app->pages->parent_menu;
        $sub_array = $this->app->pages->sub_menu;
        //$entertainment_sub_menu = $this->app->pages->entertainment_sub_menu;
		
        if (isset($_GET['page'])) {
            $crnt_page = $_GET['page'];
        } else {
            $crnt_page = 'home';
        }
		$menu = '';
        if (!empty($parent_array)) {
            $menu = "";
            if ($options['print_title']) {
                $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "menus WHERE identifier='" . $options['identifier'] . "'";
                $result = mysql_query($sql);
                if (!$result) {
                    $message = 'Invalid query: ' . mysql_error() . "\n";
                    $message .= 'Whole query: ' . $sql;
                    $this->err = $message;
                    return false;
                }
                $row = mysql_fetch_assoc($result);
                $menu_title = $row['title'];
                $menu = "<h3>" . $menu_title . "</h3>\n";
            }
            $menu .= "<ul";
            if (!empty($options['content_id']))
                $menu .= " id=\"" . $options['content_id'] . "\"";
            if (!empty($options['content_class']))
                $menu .= " class=\"" . $options['content_class'] . "\"";
            $menu .= ">\n";
            $crnt_parent = '';
            foreach ($sub_array as $sval) {
                if (isset($sval['page'])) {
                    if ($sval['page'] == $crnt_page) {
                        $crnt_parent = $sval['parent'];
                    }
                }
            }

            $parent_end = end($parent_array);
            $last_pid = $parent_end['id'];

            foreach ($parent_array as $pkey => $pval) {
                if (!empty($pval['count'])) {
                    if ($crnt_parent == $pval['id']) {
                        if ($pval['target'] == 'new') {
                            $menu .= "<li><a target=\"_blank\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                        } else {
                            $menu .= "<li><a id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                        }
                        if (!empty($options['link_before']))
                            $menu .= $options['link_before'];
                        $menu .= $pval['title'];
                        if (!empty($options['link_after']))
                            $menu .= $options['link_after'];
                        $menu .= "</a>\n";
                        $crnt_parent = false;
                    }else {
                        if ($pval['page'] == $crnt_page) {
                            if ($pval['target'] == 'new') {
                                $menu .= "<li><a target=\"_blank\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "<li><a id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a>\n";
                        }else {
                            if ($pval['target'] == 'new') {
                                $menu .= "<li><a target=\"_blank\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "<li><a href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a>\n";
                        }
                    }
                    $menu .= "<ul class=\"subnav\">\n";
                    
                    foreach ($sub_array as $sval) {
                        if (isset($sval['page']) && $pval['id'] == $sval['parent']) {
                            if ($sval['page'] == $crnt_page) {
                                if ($sval['target'] == 'new') {
                                    $menu .= "<span><a target=\"_blank\" title=\"" . $sval['title'] . "\" id=\"current-page\" href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                                } else {
                                    $menu .= "<span><a title=\"" . $sval['title'] . "\" id=\"current-page\" href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                                }
                                if (!empty($options['link_before']))
                                    $menu .= $options['link_before'];
                                $menu .= substr($sval['title'], 0, 24);
                                if (!empty($options['link_after']))
                                    $menu .= $options['link_after'];
                                $menu .= "</a></span>\n";
                                $this->page_title = $sval['title'];
                            } else {
                                if ($sval['target'] == 'new') {
                                    $menu .= "<span><a target=\"_blank\" title=\"" . $sval['title'] . "\" href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                                } else {
                                    $menu .= "<span><a title=\"" . $sval['title'] . "\" href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                                }
                                if (!empty($options['link_before']))
                                    $menu .= $options['link_before'];
                                $menu .= substr($sval['title'], 0, 24);
                                if (!empty($options['link_after']))
                                    $menu .= $options['link_after'];
                                $menu .= "</a></span>\n";
                            }
                        } elseif (isset($sval['url']) && $pval['id'] == $sval['parent']) {
                            if ($sval['target'] == 'new') {
                                $menu .= "<span><a target=\"_blank\" title=\"" . $sval['title'] . "\"href=\"" . $sval['url'] . "\">";
                            } else {
                                $menu .= "<span><a title=\"" . $sval['title'] . "\"href=\"" . $sval['url'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= substr($sval['title'], 0, 24);
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></span>\n";
                        }
                    }
                    $menu .= "</div>";
                    
                    $menu .="</ul></li>\n";
                } else {
                    if ($pval['id'] == $last_pid)
                        $menu .= "<li class=\"last\">";
                    else
                        $menu .="<li>";

                    if (isset($pval['page'])) {
                        if ($pval['page'] == $crnt_page) {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "  <a id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                            $this->page_title = $pval['title'];
                        }else {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "  <a href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }
                    }
                    elseif (isset($pval['url'])) {
                        if (($pval['identifier'] == 'home') && (empty($_GET['page']))) {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\" id=\"current\" href=\"" . $pval['url'] . "\">";
                            } else {
                                $menu .= "  <a id=\"current\" href=\"" . $pval['url'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }else {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\"  href=\"" . $pval['url'] . "\">";
                            } else {
                                $menu .= "  <a href=\"" . $pval['url'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }
                    }
                }
            }
            $menu .= "</ul>\n";
        }
        return $menu;
    }
	
    public function mobile_main_menu($options) {// $main_id = null, $main_class=null, $sub_id = null, $menu_title=null ,$extra_style = "foldout") {
        $this->app->pages->get_main_menu($options['identifier']);
        $parent_array = $this->app->pages->parent_menu;
        $sub_array = $this->app->pages->sub_menu;

        if (isset($_GET['page'])) {
            $crnt_page = $_GET['page'];
        } else {
            $crnt_page = 'home';
        }
        if (!empty($parent_array)) {
            $menu = "";
            if ($options['print_title']) {
                $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "menus WHERE identifier='" . $options['identifier'] . "'";
                $result = mysql_query($sql);
                if (!$result) {
                    $message = 'Invalid query: ' . mysql_error() . "\n";
                    $message .= 'Whole query: ' . $sql;
                    $this->err = $message;
                    return false;
                }
                $row = mysql_fetch_assoc($result);
                $menu_title = $row['title'];
                $menu = "<h3>" . $menu_title . "</h3>\n";
            }
            $menu .= "<ul";
            if (!empty($options['content_id']))
                $menu .= " id=\"" . $options['content_id'] . "\"";
            if (!empty($options['content_class']))
                $menu .= " class=\"" . $options['content_class'] . "\"";
            $menu .= ">\n";
            $crnt_parent = '';
            foreach ($sub_array as $sval) {
                if (isset($sval['page'])) {
                    if ($sval['page'] == $crnt_page) {
                        $crnt_parent = $sval['parent'];
                    }
                }
            }

            $parent_end = end($parent_array);
            $last_pid = $parent_end['id'];

            foreach ($parent_array as $pkey => $pval) {
                if (!empty($pval['count'])) {
                    if ($crnt_parent == $pval['id']) {
                        if ($pval['target'] == 'new') {
                            $menu .= "<li><a target=\"_blank\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                        } else {
                            $menu .= "<li><a id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                        }
                        if (!empty($options['link_before']))
                            $menu .= $options['link_before'];
                        $menu .= $pval['title'];
                        if (!empty($options['link_after']))
                            $menu .= $options['link_after'];
                        $menu .= "</a>\n";
                        $crnt_parent = false;
                    }else {
                        if ($pval['page'] == $crnt_page) {
                            if ($pval['target'] == 'new') {
                                $menu .= "<li><a target=\"_blank\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "<li><a id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a>\n";
                        }else {
                            if ($pval['target'] == 'new') {
                                $menu .= "<li><a target=\"_blank\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "<li><a href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a>\n";
                        }
                    }
                } else {
                    if ($pval['id'] == $last_pid)
                        $menu .= "<li class=\"last\">";
                    else
                        $menu .="<li>";

                    if (isset($pval['page'])) {
                        if ($pval['page'] == $crnt_page) {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\" id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "  <a id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                            $this->page_title = $pval['title'];
                        }else {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            } else {
                                $menu .= "  <a href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }
                    }
                    elseif (isset($pval['url'])) {
                        if (($pval['identifier'] == 'home') && (empty($_GET['page']))) {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\" id=\"current\" href=\"" . $pval['url'] . "\">";
                            } else {
                                $menu .= "  <a id=\"current\" href=\"" . $pval['url'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }else {
                            if ($pval['target'] == 'new') {
                                $menu .= "  <a target=\"_blank\"  href=\"" . $pval['url'] . "\">";
                            } else {
                                $menu .= "  <a href=\"" . $pval['url'] . "\">";
                            }
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $pval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }
                    }
                }
            }
            $menu .= "</ul>\n";
        }
        return $menu;
    }

    //Other menu
    public function other_menu($options) {// $main_id = null, $main_class=null, $sub_id = null, $menu_title=null ,$extra_style = "foldout") {
        $this->app->pages->get_menu($options['identifier']);
        $parent_array = $this->app->pages->parent_menu;
        $sub_array = $this->app->pages->sub_menu;

        if (isset($_GET['page'])) {
            $crnt_page = $_GET['page'];
        } else {
            $crnt_page = 'home';
        }
        $menu = "";
        if ($options['print_title']) {
            $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "menus WHERE identifier='" . $options['identifier'] . "'";
            $result = mysql_query($sql);
            if (!$result) {
                $message = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $sql;
                $this->err = $message;
                return false;
            }
            $row = mysql_fetch_assoc($result);
            $menu_title = $row['title'];
            $menu = "<h3>" . $menu_title . "</h3>\n";
        }
        $menu .= "<ul";
        if (!empty($options['content_id']))
            $menu .= " id=\"" . $options['content_id'] . "\"";
        if (!empty($options['content_class']))
            $menu .= " class=\"" . $options['content_class'] . "\"";
        $menu .= ">\n";
        $crnt_parent = '';
        foreach ($sub_array as $sval) {
            if (isset($sval['page'])) {
                if ($sval['page'] == $crnt_page) {
                    $crnt_parent = $sval['parent'];
                }
            }
        }
        $parent_end = end($parent_array);
        $last_pid = $parent_end['id'];
        foreach ($parent_array as $pkey => $pval) {
            if (!empty($pval['count'])) {
                if ($crnt_parent == $pval['id']) {
                    $menu .= "  <li><a id=\" current\" >";
                    if (!empty($options['link_before']))
                        $menu .= $options['link_before'];
                    $menu .= $pval['title'];
                    if (!empty($options['link_after']))
                        $menu .= $options['link_after'];
                    $menu .= "</a>\n";
                    $crnt_parent = false;
                }else {
                    $menu .= "  <li><a>";
                    if (!empty($options['link_before']))
                        $menu .= $options['link_before'];
                    $menu .= $pval['title'];
                    if (!empty($options['link_after']))
                        $menu .= $options['link_after'];
                    $menu .= "</a>\n";
                }
                $menu .= "<ul class=\"subnav\">\n";
                foreach ($sub_array as $sval) {


                    if (isset($sval['page']) && $pval['id'] == $sval['parent']) {
                        if ($sval['page'] == $crnt_page) {
                            $menu .= "  <li><a id=\"current-page\" href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";

                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $sval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                            $this->page_title = $sval['title'];
                        }else {
                            $menu .= "  <li><a href=\"index.php?controller=" . $sval['controller'] . "&page=" . $sval['page'] . "\">";
                            if (!empty($options['link_before']))
                                $menu .= $options['link_before'];
                            $menu .= $sval['title'];
                            if (!empty($options['link_after']))
                                $menu .= $options['link_after'];
                            $menu .= "</a></li>\n";
                        }
                    }
                    elseif (isset($sval['url']) && $pval['id'] == $sval['parent']) {
                        $menu .= "  <li><a href=\"" . $sval['url'] . "\">";
                        if (!empty($options['link_before']))
                            $menu .= $options['link_before'];
                        $menu .= $sval['title'];
                        if (!empty($options['link_after']))
                            $menu .= $options['link_after'];
                        $menu .= "</a></li>\n";
                    }
                }
                $menu .="</ul></li>\n";
            }
            else {
                if ($pval['id'] == $last_pid)
                    $menu .= "<li class=\"last\">";
                else
                    $menu .="<li>";

                if (isset($pval['page'])) {
                    if ($pval['page'] == $crnt_page) {
                        $menu .= "  <a id=\"current\" href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                        if (!empty($options['link_before']))
                            $menu .= $options['link_before'];
                        $menu .= $pval['title'];
                        if (!empty($options['link_after']))
                            $menu .= $options['link_after'];
                        $menu .= "</a></li>\n";
                        $this->page_title = $pval['title'];
                    }else {
                        $menu .= "  <a href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                        if (!empty($options['link_before']))
                            $menu .= $options['link_before'];
                        $menu .= $pval['title'];
                        if (!empty($options['link_after']))
                            $menu .= $options['link_after'];
                        $menu .= "</a></li>\n";
                    }
                }
                elseif (isset($pval['url'])) {
                    $menu .= "  <a href=\"" . $pval['url'] . "\">";
                    if (!empty($options['link_before']))
                        $menu .= $options['link_before'];
                    $menu .= $pval['title'];
                    if (!empty($options['link_after']))
                        $menu .= $options['link_after'];
                    $menu .= "</a></li>\n";
                }
            }
        }
        $menu .= "</ul>\n";
        return $menu;
    }

    public function menu_footer($options) {// $main_id = null, $main_class=null, $sub_id = null, $menu_title=null ,$extra_style = "foldout") {
        $this->app->pages->get_menu($options['identifier']);
        $parent_array = $this->app->pages->parent_menu;
        $sub_array = $this->app->pages->sub_menu;

        if (isset($_GET['page'])) {
            $crnt_page = $_GET['page'];
        } else {
            $crnt_page = 'home';
        }
        $menu = "";
        if ($options['print_title']) {
            $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "menus WHERE identifier='" . $options['identifier'] . "'";
            $result = mysql_query($sql);
            if (!$result) {
                $message = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $sql;
                $this->err = $message;
                return false;
            }
            $row = mysql_fetch_assoc($result);
            $menu_title = $row['title'];
            //$menu = "<h3>".$menu_title."</h3>\n";
        }
        /* $menu .= "<ul";
          if(!empty($options['content_id']))
          $menu .= " id=\"".$options['content_id']."\"";
          if(!empty($options['content_class']))
          $menu .= " class=\"".$options['content_class']."\"";
          $menu .= ">\n"; */
        $crnt_parent = '';
        foreach ($sub_array as $sval) {
            if (isset($sval['page'])) {
                if ($sval['page'] == $crnt_page) {
                    $crnt_parent = $sval['parent'];
                }
            }
        }
        $parent_end = end($parent_array);
        $last_pid = $parent_end['id'];
        foreach ($parent_array as $pkey => $pval) {
            if (!empty($pval['count'])) {
                if ($crnt_parent == $pval['id']) {
                    $menu .= "  <a>";
                    if (!empty($options['link_before']))
                        $menu .= $options['link_before'];
                    $menu .= $pval['title'];
                    if (!empty($options['link_after']))
                        $menu .= $options['link_after'];
                    $menu .= "</a>\n";
                    $crnt_parent = false;
                }else {
                    $menu .= "<a>";
                    if (!empty($options['link_before']))
                        $menu .= $options['link_before'];
                    $menu .= $pval['title'];
                    if (!empty($options['link_after']))
                        $menu .= $options['link_after'];
                    $menu .= " </a>\n";
                }
                /* $menu .= "<ul class=\"subnav\">\n";
                  foreach($sub_array as $sval){


                  if(isset($sval['page']) && $pval['id'] == $sval['parent']){
                  if($sval['page'] == $crnt_page){
                  $menu .= "  <li><a class=\"current-page\" href=\"index.php?controller=".$sval['controller']."&page=".$sval['page']."\">";

                  if(!empty($options['link_before']))
                  $menu .= $options['link_before'];
                  $menu .= $sval['title'];
                  if(!empty($options['link_after']))
                  $menu .= $options['link_after'];
                  $menu .= "</a></li>\n";
                  $this->page_title = $sval['title'];
                  }else{
                  $menu .= "  <li><a href=\"index.php?controller=".$sval['controller']."&page=".$sval['page']."\">";
                  if(!empty($options['link_before']))
                  $menu .= $options['link_before'];
                  $menu .= $sval['title'];
                  if(!empty($options['link_after']))
                  $menu .= $options['link_after'];
                  $menu .= "</a></li>\n";
                  }
                  }
                  elseif(isset($sval['url']) && $pval['id'] == $sval['parent']){
                  $menu .= "  <li><a href=\"".$sval['url']."\">";
                  if(!empty($options['link_before']))
                  $menu .= $options['link_before'];
                  $menu .= $sval['title'];
                  if(!empty($options['link_after']))
                  $menu .= $options['link_after'];
                  $menu .= "</a></li>\n";
                  }
                  }
                  $menu .="</ul></li>\n"; */
            }
            else {
                /* if($pval['id'] == $last_pid)
                  $menu .= "<li class=\"last\">";
                  else
                  $menu .="<li>"; */

                if (isset($pval['page'])) {
                    if ($pval['page'] == $crnt_page) {
                        $menu .= "  <a href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                        if (!empty($options['link_before']))
                            $menu .= $options['link_before'];
                        $menu .= $pval['title'];
                        if (!empty($options['link_after']))
                            $menu .= $options['link_after'];
                        $menu .= "</a>";
                        $this->page_title = $pval['title'];
                    }else {
                        $menu .= "  <a href=\"index.php?controller=" . $pval['controller'] . "&page=" . $pval['page'] . "\">";
                        if (!empty($options['link_before']))
                            $menu .= $options['link_before'];
                        $menu .= $pval['title'];
                        if (!empty($options['link_after']))
                            $menu .= $options['link_after'];
                        $menu .= "</a>";
                    }
                }
                elseif (isset($pval['url'])) {
                    $menu .= "  <a href=\"" . $pval['url'] . "\">";
                    if (!empty($options['link_before']))
                        $menu .= $options['link_before'];
                    $menu .= $pval['title'];
                    if (!empty($options['link_after']))
                        $menu .= $options['link_after'];
                    $menu .= "</a>";
                }
            }
        }
        //$menu = substr($menu, 0,-9);
        $menu.='</a>';
        return $menu;
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
        if (!empty($_POST['submit'])) {
            $to = $_POST['email'];
            $sub = 'Confirm your subscription to dubai shopping mall.';
            $body = "Hello! <br />
                    Hurray! You've subscribed to our site.
                    Thanks <br/> ";
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            if (empty($_POST['email']) || !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['email'])) {
                $n_error = 'Please enter your valid email address.';
                $_SESSION['n_error'] = $n_error;
            }
            if (empty($err)) {
                $newslater = $this->app->pages->newslater($_POST);
                if (!empty($newslater)) {
                    mail($to, $sub, $body, $headers);
                    $success = 'Your subscription successfull.';
                    $_SESSION['succ'] = $success;
                    header('location:' . $_POST['redirect_to']);
                    exit;
                } else {
                    $success = 'Your are already subscribe to our site.';
                    $_SESSION['succ'] = $success;
                    header('location:' . $_POST['redirect_to']);
                    exit;
                }
            }
        }

        $this->app->view->page_title = $this->app->pages->get_title($p_ident);
        $this->app->view->page_content = $this->app->pages->get_page_content($p_ident);
        $this->app->view->recent_activity_cat_title = $this->app->pages->recent_activity_cat_title(1);
        $this->app->view->recent_activity = $this->app->pages->recent_activity(1);
        $this->app->view->banner_images = $this->app->router->additional_obj['banner_management']->get_banner_img();
//            $this->app->view->feature_products =  $this->app->router->additional_obj['product_item']->get_feature_products();
//            $new_limit = $this->app->settings['sidebar_news_limit'];
//            $this->app->view->sidebar_news =  $this->app->router->additional_obj['news_management']->get_news($new_limit);
//            $this->app->view->clients_data =  $this->app->router->additional_obj['organizer_management']->get_client();

        $this->app->view->display('index');
    }

}

?>