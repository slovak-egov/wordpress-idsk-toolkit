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
 * @param array  $items        List of items to render.
 * @param string $section      Table section.
 * @param bool   $sort         Enables sorting for `thead` section.
 * @param int    $skip_index   Column index that will not be rendered.
 * @param int    $table_height Maximal height of the table.
 */
function idsktk_render_table_section( $items, $section = 'body', $sort = false, $skip_index = -1, $table_height = 0 ) {
	$tag          = 't' . $section;
	$is_head      = 'head' === $section ? true : false;
	$column_class = 'idsk-table__' . ( $is_head ? 'header' : 'cell' );
	?>

	<<?php echo esc_attr( $tag ); ?> class="<?php echo esc_attr( 'idsk-table__' . $section ); ?>" <?php echo 'body' === $section && 0 < $table_height ? 'style="max-height: ' . esc_attr( $table_height ) . 'px;"' : ''; ?>>
		<?php
		foreach ( $items as $row_index => $row ) {
			?>
			<tr class="idsk-table__row">
				<?php
				foreach ( $row as $column_index => $column ) {
					?>
					<<?php echo esc_attr( $column['tag'] ); ?>
						<?php $is_head ? 'scope="col"' : ''; ?>
						class="<?php echo esc_attr( $column_class . ' ' . $column['class'] ); ?>"
						<?php echo ( -1 !== $skip_index && $skip_index === $column_index ? 'style="display: none;"' : '' ); ?>
					>
						<?php
						if ( $is_head ) {
							?>
							<span class="th-span">
							<?php
						}

						echo wp_kses_post( $column['content'] );

						if ( $is_head ) {
							if ( $sort ) {
								?>
								<button class="arrowBtn">
									<span class="sr-only"
										data-text-unordered="<?php esc_attr_e( 'Unordered column - will use ascending order.', 'idsk-toolkit' ); ?>"
										data-text-ascending="<?php esc_attr_e( 'Ordered column - ascending.', 'idsk-toolkit' ); ?>"
										data-text-descending="<?php esc_attr_e( 'Ordered column - descending.', 'idsk-toolkit' ); ?>"
									>
										<?php esc_html_e( 'Unordered column - will use ascending order.', 'idsk-toolkit' ); ?>
									</span>
								</button>
								<?php
							}
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
 * Get options for filter.
 *
 * @param string $name    Filter name.
 * @param int    $index   Column index.
 * @param array  $section Table section to get filters from.
 * @param bool   $select  Sorts options and adds empty value.
 *
 * @return array
 */
function idsktk_get_table_filter_content( $name, $index, $section, $select = false ) {
	$filters = array();

	foreach ( $section as $row => $columns ) {
		if ( false === array_search( $columns[ $index ]['content'], $filters, true ) ) {
			$filters[] = $columns[ $index ]['content'];
		}
	}

	if ( ! ! $select ) {
		sort( $filters );
		array_unshift(
			$filters,
			sprintf(
				/* translators: %s: Option name */
				__( 'Select %s', 'idsk-toolkit' ),
				strtolower( $name )
			)
		);
	}

	return $filters;
}

/**
 * Render table filter.
 *
 * @param string $name     Filter name.
 * @param string $type     Filter type.
 * @param int    $index    Column index.
 * @param string $category Filter category name.
 * @param array  $section  Table section to get filters from.
 *
 * @return string
 */
function idsktk_render_table_filter( $name, $type, $index = 0, $category = '', $section = array() ) {
	$content = '';

	switch ( $type ) {
		case 'input':
			$content .= '<div class="govuk-grid-column-one-third-from-desktop"><div class="govuk-form-group">';
			$content .= '<label class="govuk-label" for="' . strtolower( $name ) . '">' . $name . '</label>';
			$content .= '<input tabindex="-1" class="govuk-input" type="text" id="' . strtolower( $name ) . '" name="' . strtolower( $name ) . '" placeholder="' . $name . '" aria-label="' . $name . '" />';
			$content .= '</div></div>';
			break;
		case 'select':
			$filters = idsktk_get_table_filter_content( $name, $index, $section, true );

			$content .= '<div class="govuk-grid-column-one-third-from-desktop"><div class="govuk-form-group">';
			$content .= '<label class="govuk-label" for="' . strtolower( $name ) . '">' . $name . '</label>';
			$content .= '<select tabindex="-1" class="govuk-select" id="' . strtolower( $name ) . '" name="' . strtolower( $name ) . '">';

			foreach ( $filters as $key => $value ) {
				$content .= '<option value="' . ( 0 !== $key ? strtolower( $value ) : '' ) . '">' . $value . '</option>';
			}

			$content .= '</select>';
			$content .= '</div></div>';
			break;
		case 'switch':
			$content .= '<div class="govuk-radios__item">';
			$content .= '<input class="govuk-radios__input" type="radio" name="' . strtolower( $category ) . '" id="' . strtolower( $name ) . '" value="' . strtolower( $name ) . '" >';
			$content .= '<label class="govuk-label govuk-radios__label" for="' . strtolower( $name ) . '">' . $name . '</label>';
			$content .= '</div>';
			break;
		default:
			break;
	}

	return $content;
}

/**
 * Render table.
 *
 * @param array $attributes Block attributes.
 */
function idsktk_render_dynamic_table_block( $attributes ) {
	// Block attributes.
	$block_id               = $attributes['blockId'];
	$with_title             = isset( $attributes['withTitle'] ) && $attributes['withTitle'] ? $attributes['withTitle'] : false;
	$with_filters           = isset( $attributes['withFilters'] ) && $attributes['withFilters'] ? $attributes['withFilters'] : false;
	$with_filter_categories = isset( $attributes['withFilterCategories'] ) && $attributes['withFilterCategories'] ? $attributes['withFilterCategories'] : false;
	$filter_categories      = isset( $attributes['filterCategories'] ) && $attributes['filterCategories'] ? $attributes['filterCategories'] : array();
	$with_heading           = isset( $attributes['withHeading'] ) && $attributes['withHeading'] ? $attributes['withHeading'] : false;
	$heading_sort           = isset( $attributes['headingSort'] ) && $attributes['headingSort'] ? $attributes['headingSort'] : false;
	$allow_print            = isset( $attributes['allowPrint'] ) && $attributes['allowPrint'] ? $attributes['allowPrint'] : false;
	$table_height           = isset( $attributes['tableHeight'] ) && $attributes['tableHeight'] ? $attributes['tableHeight'] : 0;
	$tab_head               = isset( $attributes['tabHead'] ) ? $attributes['tabHead'] : array();
	$tab_body               = isset( $attributes['tabBody'] ) ? $attributes['tabBody'] : array();
	$title_heading          = isset( $attributes['titleHeading'] ) ? $attributes['titleHeading'] : '';
	$title_desc             = isset( $attributes['titleDesc'] ) ? $attributes['titleDesc'] : '';
	$source_link            = isset( $attributes['sourceLink'] ) ? $attributes['sourceLink'] : '';
	$switch_filters         = array();
	$switch_category        = '';
	$allowed_html           = wp_kses_allowed_html( 'post' );
	$skip_index             = -1;

	if ( ! empty( $tab_head ) ) {
		foreach ( $tab_head[0] as $index => $item ) {
			if ( ! ! $item['filterType'] && 'switch' === $item['filterType'] ) {
				$switch_filters  = idsktk_get_table_filter_content( $item['content'], $index, $tab_body );
				$switch_category = $item['content'];
				$skip_index      = $index;
			}
		}
	}

	$allowed_html['input']  = array(
		'aria-label'  => array(),
		'class'       => array(),
		'id'          => array(),
		'name'        => array(),
		'tabindex'    => array(),
		'type'        => array(),
		'placeholder' => array(),
		'value'       => array(),
	);
	$allowed_html['option'] = array(
		'value' => array(),
	);
	$allowed_html['select'] = array(
		'class'    => array(),
		'name'     => array(),
		'tabindex' => array(),
	);

	ob_start(); // Turn on output buffering.
	?>

	<div data-module="idsk-table" id="<?php echo esc_attr( 'table-' . $block_id ); ?>" class="idsk-table-wrapper">
		<?php
		if ( ! ! $with_title || ! ! $switch_filters ) {
			?>
			<div class="idsk-table__heading">
				<?php
				if ( ! ! $with_title ) {
					?>
					<div>
						<h2 class="govuk-heading-l govuk-!-margin-bottom-4"><?php echo wp_kses_post( $title_heading ); ?></h2>
						<p class="govuk-body"><?php echo wp_kses_post( $title_desc ); ?></p>
					</div>
					<?php
				}

				if ( ! ! $switch_filters ) {
					?>
					<div class="idsk-table__heading-extended">
						<div class="govuk-form-group">
							<div class="govuk-radios govuk-radios--inline">
								<?php
								foreach ( $switch_filters as $key => $value ) {
									echo wp_kses( idsktk_render_table_filter( $value, 'switch', 0, $switch_category ), $allowed_html );
								}
								?>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}

		if ( ! ! $with_filters ) {
			?>
			<div data-module="idsk-table-filter" id="<?php echo esc_attr( 'table-' . $block_id . '-filter' ); ?>" class="idsk-table-filter">
				<div class="idsk-table-filter__panel idsk-table-filter__inputs">
					<div class="idsk-table-filter__title govuk-heading-m"><?php esc_html_e( 'Filter content', 'idsk-toolkit' ); ?></div>
					<button class="govuk-body govuk-link idsk-filter-menu__toggle"
						tabindex="0"
						data-open-text="<?php esc_attr_e( 'Expand filter content', 'idsk-toolkit' ); ?>"
						data-close-text="<?php esc_attr_e( 'Collapse filter content', 'idsk-toolkit' ); ?>"
						data-category-name=""
						aria-label="<?php esc_attr_e( 'Expand filter content', 'idsk-toolkit' ); ?>"
						type="button"
					>
						<?php esc_html_e( 'Expand filter content', 'idsk-toolkit' ); ?>
					</button>

					<form class="idsk-table-filter__content" action="#">
						<?php
						if ( ! ! $with_filter_categories && ! empty( $filter_categories ) ) {
							foreach ( $filter_categories as $category ) {
								?>
								<div class="idsk-table-filter__category">
									<div class="idsk-table-filter__title govuk-heading-s"><?php echo esc_html( $category['text'] ); ?> <span class="count"></span></div>
									<button class="govuk-body govuk-link idsk-filter-menu__toggle"
										tabindex="-1"
										data-open-text="<?php esc_attr_e( 'Expand filter section', 'idsk-toolkit' ); ?>"
										data-close-text="<?php esc_attr_e( 'Collapse filter section', 'idsk-toolkit' ); ?>"
										data-category-name="<?php echo esc_attr( $category['text'] ); ?>"
										aria-label="<?php echo esc_attr( __( 'Expand filter section', 'idsk-toolkit' ) . ' ' . $category['text'] ); ?>"
										type="button"
									>
										<?php esc_html_e( 'Expand filter section', 'idsk-toolkit' ); ?>
									</button>

									<div class="idsk-table-filter__content">
										<div class="govuk-grid-row idsk-table-filter__filter-inputs">
											<?php
											foreach ( $tab_head[0] as $index => $item ) {
												if ( ! ! $item['filterType'] && '' !== $item['filterType'] && 'switch' !== $item['filterType'] && $category['id'] === $item['filterCategory'] ) {
													echo wp_kses( idsktk_render_table_filter( $item['content'], $item['filterType'], $index, '', $tab_body ), $allowed_html );
												}
											}
											?>
										</div>
									</div>
								</div>
								<?php
							}
						} else {
							?>
							<div class="govuk-grid-row idsk-table-filter__filter-inputs">
								<?php
								foreach ( $tab_head[0] as $index => $item ) {
									if ( '' !== $item['filterType'] && 'switch' !== $item['filterType'] ) {
										echo wp_kses( idsktk_render_table_filter( $item['content'], $item['filterType'], $index, '', $tab_body ), $allowed_html );
									}
								}
								?>
							</div>
							<?php
						}
						?>

						<button type="submit" class="idsk-button submit-table-filter" disabled="disabled">
							<?php
								echo wp_kses_post(
									sprintf(
										/* translators: %s: Number of active filters */
										__( 'Filter (%s)', 'idsk-toolkit' ),
										'<span class="count">0</span>'
									)
								);
							?>
						</button>
					</form>
				</div>

				<div class="idsk-table-filter__panel idsk-table-filter__active-filters idsk-table-filter__active-filters__hide idsk-table-filter--expanded"
					data-remove-filter="<?php esc_attr_e( 'Cancel filter', 'idsk-toolkit' ); ?>"
					data-remove-all-filters="<?php esc_attr_e( 'Cancel all', 'idsk-toolkit' ); ?>"
				>
					<div class="govuk-body idsk-table-filter__title"><?php esc_html_e( 'Active filter', 'idsk-toolkit' ); ?></div>
					<button class="govuk-body govuk-link idsk-filter-menu__toggle"
						tabindex="0"
						data-open-text="<?php esc_attr_e( 'Expand active filter', 'idsk-toolkit' ); ?>"
						data-close-text="<?php esc_attr_e( 'Collapse active filter', 'idsk-toolkit' ); ?>"
						data-category-name=""
						aria-label="<?php esc_attr_e( 'Collapse active filter', 'idsk-toolkit' ); ?>"
						type="button"
					>
						<?php esc_html_e( 'Collapse active filter', 'idsk-toolkit' ); ?>
					</button>

					<div class="govuk-clearfix idsk-table-filter__content"></div>
				</div>
			</div>
			<?php
		}
		?>

		<table class="idsk-table">
			<?php
			if ( ! ! $with_heading ) {
				echo wp_kses_post( idsktk_render_table_section( $tab_head, 'head', $heading_sort, $skip_index ) );
			}

			echo wp_kses_post( idsktk_render_table_section( $tab_body, 'body', false, $skip_index, $table_height ) );
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
