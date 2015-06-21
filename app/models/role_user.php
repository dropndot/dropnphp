<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class role_user {

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
    public function insert_data($data) {

        $created = date('Y-m-d H:i:s');
        $modified = date('Y-m-d H:i:s');

        $role_name = mysql_escape_string($data['title']);
        $rs_data = mysql_query("SELECT * FROM " . $this->app->config['db_prefix'] . "groups WHERE name = '" . $role_name . "'");
        $row = mysql_fetch_object($rs_data);
        if (empty($row)) {
            $sql = "INSERT INTO " . $this->app->config['db_prefix'] . "groups 
            (name, group_type, created, modified, status)
            VALUES ('" . $data['title'] . "', '" . $data['group_type'] . "', '" . $created . "', '" . $modified . "', '" . $data['status'] . "')";
            $result = mysql_query($sql);
            if ($result) {
                $group_id = mysql_insert_id();
                if (!empty($data['permision'])) {
                    foreach ($data['permision'] as $key => $value) {
                        if (!empty($value['permision_item'])) {
                            $permision = serialize($value['permision_item']);
                            $sql = "INSERT INTO " . $this->app->config['db_prefix'] . "permission 
                        (
                        group_id, p_type_id, permission) 
                        VALUES (
                        '" . $group_id . "', '" . $value['id'] . "', '" . $permision . "')";
                            mysql_query($sql);
                        }
                    }
                }
            } else {
                $this->err = mysql_error();
                return false;
            }
        } else {
            $this->err = 'User role already exist.';
            return false;
        }
    }

    /**
     * update_data
     * 
     * takes data from articles update form and update data in article table
     * 
     * parameter $data an arrey submitted from articles update form
     * 
     * return true for a successful update
     * 
     * return false in error  
     * */
    public function update_data($data) {

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "groups set 
                        name='" . addslashes($data['name']) . "',
                        group_type='" . addslashes($data['group_type']) . "',
                        status='" . $data['status'] . "'
                        WHERE id='" . $data['id'] . "'";
        $result = mysql_query($sql);
        if ($result) {
            $sql = "DELETE FROM " . $this->app->config['db_prefix'] . "permission WHERE group_id = " . $data['id'];
            $result = mysql_query($sql);
            if (!$result || $result) {
                if (!empty($data['permision'])) {
                    foreach ($data['permision'] as $key => $value) {
                        if (!empty($value['permision_item'])) {
                            $permision = serialize($value['permision_item']);
                            $sql = "INSERT INTO " . $this->app->config['db_prefix'] . "permission 
                        (
                        group_id, p_type_id, permission) 
                        VALUES (
                        '" . $data['id'] . "', '" . $value['id'] . "', '" . $permision . "')";
                            mysql_query($sql);
                        }
                    }
                }
            }
        } else {
            $this->err = 'User role already exist.';
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

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "groups SET
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
     * check_user_list
     * 
     * update status in menu_item table
     * 
     * parameter $data an arrey of menu_item id 
     * 
     * return true for a successful update
     * 
     * return false in error  
     * */
    public function check_user_list($data) {
        $group_id = $data['check_list'][0];
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "users WHERE group_id = " . $group_id;
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $num_rows = mysql_num_rows($result);
        return $num_rows;
    }
	
	/**
     * check_user_list_delete
     * 
     * update status in menu_item table
     * 
     * parameter $data an arrey of menu_item id 
     * 
     * return true for a successful update
     * 
     * return false in error  
     * */
    public function check_user_list_delete($id) {
        $group_id = $id;
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "users WHERE group_id = " . $group_id;
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $num_rows = mysql_num_rows($result);
        return $num_rows;
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
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "groups where id=$id";
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
        $sql = "UPDATE " . $this->app->config['db_prefix'] . "groups SET
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
     * get_role_user
     * 
     * parameter $tbl_left_name, $tbl_right_name are string, takes two table name and make left join and return all data 
     * of left table in the limit passed by the integer type variable $limit, $path and $status is string, $tbl_right_id takes
     * right table id(default value is null), $fk_name takes field name in the left table as forein key from the right table
     * (default value is null)
     * 
     * return a string of pagination
     * 
     * */
    function get_role_user() {
		if($this->app->session->get_var('group_id') == 2){
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "groups WHERE (status = 'active' || status = 'inactive') ORDER BY name ASC";
		}else{
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "groups WHERE ((status = 'active' || status = 'inactive') && id != 2) ORDER BY name ASC";
		}
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
     * get_edit_permission_item
     * 
     * return id and title of block_area
     * 
     * no parameter
     * 
     * return array of id & title
     * 
     * return false in error  
     * */
    public function get_edit_permission_item($group_id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "permission_item";
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
        $permisions = array();
        foreach ($return_data as $key => $value) {
            $sql = "SELECT * from " . $this->app->config['db_prefix'] . "permission Where (group_id = " . $group_id . " && p_type_id = " . $value['p_type_id'] . " )";
            $result = mysql_query($sql);
            $row = mysql_fetch_assoc($result);
            $permisions[] = array(
                "p_type_id" => $value['p_type_id'],
                "title" => $value['title'],
                "item_key" => $value['item_key'],
                "group_id" => $group_id,
                "permision_item" => $row['permission'],
            );
        }
        return $permisions;
    }

    /**
     * get_permission_item
     * 
     * return id and title of block_area
     * 
     * no parameter
     * 
     * return array of id & title
     * 
     * return false in error  
     * */
    public function get_permission_item() {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "permission_item";
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
     * get_permission
     * 
     * return id and title of block_area
     * 
     * no parameter
     * 
     * return array of id & title
     * 
     * return false in error  
     * */
    public function get_permission($group_id, $per_id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "permission WHERE (group_id = $group_id && p_type_id = $per_id)";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $row = mysql_fetch_assoc($result);
        return unserialize($row['permission']);
    }

    /**
     * check_permission
     * 
     * return id and title of block_area
     * 
     * no parameter
     * 
     * return array of id & title
     * 
     * return false in error  
     * */
    public function check_permission($per_arr, $access_arr) {
        if (!empty($per_arr) && (array_intersect($access_arr, $per_arr))) {
            return true;
        } else {
            header('Location: index.php?controller=accounts&action=warning');
            exit;
        }
    }

    /**
     * check_permission
     * 
     * return id and title of block_area
     * 
     * no parameter
     * 
     * return array of id & title
     * 
     * return false in error  
     * */
    public function check_permission_one($per_arr, $access_arr) {
        if (!empty($per_arr) && (array_intersect($access_arr, $per_arr))) {
            return true;
        } else {
            return false;
        }
    }
	
	/**
     * check_permission_sidebar_admin_menu
     * 
     * return id and title of block_area
     * 
     * no parameter
     * 
     * return array of id & title
     * 
     * return false in error  
     * */
    public function check_permission_sidebar_admin_menu($per_arr, $access_arr) { 
        if (!empty($per_arr) && (array_intersect($access_arr, $per_arr))) {
            return true;
        } else {
            return false;
        }
    }

}

?>