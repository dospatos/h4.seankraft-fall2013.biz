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
            displayQuestion: function(data){//displays on a div or a panel
                var question_type_id = data['question_type_id']
                    , question_id = this.options.question_id
                    , answers = data.answers
                    , display_text_id = "txt_" + question_id + "_question_text";

                //All questions have display text

                var display_text = "<p><textarea rows='4' cols='50' id='" + display_text_id + "' name='txt_" + question_id + "_question_text'>" + this.options.question_text + "</textarea></p>";
                this.element.append(display_text);
                //On lost focus or when the enter key is pressed - update the question text
                $("#" + display_text_id).bind("blur keyup", (function(e) {
                    if(e.type === 'keyup' && e.keyCode !== 10 && e.keyCode !== 13) return;
                    $('#' + this.id).parent().parent().question("changeQuestionText", $(this).val());
                }));

                switch (question_type_id) {
                //Question types
                //1 - all correct
                //2 - single correct
                    case "3": {//3 - T/F
                        window.console.log(data);
                        for(i=0;i<answers.length;i++) {
                            var answer_text = answers[i].answer_text;
                            var answer_select= answers[i].correct == "1" ? "checked='checked'" : "";
                            var answer_id = answers[i].answer_id;
                            var control_id = "rdo_" + question_id + "_" + answer_id;
                            var control_name = "question_answer_" + question_id;
                            this.element.append("<label for='" + control_id + "'>" + answer_text + "</label>");
                            this.element.append("<input type='radio' id='" + control_id + "' name='" + control_name + "' " + answer_select + " answer_id='" + answer_id + "' /> | ");
                            $("#" + control_id).click(function(){
                                //When this is triggered, we have no answer context - we have to rely on our on attributes to survive
                                $('#' + this.id).parent().question("setAnswer", $(this).attr('answer_id'), true);
                            })
                        }
                        break;
                    }
                //4 - essay
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
            addAnswer: function(answer_id, answer_text){

            },
            deleteAnswer: function(answer_id, answer_text){

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