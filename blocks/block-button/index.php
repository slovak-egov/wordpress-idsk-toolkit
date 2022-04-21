<?php
/**
 * BLOCK - button - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register button.
 */
function idsktk_register_dynamic_button_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/button',
		array(
			'render_callback' => 'idsktk_render_dynamic_button_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_button_block' );

/**
 * Render button.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_button_block( $attributes ) {
	// Block attributes.
	$href    = isset( $attributes['href'] ) ? $attributes['href'] : '';
	$target  = isset( $attributes['target'] ) ? $attributes['target'] : false;
	$color   = isset( $attributes['color'] ) ? $attributes['color'] : '';
	$arrow   = isset( $attributes['arrow'] ) ? $attributes['arrow'] : false;
	$text    = isset( $attributes['text'] ) ? $attributes['text'] : '';
	$is_link = '' !== $href ? true : false;

	ob_start(); // Turn on output buffering.
	?>

	<<?php echo $is_link ? 'a href="' . esc_url( $href ) . '" ' . ( $target ? 'target="_blank"' : '' ) . ' role="button" draggable="false"' : 'button'; ?>
		class="govuk-button <?php echo esc_attr( $color . ( $arrow ? ' govuk-button--start' : '' ) ); ?>"
		data-module="govuk-button"
	>
		<?php
		echo esc_html( $text );

		if ( $arrow ) {
			?>
			<svg class="govuk-button__start-icon" xmlns="http://www.w3.org/2000/svg" width="17.5" height="19" viewBox="0 0 33 40" role="presentation" focusable="false">
				<path fill="currentColor" d="M0 0h13l20 20-20 20H0l20-20z"/>
			</svg>
			<?php
		}
		?>
	</<?php echo $is_link ? 'a' : 'button'; ?>>

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
