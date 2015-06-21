<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class articles {

    private $app;
    var $err;
    var $paging_data;
    var $page_no;
    var $page_status;
    var $test_data;

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

        $created = date('Y-m-d H:i:s');
        $modified = date('Y-m-d H:i:s');

        $identifier = $data['title'];
        $identifier = strtolower($identifier);
        $identifier = str_replace(' ', '-', $identifier);

        $description = addslashes($data['description']);

		$file_name = '';
        if (!empty($_FILES['article_image']['name'])) {
            $upload_address = BASE . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'articles' . DS;
            $file_name = time() . '_' . basename($_FILES['article_image']['name']);
            $upload_file = $upload_address . $file_name;

            if (move_uploaded_file($_FILES['article_image']['tmp_name'], $upload_file)) {
                if (mysql_query("INSERT INTO " . $this->app->config['db_prefix'] . "articles (category_id, title, identifier, description, photo, meta_key, meta_desc, ordering, featured, created, modified, status) 
                    VALUES ('" . $data['category_id'] . "', '" . addslashes($data['title']) . "', '" . $identifier . "', '" . $description . "', '" . $file_name . "', '" . addslashes($data['meta_key']) . "', '" . addslashes($data['meta_desc']) . "',
                        '" . $data['ordering'] . "', '" . $data['featured'] . "', '" . $created . "', '" . $modified . "', '" . $data['status'] . "')")) {
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
            if (mysql_query("INSERT INTO " . $this->app->config['db_prefix'] . "articles (category_id, title, identifier, description, photo, meta_key, meta_desc, ordering, featured, created, modified, status) 
                VALUES ('" . $data['category_id'] . "', '" . addslashes($data['title']) . "', '" . $identifier . "', '" . $description . "', '" . $file_name . "', '" . addslashes($data['meta_key']) . "', '" . addslashes($data['meta_desc']) . "',
                        '" . $data['ordering'] . "', '" . $data['featured'] . "', '" . $created . "', '" . $modified . "', '" . $data['status'] . "')")) {
                return true;
            } else {
                $this->err = mysql_error();
                return false;
            }
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
        $identifier = $data['title'];
        $identifier = strtolower($identifier);
        $identifier = str_replace(' ', '-', $identifier);
        $description = addslashes($data['description']);
        if (!empty($_FILES['article_image']['name'])) {
            $sql = "SELECT photo FROM " . $this->app->config['db_prefix'] . "articles WHERE id = " . $data['id'];
            $result = mysql_query($sql);
            $row = mysql_fetch_assoc($result);
            $old_img = BASE . 'app' . DS . 'resources' . DS . 'document' . DS . 'articles' . DS . $row['photo'];

            $upload_address = BASE . DS . 'app' . DS . 'resources' . DS . 'document' . DS . 'articles' . DS;
            $file_name = time() . '_' . basename($_FILES['article_image']['name']);
            $upload_file = $upload_address . $file_name;
            if (move_uploaded_file($_FILES['article_image']['tmp_name'], $upload_file)) {
                $sql = "UPDATE " . $this->app->config['db_prefix'] . "articles set
                        category_id='" . $data['category_id'] . "', 
                        title='" . addslashes($data['title']) . "',
                        identifier='" . $identifier . "',
                        description='" . $description . "',                        
                        photo='" . $file_name . "', 
                        meta_key='" . addslashes($data['meta_key']) . "',
                        meta_desc='" . addslashes($data['meta_desc']) . "',
                        ordering='" . $data['ordering'] . "',                        
                        featured='" . $data['featured'] . "',
                        status='" . $data['status'] . "',
                        modified='" . $modified . "'
                        WHERE id='" . $data['id'] . "'";

                if (mysql_query($sql)) {
                    @unlink($old_img);
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
            $sql = "UPDATE " . $this->app->config['db_prefix'] . "articles set
            category_id='" . $data['category_id'] . "', 
            title='" . addslashes($data['title']) . "',
            identifier='" . $identifier . "',
            description='" . $description . "', 
            meta_key='" . addslashes($data['meta_key']) . "',
            meta_desc='" . addslashes($data['meta_desc']) . "',
            ordering='" . $data['ordering'] . "',           
            featured='" . $data['featured'] . "',
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

        $status = strtolower($data['change_status']);

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "articles SET
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
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "articles where id=$id";
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
        $sql = "UPDATE " . $this->app->config['db_prefix'] . "articles SET
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
     * get_id_categories
     * 
     * no parameter
     * 
     * return id & title of all categories from categories table in an array $return_data
     * 
     * return false in error  
     * */
    public function get_id_categories() {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "categories WHERE status = 'active' order by title asc";
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
     * of left table in the limit passed by the integer type variable $limit, $path and $status is string
     * 
     * return a string of pagination
     * 
     * */
    public function paging($tbl_left_name, $tbl_right_name, $limit, $path, $c_id, $status = null) {
        $clause = null;
        $page_status = $status;
        if ($status != null && $status == 'active') { 
            if (!empty($c_id)) { 
                $clause = "WHERE ($tbl_left_name.category_id = $tbl_right_name.id && ($tbl_left_name.status = 'active' OR $tbl_left_name.status = 'inactive') && ($tbl_right_name.status = 'active' && $tbl_left_name.category_id = '$c_id'))";
            } else {
                $clause = "WHERE ($tbl_left_name.category_id = $tbl_right_name.id && ($tbl_left_name.status = 'active' OR $tbl_left_name.status = 'inactive') && ($tbl_right_name.status = 'active'))";
            }
        } else {
            if (!empty($c_id)) {
                $clause = "WHERE ($tbl_left_name.category_id = $tbl_right_name.id && ($tbl_left_name.status = '$status') && ($tbl_right_name.status = 'active') && ($tbl_left_name.category_id = '$c_id'))";
            } else {
                $clause = "WHERE ($tbl_left_name.category_id = $tbl_right_name.id && ($tbl_left_name.status = '$status') && ($tbl_right_name.status = 'active'))";
            }
        }
        $query = "SELECT COUNT(*) as num FROM $tbl_left_name,$tbl_right_name $clause";
        //echo $clause;
        $row = mysql_fetch_array(mysql_query($query));
        $total_pages = $row['num'];
        $adjacents = "2";

        $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
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
     * featute_article_status
     * 
     * update status in article table
     * 
     * parameter $data an arrey of article id 
     * 
     * return true for a successful update
     * 
     * return false in error  
     * */
    public function featute_article_status($st, $id) {

        $sql = "UPDATE " . $this->app->config['db_prefix'] . "articles SET featured = '" . $st . "' WHERE id = $id";
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
     * get_post_content
     * 
     * no parameter
     * 
     * return id & title of all categories from categories table in an array $return_data
     * 
     * return false in error  
     * */
    public function get_post_content($id, $post_type) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "articles WHERE (post_type = '$post_type' && id = '$id' AND status = 'active')";
        $result = mysql_query($sql);
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
     * get_archive_post_content
     * 
     * no parameter
     * 
     * return id & title of all categories from categories table in an array $return_data
     * 
     * return false in error  
     * */
    public function get_archive_post_content($id, $post_type) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "articles WHERE (post_type = '$post_type' && id = '$id' AND status = 'archive')";
        $result = mysql_query($sql);
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
     * get_post_gallery
     * 
     * no parameter
     * 
     * return id & title of all categories from categories table in an array $return_data
     * 
     * return false in error  
     * */
    public function get_post_gallery($id) {
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "manage_photo WHERE (gallery_id = '$id' && status = 'active')";
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
     * get_paging_data
     * 
     * return all data of a given table & pagination string
     * 
     * parameter $tbl_name takes tabel name as a string, $limit takes pagination limit as an integer, $path takes pagination 
     * path as a string, $status takes status of the data to view as a string
     * 
     * return a string of pagination
     * */
    function get_paging_data($tbl_name, $search, $limit, $path, $post_type, $id) {
        if (!empty($id)) {
            if (!empty($search)) {
                $clause = "WHERE (id = $id && post_type = '$post_type' && status = 'active') && (title LIKE '%$search%')";
            } else {
                $clause = "WHERE (id = $id && post_type = '$post_type' && status = 'active')";
            }
        } else {
            if (!empty($search)) {
                $clause = "WHERE (post_type = '$post_type' && status = 'active')&& (title LIKE '%$search%')";
            } else {
                $clause = "WHERE (post_type = '$post_type' && status = 'active')";
            }
        }

        $query = "SELECT COUNT(*) as num FROM $tbl_name $clause";
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

        $sql = "SELECT * FROM $tbl_name $clause order by id desc LIMIT $start, $limit";

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
            $pagination .= "";
            if ($page > 1)
                $pagination.= "<a title='Previous' id='prev' href='" . $path . "page_no=$prev'>Previous</a>";
            else
                $pagination.= "<a title='Previous' id='prev' href='javascript:(volid)' class='disabled'>Previous</a>";

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
                    $pagination.= "...";
                    $pagination.= "<a href='" . $path . "page_no=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='" . $path . "page_no=$lastpage'>$lastpage</a>";
                }elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination.= "<a href='" . $path . "page_no=1'>1</a>";
                    $pagination.= "<a href='" . $path . "page_no=2'>2</a>";
                    $pagination.= "...";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<<a href='javascript:(volid)' class='activePage'>$counter</a>";
                        else
                            $pagination.= "<a href='" . $path . "page_no=$counter'>$counter</a>";
                    }
                    $pagination.= "..";
                    $pagination.= "<a href='" . $path . "page_no=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='" . $path . "page_no=$lastpage'>$lastpage</a>";
                }else {
                    $pagination.= "<a href='" . $path . "page_no=1'>1</a>";
                    $pagination.= "<a href='" . $path . "page_no=2'>2</a>";
                    $pagination.= "..";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<a href='javascript:(volid)' class='activePage'>$counter</a>";
                        else
                            $pagination.= "<a href='" . $path . "page_no=$counter'>$counter</a>";
                    }
                }
            }

            if ($page < $counter - 1)
                $pagination.= "<a title='Next' id='next' href='" . $path . "page_no=$next'>Next</a>";
            else
                $pagination.= "<a title='Next' id='next' href='javascript:(volid)' class='disabled'>Next</a>";
            $pagination.= "";
        }


        return $pagination;
    }

    /**
     * offer_paging
     * 
     * return all data of a given table & pagination string
     * 
     * parameter $tbl_name takes tabel name as a string, $limit takes pagination limit as an integer, $path takes pagination 
     * path as a string, $status takes status of the data to view as a string
     * 
     * return a string of pagination
     * */
    function offer_paging($tbl_name, $limit, $post_type, $current_date, $path) {

        $clause = "WHERE (status = 'active' && ((start_date <= '$current_date' && end_date >= '$current_date') && post_type = '$post_type')) || category_id = '8'";

        $query = "SELECT COUNT(*) as num FROM $tbl_name $clause";
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
        $sql = "SELECT * FROM $tbl_name $clause order by id desc LIMIT $start, $limit";
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
                    $pagination.= "...";
                    $pagination.= "<a href='" . $path . "page_no=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='" . $path . "page_no=$lastpage'>$lastpage</a>";
                }elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination.= "<a href='" . $path . "page_no=1'>1</a>";
                    $pagination.= "<a href='" . $path . "page_no=2'>2</a>";
                    $pagination.= "...";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<<a href='javascript:(volid)' class='activePage'>$counter</a>";
                        else
                            $pagination.= "<a href='" . $path . "page_no=$counter'>$counter</a>";
                    }
                    $pagination.= "..";
                    $pagination.= "<a href='" . $path . "page_no=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='" . $path . "page_no=$lastpage'>$lastpage</a>";
                }else {
                    $pagination.= "<a href='" . $path . "page_no=1'>1</a>";
                    $pagination.= "<a href='" . $path . "page_no=2'>2</a>";
                    $pagination.= "..";
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

    /**
     * offer_list_catwise
     * 
     * return all data of a given table & pagination string
     * 
     * parameter $tbl_name takes tabel name as a string, $limit takes pagination limit as an integer, $path takes pagination 
     * path as a string, $status takes status of the data to view as a string
     * 
     * return a string of pagination
     * */
    function offer_list_catwise($tbl_name, $limit, $c_id, $current_date, $post_type, $path) {
        if ($c_id == '8') {
            $clause = "WHERE (status = 'active' && post_type = '$post_type' && category_id = '8')";
        } else {
            $clause = "WHERE (status = 'active' && ((start_date <= '$current_date' && end_date >= '$current_date') && post_type = '$post_type')) && category_id = '$c_id'";
        }
        //$clause = "WHERE status = 'active' && post_type = '$post_type' && category_id = '$c_id'";
        $query = "SELECT COUNT(*) as num FROM $tbl_name $clause";
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

        $sql = "SELECT * FROM $tbl_name $clause order by title LIMIT $start, $limit";

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
                    $pagination.= "...";
                    $pagination.= "<a href='" . $path . "page_no=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='" . $path . "page_no=$lastpage'>$lastpage</a>";
                }elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination.= "<a href='" . $path . "page_no=1'>1</a>";
                    $pagination.= "<a href='" . $path . "page_no=2'>2</a>";
                    $pagination.= "...";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<<a href='javascript:(volid)' class='activePage'>$counter</a>";
                        else
                            $pagination.= "<a href='" . $path . "page_no=$counter'>$counter</a>";
                    }
                    $pagination.= "..";
                    $pagination.= "<a href='" . $path . "page_no=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='" . $path . "page_no=$lastpage'>$lastpage</a>";
                }else {
                    $pagination.= "<a href='" . $path . "page_no=1'>1</a>";
                    $pagination.= "<a href='" . $path . "page_no=2'>2</a>";
                    $pagination.= "..";
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

    /**
     * get_events
     * 
     * no parameter
     * 
     * return id & title of all categories from categories table in an array $return_data
     * 
     * return false in error  
     * */
    public function get_events() {
        $current_date = date('Y-m-d');
        $where = '';
        $where = "WHERE ((status = 'active' && (start_date <= '$current_date' && end_date >= '$current_date')) || 
        (status = 'active' && start_date > '$current_date' && end_date > '$current_date'))";
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "events $where";
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
     * get_offers
     * 
     * no parameter
     * 
     * return id & title of all categories from categories table in an array $return_data
     * 
     * return false in error  
     * */
    public function get_offers() {
        $current_date = date('Y-m-d');
        $where = '';
        $where = "WHERE ((status = 'active' && (start_date <= '$current_date' && end_date >= '$current_date')) || 
        (status = 'active' && start_date > '$current_date' && end_date > '$current_date'))";
        $sql = "SELECT * from " . $this->app->config['db_prefix'] . "offers $where";
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

}