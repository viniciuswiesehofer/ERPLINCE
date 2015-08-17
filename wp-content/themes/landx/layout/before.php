<?php
		if(is_single())
			$layout = (function_exists('ot_get_option'))? ot_get_option( 'single_layout', 'rs' ) : 'rs';
		else
			$layout = (function_exists('ot_get_option'))? ot_get_option( 'blog_layout', 'rs' ) : 'rs';
		
		if( $layout == 'full' ){
			$container_class = 'col-md-10 col-md-offset-1';
		}else{
			$container_class = 'col-lg-8 col-md-8';
			$container_class .= ( $layout == 'ls' )? $container_class.' pull-right' : '';
		}
	?>
<section class="blog-posts">
	<div class="container">
			<div class="row">
			<div class="<?php echo $container_class; ?>">
