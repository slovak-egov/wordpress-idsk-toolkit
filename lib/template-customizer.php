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
     * Cookies
     */
    $wp_customize->add_section(
        'idsktk_cookies_settings',
        array(
            'title'      => __( 'Cookies', 'idsk-toolkit' ),
            'priority'   => 20
        )
    );
    
        // Cookies banner
        $wp_customize->add_setting(
            'idsktk_cookies_settings_banner',
            array(
                'capability'        => 'edit_theme_options',
                'default'           => false,
                'sanitize_callback' => 'idsktk_sanitize_checkbox'
            )
        );
        $wp_customize->add_control(
            'idsktk_cookies_settings_banner',
            array(
                'type'     => 'checkbox',
                'section'  => 'idsktk_cookies_settings',
                'label'    => __( 'Povoliť cookies a zobrazenie cookies bannera', 'idsk-toolkit' )
            )
        );

        // Cookies expiration
        $wp_customize->add_setting(
            'idsktk_cookies_settings_expiration',
            array(
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'absint' // converts value to a non-negative integer
            )
        );
        $wp_customize->add_control(
            'idsktk_cookies_settings_expiration',
            array(
                'type'     => 'number',
                'section'  => 'idsktk_cookies_settings',
                'label'    => __( 'Dĺžka platnosti cookies', 'idsk-toolkit' )
            )
        );
        
        // Cookies expire type
        $wp_customize->add_setting(
            'idsktk_cookies_settings_expiration_type',
            array(
                'capability'        => 'edit_theme_options',
                'default'           => 'day',
                'sanitize_callback' => 'idsktk_sanitize_select'
            )
        );
        $wp_customize->add_control(
            'idsktk_cookies_settings_expiration_type',
            array(
                'type'     => 'select',
                'section'  => 'idsktk_cookies_settings',
                'choices'  => array(
                    'day'   => __( 'Dní', 'idsk-toolkit' ),
                    'month' => __( 'Mesiacov', 'idsk-toolkit' ),
                )
            )
        );

        // Cookies banner heading
        $wp_customize->add_setting(
            'idsktk_cookies_settings_banner_heading',
            array(
                'sanitize_callback' => 'idsktk_sanitize_text'
            )
        );
        $wp_customize->add_control(
            'idsktk_cookies_settings_banner_heading',
            array(
                'label'      => __( 'Nadpis bannera', 'idsk-toolkit' ),
                'section'    => 'idsktk_cookies_settings',
                'settings'   => 'idsktk_cookies_settings_banner_heading',
                'type'       => 'text'
            )
        );

        // Cookies banner text
        $wp_customize->add_setting(
            'idsktk_cookies_settings_banner_text',
            array(
                'sanitize_callback' => 'idsktk_sanitize_text'
            )
        );
        $wp_customize->add_control(
            'idsktk_cookies_settings_banner_text',
            array(
                'label'      => __( 'Textový obsah banera', 'idsk-toolkit' ),
                'section'    => 'idsktk_cookies_settings',
                'type'       => 'textarea'
            )
        );

        // Cookies banner allow buttons
        $wp_customize->add_setting(
            'idsktk_cookies_settings_banner_buttons',
            array(
                'capability'        => 'edit_theme_options',
                'default'           => false,
                'sanitize_callback' => 'idsktk_sanitize_checkbox'
            )
        );
        $wp_customize->add_control(
            'idsktk_cookies_settings_banner_buttons',
            array(
                'type'     => 'checkbox',
                'section'  => 'idsktk_cookies_settings',
                'label'    => __( 'Zobraziť tlačidlá pre povolenie všetkých cookies', 'idsk-toolkit' )
            )
        );
        
        // Cookies banner accepted text
        $wp_customize->add_setting(
            'idsktk_cookies_settings_banner_accepted',
            array(
                'sanitize_callback' => 'idsktk_sanitize_text'
            )
        );
        $wp_customize->add_control(
            'idsktk_cookies_settings_banner_accepted',
            array(
                'label'      => __( 'Vlastný text po prijatí cookies', 'idsk-toolkit' ),
                'section'    => 'idsktk_cookies_settings',
                'type'       => 'textarea',
                'active_callback' => 'idsktk_is_cookies_buttons'
            )
        );

        // Cookies banner rejected text
        $wp_customize->add_setting(
            'idsktk_cookies_settings_banner_rejected',
            array(
                'sanitize_callback' => 'idsktk_sanitize_text'
            )
        );
        $wp_customize->add_control(
            'idsktk_cookies_settings_banner_rejected',
            array(
                'label'      => __( 'Vlastný text po odmietnutí cookies', 'idsk-toolkit' ),
                'section'    => 'idsktk_cookies_settings',
                'type'       => 'textarea',
                'active_callback' => 'idsktk_is_cookies_buttons'
            )
        );

        // Cookies page url
        $wp_customize->add_setting(
            'idsktk_cookies_settings_banner_page_link',
            array(
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_control(
            'idsktk_cookies_settings_banner_page_link',
            array(
                'label'      => __( 'URL stránky s nastaveniami cookies', 'idsk-toolkit' ),
                'section'    => 'idsktk_cookies_settings',
                'settings'   => 'idsktk_cookies_settings_banner_page_link',
                'type'       => 'url'
            )
        );

    /**
     * Check if idsktk_cookies_settings_banner_buttons is allowed
     * 
     * @return bool
     */
    function idsktk_is_cookies_buttons() {
        return true === get_theme_mod( 'idsktk_cookies_settings_banner_buttons', true );
    }

    /**
     * Sanitize text
     * 
     * @param string
     * @return string
     */
    function idsktk_sanitize_text( $string ) {
        $allowedtags = array(
            'p' => array(
                'class' => array()
            ),
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

    /**
     * Sanitize select.
     * 
     * @param string $input
     * @param object $setting
     * @return string
     */
    function idsktk_sanitize_select( $input, $setting ) {
        // Ensure input is a slug.
        $input = sanitize_key( $input );
        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control( $setting->id )->choices;
        // If the input is a valid key, return it; otherwise, return the default.
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }
}
add_action( 'customize_register', 'idsktk_customize_register' );