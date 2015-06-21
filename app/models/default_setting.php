<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class default_setting {

    private $app;
    var $err;
    var $paging_data;
    var $page_no;
    var $page_status;

    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * insert_data
     * 
     * takes data from default_setting form and insert data in setting table
     * 
     * parameter $data an arrey submitted from default_setting form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function insert_data($data) {

        if (!empty($data['type'])) {
            $type = $data['type'];
        } else {
            $type = 'text';
        }
        if ($type == 'text') {
            $set_val = $data['set_txt_value'];
        }
        if ($type == 'textarea') {
            $set_val = $data['set_txtarea_value'];
        }
        if (!empty($_FILES['image']['name'])) {
            $upload_address = BASE . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'settings' . DS;
            $file_name = time() . basename($_FILES['image']['name']);
            $set_val = $file_name;
            $upload_file = $upload_address . $file_name;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
                $this->err = "Can't upload Image file.";
            }
        }
        $component = "core";

        if (mysql_query("INSERT INTO " . $this->app->config['db_prefix'] . "settings (set_key, value, type, component) VALUES ('" . $data['set_key'] . "', '" . $set_val . "', '" . $type . "', '" . $component . "')")) {
            return true;
        } else {
            $this->err = mysql_error();
            return false;
        }
    }

    /**
     * update_data
     * 
     * takes data from default_setting update form and update data in setting table
     * 
     * parameter $data an arrey submitted from default_setting update form
     * 
     * return true for a successful update
     * 
     * return false in error  
     * */
    public function update_data($data) {

        if (!empty($data['type'])) {
            $type = $data['type'];
        } else {
            $type = 'text';
        }
        if ($type == 'text') {
            $set_val = $data['set_txt_value'];
        }
        if ($type == 'textarea') {
            $set_val = $data['set_txtarea_value'];
        }

        if (!empty($_FILES['image']['name'])) {
            $sql = "SELECT * from " . $this->app->config['db_prefix'] . "settings where id='" . $data['id'] . "'";
            $result = mysql_query($sql);
            $row = mysql_fetch_assoc($result);
            $old_img_url = BASE . 'app/resources/document/settings/' . $row['value'];

            $upload_address = BASE . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'settings' . DS;
            $file_name = time() . basename($_FILES['image']['name']);
            $set_val = $file_name;
            $upload_file = $upload_address . $file_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
                @unlink($old_img_url);
            } else {
                $this->err = "Can't upload Image file.";
            }
        } else {
            if ($type == 'image') {
                $set_val = $data['old_image'];
            }
        }

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "settings set
        value='" . $set_val . "'
        WHERE id='" . $data['id'] . "'";

        if (mysql_query($sql)) {
            return true;
        } else {
            $this->err = mysql_error() . "<br /> Query is : $sql";
            return false;
        }
    }

    /**
     * get_row
     *
     * parameter $id takes id of a setting and return all data for the id from setting table to admin_edit page
     * 
     * return an arrey of data
     * 
     * return false in error  
     * */
    public function get_row($id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "settings where id=$id";
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
     * parameter $id takes id of an default_setting and delet all data for that id to trash
     * 
     * return true for a successful delet
     * 
     * return false in error  
     * */
    public function delete_trash($id) {
        $sql = "UPDATE " . $this->app->config['db_prefix'] . "categories SET
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
     * paging
     * 
     * return all data of a given table & pagination string
     * 
     * parameter $tbl_name takes tabel name as a string, $limit takes pagination limit as an integer, $path takes pagination 
     * path as a string, $status takes status of the data to view as a string, $sort takes field name as a string to sort data
     * 
     * return a string of pagination
     * */
    function paging($tbl_name, $limit, $path, $status = null, $sort = null) {

        /* $clause = null;
          $page_status = $status;
          if($status != null && $status == 'active'){
          $clause = "WHERE status = 'active' OR status = 'inactive'";
          }
          else{          //if($status == 'active' || $status == 'delete')
          $clause = "WHERE status = '$status'";
          } */
        $query = "SELECT COUNT(*) as num FROM $tbl_name";
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

        if (!empty($sort)) {
            $sort = "order by $sort asc";
        } else {
            $sort = "order by id asc";
        }
		//Filter data
		if($this->app->session->get_var('group_id') == 2){
        $sql = "SELECT * FROM $tbl_name $sort LIMIT $start, $limit";
		}else{
        $sql = "SELECT * FROM $tbl_name WHERE (set_key != 'site_lang' && set_key != 'public_theme' && set_key != 'admin_site_logo' && set_key != 'admin_footer_copy_right_txt') $sort LIMIT $start, $limit";
		}
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
                $pagination.= "<a href='" . $path . "page=$prev'><< previous</a>";
            else
                $pagination.= "<span class='disabled'><< previous</span>";

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
                $pagination.= "<a href='" . $path . "page=$next'>next >></a>";
            else
                $pagination.= "<span class='disabled'>next >></span>";
            $pagination.= "</div>";
        }


        return $pagination;
    }

}

?>