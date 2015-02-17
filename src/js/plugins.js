// Copy stuff like jQuery plugins and similar that you do not get through bower
// to this file. Unlike the script.js file this one does not get linted
// by grunt as code quality should be given by the developers of the plugin
// Therefore be careful as to what you include to not weaken your site

// fonts.com tracking script
var MTIProjectId='5d4b0b0b-3738-4d30-a729-255608ae8b41';
 (function() {
        var mtiTracking = document.createElement('script');
        mtiTracking.type='text/javascript';
        mtiTracking.async='true';
        mtiTracking.src=('https:'==document.location.protocol?'https:':'http:')+'//fast.fonts.net/t/trackingCode.js';
        (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild( mtiTracking );
   })();
