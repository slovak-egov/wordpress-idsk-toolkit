<?php
/**
 * BLOCK - lists - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register lists.
 */
function idsktk_register_dynamic_lists_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/lists',
		array(
			'render_callback' => 'idsktk_render_dynamic_lists_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_lists_block' );

/**
 * Render list items.
 *
 * @param array $items  List of items.
 * @param int   $parent Parent list item ID.
 */
function render_items( $items, $parent = null ) {
	foreach ( $items as $key => $item ) {
		if ( $parent === $item['parent'] ) {
			?>
			<li><?php echo wp_kses_post( $item['text'] ); ?></li>
			<?php
			if ( true === $item['hasItems'] ) {
				$sub_list_type = $item['listType'];
				$sub_type      = strpos( $sub_list_type, 'number' ) ? 'ol' : 'ul';
				?>
				<li>
				<<?php echo esc_attr( $sub_type ); ?> class="<?php echo esc_attr( 'govuk-list ' . $sub_list_type ); ?>">
					<?php echo wp_kses_post( render_items( $items, $item['id'] ) ); ?>
				</<?php echo esc_attr( $sub_type ); ?>>
			</li>
				<?php
			}
		} else {
			continue;
		}
	}
}

/**
 * Render lists.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_lists_block( $attributes ) {
	// Block attributes.
	$list_type = isset( $attributes['listType'] ) ? $attributes['listType'] : '';
	$items     = isset( $attributes['items'] ) ? $attributes['items'] : '';
	$type      = mb_strpos( $list_type, 'number' ) ? 'ol' : 'ul';

	ob_start(); // Turn on output buffering.
	?>

	<<?php echo esc_attr( $type ); ?> class="<?php echo esc_attr( 'govuk-list ' . $list_type ); ?>">
		<?php echo wp_kses_post( render_items( $items ) ); ?>
	</<?php echo esc_attr( $type ); ?>>

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
