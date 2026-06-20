<?php
/**
 * Stats / Metrics block.
 *
 * Fields: section_heading, stats (repeater): value (text), label (text), prefix (text), suffix (text).
 *
 * Extending: add a count-up animation by targeting `.cb-stats__value` with IntersectionObserver
 * and incrementing from 0 to the data-value attribute. Add an icon field per stat for visual anchoring.
 */

$section_heading = get_field( 'section_heading' );
$stats           = get_field( 'stats' );

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-stats-' . $block['id'];
$classes  = 'cb-stats';
if ( ! empty( $block['className'] ) ) $classes .= ' ' . $block['className'];
if ( ! empty( $block['align'] ) )     $classes .= ' align' . $block['align'];

if ( $is_preview && empty( $stats ) ) {
	$section_heading = '';
	$stats = [
		[ 'value' => '20', 'label' => 'Years experience', 'prefix' => '', 'suffix' => '+' ],
		[ 'value' => '150', 'label' => 'Projects delivered', 'prefix' => '', 'suffix' => '+' ],
		[ 'value' => '99', 'label' => 'Uptime guarantee', 'prefix' => '', 'suffix' => '%' ],
		[ 'value' => '4.9', 'label' => 'Client satisfaction', 'prefix' => '', 'suffix' => '/5' ],
	];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-stats__inner">

		<?php if ( $section_heading ) : ?>
			<h2 class="cb-stats__title"><?php echo esc_html( $section_heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $stats ) : ?>
			<div class="cb-stats__grid cb-stats__grid--<?php echo esc_attr( min( count( $stats ), 4 ) ); ?>">
				<?php foreach ( $stats as $stat ) :
					$value  = $stat['value']  ?? '';
					$label  = $stat['label']  ?? '';
					$prefix = $stat['prefix'] ?? '';
					$suffix = $stat['suffix'] ?? '';
				?>
					<div class="cb-stats__item">
						<span class="cb-stats__value" data-value="<?php echo esc_attr( $value ); ?>">
							<?php if ( $prefix ) : ?><span class="cb-stats__affix"><?php echo esc_html( $prefix ); ?></span><?php endif; ?>
							<?php echo esc_html( $value ); ?>
							<?php if ( $suffix ) : ?><span class="cb-stats__affix"><?php echo esc_html( $suffix ); ?></span><?php endif; ?>
						</span>
						<?php if ( $label ) : ?>
							<span class="cb-stats__label"><?php echo esc_html( $label ); ?></span>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
