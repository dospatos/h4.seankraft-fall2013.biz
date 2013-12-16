<h2>Welcome to <?=APP_NAME?><?php if($user) echo ', '.$user->first_name; ?></h2>

<?php if(!$user) { ?>
    <p>
        Our Online Tests is a web based home for all of your company's tests and quizzes. <br/>
        Please <a href="/users/login">log in</a> or <a href="/users/signup">create an account</a> today.
    </p>
<?php }?>

</p>

<?php if($user) { ?>
    <h3>Your currently assigned tests</h3>
    <table>
        <thead class="table-header">
            <td>Test Name</td>
            <td>Due On</td>
            <td>Assigned On</td>
        </thead>
        <tbody>
            <?php
            if (isset($assigned_tests)) {
                foreach($assigned_tests AS $current_test_assign) {
                    $due_on_dt = $current_test_assign["due_on_dt"];
                    if ($due_on_dt != "") {$due_on_dt = date("m/d/Y", $due_on_dt);}
                    $assigned_on_dt = $current_test_assign["assigned_on_dt"];
                    if ($assigned_on_dt != ""){$assigned_on_dt = date("m/d/Y", $assigned_on_dt);}
                    ?>
                    <tr>
                       <td>
                           <?php echo $current_test_assign["test_name"]?>
                        </td>
                        <td><?php echo $due_on_dt;?></td>
                        <td><?php echo $assigned_on_dt;?></td>
                        <td><a href="/tests/assignment/<?php echo $current_test_assign["test_assign_id"]?>">Details</a> | <a href="/tests/take/<?php echo $current_test_assign["test_assign_id"]?>">Take</a></td>
                    </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } else {echo ("<h3>No test currently assigned</h3>");} ?>
<?php } ?>