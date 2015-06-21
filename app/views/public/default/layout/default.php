<?php require_once 'header.php'; ?>
<!--headerWrap-->        
<?php
if (!empty($_REQUEST['controller']) && $_REQUEST['controller'] == 'error') {
    require_once 'sub_banner.php';
    require_once 'sub_page.php';
} else {
    if (!empty($_REQUEST['page'])) {
        require_once 'sub_banner.php';
    } else {
        require_once 'banner.php';
    }
    ?>
    <!--banner-->
    <?php
    if (!empty($_REQUEST['page'])) {
        require_once 'sub_page.php';
    } else {
        require_once 'home.php';
    }
}
?>
<!--home mainbody-->      
<?php require_once 'footer.php'; ?>       