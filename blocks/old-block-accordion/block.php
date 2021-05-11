<?php
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }

    include_once 'acf-block.php';

    function idsktk_gov_register_block_accordion () {
        if ( !function_exists( 'acf_register_block' ) ) {
            return;
        }

        acf_register_block( [
            'name'            => 'section-accordion-open',
            'title'           => __( '1. Accordion - začiatok', 'idsk-toolkit' ),
            'description'     => __( 'Otvorenie accordionu hlavná časť, vždy sa ukladá na prvé miesto pri skladaní accordionu.', 'idsk-toolkit' ),
            'render_callback' => 'idsktk_render_callback_accordion',
            'category'        => 'gov-blocks-accordion',
            'icon'            => 'format-aside',
            'mode'            => 'preview',
            'align'           => 'full',
            'keywords'        => [ 'accordion' ],
            'example' => []
        ] );

        acf_register_block( [
            'name'            => 'section-accordion-close',
            'title'           => __( '4. Accordion - koniec', 'idsk-toolkit' ),
            'description'     => __( 'Otvorenie accordionu hlavná časť, vždy sa ukladá na posledné miesto pri skladaní accordionu.', 'idsk-toolkit' ),
            'render_callback' => 'idsktk_render_callback_accordion_close',
            'category'        => 'gov-blocks-accordion',
            'icon'            => 'format-aside',
            'mode'            => 'preview',
            'align'           => 'full',
            'keywords'        => [ 'accordion' ],
            'example' => []
        ] );

        acf_register_block( [
            'name'            => 'section-accordion-open-body',
            'title'           => __( '2. Accordion - otvorenie sekcie', 'idsk-toolkit' ),
            'description'     => __( 'Otvorenie sekcie a accordionu v hlavnej časti.', 'idsk-toolkit' ),
            'render_callback' => 'idsktk_render_callback_accordion_open_body',
            'category'        => 'gov-blocks-accordion',
            'icon'            => 'format-aside',
            'mode'            => 'preview',
            'align'           => 'full',
            'keywords'        => [ 'accordion' ],
            'example' => []
        ] );

        acf_register_block( [
            'name'            => 'section-accordion-close-body',
            'title'           => __( '3. Accordion - zatvorenie sekcie', 'idsk-toolkit' ),
            'description'     => __( 'Zatvorenie sekcie accordionu v hlavnej časti.', 'idsk-toolkit' ),
            'render_callback' => 'idsktk_render_callback_accordion_close_body',
            'category'        => 'gov-blocks-accordion',
            'icon'            => 'format-aside',
            'mode'            => 'preview',
            'align'           => 'full',
            'keywords'        => [ 'accordion' ],
            'example' => []
        ] );
    }

    add_action( 'acf/init', 'idsktk_gov_register_block_accordion' );

    function idsktk_render_callback_accordion ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-accordion/template/tmp', 'open' );
    }

    function idsktk_render_callback_accordion_close ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-accordion/template/tmp', 'close' );
    }

    function idsktk_render_callback_accordion_open_body ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-accordion/template/tmp', 'bopen' );
    }

    function idsktk_render_callback_accordion_close_body ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-accordion/template/tmp', 'bclose' );
    }

    function idsktk_block_init_assets_accordion () {
        wp_enqueue_style( 'block_init_accordion', get_theme_file_uri( '/blocks/block-accordion/template/style.css' ) );
    }

    add_action( 'enqueue_block_editor_assets', 'idsktk_block_init_assets_accordion' );