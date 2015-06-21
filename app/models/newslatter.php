<?php
if( ! defined( '_VALIDACCESS' ) ) { die( 'Sorry to say, you can not access this page on this way!' ); }
   

class newslatter{
	
    private $app;
	
    var $err;
    var $paging_data;
    var $page_no;
    var $page_status;
    
    public function __construct( $app ) {
		$this->app = $app;
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
    **/
    function paging($tbl_name,$limit,$path,$status){   
    $clause = null;
    $page_status = $status;
    if($status != null && $status == 'subscribe'){                    
        $clause = "WHERE status = 'subscribe' OR status = 'unsubscribe'";
    }
    else{          
        $clause = "WHERE status = '$status'"; 
    }
    $query = "SELECT COUNT(*) as num FROM $tbl_name $clause";
    $row = mysql_fetch_array(mysql_query($query));
    $total_pages = $row['num'];
    $adjacents = "2";

    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $page = ($page == 0 ? 1 : $page);

    if($page)
    $start = ($page - 1) * $limit;
    else
    $start = 0;

    $sql = "SELECT * FROM $tbl_name $clause order by id asc LIMIT $start, $limit";
    $result = mysql_query($sql);

    
    $return_data = array();
    $index = 0;
    while ($row = mysql_fetch_assoc($result)) {
        $return_data[$index]=$row;
        $index++;
    }
    
    $this->paging_data = $return_data; 
    $this->page_no = $page;
    
     
    $prev = $page - 1;
    $next = $page + 1;
    $lastpage = ceil($total_pages/$limit);
    $lpm1 = $lastpage - 1;

    $pagination = "";
    if($lastpage > 1)
    {   
    $pagination .= "<div class='pagination'>";
    if ($page > 1)
        $pagination.= "<a href='".$path."page=$prev'>&lt;&lt; previous</a>";
    else
        $pagination.= "<span class='disabled'>&lt;&lt; previous</span>";   
    
        if ($lastpage < 7 + ($adjacents * 2))
        {   
            for ($counter = 1; $counter <= $lastpage; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span class='current'>$counter</span>";
                else
                    $pagination.= "<a href='".$path."page=$counter'>$counter</a>";     
                         
            }
        }elseif($lastpage > 5 + ($adjacents * 2)){
        if($page < 1 + ($adjacents * 2)){
            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
            if ($counter == $page)
                $pagination.= "<span class='current'>$counter</span>";
            else
                $pagination.= "<a href='".$path."page=$counter'>$counter</a>";     
                         
            }
            $pagination.= "...";
            $pagination.= "<a href='".$path."page=$lpm1'>$lpm1</a>";
            $pagination.= "<a href='".$path."page=$lastpage'>$lastpage</a>";   
           
        }elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
            $pagination.= "<a href='".$path."page=1'>1</a>";
            $pagination.= "<a href='".$path."page=2'>2</a>";
            $pagination.= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
        {
        if ($counter == $page)
            $pagination.= "<span class='current'>$counter</span>";
        else
            $pagination.= "<a href='".$path."page=$counter'>$counter</a>";     
                     
        }
            $pagination.= "..";
            $pagination.= "<a href='".$path."page=$lpm1'>$lpm1</a>";
            $pagination.= "<a href='".$path."page=$lastpage'>$lastpage</a>";   
           
        }else{
            $pagination.= "<a href='".$path."page=1'>1</a>";
            $pagination.= "<a href='".$path."page=2'>2</a>";
            $pagination.= "..";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
        {
        if ($counter == $page)
            $pagination.= "<span class='current'>$counter</span>";
        else
            $pagination.= "<a href='".$path."page=$counter'>$counter</a>";     
                     
        }
        }
    }
    
    if ($page < $counter - 1)
        $pagination.= "<a href='".$path."page=$next'>next &gt;&gt;</a>";
    else
        $pagination.= "<span class='disabled'>next &gt;&gt;</span>";
        $pagination.= "</div>";       
    }


return $pagination;
}

}
?>
