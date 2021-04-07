<?php
/**
 * BLOCK - intro - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_dynamic_intro_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/intro', array(
        'render_callback' => 'idsktk_render_dynamic_intro_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_intro_block');
    
function idsktk_render_dynamic_intro_block($attributes) {
    // block attributes
    $title = isset($attributes['title']) ? $attributes['title'] : '';
    $subTitle = isset($attributes['subTitle']) ? $attributes['subTitle'] : '';
    $search = isset($attributes['withSearch']) && $attributes['withSearch'] ? $attributes['withSearch'] : FALSE;
    $searchTitle = isset($attributes['searchTitle']) ? $attributes['searchTitle'] : '';
    $sideStyle = isset($attributes['sideStyle']) ? $attributes['sideStyle'] : '';
    $defaultStyle = $sideStyle == 'default' || $sideStyle == '' ? true : false;
    $sideTitle = isset($attributes['sideTitle']) ? $attributes['sideTitle'] : '';

    $url1 = isset($attributes['url1']) ? $attributes['url1'] : '';
    $urlText1 = isset($attributes['urlText1']) ? $attributes['urlText1'] : '';
    $url2 = isset($attributes['url2']) ? $attributes['url2'] : '';
    $urlText2 = isset($attributes['urlText2']) ? $attributes['urlText2'] : '';
    $url3 = isset($attributes['url3']) ? $attributes['url3'] : '';
    $urlText3 = isset($attributes['urlText3']) ? $attributes['urlText3'] : '';
    $url4 = isset($attributes['url4']) ? $attributes['url4'] : '';
    $urlText4 = isset($attributes['urlText4']) ? $attributes['urlText4'] : '';
    $url5 = isset($attributes['url5']) ? $attributes['url5'] : '';
    $urlText5 = isset($attributes['urlText5']) ? $attributes['urlText5'] : '';

    $sideContent = new DOMDocument();
    if (isset($attributes['sideContent']) && $attributes['sideContent'] != '') {
        $sideContent->loadHTML($attributes['sideContent']);
    }

    // data modification
    $sideList = array();
    foreach($sideContent->getElementsByTagName('li') as $node)
    {
        if ($defaultStyle) {
            $node->setAttribute('class', 'idsk-intro-block__side-menu__default__li');
            $link = $sideContent->createElement('p');

            while ($node->firstChild) {
                $link->appendChild($node->firstChild);
            }

            $node->appendChild($link);
        } else {
            $node->setAttribute('class', 'idsk-intro-block__side-menu__li');
        }

        foreach($node->getElementsByTagName('a') as $href)
        {
            if ($defaultStyle) {
                $href->setAttribute('class', 'govuk-link');
            } else {
                $href->setAttribute('class', 'idsk-intro-block__side-menu__a');
            }
        }
        
        $sideList[] = $sideContent->saveHTML($node);
    }

    ob_start(); // Turn on output buffering
    ?>

    <div data-module="idsk-intro-block">
        <div class="idsk-intro-block ">
            <div class="govuk-grid-row ">
                <div class="govuk-grid-column-full govuk-grid-column-two-thirds-from-desktop">
                    <h2 class="govuk-heading-l">
                        <?php echo $title ?>
                    </h2>
                    <p class="idsk-intro-block__subtitle govuk-caption-l"><?php echo $subTitle ?></p>
                    <?php if ($search) { ?>
                        <form role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <div class="idsk-intro-block__search">
                                <input class="govuk-input govuk-input--width-30 idsk-intro-block__input" name="s" type="search" placeholder="<?php _e('Zadajte hľadaný výraz', 'idsk-toolkit') ?>" aria-describedby="input-width-30-hint" value="<?php echo get_search_query(); ?>">
                                <button type="submit" class="govuk-button idsk-intro-block__search__button">
                                    <svg width="31" height="30" viewbox="0 0 31 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.0115 13.103C21.0115 17.2495 17.5484 20.6238 13.2928 20.6238C9.03714 20.6238 5.57404 17.2495 5.57404 13.103C5.57404 8.95643 9.03714 5.58212 13.2928 5.58212C17.5484 5.58212 21.0115 8.95643 21.0115 13.103ZM29.833 27.0702C29.833 26.4994 29.5918 25.9455 29.1955 25.5593L23.2858 19.8012C24.6814 17.8371 25.4223 15.4868 25.4223 13.103C25.4223 6.57259 19.995 1.28451 13.2928 1.28451C6.59058 1.28451 1.16333 6.57259 1.16333 13.103C1.16333 19.6333 6.59058 24.9214 13.2928 24.9214C15.7394 24.9214 18.1515 24.1995 20.1673 22.8398L26.077 28.5811C26.4732 28.984 27.0418 29.219 27.6276 29.219C28.8337 29.219 29.833 28.2453 29.833 27.0702Z" fill="white"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.75708 13.103C0.75708 6.35398 6.36621 0.888672 13.2928 0.888672C20.2194 0.888672 25.8285 6.35398 25.8285 13.103C25.8285 15.4559 25.1301 17.7778 23.8094 19.7516L29.4827 25.2794C29.9551 25.7396 30.2392 26.3943 30.2392 27.0702C30.2392 28.464 29.058 29.6149 27.6276 29.6149C26.9347 29.6149 26.2611 29.3385 25.787 28.8584L20.1168 23.3497C18.0909 24.6367 15.7078 25.3172 13.2928 25.3172C6.36621 25.3172 0.75708 19.8519 0.75708 13.103ZM13.2928 1.68034C6.81494 1.68034 1.56958 6.7912 1.56958 13.103C1.56958 19.4147 6.81494 24.5256 13.2928 24.5256C15.6581 24.5256 17.9892 23.8275 19.9361 22.5143L20.2144 22.3265L26.3704 28.3071C26.6886 28.6308 27.1506 28.8232 27.6276 28.8232C28.6093 28.8232 29.4267 28.0267 29.4267 27.0702C29.4267 26.6046 29.2285 26.1513 28.9082 25.8392L22.7588 19.8475L22.9518 19.5759C24.2996 17.679 25.016 15.4076 25.016 13.103C25.016 6.7912 19.7706 1.68034 13.2928 1.68034ZM13.2928 5.97796C9.26151 5.97796 5.98029 9.17504 5.98029 13.103C5.98029 17.0309 9.26151 20.228 13.2928 20.228C17.3241 20.228 20.6053 17.0309 20.6053 13.103C20.6053 9.17504 17.3241 5.97796 13.2928 5.97796ZM5.16779 13.103C5.16779 8.73781 8.81278 5.18629 13.2928 5.18629C17.7728 5.18629 21.4178 8.73781 21.4178 13.103C21.4178 17.4681 17.7728 21.0196 13.2928 21.0196C8.81278 21.0196 5.16779 17.4681 5.16779 13.103Z" fill="white"/>
                                    </svg>
                                </button>
                            </div>
                        </form>

                        <div>
                            <ul class="idsk-intro-block__list__ul">
                                <li class="idsk-intro-block__bottom-menu__li govuk-caption-l">
                                    <span><?php echo $searchTitle ?></span>
                                </li>
                                
                                <?php if ($urlText1 != '') { ?>
                                    <li class="idsk-intro-block__list__li">
                                        <a class="govuk-link idsk-intro-block__list__a" href="<?php echo $url1 ?>" title="<?php echo $urlText1 ?>">
                                            <?php echo $urlText1 ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                
                                <?php if ($urlText2 != '') { ?>
                                    <li class="idsk-intro-block__list__li">
                                        <a class="govuk-link idsk-intro-block__list__a" href="<?php echo $url2 ?>" title="<?php echo $urlText2 ?>">
                                            <?php echo $urlText2 ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                
                                <?php if ($urlText3 != '') { ?>
                                    <li class="idsk-intro-block__list__li">
                                        <a class="govuk-link idsk-intro-block__list__a" href="<?php echo $url3 ?>" title="<?php echo $urlText3 ?>">
                                            <?php echo $urlText3 ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                
                                <?php if ($urlText4 != '') { ?>
                                    <li class="idsk-intro-block__list__li">
                                        <a class="govuk-link idsk-intro-block__list__a" href="<?php echo $url4 ?>" title="<?php echo $urlText4 ?>">
                                            <?php echo $urlText4 ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                
                                <?php if ($urlText5 != '') { ?>
                                    <li class="idsk-intro-block__list__li">
                                        <a class="govuk-link idsk-intro-block__list__a" href="<?php echo $url5 ?>" title="<?php echo $urlText5 ?>">
                                            <?php echo $urlText5 ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
                <div class="<?php echo !$defaultStyle ? 'idsk-intro-block__side-menu' : '' ?>">
                        <div id="<?php echo $defaultStyle ? 'idsk-intro-block__side-menu__default' : 'idsk-intro-block__side-menu__title' ?>" class='govuk-grid-column-full govuk-grid-column-one-third-from-desktop <?php echo $sideStyle ?>'>
                            <h2 class="govuk-heading-l">
                                <?php echo $sideTitle ?>
                            </h2>
                            <?php echo $defaultStyle ? '<div class="idsk-intro-block__side-menu__default__subtitle">' : '' ?>
                                <ul class="<?php echo $defaultStyle ? 'idsk-intro-block__side-menu__default__ul' : 'idsk-intro-block__side-menu__ul' ?>">
                                
                                    <?php 
                                    foreach ($sideList as $key => $val) {
                                        echo $val;
                                    }
                                    ?>

                                </ul>
                            <?php echo $defaultStyle ? '</div>' : '' ?>
                        </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    ob_end_clean(); // Turn off ouput buffer

    return $output; // Print output
}