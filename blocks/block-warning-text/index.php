<?php
/**
 * BLOCK - warning-text - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register warning text.
 */
function idsktk_register_dynamic_warning_text_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/warning-text',
		array(
			'render_callback' => 'idsktk_render_dynamic_warning_text_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_warning_text_block' );

/**
 * Render warning text.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_warning_text_block( $attributes ) {
	// Block attributes.
	$text       = isset( $attributes['text'] ) ? $attributes['text'] : '';
	$class_name = isset( $attributes['className'] ) ? $attributes['className'] : '';
	// Block settings.
	$text_type = isset( $attributes['textType'] ) && $attributes['textType'] ? $attributes['textType'] : false;

	ob_start(); // Turn on output buffering.
	?>

	<div class="govuk-clearfix"></div>
	<div class="idsk-warning-text<?php echo $text_type ? ' idsk-warning-text--info' : ''; ?> <?php echo esc_attr( $class_name ); ?>">
		<div class="govuk-width-container">
			<div class="idsk-warning-text__text">
				<?php echo wp_kses_post( $text ); ?>
			</div>
		</div>
	</div>

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
