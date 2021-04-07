<?php
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }

    include_once 'acf-block.php';

    function idsktk_gov_register_block_button () {
        if ( !function_exists( 'acf_register_block' ) ) {
            return;
        }

        //button block
        acf_register_block( [
                                'name'            => 'section-button',
                                'title'           => __( 'Tlačidlo s odkazom', 'idsk-toolkit' ),
                                'description'     => __( 'Tlačidlo s odkazom', 'idsk-toolkit' ),
                                'render_callback' => 'idsktk_render_callback_button',
                                'category'        => 'gov-blocks',
                                'icon'            => 'admin-links',
                                'mode'            => 'preview',
                                'align'           => 'full',
                                'keywords'        => [ 'tlačidlo', 'link' ],
                            ] );

    }

    add_action( 'acf/init', 'idsktk_gov_register_block_button' );

    function idsktk_render_callback_button ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-button/template/tmp', 'block' );
    }

    function idsktk_block_init_assets_button () {
        wp_enqueue_style( 'block_init_button', get_theme_file_uri( '/blocks/block-button/template/style.css' ) );
    }

    add_action( 'enqueue_block_editor_assets', 'idsktk_block_init_assets_button' );