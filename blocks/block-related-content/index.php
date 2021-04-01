<?php
/**
 * BLOCK - related-content - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function register_dynamic_related_content_block() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
      return;
  }

  // Hook server side rendering into render callback
  register_block_type('idsk/related-content', array(
      'render_callback' => 'render_dynamic_related_content_block'
  ));
}
add_action('init', 'register_dynamic_related_content_block');
    
function render_dynamic_related_content_block($attributes) {
  // block attributes
  $title = $attributes['title'];
  $body = $attributes['body'];
  $className = isset($attributes['className']) ? $attributes['className'] : '';
  // block settings
  $related_content_grid_type = isset($attributes['gridType']) ? FALSE : TRUE;
  // data modification
  $body_replaced_li = str_replace('<li>', '<li class="idsk-related-content__list-item">', $body);
  $body_final = str_replace('<a', '<a class="idsk-related-content__link"', $body_replaced_li);

  ob_start(); // Turn on output buffering
  ?>
  <div class="<?php echo $related_content_grid_type ? 'govuk-grid-column-two-thirds' : 'govuk-grid-column-one-third'; ?> <?php echo $className; ?>">
    <div class="idsk-related-content " data-module="idsk-related-content">
      <hr class="idsk-related-content__line" aria-hidden="true" />
      <h4 class="idsk-related-content__heading govuk-heading-s"><?php echo $title; ?></h4>
      <ul class="idsk-related-content__list govuk-list">
        <?php echo $body_final; ?> 
      </ul>
    </div>
  </div>

  <?php
    /* END HTML OUTPUT */
  $output = ob_get_contents(); // collect output
  ob_end_clean(); // Turn off ouput buffer

  return $output; // Print output
}