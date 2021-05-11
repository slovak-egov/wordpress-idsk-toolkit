<?php
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }

    include_once 'acf-block.php';

    function idsktk_gov_register_block_lists () {
        if ( !function_exists( 'acf_register_block' ) ) {
            return;
        }

        //lists block
        acf_register_block( [
                                'name'            => 'section-lists',
                                'title'           => __( 'Odrážky', 'idsk-toolkit' ),
                                'description'     => __( 'ID-SK Zoznam', 'idsk-toolkit' ),
                                'render_callback' => 'idsktk_render_callback_lists',
                                'category'        => 'gov-blocks',
                                'icon'            => 'editor-ul',
                                'mode'            => 'preview',
                                'align'           => 'full',
                                'keywords'        => [ 'lists' ],
                            ] );

    }

    add_action( 'acf/init', 'idsktk_gov_register_block_lists' );

    function idsktk_render_callback_lists ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-lists/template/tmp', 'block' );
    }

    function idsktk_block_init_assets_lists () {
        wp_enqueue_style( 'block_init_lists', get_theme_file_uri( '/blocks/block-lists/template/style.css' ) );
    }

    add_action( 'enqueue_block_editor_assets', 'idsktk_block_init_assets_lists' );