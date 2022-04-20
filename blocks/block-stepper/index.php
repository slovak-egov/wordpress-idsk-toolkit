<?php
/**
 * BLOCK - stepper - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register stepper.
 */
function idsktk_register_dynamic_stepper_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/stepper',
		array(
			'render_callback' => 'idsktk_render_dynamic_stepper_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_stepper_block' );

/**
 * Render stepper.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_stepper_block( $attributes ) {
	// Block attributes.
	$block_id         = 'stepper-' . wp_unique_id();
	$title            = isset( $attributes['title'] ) ? $attributes['title'] : '';
	$caption          = isset( $attributes['caption'] ) ? $attributes['caption'] : '';
	$stepper_subtitle = isset( $attributes['stepperSubtitle'] ) ? $attributes['stepperSubtitle'] : '';
	$items            = isset( $attributes['items'] ) ? $attributes['items'] : array();
	$number_of_items  = count( $items );

	ob_start(); // Turn on output buffering.
	?>

	<h2 class="govuk-heading-l"><?php echo wp_kses_post( $title ); ?></h2>
	<p class="idsk-stepper__caption govuk-caption-m"><?php echo wp_kses_post( $caption ); ?></p>
	<div class="idsk-stepper" data-module="idsk-stepper" id="<?php echo esc_attr( $block_id ); ?>" data-attribute="value">
		<div class="idsk-stepper__subtitle-container">
			<div class="idsk-stepper__subtitle--heading govuk-grid-column-three-quarters">
				<h3 class="govuk-heading-m idsk-stepper__section-subtitle"><?php echo wp_kses_post( $stepper_subtitle ); ?></h3>
			</div>
			<div class="idsk-stepper__controls govuk-grid-column-one-quarter"
				data-line1="<?php esc_attr_e( 'Show all', 'idsk-toolkit' ); ?>"
				data-line2="<?php esc_attr_e( 'Close all', 'idsk-toolkit' ); ?>"
			></div>
		</div>

		<?php
		foreach ( $items as $key => $item ) {
			$heading_id = 'stepper-step-heading-' . $block_id . '-' . $key;
			$content_id = 'stepper-step-content-' . $block_id . '-' . $key;

			if ( '' !== $item['sectionTitle'] ) {
				?>
				<div class="idsk-stepper__section-title">
					<div class="idsk-stepper__section-header idsk-stepper__section-subtitle">
						<p class="govuk-heading-m"><?php echo wp_kses_post( $item['sectionTitle'] ); ?></p>
					</div>
				</div>
				<?php
			}
			?>

			<div class="idsk-stepper__section <?php echo ! ! $item['lastStep'] ? 'idsk-stepper__section--last-item' : ''; ?>">
				<div class="idsk-stepper__section-header">
					<span class="idsk-stepper__circle idsk-stepper__circle--<?php echo '' === $item['subStep'] ? 'number' : 'letter'; ?>">
						<span class="idsk-stepper__circle-inner">
							<span class="idsk-stepper__circle-background">
								<span class="idsk-stepper__circle-step-label"><?php echo esc_html( '' === $item['subStep'] ? $item['step'] : $item['subStep'] ); ?></span>
							</span>
						</span>
					</span>
					<h4 class="idsk-stepper__section-heading">
						<span class="idsk-stepper__section-button" id="<?php echo esc_attr( $heading_id ); ?>">
							<?php echo wp_kses_post( $item['sectionHeading'] ); ?>
						</span>
					</h4>
				</div>
				<div id="<?php echo esc_attr( $content_id ); ?>" class="idsk-stepper__section-content" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
					<?php
					$section_content = new DOMDocument();
					if ( '' !== $item['sectionContent'] ) {
						$section_content->loadHTML( '<?xml encoding="utf-8" ?>' . $item['sectionContent'] );
					}

					// Data modification.
					$content = array();
					foreach ( $section_content->getElementsByTagName( 'li' ) as $node ) {
						foreach ( $node->getElementsByTagName( 'a' ) as $href ) {
							$href->setAttribute( 'class', 'govuk-link' );
							$href->setAttribute( 'title', $href->textContent ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- DOMElement
						}

						$content[] = $section_content->saveHTML( $node );
					}

					foreach ( $content as $key => $val ) {
						echo '<ul class="govuk-list">';
						echo wp_kses_post( $val );
						echo '</ul>';
					}
					?>
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
