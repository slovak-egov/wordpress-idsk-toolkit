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

function register_dynamic_stepper_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/timeline', array(
        'render_callback' => 'render_dynamic_stepper_block'
    ));
}
add_action('init', 'register_dynamic_stepper_block');
    
function render_dynamic_stepper_block($attributes) {
    // block attributes
    $title = $attributes['title'];
    $caption = $attributes['caption'];
    $stepperSubtitle = $attributes['stepperSubtitle'];
    $items = $attributes['items'];
    
    // $number_of_items = count($items);

    ob_start(); // Turn on output buffering
    ?>

    <div class="idsk-timeline " data-module="idsk-timeline" role="contentinfo">
        <div class="govuk-container-width">
            <div class="idsk-timeline__button__div">
                <button type="button" class="idsk-timeline__button--back">
                    <svg class="idsk-timeline__button__svg--previous" width="20" height="15" viewbox="0 -2 25 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.2925 13.8005C7.6825 13.4105 7.6825 12.7805 7.2925 12.3905L3.4225 8.50047H18.5925C19.1425 8.50047 19.5925 8.05047 19.5925 7.50047C19.5925 6.95047 19.1425 6.50047 18.5925 6.50047H3.4225L7.3025 2.62047C7.6925 2.23047 7.6925 1.60047 7.3025 1.21047C6.9125 0.820469 6.2825 0.820469 5.8925 1.21047L0.2925 6.80047C-0.0975 7.19047 -0.0975 7.82047 0.2925 8.21047L5.8825 13.8005C6.2725 14.1805 6.9125 14.1805 7.2925 13.8005Z" fill="#0065B3"/>
                    </svg>Zobraziť minulé udalosti
                </button>
            </div>
                <div class="idsk-timeline__content idsk-timeline__content__caption--long">
                    <div class="idsk-timeline__left-side">
                        <span class="govuk-body-m">14.03.2021</span>
                        <br>
                            <span class="idsk-timeline__content__time">8:30 - 12:00</span>
                        </div>
                        <div class="idsk-timeline__middle">
                            <span class="idsk-timeline__vertical-line--circle"></span>
                        </div>
                        <div class="idsk-timeline__content__caption">
                            <a class="govuk-link"  href="#"  title="Lorem ipsum dolor sit amet, consectetur adipiscingLorem ipsum dolor sit amet, consectetur adid">Lorem ipsum dolor sit amet, consectetur adipiscingLorem ipsum dolor sit amet, consectetur adid</a>
                        </div>
                    </div>
                <div class="idsk-timeline__content ">
                    <div class="idsk-timeline__left-side">
                        <span class="govuk-body-m">15.03.2021</span>
                        <br>
                            <span class="idsk-timeline__content__time">9:30 - 12:00</span>
                        </div>
                        <div class="idsk-timeline__middle">
                            <span class="idsk-timeline__vertical-line--circle"></span>
                        </div>
                        <div class="idsk-timeline__content__caption">
                            <a class="govuk-link"  href="#"  title="Lorem ipsum dolor sit amet, consectetur adipiscing">Lorem ipsum dolor sit amet, consectetur adipiscing</a>
                        </div>
                    </div>
                    <div class="idsk-timeline__content govuk-body">
                        <div class="idsk-timeline__left-side"></div>
                        <div class="idsk-timeline__middle">
                            <span class="idsk-timeline__vertical-line"></span>
                        </div>
                        <div class="idsk-timeline__content__date-line">
                            <span class="idsk-timeline__content__text">marec 2021
                            </span>
                        </div>
                    </div>
                <div class="idsk-timeline__content idsk-timeline__content__caption--long">
                    <div class="idsk-timeline__left-side">
                        <span class="govuk-body-m">16.03.2021</span>
                        <br>
                            <span class="idsk-timeline__content__time">10:30 - 12:00</span>
                        </div>
                        <div class="idsk-timeline__middle">
                            <span class="idsk-timeline__vertical-line--circle"></span>
                        </div>
                        <div class="idsk-timeline__content__caption">
                            <a class="govuk-link"  href="#"  title="Lorem ipsum dolor sit amet, consectetur adipiscingLorem ipsum dolor sit amet, consectetur adid">Lorem ipsum dolor sit amet, consectetur adipiscingLorem ipsum dolor sit amet, consectetur adid</a>
                        </div>
                    </div>
                <div class="idsk-timeline__content idsk-timeline__content__caption--long">
                    <div class="idsk-timeline__left-side">
                        <span class="govuk-body-m">17.03.2021</span>
                        <br>
                            <span class="idsk-timeline__content__time">8:30 - 12:00</span>
                        </div>
                        <div class="idsk-timeline__middle">
                            <span class="idsk-timeline__vertical-line--circle"></span>
                        </div>
                        <div class="idsk-timeline__content__caption">
                            <a class="govuk-link"  href="#"  title="Lorem ipsum dolor sit amet, consectetur adipiscingelit, sed do eiusmod tempor incididunt labor et labore. Lorem ipsum dolor sit amet, consectetur adipiscing">Lorem ipsum dolor sit amet, consectetur adipiscingelit, sed do eiusmod tempor incididunt labor et labore. Lorem ipsum dolor sit amet, consectetur adipiscing</a>
                        </div>
                    </div>
                    <div class="idsk-timeline__content govuk-body">
                        <div class="idsk-timeline__left-side"></div>
                        <div class="idsk-timeline__middle">
                            <span class="idsk-timeline__vertical-line"></span>
                        </div>
                        <div class="idsk-timeline__content__date-line">
                            <span class="idsk-timeline__content__text">máj 2021
                            </span>
                        </div>
                    </div>
                    <div class="idsk-timeline__content idsk-timeline__content__title-div">
                        <div class="idsk-timeline__left-side"></div>
                        <div class="idsk-timeline__middle">
                            <span class="idsk-timeline__vertical-line"></span>
                        </div>
                        <div class="idsk-timeline__content__title">
                            <h3 class="govuk-heading-m">Vybavenie rodného listu dieťaťa
                            </h3>
                        </div>
                    </div>
                <div class="idsk-timeline__content idsk-timeline__content__caption--long">
                    <div class="idsk-timeline__left-side">
                        <span class="govuk-body-m">18.03.2021</span>
                        <br>
                            <span class="idsk-timeline__content__time">8:30 - 12:00</span>
                        </div>
                        <div class="idsk-timeline__middle">
                            <span class="idsk-timeline__vertical-line--circle"></span>
                        </div>
                        <div class="idsk-timeline__content__caption">
                            <a class="govuk-link"  href="#"  title="Lorem ipsum dolor sit amet, consectetur adipiscingelit, sed do eiusmod tempor incididunt ut labore et labore. Lorem ipsum dolor sit">Lorem ipsum dolor sit amet, consectetur adipiscingelit, sed do eiusmod tempor incididunt ut labore et labore. Lorem ipsum dolor sit</a>
                        </div>
                    </div>
                <div class="idsk-timeline__content ">
                    <div class="idsk-timeline__left-side">
                        <span class="govuk-body-m">19.03.2021</span>
                        <br>
                            <span class="idsk-timeline__content__time">8:30 - 12:00</span>
                        </div>
                        <div class="idsk-timeline__middle">
                            <span class="idsk-timeline__vertical-line--circle"></span>
                        </div>
                        <div class="idsk-timeline__content__caption">
                            <a class="govuk-link"  href="#"  title="Lorem ipsum dolor sit amet, consectetur adipiscing">Lorem ipsum dolor sit amet, consectetur adipiscing</a>
                        </div>
                    </div>
                <button type="button" class="idsk-timeline__button--forward">
                    Zobraziť budúce udalosti<svg class="idsk-timeline__button__svg--next" width="20" height="13" viewbox="-5 0 25 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5558 0.281376C12.1577 0.666414 12.1577 1.2884 12.5558 1.67344L16.5063 5.51395L1.0208 5.51395C0.45936 5.51395 1.90735e-06 5.95823 1.90735e-06 6.50123C1.90735e-06 7.04424 0.45936 7.48851 1.0208 7.48851L16.5063 7.48851L12.5456 11.3192C12.1475 11.7042 12.1475 12.3262 12.5456 12.7112C12.9437 13.0963 13.5868 13.0963 13.9849 12.7112L19.7014 7.19233C20.0995 6.80729 20.0995 6.1853 19.7014 5.80027L13.9952 0.281376C13.597 -0.0937901 12.9437 -0.0937901 12.5558 0.281376Z" fill="#0065B3"/>
                    </svg>
                </button>
            </div>
        </div>

<?php /*

    <h2 class="govuk-heading-l"><?= $title ?></h2>
    <p class="idsk-stepper__caption govuk-caption-m"><?= $caption ?></p>
    <div class="idsk-stepper myClass" data-module="idsk-stepper" id="default-example" data-attribute="value" >

        <div class="idsk-stepper__subtitle-container">
            <div class="idsk-stepper__subtitle--heading govuk-grid-column-three-quarters">
                <h3 class="govuk-heading-m idsk-stepper__section-subtitle"><?= $stepperSubtitle ?></h3>
            </div>
            <div class="idsk-stepper__controls govuk-grid-column-one-quarter">
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
                            $sectionContent->loadHTML($item['sectionContent']);
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

    */ ?>

    <?php
    /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer

    return $output; // Print output
}