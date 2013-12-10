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
                $display_text = "<div class='question_text'>Q: " + this.options.question_text + "</div>";
                this.element.append($display_text);
                var question_type_id = data['question_type_id'],
                 question_id = this.options.question_id;
                switch (question_type_id) {
                //Question types
                //1 - all correct
                //2 - single correct
                    case "3": {//3 - T/F
                        this.element.append("<label for='rdo_" + question_id + "_true'>True</label><input type='radio' id='rdo_" + question_id + "_true'/>");
                        break;
                    }
                //4 - essay
                }
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
                    case "color":
                        el.css("color", value);
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