<?php
/**
 * BLOCK - address - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register address.
 */
function idsktk_register_dynamic_address_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/address',
		array(
			'render_callback' => 'idsktk_render_dynamic_address_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_address_block' );

/**
 * Render address.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_address_block( $attributes ) {
	// Block attributes.
	$title       = isset( $attributes['title'] ) ? $attributes['title'] : '';
	$title_small = isset( $attributes['titleSmall'] ) ? $attributes['titleSmall'] : '';
	$body        = new DOMDocument();
	if ( isset( $attributes['body'] ) && '' !== $attributes['body'] ) {
		$body->loadHTML( '<?xml encoding="utf-8" ?>' . $attributes['body'] );
	}
	$iframe_title = isset( $attributes['mapIframeTitle'] ) ? $attributes['mapIframeTitle'] : '';
	$coords       = isset( $attributes['mapCoords'] ) ? $attributes['mapCoords'] : '0,0';
	$map_api      = ( isset( $attributes['mapApi'] ) && $attributes['mapApi'] ) ? $attributes['mapApi'] : get_theme_mod( 'idsktk_main_settings_map_api' );
	$class_name   = isset( $attributes['className'] ) ? $attributes['className'] : '';
	// Block settings.
	$address_grid_type = isset( $attributes['gridType'] ) ? false : true;
	// Data modification.
	$paragraphs = array();
	foreach ( $body->getElementsByTagName( 'p' ) as $node ) {
		$node->setAttribute( 'class', 'govuk-body' );

		foreach ( $node->getElementsByTagName( 'a' ) as $href ) {
			$link = $body->createElement( 'span' );
			$link->setAttribute( 'class', 'idsk-address__link-text' );
			$link->textContent = $href->textContent; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- DOMElement

			$href->setAttribute( 'class', 'govuk-link' );
			$href->textContent = ''; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- DOMElement
			$href->appendChild( $link );
		}

		$paragraphs[] = $body->saveHTML( $node );
	}

	ob_start(); // Turn on output buffering.
	?>

	<div data-module="idsk-address" class="idsk-address <?php echo $address_grid_type ? '' : 'idsk-address--full-width'; ?> <?php echo esc_attr( $class_name ); ?>">
		<hr class="idsk-address__separator-top">
		<div class="idsk-address__content">
			<div class="idsk-address__description">
				<?php echo '' !== $title ? '<h2 class="govuk-heading-m">' . wp_kses_post( $title ) . '</h2>' : ''; ?>
				<h3 class="govuk-heading-s"><?php echo wp_kses_post( $title_small ); ?></h3>
				<?php
				foreach ( $paragraphs as $key => $val ) {
					echo wp_kses_post( $val );
				}
				?>
			</div>
			<iframe
				class="idsk-address__map"
				loading="lazy"
				title="<?php echo esc_attr( $iframe_title ); ?>"
				allowfullscreen
				src="https://www.google.com/maps/embed/v1/place?q=<?php echo esc_attr( $coords ); ?>&amp;key=<?php echo esc_attr( $map_api ); ?>"
			>
			</iframe>
		</div>
		<hr class="idsk-address__separator-bottom" />
	</div>

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
