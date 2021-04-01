<?php
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }

    include_once 'acf-block.php';

    function gov_register_block_accordion () {
        if ( !function_exists( 'acf_register_block' ) ) {
            return;
        }

        acf_register_block( [
            'name'            => 'section-accordion-open',
            'title'           => __( '1. Accordion - začiatok', 'idsk' ),
            'description'     => __( 'Otvorenie accordionu hlavná časť, vždy sa ukladá na prvé miesto pri skladaní accordionu.', 'idsk' ),
            'render_callback' => 'render_callback_accordion',
            'category'        => 'gov-blocks-accordion',
            'icon'            => 'format-aside',
            'mode'            => 'preview',
            'align'           => 'full',
            'keywords'        => [ 'accordion' ],
            'example' => []
        ] );

        acf_register_block( [
            'name'            => 'section-accordion-close',
            'title'           => __( '4. Accordion - koniec', 'idsk' ),
            'description'     => __( 'Otvorenie accordionu hlavná časť, vždy sa ukladá na posledné miesto pri skladaní accordionu.', 'idsk' ),
            'render_callback' => 'render_callback_accordion_close',
            'category'        => 'gov-blocks-accordion',
            'icon'            => 'format-aside',
            'mode'            => 'preview',
            'align'           => 'full',
            'keywords'        => [ 'accordion' ],
            'example' => []
        ] );

        acf_register_block( [
            'name'            => 'section-accordion-open-body',
            'title'           => __( '2. Accordion - otvorenie sekcie', 'idsk' ),
            'description'     => __( 'Otvorenie sekcie a accordionu v hlavnej časti.', 'idsk' ),
            'render_callback' => 'render_callback_accordion_open_body',
            'category'        => 'gov-blocks-accordion',
            'icon'            => 'format-aside',
            'mode'            => 'preview',
            'align'           => 'full',
            'keywords'        => [ 'accordion' ],
            'example' => []
        ] );

        acf_register_block( [
            'name'            => 'section-accordion-close-body',
            'title'           => __( '3. Accordion - zatvorenie sekcie', 'idsk' ),
            'description'     => __( 'Zatvorenie sekcie accordionu v hlavnej časti.', 'idsk' ),
            'render_callback' => 'render_callback_accordion_close_body',
            'category'        => 'gov-blocks-accordion',
            'icon'            => 'format-aside',
            'mode'            => 'preview',
            'align'           => 'full',
            'keywords'        => [ 'accordion' ],
            'example' => []
        ] );
    }

    add_action( 'acf/init', 'gov_register_block_accordion' );

    function render_callback_accordion ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-accordion/template/tmp', 'open' );
    }

    function render_callback_accordion_close ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-accordion/template/tmp', 'close' );
    }

    function render_callback_accordion_open_body ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-accordion/template/tmp', 'bopen' );
    }

    function render_callback_accordion_close_body ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-accordion/template/tmp', 'bclose' );
    }

    function block_init_assets_accordion () {
        wp_enqueue_style( 'block_init_accordion', get_theme_file_uri( '/blocks/block-accordion/template/style.css' ) );
    }

    add_action( 'enqueue_block_editor_assets', 'block_init_assets_accordion' );