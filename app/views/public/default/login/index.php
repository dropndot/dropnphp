<form name="dduser-logib" method="post" action="">
    <?php if (!empty($this->app->view->vars['login_err'])) { ?> 
        <p class="login_err"><?php echo $this->app->view->vars['login_err'] ?></p>
    <?php } ?>
    <label>
        <input type="text" name="username" placeholder="User Name" class="dduserpass" value="<?php echo!empty($_POST['username']) ? $_POST['username'] : '' ?>"/>
    </label>
    <label>
        <input type="password" name="password" placeholder="Password" class="dduserpass" value="<?php echo!empty($_POST['password']) ? $_POST['password'] : '' ?>"/>
    </label>
    <label>
        <input <?php if(!empty ($_POST['passremembar'])) { ?> checked="checked" <?php } ?> type="checkbox" name="passremembar" value="Remember your password" />
        <p>Remember Password</p>
        <a href="index.php?controller=login&amp;action=forgot_pass">Forgot Password?</a>
    </label>
    <div class="center-submit">
        <input type="submit" name="login" value="<?php echo $BUTTON_LOGIN; ?>" class="ddloginsubmit" align="baseline"/>
    </div>
</form>