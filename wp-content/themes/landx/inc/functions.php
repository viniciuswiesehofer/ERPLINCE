<?php
function landx_excerpt_more( $more ) {
	if( function_exists('ot_get_option') ){
		return ' <a class="strong" href="'.get_permalink().'">'.ot_get_option('readmore_text').'</a>';
	}else{
		return ' <a class="strong" href="'.get_permalink().'">Read More &raquo;</a>';
	}
	

}
add_filter( 'excerpt_more', 'landx_excerpt_more' );

function landx_excerpt_length( $length ) {
	if( function_exists('ot_get_option') ){
		return ot_get_option('excerpt_length', 55);
	}else{
		return 55;
	}
	
}
add_filter( 'excerpt_length', 'landx_excerpt_length', 999 );


if ( ! function_exists( 'landx_list_authors' ) ) :
/**
 * Print a list of all site contributors who published at least one post.
 *
 */
function landx_list_authors() {
	$contributor_ids = get_users( array(
		'fields'  => 'ID',
		'orderby' => 'post_count',
		'order'   => 'DESC',
		'who'     => 'authors',
	) );

	foreach ( $contributor_ids as $contributor_id ) :
		$post_count = count_user_posts( $contributor_id );

		// Move on if user has not published a post (yet).
		if ( ! $post_count ) {
			continue;
		}
	?>

	<div class="contributor">
		<div class="contributor-info">
			<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
			<div class="contributor-summary">
				<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>
				<p class="contributor-bio">
					<?php echo get_the_author_meta( 'description', $contributor_id ); ?>
				</p>
				<a class="button contributor-posts-link" href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
					<?php printf( _n( '%d Article', '%d Articles', $post_count, THEMENAME ), $post_count ); ?>
				</a>
			</div><!-- .contributor-summary -->
		</div><!-- .contributor-info -->
	</div><!-- .contributor -->

	<?php
	endforeach;
}
endif;
/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
function landx_post_classes( $classes ) {
	if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'landx_post_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 */
function landx_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'landx' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'landx_wp_title', 10, 2 );


// landx comments form
 function landx_comment_form( $args = array(), $post_id = null ) {
	if ( null === $post_id )
		$post_id = get_the_ID();
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	if ( ! isset( $args['format'] ) )
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html5    = 'html5' === $args['format'];
	$fields   =  array(
		'author' => '<div class="field-wrapper col-md-6"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . '  placeholder="' . __( 'Your Name', 'landx' ) . '" class="form-control input-box" /></div>',
		'email'  => '<div class="field-wrapper col-md-6"><input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="' . __( 'Email', 'landx' ) . '" class="form-control input-box" /></div>',
		'url'    => '<div class="field-wrapper col-md-12"><input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="' . __( 'Website', 'landx' ) . '" class="form-control input-box" /></div>',
	);

	$required_text = sprintf( ' ' . __('Required fields are marked %s', 'landx'), '<span class="required">*</span>' );
	$defaults = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<div class="field-wrapper col-md-12"><textarea id="comment" name="comment" aria-required="true" rows="8" placeholder="' . __( 'Message', 'landx' ) . '" class="form-control textarea-box"></textarea></div>',
		'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'landx' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'landx' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'landx' ) . ( $req ? $required_text : '' ) . '</p>',
		
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Leave a Reply:', 'landx' ),
		'title_reply_to'       => __( 'Leave a comment to %s', 'landx' ),
		'cancel_reply_link'    => __( 'Cancel reply', 'landx' ),
		'label_submit'         => __( 'Post Comment', 'landx' ),
		'format'               => 'xhtml',
	);

	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	?>
		<?php if ( comments_open( $post_id ) ) : ?>
			<?php do_action( 'comment_form_before' ); ?>
			<div class="comment-form">
                <h3><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></h3>
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php do_action( 'comment_form_must_log_in_after' ); ?>
				<?php else : ?>
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="contact-form"<?php echo $html5 ? ' novalidate' : ''; ?>>
                    <?php if ( is_user_logged_in() ) : ?>
					  <?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
                    <?php endif; ?>
                                        	
						<?php do_action( 'comment_form_top' ); ?>
						
						<?php if ( is_user_logged_in() ) : ?>
							<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
                             <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
						<?php else : ?>
							<?php
							do_action( 'comment_form_before_fields' ); ?>
                            <?php
								foreach ( (array) $args['fields'] as $name => $field ) {
									echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
								}
							?>
                            <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
							<?php
							do_action( 'comment_form_after_fields' );
							?>
						<?php endif; ?>                        
						<input type="submit" class="btn standard-button" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
                        <?php comment_id_fields( $post_id ); ?>
						<?php do_action( 'comment_form', $post_id ); ?>
					</form>
				<?php endif; ?>
			</div><!--.blog-comment-form-->
			<?php do_action( 'comment_form_after' ); ?>
		<?php else : ?>
			<?php do_action( 'comment_form_comments_closed' ); ?>
		<?php endif; ?>
	<?php
 }

 if ( ! function_exists( 'landx_comments' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own landx_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
function landx_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', THEMENAME ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', THEMENAME ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class('comment-list'); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-header">
			<figure class="comment-avatar pull-left">
            <a href=""><?php echo get_avatar( $comment, 80 ); ?></a>
			</figure><!-- .comment-avatar pull-left-->
				<h6>
						<?php
						printf( '%1$s %2$s',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', THEMENAME ) . '</span>' : ''
						);
						
						?>
                        </h6>
                        <?php
						printf( '<p><span>%3$s - </span>', esc_url( get_comment_link( $comment->comment_ID ) ), get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s at %2$s', THEMENAME ), get_comment_date(), get_comment_time() )
						);
						edit_comment_link( __( 'Edit', THEMENAME ), '<span class="cedit-link">', '</span>' );
						comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', THEMENAME ), 'after' => '</p>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						
						<?php if ( '0' == $comment->comment_approved ) : ?>
							<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', THEMENAME ); ?></p>
						<?php endif; ?>

					
						<?php comment_text(); ?>
							
		</div><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;


 function default_landx_menu(){
	$html = '';
	$html .='<ul class="nav navbar-nav navbar-right main-navigation" id="header-menu-1">
			 <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1 current-menu-item">
			 <a href="' .esc_url( home_url() ). '/wp-admin/nav-menus.php" target="_blank">menu settings</a></li>
             </ul>';
  echo $html;
 }

/* Filter to the post_class. */
add_filter( 'post_class', 'remove_class' );
 
/**
* Remove class from post_class() function.
*/
function remove_class( $classes ) {
	if(is_single())$classes = array_diff( $classes, array( 'post' ) ); // seperate with commas for more than one class.
return $classes;
}


/*function get_the_slug( $id=null ){
  if( empty($id) ):
    global $post;
    if( empty($post) )
      return ''; // No global $post var available.
    $id = $post->ID;
  endif;

  $slug = basename( get_permalink($id) );
  return $slug;
}*/

function get_the_slug($id) {
   $post_data = get_post($id, ARRAY_A);
   $slug = $post_data['post_name'];
   return $slug;
}

if ( ! function_exists( 'landx_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 */
function landx_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<div class="pager-buttons" id="<?php echo $html_id; ?>">
			<?php next_posts_link( __( '<span class="btn secondary-button">&larr; Older posts</span>', 'landx' ) ); ?>
			<?php previous_posts_link( __( '<span class="btn secondary-button">Newer posts &rarr;</span>', 'landx' ) ); ?>
		</div><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;



/**
 * Display the page or post slug
 *
 * Uses get_the_slug() and applies 'the_slug' filter.
 */
/*function the_slug( $id=null ){
  echo apply_filters( 'the_slug', get_the_slug($id) );
}*/

function landx_get_font_url() {
	$font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Source Sans Pro font: on or off', 'landx' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language,
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Source Sans Pro font: add new subset (greek, cyrillic, vietnamese)', 'landx' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Source+Sans+Pro:400,700,400italic%7CRaleway:500,600,700',
			'subset' => $subsets,
		);
		$font_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $font_url;
}

function landx_mce_css( $mce_css ) {
	$font_url = landx_get_font_url();

	if ( empty( $font_url ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'landx_mce_css' );

function fix_caps_gallery_wpse43558($output, $attr) {
    global $post;

    static $instance = 0;
    $instance++;
    $size_class = '';

    /**
     *  will remove this since we don't want an endless loop going on here
     */
    // Allow plugins/themes to override the default gallery template.
    //$output = apply_filters('post_gallery', '', $attr);

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'div',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => '',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = $gallery_div = '';
    if ( apply_filters( 'use_default_gallery_style', true ) )
        /**
         * this is the css you want to remove
         *  #1 in question
         */
        /*
        */
    $size_class = ($size != '' )?sanitize_html_class( $size ) : 'normal';
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-size-{$size_class}'><div class='row'>";
    $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

    $i = 1;
	$col = 12/$columns;
	$width = round(1180/$columns);
	$height = $width;
    foreach ( $attachments as $id => $attachment ) {

        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
		 $image_url = wp_get_attachment_url($id, $size, false, false);
		 $attatchement_image = landx_image_resize( $image_url, $width, $height, true, false, false );
		$class = ($i % $columns == 0)? ' last' : '';
        
		$output .= "<{$itemtag} class='col-xs-12 col-sm-6 col-md-{$col} col-lg-{$col}{$class}'><div class='gallery-item'>";
        $output .= "<a data-lightbox-gallery='screenshots-gallery' href='".$image_url."' ><img src='" . $attatchement_image . "' alt='images thumb' /></a><h5>".$attachment->post_excerpt."</h5></div>
            </{$itemtag}>";
     $i++;   
    }
    $output .= "</div></div>\n";
    return $output;
}
add_filter("post_gallery", "fix_caps_gallery_wpse43558",10,2);

// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a> 
	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
}


require THEMEDIR . 'inc/breadcrumbs.php';

?>