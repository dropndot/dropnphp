<section class="page-content">
		<div class="container">
            <div class="row">				
				 <div class="col-sm-8 col-md-8 left-content about-page">
					<?php include($display_view_file); ?>
				 </div>	
				 <?php
                if ($layout == 'yes') {
                    require_once 'right_sidebar.php';
                }
                ?>
			</div>
		</div>
	 </section>