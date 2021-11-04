<?php
/**
 * BLOCK - tab - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_tab_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/tab', array(
        'render_callback' => 'idsktk_render_dynamic_tab_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_tab_block');

function idsktk_render_dynamic_tab_block($attributes, $content) {
    // block attributes
    $blockId = isset($attributes['blockId']) ? $attributes['blockId'] : '';
    $heading = isset($attributes['heading']) ? $attributes['heading'] : '';
    $tabItem = isset($attributes['tabItem']) ? $attributes['tabItem'] : 0;

    ob_start(); // Turn on output buffering
    ?>

    <li class="idsk-tabs__list-item--mobile" role="presentation">
        <button class="govuk-caption-l idsk-tabs__mobile-tab" item="<?php echo $tabItem ?>" role="tab" aria-controls="<?php echo 'tid-'.$blockId ?>" aria-selected="false" href="<?php echo '#tid-'.$blockId ?>" >
            <?php echo $heading; ?>
            <div class="idsk-tabs__tab-arrow-mobile"></div>
        </button>
        <section class="idsk-tabs__panel <?php $tabItem > 0 ? 'idsk-tabs__panel--hidden' : '' ?>" id="<?php echo 'tid-'.$blockId ?>" role="tabpanel">
            <div class="idsk-tabs__panel-content">
                <?php echo $content; ?>
            </div>
            <div class="idsk-tabs__mobile-tab-content idsk-tabs__mobile-tab-content--hidden">
                <?php echo $content; ?>
            </div>
        </section>
    </li>

    <?php
      /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer
  
    return $output; // Print output
}
