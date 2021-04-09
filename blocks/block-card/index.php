<?php
/**
 * BLOCK - card - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_card_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/card', array(
        'render_callback' => 'idsktk_render_dynamic_card_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_card_block');
    
function idsktk_render_dynamic_card_block($attributes) {
    // block attributes
    $cardType = $attributes['cardType'] == '' ? 'basic' : $attributes['cardType'];

    $img = $attributes['img'];
    $imgAlt = $attributes['imgAlt'];
    $imgLink = $attributes['imgLink'];

    $title = $attributes['title'];
    $subTitle = $attributes['subTitle'];
    $date = date_i18n( __( 'd.m.Y', $attributes['date'] ));
    $dateLink = $attributes['dateLink'];

    $tag1 = $attributes['tag1'];
    $tagText1 = $attributes['tagText1'];
    $tag2 = $attributes['tag2'];
    $tagText2 = $attributes['tagText2'];

    $profileQuote = $attributes['profileQuote'];

    // data modification
    $title_replaced_a = str_replace('<a', '<a class="idsk-card-title govuk-link" title="'.wp_kses($title, []).'"', $title);
    $subTitle_replaced_a = str_replace('<a', '<a class="idsk-card-title govuk-link" title="'.wp_kses($subTitle, []).'"', $subTitle);

    ob_start(); // Turn on output buffering
    ?>
    
    <div class="idsk-card idsk-card-<?= $cardType ?>">

        <?php if ($cardType != 'basic-variant') { ?>
        <a href="<?= $imgLink ?>">
            <img class="idsk-card-img idsk-card-img-<?= $cardType ?>" width="100%" src="<?= $img ?>" alt="<?= $imgAlt ?>" aria-hidden="true" />
        </a>
        <?php } ?>

        <div class="idsk-card-content idsk-card-content-<?= $cardType ?>">
            <?php if ($cardType != 'profile-vertical' && $cardType != 'profile-horizontal' && $cardType != 'basic-variant') { ?>
                <div class="idsk-card-meta-container">
                    <span class="idsk-card-meta idsk-card-meta-date"><a href="<?= $dateLink ?>" class="govuk-link" title="<?= $date ?>"><?= $date ?></a></span> 
                    <?php if ($tagText1 != '') { ?>
                    <span class="idsk-card-meta idsk-card-meta-tag"><a href="<?= $tag1 ?>" class="govuk-link" title="<?= $tagText1 ?>"><?= $tagText1 ?></a></span>
                    <?php } ?>
                    <?php if ($tagText2 != '') { ?>
                    <span class="idsk-card-meta idsk-card-meta-tag"><a href="<?= $tag2 ?>" class="govuk-link" title="<?= $tagText2 ?>"><?= $tagText2 ?></a></span>
                    <?php } ?>
                </div>
            <?php } ?>


            <div class="idsk-heading idsk-heading-<?= $cardType ?>">
                <?= $title_replaced_a ?>
            </div>

            <?php if ($subTitle != '' && $cardType != 'simple' && $cardType != 'profile-vertical' && $cardType != 'profile-horizontal') { ?>
                <p class="idsk-body idsk-body-<?= $cardType ?>">
                    <?= $subTitle ?>
                </p>
            <?php } ?>

            <?php if ($cardType == 'profile-vertical' || $cardType == 'profile-horizontal') { ?>
                <div class="idsk-body idsk-body-<?= $cardType ?>">
                    <?= $subTitle_replaced_a ?>
                </div>
                
                <?php if ($cardType == 'profile-horizontal') { ?>
                    <div aria-hidden="true">
                        <svg width="24" height="19" viewBox="0 0 29 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M26.3553 0.0139084C23.5864 0.226497 19.9201 2.88 17.0759 7.02567C15.053 9.97412 12.8391 14.6653 12.8391 18.4203C12.8391 21.3658 15.151 23.7536 18.0028 23.7536C20.8546 23.7536 23.1665 21.3658 23.1665 18.4203C23.1665 15.9126 21.4908 13.8092 19.233 13.2392C19.7995 11.258 20.8141 9.10337 22.2396 7.02567C24.1378 4.25885 26.4022 2.15668 28.5216 1.00119L26.3553 0.0139084Z" fill="#003078"/>
                            <path d="M4.23679 7.02557C7.22761 2.66622 11.1274 -0.0431738 13.937 0.000520662L15.8902 0.890673C13.7117 2.01967 11.3608 4.16818 9.40047 7.02557C7.97502 9.10327 6.96037 11.2579 6.39387 13.2391C8.65175 13.8091 10.3274 15.9125 10.3274 18.4202C10.3274 21.3657 8.0155 23.7535 5.16368 23.7535C2.31186 23.7535 0 21.3657 0 18.4202C0 14.6652 2.21394 9.97402 4.23679 7.02557Z" fill="#003078"/>
                            
                            <image src="/assets/images/quote-left.png" xlink:href="" width="29" height="25"></image>
                        </svg>
                    </div>
                    <div class="idsk-quote"><?= $profileQuote ?></div>
                    <div class="idsk-quote-right" aria-hidden="true">
                        <svg width="24" height="20" viewBox="0 0 29 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.1662 24.4934C4.93513 24.2808 8.60138 21.6273 11.4456 17.4817C13.4684 14.5332 15.6824 9.84205 15.6824 6.08707C15.6824 3.14154 13.3705 0.753727 10.5187 0.753727C7.66689 0.753727 5.35503 3.14154 5.35503 6.08707C5.35503 8.59472 7.03065 10.6982 9.28852 11.2681C8.72202 13.2493 7.70737 15.404 6.28192 17.4817C4.38369 20.2485 2.1193 22.3506 -0.000114441 23.5061L2.1662 24.4934Z" fill="#003078"/>
                            <path d="M24.2847 17.4818C21.2939 21.8411 17.3941 24.5505 14.5845 24.5068L12.6313 23.6167C14.8098 22.4877 17.1606 20.3391 19.121 17.4818C20.5465 15.4041 21.5611 13.2494 22.1276 11.2682C19.8697 10.6983 18.1941 8.59482 18.1941 6.08716C18.1941 3.14164 20.506 0.753824 23.3578 0.753824C26.2096 0.753824 28.5215 3.14164 28.5215 6.08716C28.5215 9.84214 26.3075 14.5333 24.2847 17.4818Z" fill="#003078"/>
                            
                            <image src="/assets/images/quote-right.png" xlink:href="" width="29" height="25"></image>
                        </svg>
                    </div>
                <?php } ?>

            <?php } ?>

            <?php if ($cardType == 'basic-variant') { ?>
                <div class="idsk-card-meta-container">
                    <span class="idsk-card-meta idsk-card-meta-date"><a href="<?= $dateLink ?>" class="govuk-link" title="<?= $date ?>"><?= $date ?></a></span> 
                    <span class="idsk-card-meta idsk-card-meta-tag"><a href="<?= $tag1 ?>" class="govuk-link" title="<?= $tagText1 ?>"><?= $tagText1 ?></a></span>
                    <span class="idsk-card-meta idsk-card-meta-tag"><a href="<?= $tag2 ?>" class="govuk-link" title="<?= $tagText2 ?>"><?= $tagText2 ?></a></span>
                </div>
            <?php } ?>

        </div>
    </div>

    <?php
    /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer

    return $output; // Print output
}