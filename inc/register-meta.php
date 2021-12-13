<?php
/**
 * Custom metaboxes for posts and pages
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.6.0
 */

require_once plugin_dir_path(__DIR__) . 'classes/MetaBoxes.php';

new IDSK_Toolkit\IDSK_Meta_Boxes( array(
    // Add page meta boxes
    array(
        'id'        => 'page_back_button',
        'title'     => __( 'Tlačidlo späť', 'idsk-toolkit' ),
        'post_type' => 'page',
        'args'      => array(
            'fields'    => array(
                'text'  => array(
                    'type'  => 'text',
                    'title' => __( 'Text pre tlačidlo späť', 'idsk-toolkit' )
                ),
                'url'  => array(
                    'type'  => 'url',
                    'title' => __( 'URL pre tlačidlo späť (ak ostane prázdne, späť sa nezobrazí)', 'idsk-toolkit' )
                )
            )
        )
    ),
    // Add post meta boxes
    array(
        'id'        => 'post_updates_list',
        'title'     => __( 'Zoznam aktualizácií', 'idsk-toolkit' ),
        'post_type' => 'post',
        'args'      => array(
            'allow'     => __( 'Povoliť zobrazenie obsahu aktualizácií', 'idsk-toolkit' ),
            'multiple'  => true,
            'fields'    => array(
                'date'  => array(
                    'type'  => 'text',
                    'title' => __( 'Dňa', 'idsk-toolkit' )
                ),
                'desc'  => array(
                    'type'  => 'textarea',
                    'title' => __( 'Bližší popis', 'idsk-toolkit' )
                )
            )
        )
    ),
    array(
        'id'        => 'post_social',
        'title'     => __( 'Zdieľanie článku na sociálnych sieťach', 'idsk-toolkit' ),
        'post_type' => 'post',
        'args'      => array(
            'allow'     => __( 'Povoliť zdieľanie článku na sociálnych sieťach', 'idsk-toolkit' )
        )
    ),
    array(
        'id'        => 'post_related_topics',
        'title'     => __( 'Súvisiace témy', 'idsk-toolkit' ),
        'post_type' => 'post',
        'args'      => array(
            'allow'     => __( 'Povoliť zobrazenie súvisiacich tém', 'idsk-toolkit' ),
            'multiple'  => true,
            'fields'    => array(
                'title'  => array(
                    'type'  => 'text',
                    'title' => __( 'Názov témy', 'idsk-toolkit' )
                ),
                'url'  => array(
                    'type'  => 'url',
                    'title' => __( 'Odkaz na tému', 'idsk-toolkit' )
                )
            )
        )
    ),
    array(
        'id'        => 'post_related_posts',
        'title'     => __( 'Súvisiace články', 'idsk-toolkit' ),
        'post_type' => 'post',
        'args'      => array(
            'allow'     => __( 'Povoliť zobrazenie súvisiacich článkov', 'idsk-toolkit' ),
            'multiple'  => true,
            'fields'    => array(
                'id'  => array(
                    'type'          => 'select_posts',
                    'title'         => __( 'Článok', 'idsk-toolkit' ),
                    'option_none'   => __( 'Vyberte článok', 'idsk-toolkit' )
                )
            )
        )
    )
) );