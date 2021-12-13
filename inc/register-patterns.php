<?php
/**
 * Custom gutenberg block patterns
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.5.0
 */

/**
 * Register block patterns categories
 */
function idsktk_register_pattern_categories() {
    register_block_pattern_category(
        'pages',
        array( 'label' => __( 'Vzory stránok', 'idsk-toolkit' ) )
    );
}
   
add_action( 'init', 'idsktk_register_pattern_categories' );

/**
 * Register block patterns
 */
function idsktk_register_patterns() {

    $allowed_html = array(
        'a'      => array( 
                        'href' => array(),
                        'title' => array(),
                        'class' => array(),
                        'target' => array()
                    ),
        'strong' => array(),
        'b'      => array()
    );

    register_block_pattern( 
        'idsk-toolkit/homepage',
        array(
            'categories'  => array('pages'),
            'title'       => __( 'Domovská stránka', 'idsk-toolkit' ),
            'description' => _x( 'Domovská stránka s úvodnym blokom, kartičkami a rázcestníkmi. Odporúčame použiť so šablónou <strong>"Bez kontajnera a bez nadpisu"</strong>', 'Popis vzoru domovskej stránky', 'idsk-toolkit' ),
            'content'     => '<!-- wp:idsk/container {"paddingBottom":"govuk-!-padding-bottom-6"} -->
                                <div class="wp-block-idsk-container  govuk-!-padding-top-0 govuk-!-padding-bottom-6"><div class="govuk-width-container"><div class="wp-block-idsk-container"><!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/intro {"title":"' . esc_html__('Vitajte na stránke', 'idsk-toolkit') . '","subTitle":"' . esc_html__('Dozvedieť sa \u003ca href=\u0022#\u0022\u003eviac o stránkach\u003c/a\u003e.', 'idsk-toolkit') . '","withSearch":true,"searchTitle":"' . esc_html__('Hľadáte toto?', 'idsk-toolkit') . '","url1":"#","urlText1":"' . esc_attr__('Dokumenty', 'idsk-toolkit') . '","url2":"#","urlText2":"' . esc_attr__('Info', 'idsk-toolkit') . '","url3":"#","urlText3":"' . esc_attr__('Aktuality', 'idsk-toolkit') . '","url4":"#","urlText4":"' . esc_attr__('Podmienky', 'idsk-toolkit') . '","url5":"#","urlText5":"' . esc_attr__('O nás', 'idsk-toolkit') . '","sideTitle":"' . esc_attr__('Populárny obsah', 'idsk-toolkit') . '","sideContent":"' . esc_html__('\u003cli\u003e\u003ca href=\u0022#\u0022\u003eDokumenty\u003c/a\u003e\u003c/li\u003e\u003cli\u003e\u003ca href=\u0022#\u0022\u003eInfo\u003c/a\u003e\u003c/li\u003e\u003cli\u003e\u003ca href=\u0022#\u0022\u003eAktuality\u003c/a\u003e\u003c/li\u003e\u003cli\u003e\u003ca href=\u0022#\u0022\u003ePodmienky\u003c/a\u003e\u003c/li\u003e\u003cli\u003e\u003ca href=\u0022#\u0022\u003eO nás\u003c/a\u003e\u003c/li\u003e', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:idsk/separator {"separatorType":false} /-->
                                
                                <!-- wp:idsk/posts {"title":"' . esc_attr__('Aktuality', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:idsk/separator /-->
                                
                                <!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Sekcia', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph {"className":"govuk-body-m"} -->
                                <p class="govuk-body-m">' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore <a href="#">magna aliqua</a>.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/crossroad {"numberOfCols":true,"items":[{"id":"uQ-CILbA5SNT45bDPUP5k","title":"' . esc_attr__('Rázcestník 1', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"-OkgxV556acuoOw-7ccab","title":"' . esc_attr__('Rázcestník 2', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"9CC2XAuvepdVB0TH4RVNV","title":"' . esc_attr__('Rázcestník 3', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"XOk2qhdbhHgKbrUfShAw_","title":"' . esc_attr__('Rázcestník 4', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"}]} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row -->
                                
                                <!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"one-half","paddingTop":"govuk-!-padding-top-6","className":"is-style-one-half"} -->
                                <div class="wp-block-idsk-column is-style-one-half"><div class="govuk-grid-column-one-half"><div class=" govuk-!-padding-top-6   "><!-- wp:idsk/heading {"headingType":"h3","headingClass":"m","headingText":"' . esc_attr__('Podsekcia 1', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:idsk/crossroad {"items":[{"id":"xLGL9Zhcs-9xEAnwxBwFw","title":"' . esc_attr__('Rázcestník 1', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"uXZLbyXzZGb4kukW0J9Aq","title":"' . esc_attr__('Rázcestník 2', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"4lD6B5NExCfaeFrLQgT5F","title":"' . esc_attr__('Rázcestník 3', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"}]} /--></div></div></div>
                                <!-- /wp:idsk/column -->
                                
                                <!-- wp:idsk/column {"classShort":"one-half","paddingTop":"govuk-!-padding-top-6","className":"is-style-one-half"} -->
                                <div class="wp-block-idsk-column is-style-one-half"><div class="govuk-grid-column-one-half"><div class=" govuk-!-padding-top-6   "><!-- wp:idsk/heading {"headingType":"h3","headingClass":"m","headingText":"' . esc_attr__('Podsekcia 2', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:idsk/crossroad {"items":[{"id":"WS0vmi_6RNmtT7TAMtRRA","title":"' . esc_attr__('Rázcestník 1', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"aKEenKFtaWrutxzI86QQo","title":"' . esc_attr__('Rázcestník 2', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"ltzDmfttqpFGbZerGiWbS","title":"' . esc_attr__('Rázcestník 3', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"}]} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row -->
                                
                                <!-- wp:idsk/separator /-->
                                
                                <!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Vedenie', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:idsk/card {"cardType":"profile-horizontal","img":"","title":"' . esc_html__('\u003ca href=\u0022#\u0022\u003eMacko Pú\u003c/a\u003e', 'idsk-toolkit') . '","subTitle":"' . esc_html__('\u003ca href=\u0022#\u0022\u003eŠtátny tajomník medu a radosti\u003c/a\u003e', 'idsk-toolkit') . '","profileQuote":"' . esc_html__('“Aký je deň?” spýtal sa Pú. “Je dnes,” odpovedalo prasiatko. “Môj najobľúbenejší deň,” povedal Pú.', 'idsk-toolkit') . '"} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row -->
                                
                                <!-- wp:idsk/separator /-->
                                
                                <!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Informatizácia', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph {"className":"govuk-body-m"} -->
                                <p class="govuk-body-m">' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore <a href="#">magna aliqua</a>.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"one-half","className":"is-style-one-half"} -->
                                <div class="wp-block-idsk-column is-style-one-half"><div class="govuk-grid-column-one-half"><div class="    "><!-- wp:idsk/crossroad {"items":[{"id":"JaCpXypbWVugBafulvLJH","title":"' . esc_attr__('Rázcestník 1', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"7u1qTZ300-oOaexCyQrz9","title":"' . esc_attr__('Rázcestník 2', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"HrlcpiwJxm9CKhhWQk1fS","title":"' . esc_attr__('Rázcestník 3', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"JXGjqPgvE5XxWlP6AspTX","title":"' . esc_attr__('Rázcestník 4', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"}]} /--></div></div></div>
                                <!-- /wp:idsk/column -->
                                
                                <!-- wp:idsk/column {"classShort":"one-half","bgColor":"app-pane-blue","paddingTop":"govuk-!-padding-top-4","paddingBottom":"govuk-!-padding-bottom-4","paddingLeft":"govuk-!-padding-left-4","paddingRight":"govuk-!-padding-right-4","className":"is-style-one-half"} -->
                                <div class="wp-block-idsk-column is-style-one-half"><div class="govuk-grid-column-one-half"><div class="app-pane-blue govuk-!-padding-top-4 govuk-!-padding-bottom-4 govuk-!-padding-left-4 govuk-!-padding-right-4"><!-- wp:idsk/heading {"headingType":"h4","headingClass":"l","headingText":"' . esc_attr__('Služby', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:idsk/lists {"listType":"govuk-list\u002d\u002dbullet","items":[{"id":"T3R9fYhigcmbxZXN5OIBJ","text":"' . esc_html__('\u003ca href=\u0022#\u0022\u003e\u003cstrong\u003ePoložka 1\u003c/strong\u003e\u003c/a\u003e', 'idsk-toolkit') . '","parent":null,"listType":"","hasItems":false},{"id":"rpjd0tngm27OlTWrwbW1F","text":"' . esc_html__('\u003ca href=\u0022#\u0022\u003e\u003cstrong\u003ePoložka 2\u003c/strong\u003e\u003c/a\u003e', 'idsk-toolkit') . '","parent":null,"listType":"","hasItems":false},{"id":"fdD8Q11QzHKezWPXVyk1d","text":"' . esc_html__('\u003ca href=\u0022#\u0022\u003e\u003cstrong\u003ePoložka 3\u003c/strong\u003e\u003c/a\u003e', 'idsk-toolkit') . '","parent":null,"listType":"","hasItems":false},{"id":"8lmDyOsqYZYK7xTirztdO","text":"' . esc_html__('\u003ca href=\u0022#\u0022\u003e\u003cstrong\u003ePoložka 4\u003c/strong\u003e\u003c/a\u003e', 'idsk-toolkit') . '","parent":null,"listType":"","hasItems":false},{"id":"v6MGq1OFZkxwq-w5KBKNs","text":"' . esc_html__('\u003ca href=\u0022#\u0022\u003e\u003cstrong\u003ePoložka 5\u003c/strong\u003e\u003c/a\u003e', 'idsk-toolkit') . '","parent":null,"listType":"","hasItems":false},{"id":"vDGGc5TmOyNMeZHqs9S6i","text":"' . esc_html__('\u003ca href=\u0022#\u0022\u003e\u003cstrong\u003ePoložka 6\u003c/strong\u003e\u003c/a\u003e', 'idsk-toolkit') . '","parent":null,"listType":"","hasItems":false}],"className":"is-style-custom-list-style"} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row -->
                                
                                <!-- wp:idsk/separator {"separatorType":true} /-->
                                
                                <!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Sekcia 2', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph {"className":"govuk-body-m"} -->
                                <p class="govuk-body-m">' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore <a href="#">magna aliqua</a>.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/crossroad {"numberOfCols":true,"hideTiles":false,"items":[{"id":"RkyZo7LME7k0N2WQqHf7D","title":"' . esc_attr__('Rázcestník 1', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"4ocrM55ebgmMdVIW1cQqI","title":"' . esc_attr__('Rázcestník 2', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"erf5pXvbof7uf_NZP5brQ","title":"' . esc_attr__('Rázcestník 3', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"b05Mz7SXsPHXJ4xOziR3o","title":"' . esc_attr__('Rázcestník 4', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"}]} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row -->
                                
                                <!-- wp:idsk/separator {"separatorType":false} /-->
                                
                                <!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Sekcia 3', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph {"className":"govuk-body-m"} -->
                                <p class="govuk-body-m">' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore <a href="#">magna aliqua</a>.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/crossroad {"numberOfCols":true,"items":[{"id":"_aUCHmsaJjmdbdQBLyo5m","title":"' . esc_attr__('Rázcestník 1', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"hf9-HyGJYvMyoBg88qppn","title":"' . esc_attr__('Rázcestník 2', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"i6vsGMgJzEp3S6qjEIKB3","title":"' . esc_attr__('Rázcestník 3', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"YPcGmbA69ilk17sM1p3H1","title":"' . esc_attr__('Rázcestník 4', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"PRvKEwOKw_TSa7IwuFuFu","title":"' . esc_attr__('Rázcestník 5', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"MCJ2AwsRusfUghFjgdN_Q","title":"' . esc_attr__('Rázcestník 6', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"}]} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row --></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row --></div></div></div>
                                <!-- /wp:idsk/container -->
                                
                                <!-- wp:idsk/container {"bgColor":"app-pane-blue","paddingTop":"govuk-!-padding-top-6","paddingBottom":"govuk-!-padding-bottom-6"} -->
                                <div class="wp-block-idsk-container app-pane-blue govuk-!-padding-top-6 govuk-!-padding-bottom-6"><div class="govuk-width-container"><div class="wp-block-idsk-container"><!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"two-thirds","className":"is-style-two-thirds"} -->
                                <div class="wp-block-idsk-column is-style-two-thirds"><div class="govuk-grid-column-two-thirds"><div class="    "><!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Banner', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph {"className":"govuk-caption-l"} -->
                                <p class="govuk-caption-l">' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('<a href="#">Zistiť viac</a>', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph --></div></div></div>
                                <!-- /wp:idsk/column -->
                                
                                <!-- wp:idsk/column {"classShort":"one-third","className":"is-style-one-third"} -->
                                <div class="wp-block-idsk-column is-style-one-third"><div class="govuk-grid-column-one-third"><div class="    "><!-- wp:image {"id":2468,"sizeSlug":"medium","linkDestination":"none"} -->
                                <figure class="wp-block-image size-medium"><img src="" alt="" class="wp-image-2468"/></figure>
                                <!-- /wp:image --></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row --></div></div></div>
                                <!-- /wp:idsk/container -->
                                
                                <!-- wp:idsk/container {"paddingTop":"govuk-!-padding-top-6"} -->
                                <div class="wp-block-idsk-container  govuk-!-padding-top-6 govuk-!-padding-bottom-0"><div class="govuk-width-container"><div class="wp-block-idsk-container"><!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Podujatia', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph {"className":"govuk-body-m"} -->
                                <p class="govuk-body-m">' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore <a href="#">magna aliqua</a>.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"one-third","className":"is-style-one-third"} -->
                                <div class="wp-block-idsk-column is-style-one-third"><div class="govuk-grid-column-one-third"><div class="    "><!-- wp:paragraph -->
                                <p>' . wp_kses(__('<strong><a href="#">Lorem ipsum dolor sit amet</a></strong>', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . esc_html__('26.02.2021', 'idsk-toolkit') . '</p>
                                <!-- /wp:paragraph --></div></div></div>
                                <!-- /wp:idsk/column -->
                                
                                <!-- wp:idsk/column {"classShort":"one-third","className":"is-style-one-third"} -->
                                <div class="wp-block-idsk-column is-style-one-third"><div class="govuk-grid-column-one-third"><div class="    "><!-- wp:paragraph -->
                                <p>' . wp_kses(__('<strong><a href="#">Lorem ipsum dolor sit amet</a></strong>', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . esc_html__('26.02.2021', 'idsk-toolkit') . '</p>
                                <!-- /wp:paragraph --></div></div></div>
                                <!-- /wp:idsk/column -->
                                
                                <!-- wp:idsk/column {"classShort":"one-third","className":"is-style-one-third"} -->
                                <div class="wp-block-idsk-column is-style-one-third"><div class="govuk-grid-column-one-third"><div class="    "><!-- wp:paragraph -->
                                <p>' . wp_kses(__('<strong><a href="#">Lorem ipsum dolor sit amet</a></strong>', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . esc_html__('26.02.2021', 'idsk-toolkit') . '</p>
                                <!-- /wp:paragraph --></div></div></div>
                                <!-- /wp:idsk/column -->
                                
                                <!-- wp:idsk/column {"classShort":"one-third","className":"is-style-one-third"} -->
                                <div class="wp-block-idsk-column is-style-one-third"><div class="govuk-grid-column-one-third"><div class="    "><!-- wp:paragraph -->
                                <p>' . wp_kses(__('<strong><a href="#">Lorem ipsum dolor sit amet</a></strong>', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . esc_html__('26.02.2021', 'idsk-toolkit') . '</p>
                                <!-- /wp:paragraph --></div></div></div>
                                <!-- /wp:idsk/column -->
                                
                                <!-- wp:idsk/column {"classShort":"one-third","className":"is-style-one-third"} -->
                                <div class="wp-block-idsk-column is-style-one-third"><div class="govuk-grid-column-one-third"><div class="    "><!-- wp:paragraph -->
                                <p>' . wp_kses(__('<strong><a href="#">Lorem ipsum dolor sit amet</a></strong>', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . esc_html__('26.02.2021', 'idsk-toolkit') . '</p>
                                <!-- /wp:paragraph --></div></div></div>
                                <!-- /wp:idsk/column -->
                                
                                <!-- wp:idsk/column {"classShort":"one-third","className":"is-style-one-third"} -->
                                <div class="wp-block-idsk-column is-style-one-third"><div class="govuk-grid-column-one-third"><div class="    "><!-- wp:paragraph -->
                                <p>' . wp_kses(__('<strong><a href="#">Lorem ipsum dolor sit amet</a></strong>', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . esc_html__('26.02.2021', 'idsk-toolkit') . '</p>
                                <!-- /wp:paragraph --></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row -->
                                
                                <!-- wp:idsk/separator /-->
                                
                                <!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Projekty', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph {"className":"govuk-body-m"} -->
                                <p class="govuk-body-m">' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore <a href="#">magna aliqua</a>.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/crossroad {"numberOfCols":true,"hideTiles":true,"items":[{"id":"l95qVMu1zH8l2-8pHJyYa","title":"' . esc_attr__('Projekt 1', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"Ey7760YiYh4YFOprqto-Q","title":"' . esc_attr__('Projekt 2', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"-1Qd33WfJxmXzwuJTJhoG","title":"' . esc_attr__('Projekt 3', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"M7Vw0QIrH3DHbcrpAGMnU","title":"' . esc_attr__('Projekt 4', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"UvutfvRGzRBDKWp1txVTO","title":"' . esc_attr__('Projekt 5', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"h23XmanffZ9pmIlctHkcv","title":"' . esc_attr__('Projekt 6', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"PB7VDDmuIlDkyN7poPTcd","title":"' . esc_attr__('Projekt 7', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"VhmdnXug09m4GVArDYYg9","title":"' . esc_attr__('Projekt 8', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"AKwfzmn3H9_vuYToT44g_","title":"' . esc_attr__('Projekt 9', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"por1jR-F4tgkfTVFQcieN","title":"' . esc_attr__('Projekt 10', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"s1bD6TGTuWee18kdYgZSm","title":"' . esc_attr__('Projekt 11', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"rjCL7YzIQsLaEjDiEYQzY","title":"' . esc_attr__('Projekt 12', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"gyR3jb-XzdAPQZKzbsO2p","title":"' . esc_attr__('Projekt 13', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"DklhS_p31yVVu15BvxJ3Z","title":"' . esc_attr__('Projekt 14', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"SDGeBr8mmgxHCp9z53o_X","title":"' . esc_attr__('Projekt 15', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"}]} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row --></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row --></div></div></div>
                                <!-- /wp:idsk/container -->',
        )
    );

    register_block_pattern( 
        'idsk-toolkit/subpage',
        array(
            'categories'  => array('pages'),
            'title'       => __( 'Podstránka', 'idsk-toolkit' ),
            'description' => _x( 'Podstránka s úvodnym blokom, kartičkami, rázcestníkmi a akordeónmi. Odporúčame použiť so šablónou <strong>"Bez kontajnera a bez nadpisu"</strong>', 'Popis vzoru podstránky', 'idsk-toolkit' ),
            'content'     => '<!-- wp:idsk/container {"paddingBottom":"govuk-!-padding-bottom-6"} -->
                                <div class="wp-block-idsk-container  govuk-!-padding-top-0 govuk-!-padding-bottom-6"><div class="govuk-width-container"><div class="wp-block-idsk-container"><!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/intro {"title":"' . esc_attr__('Podstránka', 'idsk-toolkit') . '","subTitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore \u003ca href=\u0022#\u0022\u003emagna aliqua\u003c/a\u003e.', 'idsk-toolkit') . '","sideTitle":"' . esc_attr__('Populárny obsah', 'idsk-toolkit') . '","sideContent":"' . esc_html__('\u003cli\u003e\u003ca href=\u0022#\u0022\u003eDokumenty\u003c/a\u003e\u003c/li\u003e\u003cli\u003e\u003ca href=\u0022#\u0022\u003eInfo\u003c/a\u003e\u003c/li\u003e\u003cli\u003e\u003ca href=\u0022#\u0022\u003eAktuality\u003c/a\u003e\u003c/li\u003e\u003cli\u003e\u003ca href=\u0022#\u0022\u003ePodmienky\u003c/a\u003e\u003c/li\u003e\u003cli\u003e\u003ca href=\u0022#\u0022\u003eO nás\u003c/a\u003e\u003c/li\u003e', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:idsk/separator /-->
                                
                                <!-- wp:idsk/posts {"title":"' . esc_attr__('Aktuality', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:idsk/separator /-->
                                
                                <!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Sekcia', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/crossroad {"numberOfCols":true,"items":[{"id":"_pbrxEJqzqGLfbIpWraba","title":"' . esc_attr__('Rázcestník 1', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"Kq0Mj3wfWGXU_Cz67xRrq","title":"' . esc_attr__('Rázcestník 2', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"ssjVAs8lJnTTcjarhFYde","title":"' . esc_attr__('Rázcestník 3', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"tgsP1Ch8HYIyhMUQkbEJq","title":"' . esc_attr__('Rázcestník 4', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"RnJ9KTZ9F0RGSLWMA1S0l","title":"' . esc_attr__('Rázcestník 5', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"F01EezGZTjsGQXesvb6HG","title":"' . esc_attr__('Rázcestník 6', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"}]} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row -->
                                
                                <!-- wp:paragraph {"className":"govuk-caption-l"} -->
                                <p class="govuk-caption-l">' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/accordion {"blockId":"mfmQO4bQA-W7opWQbgNrl","items":[{"id":"wQ8noyMWAU9biDICIo0vK","open":false,"title":"' . esc_attr__('Akordeón 1', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '"},{"id":"lZ4djllYd9ewYTlp5N7o1","open":false,"title":"' . esc_attr__('Akordeón 2', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '"},{"id":"ELUowq2iu6gtzvxnJQw_O","open":false,"title":"' . esc_attr__('Akordeón 3', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '"},{"id":"yf5ngtJmVY67w4tY__bYK","open":false,"title":"' . esc_attr__('Akordeón 4', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '"},{"id":"SR-0OopqVzSLKTdxr8Lun","open":false,"title":"' . esc_attr__('Akordeón 5', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '"},{"id":"M4LtHPusUV9kxK5JrFUho","open":false,"title":"' . esc_attr__('Akordeón 6', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '"},{"id":"g0dlFnRWHhcOUkeZviWQR","open":false,"title":"' . esc_attr__('Akordeón 7', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '"}]} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row --></div></div></div>
                                <!-- /wp:idsk/container -->
                                
                                <!-- wp:idsk/container {"bgColor":"app-pane-lgray","paddingTop":"govuk-!-padding-top-6","paddingBottom":"govuk-!-padding-bottom-6"} -->
                                <div class="wp-block-idsk-container app-pane-lgray govuk-!-padding-top-6 govuk-!-padding-bottom-6"><div class="govuk-width-container"><div class="wp-block-idsk-container"><!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Banner', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"one-half","className":"is-style-one-half"} -->
                                <div class="wp-block-idsk-column is-style-one-half"><div class="govuk-grid-column-one-half"><div class="    "><!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph --></div></div></div>
                                <!-- /wp:idsk/column -->
                                
                                <!-- wp:idsk/column {"classShort":"one-half","className":"is-style-one-half"} -->
                                <div class="wp-block-idsk-column is-style-one-half"><div class="govuk-grid-column-one-half"><div class="    "><!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph --></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row --></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row --></div></div></div>
                                <!-- /wp:idsk/container -->
                                
                                <!-- wp:idsk/container {"paddingTop":"govuk-!-padding-top-6"} -->
                                <div class="wp-block-idsk-container  govuk-!-padding-top-6 govuk-!-padding-bottom-0"><div class="govuk-width-container"><div class="wp-block-idsk-container"><!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"one-half","className":"is-style-one-half"} -->
                                <div class="wp-block-idsk-column is-style-one-half"><div class="govuk-grid-column-one-half"><div class="    "><!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Sekcia 2', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('<a href="#">Dokument (PDF, 10kB)</a>', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('<a href="#">Dokument (PDF, 10kB)</a>', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/accordion {"blockId":"cYoeC-gDfu__zG_MNQ7Fv","items":[{"id":"NRkbxy4A3KXFCD75RKBnX","open":false,"title":"' . esc_attr__('Ďalšie dokumenty', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"}]} /--></div></div></div>
                                <!-- /wp:idsk/column -->
                                
                                <!-- wp:idsk/column {"classShort":"one-half","className":"is-style-one-half"} -->
                                <div class="wp-block-idsk-column is-style-one-half"><div class="govuk-grid-column-one-half"><div class="    "><!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Sekcia 3', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('<a href="#">Dokument (PDF, 10kB)</a>', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/accordion {"blockId":"JVvhB_FEnj-R8WHR0laPp","items":[{"id":"btJSVggymVBZhgyN65g4U","open":false,"title":"' . esc_attr__('Ďalšie dokumenty', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"}]} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row --></div></div></div>
                                <!-- /wp:idsk/container -->',
        )
    );
    
    register_block_pattern( 
        'idsk-toolkit/subpage-documents',
        array(
            'categories'  => array('pages'),
            'title'       => __( 'Podstránka s dokumentmi', 'idsk-toolkit' ),
            'description' => _x( 'Podstránka s rázcestníkmi a akordeónmi.', 'Popis vzoru podstránky s dokumentmi', 'idsk-toolkit' ),
            'content'     => '<!-- wp:paragraph {"className":"govuk-body-l"} -->
                                <p class="govuk-body-l">' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/row {"paddingBottom":"govuk-!-padding-bottom-4"} -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   govuk-!-padding-bottom-4"><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/crossroad {"numberOfCols":true,"items":[{"id":"dCW5EIxMAXNRw74uCG89L","title":"' . esc_attr__('Rázcestník 1', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"OATREuZ5wpVUlWrJCye4t","title":"' . esc_attr__('Rázcestník 2', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"KbbSdVZs-XORmSa27hb0D","title":"' . esc_attr__('Rázcestník 3', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"10D6bCRr-ZVwVHx1Wgy5O","title":"' . esc_attr__('Rázcestník 4', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"OPK2bU4J7MMO4AlMwH4vI","title":"' . esc_attr__('Rázcestník 5', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"Sam95_A9CPpXjpCPAeJpg","title":"' . esc_attr__('Rázcestník 6', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"Cupz2-keca8uJcm8YfVFr","title":"' . esc_attr__('Rázcestník 7', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"nOlAeA7hTx9PTbIQou9Kl","title":"' . esc_attr__('Rázcestník 8', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"}]} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row -->
                                
                                <!-- wp:paragraph {"className":"govuk-body-l"} -->
                                <p class="govuk-body-l">' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/crossroad {"numberOfCols":true,"items":[{"id":"qA-ooOiUUZPpwTtbhsRlw","title":"' . esc_attr__('Rázcestník 1', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"_6PjZXHLj-sFuZU2hXN_d","title":"' . esc_attr__('Rázcestník 2', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"JaWkbFgjSTGxSaR0oD7AZ","title":"' . esc_attr__('Rázcestník 3', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"yeyE7x4jGE8oiHC2Y2566","title":"' . esc_attr__('Rázcestník 4', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"VZ4fp9ulPZ3ViekXR5K-V","title":"' . esc_attr__('Rázcestník 5', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"tlKBOHQb6UjMG19Ux6Gl6","title":"' . esc_attr__('Rázcestník 6', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"_bMWBbRjTHxowPtZjsTPg","title":"' . esc_attr__('Rázcestník 7', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"}]} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row -->
                                
                                <!-- wp:idsk/separator /-->
                                
                                <!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Sekcia', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph {"className":"govuk-body-l"} -->
                                <p class="govuk-body-l">' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/row -->
                                <div class="wp-block-idsk-row"><div class="govuk-grid-row   "><div class="wp-block-idsk-row"><!-- wp:idsk/column {"classShort":"full"} -->
                                <div class="wp-block-idsk-column"><div class="govuk-grid-column-full"><div class="    "><!-- wp:idsk/crossroad {"numberOfCols":true,"items":[{"id":"lqot12OMnVJWLxmcLSW64","title":"' . esc_attr__('Rázcestník 1', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"hU5lXGw_3BU6SNVMMRt1q","title":"' . esc_attr__('Rázcestník 2', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"7ZghDDpMWNdJdofVqm46P","title":"' . esc_attr__('Rázcestník 3', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"WkADocfqxDiOmFwz8IhSA","title":"' . esc_attr__('Rázcestník 4', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"},{"id":"Q6T-D_Q4sgajF92VJfbHj","title":"' . esc_attr__('Rázcestník 5', 'idsk-toolkit') . '","subtitle":"' . esc_html__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit') . '","link":"#"}]} /--></div></div></div>
                                <!-- /wp:idsk/column --></div></div></div>
                                <!-- /wp:idsk/row -->
                                
                                <!-- wp:idsk/accordion {"blockId":"y0yZt2VCCtugi0t1gfIhH","items":[{"id":"EK3sBy1WB4YqBajO00DXo","open":false,"title":"' . esc_attr__('Akordeón 1', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"LuMBSUnebQ7zXMPIg0a7d","open":false,"title":"' . esc_attr__('Akordeón 2', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"0BKwVXfWL-6jDwrCWqGYM","open":false,"title":"' . esc_attr__('Akordeón 3', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"3u7k3u1ymmcHZZ5flVwvg","open":false,"title":"' . esc_attr__('Akordeón 4', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"3lcxgUediGmOCgwpnxUMH","open":false,"title":"' . esc_attr__('Akordeón 5', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"6UHrh6gl3o6i0zyQqF1_g","open":false,"title":"' . esc_attr__('Akordeón 6', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"iQAiM1RQhzZ6yYOdIopqU","open":false,"title":"' . esc_attr__('Akordeón 7', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"NUtaOaRGEFk-Mph5evWD-","open":false,"title":"' . esc_attr__('Akordeón 8', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"}]} /-->
                                
                                <!-- wp:idsk/heading {"headingType":"h2","headingClass":"l","headingText":"' . esc_attr__('Sekcia 2', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph {"className":"govuk-body-l"} -->
                                <p class="govuk-body-l">' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/accordion {"blockId":"y0yZt2VCCtugi0t1gfIhH","items":[{"id":"EK3sBy1WB4YqBajO00DXo","open":false,"title":"' . esc_attr__('Akordeón 1', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"LuMBSUnebQ7zXMPIg0a7d","open":false,"title":"' . esc_attr__('Akordeón 2', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"0BKwVXfWL-6jDwrCWqGYM","open":false,"title":"' . esc_attr__('Akordeón 3', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"3u7k3u1ymmcHZZ5flVwvg","open":false,"title":"' . esc_attr__('Akordeón 4', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"3lcxgUediGmOCgwpnxUMH","open":false,"title":"' . esc_attr__('Akordeón 5', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"6UHrh6gl3o6i0zyQqF1_g","open":false,"title":"' . esc_attr__('Akordeón 6', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"},{"id":"iQAiM1RQhzZ6yYOdIopqU","open":false,"title":"' . esc_attr__('Akordeón 7', 'idsk-toolkit') . '","summary":"","content":"' . esc_html__('Popis\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e\u003cbr\u003e\u003ca href=\u0022#\u0022\u003eDokument (PDF, 10kB)\u003c/a\u003e', 'idsk-toolkit') . '"}]} /-->',
        )
    );
    
    register_block_pattern( 
        'idsk-toolkit/subpage-stepper',
        array(
            'categories'  => array('pages'),
            'title'       => __( 'Podstránka so stepperom', 'idsk-toolkit' ),
            'description' => _x( 'Podstránka so stepperom a súvisiacim obsahom. Odporúčame použiť so šablónou <strong>"In-page navigácia"</strong>', 'Popis vzoru podstránky so stepperom', 'idsk-toolkit' ),
            'content'     => '<!-- wp:idsk/stepper-banner {"textHeading":"' . esc_attr__('Súčasť životnej situácie', 'idsk-toolkit') . '","textBanner":"' . esc_html__('\u003ca href=\u0022#\u0022\u003eNarodenie dieťaťa: krok za krokom\u003c/a\u003e', 'idsk-toolkit') . '"} /-->

                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:image -->
                                <figure class="wp-block-image"><img alt=""/></figure>
                                <!-- /wp:image -->
                                
                                <!-- wp:idsk/heading {"anchor":"nadpis-1","headingType":"h3","headingClass":"m","headingText":"' . esc_attr__('Nadpis 1', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/heading {"anchor":"nadpis-2","headingType":"h3","headingClass":"m","headingText":"' . esc_attr__('Nadpis 2', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:paragraph -->
                                <p>' . wp_kses(__('Lorem ipsum dolor sit amet, consenctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'idsk-toolkit'), $allowed_html) . '</p>
                                <!-- /wp:paragraph -->
                                
                                <!-- wp:idsk/related-content {"title":"' . esc_attr__('Súvisiace témy', 'idsk-toolkit') . '","body":"' . esc_html__('\u003cli\u003e\u003ca href=\u0022#\u0022\u003eSúvisiaca téma\u003c/a\u003e\u003c/li\u003e\u003cli\u003e\u003ca href=\u0022#\u0022\u003eSúvisiaca téma\u003c/a\u003e\u003c/li\u003e\u003cli\u003e\u003ca href=\u0022#\u0022\u003eSúvisiaca téma\u003c/a\u003e\u003c/li\u003e', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:idsk/stepper-banner {"textHeading":"' . esc_attr__('Súčasť životnej situácie', 'idsk-toolkit') . '","textBanner":"' . esc_html__('\u003ca href=\u0022#\u0022\u003eNarodenie dieťaťa: krok za krokom\u003c/a\u003e', 'idsk-toolkit') . '"} /-->
                                
                                <!-- wp:idsk/stepper {"stepperSubtitle":"' . esc_attr__('Pred narodením dieťaťa', 'idsk-toolkit') . '","items":[{"id":"3YrbSvYeiaZsFkAqhS4I0","step":1,"lastStep":false,"hasSub":false,"subStep":"","lastSubStep":false,"sectionTitle":"","sectionHeading":"' . esc_attr__('Krok 1', 'idsk-toolkit') . '","sectionContent":"' . esc_html__('\u003cli\u003e\u003ca href=\u0022#\u0022\u003eOdkaz na podstránku\u003c/a\u003e\u003c/li\u003e', 'idsk-toolkit') . '"},{"id":"pk3Y5wmk0EGmR158_-lqa","step":2,"lastStep":false,"hasSub":false,"subStep":"","lastSubStep":false,"sectionTitle":"","sectionHeading":"' . esc_attr__('Krok 2', 'idsk-toolkit') . '","sectionContent":"' . esc_html__('\u003cli\u003e\u003ca href=\u0022#\u0022\u003eOdkaz na podstránku\u003c/a\u003e\u003c/li\u003e', 'idsk-toolkit') . '"},{"id":"wDHTxyE5nBe3sxkLOTtj4","step":3,"lastStep":false,"hasSub":true,"subStep":"","lastSubStep":false,"sectionTitle":"' . esc_attr__('Po narodení dieťaťa', 'idsk-toolkit') . '","sectionHeading":"' . esc_attr__('Krok 3', 'idsk-toolkit') . '","sectionContent":"' . esc_html__('\u003cli\u003e\u003ca href=\u0022#\u0022\u003eOdkaz na podstránku\u003c/a\u003e\u003c/li\u003e', 'idsk-toolkit') . '"},{"id":"ptRo9Z6gdGEHV74xctVUg","step":3,"lastStep":false,"hasSub":false,"subStep":"a","lastSubStep":true,"sectionTitle":"","sectionHeading":"' . esc_attr__('Čiastočný krok', 'idsk-toolkit') . '","sectionContent":"' . esc_html__('\u003cli\u003e\u003ca href=\u0022#\u0022\u003eOdkaz na podstránku\u003c/a\u003e\u003c/li\u003e', 'idsk-toolkit') . '"},{"id":"4GJGV27HvsRfurQDuT5MQ","step":4,"lastStep":false,"hasSub":false,"subStep":"","lastSubStep":false,"sectionTitle":"","sectionHeading":"' . esc_attr__('Krok 4', 'idsk-toolkit') . '","sectionContent":"' . esc_html__('\u003cli\u003e\u003ca href=\u0022#\u0022\u003eOdkaz na podstránku\u003c/a\u003e\u003c/li\u003e', 'idsk-toolkit') . '"},{"id":"tJuj6sjhW1vWVrxpMxIEX","step":5,"lastStep":true,"hasSub":false,"subStep":"","lastSubStep":false,"sectionTitle":"","sectionHeading":"' . esc_attr__('Krok 5', 'idsk-toolkit') . '","sectionContent":"' . esc_html__('\u003cli\u003e\u003ca href=\u0022#\u0022\u003eOdkaz na podstránku\u003c/a\u003e\u003c/li\u003e', 'idsk-toolkit') . '"}]} /-->
                                
                                <!-- wp:idsk/related-content {"title":"' . esc_attr__('Súvisiace témy', 'idsk-toolkit') . '","body":"' . esc_html__('\u003cli\u003e\u003ca href=\u0022#\u0022\u003eSúvisiaca téma\u003c/a\u003e\u003c/li\u003e\u003cli\u003e\u003ca href=\u0022#\u0022\u003eSúvisiaca téma\u003c/a\u003e\u003c/li\u003e\u003cli\u003e\u003ca href=\u0022#\u0022\u003eSúvisiaca téma\u003c/a\u003e\u003c/li\u003e', 'idsk-toolkit') . '"} /-->',
        )
    );
}
   
add_action( 'init', 'idsktk_register_patterns' );
