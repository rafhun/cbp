/**
 * This holds common patterns used throughout the Contrexx JS API and is intended to minimize future coding efforts.
 */
cx.tools = {};

/**
 * A class implementing Event handling based on a pimped Observer-Pattern
 */
cx.tools.Events = function() {
    //an object holding all events known
    var events = {};

    //a function called as soon as a so far unknown event is bound
    var newEventHandler = null;

    //public properties of Events
    return {
        //call callback on event
        bind: function(name, callback) {
            if(!events[name]) { //event unbound so far
                events[name] = []; //create array for callbacks
                if(newEventHandler) //if a handler is set, call it
                    newEventHandler(name);
            }
            //assign the callback
            events[name].push(callback);
        },
        //sets a function eh(name) called before a so far unboud event is getting bound
        newBehaviour: function(callback) {
            newEventHandler = callback;
        },
        //calls all callbacks for event 'name' with the data provided as argument
        notify: function(name,data) {
            if(events[name]) {
                cx.jQuery.each(events[name],function(index,callback) {
                    callback(data);
                });
            }
        }
    };
};

// init the status message object

/**
 * StatusMessage function to show status messages
 * currently used in content manager and frontend editing
 *
 * @returns {{showMessage: Function, removeAllDialogs: Function}}
 * @constructor
 */
cx.tools.StatusMessage = function() {
    var timeout = null;

    /**
     * Messages to show (used as wait list)
     * @type {Array}
     */
    var messages = [];

    /**
     * The default options for the dialog
     * @type {{draggable: boolean, resizable: boolean, minWidth: number, minHeight: number, dialogClass: string, position: Array}}
     */
    var defaultOptions = {
        draggable: false,
        resizable: false,
        minWidth: 100,
        minHeight: 28,
        dialogClass: "cxDialog noTitle",
        position: ["center", "top"]
    };

    /**
     * Shows a new message in dialog
     *
     * If a message is currently displayed, put the message into the wait list
     *
     * @param message Message to show
     * @param cssClass Additional css class (for example 'warning' or 'error')
     * @param showTime After the amount of seconds, the dialog will be destroyed and the next message shown
     * @param callbackAfterDestroy This function is called after the showTime
     * @param options Show options of jquery ui dialog
     */
    var showMessage = function(message, cssClass, showTime, callbackAfterDestroy, options) {
        removeAllDialogs(true);
        // add new message
        messages.push({
            message: message,
            cssClass: cssClass,
            showTime: showTime,
            callbackAfterDestroy: callbackAfterDestroy,
            options: options
        });
        if (!timeout) {
            // show new message if no temporary message is visible
            // remove permanent dialogs
            displayMessage();
        }
    };

    /**
     * Display the first message from the messages array
     */
    var displayMessage = function() {
        if (messages.length == 0) return;
        var message = cx.jQuery(messages).first()[0];
        var options = cx.jQuery.extend({}, defaultOptions, message.options);

        cx.jQuery("<div class=\"" + message.cssClass + "\">" + message.message + "</div>").dialog(options);
        if (message.showTime) {
            // if it is a temporary message, set the timer
            timeout = setTimeout(
                function() {
                    // run callback function
                    if (message.callbackAfterDestroy) {
                        message.callbackAfterDestroy();
                    }
                    // remove current dialog
                    removeCurrentDialog();
                    // display next message
                    displayMessage();
                },
                message.showTime
            );
        }
    };

    /**
     * Remove the current dialog from screen
     */
    var removeCurrentDialog = function() {
        // remove first element from messages array
        messages.splice(0, 1);
        clearTimeout(timeout);
        timeout = null;
        cx.jQuery(".cxDialog .ui-dialog-content").dialog("destroy");
    };

    /**
     * Remove dialogs from screen
     * @param onlyPermanentMessages if true remove allk permanent messages which are not visible for an amount of seconds, if false remove all dialogs
     */
    var removeAllDialogs = function(onlyPermanentMessages) {
        // remove current dialog if it is a permanent dialog
        var activeMessageIsTemporary = cx.jQuery(messages).length > 0 && messages[0].showTime;
        if (!activeMessageIsTemporary) {
            // only remove current dialog if it is not temporary
            removeCurrentDialog();
        }

        // check whether to delete all messages or only the permanent ones
        if (onlyPermanentMessages) {
            // loop through messages and remove permanently shown messages
            cx.jQuery(messages).each(function(index, message) {
                // check if it is a permanent message without a showTime
                if(!message.showTime) {
                    messages.splice(index, 1);
                }
            });
        } else {
            // remove all dialogs
            if (!activeMessageIsTemporary) {
                clearTimeout(timeout);
                timeout = null;
            }
            messages = [];
        }
    };

    // return the public functions, so they can be used by controllers
    return {
        showMessage: showMessage,
        removeAllDialogs: removeAllDialogs
    };
};

/**
 * Status Message Object
 * @type {cx.tools.StatusMessage}
 */
cx.tools.StatusMessage = new cx.tools.StatusMessage();