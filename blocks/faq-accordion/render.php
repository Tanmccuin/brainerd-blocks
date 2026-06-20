<?php
/**
 * FAQ Accordion block.
 *
 * Uses native <details>/<summary> for zero-JS accordion behavior.
 * Fields: section_heading, section_subtext, items (repeater): question, answer.
 *
 * Extending: add a "category" taxonomy or select field to group FAQs into tabs.
 * Add schema.org FAQPage structured data by looping $items in a JSON-LD script.
 */

$section_heading = get_field( 'section_heading' );
$section_subtext = get_field( 'section_subtext' );
$items           = get_field( 'items' );

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-faq-' . $block['id'];
$classes  = 'cb-faq';
if ( ! empty( $block['className'] ) ) $classes .= ' ' . $block['className'];
if ( ! empty( $block['align'] ) )     $classes .= ' align' . $block['align'];

if ( $is_preview && empty( $items ) ) {
	$section_heading = 'Frequently asked questions';
	$items = [
		[ 'question' => 'How long does a typical project take?', 'answer' => 'Most brochure sites take 4–8 weeks from kickoff to launch. Larger projects with custom functionality or ecommerce can take 10–16 weeks.' ],
		[ 'question' => 'Do you offer ongoing maintenance?', 'answer' => 'Yes. We offer monthly maintenance plans that cover plugin updates, security monitoring, backups, and content changes.' ],
		[ 'question' => 'What do you need from me to get started?', 'answer' => 'A clear idea of your goals, your brand assets (logo, colors), and your content. We have a new project questionnaire that walks you through everything.' ],
	];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-faq__inner">

		<?php if ( $section_heading || $section_subtext ) : ?>
			<div class="cb-faq__header">
				<?php if ( $section_heading ) : ?>
					<h2 class="cb-faq__title"><?php echo esc_html( $section_heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $section_subtext ) : ?>
					<p class="cb-faq__subtext"><?php echo esc_html( $section_subtext ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $items ) : ?>
			<div class="cb-faq__list">
				<?php foreach ( $items as $item ) :
					$q = $item['question'] ?? '';
					$a = $item['answer']   ?? '';
				?>
					<details class="cb-faq__item">
						<summary class="cb-faq__question">
							<span><?php echo esc_html( $q ); ?></span>
							<svg class="cb-faq__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
						</summary>
						<div class="cb-faq__answer">
							<?php echo wp_kses_post( $a ); ?>
						</div>
					</details>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
