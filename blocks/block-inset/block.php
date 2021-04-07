<?php
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }

    include_once 'acf-block.php';

    function idsktk_gov_register_block_inset () {
        if ( !function_exists( 'acf_register_block' ) ) {
            return;
        }

        //inset block
        acf_register_block( [
            'name'            => 'section-inset',
            'title'           => __( 'Poznámka', 'idsk-toolkit' ),
            'description'     => __( 'Blok so vsadeným textom', 'idsk-toolkit' ),
            'render_callback' => 'idsktk_render_callback_inset',
            'category'        => 'gov-blocks',
            'icon'            => 'format-aside',
            'mode'            => 'preview',
            'align'           => 'full',
            'keywords'        => [ 'inset' ],
            'example' => []
        ] );

    }

    add_action( 'acf/init', 'idsktk_gov_register_block_inset' );

    function idsktk_render_callback_inset ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-inset/template/tmp', 'block' );
    }

    function idsktk_block_init_assets_inset () {
        wp_enqueue_style( 'block_init_inset', get_theme_file_uri( '/blocks/block-inset/template/style.css' ) );
    }

    add_action( 'enqueue_block_editor_assets', 'idsktk_block_init_assets_inset' );