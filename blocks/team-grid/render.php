<?php
/**
 * Team Grid block.
 *
 * Fields: section_heading, section_subtext, members (repeater):
 *   photo (image), name (text), role (text), bio (textarea),
 *   linkedin (url), twitter (url), email (email).
 *
 * Extending: add a "link" field to make cards clickable (e.g., to a team member page).
 * Add a "columns" select (2/3/4) for different grid densities.
 */

$section_heading = get_field( 'section_heading' );
$section_subtext = get_field( 'section_subtext' );
$members         = get_field( 'members' );

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'cb-team-' . $block['id'];
$classes  = 'cb-team';
if ( ! empty( $block['className'] ) ) $classes .= ' ' . $block['className'];
if ( ! empty( $block['align'] ) )     $classes .= ' align' . $block['align'];

if ( $is_preview && empty( $members ) ) {
	$section_heading = 'Our team';
	$members = [
		[ 'photo' => null, 'name' => 'Jane Smith', 'role' => 'Lead Designer', 'bio' => '', 'linkedin' => '', 'twitter' => '', 'email' => '' ],
		[ 'photo' => null, 'name' => 'Mark Johnson', 'role' => 'Developer', 'bio' => '', 'linkedin' => '', 'twitter' => '', 'email' => '' ],
		[ 'photo' => null, 'name' => 'Sarah Chen', 'role' => 'Project Manager', 'bio' => '', 'linkedin' => '', 'twitter' => '', 'email' => '' ],
	];
}
?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<div class="cb-team__inner">

		<?php if ( $section_heading || $section_subtext ) : ?>
			<div class="cb-team__header">
				<?php if ( $section_heading ) : ?>
					<h2 class="cb-team__title"><?php echo esc_html( $section_heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $section_subtext ) : ?>
					<p class="cb-team__subtext"><?php echo esc_html( $section_subtext ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $members ) : ?>
			<div class="cb-team__grid">
				<?php foreach ( $members as $m ) :
					$photo    = $m['photo']    ?? null;
					$name     = $m['name']     ?? '';
					$role     = $m['role']     ?? '';
					$bio      = $m['bio']      ?? '';
					$linkedin = $m['linkedin'] ?? '';
					$twitter  = $m['twitter']  ?? '';
					$email    = $m['email']    ?? '';
					$has_social = $linkedin || $twitter || $email;
				?>
					<article class="cb-team__card">
						<div class="cb-team__photo-wrap">
							<?php if ( $photo && ! empty( $photo['sizes']['medium_large'] ) ) : ?>
								<img class="cb-team__photo"
									src="<?php echo esc_url( $photo['sizes']['medium_large'] ); ?>"
									alt="<?php echo esc_attr( $name ); ?>"
									loading="lazy" decoding="async">
							<?php else : ?>
								<div class="cb-team__photo-placeholder" aria-hidden="true">
									<?php echo esc_html( $name ? mb_substr( $name, 0, 1 ) : '?' ); ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="cb-team__info">
							<?php if ( $name ) : ?>
								<h3 class="cb-team__name"><?php echo esc_html( $name ); ?></h3>
							<?php endif; ?>
							<?php if ( $role ) : ?>
								<p class="cb-team__role"><?php echo esc_html( $role ); ?></p>
							<?php endif; ?>
							<?php if ( $bio ) : ?>
								<p class="cb-team__bio"><?php echo esc_html( $bio ); ?></p>
							<?php endif; ?>
							<?php if ( $has_social ) : ?>
								<div class="cb-team__social">
									<?php if ( $linkedin ) : ?>
										<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $name . ' on LinkedIn' ); ?>">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
										</a>
									<?php endif; ?>
									<?php if ( $twitter ) : ?>
										<a href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $name . ' on X/Twitter' ); ?>">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4l11.733 16h4.267l-11.733-16zM4 20l6.768-6.768M20 4l-6.768 6.768"/></svg>
										</a>
									<?php endif; ?>
									<?php if ( $email ) : ?>
										<a href="mailto:<?php echo esc_attr( $email ); ?>" aria-label="<?php echo esc_attr( 'Email ' . $name ); ?>">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
										</a>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
