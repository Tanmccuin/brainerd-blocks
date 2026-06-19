<?php
/**
 * Portfolio Grid block — dynamic WP_Query.
 *
 * Fields: section_heading (text), limit (number, 0 = all),
 *         show_view_all (true_false), view_all_label (text).
 */

$section_heading = get_field( 'section_heading' );
$limit           = (int) get_field( 'limit' );
$show_view_all   = get_field( 'show_view_all' );
$view_all_label  = get_field( 'view_all_label' ) ?: 'View all work';

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-portfolio-grid-' . $block['id'];
$classes  = 'cb-portfolio-grid';
if ( ! empty( $block['className'] ) ) {
	$classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$classes .= ' align' . $block['align'];
}

$query_args = [
	'post_type'      => 'portfolio',
	'post_status'    => 'publish',
	'posts_per_page' => $limit > 0 ? $limit : -1,
	'orderby'        => 'menu_order date',
	'order'          => 'DESC',
];

$portfolio = new WP_Query( $query_args );
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-portfolio-grid__inner">

		<?php if ( $section_heading || $show_view_all ) : ?>
			<div class="cb-portfolio-grid__header">
				<?php if ( $section_heading ) : ?>
					<h2 class="cb-portfolio-grid__title"><?php echo esc_html( $section_heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $show_view_all ) : ?>
					<a class="cb-portfolio-grid__view-all" href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>">
						<?php echo esc_html( $view_all_label ); ?> →
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $portfolio->have_posts() ) : ?>
			<ul class="cb-portfolio-grid__grid" role="list">
				<?php while ( $portfolio->have_posts() ) : $portfolio->the_post(); ?>
					<li class="cb-portfolio-grid__item">
						<a class="cb-portfolio-grid__link" href="<?php echo esc_url( get_permalink() ); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="cb-portfolio-grid__thumb">
									<?php the_post_thumbnail( 'large', [
										'loading' => 'lazy',
										'alt'     => esc_attr( get_the_title() ),
									] ); ?>
								</div>
							<?php else : ?>
								<div class="cb-portfolio-grid__thumb cb-portfolio-grid__thumb--placeholder" aria-hidden="true"></div>
							<?php endif; ?>
							<div class="cb-portfolio-grid__meta">
								<div class="cb-portfolio-grid__meta-text">
									<h3 class="cb-portfolio-grid__item-title"><?php echo esc_html( get_the_title() ); ?></h3>
									<?php $role = get_field( 'role', get_the_ID() ); ?>
									<?php if ( $role ) : ?>
										<p class="cb-portfolio-grid__item-meta"><?php echo esc_html( $role ); ?></p>
									<?php endif; ?>
								</div>
								<span class="cb-portfolio-grid__arrow" aria-hidden="true">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
								</span>
							</div>
						</a>
					</li>
				<?php endwhile; wp_reset_postdata(); ?>
			</ul>
		<?php elseif ( $is_preview ) : ?>
			<p style="color: var(--tmd-muted); font-style: italic; padding: 2rem 0;">
				No portfolio entries found. Add entries via Posts → Portfolio.
			</p>
		<?php endif; ?>

	</div>
</section>
