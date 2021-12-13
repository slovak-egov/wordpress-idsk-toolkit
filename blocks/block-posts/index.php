<?php
/**
 * BLOCK - posts - register dynamic block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.6.0
 */

function idsktk_register_dynamic_posts_block() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }

    // Hook server side rendering into render callback
    register_block_type('idsk/posts', array(
        'render_callback' => 'idsktk_render_dynamic_posts_block'
    ));
}
add_action('init', 'idsktk_register_dynamic_posts_block');

function idsktk_render_dynamic_posts_block($attributes) {
    // block attributes
    $title = isset($attributes['title']) ? $attributes['title'] : '';
    $showIntro = isset($attributes['showIntro']) && $attributes['showIntro'] ? $attributes['showIntro'] : TRUE;
    $postCount = isset($attributes['postCount']) ? $attributes['postCount'] : 4;
    $postCategory = isset($attributes['postCategory']) ? $attributes['postCategory'] : 0;

    $args = array(
        'ignore_sticky_posts'   => true,
        'post_type'             => 'post',
        'posts_per_page'        => $postCount
    );

    if ($postCategory > 0) {
        $args['cat'] = $postCategory;
    }

    $new_query = new WP_Query($args);

    ob_start(); // Turn on output buffering
    ?>

    <?php if ($title != '') { ?>
        <h2 class="govuk-heading-l"><?php echo wp_kses_post($title); ?></h2>
    <?php } ?>

    <?php if ($new_query->have_posts()) {
        $index = 0;

        while ($new_query->have_posts()) {
            $new_query->the_post();

            if (has_post_thumbnail()) {
                $image_link = get_the_post_thumbnail_url(null, 'full');
            } else {
                $image_link = plugin_dir_url(__DIR__) . '../assets/images/image-placeholder.jpg';
            }

            $post_data = array(
                'title'         => get_the_title(),
                'url'           => get_permalink(),
                'created'       => get_the_date(),
                'image'         => $image_link,
                'excerpt'       => get_the_excerpt(),
                'categories'    => get_the_category(),
            );

            if ($showIntro && $index == 0) { ?>
                <div class="govuk-grid-row">
                    <div class="govuk-grid-column-full">
                        <div class="idsk-card idsk-card-hero">
                            <a href="<?php echo esc_url($post_data['url']); ?>" title="<?php echo esc_attr($post_data['title']); ?>">
                                <img class="idsk-card-img idsk-card-img-hero" width="100%" src="<?php echo esc_url($image_link); ?>" alt="<?php echo esc_attr($post_data['title']); ?>" aria-hidden="true" />
                            </a>

                            <div class="idsk-card-content idsk-card-content-hero">
                                <div class="idsk-card-meta-container">
                                    <span class="idsk-card-meta idsk-card-meta-date">
                                        <a href="<?php echo esc_url($post_data['url']); ?>" class="govuk-link" title="<?php echo esc_attr( __( 'Pridané dňa:', 'idsk-toolkit' ).' '.$post_data['created'] ); ?>"><?php echo esc_html($post_data['created']); ?></a>
                                    </span>

                                    <?php foreach ($post_data['categories'] as $category) { ?>
                                        <span class="idsk-card-meta idsk-card-meta-tag">
                                            <a href="<?php echo esc_url(get_category_link($category)); ?>" class="govuk-link" title="<?php echo esc_attr($category->name); ?>"><?php echo esc_html($category->name); ?></a>
                                        </span>
                                    <?php } ?>
                                </div>

                                <div class="idsk-heading idsk-heading-hero">
                                    <a href="<?php echo esc_url($post_data['url']); ?>" class="idsk-card-title govuk-link" title="<?php echo esc_attr($post_data['title']); ?>"><?php echo wp_kses_post($post_data['title']); ?></a>
                                </div>

                                <p class="idsk-body idsk-body-hero"><?php echo wp_kses_post($post_data['excerpt']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
            } else {
                if ($index % 3 == 1 ) { ?>
                    <div class="govuk-grid-row">
                <?php } ?>

                <div class="govuk-grid-column-one-third">
                    <div class="idsk-card idsk-card-secondary">
                        <a href="<?php echo esc_url($post_data['url']); ?>" title="<?php echo esc_attr($post_data['title']); ?>">
                            <img class="idsk-card-img idsk-card-img-secondary" width="100%" src="<?php echo esc_url($image_link); ?>" alt="<?php echo esc_attr($post_data['title']); ?>" aria-hidden="true" />
                        </a>

                        <div class="idsk-card-content idsk-card-content-secondary">
                            <div class="idsk-card-meta-container">
                                <span class="idsk-card-meta idsk-card-meta-date">
                                    <a href="<?php echo esc_url($post_data['url']); ?>" class="govuk-link" title="<?php echo esc_attr( __( 'Pridané dňa:', 'idsk-toolkit' ).' '.$post_data['created'] ); ?>"><?php echo esc_html($post_data['created']); ?></a>
                                </span>

                                <?php foreach ($post_data['categories'] as $category) { ?>
                                    <span class="idsk-card-meta idsk-card-meta-tag">
                                        <a href="<?php echo esc_url(get_category_link($category)); ?>" class="govuk-link" title="<?php echo esc_attr($category->name); ?>"><?php echo esc_html($category->name); ?></a>
                                    </span>
                                <?php } ?>
                            </div>

                            <div class="idsk-heading idsk-heading-secondary">
                                <a href="<?php echo esc_url($post_data['url']); ?>" class="idsk-card-title govuk-link" title="<?php echo esc_attr($post_data['title']); ?>"><?php echo wp_kses_post($post_data['title']); ?></a>
                            </div>

                            <p class="idsk-body idsk-body-secondary"><?php echo wp_kses_post($post_data['excerpt']); ?></p>
                        </div>
                    </div>
                </div>

                <?php if ($index % 3 == 0 || $index + 1 == $new_query->post_count ) { ?>
                    </div>
                <?php }
            }

            $index++;
        }
    }

    /* END HTML OUTPUT */
    $output = ob_get_contents(); // collect output
    // wp_reset_postdata();
    ob_end_clean(); // Turn off ouput buffer

    return $output; // Print output
}