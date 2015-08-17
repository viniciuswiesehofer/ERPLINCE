<?php
/*Include functions */

global $perch_editor_buttons;
$perch_editor_buttons=array("perchfeatures", "perchbreak");

add_action( 'init', 'add_perch_editor_buttons' );
function add_perch_editor_buttons() {
     add_filter('mce_external_plugins', 'add_perch_editor_btn_tinymce_plugin');
     add_filter('mce_buttons_3', 'register_perch_editor_buttons');
}

function register_perch_editor_buttons($buttons) {
	global $perch_editor_buttons;
		
   array_push($buttons, implode(",",$perch_editor_buttons));
   return $buttons;
}

function add_perch_editor_btn_tinymce_plugin($plugin_array) {
	global $perch_editor_buttons;
	
	foreach($perch_editor_buttons as $btn){
		$plugin_array[$btn] = THEMEURI. '/admin/editor-buttons/editor-plugin.js';
	}
	return $plugin_array;

}


?>