<?php
/**
 * BLOCK - table - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.7
 */

/**
 * Register table.
 */
function idsktk_register_dynamic_table_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/table',
		array(
			'render_callback' => 'idsktk_render_dynamic_table_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_table_block' );

/**
 * Render table section.
 *
 * @param array  $items   List of items to render.
 * @param string $section Table section.
 */
function idsktk_render_table_section( $items, $section = 'body' ) {
	$tag          = 't' . $section;
	$is_head      = 'head' === $section ? true : false;
	$column_class = 'idsk-table__' . ( $is_head ? 'header' : 'cell' );
	?>

	<<?php echo esc_attr( $tag ); ?> class="<?php echo esc_attr( 'idsk-table__' . $section ); ?>">
		<?php
		foreach ( $items as $row_index => $row ) {
			?>
			<tr class="idsk-table__row">
				<?php
				foreach ( $row as $column_index => $column ) {
					?>
					<<?php echo esc_attr( $column['tag'] ); ?> <?php $is_head ? 'scope="col"' : ''; ?> class="<?php echo esc_attr( $column_class . ' ' . $column['class'] ); ?>">
						<?php
						if ( $is_head ) {
							?>
							<span class="th-span">
							<?php
						}

						echo wp_kses_post( $column['content'] );

						if ( $is_head ) {
							?>
							</span>
							<?php
						}
						?>
					</<?php echo esc_attr( $column['tag'] ); ?>>
					<?php
				}
				?>
			</tr>
			<?php
		}
		?>
	</<?php echo esc_attr( $tag ); ?>>

	<?php
}

/**
 * Render table.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_table_block( $attributes ) {
	// Block attributes.
	$block_id     = $attributes['blockId'];
	$with_heading = isset( $attributes['withHeading'] ) && $attributes['withHeading'] ? $attributes['withHeading'] : false;
	$allow_print  = isset( $attributes['allowPrint'] ) && $attributes['allowPrint'] ? $attributes['allowPrint'] : false;
	$tab_head     = isset( $attributes['tabHead'] ) ? $attributes['tabHead'] : array();
	$tab_body     = isset( $attributes['tabBody'] ) ? $attributes['tabBody'] : array();
	$source_link  = isset( $attributes['sourceLink'] ) ? $attributes['sourceLink'] : '';

	ob_start(); // Turn on output buffering.
	?>

	<div data-module="idsk-table" id="<?php echo esc_attr( 'table-' . $block_id ); ?>">
		<table class="idsk-table">
			<?php
			if ( ! ! $with_heading ) {
				echo wp_kses_post( idsktk_render_table_section( $tab_head, 'head' ) );
			}

			echo wp_kses_post( idsktk_render_table_section( $tab_body ) );
			?>
		</table>

		<div class="idsk-table__meta">
			<div class="idsk-button-group idsk-table__meta-buttons">
				<?php
				if ( ! ! $allow_print ) {
					?>
					<button type="button" class="idsk-button idsk-table__meta-print-button" data-module="idsk-button">
						<?php esc_html_e( 'Print', 'idsk-toolkit' ); ?>
					</button>
					<?php
				}
				?>
			</div>

			<div class="govuk-body idsk-table__meta-source">
				<?php echo wp_kses_post( $source_link ); ?>
			</div>
		</div>
	</div>

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
