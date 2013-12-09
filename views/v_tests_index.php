<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sean
 * Date: 12/7/13
 * Time: 7:59 AM
 * To change this template use File | Settings | File Templates.
 */
?>
<h2>Tests</h2>

<p>
    <a href='tests/create'>Create a New Test</a>

</p>
<!--List of tests to follow-->
<?php foreach($test_list AS $current_test) { ?>
    <div>
        <a href="/tests/edit/<?php echo $current_test['test_id'] ?>">
            <?php echo $current_test['test_name']?>
        </a>
        - <?php echo $current_test['test_descr']?>
    </div>
<?php } ?>