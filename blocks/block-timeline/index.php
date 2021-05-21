<?php
/**
 * BLOCK - timeline - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_timeline_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/timeline', array(
        'render_callback' => 'idsktk_render_dynamic_timeline_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_timeline_block');
    
function idsktk_render_dynamic_timeline_block($attributes) {
    // block content
    $items = isset($attributes['items']) ? $attributes['items'] : array();
    $count = 0;

    ob_start(); // Turn on output buffering
?>

    <div class="govuk-clearfix"></div>
    <div class="idsk-timeline " data-module="idsk-timeline" role="contentinfo">
        <div class="govuk-container-width">
            <div class="idsk-timeline__button__div">
                <button type="button" class="idsk-timeline__button--back">
                </button>
            </div>

            <?php foreach ($items as $key => $item) { ?>

                <?php if ($item['isHeading']) { ?>
                    <?php if ($item['dateText'] != '') { ?>
                        <div class="idsk-timeline__content <?php echo $count!=0 ? 'govuk-body' : '' ?>">
                            <div class="idsk-timeline__left-side"></div>
                            <div class="idsk-timeline__middle">
                                <span class="idsk-timeline__vertical-line"></span>
                            </div>
                            <div class="idsk-timeline__content__date-line">
                                <span class="idsk-timeline__content__text"><?php echo $item['dateText'] ?></span>
                            </div>
                        </div>
                    <?php } elseif ($count != 0) { // for separator ?>
                        <div class="idsk-timeline__content govuk-body">
                            <div class="idsk-timeline__left-side"></div>
                            <div class="idsk-timeline__middle">
                                <span class="idsk-timeline__vertical-line"></span>
                            </div>
                            <div class="idsk-timeline__content__caption">
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($item['heading'] != '') { ?>
                        <div class="idsk-timeline__content idsk-timeline__content__title-div">
                            <div class="idsk-timeline__left-side"></div>
                            <div class="idsk-timeline__middle">
                                <span class="idsk-timeline__vertical-line"></span>
                            </div>
                            <div class="idsk-timeline__content__title">
                                <h3 class="govuk-heading-m"><?php echo $item['heading'] ?></h3>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if (!$item['isHeading']) { ?>
                    <?php
                        $content = $item['content'];
                        $hrefTitle = wp_kses($content, []);
                        $long = strlen($hrefTitle) > 80 ? true : false;

                        // data modification
                        $content_replaced_a = str_replace('<a', '<a class="idsk-card-title govuk-link" title="'.$hrefTitle.'"', $content);
                    ?>

                    <div class="idsk-timeline__content <?php echo $long ? 'idsk-timeline__content__caption--long' : '' ?>">
                        <div class="idsk-timeline__left-side">
                            <span class="govuk-body-m"><?php echo $item['date'] ?></span>
                            <br>
                            <span class="idsk-timeline__content__time"><?php echo $item['time'] ?></span>
                        </div>
                        <div class="idsk-timeline__middle">
                            <span class="idsk-timeline__vertical-line--circle"></span>
                        </div>
                        <div class="idsk-timeline__content__caption">
                            <?php echo $content_replaced_a ?>
                        </div>
                    </div>
                <?php } ?>
                <?php $count++ ?>

            <?php } ?>
        
            <button type="button" class="idsk-timeline__button--forward">
            </button>
        </div>
    </div>
    <div class="govuk-clearfix"></div>

    <?php
    /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer

    return $output; // Print output
}