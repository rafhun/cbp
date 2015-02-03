/* Swiss-German initialisation for the jQuery UI date picker plugin. */
/* By Douglas Jose & Juerg Meier. */
jQuery(function($){
	$.datepicker.regional['de-CH'] = {
		closeText: 'schliessen',
		prevText: '&#x3c;zurück',
		nextText: 'nächster&#x3e;',
		currentText: 'heute',
		monthNames: ['Januar','Februar','März','April','Mai','Juni',
		'Juli','August','September','Oktober','November','Dezember'],
		monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
		'Jul','Aug','Sep','Okt','Nov','Dez'],
		dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
		dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
		dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
		weekHeader: 'Wo',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
    };
	$.datepicker.setDefaults($.datepicker.regional['de-CH']);
    $.timepicker.regional['de-CH'] = {
		currentText: 'jetzt',
		closeText: 'fertig',
		ampm: false,
		timeFormat: 'hh:mm:ss',
		timeOnlyTitle: 'Zeit auswählen',
		timeText: 'Zeit',
		hourText: 'Stunde',
		minuteText: 'Minute',
		secondText: 'Sekunde'
    };
	$.timepicker.setDefaults($.timepicker.regional['de-CH']);
});