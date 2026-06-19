<?php
/**
 * Home Hero pattern.
 *
 * Patterns are how Claude Code assembles pages deterministically: the content
 * is serialized Gutenberg block markup (the HTML-comment delimiters ARE the
 * block structure). An ACF block serializes as a self-closing comment whose
 * JSON payload carries the field data.
 *
 * To build a page from this, either insert the pattern in the editor, or pass
 * the `content` straight to `wp post create --post_content=...` via WP-CLI.
 */

return array(
	'name'        => 'brainerd/home-hero',
	'title'       => 'Home: Hero',
	'categories'  => array( 'brainerd' ),
	'content'     => '<!-- wp:brainerd/hero {"align":"full","data":{"eyebrow":"Welcome","heading":"Build it once, build it right","body":"<p>A short supporting sentence for the hero section.</p>","cta":{"title":"Get started","url":"/contact","target":""}}} /-->',
);
