<?php
/**
 * BLOCK - address - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_address_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/address', array(
        'render_callback' => 'idsktk_render_dynamic_address_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_address_block');
    
function idsktk_render_dynamic_address_block($attributes) {
    // block attributes
    $title = isset($attributes['title']) ? $attributes['title'] : '';
    $titleSmall = isset($attributes['titleSmall']) ? $attributes['titleSmall'] : '';
    $body = new DOMDocument();
    $body->loadHTML($attributes['body']);
    $coords = isset($attributes['mapCoords']) ? $attributes['mapCoords'] : '0,0';
    $mapApi = isset($attributes['mapApi']) ? $attributes['mapApi'] : get_theme_mod('idsk_main_settings_map_api');
    $className = isset($attributes['className']) ? $attributes['className'] : '';
    // block settings
    $address_grid_type = isset($attributes['gridType']) ? FALSE : TRUE;
    // data modification
    $paragraphs = array();
    foreach($body->getElementsByTagName('p') as $node)
    {
        $node->setAttribute('class', 'govuk-body');
        
        foreach($node->getElementsByTagName('a') as $href)
        {
            $link = $body->createElement('span');
            $link->setAttribute('class', 'idsk-address__link-text');
            $link->textContent = $href->textContent;
            
            $href->setAttribute('class', 'govuk-link');
            $href->textContent = '';
            $href->appendChild($link);
        }
        
        $paragraphs[] = $body->saveHTML($node);
    }

    ob_start(); // Turn on output buffering
    ?>

    <div data-module="idsk-address" class="idsk-address <?php echo $address_grid_type ? '' : 'idsk-address--full-width'; ?> <?php echo $className; ?>">
        <hr class="idsk-address__separator-top">
        <div class="idsk-address__content">
            <div class="idsk-address__description">
                <?php echo $title != '' ? '<h2 class="govuk-heading-m">'.$title.'</h2>' : '' ?>
                <h3 class="govuk-heading-s"><?php echo $titleSmall ?></h3>
                <?php 
                foreach ($paragraphs as $key => $val) {
                    echo $val;
                }
                ?>
            </div>
            <iframe 
                class="idsk-address__map"
                loading="lazy"
                allowfullscreen
                src="https://www.google.com/maps/embed/v1/place?q=<?php echo $coords ?>&amp;key=<?php echo $mapApi ?>">
            </iframe>
            </div>
        <hr class="idsk-address__separator-bottom">
    </div>


    <?php
    /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer

    return $output; // Print output
}