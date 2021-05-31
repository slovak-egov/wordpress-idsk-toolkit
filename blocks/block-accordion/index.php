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

    <div class="govuk-accordion" data-module="idsk-accordion" id="<?php echo $blockId; ?>">
        <div class="govuk-accordion__controls">
            <button class="govuk-accordion__open-all" data-open-title="<?php echo esc_attr__('Otvoriť všetky', 'idsk-toolkit'); ?>" data-close-title="<?php echo esc_attr__('Zatvoriť všetky', 'idsk-toolkit'); ?>" type="button" aria-expanded="false">
                <span class="govuk-visually-hidden govuk-accordion__controls-span" data-section-title="<?php echo esc_attr__('sekcie', 'idsk-toolkit'); ?>"></span>
            </button>
        </div>

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
    
    <?php
      /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer
  
    return $output; // Print output
  }