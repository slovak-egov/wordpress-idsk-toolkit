<?php
/**
 * BLOCK - stepper - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_stepper_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/stepper', array(
        'render_callback' => 'idsktk_render_dynamic_stepper_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_stepper_block');
    
function idsktk_render_dynamic_stepper_block($attributes) {
    // block attributes
    $title = isset($attributes['title']) ? $attributes['title'] : '';
    $caption = isset($attributes['caption']) ? $attributes['caption'] : '';
    $stepperSubtitle = isset($attributes['stepperSubtitle']) ? $attributes['stepperSubtitle'] : '';
    $items = isset($attributes['items']) ? $attributes['items'] : array();
    
    $number_of_items = count($items);

    ob_start(); // Turn on output buffering
    ?>

    <h2 class="govuk-heading-l"><?= $title ?></h2>
    <p class="idsk-stepper__caption govuk-caption-m"><?= $caption ?></p>
    <div class="idsk-stepper myClass" data-module="idsk-stepper" id="default-example" data-attribute="value" >

        <div class="idsk-stepper__subtitle-container">
            <div class="idsk-stepper__subtitle--heading govuk-grid-column-three-quarters">
                <h3 class="govuk-heading-m idsk-stepper__section-subtitle"><?= $stepperSubtitle ?></h3>
            </div>
            <div class="idsk-stepper__controls govuk-grid-column-one-quarter" data-line1="<?php echo __( 'Zobraziť všetko', 'idsk-toolkit' ); ?>" data-line2="<?php echo __( 'Zatvoriť všetko', 'idsk-toolkit' ); ?>">
            </div>
        </div>

        <?php foreach ($items as $key => $item) { ?>
            <?php if ($item['sectionTitle'] != '') { ?>
            <div class="idsk-stepper__section-title">
                <div class="idsk-stepper__section-header idsk-stepper__section-subtitle">
                    <p class="govuk-heading-m"><?= $item['sectionTitle'] ?></p>
                </div>
            </div>
            <?php } ?>

            <div class="idsk-stepper__section <?= !!$item['lastStep'] ? 'idsk-stepper__section--last-item' : '' ?>">
                <div class="idsk-stepper__section-header">
                    <span class="idsk-stepper__circle idsk-stepper__circle--<?= $item['subStep'] == '' ? 'number' : 'letter' ?>">
                        <span class="idsk-stepper__circle-inner">
                            <span class="idsk-stepper__circle-background">
                                <span class="idsk-stepper__circle-step-label"><?= $item['subStep'] == '' ? $item['step'] : $item['subStep'] ?></span>
                            </span>
                        </span>
                    </span>
                    <h4 class="idsk-stepper__section-heading">
                        <span class="idsk-stepper__section-button" id="default-example-heading-1">
                            <?= $item['sectionHeading'] ?>
                        </span>
                    </h4>
                </div>
                <div id="default-example-content-1" class="idsk-stepper__section-content" aria-labelledby="default-example-heading-1">

                    <?php
                        $sectionContent = new DOMDocument();
                        if ($item['sectionContent'] != '') {
                            $sectionContent->loadHTML('<?xml encoding="utf-8" ?>' . $item['sectionContent']);
                        }

                        // data modification
                        $content = array();
                        foreach($sectionContent->getElementsByTagName('li') as $node)
                        {
                            foreach($node->getElementsByTagName('a') as $href)
                            {
                                $href->setAttribute('class', 'govuk-link');
                                $href->setAttribute('title', $href->textContent);
                            }
                            
                            $content[] = $sectionContent->saveHTML($node);
                        }

                        foreach ($content as $key => $val) {
                            echo '<ul class="govuk-list">';
                            echo $val;
                            echo '</ul>';
                        }
                    ?>
                    
                </div>
            </div>
        <?php } ?>

    </div>

    <?php
    /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer

    return $output; // Print output
}