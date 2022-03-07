<?php
/**
 * BLOCK - crossroad - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_crossroad_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/crossroad', array(
        'render_callback' => 'idsktk_render_dynamic_crossroad_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_crossroad_block');

function idsktk_render_dynamic_crossroad_block($attributes) {
    // block attributes
    $items = isset($attributes['items']) ? $attributes['items'] : array();
    $className = isset($attributes['className']) ? $attributes['className'] : '';
    // block settings
    $number_of_cols = isset($attributes['numberOfCols']) && $attributes['numberOfCols'] ? 2 : 1;
    $hide_tiles = isset($attributes['hideTiles']) && $attributes['hideTiles'] ? $attributes['hideTiles'] : FALSE;
    // data modification
    $number_of_items = count($items);
    $aria = FALSE;
    $classes = '';
    $number_of_showed_tiles = ($number_of_items % 2 == 0) ? 5 : 6;
  
    ob_start(); // Turn on output buffering
    ?>

    <div class="govuk-clearfix"></div>
    <div data-module="idsk-crossroad" class="<?php echo $className; ?>">
        <?php for ($i=0; $i < $number_of_cols; $i++) { ?>
            <div class="idsk-crossroad idsk-crossroad-<?php echo $number_of_cols; ?>">
                <?php foreach ($items as $key => $item) { ?>
                    <?php if ($number_of_cols == 1 || round(($key / $number_of_items)) == $i) { ?>
                        <?php if ($hide_tiles) {
                            $aria = ($key > 3 && $number_of_cols == 2 && $i == 0) || ($key > ((($number_of_items / $number_of_cols)) + ($number_of_showed_tiles - 1)) && $number_of_cols == 2 && $i == 1) || ($key > 4 && $number_of_cols == 1) ? 'true' : 'false';
                            $classes = ($key > 4) ? 'idsk-crossroad__item--two-columns-hide-mobile' : '';
                            $classes .= (
                                ($key > 4 && $number_of_cols == 2 && $i == 0)
                                || ($key > (($number_of_items / $number_of_cols) + $number_of_showed_tiles - 1) && $number_of_cols == 2 && $i == 1) 
                                || ($key > 4 && $number_of_cols == 1)
                                ) ? ' idsk-crossroad__item--two-columns-hide' : '';
                        } ?>
                        <div class="idsk-crossroad__item <?php echo $classes; ?>">
                            <a href="<?php echo $item['link']; ?>" class="govuk-link idsk-crossroad-title" title="<?php echo $item['title']; ?>" aria-hidden="<?php echo $aria; ?>">
                                <?php echo $item['title']; ?>
                            </a>
                            <p class="idsk-crossroad-subtitle" aria-hidden="<?php echo $aria; ?>"><?php echo $item['subtitle']; ?></p>
                            <hr class="idsk-crossroad-line" aria-hidden="true"/>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if ($hide_tiles) { ?>
            <?php $classes = ($number_of_items < 6 && $number_of_cols) || ($number_of_items < 11 && !$number_of_cols) ? ' idsk-crossroad__uncollapse-hide--desktop' : ''; ?>
            <?php $classes = $classes . ($number_of_items < 6 ? ' idsk-crossroad__uncollapse-hide--mobile' : ''); ?>
        <div class="govuk-grid-column-full idsk-crossroad__collapse--shadow idsk-crossroad__uncollapse-div<?php echo $classes; ?>">
            <button id="idsk-crossroad__uncollapse-button" class="idsk-crossroad__colapse--button" type="button" data-line1="<?php esc_attr_e( 'Show more', 'idsk-toolkit' ); ?>" data-line2="<?php esc_attr_e( 'Show less', 'idsk-toolkit' ); ?>"><?php esc_html_e( 'Show more', 'idsk-toolkit' ); ?></button>
        </div>
        <?php } ?>
    </div>
  
    <?php
      /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer
  
    return $output; // Print output
  }