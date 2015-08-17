<?php
require THEMEDIR . 'admin/scripts.php';
require THEMEDIR . 'admin/mce-button.php';
require THEMEDIR . 'admin/meta-boxes.php';
require THEMEDIR . 'admin/onepage-meta-boxes.php';
require THEMEDIR . 'admin/squzee-meta-boxes.php';

function landx_login_logo() { 
	$logo = (function_exists('ot_get_option'))? ot_get_option('admin_logo') : THEMEURI.'images/logo-dark.png';
	
    echo '<style type="text/css">
        body.login div#login h1 a {
            background-image: url('.esc_url($logo).');
            background-position: bottom center; 
        }
    </style>';
 }
add_action( 'login_enqueue_scripts', 'landx_login_logo' );

function landx_options_filter($var){
    $var = (is_array($var) && ($var['type'] == 'background') || ($var['type'] == 'measurement') || ($var['type'] == 'typography')|| ($var['type'] == 'colorpicker'));

     return $var;
}


function landx_dynamic_css(){
    $settings = landx_theme_options();
    $options = array_filter($settings, "landx_options_filter");
    foreach ($options as $option) :
        if(isset($option['action'])){
            if( $option['type'] == 'background' ):
                $background = ot_get_option( $option['id'] );
                $background = (empty($background)) ? $option['std'] : $background;
                if( !empty($background) ):
                    foreach ($option['action'] as $value) {
                        if($value['selector'] != ''){
                            echo $value['selector']. '{ ';
                            foreach( $background as $key => $value ){
                                if($key == 'background-image') echo ($value != '')? $key. ': url('.esc_url($value).'); ' : '';
                                else echo ($value != '')? $key. ': '.$value.'; ' : '';
                            }
                            echo '}';
                        }
                         ?>

<?php
                    }
                endif;
            elseif( $option['type'] == 'typography' ):
                $typography = ot_get_option( $option['id'], array() );        
                $typography = empty($typography) ? $option['std'] : $typography;
                if(!empty($typography)) :
                    foreach ($option['action'] as $value) {  
                        if($value['selector'] != ''){
                            echo $value['selector']. '{ ';
                            foreach ($typography as $key => $value) {
                                if( $key == 'font-color' ) echo 'color: '.$value.'; ';
                                else echo ( $value != '' )? $key. ': '.$value.'; ' : '';
                            }
                            echo ' }';
                        }
                    }
                    ?>

<?php           
                endif;
            elseif( $option[ 'type' ] == 'colorpicker' ):   
                $colorpicker = ot_get_option( $option['id'] );  

                $colorpicker = ($colorpicker == '') ? $option['std'] : $colorpicker;

                $rgb = hex2rgb($colorpicker);

                if( $colorpicker != '' ):
                    foreach ($option['action'] as $value) {
                        $colorpicker = isset($value['opacity'])? 'rgba('.$rgb.', '.$value['opacity'].')' : $colorpicker;
                        echo ($value['selector'] != '')?$value['selector']. '{ '.$value['property'].': '.$colorpicker .'; } ' : '';
                    }           
                    ?>

<?php           
                 endif;
            elseif( $option[ 'type' ] == 'measurement' ):  
                $measurement =  ot_get_option( $option['id'], array() ); 
                $measurement = empty($measurement) ? $option['std'] : $measurement; 
                if( !empty( $measurement ) ) :
                    foreach ($option['action'] as $value) {  
                        if($value['selector'] != ''){
                            echo $value['selector']. '{ ';
                            echo $value['property'].': '.intval($measurement[0]).$measurement[1] .';';
                            echo ' }';
                        }
                    }
                    ?>

<?php           
                endif;
            endif;
        }//if(isset($option['action'])):
    endforeach;
}


function landx_animation_select(){
    return array(
        array(
            'value'       => '',
            'label'       => __( 'Select a animation', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation bounce',
            'label'       => __( 'bounce', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation flash',
            'label'       => __( 'flash', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation rubberBand',
            'label'       => __( 'rubberBand', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation shake',
            'label'       => __( 'shake', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation swing',
            'label'       => __( 'swing', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation tada',
            'label'       => __( 'tada', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation wobble',
            'label'       => __( 'wobble', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation bounceIn',
            'label'       => __( 'bounceIn', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation bounceInDown',
            'label'       => __( 'bounceInDown', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation bounceInLeft',
            'label'       => __( 'bounceInLeft', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation bounceInRight',
            'label'       => __( 'bounceInRight', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation bounceInRight',
            'label'       => __( 'bounceInRight', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation bounceInUp',
            'label'       => __( 'bounceInUp', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation fadeIn',
            'label'       => __( 'fadeIn', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation fadeInDown',
            'label'       => __( 'fadeInDown', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation fadeInDownBig',
            'label'       => __( 'fadeInDownBig', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation fadeInLeft',
            'label'       => __( 'fadeInLeft', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation fadeInLeftBig',
            'label'       => __( 'fadeInLeftBig', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation fadeInRight',
            'label'       => __( 'fadeInRight', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation fadeInRightBig',
            'label'       => __( 'fadeInRightBig', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation fadeInUp',
            'label'       => __( 'fadeInUp', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation fadeInUpBig',
            'label'       => __( 'fadeInUpBig', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation flip',
            'label'       => __( 'flip', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation flipInX',
            'label'       => __( 'flipInX', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation flipInY',
            'label'       => __( 'flipInY', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation rotateIn',
            'label'       => __( 'rotateIn', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation rotateInDownLeft',
            'label'       => __( 'rotateInDownLeft', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation rotateInDownRight',
            'label'       => __( 'rotateInDownRight', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation rotateInUpLeft',
            'label'       => __( 'rotateInUpLeft', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation rotateInUpRight',
            'label'       => __( 'rotateInUpRight', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation zoomIn',
            'label'       => __( 'zoomIn', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation zoomInDown',
            'label'       => __( 'zoomInDown', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation zoomInLeft',
            'label'       => __( 'zoomInLeft', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation zoomInRight',
            'label'       => __( 'zoomInRight', THEMENAME ),
            'src'         => ''
        ),
        array(
            'value'       => ' animation zoomInUp',
            'label'       => __( 'zoomInUp', THEMENAME ),
            'src'         => ''
        ),
    );
}

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   $rgb_color = implode(",", $rgb); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
   return $rgb_color;
}
// Add Toolbar Menus
function landx_themeperch_toolbar() {
    global $wp_admin_bar;

    $args = array(
        'id'     => 'themeperch',
        'parent' => '',
        'title'  => __( THEMENAME.' '.THEMEVERSION, 'landx' ),
        'href'   => 'http://themeforest.net/item/landx-multipurpose-wordpress-landing-page/9545842?ref=themeperch',
    );
    $wp_admin_bar->add_menu( $args );

    $args = array(
        'id'     => 'forum',
        'parent' => 'themeperch',
        'title'  => __( 'Forum support', 'landx' ),
        'href'   => 'http://www.themeperch.net/forums',
        'target' => '_blank'
    );
    $wp_admin_bar->add_menu( $args );

    $args = array(
        'id'     => 'portfolio',
        'parent' => 'themeperch',
        'title'  => __( 'Envato Portfolio', 'landx' ),
        'href'   => 'http://themeforest.net/user/themeperch/portfolio?ref=themeperch',
        'target' => '_blank'
    );
    $wp_admin_bar->add_menu( $args );

}

// Hook into the 'wp_before_admin_bar_render' action
add_action( 'wp_before_admin_bar_render', 'landx_themeperch_toolbar', 999 );

/* filter theme option header */
function landx_header_version_text($output){
  return THEMENAME.' <small>vs</small> '.THEMEVERSION;
}
add_filter('ot_header_version_text', 'landx_header_version_text');
?>
