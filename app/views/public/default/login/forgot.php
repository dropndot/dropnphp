<form name="dduser-logib" method="post" action="">
    <?php if (!empty($this->app->view->vars['forgot_pass_success'])) { ?> 
        <p class="login_success"><?php echo $this->app->view->vars['forgot_pass_success'] ?></p>
    <?php } ?>
    <?php if (!empty($this->app->view->vars['forgot_pass_err'])) { ?> 
        <p class="login_err"><?php echo $this->app->view->vars['forgot_pass_err'] ?></p>
    <?php } ?>
    <label>
        <input type="text" name="email" placeholder="Enter Email" class="dduserpass" value="<?php echo!empty($_POST['email']) ? $_POST['email'] : '' ?>"/>
    </label>
    <div class="center-submit">
        <input type="submit" name="forgot" value="<?php echo $BUTTON_SUBMIT; ?>" class="ddloginsubmit" align="baseline"/>
    </div>
</form>