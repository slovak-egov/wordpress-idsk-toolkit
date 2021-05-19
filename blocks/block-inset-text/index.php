<?php
/**
 * BLOCK - inset-text - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_inset_text_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/inset-text', array(
        'render_callback' => 'idsktk_render_dynamic_inset_text_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_inset_text_block');

function idsktk_render_dynamic_inset_text_block($attributes) {

    // block attributes
    $text = isset($attributes['text']) ? $attributes['text'] : '';
  
    ob_start(); // Turn on output buffering
    ?>

    <div class="govuk-inset-text">
        <?php echo $text; ?>
    </div>
  
    <?php
      /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer
  
    return $output; // Print output
  }