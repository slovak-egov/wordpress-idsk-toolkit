<?php
/**
 * BLOCK - stepper-banner - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register stepper banner.
 */
function idsktk_register_dynamic_stepper_banner_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/stepper-banner',
		array(
			'render_callback' => 'idsktk_render_dynamic_stepper_banner_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_stepper_banner_block' );

/**
 * Render stepper banner.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_stepper_banner_block( $attributes ) {
	// Block attributes.
	$text_heading      = isset( $attributes['textHeading'] ) ? $attributes['textHeading'] : '';
	$text_banner       = isset( $attributes['textBanner'] ) ? $attributes['textBanner'] : '';
	$text_banner_final = str_replace( '<a', '<a class="govuk-link"', $text_banner );

	ob_start(); // Turn on output buffering.
	?>

	<div data-module="idsk-banner">
		<div class="idsk-banner" role="contentinfo">
			<div class="govuk-container-width">
				<div class="idsk-banner__content app-pane-grey">
					<h2 class="govuk-heading-s"><?php echo wp_kses_post( $text_heading ); ?></h2>
					<h3 class="govuk-heading-m"><?php echo wp_kses_post( $text_banner_final ); ?></h3>
				</div>
			</div>
		</div>
	</div>

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
