<?php
/**
 * CTA Band block — full-width closing call-to-action.
 *
 * Fields: heading (text), subtext (text), button (link), footnote (text).
 */

$heading  = get_field( 'heading' )  ?: 'Let\'s talk about your next project.';
$subtext  = get_field( 'subtext' )  ?: 'No RFPs. Just a conversation.';
$button   = get_field( 'button' );
$footnote = get_field( 'footnote' );

if ( $is_preview && ! $button ) {
	$button = [ 'title' => 'Get in touch', 'url' => '/contact/', 'target' => '' ];
}

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-cta-band-' . $block['id'];
$classes  = 'cb-cta-band alignfull';
if ( ! empty( $block['className'] ) ) {
	$classes .= ' ' . $block['className'];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-cta-band__inner">
		<div class="cb-cta-band__text">
			<h2 class="cb-cta-band__heading"><?php echo esc_html( $heading ); ?></h2>
			<?php if ( $subtext ) : ?>
				<p class="cb-cta-band__subtext"><?php echo esc_html( $subtext ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( $button && ! empty( $button['url'] ) ) : ?>
			<a class="cb-cta-band__button"
				href="<?php echo esc_url( $button['url'] ); ?>"
				<?php echo ( '_blank' === ( $button['target'] ?? '' ) ) ? 'target="_blank" rel="noopener"' : ''; ?>>
				<?php echo esc_html( $button['title'] ?: 'Get in touch' ); ?> →
			</a>
		<?php endif; ?>
	</div>

	<?php if ( $footnote ) : ?>
		<p class="cb-cta-band__footnote"><?php echo esc_html( $footnote ); ?></p>
	<?php endif; ?>
</section>
