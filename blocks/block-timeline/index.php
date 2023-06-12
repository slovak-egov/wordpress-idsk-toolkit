<?php
/**
 * BLOCK - timeline - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register timeline.
 */
function idsktk_register_dynamic_timeline_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/timeline',
		array(
			'render_callback' => 'idsktk_render_dynamic_timeline_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_timeline_block' );

/**
 * Render timeline.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_timeline_block( $attributes ) {
	// Block content.
	$items = isset( $attributes['items'] ) ? $attributes['items'] : array();
	$count = 0;

	ob_start(); // Turn on output buffering.
	?>

	<div class="govuk-clearfix"></div>
	<div class="idsk-timeline" data-module="idsk-timeline">
		<div class="govuk-container-width">

			<?php
			foreach ( $items as $key => $item ) {
				if ( $item['isHeading'] ) {
					if ( '' !== $item['dateText'] ) {
						?>
						<div class="idsk-timeline__content <?php echo 0 !== $count ? 'govuk-body' : ''; ?>">
							<div class="idsk-timeline__left-side"></div>
							<div class="idsk-timeline__middle">
								<span class="idsk-timeline__vertical-line"></span>
							</div>
							<div class="idsk-timeline__content__date-line">
								<span class="idsk-timeline__content__text"><?php echo wp_kses_post( $item['dateText'] ); ?></span>
							</div>
						</div>
						<?php
					} elseif ( 0 !== $count ) { // Show separator.
						?>
						<div class="idsk-timeline__content govuk-body">
							<div class="idsk-timeline__left-side"></div>
							<div class="idsk-timeline__middle">
								<span class="idsk-timeline__vertical-line"></span>
							</div>
							<div class="idsk-timeline__content__caption"></div>
						</div>
						<?php
					}

					if ( '' !== $item['heading'] ) {
						?>
						<div class="idsk-timeline__content idsk-timeline__content__title-div">
							<div class="idsk-timeline__left-side"></div>
							<div class="idsk-timeline__middle">
								<span class="idsk-timeline__vertical-line"></span>
							</div>
							<div class="idsk-timeline__content__title">
								<h3 class="govuk-heading-m"><?php echo wp_kses_post( $item['heading'] ); ?></h3>
							</div>
						</div>
						<?php
					}
				}

				if ( ! $item['isHeading'] ) {
					$content    = $item['content'];
					$href_title = wp_kses( $content, array() );
					$long       = strlen( $href_title ) > 80 ? true : false;
					// Data modification.
					$content_replaced_a = str_replace( '<a', '<a class="idsk-card-title govuk-link" title="' . $href_title . '"', $content );
					?>
					<div class="idsk-timeline__content <?php echo $long ? 'idsk-timeline__content__caption--long' : ''; ?>">
						<div class="idsk-timeline__left-side">
							<span class="govuk-body-m"><?php echo wp_kses_post( $item['date'] ); ?></span>
							<br>
							<span class="idsk-timeline__content__time"><?php echo wp_kses_post( $item['time'] ); ?></span>
						</div>
						<div class="idsk-timeline__middle">
							<span class="idsk-timeline__vertical-line--circle"></span>
						</div>
						<div class="idsk-timeline__content__caption">
							<?php echo wp_kses_post( $content_replaced_a ); ?>
						</div>
					</div>
					<?php
				}

				$count++;
			}
			?>

		</div>
	</div>
	<div class="govuk-clearfix"></div>

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
