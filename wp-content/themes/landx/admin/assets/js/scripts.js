jQuery(document).ready(function($) {
	 	
	  "use strict";
	  	var myOptions = {
		    // you can declare a default color here,
		    // or in the data-default-color attribute on the input
		    defaultColor: '#81d742',
		    // a callback to fire whenever the color changes to a valid color
		    change: function(event, ui){},
		    // a callback to fire when the input is emptied or an invalid color
		    clear: function() {},
		    // hide the color picker controls on load
		    hide: true,
		    // show a group of common colors beneath the square
		    // or, supply an array of colors to customize further
		    palettes: true
		};

 	$('.color').live( 'hover', function(){
 		$('.color').wpColorPicker( myOptions );
 	} )	
	
	
	var formfield;
	jQuery('.perch-upload-button').live('click', function(){
		formfield = $(this).closest('.perch-shortcode-field').find('.perch-upload-field').attr('id');
		tb_show('Upload an image', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});

	window.original_send_to_editor = window.send_to_editor;
	 window.send_to_editor = function(html) {
		if (formfield) {
			var fileurl = $('img',html).attr('src');
			$('#'+formfield).val(fileurl);			
			tb_remove();			
		}else {
			window.original_send_to_editor(html);
		} 
	};

	if($('#page_template').length > 0){
		$('#page_template').live('change', function(){

			if( $(this).val() == 'page-templates/one-page.php'  ){
				$('#landx_onepage_meta_box').show();
			}else{
				$('#landx_onepage_meta_box').hide();
			}
			
			if( $(this).val() == 'page-templates/squeeze-page.php'  ){
				$('#landx_squzee_meta_box').show();
			}else{
				$('#landx_squzee_meta_box').hide();
			}

			return false;
		})

		$('#page_template').trigger('change');
	}		    
	
});
