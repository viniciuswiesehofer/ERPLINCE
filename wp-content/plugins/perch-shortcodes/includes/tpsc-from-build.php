<?php
function tpsc_form_build_fields($key, $param) {
		$html = '<tr>';
		$html .= '<td class="label">' . $param['label'] . ':</td>';
		switch( $param['type'] )
		{
			case 'text' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<input type="text" class="perch-form-text perch-input" name="' . $key . '" id="' . $key . '" value="' . $param['std'] . '" />' . "\n";
				$output .= '<span class="perch-form-desc">' . $param['desc'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'textarea' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<textarea rows="10" cols="30" name="' . $key . '" id="' . $key . '" class="perch-form-textarea perch-input">' . $param['std'] . '</textarea>' . "\n";
				$output .= '<span class="perch-form-desc">' . $param['desc'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'select' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<select name="' . $key . '" id="' . $key . '" class="perch-form-select perch-input">' . "\n";

				foreach( $param['options'] as $value => $option )
				{
					$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
				}

				$output .= '</select>' . "\n";
				$output .= '<span class="perch-form-desc">' . $param['desc'] . '</span></td>' . "\n";

				// append
				$html .= $output;

				break;

			case 'checkbox' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<input type="checkbox" name="' . $key . '" id="' . $key . '" class="perch-form-checkbox perch-input"' . ( $param['default'] ? 'checked' : '' ) . '>' . "\n";
				$output .= '<span class="perch-form-desc">' . $param['desc'] . '</span></td>';

				$html .= $output;

				break;
			case 'color' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<input type="text" value="' . $param['std'] . '" name="' . $key . '" id="' . $key . '" class="perch-form-colorbox perch-input">' . "\n";
				$output .= '<span class="perch-form-desc">' . $param['desc'] . '</span></td>';

				$html .= $output;

				break;	
			case 'slider' :

				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<input type="text" value="' . $param['std'] . '" name="' . $key . '" id="' . $key . '" class="perch-form-slider" ><div class="slider-range-max" data-value="' . $param['std'] . '" data-min="' . $param['min'] . '" data-max="' . $param['max'] . '" data-step="' . $param['step'] . '"></div>' . "\n";
				$output .= '<span class="perch-form-desc">' . $param['desc'] . '</span></td>';

				$html .= $output;

				break;
			case 'upload' :
				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<div class="featuredgallerydiv">
				<input type="hidden" class="fg_perm_metadata" name="'.$key.'" id="'.$key.'" value="" data-post_id="" />
				<button class="button fg_select">Select Images</button>
				<button class="button premp6 fg_removeall" >Remove All</button>
				<ul></ul>
				</div>' . "\n";
				$output .= '<span class="perch-form-desc">' . $param['desc'] . '</span>
						</td>';

				$html .= $output;

				break;	

				case 'iconpicker' :
				// prepare
				$output = '<td><label class="screen-reader-text" for="' . $key .'">' . $param['label'] . '</label>';
				$output .= '<input class="regular-text" type="hidden" id="' . $key . '" name="' . $key . '" value="' . $param['std'] . '"/>
						<div id="' . $key . '_select" data-target="#' . $key . '" class="button icon-picker"></div>';
				$output .= '<span class="perch-form-desc">' . $param['desc'] . '</span></td>';

				$html .= $output;

				break;	

			default :
				break;
		}
		$html .= '</tr>';

		return $html;
	}
?>