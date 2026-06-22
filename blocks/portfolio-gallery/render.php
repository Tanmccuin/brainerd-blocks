<?php
/**
 * Portfolio Gallery block.
 *
 * Fields: images (gallery), columns (select: 2|3).
 *
 * Renders a CSS columns masonry grid. Images are drag-reorderable
 * in the ACF gallery field UI. Portrait images are detected and
 * given a --tall modifier class.
 *
 * Extending: add lightbox support via a JS library integration.
 * Add captions by reading $img['caption'] from the gallery array.
 */

$images  = get_field( 'images' );
$columns = get_field( 'columns' ) ?: '2';

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-portfolio-gallery-' . $block['id'];
$classes  = 'cb-portfolio-gallery';
if ( ! empty( $block['className'] ) ) $classes .= ' ' . $block['className'];
if ( ! empty( $block['align'] ) )     $classes .= ' align' . $block['align'];

if ( $is_preview && empty( $images ) ) {
	echo '<div class="' . esc_attr( $classes ) . '" style="padding:3rem;text-align:center;color:var(--tmd-muted);font-style:italic;">Add images to the gallery field to see the masonry grid.</div>';
	return;
}

if ( ! $images ) return;
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
	<div class="cb-portfolio-gallery__grid cb-portfolio-gallery__grid--<?php echo esc_attr( $columns ); ?>col" aria-label="<?php esc_attr_e( 'Project screenshots', 'brainerd' ); ?>">
		<?php foreach ( $images as $index => $img ) :
			$src = $img['sizes']['large'] ?? $img['url'] ?? '';
			$alt = $img['alt'] ?: get_the_title() . ' — screenshot ' . ( $index + 1 );
			$w   = $img['sizes']['large-width']  ?? $img['width']  ?? 1;
			$h   = $img['sizes']['large-height'] ?? $img['height'] ?? 1;
			$is_tall = ( $h / $w ) > 1.2;
			if ( ! $src ) continue;
		?>
			<figure class="cb-portfolio-gallery__item<?php echo $is_tall ? ' cb-portfolio-gallery__item--tall' : ''; ?>">
				<img
					src="<?php echo esc_url( $src ); ?>"
					alt="<?php echo esc_attr( $alt ); ?>"
					width="<?php echo esc_attr( $w ); ?>"
					height="<?php echo esc_attr( $h ); ?>"
					loading="lazy"
					decoding="async">
			</figure>
		<?php endforeach; ?>
	</div>
</section>
