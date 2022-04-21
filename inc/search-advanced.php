<?php
/**
 * Advanced search functionality.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.4.0
 */

if ( ! function_exists( 'idsktk_query_format_date' ) ) {
	/**
	 * Format date for query.
	 *
	 * @param string $date Date to format.
	 *
	 * @return array
	 */
	function idsktk_query_format_date( $date ) {
		$date_array  = explode( '.', $date );
		$date_output = array();

		if ( 1 === count( $date_array ) ) {
			$date_output = array(
				'year' => $date_array[0],
			);
		} elseif ( 3 === count( $date_array ) ) {
			$date_output = array(
				'year'  => $date_array[2],
				'month' => $date_array[1],
				'day'   => $date_array[0],
			);
		}

		return $date_output;
	}
}

/**
 * Custom query variables.
 *
 * @param string[] $qvars The array of allowed query variable names.
 *
 * @return string[]
 */
function idsktk_query_vars( $qvars ) {
	$qvars[] = 'scat';
	$qvars[] = 'tags';
	$qvars[] = 'datum-od';
	$qvars[] = 'datum-do';
	return $qvars;
}
add_filter( 'query_vars', 'idsktk_query_vars' );

/**
 * Set custom query.
 *
 * @param WP_Query $query The WP_Query instance.
 */
function idsktk_advanced_search_query( $query ) {
	if ( ! is_admin() && $query->is_search && $query->is_main_query() ) {
		// Store query params.
		$search_string = get_query_var( 's' );
		$order         = get_query_var( 'order' );
		$order_by      = get_query_var( 'orderby' );
		$category      = get_query_var( 'cat' );
		$sub_category  = get_query_var( 'scat' );
		$date_from     = get_query_var( 'datum-od' );
		$date_to       = get_query_var( 'datum-do' );
		// Get tags array.
		$tags = get_query_var( 'tags' );
		// Query arrays.
		$tax_query  = array();
		$date_query = array();

		// Set up query params.
		$query->set( 'posts_per_page', -1 );

		if ( ! empty( $search_string ) ) {
			$query->set( 's', $search_string );
		}

		if ( ! empty( $order ) ) {
			$query->set( 'order', $order );
		} elseif ( empty( $order ) && empty( $order_by ) ) {
			$query->set( 'order', 'DESC' );
		}

		if ( ! empty( $order_by ) ) {
			$query->set( 'orderby', $order_by );
		}

		// Categories.
		if ( ! empty( $category ) || ! empty( $sub_category ) ) {
			$tax_query = array(
				! empty( $category ) ?
					array(
						'taxonomy' => 'category',
						'field'    => 'id',
						'terms'    => $category,
					) : '',
				! empty( $sub_category ) ?
					array(
						'taxonomy' => 'category',
						'field'    => 'id',
						'terms'    => $sub_category,
					) : '',
			);
			$query->set( 'tax_query', $tax_query );
		}

		// Tags.
		if ( ! empty( $tags ) && '' !== $tags[0] ) {
			$query->set( 'tag__and', $tags );
		}

		// Dates.
		if ( ! empty( $date_from ) || ! empty( $date_to ) ) {
			$date_query = array(
				'column' => 'post_modified',
			);

			if ( ! empty( $date_from ) ) {
				$date_query['after'] = idsktk_query_format_date( $date_from );
			}

			if ( ! empty( $date_to ) ) {
				$date_query['before'] = idsktk_query_format_date( $date_to );
			}
		}

		// Set date_query.
		if ( count( $date_query ) > 0 ) {
			$query->set( 'date_query', $date_query );
		}
	}
}
add_action( 'pre_get_posts', 'idsktk_advanced_search_query' );
