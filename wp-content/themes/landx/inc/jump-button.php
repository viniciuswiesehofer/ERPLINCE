<?php
    $jump_button = get_post_meta( get_the_ID(), 'jump_button', true );
    $button_animation = get_post_meta( get_the_ID(), 'button_animation', true );
    if( $jump_button == 'on' ):
        $buttons = get_post_meta( get_the_ID(), 'buttons', true );
        if( !empty($buttons) ){
            echo '<div class="button-container'.$button_animation.'" id="cta-5">';
            foreach ($buttons as $key => $value) {
                $link = ( $value['link_type'] == 'inner' )? '#'.get_the_slug($value['page_id']) : get_permalink($value['page_id']);
                if( $value['link_type'] == 'customlink' ) $link = $value['custom_url'];
                echo '<a class="btn '.$value['button_type'].'" href="'.esc_url($link).'">'.esc_attr($value['title']).'</a>';
            }
            echo '</div>';
        }
    endif;
?>