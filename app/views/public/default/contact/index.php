<div class="contactPage">
    <h1><?php echo stripslashes($page_content['title']) ?></h1>
    <ul class="additionalConInfo">
        <?php if (!empty($this->app->settings['address'])) { ?>
            <li class="car">
                <h3>Address:</h3>
                <p><?php echo $this->app->settings['address']; ?></p>
            </li>
        <?php } ?>
        <?php if (!empty($this->app->settings['telephone'])) { ?>
            <li class="telephone">
                <h3>Telephone</h3>
                <p><?php echo $this->app->settings['telephone']; ?></p>
            </li>
        <?php } ?>
        <?php if (!empty($this->app->settings['phone'])) { ?>
            <li class="phone">            
                <h3>Hotline number</h3>
                <p><?php echo $this->app->settings['phone']; ?></p>
            </li>
        <?php } ?>
        <?php if (!empty($this->app->settings['fax'])) { ?>
            <li class="fax">
                <h3>Fax</h3>
                <p><?php echo $this->app->settings['fax']; ?></p>
            </li>
        <?php } ?>
    </ul>
    <div class="formArea">
        <h3>Drop Us a line what about your need.</h3>
        <p>We will contact with you within 24 hour in a day.</p>
        <?php if (!empty($c_success)) { ?>
            <div class="success-message"><?= $c_success; ?> </div>
        <?php } ?>
        <?php if (!empty($c_err)) { ?>
            <h4 style="color: red; font-size: 14px; padding: 5px 0 15px 0; margin: 0;"><?= $c_err ?></h4>
        <?php } ?>
        <form name="form2" id="form2" action="<?php echo $site_url  ?>index.php?controller=contact&page=contact-us" method="post" onsubmit="javascript:quickformSubmit(this); return false;">
            <p>
                <input type="text" name="name" id="name"  value="<?= !empty($_POST['name']) ? $_POST['name'] : '' ?>" placeholder="Name" />
                <input type="email" class="formfr" name="email" id="email"  value="<?= !empty($_POST['email']) ? $_POST['email'] : '' ?>" placeholder="Email" />
            </p>
            <p>
                <input type="text" name="phone" id="phone"  value="<?= !empty($_POST['phone']) ? $_POST['phone'] : '' ?>" placeholder="Contact Number" />
                <input type="text" class="formfr" name="subject" id="subject"  value="<?= !empty($_POST['subject']) ? $_POST['subject'] : '' ?>" placeholder="Subject" />
            </p>
            <p>
                <textarea class="msg" name="msg" id="msg" rows="7" cols="40" placeholder="Your Message"><?= !empty($_POST['msg']) ? $_POST['msg'] : '' ?></textarea>
            </p>
            <script type="text/javascript">
                var RecaptchaOptions = {
                    theme : 'red'
                };
            </script>
            <div class="chapchaArea">
                <?php echo recaptcha_get_html($publickey); ?>
            </div>
            <p>
                <input class="submitbtn" name="submit" value="Submit" type="submit"/>
            </p>
        </form>
    </div>
    <!--formArea-->
</div>
<!--contactPage-->
<div class="mapArea">
    <h2>Location Map</h2>
    <?php echo $this->app->settings['google_map']; ?>
</div>
<!--mapArea-->
