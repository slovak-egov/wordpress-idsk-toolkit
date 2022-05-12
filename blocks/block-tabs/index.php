<?php
/**
 * BLOCK - tabs - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register tabs.
 */
function idsktk_register_dynamic_tabs_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/tabs',
		array(
			'render_callback' => 'idsktk_render_dynamic_tabs_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_tabs_block' );

/**
 * Render tabs.
 *
 * @param array $attributes Block attributes.
 * @param mixed $content    Inner blocks.
 */
function idsktk_render_dynamic_tabs_block( $attributes, $content ) {
	// Block attributes.
	$main_heading = isset( $attributes['heading'] ) ? $attributes['heading'] : '';
	$headings     = isset( $attributes['headings'] ) ? $attributes['headings'] : array();
	$block_ids    = isset( $attributes['blockIds'] ) ? $attributes['blockIds'] : array();
	$allowed_html = wp_kses_allowed_html( 'post' );

	$allowed_html['button']['href'] = array();
	$allowed_html['button']['item'] = array();

	ob_start(); // Turn on output buffering.
	?>

	<div class="idsk-tabs" data-module="idsk-tabs">
		<h2 class="idsk-tabs__title"><?php echo esc_html( $main_heading ); ?></h2>

		<ul class="idsk-tabs__list">
			<?php
			foreach ( $headings as $i => $heading ) {
				?>
				<li class="idsk-tabs__list-item <?php 0 === $i ? 'idsk-tabs__list-item--selected' : ''; ?>">
					<a class="idsk-tabs__tab" href="<?php echo esc_url( '#tid-' . $block_ids[ $i ] ); ?>" item="<?php echo esc_attr( $i ); ?>" title="<?php echo esc_attr( $heading ); ?>">
						<?php echo esc_html( $heading ); ?>
					</a>
				</li>
				<?php
			}
			?>
		</ul>

		<ul class="idsk-tabs__list--mobile" role="tablist">
			<?php echo wp_kses( $content, $allowed_html ); ?>
		</ul>
	</div>

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
