<?php

class accounts_controller extends appcontroller {

    public function admin_index() {
        //Permission start 
        $this->app->role_user->check_permission($this->dashboard, $this->permision_arr);
        //Permission end

        $this->app->view->count_pages = $this->app->accounts->count_pages();
        $this->app->view->count_categories = $this->app->accounts->count_categories();
        $this->app->view->count_articles = $this->app->accounts->count_articles();
        $this->app->view->count_block = $this->app->accounts->count_blocks();
        $this->app->view->count_menus = $this->app->accounts->count_menus();

        $this->app->view->site_title = 'Dash Board';
        $this->app->view->display('admin_index');
    }

    public function admin_warning() {
        $this->app->view->site_title = 'Access Warning';
        $this->app->view->err = $this->app->lang['INVALID_ACCESS'];
        $this->app->view->display('admin_warning');
    }

    public function index() {
        echo 'accounts index...';
        $this->app->view->site_title = 'account';
        $this->app->view->display();
    }

}