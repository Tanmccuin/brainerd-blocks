<?php
/**
 * Service Pillars block.
 *
 * Fields: section_heading (text), pillars (repeater):
 *   → icon_svg (textarea), heading (text), body (wysiwyg), link (link)
 */

$section_heading = get_field( 'section_heading' );
$pillars         = get_field( 'pillars' );

// Icon library — referenced by key in the block data, rendered here.
$icon_map = [
	'design'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 9h20"/><circle cx="6" cy="6.5" r=".75" fill="currentColor" stroke="none"/><circle cx="9" cy="6.5" r=".75" fill="currentColor" stroke="none"/></svg>',
	'hosting' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2.5" width="20" height="7" rx="1.5"/><rect x="2" y="12.5" width="20" height="7" rx="1.5"/><circle cx="18.5" cy="6" r="1" fill="currentColor" stroke="none"/><circle cx="18.5" cy="16" r="1" fill="currentColor" stroke="none"/></svg>',
	'consult' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
	'a11y'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="5" r="1.5"/><path d="M7 11.5l5-2 5 2M10 21v-6l2 2.5 2-2.5v6"/><path d="M7 17.5l-1.5 3.5M17 17.5l1.5 3.5"/></svg>',
];

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-service-pillars-' . $block['id'];
$classes  = 'cb-service-pillars';
if ( ! empty( $block['className'] ) ) {
	$classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$classes .= ' align' . $block['align'];
}

if ( $is_preview && empty( $pillars ) ) {
	$section_heading = 'What we do';
	$pillars = [
		[
			'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
			'heading'  => 'Web Design & Development',
			'body'     => '<p>Custom WordPress builds from the ground up — or modernize what you have.</p>',
			'link'     => [ 'title' => 'View portfolio', 'url' => '/portfolio/', 'target' => '' ],
		],
		[
			'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>',
			'heading'  => 'Hosting & Maintenance',
			'body'     => '<p>Managed hosting on Pantheon, Kinsta & A2. Uptime monitoring, updates, backups.</p>',
			'link'     => [ 'title' => 'Learn more', 'url' => '/services/', 'target' => '' ],
		],
		[
			'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>',
			'heading'  => 'Consulting & ADA Compliance',
			'body'     => '<p>WCAG 2.2 audits, remediation plans, and ongoing ADA compliance for WordPress.</p>',
			'link'     => [ 'title' => 'Learn more', 'url' => '/services/', 'target' => '' ],
		],
	];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-service-pillars__inner">

		<?php if ( $section_heading ) : ?>
			<div class="cb-service-pillars__header">
				<h2 class="cb-service-pillars__title"><?php echo esc_html( $section_heading ); ?></h2>
				<span class="cb-service-pillars__rule" aria-hidden="true"></span>
			</div>
		<?php endif; ?>

		<?php if ( $pillars ) : ?>
			<div class="cb-service-pillars__grid">
				<?php foreach ( $pillars as $pillar ) :
					$icon_key = $pillar['icon_svg'] ?? '';
					$icon     = $icon_map[ $icon_key ] ?? $icon_key;
					$h        = $pillar['heading']  ?? '';
					$b        = $pillar['body']     ?? '';
					$lnk      = $pillar['link']     ?? [];
				?>
					<article class="cb-service-pillars__card">
						<?php if ( $icon ) : ?>
							<div class="cb-service-pillars__icon" aria-hidden="true">
								<?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput -- mapped SVG ?>
							</div>
						<?php endif; ?>

						<?php if ( $h ) : ?>
							<h3 class="cb-service-pillars__heading"><?php echo esc_html( $h ); ?></h3>
						<?php endif; ?>

						<?php if ( $b ) : ?>
							<div class="cb-service-pillars__body"><?php echo wp_kses_post( $b ); ?></div>
						<?php endif; ?>

						<?php if ( ! empty( $lnk['url'] ) ) : ?>
							<a class="cb-service-pillars__link"
								href="<?php echo esc_url( $lnk['url'] ); ?>"
								<?php echo ( '_blank' === ( $lnk['target'] ?? '' ) ) ? 'target="_blank" rel="noopener"' : ''; ?>>
								<?php echo esc_html( $lnk['title'] ?: 'Learn more' ); ?> →
							</a>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
