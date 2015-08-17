<?php
$form_display = get_post_meta( get_the_ID(), 'form_display', true );
$form_select_option = get_post_meta( get_the_ID(), 'form_select_option', true );
$contact_form_shortcode = get_post_meta( get_the_ID(), 'contact_form_shortcode', true );

if($form_display == 'on' && $form_select_option == 'contactform' && $contact_form_shortcode != ''):
echo do_shortcode($contact_form_shortcode);
else:
	if($form_display == 'on'):
	$form_title = get_post_meta( get_the_ID(), 'form_title', true );
	$form_title = ( $form_title != '' )? '<h3>'.esc_attr($form_title).'</h3>' : '';
	$form_type = get_post_meta( get_the_ID(), 'form_type', true );	
	$name_placeholder = get_post_meta( get_the_ID(), 'name_placeholder', true );
	$email_placeholder = get_post_meta( get_the_ID(), 'email_placeholder', true );
	$phone_placeholder = get_post_meta( get_the_ID(), 'phone_placeholder', true );
	$form_submit_button_text = get_post_meta( get_the_ID(), 'form_submit_button_text', true );
	if( $form_type == 'vertical' ):
	?>
	<div class="vertical-registration-form">
		<div class="colored-line">
		</div>
		<?php echo $form_title; ?>
		<form class="registration-form mailchimp" id="register" role="form">
			<!-- SUBSCRIPTION SUCCESSFUL OR ERROR MESSAGES -->
			<h6 class="subscription-success"></h6>
			<h6 class="subscription-error"></h6>
			
			<input class="form-control input-box" id="name" type="text" name="name" placeholder="<?php echo esc_attr($name_placeholder); ?>">
			<input class="form-control input-box" id="email" type="email" name="email" placeholder="<?php echo esc_attr($email_placeholder); ?>">
			<input class="form-control input-box" id="phone-number" type="text" name="phone-number" placeholder="<?php echo esc_attr($phone_placeholder); ?>">
			<button class="btn standard-button" type="submit" id="submit" name="submit"><?php echo esc_attr($form_submit_button_text); ?></button>
		</form>
	</div>
<?php else: ?>
	<div class="sf-container">
		<form class="subscription-form mailchimp form-inline" role="form">
			<?php echo $form_title; ?>
			<!-- SUBSCRIPTION SUCCESSFUL OR ERROR MESSAGES -->
			<h6 class="subscription-success"></h6>
			<h6 class="subscription-error"></h6>
			
			<!-- EMAIL INPUT BOX -->
			<input type="email" name="email" id="subscriber-email1" placeholder="<?php echo esc_attr($email_placeholder); ?>" class="form-control input-box">
			
			<!-- SUBSCRIBE BUTTON -->
			<button type="submit" id="subscribe-button1" class="btn standard-button"><?php echo esc_attr($form_submit_button_text); ?></button>
			
		</form>
	</div>
    <?php endif; ?>
<?php endif; ?>
<?php endif; ?>


