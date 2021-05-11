<?php
/**
 * BLOCK - accordion - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_accordion_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/accordion', array(
        'render_callback' => 'idsktk_render_dynamic_accordion_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_accordion_block');

function idsktk_render_dynamic_accordion_block($attributes) {
    // block attributes
    $blockId = $attributes['blockId'];
    $items = isset($attributes['items']) ? $attributes['items'] : array();
  
    ob_start(); // Turn on output buffering
    ?>

    <div class="govuk-accordion" data-module="govuk-accordion" id="<?php echo $blockId; ?>">
        <?php foreach ($items as $key => $item) { ?>
            <div class="govuk-accordion__section <?php echo $item['open'] ? 'govuk-accordion__section--expanded' : '' ?>">
                <div class="govuk-accordion__section-header">
                    <h2 class="govuk-accordion__section-heading">
                        <span class="govuk-accordion__section-button" id="<?php echo $blockId.'-heading-'.$key ?>">
                            <?php echo $item['title']; ?>
                        </span>
                    </h2>
                    <div class="govuk-accordion__section-summary govuk-body" id="<?php echo $blockId.'-summary-'.$key ?>">
                        <?php echo $item['summary']; ?>
                    </div>
                </div>
                <div id="<?php echo $blockId.'-content-'.$key ?>" class="govuk-accordion__section-content" aria-labelledby="<?php echo $blockId.'-heading-'.$key ?>">
                    <?php echo $item['content']; ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php /*
    <div class="govuk-clearfix"></div>
    <div data-module="idsk-accordion" class="<?php echo $className; ?>">
        <?php for ($i=0; $i < $number_of_cols; $i++) { ?>
            <div class="idsk-accordion idsk-accordion-<?php echo $number_of_cols; ?>">
                <?php foreach ($items as $key => $item) { ?>
                    <?php if ($number_of_cols == 1 || round(($key / $number_of_items)) == $i) { ?>
                        <?php if ($hide_tiles) {
                            $aria = ($key > 3 && $number_of_cols == 2 && $i == 0) || ($key > ((($number_of_items / $number_of_cols)) + ($number_of_showed_tiles - 1)) && $number_of_cols == 2 && $i == 1) || ($key > 4 && $number_of_cols == 1) ? 'true' : 'false';
                            $classes = ($key > 4) ? 'idsk-accordion__item--two-columns-hide-mobile' : '';
                            $classes .= (
                                ($key > 4 && $number_of_cols == 2 && $i == 0)
                                || ($key > (($number_of_items / $number_of_cols) + $number_of_showed_tiles - 1) && $number_of_cols == 2 && $i == 1) 
                                || ($key > 4 && $number_of_cols == 1)
                                ) ? ' idsk-accordion__item--two-columns-hide' : '';
                        } ?>
                        <div class="idsk-accordion__item <?php echo $classes; ?>">
                            <a href="<?php echo $item['link']; ?>" class="idsk-accordion-title" title="<?php echo $item['title']; ?>" aria-hidden="<?php echo $aria; ?>">
                                <?php echo $item['title']; ?>
                            </a>
                            <p class="idsk-accordion-subtitle" aria-hidden="<?php echo $aria; ?>"><?php echo $item['subtitle']; ?></p>
                            <hr class="idsk-accordion-line" aria-hidden="true"/>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if ($hide_tiles) { ?>
            <?php $classes = ($number_of_items < 6 && $number_of_cols) || ($number_of_items < 11 && !$number_of_cols) ? ' idsk-accordion__uncollapse-hide--desktop' : ''; ?>
            <?php $classes = $classes . ($number_of_items < 6 ? ' idsk-accordion__uncollapse-hide--mobile' : ''); ?>
        <div class="govuk-grid-column-full idsk-accordion__collapse--shadow idsk-accordion__uncollapse-div<?php echo $classes; ?>">
            <button id="idsk-accordion__uncollapse-button" class="idsk-accordion__colapse--button" type="button" data-line1="<?php echo __( 'Zobraziť viac', 'idsk-toolkit' ); ?>" data-line2="<?php echo __( 'Zobraziť menej', 'idsk-toolkit' ); ?>"><?php echo __( 'Zobraziť viac', 'idsk-toolkit' ); ?></button>
        </div>
        <?php } ?>
    </div> */ ?>
  
    <?php
      /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer
  
    return $output; // Print output
  }