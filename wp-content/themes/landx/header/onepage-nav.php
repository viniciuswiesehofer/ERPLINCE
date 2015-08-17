<?php
	if( function_exists('ot_get_option') ){
	$menu_logo = ot_get_option( 'main_logo' );
	}else{
		$menu_logo = THEMEURI. 'images/logo-dark.png';
	}
	$header_logo_display = get_post_meta( get_the_ID(), 'header_logo_display', true );
	$header_logo = get_post_meta( get_the_ID(), 'header_logo', true );
	$social_button_display = get_post_meta( get_the_ID(), 'social_button_display', true );

	$nav_display_type = get_post_meta( get_the_ID(), 'nav_display_type', true );

	$pages = get_post_meta( get_the_ID(), 'pages', true );

	$home_link = get_post_meta( get_the_ID(), 'home_link', true );
	if( $home_link == 'on' ){
		$li = '<li><a href="'.esc_url( home_url( '/' )).'#home">'.get_post_meta( get_the_ID(), 'home_text', true ).'</a></li>';
	}else
	$li = '';
	
	if(!empty($pages)):
		foreach ($pages as $key => $value) {
			$title = ( $value['title'] == '')? get_the_title() : $value['title'];
			$text_title = sprintf(__( '%1$s', THEMENAME ), $title);
			
			if( $value['display_in_menu'] == 'on' ){
				$link = ( $value['link_type'] == 'internal' )? get_permalink(get_the_ID()).'#'.get_the_slug($value['page_id']) : get_permalink($value['page_id']);
				if($value['link_type'] == 'custom_link'){ $link = $value['custom_link_url'];}
				$li .= ( $value['page_id'] != '' )? "\r\n".'<li><a href="'.$link.'">'.$text_title.'</a></li>' : '';
			}
			
		}
	endif;

	if ( class_exists( 'WooCommerce' ) ) {
		if(ot_get_option('cart_menu_onepage', 'off') == 'on'){
			$li .= '<li><a class="cart-contents" href="'.WC()->cart->get_cart_url().'" title="'.__( 'View your shopping cart' ).'">'.sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ).' - '. WC()->cart->get_cart_total().'</a></li>';
		}			
	}


?>
<div class="navigation-header">		
	<?php $navclass =  ($nav_display_type == 'on')? ' header-on' : ''?>
	<!-- STICKY NAVIGATION -->
	<div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation<?php echo $navclass; ?>">
		<div class="container">
			<div class="navbar-header">					
				<!-- LOGO ON STICKY NAV BAR -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#landx-navigation">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo $menu_logo; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>					
			</div>
			
			<!-- NAVIGATION LINKS -->
			<div class="navbar-collapse collapse" id="landx-navigation">
				<ul class="nav navbar-nav navbar-right main-navigation">
					<?php echo $li; ?>
				</ul>
			</div>				
		</div><!-- /END CONTAINER -->			
	</div><!-- /END STICKY NAVIGATION -->
	
	<!-- ONLY LOGO ON HEADER -->
	<div class="navbar non-sticky">			
		<div class="container">
			<?php if($header_logo_display == 'on'): ?>
			<div class="navbar-header">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo $header_logo; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
			</div>
			<?php endif; ?>
			<?php
				$social_array = array(
				            array(
				              'title' => 'Facebook',
				              'link'  => '#',
				              'icon'  => 'social_facebook_circle'
				              ),
				            array(
				              'title' => 'Twitter',
				              'link'  => '#',
				              'icon'  => 'social_twitter_circle'
				              ),
				            array(
				              'title' => 'Linkdin',
				              'link'  => '#',
				              'icon'  => 'social_linkedin_circle'
				              ),
				            );
				if( function_exists('ot_get_option') ){
					$social_array = ot_get_option( 'header_social_icons', array() );
				}
				?>
			<?php if( !empty($social_array) && ($social_button_display == 'on') ): ?>
			<ul class="nav navbar-nav navbar-right social-navigation hidden-xs">
				<?php foreach ($social_array as $key => $value) {
					echo '<li><a href="'.$value['link'].'" title="'.$value['title'].'"><i class="'.$value['icon'].'"></i></a></li>';
				} ?>
			
			</ul>
			<?php endif; ?>
		</div><!-- /END CONTAINER -->			
	</div><!-- /END ONLY LOGO ON HEADER -->
</div>