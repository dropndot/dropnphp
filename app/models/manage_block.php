<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class manage_block {

    private $app;
    var $err;
    var $paging_data;
    var $page_no;
    var $page_status;
    var $block_id;

    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * insert_data
     * 
     * takes data from block form and insert data in block table
     * 
     * parameter $data an arrey submitted from block form
     * 
     * return true for a successful insertion
     * 
     * return false in error  
     * */
    public function insert_data($data, $block_id = null) {

        $created = date('Y-m-d H:i:s');
        $modified = date('Y-m-d H:i:s');


        $identifier = $data['title'];
        $identifier = strtolower($identifier);
        $identifier = str_replace(' ', '-', $identifier);

        $description = addslashes($data['description']);

        if (mysql_query("INSERT INTO " . $this->app->config['db_prefix'] . "blocks (block_area_id, title, identifier, description, block_type, ordering, status, created, modified) VALUES ('" . $data['block_area_id'] . "', '" . $data['title'] . "', '" . $identifier . "', '" . $description . "', '" . $data['block_type'] . "', '" . $data['ordering'] . "', '" . $data['status'] . "', '" . $created . "', '" . $modified . "')")) {

            return true;
        } else {
            $this->err = mysql_error();
            return false;
        }
    }

    /**
     * update_data
     * 
     * takes data from block update form and update data in block table
     * 
     * parameter $data an arrey submitted from block update form
     * 
     * return true for a successful update
     * 
     * return false in error  
     * */
    public function update_data($data, $block_id = null) {
        $modified = date('Y-m-d H:i:s');
//        $identifier = $data['title'];
//        $identifier = strtolower($identifier); 
//        $identifier = str_replace(' ','-',$identifier);

        $description = addslashes($data['description']);

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "blocks set  
        block_area_id='" . $data['block_area_id'] . "',
        title='" . $data['title'] . "',
        description='" . $description . "',
        ordering='" . $data['ordering'] . "',
        status='" . $data['status'] . "',
        modified='" . $modified . "'
        WHERE id='" . $data['id'] . "'";

        if (mysql_query($sql)) {
            if (($data['block_area_id'] != $block_id) && !empty($block_id)) {
                $this->block_id = $data['block_area_id'];
            } else {
                $this->block_id = $block_id;
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
     * update status in block table
     * 
     * parameter $data an arrey of block id 
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

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "blocks SET
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
     * parameter $id takes id of a block and return all data for the id from block table to admin_edit page
     * 
     * return an arrey of data
     * 
     * return false in error  
     * */
    public function get_row($id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "blocks where id=$id";
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
     * parameter $id takes id of a block and delet all data for that id to trash
     * 
     * return true for a successful delet
     * 
     * return false in error  
     * */
    public function delete_trash($id) {
        $sql = "UPDATE " . $this->app->config['db_prefix'] . "blocks SET
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
     * parameter $id takes id of a block and permanently delet all data for that id
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
     * get_id_block_area
     * 
     * return id and title of block_area
     * 
     * no parameter
     * 
     * return array of id & title
     * 
     * return false in error  
     * */
    public function get_id_block_area() {
        $sql = "SELECT id, title from " . $this->app->config['db_prefix'] . "block_area order by title asc";
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

        $this->block_id = $tbl_right_id;
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

        $sql = "SELECT $tbl_left_name.*, $tbl_right_name.title as block_area_title FROM 
    $tbl_left_name LEFT JOIN $tbl_right_name 
    ON $tbl_left_name.block_area_id = $tbl_right_name.id $clause 
    order by $tbl_left_name.ordering asc LIMIT $start, $limit";
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
                $pagination.= "<a href='" . $path . "page=$next'>next >></a>";
            else
                $pagination.= "<span class='disabled'>next >></span>";
            $pagination.= "</div>";
        }


        return $pagination;
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

}

?>