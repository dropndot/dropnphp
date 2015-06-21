<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?php echo $site_title; ?> <?php echo !empty($row['title']) ? $row['title'] : '' ?></h3>
    </div>
</div>

<?php if (!empty($err)) { ?> 
    <p class="err"><?php echo $err ?></p>
<?php } ?>


<?php if (!empty($msg)) { ?> 
    <p class="msg"><?php echo $msg ?></p>
<?php } ?>


<div class="content">
    <div class="form">
        <form name="add_category" action="<?php echo BASE_URL  ?>admin/index.php?controller=profile" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo !empty($row['id']) ? $row['id'] : '' ?>">

            <p>
                <label>Name : </label>
                <input type="text" name="name" value="<?php echo !empty($row['name']) ? $row['name'] : '' ?>" class="medium" />
            </p>
            <p>
                <label>Location : </label>
                <input type="text" name="location" value="<?php echo !empty($row['location']) ? $row['location'] : '' ?>" class="medium" />
            </p>
            <p>
                <label>Email : </label>
                <input type="text" name="email" value="<?php echo !empty($row['email']) ? $row['email'] : '' ?>" class="medium" />
            </p>
            <p>
                <label>User Name : </label>
                <input disabled="disabled" type="text" name="username" value="<?php echo !empty($row['username']) ? $row['username'] : '' ?>" class="medium" />
<!--                <input type="hidden" name="old_username" value="<?php echo $row['username']; ?>" class="medium" />-->
            </p>
            <p>
                <label>Password : </label>
                <input type="password" name="password" value="" class="medium" />
                <input type="hidden" name="old_password" value="<?php echo $row['password']; ?>" class="medium" />
            </p>
            <p>
                <label>Phone : </label>
                <input type="text" name="phone" value="<?php echo !empty($row['phone']) ? $row['phone'] : '' ?>" class="medium" />
            </p>
            <p>
                <label>Details : </label>
                <textarea name="details" class="large" cols="40" rows="10"><?php echo !empty($row['details']) ? $row['details'] : '' ?></textarea>
            </p>            
            <p>
                <label>Photo :</label>
                <input type="hidden" name="old_profile_image" value="<?php echo $row['profile_image']; ?>" />
                <input type="file" name="profile_image" /><br/>
                <img style="margin: 0" src="app/resources/document/users/<?php echo $row['profile_image']; ?>"  alt="" width="50px" height="50px"/>
            </p>
            <p>
                <input type="submit" name="submit" value="<?php echo $BUTTON_SUBMIT ?>" class="submit" />
            </p>
        </form>
    </div>
</div>                