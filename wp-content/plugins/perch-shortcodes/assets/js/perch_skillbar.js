jQuery(function($){
	$(document).ready(function(){
		$('.perch-skillbar').each(function(){
			$(this).find('.perch-skillbar-bar').animate({ width: $(this).attr('data-percent') }, 1500 );
		});
	});
});