<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sean
 * Date: 10/8/13
 * Time: 8:00 AM
 * To change this template use File | Settings | File Templates.
 */
?>

<style>
    label {text-transform:capitalize;}
</style>
<style>
    .ui-tabs-vertical { width: 55em; }
    .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
    .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
    .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
    .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
    .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 40em;}
</style>

<?php if (isset($errors)) { ?>
    <?php foreach($errors AS $current_error) { ?>
        <div class='alerttext'>
            <?php echo $current_error ?>
        </div>
    <?php } ?>
<?php }?>


<section>
    <div id="tabs">
        <ul>
            <li><a href="#tab-test">Test</a></li>
            <li><a href="/questions/<?php echo $test_id;?>">Questions</a></li>
            <li><a href="/materials/<?php echo $test_id;?>">Materials</a></li>
        </ul>
        <div id="tab-test">
            <form method='POST' id='frmTest' action='/tests/p_edit/<?php echo $test_id;?>'>
                <fieldset>
                    <legend>Edit Test</legend>
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
                    <p>
                        <label for='test_year'>Test Year:</label>
                        <input type='text' name='test_year' value='<?php echo $test_year;?>'/>
                    </p>
                    <p>
                        <label for='passing_grade'>Passing Grade:</label>
                        <input type='text' name='passing_grade' value='<?php echo $passing_grade;?>'/>
                    </p>
                    <p>
                        <label for='minutes_to_complete'>Minutes to complete (0 for no timer):</label>
                        <input type='text' name='minutes_to_complete' value='<?php echo $minutes_to_complete;?>'/>
                    </p>
                </fieldset>
                <input type='hidden' name='test_id' id='test_id' value='<?php echo $test_id;?>'/>
                <input type='submit' value='Save Test'>

            </form>
        </div>
    </div>
</section>



<script type="text/javascript">
    $(document).ready(function() {
        /*
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
        */
    });
</script>

<script>
    $(function() {
        $( "#tabs" ).tabs();
    });



    $(function() {
        var tabs = $( "#tab-questions" ).tabs();
        tabs.find( ".ui-tabs-nav" ).sortable({
            axis: "x",
            stop: function() {
                tabs.tabs( "refresh" );
            }
        });
    });

</script>
