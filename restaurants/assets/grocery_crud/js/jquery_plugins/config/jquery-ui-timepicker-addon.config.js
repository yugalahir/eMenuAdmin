/*$(function(){
    $('.datetime-input').datetimepicker({
    	timeFormat: 'HH:mm:ss',
		dateFormat: js_date_format,
		showButtonPanel: true,
		changeMonth: true,
		changeYear: true
    });
    
	$('.datetime-input-clear').button();
	
	$('.datetime-input-clear').click(function(){
		$(this).parent().find('.datetime-input').val("");
		return false;
	});	

});*/
$(function(){
    $('.datetime-input').datetimepicker({
    	timeFormat: 'hh:mm:ss',
	dateFormat: js_date_format,
	showButtonPanel: true,
	changeMonth: true,
	changeYear: true,
        yearRange: "1950:+nn",
    });
    
	$('.datetime-input-clear').button();
	
	$('.datetime-input-clear').click(function(){
		$(this).parent().find('.datetime-input').val("");
		return false;
	});	
 
	$('.time-input').timepicker({
		stepMinute: 5,
		timeFormat: 'HH:mm',
		hourMin: 0,
		hourMax: 23,
		addSliderAccess: true,
		sliderAccessArgs: { touchonly: false }
	});
	
	$('.time-input-clear').button();
	
	$('.time-input-clear').click(function(){
		$(this).parent().find('.time-input').val("");
		return false;
	});
	
});