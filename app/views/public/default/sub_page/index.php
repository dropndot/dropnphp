
<div class="content"> 
    <?php if ($page_content['identifier'] != 'home') { ?>
        <h1><?php echo stripslashes($page_title); ?></h1>
    <?php } ?>
    <?php echo stripslashes($page_content['description']) ?>
</div>
