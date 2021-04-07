<?php
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }

    include_once 'acf-block.php';

    function idsktk_id_sk_gov_register_block_news () {
        if ( !function_exists( 'acf_register_block' ) ) {
            return;
        }

        //news block
        acf_register_block( [
                                'name'            => 'section-news',
                                'title'           => __( 'Novinka', 'idsk-toolkit' ),
                                'description'     => __( 'Blok s novinkou', 'idsk-toolkit' ),
                                'render_callback' => 'idsktk_render_callback_news',
                                'category'        => 'gov-blocks',
                                'icon'            => '<svg enable-background="new 0 0 512 512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g><g><path d="m460.558 280.705c6.596-20.87 9.944-42.553 9.944-64.645 0-54.715-20.351-106.293-57.449-146.119-.138-.163-.286-.313-.433-.466-1.621-1.73-3.261-3.446-4.945-5.13-40.516-40.526-94.388-62.845-151.69-62.845-61.231 0-116.547 25.804-155.664 67.107-.745.597-1.415 1.307-1.978 2.125-35.266 38.251-56.845 89.313-56.845 145.328 0 22.126 3.339 43.811 9.919 64.649-29.096 4.599-51.417 29.854-51.417 60.231v108.575c0 33.628 27.35 60.985 60.966 60.985h150.063c5.522 0 10-4.478 10-10s-4.478-10-10-10h-150.063c-22.589 0-40.966-18.386-40.966-40.984v-108.576c0-22.599 18.377-40.984 40.966-40.984h96.122c.015 0 .03.002.045.002.013 0 .026-.002.039-.002h197.628c.013 0 .026.002.039.002.015 0 .03-.002.045-.002h91.776c.021 0 .043.003.064.003.026 0 .052-.003.078-.003h4.233c22.589 0 40.966 18.386 40.966 40.984v108.575c0 22.599-18.377 40.984-40.966 40.984h-150.178c-5.522 0-10 4.478-10 10s4.478 10 10 10h150.177c33.616 0 60.966-27.357 60.966-60.984v-108.575c0-30.386-22.334-55.647-51.442-60.235zm-93.735-.749c2.892-17.418 4.579-35.466 5.026-53.896h78.392c-.934 18.437-4.457 36.499-10.507 53.896zm-100.838 0v-53.896h85.851c-.47 18.487-2.247 36.546-5.303 53.896zm-100.538 0c-3.059-17.433-4.838-35.491-5.31-53.896h85.849v53.896zm-93.208 0c-6.036-17.368-9.551-35.431-10.481-53.896h78.366c.448 18.356 2.138 36.403 5.035 53.896zm36.634-191.022c14.219 7.194 29.994 13.219 46.935 17.994-9.417 29.857-14.826 63.73-15.684 99.133h-78.372c2.27-44.644 19.655-85.362 47.121-117.127zm341.375 117.127h-78.401c-.858-35.402-6.267-69.274-15.684-99.131 16.946-4.776 32.729-10.801 46.957-17.995 27.471 31.765 44.858 72.483 47.128 117.126zm-204.263-106.156c-22.033-.578-43.586-3.056-63.769-7.233 2.391-5.785 4.957-11.351 7.705-16.655 15.708-30.319 35.321-48.877 56.063-53.413v77.301zm0 20.007v86.148h-85.858c.858-33.876 6.077-66.124 15.122-94.312 22.23 4.793 46.06 7.573 70.736 8.164zm20 0c24.673-.591 48.503-3.371 70.737-8.164 9.045 28.188 14.263 60.436 15.121 94.312h-85.858zm0-20.007v-77.302c20.743 4.536 40.356 23.094 56.064 53.413 2.748 5.304 5.314 10.87 7.705 16.655-20.186 4.177-41.739 6.656-63.769 7.234zm83.428-11.961c-2.937-7.372-6.137-14.435-9.605-21.128-7.393-14.27-15.701-26.36-24.705-36.119 27.66 8.846 52.644 23.725 73.406 43.085-11.906 5.544-25.052 10.291-39.096 14.162zm-177.25-21.128c-3.467 6.693-6.668 13.755-9.604 21.127-14.039-3.871-27.179-8.618-39.077-14.161 20.755-19.357 45.731-34.235 73.382-43.081-9.002 9.759-17.309 21.848-24.701 36.115z"/><path d="m121.009 351.489v57.007l-46.29-62.932c-2.562-3.481-7.068-4.924-11.174-3.576-4.105 1.347-6.882 5.18-6.882 9.501v87.479c0 5.522 4.478 10 10 10s10-4.478 10-10v-57.007l46.29 62.932c1.921 2.611 4.937 4.076 8.057 4.076 1.04 0 2.091-.163 3.117-.5 4.105-1.347 6.882-5.18 6.882-9.501v-87.479c0-5.522-4.478-10-10-10s-10 4.478-10 10z"/><path d="m217.634 361.489c5.522 0 10-4.478 10-10s-4.478-10-10-10h-40.478c-5.522 0-10 4.478-10 10v87.479c0 5.522 4.478 10 10 10h40.478c5.522 0 10-4.478 10-10s-4.478-10-10-10h-30.478v-23.726h30.478c5.522 0 10-4.478 10-10s-4.478-10-10-10h-30.478v-23.753z"/><path d="m327.446 445.758c1.931 2.088 4.608 3.21 7.343 3.21 1.224 0 2.46-.225 3.645-.688 3.832-1.501 6.354-5.196 6.354-9.312v-87.479c0-5.522-4.478-10-10-10s-10 4.478-10 10v61.94l-18.147-19.618c-.102-.11-.197-.2-.289-.283-.089-.088-.169-.182-.262-.268-4.053-3.75-10.38-3.505-14.131.551l-18.148 19.619v-61.941c0-5.522-4.478-10-10-10s-10 4.478-10 10v87.479c0 4.115 2.521 7.811 6.354 9.312 1.186.464 2.42.688 3.645.688 2.734 0 5.412-1.122 7.343-3.21l28.148-30.43z"/><path d="m423.453 428.968h-42.49c-5.522 0-10 4.478-10 10s4.478 10 10 10h42.49c17.565 0 31.855-14.294 31.855-31.863s-14.29-31.862-31.855-31.862h-20.636c-6.536 0-11.854-5.321-11.854-11.862 0-6.557 5.318-11.891 11.854-11.891h42.491c5.522 0 10-4.478 10-10s-4.478-10-10-10h-42.491c-17.564 0-31.854 14.306-31.854 31.891 0 17.569 14.29 31.862 31.854 31.862h20.636c6.537 0 11.855 5.321 11.855 11.862s-5.318 11.863-11.855 11.863z"/><path d="m255.957 490.5c-5.522 0-10 4.478-10 10s4.478 10 10 10h.028c5.522 0 9.986-4.478 9.986-10s-4.492-10-10.014-10z"/></g></g></svg>',
                                'mode'            => 'preview',
                                'align'           => 'full',
                                'keywords'        => [ 'novinka', 'news' ],
                            ] );

    }

    add_action( 'acf/init', 'idsktk_id_sk_gov_register_block_news' );

    function idsktk_render_callback_news ( $block ) {
        set_query_var( 'block', $block );
        get_template_part( '/blocks/block-news/template/tmp', 'block' );
    }

    function idsktk_block_init_assets_news () {
        wp_enqueue_style( 'block_init_news', get_theme_file_uri( '/blocks/block-news/template/style.css' ) );
    }

    add_action( 'enqueue_block_editor_assets', 'idsktk_block_init_assets_news' );