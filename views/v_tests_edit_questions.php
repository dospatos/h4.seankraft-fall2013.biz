<!-- Question editing -->
<div id="tab-question-edit">
	<div id="dialog-confirm" title="Delete the question?">
		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete this question from the test?</p>
	</div>
	<div id="tab-questions">
		<ul> <!-- The add question tab -->
		<?php if ($editable) {?>	
			<li id="new-question-tab"><a href="#tab-question-new">Add a new question</a></li>									
		<?php }?>
		
		<!--List the questions. Most of the display is handled via javascript -->
			<?php foreach($question_list AS $current_question) { ?>
				<li id="q-<?php echo $current_question["question_id"]; ?>">
					<!-- question_order field starts from 0 so need to add 1 -->
					<span class="question-order"><?php echo $current_question["question_order"]+1?>.</span>
					<a href="#tab-question-<?php echo $current_question["question_id"]; ?>">
						<?php echo siteutils::Truncate($current_question['question_text'], 20,true);//truncate so the text fits in the tab?>
					</a>
					<span class="ui-icon ui-icon-close" role="presentation">Remove Tab</span>
				</li>
			<?php } ?>
		</ul>
		<?php if ($editable) {?>
			<div id="tab-question-new" >
				<fieldset>
					<legend>Create a new Question</legend>
					<p class="form-row">
						<label for="question_text">Question Text:</label>
						<input type='text' name='question_text' id='question_text' style="width:450px" />
					</p>
					<?php foreach($question_types AS $current_question_type) {
						$selected = $current_question_type['question_type_id'] == "1" ? "checked='checked'" : "";//select the first type by default
						?>
						<p class="form-row" style="width:400px">
							<label style="white-space:nowrap;text-align: left;" for="question_type_id_<?php echo $current_question_type['question_type_id']?>"><?php echo $current_question_type['question_type_descr']?></label>
							<input type="radio" style="float:right;width:200px" <?php echo $selected;?> name="question_type_id" id="question_type_id_<?php echo $current_question_type['question_type_id']?>" value="<?php echo $current_question_type['question_type_id']?>"/>
						</p>
					<?php } ?>
					<input type='hidden' name='test_id' id='test_id' value='<?php echo $test_id;?>'/>
					<input type='button' value='Add New Question' id='cmdAddQuestion'>
				</fieldset>
			</div>
		<?php } ?>
		<?php foreach($question_list AS $current_question) { ?>
			<div id='tab-question-<?php echo $current_question["question_id"] ?>'
				 question_id='<?php echo $current_question["question_id"]; ?>'
				 class='question' >

			</div>
		<?php } ?>
	</div>
</div>
			

<script>
$(document).ready(function() {
	console.log("Document ready");
	function linkTestQuestions() {
		/*
		$(".question").each( function (index, el) {
			var questionText = $(this)
			$(this).question
		}
		*/
        <?php
        //can't use a class selector for these because it always picks the top one and then $(this) does not work like it should
        //so we are forced to loop here in the PHP
        foreach($question_list AS $current_question) {
            $disabled_text = $editable ? "false" : "true";
            echo "$('#tab-question-".$current_question["question_id"]."').question({question_text: '".$current_question["question_text"]."', question_type_id:".$current_question["question_type_id"].",disabled:".$disabled_text."});";
        }
        ?>
    }	
	window.setTimeout(linkTestQuestions, 1000);//wait a second to load the questions
});
</script>	



