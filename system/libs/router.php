<?php

if (!defined('_VALIDACCESS')) {
    die('Sorry to say, you can not access this page on this way!');
}

class router {

    public $app;
    public $args = array();
    public $file;
    public $controller;
    public $action;
    public $value;
    public $page;
    public $admin;
    public $additional_obj;
    public $controllerFile;
    public $additional_class = array();

    //public $test = array('key' => 'value', 'key1' => 'value1');

    public function __construct($app) {
        $this->app = $app;
    }

    public function load() {

        $this->load_controller_file();



        if (!is_file($this->file)) {
            $err = 'Requested controller ' . $this->file . ' is not available';
            $this->file = APP . 'controllers' . DS . 'error_controller.php';
            $this->controller = 'error';
        }



        require_once( $this->file );
        $class = $this->controller . '_controller';
        $controller = new $class($this->app);



        //Loading all controller classes in a router variables
        if (isset($controller->additionalController)) {
            $this->additional_obj[$this->controller] = $controller;
            foreach ($controller->additionalController as $key => $value) {
                $this->controllerFile = APP . 'controllers' . DS . $value . '_controller.php';
                if (is_file($this->controllerFile)) {
                    require_once( $this->controllerFile );
                    $this->additional_class = $value . '_controller';
                    $this->additional_obj[$value] = new $this->additional_class($this->app);
                }
            }
        }


        if (!is_callable(array($controller, $this->action))) {
            $action = 'index';
        } else {
            $action = $this->action;
        }


        if (!empty($err)) {
            $err = array('err' => $err);
            $this->app->session->add_var($err);
            header('Location: index.php?controller=error');
            exit;
        }



        if ($this->controller == 'error' && $this->admin == 'yes' && strpos($action, 'admin_')) {
            $action = 'index';
        }



        $controller->$action();
    }

    public function load_controller_file() {

        $URI = $_SERVER['REQUEST_URI'];
        if (strpos($URI, 'admin')) {
            $_GET['admin'] = 'yes';
            $this->admin = ( isset($_GET['admin']) ? $_GET['admin'] : 'yes' );
            $this->controller = ( isset($_GET['controller']) ? $_GET['controller'] : 'accounts' );
        } else {
            $this->controller = ( isset($_GET['controller']) ? $_GET['controller'] : 'pages' );
        }


        $this->action = ( isset($_GET['action']) ? $_GET['action'] : 'index' );


        if ($this->app->session->get_var('user_type') == 'admin' && $this->admin == 'yes') {
            $this->action = 'admin_' . $this->action;
        } elseif ($this->admin == 'yes') {
            header('Location: ../index.php?controller=login');
            exit;
        }

        $this->value = ( isset($_GET['id']) ? $_GET['id'] : 'index' );
        $this->page = ( isset($_GET['page']) ? $_GET['page'] : 1 );

        $this->file = APP . 'controllers' . DS . $this->controller . '_controller.php';
    }

}
