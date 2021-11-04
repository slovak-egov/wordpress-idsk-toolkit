<?php
/**
 * BLOCK - tabs - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_tabs_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/tabs', array(
        'render_callback' => 'idsktk_render_dynamic_tabs_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_tabs_block');

function idsktk_render_dynamic_tabs_block($attributes, $content) {
    // block attributes
    $mainHeading = isset($attributes['heading']) ? $attributes['heading'] : '';
    $headings = isset($attributes['headings']) ? $attributes['headings'] : [];
    $blockIds = isset($attributes['blockIds']) ? $attributes['blockIds'] : [];

    ob_start(); // Turn on output buffering
    ?>

    <div class="idsk-tabs" data-module="idsk-tabs">
        <h2 class="idsk-tabs__title"><?php echo $mainHeading; ?></h2>
        
        <ul class="idsk-tabs__list">
            <?php foreach ($headings as $i=>$heading) { ?>
                <li class="idsk-tabs__list-item <?php $i == 0 ? 'idsk-tabs__list-item--selected' : '' ?>">
                    <a class="idsk-tabs__tab" href="<?php echo '#tid-'.$blockIds[$i] ?>" item="<?php echo $i ?>" title="<?php echo $heading; ?>"><?php echo $heading; ?></a>
                </li>
            <?php } ?>
        </ul>

        <ul class="idsk-tabs__list--mobile" role="tablist">
            <?php echo $content; ?>
        </ul>
    </div>

    <?php
      /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer
  
    return $output; // Print output
}