<?php
if( function_exists('ot_get_option') ){
	$logo = ot_get_option( 'main_logo' );
}else{
	$logo = THEMEURI. 'images/logo-dark.png';
}
?>
<!-- STICKY NAVIGATION -->
<div class="navbar navbar-inverse bs-docs-nav sticky-navigation">
	<div class="container">
		<div class="navbar-header">
			<!-- LOGO ON STICKY NAV BAR -->
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#landx-navigation">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo $logo; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
		</div>
		<!-- NAVIGATION LINKS -->
		<div class="navbar-collapse collapse" id="landx-navigation">
		<?php
		$cart = '';
		if ( class_exists( 'WooCommerce' ) ) {
			if(ot_get_option('cart_menu', 'on') == 'on'){
				$cart = '<li><a class="cart-contents" href="'.WC()->cart->get_cart_url().'" title="'.__( 'View your shopping cart' ).'">'.sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ).' - '. WC()->cart->get_cart_total().'</a></li>';
			}			
		}
        $args = array(
		'theme_location'  => 'header-menu',
		'menu_class'      => 'nav navbar-nav navbar-right main-navigation multipage-menu',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s'.$cart.'</ul>',
		'fallback_cb'     => 'default_landx_menu',
		'container'       => '',
		);
		wp_nav_menu( $args );
		?>
		</div>
	</div>
	<!-- /END CONTAINER -->
</div>

