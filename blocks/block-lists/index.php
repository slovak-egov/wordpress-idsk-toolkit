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
    // $output = '';

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



/*
    foreach ($items as $key => $item) {
        echo $index.'-'.$key.'-'.($key+1).'<br/>';
        echo '<pre>';
        var_dump($item);
        echo '</pre>';
        if ($item['parent'] == $index) { ?>
            <li><?php echo $item['text'] ?></li>

            <?php if ($item['hasItems'] == true) { 
                $subListType = $item['listType'];
                $subType = strpos($subListType, 'number') ? 'ol' : 'ul';
            ?>
                <<?php echo $subType ?> class="<?php echo "govuk-list ".$subListType ?>">
                    <?php echo render_items($items, ($key+1)) ?>
                </<?php echo $subType ?>>
            <?php } ?>

        <?php
        } else {
            continue;
            // break;
        }





        // if ($key >= $index) {
        //     $output .= '<li>'.$item['text'].'</li>';

        //     $listType = ''.$item['listType'];
        //     // echo $key.' - '.$listType.'<br/>';

        //     if ($item['hasItems'] == true && $item['parent'] == $index) { 
        //         $type = strpos($listType, 'number') ? 'ol' : 'ul';

        //         $itemList = render_items($items, $key+1);

        //         // echo '<hr>';
        //         // echo $itemList;
        //         // echo '<hr>';

        //         // $output .= '<'.$type.' class="govuk-list '.$listType.'">';
        //         // $output .= render_items($items, $key+1);
        //         // $output .= '</'.$type.'>';

        //     }
        // } else {
        //     continue;
        // }
    }*/

    // echo $output;
}

function idsktk_render_dynamic_lists_block($attributes) {
    // block attributes
    $listType = isset($attributes['listType']) ? $attributes['listType'] : '';
    $items = isset($attributes['items']) ? $attributes['items'] : '';

    $type = mb_strpos($listType, 'number') ? 'ol' : 'ul';

    ob_start(); // Turn on output buffering

    // echo '
    //     <'.$type.' class="govuk-list '.$listType.'">

    //     </'.$type.'>
    // ';



    ?>

    <<?php echo $type; ?> class="<?php echo "govuk-list ".$listType; ?>">

        <?php
            echo render_items($items); 
/*
            foreach ($items as $key => $item) { ?>

                <li><?php echo $item['text'] ?></li>

            <?php

                
                // echo '<pre>';
                // var_dump($item);
                // echo '</pre>';

                $subListType = $item['listType'];

                if ($item['hasItems'] == true) { 
                    $subType = strpos($subListType, 'number') ? 'ol' : 'ul';
                ?>
                    <<?php echo $subType ?> class="<?php echo "govuk-list ".$subListType ?>">
                        <?php echo render_items($items, $key) ?>
                    </<?php echo $subType ?>>

                <?php
                }
            }*/
        ?>

    </<?php echo $type; ?>>

    <?php
    // END HTML OUTPUT 
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer

    return $output; // Print output
}