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

    <div class="govuk-tabs" data-module="govuk-tabs">
        <h2 class="govuk-tabs__title"><?php echo $mainHeading; ?></h2>
        
        <ul class="govuk-tabs__list">
            <?php foreach ($headings as $i=>$heading) { ?>
                <li class="govuk-tabs__list-item">
                    <a class="govuk-tabs__tab" href="<?php echo '#tab-'.$blockIds[$i] ?>"><?php echo $heading; ?></a>
                </li>
            <?php } ?>
        </ul>

        <?php echo $content; ?>
    </div>

    <?php
      /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer
  
    return $output; // Print output
}