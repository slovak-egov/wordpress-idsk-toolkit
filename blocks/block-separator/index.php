<?php
/**
 * BLOCK - separator - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.5.0
 */

/**
 * Register separator.
 */
function idsktk_register_dynamic_separator_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/separator',
		array(
			'render_callback' => 'idsktk_render_dynamic_separator_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_separator_block' );

/**
 * Render separator.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_separator_block( $attributes ) {
	// Block attributes.
	$separator_type = isset( $attributes['separatorType'] ) ? $attributes['separatorType'] : false;
	$margin_bottom  = isset( $attributes['marginBottom'] ) ? $attributes['marginBottom'] : 'govuk-!-margin-bottom-6';

	ob_start(); // Turn on output buffering.
	?>

	<hr class="<?php echo esc_attr( ( $separator_type ? 'idsk-hr-separator-until-tablet' : 'idsk-hr-separator' ) . ' ' . $margin_bottom ); ?>" />

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
