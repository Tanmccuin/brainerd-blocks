<?php
/**
 * Pricing Grid block — repeater of tier cards.
 *
 * Fields: section_heading, section_subtext, tiers (repeater):
 *   → name, price, price_suffix, tagline, features (textarea, one per line),
 *     cta (link), is_featured (true/false)
 */

$section_heading = get_field( 'section_heading' );
$section_subtext = get_field( 'section_subtext' );
$tiers           = get_field( 'tiers' );

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-pricing-grid-' . $block['id'];
$classes  = 'cb-pricing-grid';
if ( ! empty( $block['className'] ) ) {
	$classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$classes .= ' align' . $block['align'];
}

if ( $is_preview && empty( $tiers ) ) {
	$section_heading = 'Hosting & Maintenance';
	$section_subtext = 'Managed WordPress hosting to fit every scale.';
	$tiers = [
		[
			'name'         => 'Basic',
			'price'        => '$25',
			'price_suffix' => '/mo',
			'tagline'      => 'Perfect for small brochure sites.',
			'features'     => "A2 Hosting\nLitespeed + Redis + SSD\nSSL included\nEmail support",
			'cta'          => [ 'title' => 'Get started', 'url' => '/contact/', 'target' => '' ],
			'is_featured'  => false,
		],
		[
			'name'         => 'Professional',
			'price'        => '$60',
			'price_suffix' => '/mo',
			'tagline'      => 'For growing businesses and ecommerce.',
			'features'     => "Kinsta or Pantheon\nScheduled backups\nCustom WP tuning\nPriority support",
			'cta'          => [ 'title' => 'Get started', 'url' => '/contact/', 'target' => '' ],
			'is_featured'  => true,
		],
		[
			'name'         => 'Custom',
			'price'        => 'Let\'s talk',
			'price_suffix' => '',
			'tagline'      => 'High-traffic, multi-site, or non-WP needs.',
			'features'     => "Google Cloud Services\nInfinitely scalable\nCustom architecture\nDedicated support",
			'cta'          => [ 'title' => 'Contact us', 'url' => '/contact/', 'target' => '' ],
			'is_featured'  => false,
		],
	];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-pricing-grid__inner">

		<?php if ( $section_heading || $section_subtext ) : ?>
			<div class="cb-pricing-grid__header">
				<?php if ( $section_heading ) : ?>
					<h2 class="cb-pricing-grid__title"><?php echo esc_html( $section_heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $section_subtext ) : ?>
					<p class="cb-pricing-grid__subtext"><?php echo esc_html( $section_subtext ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $tiers ) : ?>
			<div class="cb-pricing-grid__tiers cb-pricing-grid__tiers--<?php echo esc_attr( count( $tiers ) ); ?>">
				<?php foreach ( $tiers as $tier ) :
					$name         = $tier['name']         ?? '';
					$price        = $tier['price']        ?? '';
					$suffix       = $tier['price_suffix'] ?? '';
					$tagline      = $tier['tagline']      ?? '';
					$features_raw = $tier['features']     ?? '';
					$cta          = $tier['cta']          ?? [];
					$featured     = ! empty( $tier['is_featured'] );
					$badge_text   = $tier['badge_text']   ?? __( 'Popular', 'brainerd' );
					$features     = array_filter( array_map( 'trim', explode( "\n", $features_raw ) ) );
					$card_class   = 'cb-pricing-grid__card' . ( $featured ? ' cb-pricing-grid__card--featured' : '' );
				?>
					<article class="<?php echo esc_attr( $card_class ); ?>">
						<?php if ( $featured ) : ?>
							<span class="cb-pricing-grid__badge"><?php echo esc_html( $badge_text ); ?></span>
						<?php endif; ?>

						<h3 class="cb-pricing-grid__name"><?php echo esc_html( $name ); ?></h3>

						<?php if ( $price ) : ?>
							<div class="cb-pricing-grid__price">
								<span class="cb-pricing-grid__amount"><?php echo esc_html( $price ); ?></span>
								<?php if ( $suffix ) : ?>
									<span class="cb-pricing-grid__suffix"><?php echo esc_html( $suffix ); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( $tagline ) : ?>
							<p class="cb-pricing-grid__tagline"><?php echo esc_html( $tagline ); ?></p>
						<?php endif; ?>

						<?php if ( $features ) : ?>
							<ul class="cb-pricing-grid__features">
								<?php foreach ( $features as $f ) : ?>
									<li>
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
										<?php echo esc_html( $f ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if ( ! empty( $cta['url'] ) ) : ?>
							<a class="cb-pricing-grid__cta"
								href="<?php echo esc_url( $cta['url'] ); ?>"
								<?php echo ( '_blank' === ( $cta['target'] ?? '' ) ) ? 'target="_blank" rel="noopener"' : ''; ?>>
								<?php echo esc_html( $cta['title'] ?: 'Get started' ); ?>
							</a>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
