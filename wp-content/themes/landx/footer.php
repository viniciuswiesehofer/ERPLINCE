<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 */
?>
<!-- =========================
     FOOTER 
============================== -->
<?php
$social_array = array(
            array(
              'title' => 'Facebook',
              'link'  => '#',
              'icon'  => 'social_facebook_square'
              ),
            array(
              'title' => 'Twitter',
              'link'  => '#',
              'icon'  => 'social_twitter_square'
              ),
            array(
              'title' => 'Pinterest',
              'link'  => '#',
              'icon'  => 'social_pinterest_square'
              ),
            array(
              'title' => 'Google+',
              'link'  => '#',
              'icon'  => 'social_googleplus_square'
              ),
            array(
              'title' => 'Instragram',
              'link'  => '#',
              'icon'  => 'social_instagram_square'
              ),
            array(
              'title' => 'Linkdin',
              'link'  => '#',
              'icon'  => 'social_linkedin_square'
              ),
			  array(
              'title' => 'Youtube',
              'link'  => '#',
              'icon'  => 'social_youtube_square'
              ),
			  array(
              'title' => 'VK',
              'link'  => '#',
              'icon'  => 'fa fa-vk'
              ),
            );
if( function_exists('ot_get_option') ){
	$logo = ot_get_option( 'footer_logo' );
	$copyright_text =  ot_get_option( 'copyright_text', '&copy;2014 LandX Template LLC.' );
	$social_array = ot_get_option( 'footer_social_icons', array() );
}
?>
<footer class="bgcolor-2">
<div class="container">
	
	<div class="footer-logo">
		<img src="<?php echo $logo; ?>" alt="">
	</div>
	
	<div class="copyright">
		<?php echo do_shortcode($copyright_text); ?> 
	</div>
	
	<?php 
	$icon_display = ot_get_option( 'social_icon_display' );
	if( !empty($social_array) && ($icon_display == 'on') ): ?>
	<ul class="social-icons">
		<?php foreach ($social_array as $key => $value) {
			echo '<li><a href="'.$value['link'].'" title="'.$value['title'].'"><span class="'.$value['icon'].'"></span></a></li>';
		} ?>
	</ul>
	<?php endif; ?>
	
</div>
</footer>

  <?php wp_footer(); ?>
</body>
</html>