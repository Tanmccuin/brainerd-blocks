<?php
/**
 * Contact Form block.
 *
 * Outputs a native HTML form that POSTs to admin-post.php.
 * Submission handled by mu-plugins/snippets/contact-form-handler.php.
 * SMTP config is a manual step — see REPORT.md.
 */

$submit_label = get_field( 'submit_label' ) ?: __( 'Send message', 'brainerd' );

$sent    = isset( $_GET['msg'] ) && 'sent' === $_GET['msg']; // phpcs:ignore WordPress.Security.NonceVerification
$error   = isset( $_GET['msg'] ) && 'error' === $_GET['msg'];
$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-contact-form-' . $block['id'];
$classes  = 'cb-contact-form';
if ( ! empty( $block['className'] ) ) {
	$classes .= ' ' . $block['className'];
}
?>
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">

	<?php if ( $sent ) : ?>
		<div class="cb-contact-form__success" role="alert">
			<strong><?php esc_html_e( 'Message sent!', 'brainerd' ); ?></strong>
			<?php esc_html_e( "We'll be in touch within one business day.", 'brainerd' ); ?>
		</div>
	<?php elseif ( $error ) : ?>
		<div class="cb-contact-form__error" role="alert">
			<?php esc_html_e( 'Something went wrong. Please try again or email us directly.', 'brainerd' ); ?>
		</div>
	<?php endif; ?>

	<?php if ( ! $sent ) : ?>
	<form class="cb-contact-form__form"
		method="post"
		action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
		novalidate>

		<input type="hidden" name="action" value="tmd_contact">
		<?php wp_nonce_field( 'tmd_contact', 'tmd_nonce' ); ?>

		<div class="cb-contact-form__hp" aria-hidden="true" tabindex="-1">
			<label for="contact_website">Website</label>
			<input type="text" id="contact_website" name="contact_website" autocomplete="off" tabindex="-1">
		</div>

		<div class="cb-contact-form__row cb-contact-form__row--half">
			<div class="cb-contact-form__field">
				<label for="contact_name"><?php esc_html_e( 'Name', 'brainerd' ); ?> <span aria-hidden="true">*</span></label>
				<input type="text" id="contact_name" name="contact_name"
					required autocomplete="name"
					value="<?php echo esc_attr( $_GET['_name'] ?? '' ); ?>"> <?php // phpcs:ignore ?>
			</div>
			<div class="cb-contact-form__field">
				<label for="contact_email"><?php esc_html_e( 'Email', 'brainerd' ); ?> <span aria-hidden="true">*</span></label>
				<input type="email" id="contact_email" name="contact_email"
					required autocomplete="email"
					value="<?php echo esc_attr( $_GET['_email'] ?? '' ); ?>"> <?php // phpcs:ignore ?>
			</div>
		</div>

		<div class="cb-contact-form__row cb-contact-form__row--half">
			<div class="cb-contact-form__field">
				<label for="contact_phone"><?php esc_html_e( 'Phone', 'brainerd' ); ?></label>
				<input type="tel" id="contact_phone" name="contact_phone" autocomplete="tel">
			</div>
			<div class="cb-contact-form__field">
				<label for="contact_subject"><?php esc_html_e( 'Subject', 'brainerd' ); ?></label>
				<input type="text" id="contact_subject" name="contact_subject">
			</div>
		</div>

		<div class="cb-contact-form__field">
			<label for="contact_message"><?php esc_html_e( 'Message', 'brainerd' ); ?> <span aria-hidden="true">*</span></label>
			<textarea id="contact_message" name="contact_message" rows="6" required></textarea>
		</div>

		<button type="submit" class="cb-contact-form__submit">
			<?php echo esc_html( $submit_label ); ?> →
		</button>

	</form>
	<?php endif; ?>

	<aside class="cb-contact-form__direct">
		<p>
			<?php esc_html_e( 'Prefer a direct line?', 'brainerd' ); ?><br>
			<a href="tel:+18023554520">802.355.4520</a> &nbsp;·&nbsp;
			<a href="mailto:tanner@tannermooredesign.com">tanner@tannermooredesign.com</a>
		</p>
	</aside>

</div>
