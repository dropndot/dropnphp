<?php

class search_controller extends appcontroller {

    var $additionalController = array('pages', 'banner_management', 'product_item', 'news_management', 'product', 'organizer_management');
    var $page_title = '';

    public function show_result($result) {
        $string = '';
        if (isset($result['categories'])) {
            $string .= '<ul>
                        <li>Categories</li>
                            <ul>';
            $index = 0;
            foreach ($result['categories'] as $key => $value) {
                $string .= '<li>
                            <a href="' . $this->app->settings['site_url'] . 'index.php?controller=categories' . '&page=' . $value[$index]['identifier'] . '">' .
                        $value[$index]['title'] . '</a></li>';
                $index++;
            }
        }
    }

    public function index() {

        $this->beforeLoadFrontEnd();

        /*         * ******Common Veriabls******** */

        if (isset($_REQUEST['page'])) {
            $p_ident = $_REQUEST['page'];
        } else {
            $p_ident = 'home';
        }
        if (!empty($_POST['submit'])) {
            if (!empty($_POST['district']) || !empty($_POST['thana']) || !empty($_POST['address'])) {
                $search_result = $this->app->search->get_search($_POST);
                $this->app->view->dealer_list = $search_result;
            } else {
                $this->app->view->search_result_error = "Please enter your different search key again.";
            }
        }
        $this->app->view->total_result = $this->app->search->total_result;
        $this->app->view->search_result_error = "No item found. Please again with different search key.";
        $this->app->view->page_title = 'Search';

        $this->app->view->display('index');
    }

    public function lsearch() {
        $this->beforeLoadFrontEnd();

        /*         * ******Common Veriabls******** */

        if (!empty($_REQUEST['alpha'])) {
            $search = $_REQUEST['alpha'];
        }
        $post_type = 'news';
        $url = 'index.php?controller=search&page=search&action=lsearch&alpha=' . $search . '&';
        $paging_string = $this->app->search->latter_search($this->app->config['db_prefix'] . "articles", $this->app->settings['public_page_factor'], $search, $post_type, $url);
        $search_result = $this->app->search->paging_data;
        $this->app->view->search_result = $search_result;
        $this->app->view->paging = $paging_string;
        $this->app->view->page_title = 'Search';

        $this->app->view->display('lsearch');
    }

}

?>
