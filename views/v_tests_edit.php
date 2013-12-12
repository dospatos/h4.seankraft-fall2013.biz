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


<section>
    <div id="tabs">
        <ul>
            <li><a href="#tab-test">Test</a></li>
            <li><a href="#tab-questions">Questions</a></li>
            <li><a href="#tab-materials">Materials</a></li>
            <li><a href="#tab-assign">Assign</a></li>
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
        <div id="tab-questions">
            <div>
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
                        <input type="radio" name="question_type_id" id="question_type_id_<?php echo $current_question_type['question_type_id']?>" value="<?php echo $current_question_type['question_type_id']?>"/> |
                    <?php } ?>
                    </p>
                    <input type='hidden' name='test_id' id='test_id' value='<?php echo $test_id;?>'/>
                    <input type='button' value='Add Question' id='cmdAddQuestion'>
                </fieldset>
            </div>
            <!--List the questions-->
            <ul>
                <?php foreach($question_list AS $current_question) { ?>
                    <li><a href="#tab-question-<?php echo $current_question["question_id"]; ?>">
                            <?php echo siteutils::Truncate($current_question['question_text'], 20,true);?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php foreach($question_list AS $current_question) { ?>
                <div id='tab-question-<?php echo $current_question["question_id"] ?>'
                     question_id='<?php echo $current_question["question_id"]; ?>'
                     class='question' >

                </div>
            <?php } ?>

        </div>
        <div id="tab-materials">
            Materials here
        </div>
        <div id="tab-assign">
            <form method='POST' id='frmAssign' action='/tests/p_assign/' >
                <table>
                    <thead class="table-header">
                    <td><a href="#">Select All</a></td>
                    <td>Name</td>
                    <td>Due Date (<a id="cmdAddMonth" href="#" title="Plus One month">M+</a> | <a href="#" id="cmdEOY" title="End of year">EOY</a>)</td>
                    <td>Assigned Date</td>
                    </thead>
                    <tbody>
                    <?php
                    if ($test_assign_status) {

                        foreach($test_assign_status AS $current_test_assign_status) { ?>
                            <tr>
                                <td><input type="checkbox" checked="" id="chk_<?php echo $current_test_assign_status['user_id']?>" name="chk_<?php echo $current_test_assign_status['user_id']?>" value="<?php echo $current_test_assign_status['user_id']?>"></td>
                                <td>
                                    <label for="txt_due_<?php echo $current_test_assign_status['user_id']?>">
                                    <?php echo $current_test_assign_status['first_name']?>&nbsp;<?php echo $current_test_assign_status['last_name']?>
                                    </label>
                                </td>
                                <td><input class="due_date" type="text" id="txt_due_<?php echo $current_test_assign_status['user_id']?>" name="txt_due_<?php echo $current_test_assign_status['user_id']?>" value="<?php echo $current_test_assign_status['due_on_dt']?>"/></td>
                                <td><?php echo $current_test_assign_status["assigned_on_dt"];?></td>
                            </tr>
                        <?php }} else {echo ("<h3>No test takers exist to be assigned</h3>");} ?>
                    <tbody>
                </table>
                <input type="submit" value="Assign Test"/>
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
        Date.prototype.addDays = function(days) {
            this.setDate(this.getDate() + days);
            return this;
        };

        Date.prototype.formatMMDDYYY = function() {
            var return_date = "";
            var dd = this.getDate();
            var mm = this.getMonth()+1; //January is 0!

            var yyyy = this.getFullYear();
            if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} return_date = mm+'/'+dd+'/'+yyyy;
            return return_date;
        }

        $("#cmdAddMonth").click(function() {
            var due_date_text = $(".due_date");
            var due_date = new Date(due_date_text.val());
            if (!(due_date instanceof Date && !isNaN(due_date.valueOf()))) {due_date = new Date();}

            due_date = due_date.addDays(30);
            due_date_text.val(due_date.formatMMDDYYY())
        });

        $("#cmdEOY").click(function() {
            var the_date = new Date().getFullYear();
            the_date = "12/31/" + the_date;
            var due_date_text = $(".due_date").val(the_date);
        });

        $('#cmdAddQuestion').click(function () {
            //Add the question at the server, get the new ID
            var question_text = $('#question_text').val();
            var question_type_id = $("input[name='question_type_id']:checked").val();
            var test_id = $('#test_id').val();
            var question_id = 0;

            if (typeof(question_type_id) == "undefined") {
                alert ("Please choose a question type")
                return;
            }

            if (question_text.length < 10) {
                alert("Please provide a question of 10 characters or more");
                return;
            }

            $.ajax({
                type: "POST",
                url: "/questions/p_create/" + test_id,
                dataType: "json",
                data: { question_text: question_text, question_type_id: question_type_id},
                async: false,
                success : function(data) {
                    question_id = data;
                }
            });

            if (question_id != null) {
                //Add the question to the local page
                var newTabContent = $("#tab-questions").append("<div style='display: none' id='tab-question-" + question_id + "' class='question ui-tabs-panel ui-widget-content ui-corner-bottom' question_id='" + question_id + "' aria-labelledby='ui-id-4' role='tabpanel' aria-expanded='false' aria-hidden='true' style='display: none;'></div>");
                var newTab = $( "#tab-questions .ui-tabs-nav").append("<li><a href='#tab-question-" + question_id + "'>" + question_text + "-" + question_type_id +"</li>");
                $("#tab-questions").tabs("refresh");
                //light up the question
                $( "#tab-question-" + question_id).question({question_text: question_text});
            }
        });

        <?php
        //can't use a class selector for these because it always picks the top one and then $(this) does not work like it should
        //so we are forced to loop here in the PHP
        foreach($question_list AS $current_question) {
            echo "$('#tab-question-".$current_question["question_id"]."').question({question_text: '".$current_question["question_text"]."', question_type_id:".$current_question["question_type_id"]."});";
        }
        ?>

    });


</script>
