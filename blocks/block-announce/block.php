<?php
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }

    include_once 'acf-block.php';

    function idsktk_gov_register_block_announce () {
        if ( !function_exists( 'acf_register_block' ) ) {
            return;
        }

        //announce block
        acf_register_block( [
            'name'            => 'section-announce',
            'title'           => __( 'Upozornenie', 'idsk-toolkit' ),
            'description'     => __( 'Blok pre dôležitý oznam', 'idsk-toolkit' ),
            'render_callback' => 'idsktk_render_callback_announce',
            'category'        => 'gov-blocks',
            'icon'            => 'format-aside',
            'mode'            => 'preview',
            'align'           => 'full',
            'keywords'        => [ 'announce' ],
            'example' => []
        ] );

    }

    add_action( 'acf/init', 'idsktk_gov_register_block_announce' );

    function idsktk_render_callback_announce ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-announce/template/tmp', 'block' );
    }

    function idsktk_block_init_assets_announce () {
        wp_enqueue_style( 'block_init_announce', get_theme_file_uri( '/blocks/block-announce/template/style.css' ) );
    }

    add_action( 'enqueue_block_editor_assets', 'idsktk_block_init_assets_announce' );