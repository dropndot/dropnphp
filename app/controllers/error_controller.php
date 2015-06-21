<?php
if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class error_controller extends appcontroller {

    var $additionalController = array('pages', 'banner_management', 'product_item', 'news_management', 'product', 'organizer_management');
    var $page_title = '';
    //var $name = 'error';
//    var $view = 'error';
//    var $layout = 'error';

    function index() {
        /*********Common Veriabls*********/
        $this->beforeLoadFrontEnd();
        /*********Common Veriabls******** */
        $this->app->view->page_title = '404 Error';

        //$err = $this->app->session->get_var('err');
        //$this->set_err($err);
        $this->app->view->display('index');
    }

    public function set_err($msg) {
        $this->app->view->err = $msg;
    }

}