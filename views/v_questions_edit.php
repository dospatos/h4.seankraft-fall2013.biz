<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sean
 * Date: 12/7/13
 * Time: 7:59 AM
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
            <li><a href="/tests/edit/<?php echo $test_id;?>">Test</a></li>
            <li><a href="#tab-questions<?php echo $test_id;?>">Questions</a></li>
            <li><a href="/materials/<?php echo $test_id;?>">Materials</a></li>
        </ul>
        <div id="tab-questions">
            <form method='POST' id='frmQuestion' action='/questions/p_create/<?php echo $test_id;?>'>
                <fieldset>
                    <legend>Add Question</legend>
                    <p>
                        <label for="question_text">Question Text:</label>
                        <input type='text' name='question_text' id='question_text'/>
                    </p>
                    <p>
                    <div>Question Type:</div>
                    <?php foreach($question_types AS $current_question_type) { ?>
                        <label for="question_type_id_<?php echo $current_question_type['question_type_id']?>"><?php echo $current_question_type['question_type_descr']?></label>
                        <input type="radio" name="question_type_id" id="question_type_id_<?php echo $current_question_type['question_type_id']?>" value="<?php echo $current_question_type['question_type_id']?>"/>
                    <?php } ?>


                    </p>
                    <input type='hidden' name='test_id' id='test_id' value='<?php echo $test_id;?>'/>
                    <input type='submit' value='Add Question'>
                </fieldset>


            </form>

            </p>
            <!--List the questions-->
            <ul id="ul-question-tabs">
                <?php foreach($question_list AS $current_question) { ?>
                        <li><a href="#tab-question-<?php echo $current_question["question_id"]; ?>">
                                <?php echo siteutils::Truncate($current_question['question_text'], 20,true);?>
                            </a>
                        </li>
                <?php } ?>
            </ul>
            <?php foreach($question_list AS $current_question) { ?>
                <div id='tab-question-<?php echo $current_question["question_id"] ?>' question_id='<?php echo $current_question["question_id"]; ?>' class='question' >
                    <?php echo $current_question["question_text"] ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<script>
    $(function() {
        $( "#tabs" ).tabs();
        var tabs = $( "#tab-questions" ).tabs();

        /*
         tabs.find( ".ui-tabs-nav" ).sortable({
         axis: "x",
         stop: function() {
         tabs.tabs( "refresh" );
         }
         });
         */
        tabs.addClass( "ui-tabs-vertical ui-helper-clearfix" );
        tabs.removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

    });



    $(document).ready(function()
    {
        <?php
        //can't use a class selector for these because it always picks the top one and then $(this) does not work like it should
        //so we are forced to loop here in the PHP
        foreach($question_list AS $current_question) {
            echo "$('#tab-question-".$current_question["question_id"]."').question();";
        }
        ?>

    });


</script>
