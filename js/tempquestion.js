 _addAnswerDisplay: function(question_id, question_type_id, answer_id, answer_text, answer_correct) {
                //console.log("answer_id: " + answer_id + ", question_type_id:" + question_type_id);
                var select_control_prefix = "select_";
                var answer_select= answer_correct == "1" ? "checked='checked'" : "";
                var select_control_id = select_control_prefix + question_id + "_" + answer_id;
                var textbox_control_id = "txt_" + question_id + "_" + answer_id;
                var delete_control_id = "del_" + question_id + "_" + answer_id;
                var rdo_control_name = "question_answer_" + question_id;
                var answer_span_id = "answer_span_" + answer_id;

                switch (this.options.display_mode) {
                    case "edit":
                        
                        switch (question_type_id) {
                             case 1://A check box list, a textbox, and a delete control for edit and a DIV for take
                        
                                var delete_control = this.options.disabled ? "" : 
                                " - <a href='#' class='alerttext button' id='" + delete_control_id + "' answer_id='" + answer_id + "' " + this.disabled_option + ">delete</a><br/>";
                                this.element.append("<span style='float:left' class='form-row' class='form-row' id='" + answer_span_id + "'>"
                                 + "<input style='float:left' type='checkbox' id='" + select_control_id + "' name='" + select_control_id + "' " + answer_select + " answer_id='" + answer_id + "' textbox_control_id='" + textbox_control_id + "' " + this.disabled_option + "/> "
                                 + "<input type='text' id='" + textbox_control_id + "' value='" + answer_text + "' " + this.disabled_option + "/>"
                                 + delete_control
                                 + "</span>");
                                break;
                                
                            case 2://a radio button list
                               
                            
                                var delete_control = this.options.disabled ? "" : 
                                " - <a href='#' class='alerttext button' id='" + delete_control_id + "' answer_id='" + answer_id + "' " + this.disabled_option + ">delete</a><br/>";
                                this.element.append("<span class='form-row' style='float:left' id='" + answer_span_id + "'>"
                                + "<input style='float:left'  type='radio' id='" + select_control_id + "' " + answer_select + " answer_id='" + answer_id + "' textbox_control_id='" + textbox_control_id + "' name='" + rdo_control_name + "' value='" + answer_id + "' " + this.disabled_option + "/> "
                                + "<input type='text' id='" + textbox_control_id + "' value='" + answer_text + "' " + this.disabled_option + "/>"
                                + delete_control
                                + "</span>");
                                break;
                            
                             case 3://just radio buttons for true/false - same for edit and take
                      
                                this.element.append("<span style='float:left; width: 200px;clear:both' id='" + answer_span_id + "'>"
                                    + "<label style='float:left; text-align: left;width:50px' for='" + select_control_id + "'>" + answer_text + "</label>"
                                    + "<input style='float:left' type='radio' id='" + select_control_id + "' name='" + rdo_control_name + "' " + answer_select + " answer_id='" + answer_id + "' value='" + answer_id + "' " + this.disabled_option + "/>"
                                    + "</span>");
                                break;

                             case 4://Show a text area with prompting text as a watermark
                                var display_text_area = "<br/><span class='form-row' style='float:left;clear:both' id='" + answer_span_id + "'>";
                                display_text_area+= "<label style='float:right;clear:both;width:100%; text-align: left' for='" + textbox_control_id + "'>The test taker will see the following text as a prompt</label>"
                                        + "<textarea style='float:left;clear:both' rows='4' cols='50' id='" + textbox_control_id + "' name='" + textbox_control_id + "' " + this.disabled_option + "></textarea>"
                                            + "</span>";

                                this.element.append(display_text_area);
                                $("#" + textbox_control_id).val(answer_text);
                                $("#" + textbox_control_id).bind("blur keyup", (function(e) {
                                    if(e.type === 'keyup' && e.keyCode !== 10 && e.keyCode !== 13) return;
                                    $('#' + this.id).closest(".question").question("changeAnswerText", $(this).val());
                                }));

                                break;
                             }//question_type_id

                    case "take":

                        switch (question_type_id) {
                            case 1:
                                this.element.append("<span class='form-row' id='" + answer_span_id + "'>"
                                + "<input style='float:left' type='checkbox' id='" + select_control_id + "' name='" + select_control_id + "' "
                                + answer_select + "answer_id='" + answer_id + "' textbox_control_id='" + textbox_control_id + "'/> "
                                + "<label style='float:left' for='" + select_control_id + "'>" + answer_text + "</label><br/>"
                                + "</span>");
                                break;

                            case 2:
                                 //TODO: find out if the answer is selected by the user
                                this.element.append("<span class='form-row' id='" + answer_span_id + "'>"
                                + "<input style='float:left'  type='radio' id='" + select_control_id + "' " + answer_select + " answer_id='" + answer_id + "' textbox_control_id='" + textbox_control_id + "' name='" + rdo_control_name + "' value='" + answer_id + "'/> "
                                + "<label for='" + select_control_id + "'>" + answer_text + "</label><br/>"
                                + "</span>");
                                break;

                            case 3:
                                this.element.append("<span style='float:left; width: 200px;clear:both' id='" + answer_span_id + "'>"
                                + "<label style='float:left; text-align: left;width:50px' for='" + select_control_id + "'>" + answer_text + "</label>"
                                + "<input style='float:left' type='radio' id='" + select_control_id + "' name='" + rdo_control_name + "' " + answer_select + " answer_id='" + answer_id + "' value='" + answer_id + "' />"
                                + "</span>");    
                                break;

                            case 4:
                                var display_text_area = "<br/><span class='form-row' style='float:left;clear:both' id='" + answer_span_id + "'>";
                               display_text_area+= "<textarea rows='4' cols='50' id='" + textbox_control_id + "' name='" + textbox_control_id + "'></textarea>"
                                    + "</span>";

                                this.element.append(display_text_area);
                                if (answer_correct==0) {//show the prompting watermark
                                    $("#" + textbox_control_id).watermark(answer_text, {
                                        className: 'lightText'
                                    });
                                } else {
                                    $("#" + textbox_control_id).val(answer_text);
                                }
                                break;
                             }//question_type_id

                    case "review":
                        switch (question_type_id) {
                            case 1:
                                if (answer_correct == 1){
                                    this.element.append("<div>A: " + answer_text + "</div>")
                                }
                            break;

                            case 2:
                                 if (answer_correct == 1){
                                    this.element.append("<div>A: " + answer_text + "</div>")
                                }
                                break;

                            case 3:

                                if (answer_correct == 1){
                                    this.element.append("<div>A: " + answer_text + "</div>")
                                }
                                break;

                            case 4:
                                 if (answer_correct == 1){
                                    this.element.append("<div>A: " + answer_text + "</div>")
                                }
                                break;
                        }
                        break;
                    

                        }//question_type_id

                        break;
                }//display_mode

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