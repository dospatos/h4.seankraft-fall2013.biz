<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sean
 * Date: 10/8/13
 * Time: 8:00 AM
 * To change this template use File | Settings | File Templates.
 */
?>
<?php if ($duplicate_username == true) { ?>
    <div class="alerttext">That email is already in use, try another!</div>
<?php }?>

<form method='POST' action='/users/p_signup'>
    <fieldset>
        <legend>Create Your User</legend>
            <p>
                <label for="first_name">First Name:</label>
                <input type='text' name='first_name' id='first_name' value='<?php echo $duplicate_username ? $first_name : "" ?>'/>
            </p>
            <p>
                <label for='last_name'>Last Name:</label>
                <input type='text' name='last_name' id='last_name' value='<?php echo $duplicate_username ? $last_name : "" ?>'/>
            </p>
            <p>
                <label for='email'>Email:</label>
                <input type='text' name='email' value='<?php echo $duplicate_username ? $email : "" ?>' style='<?php echo $duplicate_username ? "color:red;" : "" ?>'/>
            </p>
            <p>
                <label for='password'>Password:</label>
                <input type='password' name='password01' id='password01'>
            </p>
        <p>
            <label for='password02'>Password Again:</label>
            <input type='password' name='password02' id='password02'>
        </p>

    </fieldset>
    <input type='submit' value='Sign up'>

</form>