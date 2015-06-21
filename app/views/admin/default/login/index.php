<div class="login_container">
    <div class="toolbar"><h1 class="title">Login</h1></div>
    
    <div class="form">
        <form name="login" action="" method="post" class="login_form">
            <?php if(!empty($this->app->view->vars['login_err'])) { ?> 
                <p class="login_err"><?=$this->app->view->vars['login_err']?></p>
            <?php } ?>
            
            <p><label>Username: </label><input type="text" name="username" value="<?=!empty($_POST['username'])?$_POST['username']:''?>" class="medium"></p>
            <p><label>Password: </label><input type="password" name="password" value="<?=!empty($_POST['password'])?$_POST['password']:''?>" class="medium"></p>
            <p><label>&nbsp;</label><input type="submit" name="login" value="<?=$BUTTON_LOGIN?>" class="button"></p>
        </form>
    </div>
</div>