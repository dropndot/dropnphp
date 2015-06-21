<?php

class login_controller extends appcontroller {

    var $layout = 'login';

    //Admin Login
    function index() { 
        if (!empty($_COOKIE['user_id']))
            $admin_user_id = $_COOKIE['user_id'];

        if (!empty($_COOKIE['user_type']))
            $admin_user_type = $_COOKIE['user_type'];

        if (!empty($admin_user_id) && !empty($admin_user_type)) {
            $this->app->session->add_var(array('user_id' => $admin_user_id, 'user_type' => $admin_user_type));
            if ($_SESSION) {
                session_regenerate_id(true);
            }
			if($admin_user_type == 'subscriber'){
            header('Location: index.php?controller=sub_page&page=about');
            exit;
			}
			if($admin_user_type == 'admin'){
				header('Location: admin/index.php?controller=accounts');
				exit;
			}
			}
        $logged_in_user = $this->app->session->get_var('user_type');
        if (!empty($logged_in_user) && $logged_in_user == 'subscriber') {
            header('Location: index.php?controller=sub_page&page=about');
            exit;
			}
			if (!empty($logged_in_user) && $logged_in_user == 'admin') {
				header('Location: admin/index.php?controller=accounts');
				exit;
			}
        if (!empty($_POST)) {
            $remember_pass = '';
            if (!empty($_POST['passremembar'])) {
                $remember_pass = $_POST['passremembar'];
            }
            $login_data = $this->app->user->login($_POST['username'], $_POST['password'], $remember_pass);
            $this->app->view->login_err = $login_data;
        }
        $this->app->view->page_title = 'Admin Login';
        $this->app->view->display();
    }

    //Forgot admin password
    function forgot_pass() {
        if (!empty($_POST)) {
            $this->app->user->forgot_password($_POST['email']);
            if (empty($this->app->user->err)) {
                $this->app->view->forgot_pass_success = $this->app->user->Success;
            } else {
                $this->app->view->forgot_pass_err = $this->app->user->err;
            }
        }
        $this->app->view->site_title = 'Forgot Password';
        $this->app->view->display('forgot');
    }

    //Admin logout
    function admin_logout() {
        session_destroy();
        setcookie("user_id", '', time() + (3600 * 24 * 3), '/dropnphp/');
        setcookie("user_type", '', time() + (3600 * 24 * 3), '/dropnphp/');
        header('Location: index.php?controller=login');
        exit;
    }
	//Subscriber logout
    function logout() {
        session_destroy();
        setcookie("user_id", '', time() + (3600 * 24 * 3), '/dropnphp/');
        setcookie("user_type", '', time() + (3600 * 24 * 3), '/dropnphp/');
        header('Location: index.php?controller=login');
        exit;
    }

}