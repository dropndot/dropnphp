<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class search {

    private $app;
    public $total_result = 0;
    public $serch_result = array();

    public function __construct($app) {
        $this->app = $app;
    }

    public function get_search($data) {
        $search_str = $data['search_key'];
        if ($data['site_search'] == 'Site Search') {
            $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "pages WHERE (title LIKE '%$search_str%' || description LIKE '%$search_str%') AND status = 'active'"; //OR title LIKE '%$search_str%' OR title LIKE '%$search_str'";

            $result = mysql_query($sql);
            $this->total_result += mysql_numrows($result);

            $index = 0;
            while ($row = mysql_fetch_assoc($result)) {
                $this->serch_result['pages'][$index] = $row;
                $index++;
            }

            $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "articles WHERE (title LIKE '%$search_str%' || description LIKE '%$search_str%') AND status = 'active'";

            $result = mysql_query($sql);
            $this->total_result += mysql_numrows($result);

            $index = 0;
            while ($row = mysql_fetch_assoc($result)) {
                $this->serch_result['articles'][$index] = $row;
                $index++;
            }

            $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "events WHERE (title LIKE '%$search_str%' || description LIKE '%$search_str%') AND status = 'active'";

            $result = mysql_query($sql);
            $this->total_result += mysql_numrows($result);

            $index = 0;
            while ($row = mysql_fetch_assoc($result)) {
                $this->serch_result['events'][$index] = $row;
                $index++;
            }
            $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "offers WHERE (title LIKE '%$search_str%' || description LIKE '%$search_str%') AND status = 'active'";

            $result = mysql_query($sql);
            $this->total_result += mysql_numrows($result);

            $index = 0;
            while ($row = mysql_fetch_assoc($result)) {
                $this->serch_result['offers'][$index] = $row;
                $index++;
            }

            return $this->serch_result;
        }
        if ($data['submit'] == 'Submit') {
            $where = 'where ';
            if (!empty($data['district'])) {
                $where.= "district = '" . $data['district'] . "' AND ";
            }
            if (!empty($data['thana'])) {
                $where.= "thana = '" . $data['thana'] . "' AND ";
            }
            if (!empty($data['address'])) {
                $address = '%' . $data['address'] . '%';
                $where.= "address like '$address' AND ";
            }
            $where.= " status = 'active'";
 
            $sql = "SELECT * FROM " . $this->app->config['db_prefix'] . "dealer $where"; 
            $result = mysql_query($sql);
            $this->total_result += mysql_numrows($result);

            $index = 0;
            while ($row = mysql_fetch_assoc($result)) {
                $this->serch_result['dealer'][$index] = $row;
                $index++;
            }
            return $this->serch_result;
        }
    }

    /**
     * latter_search
     * 
     * return all data of a given table & pagination string
     * 
     * parameter $tbl_name takes tabel name as a string, $limit takes pagination limit as an integer, $path takes pagination 
     * path as a string, $status takes status of the data to view as a string
     * 
     * return a string of pagination
     * */
    function latter_search($tbl_left_name, $limit, $search, $post_type, $path) {

        $clause = "WHERE ($tbl_left_name.status = 'active' && $tbl_left_name.post_type != '$post_type' && $tbl_left_name.title LIKE '$search%')";

        $query = "SELECT COUNT(*) as num FROM $tbl_left_name $clause";
        //echo $query . '<br />';
        $row = mysql_fetch_array(mysql_query($query));
        $total_pages = $row['num'];
        $adjacents = "2";

        $page = (int) (!isset($_GET["page_no"]) ? 1 : $_GET["page_no"]);
        $page = ($page == 0 ? 1 : $page);

        if ($page)
            $start = ($page - 1) * $limit;
        else
            $start = 0;
        $sql = "SELECT $tbl_left_name.* FROM $tbl_left_name $clause 
            order by $tbl_left_name.id desc LIMIT $start, $limit";

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

?>
