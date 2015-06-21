<?php
$connection = mysql_connect('localhost', 'root', '');
mysql_select_db("dubai_shopping_mall", $connection);

if (!empty($_GET['q']) && $_GET['q'] == 'page') {
    $sql = "SELECT * FROM dnp_pages WHERE status = 'active' ORDER BY title ASC";
    $result = mysql_query($sql);
    $index = 0;
    while ($row = mysql_fetch_assoc($result)) {
        $page_list[$index] = $row;
        $index++;
    }
}
if (!empty($_GET['q']) && $_GET['q'] == 'category') {
    $sql = "SELECT * FROM dnp_categories WHERE status = 'active' ORDER BY title ASC";
    $result = mysql_query($sql);
    $index = 0;
    while ($row = mysql_fetch_assoc($result)) {
        $cat_list[$index] = $row;
        $index++;
    }
    $sql = "SELECT * FROM dnp_pages WHERE status = 'active' ORDER BY title ASC";
    $result = mysql_query($sql);
    $index = 0;
    while ($row = mysql_fetch_assoc($result)) {
        $page_list[$index] = $row;
        $index++;
    }
}
?>
<?php
if ($_GET['q'] == 'page') {
    ?><p>
        <label>Pages:</label>
        <select name="url" class="medium">
            <?php
            foreach ($page_list as $key => $values) {
                ?>
                <option value="<?= $values['id'] ?>" <?php
        if (!empty($_POST['url']) && ($values['id'] == $_POST['url'])) {
            echo "selected='selected'";
        }
                ?>><?= $values['title'] ?></option>
                        <?php
                    }
                    ?>
        </select>
    </p>
<?php } ?>
<?php
if ($_GET['q'] == 'category') {
    ?>
    <p>
        <label>Categories:</label>
        <select name="url" class="medium">
            <?php
            foreach ($cat_list as $key => $values) {
                ?>
                <option value="<?= $values['id'] ?>" <?php
        if (!empty($_POST['url']) && ($values['id'] == $_POST['url'])) {
            echo "selected='selected'";
        }
                ?>><?= $values['title'] ?></option>
                        <?php
                    }
                    ?>
        </select>
    </p>
<?php } ?>
<?php
if ($_GET['q'] == 'url') {
    ?>
    <p>
        <label>URL:</label>
        <input class="medium" type="text" name="url" value="<?= !empty($_POST['url']) ? $_POST['url'] : '' ?>">
    </p>
<?php } ?>
