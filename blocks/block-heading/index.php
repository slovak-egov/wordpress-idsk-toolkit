<?php
/**
 * BLOCK - heading - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_heading_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/heading', array(
        'render_callback' => 'idsktk_render_dynamic_heading_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_heading_block');
    
function idsktk_render_dynamic_heading_block($attributes) {
    // block 
    $anchor = isset($attributes['anchor']) ? $attributes['anchor'] : '';
    $headingType = isset($attributes['headingType']) ? $attributes['headingType'] : 'h1';
    $headingClass = isset($attributes['headingClass']) ? $attributes['headingClass'] : 'xl';
    $headingText = isset($attributes['headingText']) ? $attributes['headingText'] : '';
    $isCaption = isset($attributes['isCaption']) ? $attributes['isCaption'] : false;
    $captionText = isset($attributes['captionText']) ? $attributes['captionText'] : '';

    ob_start(); // Turn on output buffering
    ?>

    <?php if ($isCaption) { ?>
        <span class="<?php echo 'govuk-caption-'.($headingClass != 's' ? $headingClass : 'm'); ?>"><?php echo $captionText; ?></span>
    <?php } ?>
    <<?php echo $headingType; ?> <?php echo $anchor != '' ? 'id="'.$anchor.'"' : '' ?> class="<?php echo 'govuk-heading-'.$headingClass ?>"><?php echo $headingText; ?></<?php echo $headingType; ?>>

    <?php
    /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer

    return $output; // Print output
}