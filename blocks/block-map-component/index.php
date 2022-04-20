<?php
/**
 * BLOCK - map-component - register dynamic block.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Register map component.
 */
function idsktk_register_dynamic_map_component_block() {
	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback.
	register_block_type(
		'idsk/map-component',
		array(
			'render_callback' => 'idsktk_render_dynamic_map_component_block',
		)
	);
}
add_action( 'init', 'idsktk_register_dynamic_map_component_block' );

/**
 * Render map component.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_map_component_block( $attributes ) {
	// Block attributes.
	$block_id           = $attributes['blockId'];
	$title              = isset( $attributes['title'] ) ? $attributes['title'] : '';
	$indicator_options  = isset( $attributes['indicatorOptions'] ) ? $attributes['indicatorOptions'] : array();
	$iframe_map_title   = isset( $attributes['iframeMapTitle'] ) ? $attributes['iframeMapTitle'] : '';
	$iframe_table_title = isset( $attributes['iframeTableTitle'] ) ? $attributes['iframeTableTitle'] : '';
	$iframe_map         = isset( $attributes['iframeMap'] ) ? $attributes['iframeMap'] : '';
	$iframe_table       = isset( $attributes['iframeTable'] ) ? $attributes['iframeTable'] : '';
	$csv_download       = isset( $attributes['csvDownload'] ) ? $attributes['csvDownload'] : '';
	$download_text      = isset( $attributes['downloadText'] ) ? $attributes['downloadText'] : '';
	$source             = isset( $attributes['source'] ) ? $attributes['source'] : '';

	ob_start(); // Turn on output buffering.
	?>

	<div data-module="idsk-interactive-map" class="idsk-interactive-map">
		<h2 class="govuk-heading-l"><?php echo wp_kses_post( $title ); ?></h2>
		<div class="idsk-interactive-map__header">
			<div class="idsk-interactive-map__header-controls">

				<div class="idsk-interactive-map__header-radios">
					<div class="govuk-form-group">
						<div class="govuk-radios govuk-radios--inline">
							<div class="govuk-radios__item idsk-intereactive-map__radio-map">
								<input class="govuk-radios__input" name="<?php echo esc_attr( $block_id . '-interactive-radios-b' ); ?>" id="<?php echo esc_attr( $block_id . '-interactive-radios-b-1' ); ?>" type="radio" value="map" checked>
								<label class="govuk-label govuk-radios__label" for="<?php echo esc_attr( $block_id . '-interactive-radios-b-1' ); ?>">
									<?php esc_html_e( 'Map', 'idsk-toolkit' ); ?>
								</label>
							</div>
							<div class="govuk-radios__item idsk-intereactive-map__radio-table">
								<input class="govuk-radios__input" name="<?php echo esc_attr( $block_id . '-interactive-radios-b' ); ?>" id="<?php echo esc_attr( $block_id . '-interactive-radios-b-2' ); ?>" type="radio" value="table">
								<label class="govuk-label govuk-radios__label" for="<?php echo esc_attr( $block_id . '-interactive-radios-b-2' ); ?>">
									<?php esc_html_e( 'Table', 'idsk-toolkit' ); ?>
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="idsk-interactive-map__header-selects">
					<div class="govuk-form-group">
						<div class="govuk-label-wrapper">
							<label class="govuk-label" for="<?php echo esc_attr( $block_id . '-time-period' ); ?>">
								<strong><?php esc_html_e( 'Period', 'idsk-toolkit' ); ?></strong>
							</label>
						</div>
						<select class="idsk-interactive-map__select-time-period govuk-select" id="<?php echo esc_attr( $block_id . '-time-period' ); ?>" name="<?php echo esc_attr( $block_id . '-time-period' ); ?>">
							<option value="30"><?php esc_html_e( 'Last month', 'idsk-toolkit' ); ?></option>
							<option value="90"><?php esc_html_e( 'Last 3 months', 'idsk-toolkit' ); ?></option>
							<option value="180"><?php esc_html_e( 'Last 6 months', 'idsk-toolkit' ); ?></option>
							<option value="" selected="selected"><?php esc_html_e( 'Entire period', 'idsk-toolkit' ); ?></option>
						</select>
					</div>

					<?php
					if ( count( $indicator_options ) > 0 ) {
						?>
						<div class="govuk-form-group">
							<div class="govuk-label-wrapper">
								<label class="govuk-label" for="<?php echo esc_attr( $block_id . '-indicator' ); ?>">
									<strong><?php esc_html_e( 'Indicator', 'idsk-toolkit' ); ?></strong>
								</label>
							</div>
							<select class="idsk-interactive-map__select-indicator govuk-select" id="<?php echo esc_attr( $block_id . '-indicator' ); ?>" name="<?php echo esc_attr( $block_id . '-indicator' ); ?>">
								<?php
								foreach ( $indicator_options as $key => $item ) {
									?>
									<option value="<?php echo esc_attr( $item['value'] ); ?>"><?php echo esc_html( $item['text'] ); ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<?php
					}
					?>
				</div>

			</div>
			<?php
			if ( count( $indicator_options ) > 0 ) {
				?>
				<h3 class="govuk-heading-m">
					<span class="idsk-interactive-map__current-indicator"><?php echo esc_html( $indicator_options[0]['text'] ); ?></span> <?php esc_html_e( 'for', 'idsk-toolkit' ); ?> <span class="idsk-interactive-map__current-time-period"><?php esc_html_e( 'entire period', 'idsk-toolkit' ); ?></span>
				</h3>
				<?php
			}
			?>
		</div>

		<div class="idsk-interactive-map__body">
			<div class="idsk-interactive-map__map">
				<iframe class="idsk-interactive-map__map-iframe" data-src="<?php echo esc_url( $iframe_map ); ?>" src="<?php echo esc_url( $iframe_map ); ?>" title="<?php echo esc_attr( $iframe_map_title ); ?>"></iframe>
			</div>
			<div class="idsk-interactive-map__table">
				<iframe class="idsk-interactive-map__table-iframe" data-src="<?php echo esc_url( $iframe_table ); ?>" title="<?php echo esc_attr( $iframe_table_title ); ?>"></iframe>
			</div>
		</div>
		<div class="idsk-interactive-map__meta">
			<a class="govuk-link idsk-interactive-map__meta-data" title="<?php echo esc_attr( $download_text ); ?>" href="<?php echo esc_url( $csv_download ); ?>" download>
				<?php echo esc_html( $download_text ); ?>
			</a>
			<span class="idsk-interactive-map__meta-source"><?php echo wp_kses_post( $source ); ?></span>
		</div>
	</div>
	<div class="govuk-clearfix"></div>

	<?php
	/* END HTML OUTPUT */
	$output = ob_get_contents(); // Collect output.
	ob_end_clean(); // Turn off ouput buffer.

	return $output; // Print output.
}
