<?php
/**
 * BLOCK - announce - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register announce.
 */
function idsktk_register_dynamic_announce_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/announce',
		array(
			'render_callback' => 'idsktk_render_dynamic_announce_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_announce_block' );

/**
 * Render announce.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_announce_block( $attributes ) {
	// Block attributes.
	$text = isset( $attributes['text'] ) ? $attributes['text'] : '';

	ob_start(); // Turn on output buffering.
	?>

	<div class="govuk-warning-text">
		<span class="govuk-warning-text__icon" aria-hidden="true">!</span>
		<strong class="govuk-warning-text__text">
			<span class="govuk-warning-text__assistive"><?php esc_html_e( 'Warning', 'idsk-toolkit' ); ?></span>
			<?php echo wp_kses_post( $text ); ?>
		</strong>
	</div>

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
