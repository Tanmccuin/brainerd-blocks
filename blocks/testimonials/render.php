<?php
/**
 * Testimonials block.
 *
 * Fields: section_heading (text), section_subtext (text), layout (select: grid|single),
 *         testimonials (repeater): quote (textarea), name (text), role (text), photo (image).
 *
 * Extending: add star rating (number 1-5), company logo (image), or link (url) fields
 * to the repeater. Render them after the attribution row in the card markup below.
 */

$section_heading = get_field( 'section_heading' );
$section_subtext = get_field( 'section_subtext' );
$layout          = get_field( 'layout' ) ?: 'grid';
$testimonials    = get_field( 'testimonials' );

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-testimonials-' . $block['id'];
$classes  = 'cb-testimonials';
if ( ! empty( $block['className'] ) ) $classes .= ' ' . $block['className'];
if ( ! empty( $block['align'] ) )     $classes .= ' align' . $block['align'];

if ( $is_preview && empty( $testimonials ) ) {
	$section_heading = 'What clients say';
	$testimonials = [
		[ 'quote' => 'Working with this team transformed our online presence. Professional, responsive, and genuinely invested in our success.', 'name' => 'Jane Smith', 'role' => 'CEO, Acme Co.', 'photo' => null ],
		[ 'quote' => 'They delivered on time, on budget, and the site exceeded our expectations. Could not recommend more highly.', 'name' => 'Mark Johnson', 'role' => 'Founder, StartupXYZ', 'photo' => null ],
		[ 'quote' => 'Finally a developer who understands accessibility. Our site is beautiful AND compliant.', 'name' => 'Sarah Chen', 'role' => 'Director, Nonprofit Org', 'photo' => null ],
	];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-testimonials__inner">

		<?php if ( $section_heading || $section_subtext ) : ?>
			<div class="cb-testimonials__header">
				<?php if ( $section_heading ) : ?>
					<h2 class="cb-testimonials__title"><?php echo esc_html( $section_heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $section_subtext ) : ?>
					<p class="cb-testimonials__subtext"><?php echo esc_html( $section_subtext ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $testimonials ) : ?>
			<div class="cb-testimonials__grid cb-testimonials__grid--<?php echo esc_attr( $layout ); ?>">
				<?php foreach ( $testimonials as $t ) :
					$quote = $t['quote'] ?? '';
					$name  = $t['name']  ?? '';
					$role  = $t['role']  ?? '';
					$photo = $t['photo'] ?? null;
				?>
					<blockquote class="cb-testimonials__card">
						<div class="cb-testimonials__quote">
							<p><?php echo esc_html( $quote ); ?></p>
						</div>
						<footer class="cb-testimonials__attribution">
							<?php if ( $photo && ! empty( $photo['sizes']['thumbnail'] ) ) : ?>
								<img class="cb-testimonials__photo"
									src="<?php echo esc_url( $photo['sizes']['thumbnail'] ); ?>"
									alt="<?php echo esc_attr( $name ); ?>"
									width="40" height="40" loading="lazy" decoding="async">
							<?php elseif ( $name ) : ?>
								<span class="cb-testimonials__initials" aria-hidden="true">
									<?php echo esc_html( mb_substr( $name, 0, 1 ) ); ?>
								</span>
							<?php endif; ?>
							<div class="cb-testimonials__meta">
								<?php if ( $name ) : ?>
									<cite class="cb-testimonials__name"><?php echo esc_html( $name ); ?></cite>
								<?php endif; ?>
								<?php if ( $role ) : ?>
									<span class="cb-testimonials__role"><?php echo esc_html( $role ); ?></span>
								<?php endif; ?>
							</div>
						</footer>
					</blockquote>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
