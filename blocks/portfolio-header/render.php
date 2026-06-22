<?php
/**
 * Portfolio Header block.
 *
 * Fields: role (text), heading (text), description (textarea),
 *         project_url (url), featured_image (image).
 *
 * Designed for portfolio/case study single pages. Split layout:
 * project info left, featured screenshot right.
 *
 * Extending: add client name, technologies used, or testimonial quote fields.
 */

$role          = get_field( 'role' );
$heading       = get_field( 'heading' );
$description   = get_field( 'description' );
$project_url   = get_field( 'project_url' );
$featured_img  = get_field( 'featured_image' );

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-portfolio-header-' . $block['id'];
$classes  = 'cb-portfolio-header';
if ( ! empty( $block['className'] ) ) $classes .= ' ' . $block['className'];
if ( ! empty( $block['align'] ) )     $classes .= ' align' . $block['align'];

if ( $is_preview ) {
	$role        = $role        ?: 'Design & Development';
	$heading     = $heading     ?: 'Project Name';
	$description = $description ?: 'A brief description of the project scope, goals, and outcome.';
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-portfolio-header__inner">
		<div class="cb-portfolio-header__info">
			<?php if ( $role ) : ?>
				<p class="cb-portfolio-header__role"><?php echo esc_html( $role ); ?></p>
			<?php endif; ?>

			<h1 class="cb-portfolio-header__title"><?php echo esc_html( $heading ?: get_the_title() ); ?></h1>

			<?php if ( $description ) : ?>
				<div class="cb-portfolio-header__description">
					<p><?php echo esc_html( $description ); ?></p>
				</div>
			<?php endif; ?>

			<div class="cb-portfolio-header__actions">
				<?php if ( $project_url ) : ?>
					<a class="cb-portfolio-header__cta" href="<?php echo esc_url( $project_url ); ?>" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'View live site', 'brainerd' ); ?>
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
					</a>
				<?php endif; ?>
				<a class="cb-portfolio-header__back" href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ?: '/portfolio/' ); ?>">
					&larr; <?php esc_html_e( 'Back to portfolio', 'brainerd' ); ?>
				</a>
			</div>

			<div class="cb-portfolio-header__extra">
				<InnerBlocks />
			</div>
		</div>

		<?php if ( $featured_img && ! empty( $featured_img['url'] ) ) : ?>
			<div class="cb-portfolio-header__featured">
				<img src="<?php echo esc_url( $featured_img['sizes']['large'] ?? $featured_img['url'] ); ?>"
					alt="<?php echo esc_attr( $featured_img['alt'] ?: $heading ); ?>"
					width="<?php echo esc_attr( $featured_img['sizes']['large-width'] ?? $featured_img['width'] ?? '' ); ?>"
					height="<?php echo esc_attr( $featured_img['sizes']['large-height'] ?? $featured_img['height'] ?? '' ); ?>"
					loading="eager" decoding="async">
			</div>
		<?php elseif ( has_post_thumbnail() ) : ?>
			<div class="cb-portfolio-header__featured">
				<?php the_post_thumbnail( 'large', [ 'loading' => 'eager' ] ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
