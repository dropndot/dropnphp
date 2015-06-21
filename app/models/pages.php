<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class pages {

    private $app;
    var $err;
    var $paging_data;
    var $page_no;
    var $page_status;
    var $parent_menu = array();
    var $sub_menu = array();

    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * insert_data
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function insert_data($data) {

        $created = date('Y-m-d H:i:s');
        $modified = date('Y-m-d H:i:s');

		if(!empty($_POST['controller'])){
			$controller = $_POST['controller'];
		}else{
			$controller = 'sub_page';
		}
        $identifier = $data['title'];
        $identifier = strtolower($identifier);
        $identifier = str_replace('&', 'dd', $identifier);
        $identifier = str_replace(' ', '-', $identifier);

        $description = addslashes($data['description']);
        $sql = "SELECT identifier from " . $this->app->config['db_prefix'] . "pages where identifier='" . $identifier . "'";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);

        if (empty($row)) {            
            $upload_address = BASE . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'pages' . DS;
            if (!empty($_FILES['feature_img']['name'])) {
                $file_name = time() .'_'. basename($_FILES['feature_img']['name']);
                $upload_file = $upload_address . $file_name;
                move_uploaded_file($_FILES['feature_img']['tmp_name'], $upload_file);
            }else{
               $file_name = ''; 
            }

            if (mysql_query("INSERT INTO " . $this->app->config['db_prefix'] . "pages (title, identifier, description, photo, controller, layout, meta_key, meta_desc, status, created, modified) VALUES ('" . addslashes($data['title']) . "', '" . $identifier . "', '" . $description . "', '" . $file_name . "', '" . $controller . "', '" . $data['layout'] . "', '" . addslashes($data['meta_key']) . "', '" . addslashes($data['meta_desc']) . "', '" . $data['status'] . "', '" . $created . "', '" . $modified . "')")) {
                return true;
            } else {
                $this->err = mysql_error();
                return false;
            }
        } else {
            $this->err = 'This page title already exist.';
        }
    }

    /**
     * update_data
     * 
     * takes data from pages update form and update data in pages table
     * 
     * parameter $data an arrey submitted from pages update form
     * 
     * return true for a successful update
     * 
     * return false in error  
     * */
    public function update_data($data) {
        $modified = date('Y-m-d H:i:s');
        $identifier = $data['title'];
        $identifier = strtolower($identifier);
        $identifier = str_replace('&', 'dd', $identifier);
        $identifier = str_replace(' ', '-', $identifier);

        $description = addslashes($data['description']);

		if(!empty($_POST['controller'])){
			$controller = $_POST['controller'];
		}else{
			$controller = 'sub_page';
		}
		
        if (!empty($_FILES['feature_img']['name'])) {
            $upload_address = BASE . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'pages' . DS;
            $file_name = time() . basename($_FILES['feature_img']['name']);
            $upload_file = $upload_address . $file_name;
            move_uploaded_file($_FILES['feature_img']['tmp_name'], $upload_file);
            $old_img = $upload_address . $_POST['old_feature_img'];
            @unlink($old_img);
        } else {
            $file_name = $_POST['old_feature_img'];
        }
        $sql = "UPDATE " . $this->app->config['db_prefix'] . "pages set  
        title='" . addslashes($data['title']) . "',        
        identifier='" . $identifier . "',        
        description='" . $description . "',
        layout='" . $data['layout'] . "',
        photo = '" . $file_name . "',
        controller = '" . $controller . "',
        meta_key = '" . addslashes($data['meta_key']) . "',
        meta_desc = '" . addslashes($data['meta_desc']) . "',
        status='" . $data['status'] . "',
        modified='" . $modified . "'
        WHERE id='" . $data['id'] . "'";

        if (mysql_query($sql)) {
            return true;
        } else {
            $this->err = mysql_error();
            return false;
        }
    }

    /**
     * update_status
     * 
     * update status in pages table
     * 
     * parameter $data an arrey of pages id 
     * 
     * return true for a successful update
     * 
     * return false in error  
     * */
    public function update_status($data) {
        $cunt = count($data['check_list']);
        $id = array();
        $clause = 'WHERE ';
        foreach ($data['check_list'] as $key => $value) {
            //$clause .="id = '".$value."'";
            $id[$key] = $value;
        }
        $clause .="id = '" . $id[0] . "'";
        for ($i = 1; $i < $cunt; $i++) {
            $clause .=" OR id = '" . $id[$i] . "'";
        }

        $status = strtolower($data['status']);

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "pages SET
        status = '" . $status . "' " . $clause;

        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        return true;
    }

    /**
     * get_row
     *
     * parameter $id takes id of a pages and return all data for the id from pages table to admin_edit page
     * 
     * return an arrey of data
     * 
     * return false in error  
     * */
    public function get_row($id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "pages where id=$id";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }

        $row = mysql_fetch_assoc($result);
        return $row;
    }

    /**
     * delete_trash
     * 
     * parameter $id takes id of a pages and delet all data for that id to trash
     * 
     * return true for a successful delet
     * 
     * return false in error  
     * */
    public function delete_trash($id) {
        $sql = "UPDATE " . $this->app->config['db_prefix'] . "pages SET
        status = 'delete' WHERE id = $id";
        //echo $sql;
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }

        return true;
    }

    /**
     * delete_row
     * 
     * parameter $id takes id of a pages and permanently delet all data for that id
     * 
     * return true for a successful delet
     * 
     * return false in error  
     * */
    public function delete_row($id) {
        $sql = "DELETE from " . $this->app->config['db_prefix'] . "pages where id=$id";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }

        return true;
    }

    /**
     * paging
     * 
     * return all data of a given table & pagination string
     * 
     * parameter $tbl_name takes tabel name as a string, $limit takes pagination limit as an integer, $path takes pagination 
     * path as a string, $status takes status of the data to view as a string
     * 
     * return a string of pagination
     * */
    function paging($tbl_name, $limit, $path, $status) {

        $clause = null;
        $page_status = $status;
        if ($status != null && $status == 'active') {
            $clause = "WHERE status = 'active' OR status = 'inactive'";
        } else {          //if($status == 'active' || $status == 'delete')
            $clause = "WHERE status = '$status'";
        }
        $query = "SELECT COUNT(*) as num FROM $tbl_name $clause";
        //echo $query.'<br />';
        $row = mysql_fetch_array(mysql_query($query));
        $total_pages = $row['num'];
        $adjacents = "2";

        $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
        $page = ($page == 0 ? 1 : $page);

        if ($page)
            $start = ($page - 1) * $limit;
        else
            $start = 0;

        $sql = "SELECT * FROM $tbl_name $clause order by title asc LIMIT $start, $limit";
        //echo $sql.'<br />';
        $result = mysql_query($sql);


        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }

        $this->paging_data = $return_data;
        $this->page_no = $page;


        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil($total_pages / $limit);
        $lpm1 = $lastpage - 1;

        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<div class='pagination'>";
            if ($page > 1)
                $pagination.= "<a href='" . $path . "page=$prev'>&lt;&lt; previous</a>";
            else
                $pagination.= "<span class='disabled'>&lt;&lt; previous</span>";

            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                    else
                        $pagination.= "<a href='" . $path . "page=$counter'>$counter</a>";
                }
            }elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page)
                            $pagination.= "<span class='current'>$counter</span>";
                        else
                            $pagination.= "<a href='" . $path . "page=$counter'>$counter</a>";
                    }
                    $pagination.= "<span class='disabled'>...</span>";
                    $pagination.= "<a href='" . $path . "page=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='" . $path . "page=$lastpage'>$lastpage</a>";
                }elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination.= "<a href='" . $path . "page=1'>1</a>";
                    $pagination.= "<a href='" . $path . "page=2'>2</a>";
                    $pagination.= "<span class='disabled'>...</span>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<span class='current'>$counter</span>";
                        else
                            $pagination.= "<a href='" . $path . "page=$counter'>$counter</a>";
                    }
                    $pagination.= "<span class='disabled'>..</span>";
                    $pagination.= "<a href='" . $path . "page=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='" . $path . "page=$lastpage'>$lastpage</a>";
                }else {
                    $pagination.= "<a href='" . $path . "page=1'>1</a>";
                    $pagination.= "<a href='" . $path . "page=2'>2</a>";
                    $pagination.= "<span class='disabled'>..</span>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<span class='current'>$counter</span>";
                        else
                            $pagination.= "<a href='" . $path . "page=$counter'>$counter</a>";
                    }
                }
            }

            if ($page < $counter - 1)
                $pagination.= "<a href='" . $path . "page=$next'>next &gt;&gt;</a>";
            else
                $pagination.= "<span class='disabled'>next &gt;&gt;</span>";
            $pagination.= "</div>";
        }


        return $pagination;
    }

    public function doc_info($str = null) {
        $doc_info = array();
        $doc_info['theme_root'] = BASE_URL . THEME . $this->app->settings['public_theme'] . DS;
        switch ($str) {
            case 'theme_root':
                return $doc_info['theme_root'];
            default:
                return $doc_info;
        }
    }

    public function get_menu($menu_type) {
        if (!empty($menu_type)) {
            $sql = "SELECT id FROM " . $this->app->config['db_prefix'] . "menus WHERE identifier='$menu_type' && status = 'active'";
            $result = mysql_query($sql);
            if (!$result) {
                $message = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $sql;
                $this->err = $message;
                return false;
            }
            $row = mysql_fetch_assoc($result);
            $menu_id = $row['id'];
        }

        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "menu_item WHERE menus_id = '" . $menu_id . "' AND status = 'active' ORDER BY parent_id, ordering, id ASC";

        $items = mysql_query($sql);
        if (!$items) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        while ($obj = mysql_fetch_object($items)) {
            if ($obj->parent_id == 0) {
                $parent_menu[$obj->id]['id'] = $obj->id;
                $parent_menu[$obj->id]['title'] = $obj->title;
                $parent_menu[$obj->id]['target'] = $obj->target;
                if ($obj->menu_type == 'page') {
                    $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "pages WHERE id ='" . $obj->page_id . "' AND status = 'active'";
                    $result = mysql_query($sql);
                    if (!$result) {
                        $message = 'Invalid query: ' . mysql_error() . "\n";
                        $message .= 'Whole query: ' . $sql;
                        $this->err = $message;
                        return false;
                    }
                    $row = mysql_fetch_assoc($result);
                    $parent_menu[$obj->id]['page'] = $row['identifier'];
                    $parent_menu[$obj->id]['controller'] = $row['controller'];
                }
                if ($obj->menu_type == 'category') {
                    $parent_menu[$obj->id]['page'] = 'category' . '&c_id=' . $obj->cat_id;
                    $parent_menu[$obj->id]['c_id'] = $obj->cat_id;
                    $parent_menu[$obj->id]['controller'] = 'categories';
                }

                if ($obj->menu_type == 'url') {
                    $parent_menu[$obj->id]['url'] = $obj->url;
                }
            } else {
                $sub_menu[$obj->id]['parent'] = $obj->parent_id;
                $sub_menu[$obj->id]['title'] = $obj->title;
                $sub_menu[$obj->id]['target'] = $obj->target;

                if ($obj->menu_type == 'page') {
                    $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "pages WHERE id ='" . $obj->page_id . "' AND status = 'active'";
                    $result = mysql_query($sql);
                    if (!$result) {
                        $message = 'Invalid query: ' . mysql_error() . "\n";
                        $message .= 'Whole query: ' . $sql;
                        $this->err = $message;
                        return false;
                    }
                    $row = mysql_fetch_assoc($result);
                    $sub_menu[$obj->id]['page'] = $row['identifier'];
                    $sub_menu[$obj->id]['controller'] = $row['controller'];
                }

                if ($obj->menu_type == 'category') {
                    $sub_menu[$obj->id]['page'] = 'category' . '&c_id=' . $obj->cat_id;
                    $sub_menu[$obj->id]['c_id'] = $obj->cat_id;
                    $sub_menu[$obj->id]['controller'] = 'categories';
                }

                if ($obj->menu_type == 'url') {
                    $sub_menu[$obj->id]['url'] = $obj->url;
                }
                $parent_menu[$obj->parent_id]['count']++;
            }
        }

        mysql_free_result($items);
		if (isset($parent_menu)) {
        $this->parent_menu = $parent_menu;
		}
        if (isset($sub_menu)) {
            $this->sub_menu = $sub_menu;
        }
        return true;
    }

    public function get_main_menu($menu_type) {
        if (!empty($menu_type)) {            

            $sql = "SELECT id FROM " . $this->app->config['db_prefix'] . "menus WHERE identifier='$menu_type' && status = 'active'";
            $result = mysql_query($sql);
            if (!$result) {
                $message = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $sql;
                $this->err = $message;
                return false;
            }
            $row = mysql_fetch_assoc($result);
            $menu_id = $row['id'];
        }

        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "menu_item WHERE menus_id = '" . $menu_id . "' AND status = 'active' ORDER BY parent_id, ordering, id ASC";

        $items = mysql_query($sql);
        if (!$items) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        while ($obj = mysql_fetch_object($items)) {
            if ($obj->parent_id == 0) {
                $parent_menu[$obj->id]['id'] = $obj->id;
                $parent_menu[$obj->id]['title'] = $obj->title;
                $parent_menu[$obj->id]['target'] = $obj->target;
                if ($obj->menu_type == 'page') {
                    $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "pages WHERE id ='" . $obj->page_id . "' AND status = 'active'";
                    $result = mysql_query($sql);
                    if (!$result) {
                        $message = 'Invalid query: ' . mysql_error() . "\n";
                        $message .= 'Whole query: ' . $sql;
                        $this->err = $message;
                        return false;
                    }
                    $row = mysql_fetch_assoc($result);
                    $parent_menu[$obj->id]['page'] = $row['identifier'];
                    $parent_menu[$obj->id]['controller'] = $row['controller'];
                }
                if ($obj->menu_type == 'category') {
                    $parent_menu[$obj->id]['page'] = 'category' . '&c_id=' . $obj->cat_id;
                    $parent_menu[$obj->id]['c_id'] = $obj->cat_id;
                    $parent_menu[$obj->id]['controller'] = 'categories';
                }

                if ($obj->menu_type == 'url') {
                    $parent_menu[$obj->id]['url'] = $obj->url;
                    $parent_menu[$obj->id]['identifier'] = $obj->identifier;
                }
            } else {
                $sub_menu[$obj->id]['parent'] = $obj->parent_id;
                $sub_menu[$obj->id]['title'] = $obj->title;
                $sub_menu[$obj->id]['target'] = $obj->target;
				$parent_menu[$obj->parent_id]['count'] = 0;
				
                if ($obj->menu_type == 'page') {
                    $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "pages WHERE id ='" . $obj->page_id . "' AND status = 'active'";
                    $result = mysql_query($sql);
                    if (!$result) {
                        $message = 'Invalid query: ' . mysql_error() . "\n";
                        $message .= 'Whole query: ' . $sql;
                        $this->err = $message;
                        return false;
                    }
                    $row = mysql_fetch_assoc($result);
                    $sub_menu[$obj->id]['page'] = $row['identifier'];
                    $sub_menu[$obj->id]['controller'] = $row['controller'];
                }

                if ($obj->menu_type == 'category') {
                    $sub_menu[$obj->id]['page'] = 'category' . '&c_id=' . $obj->cat_id;
                    $sub_menu[$obj->id]['c_id'] = $obj->cat_id;
                    $sub_menu[$obj->id]['controller'] = 'categories';
                }

                if ($obj->menu_type == 'url') {
                    $sub_menu[$obj->id]['url'] = $obj->url;
                    $parent_menu[$obj->id]['identifier'] = $obj->identifier;
                }
                $parent_menu[$obj->parent_id]['count']++;
            }
        }
        //print_r($parent_menu);
        mysql_free_result($items);
        $this->parent_menu = $parent_menu;
        if (isset($sub_menu)) {
            $this->sub_menu = $sub_menu;
        }
        return true;
    }

    public function get_block($block_title) {
        if (!empty($block_title)) {
            $sql = "SELECT description FROM " . $this->app->config['db_prefix'] . "blocks WHERE title = '$block_title' AND status = 'active'";
            $result = mysql_query($sql);
            if (!$result) {
                $message = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $sql;
                $this->err = $message;
                return false;
            }
            $row = mysql_fetch_assoc($result);
            $block_description = $row['description'];
            return $block_description;
        }
        else
            return false;
    }

    public function get_slide_banner() {
        $sql = "SELECT title, photo FROM " . $this->app->config['db_prefix'] . "banner_management WHERE status = 'active' ORDER BY ordering ASC";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    public function get_slider() {
        $sql = "SELECT title, photo, url FROM " . $this->app->config['db_prefix'] . "slider_management WHERE status = 'active' ORDER BY id ASC";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    public function get_page_content($p_ident = 'home') {
        if (!empty($p_ident)) {
            $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "pages WHERE identifier ='" . $p_ident . "' AND status = 'active'";
            $result = mysql_query($sql);
            if (!$result) {
                $message = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $sql;
                $this->err = $message;
                return false;
            }
            $row = mysql_fetch_assoc($result);
            return $row;
        }
        else
            return false;
    }

    public function get_download_files() {
        $sql = "SELECT title, file FROM " . $this->app->config['db_prefix'] . "download_management WHERE status = 'active' ORDER BY ordering ASC";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    public function get_message() {
        $sql = "SELECT title, description, photo FROM " . $this->app->config['db_prefix'] . "message_management WHERE status = 'active' ORDER BY ordering DESC";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    public function get_news() {
        $sql = "SELECT title, description, photo FROM " . $this->app->config['db_prefix'] . "news_management WHERE status = 'active' ORDER BY ordering ASC";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    public function get_organizer_info() {
        $sql = "SELECT title, description, photo, url FROM " . $this->app->config['db_prefix'] . "organizer_management WHERE status = 'active' ORDER BY ordering ASC";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    public function get_title($identifier) {
        $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "pages WHERE identifier = '" . $identifier . "'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        while ($row = mysql_fetch_assoc($result)) {
            $title = $row['title'];
        }
        return $title;
    }

    public function recent_activity_cat_title($cat_id) {
        $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "categories WHERE id = '" . $cat_id . "' && status = 'active'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        while ($row = mysql_fetch_assoc($result)) {
            $cat_title = $row['title'];
        }
        return $cat_title;
    }

    public function recent_activity($cat_id) {
        $sql = "SELECT dnp_articles.*, dnp_categories.title as cat_title FROM dnp_articles, dnp_categories WHERE (dnp_articles.category_id = $cat_id && dnp_categories.id = $cat_id) && (dnp_articles.status = 'active' && dnp_categories.status = 'active')";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_activity = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_activity[$index] = $row;
            $index++;
        }
        return $return_activity;
    }

    public function news_event_cat_title($cat_id) {
        $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "categories WHERE id = '" . $cat_id . "' && status = 'active'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        while ($row = mysql_fetch_assoc($result)) {
            $cat_title = $row['title'];
        }
        return $cat_title;
    }

    public function news_event($limit, $cat_id) {
        ;
        $sql = "SELECT dnp_articles.*, dnp_categories.title as cat_title FROM dnp_articles, dnp_categories WHERE (dnp_articles.category_id = $cat_id && dnp_categories.id = $cat_id) && (dnp_articles.status = 'active' && dnp_categories.status = 'active') order by dnp_articles.id desc limit 0, $limit";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_activity = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_activity[$index] = $row;
            $index++;
        }
        return $return_activity;
    }

    public function article_title($id) {
        $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "articles WHERE id = '" . $id . "' && status = 'active'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        while ($row = mysql_fetch_assoc($result)) {
            $title = $row['title'];
        }
        return $title;
    }

    public function article_desc($id) {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "articles WHERE id ='" . $id . "' AND status = 'active'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function link_list() {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "links WHERE status = 'active' order by id asc";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * newslater
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function newslater($data) {
        $created = date('Y-m-d H:i:s');
        $status = 'subscribe';
        $sql = "SELECT email_address FROM " . $this->app->config['db_prefix'] . "newslater WHERE (email_address = '" . $data['email'] . "')";
        $row = mysql_fetch_array(mysql_query($sql));
        if (empty($row)) {
            $sql = "INSERT INTO " . $this->app->config['db_prefix'] . "newslater (email_address, created, status) values ('" . $data['email'] . "', '" . $created . "', '" . $status . "')";
            $result = mysql_query($sql);
            if (!$result) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * get_feature_news
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_feature_news($post_type) {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "articles WHERE (post_type = '" . $post_type . "' && status = 'active') order by id desc LIMIT 0, 3";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * get_feature_offers
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_feature_offers($post_type) {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "articles WHERE (post_type = '" . $post_type . "' && status = 'active') order by id desc LIMIT 0, 4";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * get_feature_events
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_feature_events() {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "events WHERE status = 'active' order by id desc LIMIT 0, 4";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * get_feature_logos
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_feature_logos() {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "organizer_management WHERE status = 'active' order by id desc";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * get_page_id
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_page_id($identifier) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "pages where identifier = '$identifier' && status = 'active'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    /**
     * sidebar_block_id
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function sidebar_block_id($id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "manage_sidebar where page_id = '$id' && status = 'active'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    /**
     * common_sidebar_block_id
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function common_sidebar_block_id($id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "manage_sidebar where id = '$id' && status = 'active'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    /**
     * get_sidebar_block
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_sidebar_block($blocks) {
        $current = current($blocks);
        $where = " WHERE ";
        $where.="(id = '$current' ";
        foreach ($blocks as $key => $val) {
            if ($current != $val) {
                $where.=" || id = '$val'";
            }
        }
        $where.=") && (status = 'active') order by ordering asc";
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "blocks " . $where;
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * shop_dine_cat_list
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function shop_dine_cat_list($post_type) {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "categories WHERE ((post_type = '$post_type') && status = 'active')";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * all_cat_list
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function all_cat_list() {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "categories WHERE ((post_type = 'shop' || post_type = 'dine') && status = 'active')";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * get_special_offers
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_special_offers($post_type) {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "articles WHERE (post_type = '" . $post_type . "' && status = 'active' && featured = 'yes') order by id desc";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * get_latest_news
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_latest_news($post_type, $limit) {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "articles WHERE (post_type = '" . $post_type . "' && status = 'active') order by id desc LIMIT 0, $limit";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * get_coming_events
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_coming_events($limit) {
        $current_date = date('Y-m-d');
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "events WHERE (status = 'active' && start_date > '$current_date' && end_date > '$current_date') order by id desc LIMIT 0, $limit";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * get_featured_video
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_featured_video($limit) {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "video_gallery WHERE (status = 'active' && featured = 'Yes') LIMIT 0, $limit";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * get_country_list
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_country_list() {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "countries";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * current_events
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function current_events($limit) {
        $current_date = date('Y-m-d');
        $where = "WHERE (status = 'active' && (start_date <= '$current_date' && end_date >= '$current_date'))";
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "events $where order by created desc LIMIT 0, $limit";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * uocoming_events
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function uocoming_events($limit) {
        $current_date = date('Y-m-d');
        $where = "WHERE (status = 'active' && start_date > '$current_date' && end_date > '$current_date')";
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "events $where order by created desc LIMIT 0, $limit";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * admin_login_data
     *
     * parameter $id takes id of a user and return all data for the id from users table to all admin pages.
     * 
     * return an arrey of data
     * 
     * return false in error  
     * */
    public function admin_login_data($id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "users where id=$id";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }

        $row = mysql_fetch_assoc($result);
        return $row;
    }

    /**
     * admin_nav
     *
     * parameter $id takes id of a user and return all data for the id from users table to all admin pages.
     * 
     * return an arrey of data
     * 
     * return false in error  
     * */
    public function admin_nav($permision_data_set, $permision_arr) {
		
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "menus WHERE status = 'active'";
        $result = mysql_query($sql);
        $list = array();
        $list[] = array(
            'title' => 'All Menu',
            'url' => BASE_URL . 'admin/index.php?controller=menus',
            'access_url' => 'admin/index.php?controller=menus',
            'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['menus'], $permision_arr),
        );
        while ($row = mysql_fetch_assoc($result)) {
            $list[] = array(
                'title' => $row['title'],
                'url' => BASE_URL . 'admin/index.php?controller=menu_item&menus_id=' . $row['id'],
                'access_url' => 'admin/index.php?controller=menu_item',
                'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['menus'], $permision_arr),
            );
        }
        $nav = '';
                $nav[] = array(
                    'title' => 'Dashboard',
                    'url' => BASE_URL . 'admin/index.php?controller=accounts',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['dashboard'], $permision_arr),
                );
        $nav[] = array(
            'title' => 'Pages',
            'url' => BASE_URL . 'admin/index.php?controller=pages',
			'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['pages'], $permision_arr),
            'submenu' => array(
                array(
                    'title' => 'All Pages',
                    'url' => BASE_URL . 'admin/index.php?controller=pages',
                    'access_url' => 'admin/index.php?controller=pages',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['pages'], $permision_arr),
                ),
                array(
                    'title' => 'Add New Page',
                    'url' => BASE_URL . 'admin/index.php?controller=pages&action=add',
                    'access_url' => 'admin/index.php?controller=pages',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['pages'], array($permision_arr[1])),
                ),
            )
        );
        $nav[] = array(
            'title' => 'Categories',
            'url' => BASE_URL . 'admin/index.php?controller=categories',
			'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['categories'], $permision_arr),
            'submenu' => array(
                array(
                    'title' => 'All Category',
                    'url' => BASE_URL . 'admin/index.php?controller=categories',
                    'access_url' => 'admin/index.php?controller=categories',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['categories'], $permision_arr),
                ),
                array(
                    'title' => 'Add New Categories',
                    'url' => BASE_URL . 'admin/index.php?controller=categories&action=add',
                    'access_url' => 'admin/index.php?controller=categories',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['categories'], array($permision_arr[1])),
                ),
            )
        );
        $nav[] = array(
            'title' => 'Articles',
            'url' => BASE_URL . 'admin/index.php?controller=articles',
			'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['articles'], $permision_arr),
            'submenu' => array(
                array(
                    'title' => 'All Article',
                    'url' => BASE_URL . 'admin/index.php?controller=articles',
                    'access_url' => 'admin/index.php?controller=articles',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['articles'], $permision_arr),
                ),
                array(
                    'title' => 'Add New Article',
                    'url' => BASE_URL . 'admin/index.php?controller=articles&action=add',
                    'access_url' => 'admin/index.php?controller=articles',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['articles'], array($permision_arr[1])),
                ),
            )
        );
        $nav[] = array(
            'title' => 'Blocks',
            'url' => BASE_URL . 'admin/index.php?controller=block_area',
			'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['blocks'], $permision_arr),
            'submenu' => array(
                array(
                    'title' => 'All Block Area',
                    'url' => BASE_URL . 'admin/index.php?controller=block_area',
                    'access_url' => 'admin/index.php?controller=block_area',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['blocks'], $permision_arr),
                ),
                array(
                    'title' => 'Add New Block',
                    'url' => BASE_URL . 'admin/index.php?controller=manage_block&action=add',
                    'access_url' => 'admin/index.php?controller=manage_block',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['blocks'], array($permision_arr[1])),
                ),
            )
        );
        $nav[] = array(
            'title' => 'Menus',
            'url' => BASE_URL . 'admin/index.php?controller=menus',
			'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['menus'], $permision_arr),
            'submenu' => $list,
        );
        $nav[] = array(
            'title' => 'Slider',
            'url' => BASE_URL . 'admin/index.php?controller=banner_management',
			'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['slider'], $permision_arr),
            'submenu' => array(
                array(
                    'title' => 'All Slide',
                    'url' => BASE_URL . 'admin/index.php?controller=banner_management',
                    'access_url' => 'admin/index.php?controller=banner_management',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['slider'], $permision_arr),
                ),
                array(
                    'title' => 'Add New Slide',
                    'url' => BASE_URL . 'admin/index.php?controller=banner_management&action=add',
                    'access_url' => 'admin/index.php?controller=banner_management',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['slider'], array($permision_arr[1])),
                ),
            )
        );
        $nav[] = array(
            'title' => 'Media Manager',
            'url' => BASE_URL . 'admin/index.php?controller=media',
			'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['media_manager'], $permision_arr),
        );
        $nav[] = array(
            'title' => 'Database Backup',
            'url' => BASE_URL . 'admin/index.php?controller=backup',
			'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['database_backup'], $permision_arr),
        );
        $nav[] = array(
            'title' => 'User Role',
            'url' => BASE_URL . 'admin/index.php?controller=role_user',
			'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['user_role'], $permision_arr),
        );
        $nav[] = array(
            'title' => 'Users',
            'url' => BASE_URL . 'admin/index.php?controller=user',
			'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['users'], $permision_arr),
            'submenu' => array(
                array(
                    'title' => 'All Users',
                    'url' => BASE_URL . 'admin/index.php?controller=user',
                    'access_url' => 'admin/index.php?controller=user',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['users'], $permision_arr),
                ),
                array(
                    'title' => 'Add New User',
                    'url' => BASE_URL . 'admin/index.php?controller=user&action=add',
                    'access_url' => 'admin/index.php?controller=user',
					'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['users'], array($permision_arr[1])),
                ),
            )
        );
        $nav[] = array(
            'title' => 'User Profile',
            'url' => BASE_URL . 'admin/index.php?controller=profile&id=' . $this->app->session->get_var('user_id'),
			'permision' => true,
        );
		$nav[] = array(
            'title' => 'Newslatter',
            'url' => BASE_URL . 'admin/index.php?controller=newslatter',
			'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['newslatter'], $permision_arr),
        );
        $nav[] = array(
            'title' => 'Site Settings',
            'url' => BASE_URL . 'admin/index.php?controller=default_setting',
			'permision' => $this->app->role_user->check_permission_sidebar_admin_menu($permision_data_set['settings'], $permision_arr),
        );	

        return $nav;
    }

    /**
     * search_pages
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function search_pages($key) {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "pages WHERE title LIKE '%$key%'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $index = 0;
		$return_data = '';
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * logos
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function logos() {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "organizer_management WHERE status = 'active'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

    /**
     * last_news
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function last_news() {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "articles WHERE (status = 'active' && category_id = '1' && post_type = 'news') order by id";

        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return end($return_data);
    }

    /**
     * get_about_page_content
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_about_page_content($id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "pages where id = '$id' && status = 'active'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        while ($row = mysql_fetch_assoc($result)) {
            $return_data['title'] = $row['title'];
            $return_data['description'] = $row['description'];
            $return_data['identifier'] = $row['identifier'];
            $return_data['controller'] = $row['controller'];
        }
        return $return_data;
    }

    /**
     * get_feature_product
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function get_feature_product() {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "products WHERE (featured = 'yes' && status = 'active')";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            $index++;
        }
        return $return_data;
    }

}