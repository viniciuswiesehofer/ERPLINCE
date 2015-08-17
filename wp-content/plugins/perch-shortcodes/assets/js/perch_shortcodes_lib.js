jQuery(function($){
	$(document).ready(function(){
		
		// Toggle
		$("h3.perch-toggle-trigger").click(function(){
			$(this).toggleClass("active").next().slideToggle("fast");
			return false; //Prevent the browser jump to the link anchor
		});
					
		// UI tabs
		$( ".perch-tabs" ).tabs();
		
		// UI accordion
		$(".perch-accordion").accordion({autoHeight: false});		

	}); // END doc ready
}); // END function ($)