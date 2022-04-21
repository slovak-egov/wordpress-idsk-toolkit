<?php
/**
 * BLOCK - related-content - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register related content.
 */
function idsktk_register_dynamic_related_content_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/related-content',
		array(
			'render_callback' => 'idsktk_render_dynamic_related_content_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_related_content_block' );

/**
 * Render related content.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_related_content_block( $attributes ) {
	// Block attributes.
	$title = isset( $attributes['title'] ) ? $attributes['title'] : '';
	$body  = isset( $attributes['body'] ) ? $attributes['body'] : '';
	// Data modification.
	$body_replaced_li = str_replace( '<li>', '<li class="idsk-related-content__list-item">', $body );
	$body_final       = str_replace( '<a', '<a class="idsk-related-content__link"', $body_replaced_li );

	ob_start(); // Turn on output buffering.
	?>

	<div class="idsk-related-content" data-module="idsk-related-content">
		<hr class="idsk-related-content__line" aria-hidden="true" />
		<h4 class="idsk-related-content__heading govuk-heading-s"><?php echo wp_kses_post( $title ); ?></h4>
		<ul class="idsk-related-content__list govuk-list">
			<?php echo wp_kses_post( $body_final ); ?>
		</ul>
	</div>

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
