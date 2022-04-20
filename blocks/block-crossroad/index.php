<?php
/**
 * BLOCK - crossroad - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register crossroad.
 */
function idsktk_register_dynamic_crossroad_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/crossroad',
		array(
			'render_callback' => 'idsktk_render_dynamic_crossroad_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_crossroad_block' );

/**
 * Render crossroad.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_crossroad_block( $attributes ) {
	// Block attributes.
	$items      = isset( $attributes['items'] ) ? $attributes['items'] : array();
	$class_name = isset( $attributes['className'] ) ? $attributes['className'] : '';
	// Block settings.
	$number_of_cols = isset( $attributes['numberOfCols'] ) && $attributes['numberOfCols'] ? 2 : 1;
	$hide_tiles     = isset( $attributes['hideTiles'] ) && $attributes['hideTiles'] ? $attributes['hideTiles'] : false;
	// Data modification.
	$number_of_items        = count( $items );
	$aria                   = false;
	$classes                = '';
	$number_of_showed_tiles = ( 0 === $number_of_items % 2 ) ? 5 : 6;

	ob_start(); // Turn on output buffering.
	?>

	<div class="govuk-clearfix"></div>
	<div data-module="idsk-crossroad" class="<?php echo esc_attr( $class_name ); ?>">
		<?php
		for ( $i = 0; $i < $number_of_cols; $i++ ) {
			?>
			<div class="idsk-crossroad <?php echo esc_attr( 'idsk-crossroad-' . $number_of_cols ); ?>">
				<?php
				foreach ( $items as $key => $item ) {
					if ( 1 === $number_of_cols || (int) round( ( $key / $number_of_items ) ) === $i ) {
						if ( $hide_tiles ) {
							$aria     = (
								( $key > 3 && 2 === $number_of_cols && 0 === $i )
								|| ( $key > ( ( $number_of_items / $number_of_cols ) + ( $number_of_showed_tiles - 1 ) ) && 2 === $number_of_cols && 1 === $i )
								|| ( $key > 4 && 1 === $number_of_cols )
								) ? 'true' : 'false';
							$classes  = ( $key > 4 ) ? 'idsk-crossroad__item--two-columns-hide-mobile' : '';
							$classes .= (
								( $key > 4 && 2 === $number_of_cols && 0 === $i )
								|| ( $key > ( ( $number_of_items / $number_of_cols ) + ( $number_of_showed_tiles - 1 ) ) && 2 === $number_of_cols && 1 === $i )
								|| ( $key > 4 && 1 === $number_of_cols )
								) ? ' idsk-crossroad__item--two-columns-hide' : '';
						}
						?>
						<div class="idsk-crossroad__item <?php echo esc_attr( $classes ); ?>">
							<a href="<?php echo esc_url( $item['link'] ); ?>" class="govuk-link idsk-crossroad-title" title="<?php echo esc_attr( $item['title'] ); ?>" aria-hidden="<?php echo esc_attr( $aria ); ?>">
								<?php echo esc_html( $item['title'] ); ?>
							</a>
							<p class="idsk-crossroad-subtitle" aria-hidden="<?php echo esc_attr( $aria ); ?>"><?php echo wp_kses_post( $item['subtitle'] ); ?></p>
							<hr class="idsk-crossroad-line" aria-hidden="true"/>
						</div>
						<?php
					}
				}
				?>
			</div>
			<?php
		}

		if ( $hide_tiles ) {
			$classes  = ( $number_of_items < 6 && $number_of_cols ) || ( $number_of_items < 11 && ! $number_of_cols ) ? 'idsk-crossroad__uncollapse-hide--desktop' : '';
			$classes .= $number_of_items < 6 ? 'idsk-crossroad__uncollapse-hide--mobile' : '';
			?>
			<div class="govuk-grid-column-full idsk-crossroad__collapse--shadow idsk-crossroad__uncollapse-div <?php echo esc_attr( $classes ); ?>">
				<button id="idsk-crossroad__uncollapse-button"
					class="idsk-crossroad__colapse--button"
					type="button"
					data-line1="<?php esc_attr_e( 'Show more', 'idsk-toolkit' ); ?>"
					data-line2="<?php esc_attr_e( 'Show less', 'idsk-toolkit' ); ?>"
				>
					<?php esc_html_e( 'Show more', 'idsk-toolkit' ); ?>
				</button>
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
