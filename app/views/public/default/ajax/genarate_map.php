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
    $id = $_GET['q'];
    $sql = "SELECT * FROM dnp_show_room WHERE id = '$id'";
    $result = mysql_query($sql);
    $row = mysql_fetch_assoc($result);
}
if (!empty($row)) {
    ?>
    <div id="em-location-data">
        <div id="location_coordinates" style="display: none;">
            <input id="location-latitude" name="location_latitude" value="0" size="15" type="text">
            <input id="location-longitude" name="location_longitude" value="0" size="15" type="text">
        </div>

        <table style="display: none;" class="em-location-data">
            <tbody>
                <tr>
                    <th>Location Name:</th>
                    <td>
                        <input id="location-id" name="location_id" value="<?php echo $row['id']; ?>" size="15" type="hidden">
                        <input aria-haspopup="true" value="<?php echo $row['title']; ?>" aria-autocomplete="list" role="textbox" autocomplete="off" class="ui-autocomplete-input" id="location-name" name="location_name" type="text"><i>*</i>													
                        <br><em>Create a location or start typing to search a previously created location.</em>
                        <p id="em-location-reset" style="display:none;"><em>You cannot edit saved locations here. <a href="#">Reset this form to create a location.</a></em></p>
                    </td>
                </tr>
                <tr>
                    <th>Address:&nbsp;</th>
                    <td>
                        <input id="location-address" name="location_address" type="text" value="<?php echo $row['address']; ?>"><i>*</i>			</td>
                </tr>
                <tr>
                    <th>City/Town:&nbsp;</th>
                    <td>
                        <input id="location-town" name="location_town" value="<?php echo $row['thana']; ?>" type="text"><i>*</i>			</td>
                </tr>
                <tr>
                    <th>State/County:&nbsp;</th>
                    <td>
                        <input id="location-state" value="<?php echo $row['district']; ?>" name="location_state" type="text">
                    </td>
                </tr>
                <tr>
                    <th>Postcode:&nbsp;</th>
                    <td>
                        <input id="location-postcode" name="location_postcode" type="text">
                    </td>
                </tr>
                <tr>
                    <th>Region:&nbsp;</th>
                    <td>
                        <input id="location-region" value="<?php echo $row['division']; ?>" name="location_region" type="text">
                    </td>
                </tr>
                <tr>
                    <th>Country:&nbsp;</th>
                    <td>
                        <select id="location-country" name="location_country">
                            <option selected="selected" value="BD">Bangladesh</option>

                        </select><i>*</i>			
                    </td>
                </tr>
            </tbody>
        </table>    
    </div>
<?php } ?>
