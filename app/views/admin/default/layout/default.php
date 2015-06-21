<?php require_once 'header.php'; ?>
<div id="wrap">
    <div id="mainbody">
        <div id="inner">
            <div id="contents-sidebar-wrap">
                <?php require_once 'sidebar.php'; ?>
                <!-- end #sidebar -->
                <div id="contentArea">
                    <?php
                    if ((!empty($_GET['controller']) &&  $_GET['controller'] == 'accounts') || empty($_GET['controller'])) { 
                        include($display_view_file);
                    } else {
                        ?>
                        <div class="adminContent">
                            <?php include($display_view_file); ?>            
                        </div>
                        <!-- contents -->
                    <?php } ?>
                </div>
            </div>
            <!-- end #contents-sidebar-wrap -->
        </div>
        <!-- end #inner -->		
    </div>
    <!-- end #mainbody -->
</div>
<!-- wrapper -->
<?php require_once 'footer.php'; ?>