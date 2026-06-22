<?php
/**
 * Feature List block.
 *
 * Fields: section_heading, section_subtext, layout (select: stacked|alternating),
 *         features (repeater): icon_key (select), heading, description, link (link).
 *
 * icon_key maps to the same icon registry as service-pillars. Available keys:
 * design, hosting, consult, a11y. Add new icons to both this file and
 * blocks/service-pillars/render.php to keep them in sync.
 *
 * Extending: add image field as alternative to icon. Add "numbered" layout
 * option that shows step numbers (01, 02, 03) instead of icons.
 */

$icon_map = [
	'design'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 9h20"/><circle cx="6" cy="6.5" r=".75" fill="currentColor" stroke="none"/><circle cx="9" cy="6.5" r=".75" fill="currentColor" stroke="none"/></svg>',
	'hosting' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2.5" width="20" height="7" rx="1.5"/><rect x="2" y="12.5" width="20" height="7" rx="1.5"/><circle cx="18.5" cy="6" r="1" fill="currentColor" stroke="none"/><circle cx="18.5" cy="16" r="1" fill="currentColor" stroke="none"/></svg>',
	'consult' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
	'a11y'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="5" r="1.5"/><path d="M7 11.5l5-2 5 2M10 21v-6l2 2.5 2-2.5v6"/><path d="M7 17.5l-1.5 3.5M17 17.5l1.5 3.5"/></svg>',
	'check'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
	'shield'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
	'zap'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
	'globe'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
];

$section_heading = get_field( 'section_heading' );
$section_subtext = get_field( 'section_subtext' );
$layout          = get_field( 'layout' ) ?: 'stacked';
$features        = get_field( 'features' );

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-feature-list-' . $block['id'];
$classes  = 'cb-feature-list';
if ( ! empty( $block['className'] ) ) $classes .= ' ' . $block['className'];
if ( ! empty( $block['align'] ) )     $classes .= ' align' . $block['align'];

if ( $is_preview && empty( $features ) ) {
	$section_heading = 'How we work';
	$features = [
		[ 'icon_key' => 'consult', 'heading' => 'Discovery', 'description' => 'We start with a conversation about your goals, your audience, and what success looks like.', 'link' => null ],
		[ 'icon_key' => 'design',  'heading' => 'Design & build', 'description' => 'We design and develop your site iteratively, with feedback rounds at every stage.', 'link' => null ],
		[ 'icon_key' => 'zap',     'heading' => 'Launch & support', 'description' => 'We go live together, then provide ongoing maintenance and support.', 'link' => null ],
	];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-feature-list__inner">

		<?php if ( $section_heading || $section_subtext ) : ?>
			<div class="cb-feature-list__header">
				<?php if ( $section_heading ) : ?>
					<h2 class="cb-feature-list__title"><?php echo esc_html( $section_heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $section_subtext ) : ?>
					<p class="cb-feature-list__subtext"><?php echo esc_html( $section_subtext ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $features ) : ?>
			<div class="cb-feature-list__items cb-feature-list__items--<?php echo esc_attr( $layout ); ?>">
				<?php foreach ( $features as $i => $f ) :
					$icon_key = $f['icon_key'] ?? 'check';
					$icon     = $icon_map[ $icon_key ] ?? $icon_map['check'];
					$heading  = $f['heading']     ?? '';
					$desc     = $f['description'] ?? '';
					$link     = $f['link']        ?? null;
				?>
					<div class="cb-feature-list__item">
						<div class="cb-feature-list__icon" aria-hidden="true">
							<?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput -- mapped SVG ?>
						</div>
						<div class="cb-feature-list__content">
							<?php if ( $heading ) : ?>
								<h3 class="cb-feature-list__heading"><?php echo esc_html( $heading ); ?></h3>
							<?php endif; ?>
							<?php if ( $desc ) : ?>
								<p class="cb-feature-list__desc"><?php echo esc_html( $desc ); ?></p>
							<?php endif; ?>
							<?php if ( $link && ! empty( $link['url'] ) ) : ?>
								<a class="cb-feature-list__link" href="<?php echo esc_url( $link['url'] ); ?>"
									<?php echo ( '_blank' === ( $link['target'] ?? '' ) ) ? 'target="_blank" rel="noopener"' : ''; ?>>
									<?php echo esc_html( $link['title'] ?: 'Learn more' ); ?> &rarr;
								</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="cb-feature-list__extra">
			<InnerBlocks />
		</div>

	</div>
</section>
