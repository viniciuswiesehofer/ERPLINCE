<?php
	$shop_layout = ot_get_option( 'shop_layout' );
	$shop_layout = ( $shop_layout == '' )? 'rs' : $shop_layout;
	
	if( $shop_layout != 'full' ){
		$shop_sidebar = ot_get_option( 'shop_sidebar' );
		if( $shop_layout != 'ds' ){
			$shop_container_class = 'col-lg-8 col-md-8';
			$shop_sidebar_class = 'col-lg-4 col-md-4';
			$shop_container_class .= ( $shop_layout == 'ls' )? $shop_container_class.' pull-right' : '';
		}
	}
	
	$product_layout = ot_get_option( 'product_layout' );
	$product_layout = ( $product_layout == '' )? 'rs' : $product_layout;
	
	if( $product_layout != 'full' ){
		$product_sidebar = ot_get_option( 'product_sidebar' );
		if( $product_layout != 'ds' ){
			$product_container_class = 'col-lg-8 col-md-8';
			$product_sidebar_class = 'col-lg-4 col-md-4';
			$product_container_class .= ( $product_layout == 'ls' )? $product_container_class.' pull-right' : '';
		}
	}

$args = 'before_widget = <div class="widget">&after_widget=</div>&before_title=<h3 class="widget-title">&after_title=</h3>'; 
?>
<?php if( is_singular( 'product' ) ): ?>
	<?php if( $product_layout == 'full' ): ?>
            <?php woocommerce_content(); ?>
    <?php else: ?>
        <div class="row">
            <div class="<?php echo $product_container_class; ?>">
                    <?php woocommerce_content(); ?>
            </div>    
    
            <div class="<?php echo $product_sidebar_class; ?>">
                <div id="secondary" class="widget-area sidebar" role="complementary">
                    <?php 
                    if ( is_active_sidebar( $product_sidebar ) ) : 				
                        dynamic_sidebar( $product_sidebar );			
                    else: 
                        the_widget( 'WP_Widget_Archives', '', $args );
                        the_widget( 'WP_Widget_Pages', '', $args );  
                    endif; 
                    ?>
                </div><!-- #secondary -->
            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
	<?php if( $shop_layout == 'full' ): ?>
            <?php woocommerce_content(); ?>
    <?php else: ?>
        <div class="row">
            <div class="<?php echo $shop_container_class; ?>">
                    <?php woocommerce_content(); ?>
            </div>    
    
            <div class="<?php echo $shop_sidebar_class; ?>">
                <div id="secondary" class="widget-area sidebar" role="complementary">
                    <?php 
                    if ( is_active_sidebar( $shop_sidebar ) ) : 				
                        dynamic_sidebar( $shop_sidebar );			
                    else: 
                        the_widget( 'WP_Widget_Archives', '', $args );
                        the_widget( 'WP_Widget_Pages', '', $args );  
                    endif; 
                    ?>
                </div><!-- #secondary -->
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>	


