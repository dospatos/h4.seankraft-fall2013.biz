<?php
if (count($test_list) > 0) {?>
    <h3>Your Test History</h3>
    <table>
    <thead class="table-header">
    <td>Category</td>
    <td>Test Name</td>
    <td>Due On</td>
    <td>Assigned On</td>
    <td>Taken On</td>
    <td>Grade</td>
    </thead>
    <tbody>
    <?php
    foreach($test_list AS $current_test) {
        $due_on_dt = $current_test["due_on_dt"];
        if ($due_on_dt != "") {$due_on_dt = date("m/d/Y", $due_on_dt);}
        $assigned_on_dt = $current_test["assigned_on_dt"];
        if ($assigned_on_dt != ""){$assigned_on_dt = date("m/d/Y", $assigned_on_dt);
        $taken_on_dt = $current_test["start_dt"];
        if ($taken_on_dt != ""){$taken_on_dt = date("m/d/Y", $taken_on_dt);
        }
        ?>

        <tr>
            <td>
            <?php echo $current_test["test_category"];?>
            </td>
            <td>
                <?php echo $current_test["test_name"];?>
            </td>
            <td><?php echo $due_on_dt;?></td>
            <td><?php echo $assigned_on_dt;?></td>
            <td><?php echo $taken_on_dt;?></td>
            <td><?php echo $current_test["grade"];?></td>
        </tr>
    <?php } ?>

<?php }?>
    </tbody>
    </table>
    <?php } else {echo ("<h3>No current test history</h3>");} ?>