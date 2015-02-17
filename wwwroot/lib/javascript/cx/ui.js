(function(){ //autoexec-closure

//first dependencies: logic
//find correct dialog css
var lang = cx.variables.get('language', 'contrexx');
var requiredFiles = cx.variables.get('lazyLoadingFiles', 'contrexx');
//second dependencies: i18n
var datepickerI18n = cx.variables.get('datePickerI18nFile', 'jQueryUi');
if (datepickerI18n) {
    requiredFiles.push(datepickerI18n);
}

//load the css and jquery ui plugin
cx.internal.dependencyInclude(
    requiredFiles,
    function() {

        /**
         * Contrexx JS API: User Interface extension
         */
        var UI = function() {
            //we want jQuery at $ locally
            var $ = cx.jQuery;

            /**
             * A contrexx dialog.
             * 
             * @param array options {
             *     [ title: 'the title', ]
             *     content: <content-div> | 'html code',
             *     modal: <boolean>,
             *     autoOpen: <boolean> (default true)
             * }
             */
            var Dialog = function(options) {
                var opened = false; //is the dialog opened?

                //option handling
                var title = options.title;
                var content = options.content;

                var autoOpen;
                if(typeof(options.autoOpen) != "undefined")
                    autoOpen = options.autoOpen;
                else
                    autoOpen = true;
                
                var modal;
                if(typeof(options.modal) != "undefined") 
                    modal = options.modal;
                else
                    modal = false;

                var height = options.height ? options.height : 0;
                var width = options.width ? options.width : 0;
                var classname = options.dialogClass ? options.dialogClass : 0;
                var buttons = options.buttons ? options.buttons : {};
                var openHandler = options.open ? options.open : function () {};
                var closeHandler = options.close ? options.close : function () {};

                var position = options.position;

                //events the user specified handlers for
                var requestedEvents = options.events ? options.events : null;
                
                var dialogDiv;

                //event handling
                var events = new cx.tools.Events();

                //create bind to new event on the dialog for each bind request of user
                events.newBehaviour(function(name){
                    dialogDiv.dialog().bind('dialog'+name, function(){
                        events.notify(name);
                    });
                });

                var createDialogDiv = function() {

                    if(typeof(content) != 'string') { //content is a div
                        dialogDiv = $(content);
                    }
                    else { //content is a html string
                        //create a hidden div...
                        dialogDiv = $('<div></div>').css({display:'none'});
                        //...set the content and append it to the body
                        dialogDiv.html(content).appendTo('body:first');
                    }

                    if(title) //set title if specified (user could also set it in html)
                        dialogDiv.attr('title',title);

                    //remove all script tags; jquery fires DOM ready-event on dialog creation
                    //scripts have already been parsed once at this point and would be parsed
                    //twice if they're in a "jQuery(function(){...})"-statement
                    var scripts = dialogDiv.find("script").remove();

                    //the options that we pass to the jquery ui dialog constructor
                    var dialogOptions = {
                        dialogClass:classname,
                        modal:modal,
                        open: function (event, ui) {
                            opened = true;
                            $J(event.target).parent().css('top', '30%');
                            $J(event.target).parent().css('position', 'fixed');
                            openHandler(event, ui);
                        },
                        close: function (event, ui) {
                            opened = false;
                            closeHandler(event, ui);
                        },
                        autoOpen:autoOpen,
                        position:position,
                        buttons:buttons
                    };          
                    //handle height and width if set
                    if(height > 0)
                        dialogOptions.height = height;

                    if(width > 0)
                        dialogOptions.width = width;
                    
                    //init jquery ui dialog
                    dialogDiv.dialog(dialogOptions);

                    //bind all requested events
                    if(requestedEvents) {
                        $.each(requestedEvents, function(event, handler){
                            events.bind(event, handler);
                        });
                    }
                };

                createDialogDiv();
               
                //public properties of Dialog
                return {
                    close: function() {
                        dialogDiv.dialog('close');
                    },
                    open: function() {
                        dialogDiv.dialog('open');
                    },
                    getElement: function() {
                        return dialogDiv;
                    },
                    isOpen: function() {
                        return opened;
                    },
                    bind: function(event, handler) {
                        events.bind(event, handler);
                    }
                };        
            };

            /**
             * A contrexx tooltip.
             */
            var Tooltip = function(element) {

                selectors = new Array();
                selectors.push('.tooltip-trigger');
                if (typeof element != "undefined") {
                    selectors.push(element);
                }

                jQuery(selectors).each(function(i, selector) {

                    jQuery(selector).each(function(i, element) {

                        defaultOptions = {
                            "position": {
                                "x": "right",
                                "y": "center"
                            },
                            "offset": {
                                "x": 10,
                                "y": 0
                            },
                            "predelay": 250,
                            "relative": true
                        };

                        if ((options = jQuery(this).data('tooltip-options')) && (typeof options != "undefined")) {

                            if (typeof options.position != "undefined") {
                                if (typeof options.position.x != "undefined") {
                                    defaultOptions.position.x = options.position.x;
                                }
                                if (typeof options.position.y != "undefined") {
                                    defaultOptions.position.y = options.position.y;
                                }
                            }

                            if (typeof options.offset != "undefined") {
                                if (typeof options.offset.x != "undefined") {
                                    defaultOptions.offset.x = options.offset.x;
                                }
                                if (typeof options.offset.y != "undefined") {
                                    defaultOptions.offset.y = options.offset.y;
                                }
                            }

                            if (typeof options.predelay != "undefined") {
                                defaultOptions.predelay = options.predelay;
                            }

                            if (typeof options.relative != "undefined") {
                                defaultOptions.relative = options.relative;
                            }

                        }

                        jQuery(element).tooltip({
                            position: defaultOptions.position.y+' '+defaultOptions.position.x,
                            offset: [defaultOptions.offset.y, defaultOptions.offset.x],
                            predelay: defaultOptions.predelay,
                            relative: defaultOptions.relative
                        }).dynamic();

                    });

                });

            };

            var Expand = function(){
                
                var findNextExpanding = function(ele){
                    var element = jQuery(ele).next('.cx-expanding');
                    while(element.length < 1){
                        if(jQuery(ele).next('.cx-expanding').length > 0) {
                            element = jQuery(ele).next('.cx-expanding').first();
                        } else {
                            ele = jQuery(ele).parent();
                        }
                        if ( typeof element == 'undefined' ) {
                            jQuery(ele).children().each(function() {
                                if(jQuery(this).find('.cx-expanding').length > 0){
                                    element = jQuery(this).find('.cx-expanding').first();
                                }
                            });
                        }
                    }

                    return element;
                };
                
                var setAsUp = function(ele, isInitialising){
                    jQuery(ele).removeClass('cx-expandUp');
                    jQuery(ele).addClass('cx-expandDown');
                    jQuery(ele).children('span.cx-expandDownText').css('display', 'inline');
                    jQuery(ele).children('span.cx-expandUpText').css('display', 'none');
                    if(true == isInitialising){
                       findNextExpanding(ele).fadeOut().css('display', 'none');
                    }else{
                        findNextExpanding(ele).fadeOut();
                    }
                };
                
                var setAsDown = function(ele){
                    jQuery(ele).removeClass('cx-expandDown');
                    jQuery(ele).addClass('cx-expandUp');
                    jQuery(ele).children('span.cx-expandDownText').css('display', 'none');
                    jQuery(ele).children('span.cx-expandUpText').css('display', 'inline');
                    findNextExpanding(ele).fadeIn();
                };
                
                jQuery('.cx-expand').each(function(){
                    setAsUp(this, true);
                    jQuery(this).click(function(){
                        if(jQuery(this).hasClass('cx-expandDown')){
                            setAsDown(this);
                        }else{
                            setAsUp(this);
                        }
                    });
                });
            }

            //public properties of UI
            return {
                dialog: function(options)
                {
                    return new Dialog(options);
                },
                tooltip: function(element)
                {
                    return new Tooltip(element);
                },
                expand: function(){
                    return new Expand();
                }
            };
        };

        //add the functionality to the global cx object
        cx.ui = new UI();

        //initialize tooltips
        cx.ui.tooltip();
        
        //initialize expands
        cx.ui.expand();

    }, //end of dependencyInclude: callback
    true //dependencyInclude: chain
);


//end of autoexec-closure
})();
