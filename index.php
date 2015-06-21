<?php
/**
*
* cCMS v 1.2.2
* 
* @package cCMS
* @file index.php
* @created 09-May-2011 (beginning from here)
* @last modified: 
* @author: musicalsaif@gmail.com
* @homepage: www.cCMS.com
* */

error_reporting(E_ALL);
ini_set('display_errors', 1);
define( '_VALIDACCESS', 1 );
/*define( 'DS', DIRECTORY_SEPARATOR );*/
define( 'DS', '/' );
define( 'BASE', dirname(__FILE__) . DS );
define( 'APP', 'app' . DS );
define( 'SYSTEM', 'system' . DS );
define('THEME', APP.'views'.DS.'public'.DS);
define('ADMINTHEME', APP.'views'.DS.'admin'.DS);

require_once ( BASE .DS.'system'.DS.'libraries.php' );


require_once ( APP . 'models' . DS . 'user.php');
require_once ( APP . 'models' . DS . 'accounts.php');
require_once ( APP . 'models' . DS . 'category.php');
require_once ( APP . 'models' . DS . 'articles.php');
require_once ( APP . 'models' . DS . 'pages.php');
require_once ( APP . 'models' . DS . 'block_area.php');
require_once ( APP . 'models' . DS . 'manage_block.php');
require_once ( APP . 'models' . DS . 'default_setting.php');
require_once ( APP . 'models' . DS . 'menus.php');
require_once ( APP . 'models' . DS . 'menu_item.php');
require_once ( APP . 'models' . DS . 'media.php');
require_once ( APP . 'models' . DS . 'backup.php');
require_once ( APP . 'models' . DS . 'banner_management.php');
require_once ( APP . 'models' . DS . 'profile.php');  
require_once ( APP . 'models' . DS . 'role_user.php');  
require_once ( APP . 'models' . DS . 'newslatter.php');  


$app             = new app;
$app->router     = new router( $app );
$app->session    = new session( $app );

/**
*
* loading framework system class view for templating
* */
$app->view       = new view( $app ); 



//loading application models here
$app->user           = new user( $app );
$app->accounts       = new accounts($app);
$app->category       = new category( $app );
$app->articles       = new articles($app);
$app->pages          = new pages($app);
$app->block_area     = new block_area($app);
$app->manage_block   = new manage_block($app);
$app->default_setting = new default_setting($app);
$app->menus          = new menus($app);
$app->menu_item      = new menu_item($app);
$app->media          = new media($app);
$app->backup          = new backup($app);
$app->banner_management = new banner_management($app);
$app->profile = new profile($app); 
$app->role_user = new role_user($app);
$app->newslatter = new newslatter($app);

//End of application models loading

$app->router->load();


?>