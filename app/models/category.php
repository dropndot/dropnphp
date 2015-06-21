<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class category {

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
     * takes data from category form and insert data in category table
     * 
     * parameter $data an arrey submitted from category form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function insert_data($data) {

        $created = date('Y-m-d H:i:s');
        $modified = date('Y-m-d H:i:s');

        $identifier = $data['title'];
        $identifier = strtolower($identifier);
        $identifier = str_replace(' ', '-', $identifier);

        $sql = "SELECT identifier from " . $this->app->config['db_prefix'] . "categories where identifier='" . $identifier . "'";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
        if (empty($row)) {
            if (mysql_query("INSERT INTO " . $this->app->config['db_prefix'] . "categories (title, identifier, description, post_type, meta_key, meta_desc, ordering, status, created, modified) VALUES ('" . $data['title'] . "', '" . $identifier . "', '" . $data['description'] . "', '" . $data['post_type'] . "', '" . $data['meta_key'] . "', '" . $data['meta_desc'] . "', '" . $data['ordering'] . "', '" . $data['status'] . "', '" . $created . "', '" . $modified . "')")) {
                return true;
            } else {
                $this->err = mysql_error();
                return false;
            }
        } else {
            $this->err = 'This title already exist. Please try again with different title.';
        }
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
        $identifier = $data['title'];
        $identifier = strtolower($identifier);
        $identifier = str_replace(' ', '-', $identifier);

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "categories set 
        title='" . $data['title'] . "',
        identifier='" . $identifier . "',
        ordering='" . $data['ordering'] . "',
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

        $status = strtolower($data['change_status']);

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "categories SET
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
     * parameter $id takes id of an category and return all data for the id from category table to admin_edit page
     * 
     * return true for a successful selection of data
     * 
     * return false in error  
     * */
    public function get_row($id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "categories where id=$id";
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
     * parameter $id takes id of an category and delet all data for that id to trash
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
     * delete_row
     * 
     * parameter $id takes id of an category and permanently delet all data for that id
     * 
     * return true for a successful delet
     * 
     * return false in error  
     * */
    public function delete_row($id) {
        $sql = "DELETE from " . $this->app->config['db_prefix'] . "categories where id=$id";
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
            $clause = "WHERE (status = 'active' OR status = 'inactive')";
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

    /**
     * cat_title
     *
     * parameter $id takes id of an category and return all data for the id from category table to admin_edit page
     * 
     * return true for a successful selection of data
     * 
     * return false in error  
     * */
    public function cat_title($id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "categories where id=$id";
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
     * data_list
     * 
     * parameter $tbl_left_name, $tbl_right_name are string, takes two table name and make left join and return all data 
     * of left table in the limit passed by the integer type variable $limit, $path and $status is string
     * 
     * return a string of pagination
     * 
     * */
    public function data_list($tbl_left_name, $tbl_right_name, $limit, $c_id, $path) {
        $clause = '';
        $clause = "WHERE $tbl_left_name.category_id = $tbl_right_name.id && ($tbl_left_name.status = 'active' && $tbl_right_name.status = 'active') && ($tbl_left_name.category_id = '$c_id')";

        $query = "SELECT COUNT(*) as num FROM $tbl_left_name,$tbl_right_name $clause";
        //echo $query.'<br />';
        $row = mysql_fetch_array(mysql_query($query));
        $total_pages = $row['num'];
        $adjacents = "2";

        $page = (int) (!isset($_GET["page_no"]) ? 1 : $_GET["page_no"]);
        $page = ($page == 0 ? 1 : $page);

        if ($page)
            $start = ($page - 1) * $limit;
        else
            $start = 0;

        $sql = "SELECT $tbl_left_name.*, $tbl_right_name.title as category_title FROM $tbl_left_name,$tbl_right_name $clause 
        order by $tbl_left_name.ordering asc LIMIT $start, $limit";


        $result = mysql_query($sql);
        if (!$result) {
            $this->err = mysql_error();
            return false;
        }
        //print_r($result);
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
                $pagination.= "<a class='prev' href='" . $path . "page_no=$prev'>&lt;&lt; Previous</a>";
            else
                $pagination.= "<a href='javascript:(volid)' class='disabled'>&lt;&lt; Previous</a>";

            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<a href='javascript:(volid)' class='activePage'>$counter</a>";
                    else
                        $pagination.= "<a href='" . $path . "page_no=$counter'>$counter</a>";
                }
            }elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page)
                            $pagination.= "<a href='javascript:(volid)' class='activePage'>$counter</a>";
                        else
                            $pagination.= "<a href='" . $path . "page_no=$counter'>$counter</a>";
                    }
                    $pagination.= "<span class='disabled'>...</span>";
                    $pagination.= "<a href='" . $path . "page_no=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='" . $path . "page_no=$lastpage'>$lastpage</a>";
                }elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination.= "<a href='" . $path . "page_no=1'>1</a>";
                    $pagination.= "<a href='" . $path . "page_no=2'>2</a>";
                    $pagination.= "<span class='disabled'>...</span>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<a href='javascript:(volid)' class='activePage'>$counter</a>";
                        else
                            $pagination.= "<a href='" . $path . "page_no=$counter'>$counter</a>";
                    }
                    $pagination.= "<span class='disabled'>..</span>";
                    $pagination.= "<a href='" . $path . "page_no=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='" . $path . "page_no=$lastpage'>$lastpage</a>";
                }else {
                    $pagination.= "<a href='" . $path . "page_no=1'>1</a>";
                    $pagination.= "<a href='" . $path . "page_no=2'>2</a>";
                    $pagination.= "<span class='disabled'>..</span>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<a href='javascript:(volid)' class='activePage'>$counter</a>";
                        else
                            $pagination.= "<a href='" . $path . "page_no=$counter'>$counter</a>";
                    }
                }
            }

            if ($page < $counter - 1)
                $pagination.= "<a class='next' href='" . $path . "page_no=$next'>Next &gt;&gt;</a>";
            else
                $pagination.= "<a href='javascript:(volid)' class='disabled'>Next &gt;&gt;</a>";
            $pagination.= "</div>";
        }


        return $pagination;
    }

}
