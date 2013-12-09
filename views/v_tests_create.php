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

<form method='POST' action='p_create'>
    <fieldset>
        <legend>Create a Test</legend>
        <p>
            <label for="test_name">Test Name:</label>
            <input type='text' name='test_name' id='test_name' value='<?php echo $test_name;?>'/>
        </p>
        <p>
            <label for='test_descr'>Description:</label>
            <input type='text' name='test_descr' id='test_descr' value='<?php echo $test_descr; ?>'/>
        </p>
        <p>
            <label for='test_category'>Category:</label>
            <input type='text' name='test_category' value='<?php echo $test_category;?>'/>
        </p>


        <!-- `test_id`, `account_id`, `copied_from_test_id`, `test_name`, `test_descr`, `public`,
        `test_year`, `created_by_user_id`, `created_on_dt`, `last_updated_dt`, `minutes_to_complete`
        , `passing_grade`, `deleted`, `deleted_date`, `test_category`-->
    </fieldset>
    <input type='submit' value='Create Test'>

</form>

<script type="text/javascript">
    $(document).ready(function() {
        $("#form1").validate({
            rules: {
                test_name: "required",    // simple rule, converted to {required: true}
                test_descr: {
                    required: true
                },
                test_category: {
                    required: true
                }
            }
        });
    });
</script>