<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $site_title; ?> :: <?php echo $this->app->settings['site_title']; ?></title>
		<?php if(!empty($this->app->settings['favicon_icon'])){?>
		<link rel="icon" type="image/png" href="<?php echo 'app/resources/document/settings/' . $this->app->settings['favicon_icon']; ?>">
		<?php }?>
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_root ?>layout/css/admin.css">
            <script type="text/javascript" language="javascript" src="<?php echo $theme_root ?>resources/js/jquery-1.4.2.min.js"></script>
            <script type="text/javascript" language="javascript" src="<?php echo $theme_root ?>resources/js/custom.js"></script>
            <script type="text/javascript" language="javascript" src="<?php echo $theme_root ?>resources/js/ajax/ajax.js"></script>
            <script type="text/javascript" language="javascript" src="<?php echo $theme_root ?>resources/js/control.js"></script>
            <!--date picker -->
            <link rel="stylesheet" type="text/css" href="<?php echo $theme_root ?>resources/date-picker/jquery-ui.css" />   
            <script type="text/javascript" language="javascript" src="<?php echo $theme_root ?>resources/date-picker/jquery.ui.core.js"></script>
            <script type="text/javascript" language="javascript" src="<?php echo $theme_root ?>resources/date-picker/jquery.ui.datepicker.js"></script>
            <!--date picker -->
            <!-- TinyMCE -->
            <script type="text/javascript" language="javascript" src="<?php echo $theme_root ?>resources/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
            <script type="text/javascript">
                tinyMCE.init({
                    // General options
                    mode : "specific_textareas",
                    editor_selector : "mceEditor",
                    theme : "advanced",
                    plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

                    // Theme options
                    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_toolbar_align : "left",
                    theme_advanced_statusbar_location : "bottom",
                    theme_advanced_resizing : true,

                    // Example content CSS (should be your site CSS)
                    content_css : "css/content.css",

                    // Drop lists for link/image/media/template dialogs
                    template_external_list_url : "lists/template_list.js",
                    external_link_list_url : "lists/link_list.js",
                    external_image_list_url : "lists/image_list.js",
                    media_external_list_url : "lists/media_list.js",
        
                    convert_urls : false,

                    // Style formats
                    style_formats : [
                        {title : 'Bold text', inline : 'b'},
                        {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
                        {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
                        {title : 'Example 1', inline : 'span', classes : 'example1'},
                        {title : 'Example 2', inline : 'span', classes : 'example2'},
                        {title : 'Table styles'},
                        {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
                    ],

                    // Replace values for the template plugin
                    template_replace_values : {
                        username : "Some User",
                        staffid : "991234"
                    }
                });
            </script>
            <!-- /TinyMCE -->
    </head>
    <body>
        <div class="headwrap">
            <div id="header">
                <div class="logoblock-content">
				<?php if(!empty($this->app->settings['site_logo'])){?>
                    <a target="_blank" class="ddlogo" href="<?php echo BASE_URL ; ?>">
					<img style="max-width:130px;" src="app/resources/document/settings/<?php echo $this->app->settings['site_logo'];?>" alt="admin logo" />
					</a>
					<?php }else{?>
                    <p style="float: none;" class="ddlogo-textcontent"><?php echo $this->app->settings['site_title']; ?></p>
					<?php }?>
                </div>

                <div class="sitelink">
                    <a target="_blank" href="<?php echo BASE_URL ; ?>">Visit Site</a>
                </div>
                <div class="search-pannel">
                    <form id="search-form">
                        <h2><?php echo $this->app->settings['site_title']; ?> admin panel</h2>
                    </form>
                </div>
                <div class="userinfo">
				<?php if(!empty($admin_login_data['profile_image'])){?>
                    <span style="width: 30px; height: 30px; display: block; float: left; margin: 0 4% 0 0;">
                        <img style="max-width: 100%; width: auto; height: auto;" class="useravater" src="app/resources/document/users/<?php echo $admin_login_data['profile_image']; ?>" alt="<?php echo $admin_login_data['name']; ?>" />
                    </span>
					<?php } ?>
                    <div class="date-name">
                        <p class="today-date"><?php echo date('Y, F d'); ?></p><br />
                        <p class="username"><b><?php echo $admin_login_data['name']; ?></b></p>
                    </div>
                    <a href="index.php?controller=login&amp;action=logout" class="logout"><?php echo $LOGOUT; ?></a>
                </div>
            </div>
        </div>
