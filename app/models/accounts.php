<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class accounts {

    private $app;
    var $err;
    var $paging_data;
    var $page_no;
    var $page_status;

    public function __construct($app) {
        $this->app = $app;
    }

    public function count_pages() {
        $count_pages = '';
        $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "pages WHERE status = 'active'";
        $result = mysql_query($sql);
        if ($result)
            $count_pages = mysql_num_rows($result);
        return $count_pages;
    }

    public function count_categories() {
        $count_categories = '';
        $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "categories WHERE status = 'active'";
        $result = mysql_query($sql);
        if ($result)
            $count_categories = mysql_num_rows($result);
        return $count_categories;
    }

    public function count_articles() {
        $count_articles = '';
        $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "articles WHERE status = 'active'";
        $result = mysql_query($sql);
        if ($result)
            $count_articles = mysql_num_rows($result);
        return $count_articles;
    }

    public function count_blocks() {
        $count_blocks = '';
        $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "blocks WHERE status = 'active'";
        $result = mysql_query($sql);
        if ($result)
            $count_blocks = mysql_num_rows($result);
        return $count_blocks;
    }

    public function count_menus() {
        $count_menus = '';
        $sql = "SELECT title FROM " . $this->app->config['db_prefix'] . "menus WHERE status = 'active'";
        $result = mysql_query($sql);
        if ($result)
            $count_menus = mysql_num_rows($result);
        return $count_menus;
    } 
}

?>