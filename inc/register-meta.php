<?php
/**
 * Custom metaboxes for posts and pages.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.6.0
 */

// Require meta boxes class.
require_once plugin_dir_path( __DIR__ ) . 'classes/class-idsk-meta-boxes.php';

/**
 * Add page meta boxes.
 */
new IDSK_Toolkit\IDSK_Meta_Boxes(
	array(
		array(
			'id'        => 'page_back_button',
			'title'     => __( 'Back button', 'idsk-toolkit' ),
			'post_type' => 'page',
			'args'      => array(
				'fields' => array(
					'text' => array(
						'type'  => 'text',
						'title' => __( 'Text for Back button', 'idsk-toolkit' ),
					),
					'url'  => array(
						'type'  => 'url',
						'title' => __( 'URL for Back button (if left empty, button will not show)', 'idsk-toolkit' ),
					),
				),
			),
		),
	)
);

/**
 * Add post meta boxes.
 */
new IDSK_Toolkit\IDSK_Meta_Boxes(
	array(
		array(
			'id'        => 'post_updates_list',
			'title'     => __( 'Updates list', 'idsk-toolkit' ),
			'post_type' => 'post',
			'args'      => array(
				'allow'    => __( 'Allow updates to be displayed', 'idsk-toolkit' ),
				'multiple' => true,
				'fields'   => array(
					'date' => array(
						'type'  => 'text',
						'title' => __( 'On (as date)', 'idsk-toolkit' ),
					),
					'desc' => array(
						'type'  => 'textarea',
						'title' => __( 'Detailed description', 'idsk-toolkit' ),
					),
				),
			),
		),
		array(
			'id'        => 'post_social',
			'title'     => __( 'Article sharing on social networks', 'idsk-toolkit' ),
			'post_type' => 'post',
			'args'      => array(
				'allow' => __( 'Allow article sharing on social networks', 'idsk-toolkit' ),
			),
		),
		array(
			'id'        => 'post_related_topics',
			'title'     => __( 'Related topics', 'idsk-toolkit' ),
			'post_type' => 'post',
			'args'      => array(
				'allow'    => __( 'Allow related topics to be displayed', 'idsk-toolkit' ),
				'multiple' => true,
				'fields'   => array(
					'title' => array(
						'type'  => 'text',
						'title' => __( 'Topic title', 'idsk-toolkit' ),
					),
					'url'   => array(
						'type'  => 'url',
						'title' => __( 'Link to topic', 'idsk-toolkit' ),
					),
				),
			),
		),
		array(
			'id'        => 'post_related_posts',
			'title'     => __( 'Related articles', 'idsk-toolkit' ),
			'post_type' => 'post',
			'args'      => array(
				'allow'    => __( 'Allow related articles to be displayed', 'idsk-toolkit' ),
				'multiple' => true,
				'fields'   => array(
					'id' => array(
						'type'        => 'select_posts',
						'title'       => __( 'Article', 'idsk-toolkit' ),
						'option_none' => __( 'Select article', 'idsk-toolkit' ),
					),
				),
			),
		),
	)
);
