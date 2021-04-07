<?php
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }

    include_once 'acf-block.php';

    function idsktk_gov_register_block_heading () {
        if ( !function_exists( 'acf_register_block' ) ) {
            return;
        }

        acf_register_block( [
            'name'            => 'section-heading',
            'title'           => __( 'Nadpis', 'idsk-toolkit' ),
            'description'     => __( 'Blok určijúci úroveň nadpisu a jeho veľkosť', 'idsk-toolkit' ),
            'render_callback' => 'idsktk_render_callback_heading',
            'category'        => 'gov-blocks',
            'icon'            => 'editor-textcolor',
            'mode'            => 'preview',
            'align'           => 'full',
            'keywords'        => [ 'heading' ],
            'example' => []
        ] );

    }

    add_action( 'acf/init', 'idsktk_gov_register_block_heading' );

    function idsktk_render_callback_heading ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-heading/template/tmp', 'block' );
    }

    function idsktk_block_init_assets_heading () {
        wp_enqueue_style( 'block_init_heading', get_theme_file_uri( '/blocks/block-heading/template/style.css' ) );
    }

    add_action( 'enqueue_block_editor_assets', 'idsktk_block_init_assets_heading' );