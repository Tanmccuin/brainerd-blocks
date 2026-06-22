<?php
/**
 * Plugin Name:       Brainerd Blocks
 * Description:       ACF Gutenberg blocks, patterns, and block category for the Brainerd theme ecosystem.
 * Version:           0.1.05
 * Requires PHP:      8.0
 * Requires at least: 6.4
 * Author:            Tannermooredesign
 * Author URI:        https://tannermooredesign.com
 * Text Domain:       brainerd
 * License:           GPL-2.0-or-later
 *
 * Single home for all custom, version-controlled site functionality that is
 * block-related. WP-CLI and Claude Code treat this plugin as source of truth.
 */

defined( 'ABSPATH' ) || exit;

define( 'BRAINERD_BLOCKS_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Register a custom block category so our blocks group together in the inserter.
 */
add_filter(
	'block_categories_all',
	function ( $categories ) {
		array_unshift(
			$categories,
			array(
				'slug'  => 'brainerd',
				'title' => __( 'Brainerd Blocks', 'brainerd' ),
				'icon'  => null,
			)
		);
		return $categories;
	}
);

/**
 * Tell ACF where to load/save local JSON field groups.
 * This is what makes field definitions version-controlled files.
 */
add_filter(
	'acf/settings/load_json',
	function ( $paths ) {
		$paths[] = BRAINERD_BLOCKS_DIR . 'acf-json';
		return $paths;
	}
);
add_filter(
	'acf/settings/save_json',
	function () {
		return BRAINERD_BLOCKS_DIR . 'acf-json';
	}
);

/**
 * Auto-register every block in /blocks that has a block.json.
 * Add a new block by creating a folder with block.json + render.php — no edits here.
 */
add_action(
	'init',
	function () {
		$blocks_dir = BRAINERD_BLOCKS_DIR . 'blocks';
		if ( ! is_dir( $blocks_dir ) ) {
			return;
		}
		foreach ( glob( $blocks_dir . '/*', GLOB_ONLYDIR ) as $dir ) {
			if ( file_exists( $dir . '/block.json' ) ) {
				register_block_type( $dir );
			}
		}
	}
);

/**
 * Enqueue the mosaic parallax + dark-mode toggle scripts on the front end.
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_script(
			'brainerd-js',
			plugins_url( 'brainerd.js', __FILE__ ),
			[],
			'0.1.0',
			[ 'strategy' => 'defer', 'in_footer' => true ]
		);
	}
);

/**
 * Register block patterns from /patterns (each is a PHP file returning markup).
 */
add_action(
	'init',
	function () {
		register_block_pattern_category(
			'brainerd',
			array( 'label' => __( 'Client Patterns', 'brainerd' ) )
		);

		foreach ( glob( BRAINERD_BLOCKS_DIR . 'patterns/*.php' ) as $file ) {
			$pattern = require $file;
			if ( is_array( $pattern ) && ! empty( $pattern['name'] ) && ! empty( $pattern['content'] ) ) {
				register_block_pattern( $pattern['name'], $pattern );
			}
		}
	}
);
