<?php ?>

<form method='POST' action='/users/p_login'>
    <?php if(isset($new_user)) { ?>
        <h2>Welcome! new user - please login below</h2>
    <?php } ?>

    Email<br>
    <input type='text' name='email' value='<?php echo $new_user ?>'/>

    <br><br>

    Password<br>
    <input type='password' name='password'>

    <br><br>
    <?php if(isset($error)) { ?>
        <div class='alerttext'>
            <?php echo str_replace("_", " ", $error)?>. Please double check your email and password. <br/>

            If you don't have an account, <a href="/users/signup">sign up here</a>
        </div>
        <br>
    <?php }?>

    <input type='submit' value='Log in'>

</form>