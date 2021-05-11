<?php
if (!defined('ABSPATH')) {
    exit;
}

$block_id = $block['id'];
$block_name = $block['title'];

if (1==1) {
    ?>

    <div class="govuk-grid-row">
        <div class="govuk-grid-column-one-half">
            <img src="#" alt="3:2">
        </div>
        <div class="govuk-grid-column-one-half">
            <img src="#" alt="">
        </div>
    </div>

<?php } else { ?>

    <h2>Začnite editovať obsah - <?php echo $block_name ?></h2>

<?php } ?>
