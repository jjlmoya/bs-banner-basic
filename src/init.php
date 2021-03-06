<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package BS
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

$block = 'block-bs-banner-basic';

// Hook server side rendering into render callback
register_block_type('bonseo/' . $block,
	array(
		'attributes' => array(
			'title' => array(
				'type' => 'string',
			),
			'content' => array(
				'type' => 'string',
			),
			'cta' => array(
				'type' => 'string',
			),
			'url' => array(
				'type' => 'string',
			),
			'className' => array(
				'type' => 'string'
			)

		),
		'render_callback' => 'render_bs_basic_banner',
	)
);


/**
 * Enqueue Gutenberg block assets for backend editor.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function bs_basic_banner_editor_assets()
{ // phpcs:ignore
	// Scripts.
	wp_enqueue_script(
		'bs_basic_banner-block-js', // Handle.
		plugins_url('/dist/blocks.build.js', dirname(__FILE__)), // Block.build.js: We register the block here. Built with Webpack.
		array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), // Dependencies, defined above.
		// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: File modification time.
		true // Enqueue the script in the footer.
	);
}

function render_bs_basic_banner($attributes)
{
	$class = isset($attributes['className']) ? ' ' . $attributes['className'] : '';
	$title = isset($attributes['title']) ? $attributes['title'] : '';
	$content = isset($attributes['content']) ? $attributes['content'] : '';
	$cta = isset($attributes['cta']) ? $attributes['cta'] : '';
	$url = isset($attributes['url']) ? $attributes['url'] : '';

	return '
		<section class="og-banner-basic l-flex l-flex--justify-space-around a-bg a-pad l-flex--wrap l-grid-column--full ' . $class . '">
			<div class="og-banner-basic-content l-flex l-flex--direction-column a-pad-20">
				<h2 class="a-text a-text--xl a-text--secondary ">
					' . $title . '
				</h2>
				<p class="a-text a-text--secondary">
					' . $content . '
				</p>
			</div>
			<a href="' . $url . '" class="a-button a-button--rounded a-button--s a-button--secondary a-text--m l-flex-item--align-center">
				' . $cta . '
			</a>
		</section>';
}

add_action('enqueue_block_editor_assets', 'bs_basic_banner_editor_assets');
