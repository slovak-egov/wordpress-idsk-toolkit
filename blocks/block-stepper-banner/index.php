<?php
/**
 * BLOCK - stepper-banner - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_stepper_banner_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/stepper-banner', array(
        'render_callback' => 'idsktk_render_dynamic_stepper_banner_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_stepper_banner_block');

function idsktk_render_dynamic_stepper_banner_block($attributes) {

    // block attributes
    $textHeading = isset($attributes['textHeading']) ? $attributes['textHeading'] : '';
    $textBanner = isset($attributes['textBanner']) ? $attributes['textBanner'] : '';
    $textBannerFinal = str_replace('<a', '<a class="govuk-link"', $textBanner);
  
    ob_start(); // Turn on output buffering
    ?>

    <div data-module="idsk-banner">
        <div class="idsk-banner" role="contentinfo">
            <div class="govuk-container-width">
                <div class="idsk-banner__content app-pane-grey">
                    <h2 class="govuk-heading-s"><?php echo $textHeading; ?></h2>
                    <h3 class="govuk-heading-m"><?php echo $textBannerFinal; ?></h3>
                </div>
            </div>
        </div>
    </div>
  
    <?php
      /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer
  
    return $output; // Print output
}