<?php
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }

    include_once 'acf-block.php';

    function idsktk_id_sk_gov_register_block_example () { //TODO: zmeniť
        if ( !function_exists( 'acf_register_block' ) ) {
            return;
        }

        //example block
        acf_register_block( [
                                'name'            => 'section-example', //TODO: zmeniť
                                'title'           => __( 'Malý blok s textom', 'idsk-toolkit' ),
                                'description'     => __( 'Text zarovnaný na stred s nadpisom', 'idsk-toolkit' ),
                                'render_callback' => 'idsktk_render_callback_example', //TODO: zmeniť
                                'enqueue_assets'	=> function(){ //TODO: Enqueue scripts and styles for block - front
                                    wp_enqueue_style( 'slick-slider-css', plugin_dir_url(__DIR__) . '/assets/css/slick.css', array(), null, 'all');
                                    wp_enqueue_script('slick-slider-js', plugin_dir_url(__DIR__) . '/assets/js/slick.min.js', array( 'jquery' ), null, true );
                                    wp_enqueue_script('slick-slider-init', plugin_dir_url(__DIR__) . '/blocks/scripts/logo-carousel.js', array(), null, true );
                                },
                                'category'        => 'page-blocks',
                                'icon'            => 'format-aside',
                                'mode'            => 'preview',
                                'align'           => 'full',
                                'keywords'        => [ 'example' ],
                            ] );

    }

    add_action( 'acf/init', 'idsktk_id_sk_gov_register_block_example' ); //TODO: zmeniť

    function idsktk_render_callback_example ( $block ) { //TODO: zmeniť
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-example/template/tmp', 'block' ); //TODO: zmeniť
    }

    function idsktk_block_init_assets_example () { // TODO: zmeniť
        wp_enqueue_style( 'block_init_example', get_theme_file_uri( '/blocks/block-example/template/style.css' ) ); //TODO: zmeniť
    }

    add_action( 'enqueue_block_editor_assets', 'idsktk_block_init_assets_example' ); // TODO: zmeniť