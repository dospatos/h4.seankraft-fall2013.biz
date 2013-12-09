<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sean
 * Date: 10/8/13
 * Time: 8:00 AM
 * To change this template use File | Settings | File Templates.
 */
?>
<?php if (isset($errors)) { ?>
    <?php foreach($errors AS $current_error) { ?>
        <div class='alerttext'>
            <?php echo $current_error ?>
        </div>
    <?php } ?>
<?php }?>

<form method='POST' action='/users/p_signup'>
    <fieldset>
        <legend>Create Your User</legend>
            <p>
                <label for="first_name">First Name:</label>
                <input type='text' name='first_name' id='first_name' value='<?php echo $first_name;?>'/>
            </p>
            <p>
                <label for='last_name'>Last Name:</label>
                <input type='text' name='last_name' id='last_name' value='<?php echo $last_name; ?>'/>
            </p>
            <p>
                <label for='email'>Email (this will be your username):</label>
                <input type='text' name='email' value='<?php echo $email;?>' style='<?php echo isset($duplicate_username) ? "color:red;" : "" ?>'/>
            </p>
            <p>
                <label for='email'>Company/Account Name:</label>
                <input type='text' name='company' value='<?php echo $company;?>' style='<?php echo isset($duplicate_account) ? "color:red;" : "" ?>'/>
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

<script type="text/javascript">
    $(document).ready(function() {
        $("#form1").validate({
            rules: {
                name: "required",    // simple rule, converted to {required: true}
                email: {             // compound rule
                    required: true,
                    email: true
                },
                url: {
                    url: true
                },
                comment: {
                    required: true
                }
            },
            messages: {
                comment: "Please enter a comment."
            }
        });
    });
</script>