<?php
/**
 * BLOCK - map-component - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_map_component_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/map-component', array(
        'render_callback' => 'idsktk_render_dynamic_map_component_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_map_component_block');

function idsktk_render_dynamic_map_component_block($attributes) {

    // block attributes
    $blockId = $attributes['blockId'];
    $title = isset($attributes['title']) ? $attributes['title'] : '';
    $indicatorOptions = isset($attributes['indicatorOptions']) ? $attributes['indicatorOptions'] : array();
    $iframeMapTitle = isset($attributes['iframeMapTitle']) ? $attributes['iframeMapTitle'] : '';
    $iframeTableTitle = isset($attributes['iframeTableTitle']) ? $attributes['iframeTableTitle'] : '';
    $iframeMap = isset($attributes['iframeMap']) ? $attributes['iframeMap'] : '';
    $iframeTable = isset($attributes['iframeTable']) ? $attributes['iframeTable'] : '';
    $csvDownload = isset($attributes['csvDownload']) ? $attributes['csvDownload'] : '';
    $downloadText = isset($attributes['downloadText']) ? $attributes['downloadText'] : '';
    $source = isset($attributes['source']) ? $attributes['source'] : '';
  
    ob_start(); // Turn on output buffering
    ?>

    <div data-module="idsk-interactive-map" class="idsk-interactive-map">
        <h2 class="govuk-heading-l"><?php echo $title ?></h2>
        <div class="idsk-interactive-map__header">
            <div class="idsk-interactive-map__header-controls">
                <div class="idsk-interactive-map__header-radios">
                    <div class="govuk-form-group">
                        <div class="govuk-radios govuk-radios--inline">
                            <div class="govuk-radios__item idsk-intereactive-map__radio-map">
                                <input class="govuk-radios__input" name="interactive-radios-b" id="<?php echo $blockId; ?>-interactive-radios-b-1" type="radio" value="map" checked >
                                <label class="govuk-label govuk-radios__label" for="<?php echo $blockId; ?>-interactive-radios-b-1"><?php echo __( 'Mapa', 'idsk-toolkit' ) ?></label>
                            </div>
                            <div class="govuk-radios__item idsk-intereactive-map__radio-table">
                                <input class="govuk-radios__input" name="interactive-radios-b" id="<?php echo $blockId; ?>-interactive-radios-b-2" type="radio" value="table" >
                                <label class="govuk-label govuk-radios__label" for="<?php echo $blockId; ?>-interactive-radios-b-2"><?php echo __( 'Tabuľka', 'idsk-toolkit' ) ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="idsk-interactive-map__header-selects">
                    <div class="govuk-form-group">
                        <div class="govuk-label-wrapper">
                            <label class="govuk-label" for="time-period"><strong><?php echo __( 'Obdobie', 'idsk-toolkit' ) ?></strong></label>
                        </div>
                        <select class="idsk-interactive-map__select-time-period govuk-select" id="time-period" name="time-period">
                            <option value="30"><?php echo __( 'Posledný mesiac', 'idsk-toolkit' ) ?></option>
                            <option value="90"><?php echo __( 'Posledné 3 mesiace', 'idsk-toolkit' ) ?></option>
                            <option value="180"><?php echo __( 'Posledných 6 mesiacov', 'idsk-toolkit' ) ?></option>
                            <option value="" selected="selected"><?php echo __( 'Celé obdobie', 'idsk-toolkit' ) ?></option>
                        </select>
                    </div>
                    
                    <?php if (count($indicatorOptions) > 0) { ?>
                        <div class="govuk-form-group">
                            <div class="govuk-label-wrapper">
                                <label class="govuk-label" for="indicator"><strong><?php echo __( 'Ukazovateľ', 'idsk-toolkit' ) ?></strong></label>
                            </div>
                            <select class="idsk-interactive-map__select-indicator govuk-select" id="indicator" name="indicator">
                                <?php foreach ($indicatorOptions as $key => $item) { ?>
                                    <option value="<?php echo $item['value'] ?>"><?php echo $item['text'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php if (count($indicatorOptions) > 0) { ?>
                <h3 class="govuk-heading-m">
                    <span class="idsk-interactive-map__current-indicator"><?php echo $indicatorOptions[0]['text'] ?></span> <?php echo __( 'za', 'idsk-toolkit' ) ?> <span class="idsk-interactive-map__current-time-period"><?php echo __( 'celé obdobie', 'idsk-toolkit' ) ?></span>
                </h3>
            <?php } ?>
        </div>
        <div class="idsk-interactive-map__body">
            <div class="idsk-interactive-map__map">
                <iframe class="idsk-interactive-map__map-iframe" data-src="<?php echo $iframeMap ?>" src="<?php echo $iframeMap ?>" title="<?php echo $iframeMapTitle ?>"></iframe>
            </div>
            <div class="idsk-interactive-map__table">
                <iframe class="idsk-interactive-map__table-iframe" data-src="<?php echo $iframeTable ?>" title="<?php echo $iframeTableTitle ?>"></iframe>
            </div>
        </div>
        <div class="idsk-interactive-map__meta">
            <a class="govuk-link idsk-interactive-map__meta-data" title="<?php echo $downloadText ?>" href="<?php echo $csvDownload ?>" download><?php echo $downloadText ?></a>
            <span class="idsk-interactive-map__meta-source"><?php echo $source ?></span>
        </div>
    </div>
    <div class="govuk-clearfix"></div>
  
    <?php
      /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer
  
    return $output; // Print output
}