<?php
if( ! defined( '_VALIDACCESS' ) ) { die( 'Sorry to say, you can not access this page on this way!' ); }

class app {
    
    private $vars = array();
    
    function __construct(){

        if( is_file( APP . 'config' . DS . 'config.php' ) ) {
            require_once( APP . 'config' . DS . 'config.php' );
            if( ! isset( $config ) || ! is_array( $config ) ) {
                header( 'Location: install.php?choice' );
            } else {
                $this->config = $config;
            }
        } else {
            header( 'Location: install.php?choice' );
            exit;
        }
        
        
        $connect = mysql_connect( $this->config['db_host'], $this->config['db_user'], $this->config['db_pass'] ) or die('Could not connect: ' . mysql_error());
        mysql_select_db( $this->config['db_name'], $connect ) or die ('Can\'t use ' . $this->config['db_name'] . ' : ' . mysql_error());

        
        $rs_settings = mysql_query( "SELECT * FROM " . $this->config['db_prefix'] . "settings" ) or die( 'Can not load data from ' . $this->config['db_prefix'] . 'settings : ' . mysql_error() );
        $ar_settings = array();
        while ($row = mysql_fetch_assoc($rs_settings)) {
            $ar_settings[$row['set_key']]=$row['value'];
        }
        mysql_free_result($rs_settings);

        $this->settings = $ar_settings;
        
        
        require_once( APP . 'includes' . DS . 'lang' . DS . $this->settings['site_lang'] . '.php' );
        $this->lang = $lang;
        
    }
    
    function __set( $index, $value ){
        $this->vars[$index] = $value;
    }

    function __get( $index ){
        return $this->vars[$index];
    }
}
