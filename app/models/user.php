<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class user {

    private $app;

    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * insert_data
     * 
     * takes data from articles form and insert data in article table
     * 
     * parameter $data an arrey submitted from articles form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function insert_data($data) {

        $username = mysql_escape_string($data['username']);
        $rs_data = mysql_query("SELECT * FROM " . $this->app->config['db_prefix'] . "users WHERE username = '" . $username . "'");
        $row = mysql_fetch_object($rs_data);
        if (empty($row)) {
            if (!empty($_FILES['profile_image']['name'])) { //check blank image field               
                $upload_address = BASE . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'users' . DS;
                $file_name = time() . '_' . basename($_FILES['profile_image']['name']);
                $upload_file = $upload_address . $file_name;
                move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_file);
            } else {
                $file_name = '';
            }

            $created = date('Y-m-d H:i:s');
            $password = md5(mysql_escape_string($data['password']));
			$user_group_data = mysql_query("SELECT * FROM " . $this->app->config['db_prefix'] . "groups WHERE id = '" . $data['group_id'] . "'");
			$row_data = mysql_fetch_array($user_group_data);
            $user_type = $row_data['group_type']; 
            $sql = "INSERT INTO " . $this->app->config['db_prefix'] . "users 
                        (
                        name, location, email, username, password, created, phone, details, group_id, user_type, status, profile_image) 
                        VALUES (
                        '" . $data['name'] . "', '" . $data['location'] . "', '" . $data['email'] . "', '" . $data['username'] . "', 
                        '" . $password . "',  '" . $created . "', '" . $data['phone'] . "', '" . $data['details'] . "',
                        '" . $data['group_id'] . "', '" . $user_type . "', '" . $data['status'] . "', '" . $file_name . "')";

            if (mysql_query($sql)) {
                return true;
            } else {
                $this->err = mysql_error();
                return false;
            }
        } else {
            $this->err = 'User name already exist.';
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

        $modified = date('Y-m-d H:i:s');
        if ($data['password']) {
            $password = md5($data['password']);
        } else {
            $password = $data['old_password'];
        }

        $img_fiel1 = '';
        if (!empty($_FILES['profile_image']['name'])) { //check blank image field
            $sql = "SELECT profile_image FROM " . $this->app->config['db_prefix'] . "users WHERE id = " . $data['id'];
            $result = mysql_query($sql);
            $row = mysql_fetch_assoc($result);
            $img_fiel1 = BASE . 'app' . DS . 'resources' . DS . 'document' . DS . 'users' . DS . $row['profile_image'];

            $upload_address = BASE . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'users' . DS;
            $file_name = time() . basename($_FILES['profile_image']['name']);
            $upload_file = $upload_address . $file_name;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_file);
        } else {
            $file_name = $data['old_profile_image'];
        }
		
		$user_group_data = mysql_query("SELECT * FROM " . $this->app->config['db_prefix'] . "groups WHERE id = '" . $data['group_id'] . "'");
		$row_data = mysql_fetch_array($user_group_data);
        $user_type = $row_data['group_type'];
        $sql = "UPDATE " . $this->app->config['db_prefix'] . "users set 
                    name='" . $data['name'] . "',
                    location='" . $data['location'] . "',
                    email='" . $data['email'] . "',
                    password='" . $password . "',
                    phone='" . $data['phone'] . "',
                    details='" . $data['details'] . "',
                    group_id='" . $data['group_id'] . "',
                    user_type='" . $user_type . "',
                    status='" . $data['status'] . "',
                    profile_image='" . $file_name . "'
                    WHERE id='" . $data['id'] . "'";

        if (mysql_query($sql)) {
            @unlink($img_fiel1);
            return true;
        } else {
            $this->err = mysql_error();
            return false;
        }
    }

    /**
     * update_status
     * 
     * update status in article table
     * 
     * parameter $data an arrey of article id 
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
            $id[$key] = $value;
        }
        $clause .="id = '" . $id[0] . "'";
        for ($i = 1; $i < $cunt; $i++) {
            $clause .=" OR id = '" . $id[$i] . "'";
        }

        $status = strtolower($data['status']);

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "users SET
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
     * parameter $id takes id of an article and return all data for the id from articles table to admin_edit page
     * 
     * return an arrey of data
     * 
     * return false in error  
     * */
    public function get_row($id) {
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
     * delete_trash
     * 
     * parameter $id takes id of an article and delet all data for that id to trash
     * 
     * return true for a successful delet
     * 
     * return false in error  
     * */
    public function delete_trash($id) {
        $sql = "UPDATE " . $this->app->config['db_prefix'] . "users SET
        status = 'delete' WHERE id = $id";
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
     * parameter $id takes id of an article and permanently delet all data for that id
     * 
     * return true for a successful delet
     * 
     * return false in error  
     * */
    public function delete_row($id) {
        $sql = "DELETE from " . $this->app->config['db_prefix'] . "users where id=$id";
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
     * parameter $tbl_left_name, $tbl_right_name are string, takes two table name and make left join and return all data 
     * of left table in the limit passed by the integer type variable $limit, $path and $status is string
     * 
     * return a string of pagination
     * 
     * */
    public function paging($tbl_left_name, $limit, $path, $status = null) {
        $clause = null;
        if ($status != null && $status == 'active') {
			if($this->app->session->get_var('group_id') == 2){
            $clause = "WHERE (status = 'active' || status = 'inactive')";
			}else{
            $clause = "WHERE ((status = 'active' || status = 'inactive') && group_id != 2)";
			}
        } else {
			if($this->app->session->get_var('group_id') == 2){
            $clause = "WHERE status = '$status'";
			}else{
            $clause = "WHERE status = '$status' && group_id != 2";
			}
        }
        $query = "SELECT COUNT(*) as num FROM $tbl_left_name $clause";
//echo $clause.'<br />';
        $row = mysql_fetch_array(mysql_query($query));
        $total_pages = $row['num'];
        $adjacents = "2";

        $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
        $page = ($page == 0 ? 1 : $page);

        if ($page)
            $start = ($page - 1) * $limit;
        else
            $start = 0;

        $sql = "SELECT * FROM $tbl_left_name $clause order by name asc LIMIT $start, $limit";

        $result = mysql_query($sql);
        if (!$result) {
            $this->err = mysql_error();
            return false;
        }

//$return_data = mysql_fetch_assoc($result);
//print_r($return_data);
        $return_data = array();
        $index = 0;
        while ($qrow = mysql_fetch_array($result)) {
            $return_data[$index] = $qrow;
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
                    $pagination.= "...";
                    $pagination.= "<a href='" . $path . "page=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='" . $path . "page=$lastpage'>$lastpage</a>";
                }elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination.= "<a href='" . $path . "page=1'>1</a>";
                    $pagination.= "<a href='" . $path . "page=2'>2</a>";
                    $pagination.= "...";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<span class='current'>$counter</span>";
                        else
                            $pagination.= "<a href='" . $path . "page=$counter'>$counter</a>";
                    }
                    $pagination.= "..";
                    $pagination.= "<a href='" . $path . "page=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='" . $path . "page=$lastpage'>$lastpage</a>";
                }else {
                    $pagination.= "<a href='" . $path . "page=1'>1</a>";
                    $pagination.= "<a href='" . $path . "page=2'>2</a>";
                    $pagination.= "..";
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

    /**
     * get_user_role
     * 
     * parameter $tbl_left_name, $tbl_right_name are string, takes two table name and make left join and return all data 
     * of left table in the limit passed by the integer type variable $limit, $path and $status is string, $tbl_right_id takes
     * right table id(default value is null), $fk_name takes field name in the left table as forein key from the right table
     * (default value is null)
     * 
     * return a string of pagination
     * 
     * */
    function get_user_group() {
		if($this->app->session->get_var('group_id') == 2){
			$sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "groups WHERE status = 'active' ORDER BY name ASC";
		}else{
			$sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "groups WHERE (id != 2 && status = 'active') ORDER BY name ASC";
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
     * search_users
     * 
     * takes data from pages form and insert data in pages table
     * 
     * parameter $data an arrey submitted from pages form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function search_users($key) {
        $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "users WHERE (name LIKE '%$key%' || email LIKE '%$key%' || phone LIKE '%$key%')";
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
    
//Admin login
    public function login($username, $password, $passremembar) {
        $username = mysql_escape_string($username);
        $password = md5(mysql_escape_string($password));
        $rs_data = mysql_query("SELECT * FROM " . $this->app->config['db_prefix'] . "users WHERE username = '" . $username . "' AND password = '" . $password . "' AND status='active'");
        if (mysql_num_rows($rs_data) < 1) {
            return $this->app->lang['ERROR_LOGIN'];
        } else {
            $row = mysql_fetch_object($rs_data);
            if (!empty($passremembar)) {
                setcookie("user_id", $row->id, time() + (3600 * 24 * 3), '/dropnphp/');
                setcookie("user_type", $row->user_type, time() + (3600 * 24 * 3), '/dropnphp/');
            }
             $this->app->session->add_var(array('user_id' => $row->id, 'user_type' => $row->user_type, 'group_id' => $row->group_id, 'name' => $row->name));
            if ($_SESSION) {
                session_regenerate_id(true);
            }
			if($row->group_id == 3 && $row->user_type == 'subscriber'){
            header('Location: index.php?controller=sub_page&page=about');
            exit;
			}else{
			header('Location: admin/index.php?controller=accounts');
            exit;
        }
        }
    }

//Forgot admin password
    public function forgot_password($email) {
        $email = mysql_escape_string($email);

        $new_password = time();
        $sub = 'Password Reset.';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        if (!empty($email)) {
            $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "users WHERE email = '" . $email . "' AND status='active'";
            $result = mysql_query($sql);
            $row_data = mysql_fetch_assoc($result);
        }
        if (!empty($row_data)) {
            $sql = "UPDATE " . $this->app->config['db_prefix'] . "users set 
            password = '" . md5(mysql_escape_string($new_password)) . "'
            WHERE id = '" . $row_data['id'] . "'";
            $result = mysql_query($sql);
            if (!$result) {
                $message = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $sql;
                $this->err = $message;
            } else {
                $to = $row_data['email'];
                $body = "Hi, <br />Your password alteady reset.<br />
                        New password : " . $new_password . "
                        <p>Best Regards </p> ";
                mail($to, $sub, $body, $headers);
                $this->Success = $this->app->lang['CHANGE_PASS_DONE'];
            }
        } else {
            $this->err = $this->app->lang['ERR_CHANGE_PASS'];
        }
    }

//Public user logout
    public function logout() {
        session_destroy();
        header('Location: index.php');
    }

}
