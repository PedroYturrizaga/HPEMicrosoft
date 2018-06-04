/* MASK DE FECHA */
function initMaskInputs() {
	for(var i = 0; i < arguments.length; i++) {
		var text	= arguments[i];
		var input	= $('#'+text);
		input.mask('00/00/0000');
	}
}
function clonarFecha(inputNew,idButton) {
	$('#'+inputNew.data('time')).val(inputNew.val());
	$('#'+inputNew.data('time')).focus();
	$('#'+inputNew.data('time')).blur();
	if(idButton){
		$("#"+idButton).trigger("change");
	}
}
function initCalendarDaysMinToday(id, currentDate, fecha){
	var startDate = new Date();
	 if (currentDate != undefined) {
            var startDate = new Date(currentDate);
        }
	$("#"+id).bootstrapMaterialDatePicker({ 
		weekStart : 0, 
		date	: true, 
		time	: false, 
		format 	: 'DD/MM/YYYY',
		currentDate : startDate,
		minDate : (fecha == undefined) ? new Date() : fecha
	});
}
function initButtonCalendarDaysMinToday(idButton, currentDate, fecha) {
	var text 		= idButton;
	var id 			= $("#"+text);
	var newInput	= null;
	var iconButton 	= id.closest('.mdl-input').find('.mdl-icon');
	iconButton.find('.mdl-button').click(function(){
		newInput = text+'ForCalendar';
		if ( $('#'+newInput).length < 1 ) {
			$('<input>').attr({
			    type		: 'text',
			    id			: newInput,
			    name		: newInput,
			    'data-time'	: text,
			    onchange 	: 'clonarFecha($(this))',
			    style		: 'position: absolute; top: 40px; border: transparent; color: transparent; z-index: -4'
			}).appendTo(iconButton);
			initCalendarDaysMinToday(newInput, currentDate, fecha);
		}
		$("#"+newInput).focus();			
	});		
	var valueNewInput = $("#"+newInput).val();   
	id.text(valueNewInput);
}
function initCalendarDaysRange(id, min, max){
	$("#"+id).bootstrapMaterialDatePicker({ 
		weekStart : 0, 
		date	: true, 
		time	: false, 
		format 	: 'DD/MM/YYYY',
		minDate : min,
		maxDate : max
	});
}
function initButtonCalendarDaysRange(idButton, minDate, maxDate) {
	var text 		= idButton;
	var id 			= $("#"+text);
	var min         = minDate;
	var max         = maxDate;
	var newInput	= null;
	var iconButton 	= id.closest('.mdl-input').find('.mdl-icon');
	iconButton.find('.mdl-button').click(function(){
		newInput = text+'ForCalendar';
		if ( $('#'+newInput).length < 1 ) {
			$('<input>').attr({
			    type		: 'text',
			    id			: newInput,
			    name		: newInput,
			    'data-time'	: text,
			    onchange 	: 'clonarFecha($(this))',
			    style		: 'position: absolute; top: 40px; border: transparent; color: transparent; z-index: -4'
			}).appendTo(iconButton);
			initCalendarDaysRange(newInput, min, max);
		}
		$("#"+newInput).focus();
	});		
	var valueNewInput = $("#"+newInput).val();
	id.text(valueNewInput);
}
