<?php
/**
 * Custom template customizer options
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_customize_register( $wp_customize ) {
    
    $wp_customize->add_section(
        'idsktk_main_settings',
        array(
            'title'      => __( 'Nastavenia Google Maps API', 'idsk-toolkit' ),
            'priority'   => 11,
        )
    );
        // set google maps api
        $wp_customize->add_setting(
            'idsktk_main_settings_map_api',
            array(
                'sanitize_callback' => 'idsktk_sanitize_text',
            )
        );
        $wp_customize->add_control(
            'idsktk_main_settings_map_api_control',
            array(
                'label'      => __( 'Google Maps - API kľúč', 'idsk-toolkit' ),
                'section'    => 'idsktk_main_settings',
                'settings'   => 'idsktk_main_settings_map_api',
                'type'       => 'text',
            )
        );
        
    /**
     * Search settings
     */
    $wp_customize->add_section(
        'idsktk_search_settings',
        array(
            'title'      => __( 'Nastavenie vyhľadávania', 'idsk-toolkit' ),
            'priority'   => 17,
        )
    );

        // global info
        $wp_customize->add_setting(
            'idsktk_search_settings_main_show',
            array(
                'capability'        => 'edit_theme_options',
                'default'           => false,
                'sanitize_callback' => 'idsktk_sanitize_checkbox'
            )
        );
        $wp_customize->add_control(
            'idsktk_search_settings_main_show',
            array(
                'type'          => 'checkbox',
                'section'       => 'idsktk_search_settings',
                'label'         => __( 'Zobraziť hlavné vyhľadávanie', 'idsk-toolkit' ),
                'description'   => __( 'Zobrazuje veľké vyhľadávanie alebo malé pri filtroch', 'idsk-toolkit' )
            )
        );

    /**
     * Sanitize text
     */
    function idsktk_sanitize_text( $string ) {
        $allowedtags = array(
            'strong' => array(),
            'a' => array(
                'href' => array(),
                'title' => array(),
                'class' => array(),
                'target' => array(),
                'aria-label' => array(),
                'id' => array()
            ),
        );

        return wp_kses( $string , $allowedtags );
    }

    /**
     * Sanitize boolean for checkbox.
     *
     * @param bool $checked Whether or not a box is checked.
     * @return bool
     */
    function idsktk_sanitize_checkbox( $checked ) {
        return ( ( isset( $checked ) && true === $checked ) ? true : false );
    }
}
add_action( 'customize_register', 'idsktk_customize_register' );