<?php
/**
 * BLOCK - lists - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_lists_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/lists', array(
        'render_callback' => 'idsktk_render_dynamic_lists_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_lists_block');

function render_items($items, $parent=null) {
    foreach ($items as $key => $item) {
        if ($item['parent'] == $parent) { ?>
            <li><?php echo $item['text'] ?></li>

            <?php if ($item['hasItems'] == true) { 
                $subListType = $item['listType'];
                $subType = strpos($subListType, 'number') ? 'ol' : 'ul';
            ?>
                <<?php echo $subType ?> class="<?php echo "govuk-list ".$subListType ?>">
                    <?php echo render_items($items, $item['id']) ?>
                </<?php echo $subType ?>>

            <?php } ?>

        <?php
        } else {
            continue;
        }
    }
}

function idsktk_render_dynamic_lists_block($attributes) {
    // block attributes
    $listType = isset($attributes['listType']) ? $attributes['listType'] : '';
    $items = isset($attributes['items']) ? $attributes['items'] : '';

    $type = mb_strpos($listType, 'number') ? 'ol' : 'ul';

    ob_start(); // Turn on output buffering
    ?>

    <<?php echo $type; ?> class="<?php echo "govuk-list ".$listType; ?>">
        <?php echo render_items($items); ?>
    </<?php echo $type; ?>>

    <?php
    // END HTML OUTPUT 
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer

    return $output; // Print output
}