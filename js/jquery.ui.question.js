(function($) {
    $.widget("ui.question",{
            options: {
                question_id: null,
                display_mode: "edit"

            },
            _create: function() {//creates the timer and starts it ticking
                var self = this,
                    o = self.options,
                    el = self.element,
                    localId = el[0].id;

                    if (this.options.question_id == null) {
                        this.options.question_id = this.element.attr('question_id');
                    }
                    /*
                    $.ajax({
                        type: "GET",
                        url: o.ajaxUrlRoot + "increment/",//Calling increment with a blank returns a new timerId for us
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        async: false,
                        success : function(data) {
                            $serverTimerID = data;
                        }
                    });
                    */
                this.displayQuestion();


            },
            displayQuestion: function(){//displays on a div or a panel
                this.element.append(this.options.question_id);
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