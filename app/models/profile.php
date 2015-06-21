<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class profile {

    private $app;
    var $err;
    var $paging_data;
    var $page_no;
    var $page_status;

    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * get_row
     *
     * parameter $id takes id of an category and return all data for the id from category table to admin_edit page
     * 
     * return true for a successful selection of data
     * 
     * return false in error  
     * */
    public function get_row($id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "users where (status = 'active' && id=$id)";
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
     * update_data
     * 
     * takes data from category update form and update data in category table
     * 
     * parameter $data an arrey submitted from category update form
     * 
     * return true for a successful update
     * 
     * return false in error  
     * */
    public function update_data($data) {
        $modified = date('Y-m-d H:i:s');
//        if ($data['username']) {
//            $username = $data['username'];
//        } else {
//            $username = $data['old_username'];
//        }
        if ($data['password']) {
            $password = md5($data['password']);
        } else {
            $password = $data['old_password'];
        }
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
        $sql = "UPDATE " . $this->app->config['db_prefix'] . "users set 
                    name='" . $data['name'] . "',
                    location='" . $data['location'] . "',
                    email='" . $data['email'] . "',
                    password='" . $password . "',
                    phone='" . $data['phone'] . "',
                    details='" . $data['details'] . "',
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
     * insert_data
     * 
     * takes data from category form and insert data in category table
     * 
     * parameter $data an arrey submitted from category form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function insert_data($data) {

        $modified = date('Y-m-d H:i:s');

        if (!empty($_FILES['banner_img']['name'])) { //check blank image field
            $upload_address = BASE . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'banner_management' . DS;
            $file_name = time() . basename($_FILES['banner_img']['name']);
            $upload_file = $upload_address . $file_name;
            $type = $_FILES['banner_img']['type'];

            list($width, $height) = getimagesize($_FILES['banner_img']['tmp_name']); //Get image height width

            if (is_image($file_name) && ($width > 664 && $height > 319)) { //Check image & height,width
                if (move_uploaded_file($_FILES['banner_img']['tmp_name'], $upload_file)) {
                    $thmb_file = $upload_address . 'thmb' . DS . $file_name;

                    switch ($type) {
                        case 'image/gif':
                            $img = imagecreatefromgif($upload_file);
                            break;
                        case 'image/jpeg':
                            $img = imagecreatefromjpeg($upload_file);
                            break;
                        case 'image/png':
                            $img = imagecreatefrompng($upload_file);
                            break;
                    }
                    $width = imagesx($img);
                    $height = imagesy($img);
                    $tmp_img = imagecreatetruecolor(661, 316);
                    imagecopyresized($tmp_img, $img, 0, 0, 0, 0, 661, 316, $width, $height);
                    imagejpeg($tmp_img, $thmb_file);

                    $identifier = $data['title'];
                    $identifier = strtolower($identifier);
                    $identifier = str_replace(' ', '-', $identifier);


                    if (mysql_query("INSERT INTO " . $this->app->config['db_prefix'] . "banner_management (title, identifier, photo, ordering, status, created, modified) VALUES ('" . $data['title'] . "', '" . $identifier . "', '" . $file_name . "', '" . $data['ordering'] . "', '" . $data['status'] . "', '" . $created . "', '" . $modified . "')")) {
                        return true;
                    } else {
                        $this->err = mysql_error();
                        return false;
                    }
                } else {
                    $this->err = 'File upload Error, Please try again later.';
                    return false;
                }
            } else {
                $this->err = 'Please Upload an image file ( jpg, jpeg, gif, png ) & minimum dimension 665x320.';
                return false;
            }
        } else {
            $this->err = 'Please Select an image for Banner.';
            return false;
        }
    }

    /**
     * update_status
     * 
     * update status in category table
     * 
     * parameter $data an arrey of category id 
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

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "banner_management SET
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
     * delete_trash
     * 
     * parameter $id takes id of an category and delet all data for that id to trash
     * 
     * return true for a successful delet
     * 
     * return false in error  
     * */
    public function delete_trash($id) {
        $sql = "UPDATE " . $this->app->config['db_prefix'] . "banner_management SET
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
     * parameter $id takes id of an category and permanently delet all data for that id
     * 
     * return true for a successful delet
     * 
     * return false in error  
     * */
    public function delete_row($id) {
        $sql = "DELETE from " . $this->app->config['db_prefix'] . "banner_management where id=$id";
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
        } else {
            $clause = "WHERE status = '$status'";
        }
        $query = "SELECT COUNT(*) as num FROM $tbl_name $clause";
        $row = mysql_fetch_array(mysql_query($query));
        $total_pages = $row['num'];
        $adjacents = "2";

        $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
        $page = ($page == 0 ? 1 : $page);

        if ($page)
            $start = ($page - 1) * $limit;
        else
            $start = 0;

        $sql = "SELECT * FROM $tbl_name $clause order by ordering asc LIMIT $start, $limit";
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

}

?>
