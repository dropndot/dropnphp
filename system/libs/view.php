<?php
if( ! defined( '_VALIDACCESS' ) ) { die( 'Sorry to say, you can not access this page on this way!' ); }

class view {

    private $app;
    
    public $vars = array();
    
    public function __construct( $app ) {
        $this->app = $app;
    }
    
    public function __set( $index, $value ) {
        $this->vars[$index] = $value;
    }
    
    public function display( $file = null ) {
        
        $backtrace = debug_backtrace();
            
        if(empty($file)){
            $action = $backtrace[1]['function'];   
        } else {
            $action = $file;
        }
        
        if(!empty($backtrace[1]['object']->view)) {
            $controller_view = $backtrace[1]['object']->view;    
        } else {
            $controller_view = str_replace('_controller', '', $backtrace[1]['class']);  
        }
        
        
        if(!empty($backtrace[1]['object']->layout)) {
            $controller_layout = $backtrace[1]['object']->layout;    
        } else {
            $controller_layout = 'default';  
        }
        
        
        
        $theme = $this->vars['public_theme'];
        if(empty($theme)){
            $theme='default';
        }
        
        

        
        if( $this->app->session->get_var('user_type') == 'admin' && $this->app->router->admin=='yes' && $controller_layout!='error'){
            $theme='default';
            $theme_folder = 'admin';
        } else {
            $theme_folder = 'public';
        }
        
        $theme_root             = APP . 'views' . DS . $theme_folder . DS . $theme . DS;
        $theme_root = str_replace('\\', '/', $theme_root);
        
        
        
        if( is_dir( $theme_root ) == false ) {
            $err = array('err'=>'Theme Error: No theme directory found : ' . $theme_root);
            $this->app->session->add_var( $err );
            header('Location: index.php?controller=error');
            exit;
        }
        
        $display_layout_file    = $theme_root . 'layout' . DS . $controller_layout . '.php';
        $display_view_file      = $theme_root . $controller_view . DS . $action . '.php';
        
        
        if( file_exists( $display_layout_file ) == false ) {
            $err = array('err'=>'Layout Error: No layout file found in ' . $display_layout_file);
            $this->app->session->add_var( $err );
            header('Location: index.php?controller=error');
            exit;
        } 
    
        if( file_exists( $display_view_file ) == false ) {
            $err = array('err'=>'View Error: No view file found in ' . $display_view_file);
            $this->app->session->add_var( $err );
            header('Location: index.php?controller=error');
            exit;
        }
    
        /**
        * 
        * Setting current all template or view variables(Array) to view as unique or individual variable
        * 
        */
        foreach ( $this->vars as $k => $v ) {
            $$k = $v;
        }
    
        
        require_once( $display_layout_file );     
        exit;        
    }
}
