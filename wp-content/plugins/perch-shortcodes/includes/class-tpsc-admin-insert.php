<?php
/**
 * Creates the admin interface to add shortcodes to the editor
 *
 * @package  PerchShortcodes
 * @since 2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * TPSC_Admin_Insert class
 */
class TPSC_Admin_Insert {

	/**
	 * __construct function
	 *
	 * @access public
	 * @return  void
	 */
	public function __construct() {
		add_action( 'media_buttons', array( $this, 'media_buttons' ), 20 );
		add_action( 'admin_footer', array( $this, 'tpsc_popup_html' ) );
	}

	/**
	 * media_buttons function
	 *
	 * @access public
	 * @return void
	 */
	public function media_buttons( $editor_id = 'content' ) {
		global $pagenow;
		$output = '';
		// Only run on add/edit screens
		
			$output = '<a href="#TB_inline?width=4000&amp;inlineId=tpsc-choose-shortcode" class="thickbox button tpsc-thicbox" title="' . __( 'Insert Shortcode', 'tpsc' ) . '">' . __( 'Insert Shortcode', 'tpsc' ) . '</a>';
		
		echo $output;
	}

	/**
	 * Build out the input fields for shortcode content
	 * @param  string $key
	 * @param  array $param the parameters of the input
	 * @return void
	 */
	public function tpsc_build_fields($key, $param) {
		

		return tpsc_form_build_fields($key, $param);
	}

	/**
	 * Popup window
	 *
	 * Print the footer code needed for the Insert Shortcode Popup
	 *
	 * @since 2.0
	 * @global $pagenow
	 * @return void Prints HTML
	 */
	function tpsc_popup_html() {
		global $pagenow;
		include(TPSC_PLUGIN_DIR . 'includes/config.php');

		// Only run in add/edit screens
		//if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) { ?>

			<script type="text/javascript">

		
				
				function tpscAddClass(obj){
					jQuery('.tpsc-thicbox').removeClass('currenteditor');
					jQuery(obj).addClass('currenteditor');
				}

				function tpscInsertShortcode() {
					// Grab input content, build the shortcodes, and insert them
					
					

					// into the content editor
					var select = jQuery('#select-tpsc-shortcode').val(),
						type = select.replace('tpsc-', '').replace('-shortcode', ''),
						template = jQuery('#' + select).data('shortcode-template'),
						childTemplate = jQuery('#' + select).data('shortcode-child-template'),
						tables = jQuery('#' + select).find('table').not('.tpsc-clone-template'),
						attributes = '',
						content = '',
						contentToEditor = '';

					// go over each table, build the shortcode content
					for (var i = 0; i < tables.length; i++) {
						var elems = jQuery(tables[i]).find('input, select, textarea');

						// Build an attributes string by mapping over the input
						// fields in a given table.
						attributes = jQuery.map(elems, function(el, index) {
							var $el = jQuery(el);

							console.log(el);

							if( $el.attr('id') === 'content' ) {
								content = $el.val();
								return '';
							} else if( $el.attr('id') === 'last' ) {
								if( $el.is(':checked') ) {
									return $el.attr('id') + '="true"';
								} else {
									return '';
								}
							} else {
								return $el.attr('id') + '="' + $el.val() + '"';
							}
						});
						attributes = attributes.join(' ').trim();

						// Place the attributes and content within the provided
						// shortcode template
						if( childTemplate ) {
							// Run the replace on attributes for columns because the
							// attributes are really the shortcodes
							contentToEditor += childTemplate.replace('{{attributes}}', attributes).replace('{{attributes}}', attributes).replace('{{content}}', content);
						} else {
							// Run the replace on attributes for columns because the
							// attributes are really the shortcodes
							contentToEditor += template.replace('{{attributes}}', attributes).replace('{{attributes}}', attributes).replace('{{content}}', content);
						}
					};

					// Insert built content into the parent template
					if( childTemplate ) {
						contentToEditor = template.replace('{{child_shortcode}}', contentToEditor);
					}

					var id = jQuery('.currenteditor').closest('.widget').attr('id');
					var id2 = jQuery('.currenteditor').closest('.ui-widget-content').attr('id');
					if(id){
						jQuery('.currenteditor').closest('.widget').find('.perch-shortcode-area').empty().append(contentToEditor);
	
					}else if(id2){
						jQuery('.currenteditor').closest('.ui-widget-content').find('.perch-shortcode-area').empty().append(contentToEditor);

					}else{
						// Send the shortcode to the content editor and reset the fields
						window.send_to_editor( contentToEditor );
					}
					jQuery('.thickbox').removeClass('currenteditor');
					tpscResetFields();
					tb_remove();
				}

				// Set the inputs to empty state
				function tpscResetFields() {
					jQuery('#tpsc-shortcode-title').text('');
					jQuery('#tpsc-shortcode-wrap').find('input[type=text], select').val('');
					jQuery('#tpsc-shortcode-wrap').find('textarea').text('');
					jQuery('.tpsc-was-cloned').remove();
					jQuery('.tpsc-shortcode-type').hide();
				}

				// Function to redraw the thickbox for new content
				function tpscResizeTB() {
					var	ajaxCont = jQuery('#TB_ajaxContent'),
						tbWindow = jQuery('#TB_window'),
						perchPopup = jQuery('#tpsc-shortcode-wrap');

					ajaxCont.css({
						height: (tbWindow.outerHeight()-47),
						overflow: 'auto', // IMPORTANT
						width: (tbWindow.outerWidth() - 30)
					});
				}

				// Simple function to clone an included template
				function tpscCloneContent(el) {
					var clone = jQuery(el).find('.tpsc-clone-template').clone().removeClass('hidden tpsc-clone-template').removeAttr('id').addClass('tpsc-was-cloned');

					jQuery(el).append(clone);
				}

				jQuery(document).ready(function($) {
					var $shortcodes = $('.tpsc-shortcode-type').hide(),
						$title = $('#tpsc-shortcode-title');

					// Show the selected shortcode input fields
	                $('#select-tpsc-shortcode').change(function () {
	                	var text = $(this).find('option:selected').text();

	                	$shortcodes.hide();
	                	$title.text(text);
	                    $('#' + $(this).val()).show();
	                    tpscResizeTB();
	                });

	                // Clone a set of input fields
	                $('.clone-content').on('click', function() {
						var el = $(this).siblings('.tpsc-sortable');

						tpscCloneContent(el);
						tpscResizeTB();
						$('.tpsc-sortable').sortable('refresh');
					});

	                // Remove a set of input fields
					$('.tpsc-shortcode-type').on('click', '.tpsc-remove' ,function() {
						$(this).closest('table').remove();
					});

					// Make content sortable using the jQuery UI Sortable method
					$('.tpsc-sortable').sortable({
						items: 'table:not(".hidden")',
						placeholder: 'tpsc-sortable-placeholder'
					});

					//color picker
					var myOptions = {
					    // you can declare a default color here,
					    // or in the data-default-color attribute on the input
					    defaultColor: false,
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
					 
					$('.perch-form-colorbox').wpColorPicker(myOptions);

					//Range slider
					$( ".slider-range-max" ).each(function(){
					 $( this ).slider({
							range: "max",
							min: $(this).data('min'),
							max: $(this).data('max'),
							step: $(this).data('step'),
							value: $(this).data('value'),
							slide: function( event, ui ) {
								$( this ).closest('td').find( ".perch-form-slider" ).val( ui.value );
							}
						});

						$( ".perch-form-slider" ).each(function(){
							$( this ).val( $( this ).closest('td').find( ".slider-range-max" ).attr( "data-value" ) );
						})
						
						
					})

					$( ".perch-form-slider" ).change(function(){
							$(this).closest('td').find('.slider-range-max').slider( "value", $(this).val() );
						})


					// Uploading files

	if (jQuery('.fg_removeall').hasClass('premp6')) {var button = '<button class="media-modal-icon"></button>';}

	else {var button = '<button></button>';}
	
	jQuery('.fg_select').each(function(){
		jQuery(this).on('click', function(event){
			jQuery(this).closest('td').find('input').addClass('tempclass');

			event.preventDefault();
			
			// If the media frame already exists, reopen it.
			if ( file_frame ) {
				file_frame.open();
				fixBackButton();
				return;
			}
			
			// Create the media frame.
			var file_frame = wp.media.frame = wp.media({
				frame: "post",
				state: "featured-gallery",
				library : { type : 'image'},
				button: {text: "Edit Image Order"},
				multiple: true
			});

			// Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
			file_frame.states.add([
				new wp.media.controller.Library({
					id:         'featured-gallery',
					title:      'Select Images for Gallery',
					priority:   20,
					toolbar:    'main-gallery',
					filterable: 'uploaded',
					library:    wp.media.query( file_frame.options.library ),
					multiple:   file_frame.options.multiple ? 'reset' : false,
					editable:   true,
					allowLocalEdits: true,
					displaySettings: true,
					displayUserSettings: true
				}),
			]);

			
			
			file_frame.on('open', function() {
				var selection = file_frame.state().get('selection');
				var library = file_frame.state('gallery-edit').get('library');
				var ids = jQuery('.tempclass').val();

				if (ids) {
					idsArray = ids.split(',');
					idsArray.forEach(function(id) {
						attachment = wp.media.attachment(id);
						attachment.fetch();
						selection.add( attachment ? [ attachment ] : [] );
					});
					file_frame.setState('gallery-edit');
					idsArray.forEach(function(id) {
						attachment = wp.media.attachment(id);
						attachment.fetch();
						library.add( attachment ? [ attachment ] : [] );
					});
					
				}
			});

			file_frame.on('ready', function() {
				jQuery( '.media-modal' ).addClass( 'no-sidebar' );
			});

			file_frame.on('change', function() {
				fixBackButton();
			});
			 
			// When an image is selected, run a callback.
			file_frame.on('update', function() {
				var imageIDArray = [];
				var imageHTML = '';
				var metadataString = '';
				images = file_frame.state().get('library');
				images.each(function(attachment) {
					imageIDArray.push(attachment.attributes.id);
					imageHTML += '<li>'+button+'<img id="'+attachment.attributes.id+'" src="'+attachment.attributes.url+'"></li>';
				});
				metadataString = imageIDArray.join(",");
				if (metadataString) {
					jQuery('.tempclass').val(metadataString);
					jQuery('.tempclass').closest('td').find(".featuredgallerydiv ul").html(imageHTML);
					jQuery('.tempclass').closest('td').find('.fg_select').text('Edit Selection');
					jQuery('.tempclass').closest('td').find('.fg_removeall').addClass('visible');
					setTimeout(function(){
						ajaxUpdateTempMetaData();
					},0);
				}
			});
			 
			// Finally, open the modal
			file_frame.open();

		});
	})//each
	

		jQuery('.featuredgallerydiv ul').on('click', 'button', function(event){

			event.preventDefault();

			if (confirm('Are you sure you want to remove this image?')) {

				var removedImage = jQuery(this).parent().children('img').attr('id');

				var oldGallery = jQuery(".fg_perm_metadata").val();

				var newGallery = oldGallery.replace(','+removedImage,'').replace(removedImage+',','').replace(removedImage,'');

				jQuery(this).parent('li').remove();

				jQuery(".fg_perm_metadata").val(newGallery);

				if (newGallery == "") {

					jQuery(this).closest('td').find('.fg_select').text('Select Images');

					jQuery(this).closest('td').find('.fg_removeall').removeClass('visible');

				}

				ajaxUpdateTempMetaData();

			}

		});

		jQuery('.fg_removeall').on('click', function(event){

			event.preventDefault();

			if (confirm('Are you sure you want to remove all images?')) {

				jQuery(this).closest('td').find(".featuredgallerydiv ul").html("");

				jQuery(this).closest('td').find(".fg_perm_metadata").val("");

				jQuery(this).closest('td').find('.fg_removeall').removeClass('visible');

				jQuery(this).closest('td').find('.fg_select').text('Select Images');

				ajaxUpdateTempMetaData();

			}

		});

	

	$('.icon-picker').iconPicker();
					
					

	            });
			</script>

			<div id="tpsc-choose-shortcode" style="display: none;">
				<div id="tpsc-shortcode-wrap" class="wrap tpsc-shortcode-wrap">
					<div class="tpsc-shortcode-select">
						<label for="tpsc-shortcode"><?php _e('Select the shortcode type', 'tpsc'); ?></label>
						<select name="tpsc-shortcode" id="select-tpsc-shortcode">
							<option><?php _e('Select Shortcode', 'tpsc'); ?></option>
							<?php foreach( $perch_shortcodes as $shortcode ) {
								echo '<option data-title="' . $shortcode['title'] . '" value="' . $shortcode['id'] . '">' . $shortcode['title'] . '</option>';
							} ?>
						</select>
					</div>

					<h3 id="tpsc-shortcode-title"></h3>

				<?php

				$html = '';
				$clone_button = array( 'show' => false );

				// Loop through each shortcode building content
				foreach( $perch_shortcodes as $key => $shortcode ) {

					// Add shortcode templates to be used when building with JS
					$shortcode_template = ' data-shortcode-template="' . $shortcode['template'] . '"';
					if( array_key_exists('child_shortcode', $shortcode ) ) {
						$shortcode_template .= ' data-shortcode-child-template="' . $shortcode['child_shortcode']['template'] . '"';
					}

					// Individual shortcode 'block'
					$html .= '<div id="' . $shortcode['id'] . '" class="tpsc-shortcode-type" ' . $shortcode_template . '>';

					// If shortcode has children, it can be cloned and is sortable.
					// Add a hidden clone template, and set clone button to be displayed.
					if( array_key_exists('child_shortcode', $shortcode ) ) {
						$html .= (isset($shortcode['child_shortcode']['shortcode']) ? $shortcode['child_shortcode']['shortcode'] : null);
						$shortcode['params'] = $shortcode['child_shortcode']['params'];
						$clone_button['show'] = true;
						$clone_button['text'] = $shortcode['child_shortcode']['clone_button'];
						$html .= '<div class="tpsc-sortable">';
						$html .= '<table id="clone-' . $shortcode['id'] . '" class="hidden tpsc-clone-template"><tbody>';
						foreach( $shortcode['params'] as $key => $param ) {
							$html .= $this->tpsc_build_fields($key, $param);
						}
						if( $clone_button['show'] ) {
							$html .= '<tr><td colspan="2"><a href="#" class="tpsc-remove">' . __('Remove', 'tpsc') . '</a></td></tr>';
						}
						$html .= '</tbody></table>';
					}

					// Build the actual shortcode input fields
					$html .= '<table><tbody>';
					foreach( $shortcode['params'] as $key => $param ) {
						$html .= $this->tpsc_build_fields($key, $param);
					}

					// Add a link to remove a content block
					if( $clone_button['show'] ) {
						$html .= '<tr><td colspan="2"><a href="#" class="tpsc-remove">' . __('Remove', 'tpsc') . '</a></td></tr>';
					}
					$html .= '</tbody></table>';

					// Close out the sortable div and display the clone button as needed
					if( $clone_button['show'] ) {
						$html .= '</div>';
						$html .= '<a id="add-' . $shortcode['id'] . '" href="#" class="button-secondary clone-content">' . $clone_button['text'] . '</a>';
						$clone_button['show'] = false;
					}

					// Display notes if provided
					if( array_key_exists('notes', $shortcode) ) {
						$html .= '<p class="tpsc-notes">' . $shortcode['notes'] . '</p>';
					}
					$html .= '</div>';
				}

				echo $html;
				?>

				<p class="submit">
					<input type="button" id="tpsc-insert-shortcode" class="button-primary" value="<?php _e('Insert Shortcode', 'tpsc'); ?>" onclick="tpscInsertShortcode();" />
					<a href="#" id="tpsc-cancel-shortcode-insert" class="button-secondary tpsc-cancel-shortcode-insert" onclick="tb_remove();"><?php _e('Cancel', 'tpsc'); ?></a>
				</p>
				</div>
			</div>

		<?php
		}
	}
//}

new TPSC_Admin_Insert();