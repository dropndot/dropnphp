<?php
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    $host = 'localhost';
    $db = 'cms_pedrollo';
    $dbuser = 'root';
    $pass = '';
} else {
    $host = 'localhost';
    $db = 'pedrollo_cms_pedrollo';
    $dbuser = 'pedrollo_ped1234';
    $pass = 'I3h4]+1Nr-tu';
}
$connection = mysql_connect($host, $dbuser, $pass);
mysql_select_db($db, $connection);

if (!empty($_GET['q'])) {
    $division = $_GET['q'];
    $sql = "SELECT * FROM dnp_dis_list WHERE division = '$division' ORDER BY name ASC";
    $result = mysql_query($sql);
    $index = 0;
    while ($row = mysql_fetch_assoc($result)) {
        $dis_list[$index] = $row;
        $index++;
    }
}
?>
<?php
foreach ($dis_list as $key => $values) {
    ?>
    <option value="<?= $values['name'] ?>" <?php if (!empty($_POST['district']) && $_POST['district'] == $values['name']) { ?> selected="selected" <?php } ?>><?= $values['name'] ?></option>
<?php } ?>
