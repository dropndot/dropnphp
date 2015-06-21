<?php
if( ! defined( '_VALIDACCESS' ) ) { die( 'Sorry to say, you can not access this page on this way!' ); }

class session {
    public $app;
    
    public function __construct( $app ) {
        session_start();
    }
    
    public function add_var( $vars ) {
        foreach( $vars as $k => $v ) {
            $_SESSION[$k] = $v;
        }
    }
    
    public function get_var( $name ) {
        if( isset( $_SESSION[$name] ) ) {
            return $_SESSION[$name];
        } else {
            return false;
        }
    }
}
