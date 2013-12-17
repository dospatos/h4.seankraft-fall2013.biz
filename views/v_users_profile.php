<?php
/**
 * Created by JetBrains PhpStorm.
 * User: skraft
 * Date: 10/15/13
 * Time: 3:42 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<h2>Edit Your Profile</h2>

<form method='POST' action='/users/p_profileedit/<?php echo $currentuser["user_id"] ?>' enctype="multipart/form-data">
    <fieldset>
        <legend>Profile</legend>

        <p>
            Company Name: <?php echo $currentuser["account_name"] ?>
        </p>
        <p>
            <label for='first_name'>First Name</label>
            <input type='text' name='first_name' value='<?php echo stripslashes($currentuser["first_name"]) ?>'>
        </p>

        <p>
            <label for='last_name'>Last Name</label>
            <input type='text' name='last_name' value='<?php echo stripslashes($currentuser["last_name"]); ?>'>
        </p>
        <p>
            <label for='first_name'>Job Title</label>
            <input type='text' name='title' value='<?php echo stripslashes($currentuser["job_title"]); ?>'>
        </p>
        <p>
            <label for='email'>Email (this is also the username)</label>
            <input type='text' name='email' value='<?php echo stripslashes($currentuser["email"]); ?>'>
            <br>
        </p>

        <input type='submit' value='Update Profile'>
    </fieldset>
</form>