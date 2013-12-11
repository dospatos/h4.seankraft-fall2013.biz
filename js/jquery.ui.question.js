(function($) {
    $.widget("ui.question",{
            options: {
                question_id: null,
                display_mode: "edit",
                question_text: null,
                question_type_id: null

            },
            _create: function() {
                var self = this,
                    o = self.options,
                    el = self.element,
                    localId = el[0].id;

                if (this.options.question_id == null) {
                    this.options.question_id = this.element.attr('question_id');
                }

                //Get the test from the server and draw the display
                var json_data = null;
                $.ajax({
                    type: "GET",
                    url: "/questions/get/" + this.options.question_id,
                    dataType: "json",
                    async: false,
                    success : function(data) {
                        json_data = data;
                    }
                });
                if (json_data != null) {
                    this.displayQuestion(json_data);
                }


            },
            displayQuestion: function(data){//displays on a div
                var question_type_id = parseInt(data['question_type_id'])
                    , question_id = this.options.question_id
                    , answers = data.answers
                    , display_text_id = "txt_" + question_id + "_question_text";

                //All questions have display text
                var display_text = "<div id='" + display_text_id + "'>" + this.options.question_text + "</div>";
                if (this.options.display_mode == "edit"){
                    display_text = "<p><textarea rows='4' cols='50' id='" + display_text_id + "' name='txt_" + question_id + "_question_text'>" + this.options.question_text + "</textarea></p>";
                }
                this.element.append(display_text);

                //On display text lost focus or when the enter key is pressed - update the question text
                $("#" + display_text_id).bind("blur keyup", (function(e) {
                    if(e.type === 'keyup' && e.keyCode !== 10 && e.keyCode !== 13) return;
                    $('#' + this.id).closest(".question").question("changeQuestionText", $(this).val());
                }));

                switch (question_type_id) {
                    case 1 : //1 - choose all correct
                    case 2: {//2 - choose single correct
                        //Write out a textbox so the user can enter the next answer
                        var new_answer_id = "txt_new_answer_" + this.options.question_id;
                        this.element.append("<input type='text' id='" + new_answer_id +  "' value=''/><br/>");
                        //Bind the keyup events to add a new answer

                        $("#" + new_answer_id).bind("keyup", (function(e) {
                            if(e.type === 'keyup' && e.keyCode !== 10 && e.keyCode !== 13) return;
                            $('#' + this.id).closest(".question").question("addAnswer", $(this).val());
                        }));

                        $("#" + new_answer_id).watermark('Enter a new answer', {
                            className: 'lightText'
                        });


                        if (this.options.display_mode == "edit"){
                            //display all the answers
                            for(i=0;i<answers.length;i++) {
                                this._addAnswerDisplay(question_id, question_type_id, answers[i].answer_id, answers[i].answer_text, answers[i].correct);
                            }
                        } else {//It's time to display the question
                        }
                        break;
                    }//2 - single correct
                    case 3: {//3 - T/F
                        for(i=0;i<answers.length;i++) {
                            var answer_text = answers[i].answer_text;
                            var answer_id = answers[i].answer_id;
                            this._addAnswerDisplay(question_id, question_type_id, answer_id, answer_text, answers[i].correct);
                        }
                        break;
                    }
                    case 4: {
                        for(i=0;i<answers.length;i++) {
                            var answer_text = answers[i].answer_text;
                            var answer_id = answers[i].answer_id;
                            this._addAnswerDisplay(question_id, question_type_id, answer_id, answer_text, true);
                        }
                    }//4 - essay
                }
            },
            //Append the proper elements to the DOM to enable the editing of answers
            _addAnswerDisplay: function(question_id, question_type_id, answer_id, answer_text, answer_correct) {
                var select_control_prefix = "select_";
                var answer_select= answer_correct == "1" ? "checked='checked'" : "";
                var select_control_id = select_control_prefix + question_id + "_" + answer_id;
                var textbox_control_id = "txt_" + question_id + "_" + answer_id;
                var delete_control_id = "del_" + question_id + "_" + answer_id;
                var rdo_control_name = "question_answer_" + question_id;
                var answer_span_id = "answer_span_" + answer_id;

                switch (question_type_id) {
                    case 1://A check box, a textbox, and a delete control
                        this.element.append("<span id='" + answer_span_id + "'>"
                         + "<input type='checkbox' id='" + select_control_id + "' name='" + select_control_id + "' " + answer_select + " answer_id='" + answer_id + "' textbox_control_id='" + textbox_control_id + "'/> "
                         + "<input type='text' id='" + textbox_control_id + "' value='" + answer_text + "'/>"
                         + " - <a href='#' class='alerttext' id='" + delete_control_id + "' answer_id='" + answer_id + "'>delete</a><br/>"
                         + "</span>");
                        break;
                    case 2://a radio button, text box, and delete
                        this.element.append("<span id='" + answer_span_id + "'>"
                            + "<input type='radio' id='" + select_control_id + "' " + answer_select + " answer_id='" + answer_id + "' textbox_control_id='" + textbox_control_id + "' name='" + rdo_control_name + "'/> "
                            + "<input type='text' id='" + textbox_control_id + "' value='" + answer_text + "'/>"
                            + " - <a href='#' class='alerttext' id='" + delete_control_id + "' answer_id='" + answer_id + "'>delete</a><br/>"
                            + "</span>");
                        break;
                    case 3://just radio buttons for true/false
                        this.element.append("<span id='" + answer_span_id + "'>"
                            + "<label for='" + select_control_id + "'>" + answer_text + "</label>"
                            + "<input type='radio' id='" + select_control_id + "' name='" + rdo_control_name + "' " + answer_select + " answer_id='" + answer_id + "' />"
                            + "</span>");
                        break;
                    case 4://Show a text area with prompting text as a watermark
                        this.element.append("<span id='" + answer_span_id + "'>"
                            + "<label for='" + textbox_control_id + "'>The test taker will see the following text at a prompt</label><textarea rows='4' cols='50' id='" + textbox_control_id + "'>" + answer_text + "</textarea>"
                            + "</span>");
                        break;
                }

                $("#" + select_control_id).change(function(){
                    //When this is triggered, we have no answer context - we have to rely on our on attributes to survive
                    $('#' + this.id).closest(".question").question("setAnswer", $(this).attr('answer_id'), this.checked);
                });

                if (question_type_id == "1" || question_type_id == "2") {
                    //Allow deletes for multiple answer questions
                    $("#" + delete_control_id).click(function() {
                        $('#' + this.id).closest(".question").question("deleteAnswer",$(this).attr('answer_id'));
                    });

                    //TODO: allow for text change updates here
                    //reset the new answer text box
                    var new_answer_id = "txt_new_answer_" + this.options.question_id;
                    $("#" + new_answer_id).val("");
                    $("#" + new_answer_id).watermark('Enter a new answer', {
                        className: 'lightText'
                    });
                }
            },
            setAnswer: function(answer_id, is_correct) {
                //alert("question_id: " + this.options.question_id + ", answer_id: " + answer_id + ", is_correct: " + is_correct);
                $.ajax({
                    type: "POST",
                    url: "/questions/p_setanswer/" + this.options.question_id,
                    data: { answer_id: answer_id, correct: is_correct},
                    async: false
                });
            },
            changeQuestionText: function(question_text){
                //alert("question_id: " + this.options.question_id + ", question_text: " + question_text);
                question_text = question_text.replace(/[\n\r]/g, ' ');
                $.ajax({
                    type: "POST",
                    url: "/questions/p_set_question_text/" + this.options.question_id,
                    data: { question_text: question_text},
                    async: false
                });
            },
            addAnswer: function(answer_text){
                //alert("question_id: " + this.options.question_id + ", answer_text: " + answer_text);
                var answer_id = 0;
                $.ajax({
                    type: "POST",
                    url: "/questions/p_addquestion/" + this.options.question_id,
                    data: { answer_text: answer_text},
                    async: false,
                    dataType: "json",
                    success: function(data) {
                        answer_id = data;
                    }
                });
                //Find the last answer and put this one after it
                //this.element.append("<div>" + answer_text + " - " + answer_id + "</div>")
                this._addAnswerDisplay(this.options.question_id, this.options.question_type_id, answer_id, answer_text, false);
            },
            deleteAnswer: function(answer_id){
                //alert("answer_id: " + answer_id);
                $.ajax({
                    type: "POST",
                    url: "/questions/p_deleteanswer/" + this.options.question_id,
                    data: { answer_id: answer_id},
                    async: false,
                    dataType: "json",
                    success: function(data) {
                        //remove the answer from the DOM
                        var answer_span_id = "answer_span_" + answer_id;
                        $("#" + answer_span_id).remove();
                    }
                });
            },
            serialize: function() {//get a jSon representation of the object to post back to the server
                $elementType = this.isDiv() ? "DIV" : "CANVAS";
                $minutesAllowed =  this.options.minutesAllowed;
                return '{'
                    +'"elementId" : "' + this.element[0].id + '",'
                    +'"display_mode" : "' + this.options.display_mode + '",'
                    +'"question_id" : "' + this.options.question_id + '",'
                    +'}';

            },
            destroy: function() {//take the timer out of the DOM
                this.element.remove();
            },
            _setOption: function(option, value) {//set a single option
                $.Widget.prototype._setOption.apply(this, arguments);

                var el = this.element;
                switch (option) {
                    case "question_text":
                        var newVal = value.replace(/[\n\r]/g, ' ');
                        alert(newVal);
                        break;
                    case "backgroundColor":
                        el.css("backgroundColor", value);
                        break;
                }
            },
            _setOptions: function( options ) {//set an array of options
                var that = this,
                    resize = false;

                $.each( options, function( key, value ) {
                    that._setOption( key, value );
                    if ( key === "height" || key === "width" ) {
                        resize = true;
                    }
                });

                if ( resize ) {
                    this.resize();
                }
            }
        }

    );
})(jQuery);