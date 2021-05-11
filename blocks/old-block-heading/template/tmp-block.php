<?php
if (!defined('ABSPATH')) {
    exit;
}

$block_id = $block['id'];
$block_name = $block['title'];
$id_nadpisu='';

if ($nadpis = get_field('nadpis')) {

    $id_nadpisu = get_field( 'id_nadpisu' );

    ?>

    <<?php echo get_field('uroven_nadpisu')?><?php echo ( !empty( $id_nadpisu ) ? ' id="' . sanitize_title( $id_nadpisu ) . '"' : '' ); ?> class="<?php echo get_field('velkost_nadpisu')?>"><?php echo wp_kses( $nadpis, [ 'br' => [] ] ) ?></<?php echo get_field('uroven_nadpisu')?>>

<?php } else { ?>

    <h2>Začnite editovať obsah - <?php echo $block_name ?></h2>

<?php } ?>
