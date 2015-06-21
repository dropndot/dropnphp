<?php

class contact_controller extends appcontroller {

    var $additionalController = array('pages', 'banner_management', 'product_item', 'news_management', 'product', 'organizer_management');
    var $page_title = '';
    /* public $router;

      public function __construct( $app ) {


      parent::__construct($app);



      } */

    public function index() {
        /*         * *******Common Veriabls******** */
        $this->beforeLoadFrontEnd();
        /*         * *******Common Veriabls******** */

        if (isset($_REQUEST['page'])) {
            $p_ident = $_REQUEST['page'];
        } else {
            $p_ident = 'home';
        }
        //print_r($_POST);exit;
        /*         * ********Contact form************** */
        // Get a key from https://www.google.com/recaptcha/admin/create
        $publickey = "6LdcGewSAAAAAEKJ__TkmoYuy-MDCLhyL3D7QWth";
        $privatekey = "6LdcGewSAAAAANE-v28PyCzSfGedvH7vVXAm1F7-";
        $this->app->view->publickey = "6LdcGewSAAAAAEKJ__TkmoYuy-MDCLhyL3D7QWth";
        $this->app->view->privatekey = "6LdcGewSAAAAANE-v28PyCzSfGedvH7vVXAm1F7-";

        # was there a reCAPTCHA response?
        if (!empty($_POST["recaptcha_response_field"])) {
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
        }
        if ($resp->is_valid) {
            $resp = true;
        } else {
            $resp = false;
        }
        if (!empty($_POST['submit'])) {
          
            $c_err = '';
            if (empty($err) && empty($_POST['name']))
                $c_err = 'Name field can not be blank.';

            elseif (empty($err) && empty($_POST['email']))
                $c_err = 'Email field can not be blank.';

            elseif (empty($err) && empty($_POST['msg']))
                $c_err = 'Massege field can not be blank.';

            elseif (!empty($_POST['email']) && !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['email']))
                $c_err = 'Your email address not valid.';

            elseif ($resp == false)
                $c_err = 'Rechapcha code is incorrect.';

            if (empty($c_err)) { //valid form
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $sub = $_POST['subject'];
                $msg = $_POST['msg'];
                $to = $this->app->settings['site_email'];
                if (empty($sub)) {
                    $sub = 'Contact Information';
                }
                $body = "Hi, <br />$name has request to contact with them providing the following information: <br />
                    Name : <strong>$name</strong> <br/> 
                    Email :<strong>$email</strong> <br/>       
                    Phone :<strong>$phone</strong> <br/>                  
                    Message : $msg <br/><br/>
                    Thanks <br/> ";
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $send_mail = mail($to, $sub, $body, $headers);
                if ($send_mail) {
                    $c_success = 'Mail send succesfully.';
                    $this->app->view->c_success = $c_success;
                } else {
                    $c_err = 'Unable to send the mail. Please try again';
                    $this->app->view->c_err = $c_err;
                }
            } else {
                $this->app->view->c_err = $c_err;
            }
        }
        $this->app->view->page_title = $this->app->pages->get_title($p_ident);
        $this->app->view->page_content = $this->app->pages->get_page_content($p_ident);
        $this->app->view->country_list = $this->app->pages->get_country_list();

        $this->app->view->display('index');
    }

}

?>