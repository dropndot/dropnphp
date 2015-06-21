<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class menu_item {

    private $app;
    var $err;
    var $paging_data;
    var $page_no;
    var $page_status;
    var $menus_id;
    var $parent_title;

    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * insert_data
     * 
     * takes data from menu_item form and insert data in menu_item table
     * 
     * parameter $data an arrey submitted from menu_item form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function insert_data($data, $menus_id = null) {

        $created = date('Y-m-d H:i:s');
        $modified = date('Y-m-d H:i:s');

        $identifier = $data['title'];
        $identifier = strtolower($identifier);
        $identifier = str_replace(' ', '-', $identifier);
        if (!empty($data['target'])) {
            $target = $data['target'];
        } else {
            $target = 'same';
        }
        if ($data['menu_type'] == 'page' || $data['menu_type'] == 'url') {
            $cat_id = '';
        } else {
            $cat_id = $data['cat_id'];
        }
        if ($data['menu_type'] == 'category' || $data['menu_type'] == 'url') {
            $page_id = '';
        } else {
            $page_id = $data['page_id'];
        }
        
        if ($_POST['menus_id'] == $menus_id) {
            if (mysql_query("INSERT INTO " . $this->app->config['db_prefix'] . "menu_item (menus_id, parent_id, title, identifier, menu_type, page_id, cat_id, url, target, ordering, status, created, modified) VALUES ('" . $data['menus_id'] . "', '" . $data['parent_id'] . "', '" . $data['title'] . "', '" . $identifier . "', '" . $data['menu_type'] . "', '" . $page_id . "', '" . $cat_id . "', '" . $data['url'] . "', '" . $target . "', '" . $data['ordering'] . "', '" . $data['status'] . "', '" . $created . "', '" . $modified . "')")) {

                return true;
            } else {
                $this->err = mysql_error();
                return false;
            }
        }
        else
            $this->err = "Manus ID not found !!";
    }

    /**
     * update_data
     * 
     * takes data from menu_item update form and update data in menu_item table
     * 
     * parameter $data an arrey submitted from menu_item update form and $menus_id takes menu id(default value is null)
     * 
     * return true for a successful update
     * 
     * return false in error  
     * */
    public function update_data($data, $menus_id = null) {

        $modified = date('Y-m-d H:i:s');
        $identifier = $data['title'];
        $identifier = strtolower($identifier);
        $identifier = str_replace(' ', '-', $identifier);

        if ($data['menu_type'] == 'page' || $data['menu_type'] == 'url') {
            $cat_id = '';
        } else {
            $cat_id = $data['cat_id'];
        }
        if ($data['menu_type'] == 'category' || $data['menu_type'] == 'url') {
            $page_id = '';
        } else {
            $page_id = $data['page_id'];
        }  

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "menu_item set  
        menus_id='" . $data['menus_id'] . "',
        parent_id='" . $data['parent_id'] . "',
        title='" . $data['title'] . "',
        identifier='" . $identifier . "',
        menu_type='" . $data['menu_type'] . "',
        page_id='" . $page_id . "',
        cat_id='" . $cat_id . "',
        url='" . $data['url'] . "',
        target='" . $data['target'] . "',
        ordering='" . $data['ordering'] . "',
        status='" . $data['status'] . "',
        modified='" . $modified . "'
        WHERE id='" . $data['id'] . "'";
    
        if (mysql_query($sql)) {
            if (($data['menus_id'] != $menus_id) && !empty($menus_id)) {
                $this->menus_id = $data['menus_id'];
            } else {
                $this->menus_id = $menus_id;
            }
            return true;
        } else {
            $this->err = mysql_error();
            return false;
        }
    }

    /**
     * update_status
     * 
     * update status in menu_item table
     * 
     * parameter $data an arrey of menu_item id 
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

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "menu_item SET
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
     * parameter $id takes id of a menu_item and return all data for the id from menu_item table to admin_edit page
     * 
     * return an arrey of data
     * 
     * return false in error  
     * */
    public function get_row($id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "menu_item where id=$id";
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
     * parameter $id takes id of an menu_item and delet all data for that id to trash
     * 
     * return true for a successful delet
     * 
     * return false in error  
     * */
    public function delete_trash($id) {
        $sql = "UPDATE " . $this->app->config['db_prefix'] . "menu_item SET
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
     * get_page_list
     * 
     * return id, title & identifier from the pages table
     * 
     * return an array of data
     * 
     * return false in error  
     * */
    public function get_page_list() {
        $sql = "SELECT id, title, identifier FROM " . $this->app->config['db_prefix'] . "pages WHERE status = 'active' ORDER BY title ASC";
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

        mysql_free_result($result);

        return $return_data;
    }

    /**
     * get_cat_list
     * 
     * return id, title & identifier from the pages table
     * 
     * return an array of data
     * 
     * return false in error  
     * */
    public function get_cat_list() {
        $sql = "SELECT id, title, identifier FROM " . $this->app->config['db_prefix'] . "categories WHERE status = 'active' ORDER BY title ASC";
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

        mysql_free_result($result);
        return $return_data;
    }

    /**
     * delete_row
     * 
     * parameter $id takes id of a menu_item and permanently delet all data for that id
     * 
     * return true for a successful delet
     * 
     * return false in error  
     * */
    public function delete_row($id) {
        $sql = "DELETE from " . $this->app->config['db_prefix'] . "blocks where id=$id";
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
     * get_menus_id
     * 
     * return id, title from the menus table
     * 
     * return an array of data
     * 
     * return false in error  
     * */
    public function get_menus_id() {
        $sql = "SELECT id, title from " . $this->app->config['db_prefix'] . "menus";
        //echo $sql;
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
        mysql_free_result($result);


        return $return_data;
    }

    /**
     * get_title_menus
     * 
     * return title of a given menu id from the menus table
     * 
     * parameter $menus_id takes a single menu id
     * 
     * return false in error  
     * */
    public function get_title_menus($menus_id) {
        $sql = "SELECT title from " . $this->app->config['db_prefix'] . "menus WHERE id = '$menus_id'";
        //echo $sql;
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $return_data = array();
        $return_data = mysql_fetch_assoc($result);


        return $return_data['title'];
    }

    /**
     * get_id_menu_item
     * 
     * no parameter
     * 
     * return id & title of all menu item from menu item table in an array $return_data
     * 
     * return false in error  
     * */
    public function get_id_menu_item($menus_id) {
        $sql = "SELECT id, title from " . $this->app->config['db_prefix'] . "menu_item WHERE status = 'active' AND menus_id = '" . $menus_id . "' order by id asc";
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
        mysql_free_result($result);

        return $return_data;
    }

    /**
     * paging
     * 
     * parameter $tbl_left_name, $tbl_right_name are string, takes two table name and make left join and return all data 
     * of left table in the limit passed by the integer type variable $limit, $path and $status is string, $tbl_right_id takes
     * right table id(default value is null), $fk_name takes field name in the left table as forein key from the right table
     * (default value is null)
     * 
     * return a string of pagination
     * 
     * */
    function paging($tbl_left_name, $tbl_right_name, $limit, $path, $status, $tbl_right_id = null, $fk_name = null) {

        $this->menus_id = $tbl_right_id;
        $clause = null;
        $page_status = $status;
        if ($status != null && $status == 'active') {
            $clause = "WHERE ($tbl_left_name.status = 'active' OR $tbl_left_name.status = 'inactive')";
        } else {          //if($status == 'active' || $status == 'delete')
            $clause = "WHERE $tbl_left_name.status = '$status'";
        }
        if (!($tbl_right_id == null && $fk_name == null)) {
            $clause .=" AND $tbl_left_name.$fk_name = $tbl_right_id";
        }
        $query = "SELECT COUNT(*) as num FROM $tbl_left_name $clause";
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

        $sql = "SELECT $tbl_left_name.*, $tbl_right_name.title as menus_title FROM 
    $tbl_left_name LEFT JOIN $tbl_right_name 
    ON $tbl_left_name.$fk_name = $tbl_right_name.id $clause 
    order by $tbl_left_name.parent_id, $tbl_left_name.ordering asc LIMIT $start, $limit";
        //echo $sql.'<br />';
        $result = mysql_query($sql);


        $return_data = array();
        $parent = array();
        $index = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $return_data[$index] = $row;
            if ($row['parent_id'] != 0) {
                $sql = "SELECT title FROM $tbl_left_name WHERE id=" . $row['parent_id'];
                //echo $sql;
                $sql_result = mysql_query($sql);
                //echo $parent_title;
                if (!$sql_result) {
                    $message = 'Invalid query: ' . mysql_error() . "\n";
                    $message .= 'Whole query: ' . $sql;
                    $this->err = $message;
                    return false;
                }
                $parent_title = mysql_fetch_assoc($sql_result);
                $parent[$index] = $parent_title['title'];
            } else {
                $parent[$index] = '--';
            }
            $index++;
        }
        $this->parent_title = $parent;
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

}

?>