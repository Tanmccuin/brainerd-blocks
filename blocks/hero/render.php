<?php
/**
 * Hero block — split layout: text left, mosaic image grid right.
 *
 * Fields: eyebrow (text), heading (text), body (wysiwyg),
 *         cta_primary (link), cta_secondary (link),
 *         mosaic_images (gallery, 4 images).
 */

$eyebrow       = get_field( 'eyebrow' );
$heading       = get_field( 'heading' );
$body          = get_field( 'body' );
$cta_primary   = get_field( 'cta_primary' );
$cta_secondary = get_field( 'cta_secondary' );
$mosaic_images = get_field( 'mosaic_images' );

// Lightweight alternative: comma-separated attachment IDs (avoids gallery JSON in block data).
$mosaic_ids_raw = get_field( 'mosaic_ids' );
if ( ! $mosaic_images && $mosaic_ids_raw ) {
	$ids = array_filter( array_map( 'intval', explode( ',', $mosaic_ids_raw ) ) );
	$mosaic_images = [];
	foreach ( $ids as $aid ) {
		$src = wp_get_attachment_image_src( $aid, 'large' );
		if ( $src ) {
			$mosaic_images[] = [ 'url' => $src[0], 'alt' => get_post_meta( $aid, '_wp_attachment_image_alt', true ) ?: '' ];
		}
	}
	if ( ! $mosaic_images ) {
		$mosaic_images = null;
	}
}

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-hero-' . $block['id'];
$classes  = 'cb-hero alignfull';
if ( ! empty( $block['className'] ) ) {
	$classes .= ' ' . $block['className'];
}

if ( $is_preview ) {
	$eyebrow     = $eyebrow     ?: 'Vermont Web Studio';
	$heading     = $heading     ?: 'WordPress Design, Development & Consulting';
	$body        = $body        ?: '<p>A solo Vermont studio helping organizations build WordPress sites that are fast, accessible, and worth maintaining.</p>';
	$cta_primary = $cta_primary ?: [ 'title' => 'View portfolio', 'url' => '/portfolio/', 'target' => '' ];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-hero__inner">

		<div class="cb-hero__text">
			<?php if ( $eyebrow ) : ?>
				<p class="cb-hero__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>

			<h1 class="cb-hero__heading"><?php echo esc_html( $heading ?: 'WordPress Design, Development & Consulting' ); ?></h1>

			<?php if ( $body ) : ?>
				<div class="cb-hero__body"><?php echo wp_kses_post( $body ); ?></div>
			<?php endif; ?>

			<div class="cb-hero__inner-blocks">
				<InnerBlocks />
			</div>

			<div class="cb-hero__actions">
				<?php if ( $cta_primary && ! empty( $cta_primary['url'] ) ) : ?>
					<a class="cb-hero__cta cb-hero__cta--primary wp-element-button"
						href="<?php echo esc_url( $cta_primary['url'] ); ?>"
						<?php echo ( '_blank' === ( $cta_primary['target'] ?? '' ) ) ? 'target="_blank" rel="noopener"' : ''; ?>>
						<?php echo esc_html( $cta_primary['title'] ?: 'View portfolio' ); ?>
					</a>
				<?php endif; ?>

				<?php if ( $cta_secondary && ! empty( $cta_secondary['url'] ) ) : ?>
					<a class="cb-hero__cta cb-hero__cta--secondary"
						href="<?php echo esc_url( $cta_secondary['url'] ); ?>"
						<?php echo ( '_blank' === ( $cta_secondary['target'] ?? '' ) ) ? 'target="_blank" rel="noopener"' : ''; ?>>
						<?php echo esc_html( $cta_secondary['title'] ?: 'Get in touch' ); ?> <svg style="width:.75em;height:.75em;vertical-align:baseline;display:inline-block;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17L17 7M7 7h10v10"/></svg>
					</a>
				<?php endif; ?>
			</div>

			<p class="cb-hero__contact">
				<a href="tel:+18023554520">802.355.4520</a>
				&middot;
				<a href="mailto:tanner@tannermooredesign.com">tanner@tannermooredesign.com</a>
			</p>
		</div>

		<div class="cb-hero__mosaic" aria-hidden="true" data-mosaic>
			<?php
			$placeholders = [
				'Portfolio work — Union Street Media',
				'Portfolio work — NewLeaf Productions',
				'Portfolio work — Vermont SportsCar',
				'Portfolio work — The Light + Color',
			];

			// If no gallery field set, auto-pull featured images from the 4 most recent portfolio posts.
			if ( ! $mosaic_images ) {
				$recent = get_posts( [
					'post_type'      => 'portfolio',
					'posts_per_page' => 4,
					'orderby'        => 'rand',
					'post_status'    => 'publish',
				] );
				if ( $recent ) {
					$mosaic_images = [];
					foreach ( $recent as $p ) {
						$thumb_id = get_post_thumbnail_id( $p->ID );
						if ( $thumb_id ) {
							$src_data = wp_get_attachment_image_src( $thumb_id, 'large' );
							if ( $src_data ) {
								$mosaic_images[] = [
									'url' => $src_data[0],
									'alt' => get_the_title( $p->ID ),
								];
							}
						}
					}
					if ( ! $mosaic_images ) {
						$mosaic_images = null; // still nothing — fall through to placeholders
					}
				}
			}

			if ( $mosaic_images && is_array( $mosaic_images ) ) :
				foreach ( array_slice( $mosaic_images, 0, 4 ) as $i => $img ) :
					$src = esc_url( $img['sizes']['large'] ?? $img['url'] ?? '' );
					$alt = esc_attr( $img['alt'] ?: ( $placeholders[ $i ] ?? '' ) );
					if ( ! $src ) continue;
					?>
					<div class="cb-hero__mosaic-tile cb-hero__mosaic-tile--<?php echo $i + 1; ?>">
						<img src="<?php echo $src; ?>" alt="<?php echo $alt; ?>" loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>">
					</div>
				<?php
				endforeach;
			else :
				for ( $i = 0; $i < 4; $i++ ) :
					?>
					<div class="cb-hero__mosaic-tile cb-hero__mosaic-tile--<?php echo $i + 1; ?>">
						<div class="cb-hero__mosaic-ph" role="presentation"></div>
					</div>
				<?php endfor; ?>
			<?php endif; ?>
		</div>

	</div>

	<button class="cb-hero__scroll-hint" aria-label="<?php esc_attr_e( 'Scroll to content', 'brainerd' ); ?>" type="button">
		<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
	</button>

</section>
