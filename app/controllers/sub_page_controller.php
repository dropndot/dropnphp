<?php
class sub_page_controller extends appcontroller {
    var $additionalController = array('pages', 'news_management', 'product', 'product_item', 'organizer_management');
    /*public $router;
    
    public function __construct( $app ) {
        
        
        parent::__construct($app);
        
        
        
    } */
    
    public function index(){
        /*********Common Veriabls*********/
        $this->beforeLoadFrontEnd();   
        /*********Common Veriabls*********/
        if(isset($_REQUEST['page'])){
            $p_ident = $_REQUEST['page'];
        }
        else{
            $p_ident = 'home';
        }
        $this->app->view->page_title = $this->app->pages->get_title($p_ident);
        $this->app->view->page_content = $this->app->pages->get_page_content($p_ident); 
        $this->app->view->display('index');        
    }
    
    public function article(){
        /*********Common Veriabls*********/
        $this->beforeLoadFrontEnd();   
        /*********Common Veriabls*********/
        $this->app->view->page_title = $this->app->pages->article_title($_REQUEST['aid']);
        $this->app->view->article_desc = $this->app->pages->article_desc($_REQUEST['aid']);
        $this->app->view->display('article');
        
    }
    
    
    
}
?>