<?php
/**
 * BLOCK - accordion - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register accordion.
 */
function idsktk_register_dynamic_accordion_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/accordion',
		array(
			'render_callback' => 'idsktk_render_dynamic_accordion_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_accordion_block' );

/**
 * Render accordion.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_accordion_block( $attributes ) {
	// Block attributes.
	$block_id = $attributes['blockId'];
	$items    = isset( $attributes['items'] ) ? $attributes['items'] : array();

	ob_start(); // Turn on output buffering.
	?>

	<div class="govuk-accordion" data-module="idsk-accordion" id="<?php echo esc_attr( $block_id ); ?>">
		<div class="govuk-accordion__controls">
			<button class="govuk-accordion__open-all"
				data-open-title="<?php esc_attr_e( 'Open all', 'idsk-toolkit' ); ?>"
				data-close-title="<?php esc_attr_e( 'Close all', 'idsk-toolkit' ); ?>"
				type="button"
				aria-expanded="false"
			>
				<span class="govuk-visually-hidden govuk-accordion__controls-span" data-section-title="<?php esc_attr_e( 'sections', 'idsk-toolkit' ); ?>"></span>
			</button>
		</div>

		<?php
		foreach ( $items as $key => $item ) {
			?>
			<div class="govuk-accordion__section <?php echo $item['open'] ? 'govuk-accordion__section--expanded' : ''; ?>">
				<div class="govuk-accordion__section-header">
					<h2 class="govuk-accordion__section-heading">
						<span class="govuk-accordion__section-button" id="<?php echo esc_attr( $block_id . '-heading-' . ( $key + 1 ) ); ?>">
							<?php echo esc_html( $item['title'] ); ?>
						</span>
					</h2>
					<div class="govuk-accordion__section-summary govuk-body" id="<?php echo esc_attr( $block_id . '-summary-' . ( $key + 1 ) ); ?>">
						<?php echo esc_html( $item['summary'] ); ?>
					</div>
				</div>
				<div id="<?php echo esc_attr( $block_id . '-content-' . ( $key + 1 ) ); ?>"
					class="govuk-accordion__section-content"
					aria-labelledby="<?php echo esc_attr( $block_id . '-heading-' . ( $key + 1 ) ); ?>"
				>
					<?php echo wp_kses_post( $item['content'] ); ?>
				</div>
			</div>
			<?php
		}
		?>
	</div>

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
