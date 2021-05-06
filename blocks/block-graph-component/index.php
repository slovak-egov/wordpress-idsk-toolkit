<?php
/**
 * BLOCK - graph-component - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_graph_component_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/graph-component', array(
        'render_callback' => 'idsktk_render_dynamic_graph_component_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_graph_component_block');

function idsktk_render_dynamic_graph_component_block($attributes) {
    // block attributes
    $blockId = $attributes['blockId'];
    $title = isset($attributes['title']) ? $attributes['title'] : '';
    $graphOptions = isset($attributes['graphOptions']) ? $attributes['graphOptions'] : array();
    $summary = isset($attributes['summary']) ? $attributes['summary'] : '';
    $iframeLabel1 = isset($attributes['iframeLabel1']) ? $attributes['iframeLabel1'] : '';
    $iframeLabel2 = isset($attributes['iframeLabel2']) ? $attributes['iframeLabel2'] : '';
    $iframeLabel3 = isset($attributes['iframeLabel3']) ? $attributes['iframeLabel3'] : '';
    $iframeLabel4 = isset($attributes['iframeLabel4']) ? $attributes['iframeLabel4'] : '';
    $iframeTitleGraph1 = isset($attributes['iframeTitleGraph1']) ? $attributes['iframeTitleGraph1'] : '';
    $iframeTitleGraph2 = isset($attributes['iframeTitleGraph2']) ? $attributes['iframeTitleGraph2'] : '';
    $iframeTitleGraph3 = isset($attributes['iframeTitleGraph3']) ? $attributes['iframeTitleGraph3'] : '';
    $iframeTitleGraph4 = isset($attributes['iframeTitleGraph4']) ? $attributes['iframeTitleGraph4'] : '';
    $iframeGraph1 = isset($attributes['iframeGraph1']) ? $attributes['iframeGraph1'] : '';
    $iframeGraph2 = isset($attributes['iframeGraph2']) ? $attributes['iframeGraph2'] : '';
    $iframeGraph3 = isset($attributes['iframeGraph3']) ? $attributes['iframeGraph3'] : '';
    $bodyGraph4 = isset($attributes['bodyGraph4']) ? $attributes['bodyGraph4'] : '';
    $downloadLinks = isset($attributes['downloadLinks']) ? $attributes['downloadLinks'] : array();
    $shareOption = isset($attributes['shareOption']) ? FALSE : TRUE;
    $source = isset($attributes['source']) ? $attributes['source'] : '';
  
    ob_start(); // Turn on output buffering
    ?>

    <div data-module="idsk-graph" class="idsk-graph" id="<?php echo $blockId; ?>">
        <div class="govuk-grid-row idsk-graph__heading">
            <div class="idsk-graph__title">
                <h2 class="govuk-heading-m"><?php echo $title; ?></h2>
            </div>
            <div class="idsk-graph__controls">
                <div class="govuk-form-group">
                    <div class="govuk-radios govuk-radios--inline">
                        
                        <?php if (count($graphOptions) > 0) { ?>
                            <?php foreach ($graphOptions as $key => $item) { ?>
                                <div class="govuk-radios__item">
                                    <input class="govuk-radios__input idsk-graph__radio" name="<?php echo 'radio-'.$blockId; ?>" id="<?php echo 'radio-'.$blockId.'-'.($key+1) ?>" type="radio" value="<?php echo $item['value'] ?>" <?php if ($key == 0) { echo 'checked'; } ?>>
                                    <label class="govuk-label govuk-radios__label" for="<?php echo 'radio-'.$blockId.'-'.($key+1) ?>"><?php echo $item['name'] ?></label>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    
                    </div>
                </div>
            </div>
        </div>
        
        <div class="govuk-grid-row">
            <div class="govuk-grid-column-one-half">
                <summary class="govuk-body-s idsk-graph__summary">
                    <?php echo $summary ?>
                </summary>
            </div>
        </div>

        
        <div class="govuk-tabs" data-activetab="" data-module="govuk-tabs">
            <h2 class="govuk-tabs__title">
                <?php echo __('Obsah', 'idsk-toolkit') ?>
            </h2>
            <ul class="govuk-tabs__list">
                <li class="govuk-tabs__list-item govuk-tabs__list-item--selected">
                    <a class="govuk-tabs__tab" href="<?php echo "#".$blockId."-1"; ?>">
                        <?php echo $iframeLabel1 ?>
                    </a>
                </li>
                <li class="govuk-tabs__list-item">
                    <a class="govuk-tabs__tab" href="<?php echo "#".$blockId."-2"; ?>">
                        <?php echo $iframeLabel2 ?>
                    </a>
                </li>
                <li class="govuk-tabs__list-item">
                    <a class="govuk-tabs__tab" href="<?php echo "#".$blockId."-3"; ?>">
                        <?php echo $iframeLabel3 ?>
                    </a>
                </li>
                <li class="govuk-tabs__list-item">
                    <a class="govuk-tabs__tab" href="<?php echo "#".$blockId."-4"; ?>">
                        <?php echo $iframeLabel4 ?>
                    </a>
                </li>
            </ul>
            <section class="govuk-tabs__panel" id="<?php echo $blockId."-1"; ?>">
                <iframe class='idsk-graph__iframe' data-src='<?php echo $iframeGraph1 ?>' src='<?php echo $iframeGraph1 ?>' title='<?php echo $iframeTitleGraph1 ?>'></iframe>
            </section>
            <section class="govuk-tabs__panel govuk-tabs__panel--hidden" id="<?php echo $blockId."-2"; ?>">
                <iframe class='idsk-graph__iframe' data-src='<?php echo $iframeGraph2 ?>' src='<?php echo $iframeGraph2 ?>' title='<?php echo $iframeTitleGraph2 ?>'></iframe>
            </section>
            <section class="govuk-tabs__panel govuk-tabs__panel--hidden" id="<?php echo $blockId."-3"; ?>">
                <iframe class='idsk-graph__iframe' data-src='<?php echo $iframeGraph3 ?>' src='<?php echo $iframeGraph3 ?>' title='<?php echo $iframeTitleGraph3 ?>'></iframe>
            </section>
            <section class="govuk-tabs__panel govuk-tabs__panel--hidden" id="<?php echo $blockId."-4"; ?>">
                <?php
                    $body_final = str_replace('<p', '<p class="govuk-body"', $bodyGraph4);
                    echo $body_final;
                ?>
            </section>
        </div>

        <div class="idsk-graph__meta">
            <div class="idsk-graph__meta-download-share">
                <?php if (count($downloadLinks) > 0) { ?>
                    <div class="idsk-graph__meta-download">
                        <a class="govuk-link idsk-graph__meta-link-list" title="<?php echo __('Stiahnuť údaje', 'idsk-toolkit') ?>" href="#">
                            <?php echo __('Stiahnuť údaje', 'idsk-toolkit') ?>
                            <svg width="18" height="11" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.0725 1.07107L9.00146 8.14214L1.9304 1.07107" stroke="#0B0C0C" stroke-width="3"/>
                            </svg>
                        </a>
                        <ul class="idsk-graph__meta-list">
                            <?php foreach ($downloadLinks as $key => $item) { ?>
                                <li>
                                    <a title="<?php echo $item['name'] ?>" href="<?php echo $item['url'] ?>" class="govuk-link" download><?php echo $item['name'] ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <?php if ($shareOption == true) { ?>
                    <div class="idsk-graph__meta-share">
                        <a class="govuk-link idsk-graph__meta-link-list" title="<?php echo __('Zdielať údaje', 'idsk-toolkit') ?>" href="#">
                            <?php echo __('Zdielať údaje', 'idsk-toolkit') ?>
                            <svg width="18" height="11" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.0725 1.07107L9.00146 8.14214L1.9304 1.07107" stroke="#0B0C0C" stroke-width="3"/>
                            </svg>
                        </a>
                        <ul class="idsk-graph__meta-list">
                            <li>
                                <a title="<?php echo __('Kopírovať link', 'idsk-toolkit') ?>" href="<?php echo $iframeGraph1 ?>" class="govuk-link idsk-graph__copy-to-clickboard" ><?php echo __('Kopírovať link', 'idsk-toolkit') ?></a>
                            </li>
                            <li>
                                <a title="<?php echo __('Emailom', 'idsk-toolkit') ?>" href="<?php echo "#".$blockId; ?>" class="govuk-link idsk-graph__send-link-by-email" ><?php echo __('Emailom', 'idsk-toolkit') ?></a>
                            </li>
                            <li>
                                <a title="<?php echo __('na Facebooku', 'idsk-toolkit') ?>" href="<?php echo "#".$blockId; ?>" class="govuk-link idsk-graph__share-on-facebook" target="_blank"><?php echo __('na Facebooku', 'idsk-toolkit') ?></a>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
            <div class="idsk-graph__meta-source">
                <?php echo $source; ?>
            </div>
        </div>
    </div>
  
    <?php
      /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer
  
    return $output; // Print output
}