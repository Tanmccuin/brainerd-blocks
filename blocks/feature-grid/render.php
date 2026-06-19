<?php
/**
 * Feature Grid block render template.
 *
 * @var array $block      Block settings/attributes.
 * @var bool  $is_preview True during editor preview.
 */

$heading  = get_field( 'heading' );
$features = get_field( 'features' ); // repeater: icon (text), title, text

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-feature-grid-' . $block['id'];
$classes  = 'cb-feature-grid';
if ( ! empty( $block['className'] ) ) {
	$classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$classes .= ' align' . $block['align'];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-feature-grid__inner">
		<?php if ( $heading ) : ?>
			<h2 class="cb-feature-grid__heading"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $features ) : ?>
			<ul class="cb-feature-grid__list">
				<?php foreach ( $features as $f ) : ?>
					<li class="cb-feature-grid__item">
						<?php if ( ! empty( $f['icon'] ) ) : ?>
							<span class="cb-feature-grid__icon" aria-hidden="true"><?php echo esc_html( $f['icon'] ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $f['title'] ) ) : ?>
							<h3 class="cb-feature-grid__item-title"><?php echo esc_html( $f['title'] ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $f['text'] ) ) : ?>
							<p class="cb-feature-grid__item-text"><?php echo esc_html( $f['text'] ); ?></p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php elseif ( $is_preview ) : ?>
			<p>Add features to populate the grid.</p>
		<?php endif; ?>
	</div>
</section>
