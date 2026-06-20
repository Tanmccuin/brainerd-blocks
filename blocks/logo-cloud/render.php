<?php
/**
 * Logo Cloud block.
 *
 * Fields: section_heading, section_subtext, logos (repeater): logo (image), name (text), url (url).
 *
 * Extending: add a "columns" select (4/5/6) for different grid densities.
 * Add a "style" select (grayscale/color/monochrome) for different default appearances.
 * Add a marquee/scroll animation option for large logo sets.
 */

$section_heading = get_field( 'section_heading' );
$section_subtext = get_field( 'section_subtext' );
$logos           = get_field( 'logos' );

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-logo-cloud-' . $block['id'];
$classes  = 'cb-logo-cloud';
if ( ! empty( $block['className'] ) ) $classes .= ' ' . $block['className'];
if ( ! empty( $block['align'] ) )     $classes .= ' align' . $block['align'];

if ( $is_preview && empty( $logos ) ) {
	$section_heading = 'Trusted by';
	$logos = [
		[ 'logo' => null, 'name' => 'Client One', 'url' => '' ],
		[ 'logo' => null, 'name' => 'Client Two', 'url' => '' ],
		[ 'logo' => null, 'name' => 'Client Three', 'url' => '' ],
		[ 'logo' => null, 'name' => 'Client Four', 'url' => '' ],
		[ 'logo' => null, 'name' => 'Client Five', 'url' => '' ],
	];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-logo-cloud__inner">

		<?php if ( $section_heading || $section_subtext ) : ?>
			<div class="cb-logo-cloud__header">
				<?php if ( $section_heading ) : ?>
					<h2 class="cb-logo-cloud__title"><?php echo esc_html( $section_heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $section_subtext ) : ?>
					<p class="cb-logo-cloud__subtext"><?php echo esc_html( $section_subtext ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $logos ) : ?>
			<div class="cb-logo-cloud__grid">
				<?php foreach ( $logos as $item ) :
					$logo = $item['logo'] ?? null;
					$name = $item['name'] ?? '';
					$url  = $item['url']  ?? '';
					$tag  = $url ? 'a' : 'div';
					$href = $url ? ' href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer"' : '';
				?>
					<<?php echo $tag; ?> class="cb-logo-cloud__item"<?php echo $href; ?> title="<?php echo esc_attr( $name ); ?>">
						<?php if ( $logo && ! empty( $logo['url'] ) ) : ?>
							<img src="<?php echo esc_url( $logo['sizes']['medium'] ?? $logo['url'] ); ?>"
								alt="<?php echo esc_attr( $name ); ?>"
								loading="lazy" decoding="async">
						<?php else : ?>
							<span class="cb-logo-cloud__placeholder" aria-hidden="true"><?php echo esc_html( $name ); ?></span>
						<?php endif; ?>
					</<?php echo $tag; ?>>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
