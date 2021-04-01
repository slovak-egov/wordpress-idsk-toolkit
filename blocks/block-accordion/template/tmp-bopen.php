<?php
if (!defined('ABSPATH')) {
    exit;
}
$block_id  = $block['id'];
$block_name  = $block['title'];

if(is_admin() && !get_field('nazov_accordionu')){
    echo $block_name;
}
?>
<div class="govuk-accordion__section <?php echo (get_field('predvoleny_stav') ? 'govuk-accordion__section--expanded'  : ''); ?>">
    <div class="govuk-accordion__section-header">
        <h2 class="govuk-accordion__section-heading">
            <span class="govuk-accordion__section-button" id="<?php echo (get_field('id_accordionu') ? get_field('id_accordionu')  : $block_id.'-heading'); ?>">
              <?php echo (get_field('nazov_accordionu') ? get_field('nazov_accordionu')  : ''); ?>
            </span>
        </h2>
    </div>
    <div id="<?php echo (get_field('id_accordionu') ? get_field('id_accordionu')  : $block_id.'-content'); ?>" class="govuk-accordion__section-content" aria-labelledby="<?php echo (get_field('id_accordionu') ? get_field('id_accordionu')  : $block_id.'-heading'); ?>">