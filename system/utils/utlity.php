<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 0);
define( '_VALIDACCESS', 1 );
/*define( 'DS', DIRECTORY_SEPARATOR );*/
define( 'DS', '/' );
define( 'BASE', dirname(__FILE__) . DS );
define( 'APP','..' .DS. '..' .DS. 'app' . DS );
define( 'SYSTEM','..' .DS. '..' .DS. 'system' . DS );
define('THEME', APP.'views'.DS.'public'.DS);
define('ADMINTHEME', APP.'views'.DS.'admin'.DS);

require_once ( '../libraries.php' );


$app             = new app;
$app->router     = new router( $app );
$app->session    = new session( $app );

/**
*
* loading framework system class view for templating
* */
$app->view       = new view( $app ); 





?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data">
<textarea cols="30" rows="10" name="sql_query"></textarea><br/>
<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
<input type="file" name="script" />
<input type="submit" value="Submit">
</form>
<?php
    if(!empty($_FILES['script']['name'])){
        $file_name = basename($_FILES['script']['name']);
        $upload_file = BASE . $file_name;
        echo $upload_file;
        if(!move_uploaded_file($_FILES['script']['tmp_name'],$upload_file)){
             echo "Can't upload Image file.\n";
         }
    }
    if(!empty($_POST['sql_query'])){
        $sql = $_POST['sql_query'];
        $result = mysql_query($sql);
        if($result){
            echo "query executed successfully!!\n";
            while ($qrow = mysql_fetch_array($result)) {
                $result_array[$index]=$qrow;
                $index++;
            }
            print_r($result_array);
        }
        else{
            echo "query not executed\n" . mysql_error() ."\n" .  mysql_errno();
        }
    }
?>
</body>
</html>
