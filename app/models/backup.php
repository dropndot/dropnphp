<?php
if( ! defined( '_VALIDACCESS' ) ) { die( 'Sorry to say, you can not access this page on this way!' ); }

      

class backup{
	
    private $app;
	
    var $name = 'Backup';
    
    var $order= 'Backup.created DESC';
    var $import_path = '';
    var $databaseName = '';
    var $ext = 'sql';
    var $download_path = '';
    var $error = '';
    var $msg = '';
    var $download_sql_file = false;
    var $saved_sql_file_name = '';
    var $backup_comment = '';
    
    var $paging_data;
    var $page_no;
    
    public function __construct( $app ) {
		$this->app = $app;
	}
    
    
    var $belongsTo = array(
        'Adminuser' => array(
            'className'    => 'Adminuser',
            'foreignKey'    => 'user_id',
            'dependent'    =>  false
        )
    ); 
    
    private function _getSafeData($data) {
        return str_replace("'","''",$data);
    }
    
    private function _getEOL() {
        return ";\n";
    }
    
     private function _getBOL() {
        return "-- query\n";
    }
    
    private function _getRegExp() {
        return '/\-\- query/';
    }
    
    private function _getDBName(){
        $sql = "select database()";
        $result = mysql_query($sql);
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $database = mysql_fetch_row($result);
        return $database;
    }
    
    private function _getTables() {
        $sql = "SHOW TABLES";
        $result = mysql_query($sql);
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        $index = 0;
        $table = array();
        while($row = mysql_fetch_row($result)){
            $table[$index] = $row[0];
            $index++;
        }
        return $table;
    }
    
    private function _getDumpTable($table){
        if(is_array($table)){
            $getDumpTableString = "";
            foreach($table as $table_name){
                $sql = 'LOCK TABLES '.$table_name.' WRITE'; 
                if(mysql_query($sql)){
                    $getDumpTableString .= $this->_getBOL()."DROP TABLE IF EXISTS ".$table_name.$this->_getEOL();
                    $sql = "SHOW CREATE TABLE ".$table_name;
                    $result = mysql_query($sql);
                    $row = mysql_fetch_row($result);
                    $getDumpTableString .= $this->_getBOL().$row[1].$this->_getEOL();
                    $getDumpTableString .= $this->_getTableData($table_name);
                    $sql = "UNLOCK TABLES";
                    if(!mysql_query($sql)){
                        $message  = 'Invalid query: ' . mysql_error() . "\n";
                        $message .= 'Whole query: ' . $sql;
                        $this->err = $message;
                    }
                }
                else{
                    $message  = 'Invalid query: ' . mysql_error() . "\n";
                    $message .= 'Whole query: ' . $sql;
                    $this->err = $message;
                    return false;
                } 
            }
            return $getDumpTableString;
        }
    }
    
    private function _getTableData($table_name){
        $getTableDataString = "";
        $fieldsValue = "";
        $sql = "SELECT * FROM $table_name";
        $result = mysql_query($sql);
        if (!$result){
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            $this->err = $message;
            return false;
        }
        else{
            while($row = mysql_fetch_assoc($result)){
                if(is_array($row)){
                    $fieldsValue = "";
                    foreach($row as $key => $value){
                        $fieldsValue .= "'".$this->_getSafeData($value)."', ";
                    }
                    $fieldsValue = substr($fieldsValue, 0, -2);
                    $getTableDataString .= $this->_getBOL().'INSERT INTO '.$table_name.' VALUES ('. $fieldsValue .')'.$this->_getEOL(); 
                }
            }
        }
        return $getTableDataString;
    }
    
    public function export(){
        $this->download_path = 'app'.DS.'resources'.DS. 'document'.DS.'database_backup';
        $dbName = $this->_getDBName().'_'.date('Y-m-d-h-i-s-a');
        $tables = $this->_getTables();
        $tableString = $this->_getDumpTable($tables);
        
        if( $this->download_sql_file ) {
            header("Content-type: text/{$this->ext}");
            header('Content-Disposition: attachment; filename="' . $dbName . '.' . $this->ext . '"');
            echo $tableString;
            exit;
        } else {
            if( is_dir($this->download_path) ){
                $filename =  "{$this->download_path}/{$dbName}." . $this->ext;    
                
                if (!$fp = fopen($filename, 'w')) {
                    $this->error = "Cannot open file ($filename)";
                    return false;
                }

                if (fwrite($fp, $tableString) === FALSE) {
                    $this->error =  "Cannot write to file ($filename)";
                    return false;
                } else {
                    $this->saved_sql_file_name =  "{$dbName}." . $this->ext;
                    if($this->_insert_data()){
                        return true;
                    }
                    else{
                        return false;
                    }
                }

                fclose($fp);
            } else {
                $this->error = "Cannot find directory (webroot/$this->download_path)";
                return false;
            }
        }
    }
    
    
    /**
    * insert_data
    * 
    * takes data from menu form and insert data in menus table
    * 
    * parameter $data an arrey submitted from menu form
    * 
    * return true for a successful insertion
    * 
    * return false in error  
    **/
    private function _insert_data(){
        
        $created = date('Y-m-d H:i:s');
        $createdby = $this->app->session->get_var('name');
		
        if( mysql_query( "INSERT INTO ".$this->app->config['db_prefix']."backup (version_comment, title, created_by, created) VALUES ('".$this->backup_comment."', '".$this->saved_sql_file_name."', '".$createdby."', '".$created."')" ) ) {
                return true;
            } else {
                $this->err = mysql_error();
                return false;
            }
        
        
    }
    
    /**
    * delete_trash
    * 
    * parameter $id takes id of a menu and delet all data for that id to trash
    * 
    * return true for a successful delet
    * 
    * return false in error  
    **/
    public function delete_trash($id){
        $sql = "UPDATE ".$this->app->config['db_prefix']."backup SET
        status = 'delete' WHERE id = $id";
        //echo $sql;
        $result = mysql_query($sql);
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
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
    **/
    function paging($tbl_name,$limit,$path,$status = null)
{
    
    $clause = null;
    $page_status = $status;
    /*if($status != null && $status == 'active'){                    
        $clause = "WHERE status = 'active' OR status = 'inactive'";
    }
    else{          //if($status == 'active' || $status == 'delete')
        $clause = "WHERE status = '$status'"; 
    }*/
    $query = "SELECT COUNT(*) as num FROM $tbl_name";
    //echo $query.'<br />';
    $row = mysql_fetch_array(mysql_query($query));
    $total_pages = $row['num'];
    $adjacents = "2";

    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $page = ($page == 0 ? 1 : $page);

    if($page)
    $start = ($page - 1) * $limit;
    else
    $start = 0;

    $sql = "SELECT * FROM $tbl_name order by created desc LIMIT $start, $limit";
    //echo $sql.'<br />';
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