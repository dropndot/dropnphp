<?php

class profile_controller extends appcontroller {   

    public function admin_index() {

        if (!empty($_POST['submit'])) {   //Form submitted
            $err = '';
            if (empty($err) && empty($_POST['name']))
                $err = 'Name field can not be blank.';

            if (empty($err)) {    //Form valid
                $this->app->profile->update_data($_POST);
                if (empty($this->app->profile->err)) {
                    $this->app->view->msg = 'Profile has updated successfully.';
                    $this->app->view->row = $this->app->profile->get_row($_REQUEST['id']);
                } else {
                    $this->app->view->err = $this->app->profile->err;
                    $this->app->view->row = $this->app->profile->get_row($_REQUEST['id']);
                }
            } else {
                $this->app->view->row = $this->app->profile->get_row($_REQUEST['id']);
                $this->app->view->err = $err;
            }
        } else {
            $row = $this->app->profile->get_row($_REQUEST['id']);
            if (empty($this->app->profile->err)) {
                $this->app->view->row = $row;
            } else {
                $this->app->view->row = $row;
                $this->app->view->err = $this->app->profile->err;
            }
        }

        $this->app->view->site_title = 'Profile';

        $this->app->view->display('admin_index');
    }   

    public function index() {
        echo 'default category index...';
        $this->app->view->site_title = 'Profile';
        $this->app->view->display();
    }

}

?>