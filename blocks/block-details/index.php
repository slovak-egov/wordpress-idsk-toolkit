<?php
/**
 * BLOCK - details - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_details_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/details', array(
        'render_callback' => 'idsktk_render_dynamic_details_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_details_block');
    
function idsktk_render_dynamic_details_block($attributes) {
    // block attributes
    $summary = isset($attributes['summary']) ? $attributes['summary'] : '';
    $details = isset($attributes['details']) ? $attributes['details'] : '';

    ob_start(); // Turn on output buffering
    ?>

    <details class="govuk-details" data-module="govuk-details">
        <summary class="govuk-details__summary">
            <span class="govuk-details__summary-text">
                <?php echo $summary; ?>
            </span>
        </summary>
        <div class="govuk-details__text">
            <?php echo $details; ?>
        </div>
    </details>

    <?php
    /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer

    return $output; // Print output
}