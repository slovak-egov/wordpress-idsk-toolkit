<?php
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }

    include_once 'acf-block.php';

    function idsktk_gov_register_block_images () {
        if ( !function_exists( 'acf_register_block' ) ) {
            return;
        }

        //images block
        acf_register_block( [
            'name'            => 'section-images',
            'title'           => __( 'Obrázky', 'idsk-toolkit' ),
            'description'     => __( 'Blok zobrazujúci obrázky', 'idsk-toolkit' ),
            'render_callback' => 'idsktk_render_callback_images',
            'category'        => 'gov-blocks',
            'icon'            => 'format-aside',
            'mode'            => 'preview',
            'align'           => 'full',
            'keywords'        => [ 'images' ],
            'example' => []
        ] );

    }

    add_action( 'acf/init', 'idsktk_gov_register_block_images' );

    function idsktk_render_callback_images ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-images/template/tmp', 'block' );
    }

    function idsktk_block_init_assets_images () {
        wp_enqueue_style( 'block_init_images', get_theme_file_uri( '/blocks/block-images/template/style.css' ) );
    }

    add_action( 'enqueue_block_editor_assets', 'idsktk_block_init_assets_images' );