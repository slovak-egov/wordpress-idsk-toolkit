<?php
/**
 * BLOCK - warning-text - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function register_dynamic_warning_text_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/warning-text', array(
        'render_callback' => 'render_dynamic_warning_text_block'
    ));
}
add_action('init', 'register_dynamic_warning_text_block');

function render_dynamic_warning_text_block($attributes) {

    // block attributes
    $text = $attributes['text'];
    $className = isset($attributes['className']) ? $attributes['className'] : '';
    // block settings
    $text_type = isset($attributes['textType']) && $attributes['textType'] ? $attributes['textType'] : FALSE;
  
    ob_start(); // Turn on output buffering
    ?>

    <div class="govuk-clearfix"></div>
    <div class="idsk-warning-text<?php echo $text_type ? ' idsk-warning-text--info' : ''; ?> <?php echo $className; ?>">
        <div class="govuk-width-container">
            <div class="idsk-warning-text__text">
                <?php echo $text; ?> 
            </div>
        </div>
    </div>
  
    <?php
      /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer
  
    return $output; // Print output
  }