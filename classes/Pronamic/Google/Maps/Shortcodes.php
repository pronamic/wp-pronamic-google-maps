<?php

/**
 * Title: Pronamic Google Maps shortcodes
 * Description:
 * Copyright: Copyright (c) 2005 - 2015
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @doc http://codex.wordpress.org/Shortcode_API
 */
class Pronamic_Google_Maps_Shortcodes {
	/**
	 * Bootstrap
	 */
	public static function bootstrap() {
		add_shortcode( 'googlemaps',       array( __CLASS__, 'shortcode_map' ) );
		// The shortcode with hyphen is @deprecated
		add_shortcode( 'google-maps',      array( __CLASS__, 'shortcode_map_hyphen' ) );
		add_shortcode( 'geo',              array( __CLASS__, 'shortcode_geo' ) );
		add_shortcode( 'googlemapsmashup', array( __CLASS__, 'shortcode_mashup' ) );
	}

	//////////////////////////////////////////////////

	public static function parse_map_options( $atts ) {
		$map_options = array();

		if ( isset( $atts['map_options'] ) ) {
			$value = $atts['map_options'];

			if ( is_array( $value ) ) {
				$map_options = $value;
			} else {
				$map_options = json_decode( $value, true );
			}
		}

		$map_options_keys = array(
			'backgroundColor'        => FILTER_SANITIZE_STRING,
			// 'center' => ?,
			'disableDefaultUI'       => FILTER_VALIDATE_BOOLEAN,
			'disableDoubleClickZoom' => FILTER_VALIDATE_BOOLEAN,
			'draggable'              => FILTER_VALIDATE_BOOLEAN,
			'draggableCursor'        => FILTER_SANITIZE_STRING,
			'draggingCursor'         => FILTER_SANITIZE_STRING,
			'heading'                => FILTER_VALIDATE_INT,
			'keyboardShortcuts'      => FILTER_VALIDATE_BOOLEAN,
			'mapMaker'               => FILTER_VALIDATE_BOOLEAN,
			'mapTypeControl'         => FILTER_VALIDATE_BOOLEAN,
			// 'mapTypeControlOptions' => ?,
			'mapTypeId'              => FILTER_SANITIZE_STRING,
			'maxZoom'                => FILTER_VALIDATE_INT,
			'minZoom'                => FILTER_VALIDATE_INT,
			'noClear'                => FILTER_VALIDATE_BOOLEAN,
			'overviewMapControl'     => FILTER_VALIDATE_BOOLEAN,
			// 'overviewMapControlOptions' => ?,
			'panControl'             => FILTER_VALIDATE_BOOLEAN,
			// 'panControlOptions' => ?,
			'rotateControl'          => FILTER_VALIDATE_BOOLEAN,
			// 'rotateControlOptions' => ?,
			'scaleControl'           => FILTER_VALIDATE_BOOLEAN,
			// 'scaleControlOptions' => ?,
			'scrollwheel'            => FILTER_VALIDATE_BOOLEAN,
			// 'streetView' => ?,
			'streetViewControl'      => FILTER_VALIDATE_BOOLEAN,
			// 'streetViewControlOptions' => ?,
			// 'styles' => ?,
			'tilt'                   => FILTER_VALIDATE_INT,
			'zoom'                   => FILTER_VALIDATE_INT,
			'zoomControl'            => FILTER_VALIDATE_BOOLEAN,
			// 'zoomControlOptions' => ?
		);

		foreach ( $map_options_keys as $key => $filter ) {
			// Shortcode attributes are always lower case
			// @see http://core.trac.wordpress.org/browser/tags/3.5.1/wp-includes/shortcodes.php#L255
			$key_lower = strtolower( $key );

			if ( isset( $atts[ $key_lower ] ) ) {
				$map_options[ $key ] = filter_var( $atts[ $key_lower ], $filter );
			}
		}

		$atts['map_options'] = $map_options;

		return $atts;
	}

	public static function parse_marker_clusterer_options( $atts ) {
		$options = array();

		if ( isset( $atts['marker_clusterer_options'] ) ) {
			$value = $atts['marker_clusterer_options'];
			$value = html_entity_decode( $value );

			wp_parse_str( $value, $options );
		}

		// Transform numeric options into int or float
		foreach ( $options as $key => $option ) {
			if ( is_numeric( $option ) ) {
				$options[ $key ] = 0 + $option;
			}
		}

		$atts['marker_clusterer_options'] = $options;

		return $atts;
	}

	public static function parse_overlapping_marker_spiderfier_options( $atts ) {
		$options = array();

		if ( isset( $atts['overlapping_marker_spiderfier_options'] ) ) {
			$value = $atts['overlapping_marker_spiderfier_options'];
			$value = html_entity_decode( $value );

			wp_parse_str( $value, $options );
		}

		$atts['overlapping_marker_spiderfier_options'] = $options;

		return $atts;
	}

	//////////////////////////////////////////////////

	/**
	 * Shortcode map
	 */
	public static function shortcode_map( $atts ) {
		$atts = self::parse_map_options( $atts );
		$atts = self::parse_marker_clusterer_options( $atts );
		$atts = self::parse_overlapping_marker_spiderfier_options( $atts );

		$atts['echo'] = false;

		return Pronamic_Google_Maps_Maps::render( $atts );
	}

	/**
	 * Shortcode map hyphen
	 *
	 * @see http://codex.wordpress.org/Shortcode_API#Hyphens
	 * @deprecated 2.3
	 */
	public static function shortcode_map_hyphen( $atts ) {
		// _deprecated_function('Pronamic Google Maps shortcode [google-maps]', '2.3', 'Pronamic Google Maps shortcode [googlemaps]');

		return self::shortcode_map( $atts );
	}

	//////////////////////////////////////////////////

	/**
	 * Shortcode GEO
	 */
	public static function shortcode_geo( $atts ) {
		// Override echo
		$atts['echo'] = false;

		return Pronamic_Google_Maps_GeoMicroformat::render( $atts );
	}

	//////////////////////////////////////////////////

	/**
	 * Shortcode map
	 */
	public static function shortcode_mashup( $atts ) {
		$atts = wp_parse_args( $atts, array(
			'query' => array(),
		) );

		$atts = self::parse_map_options( $atts );
		$atts = self::parse_marker_clusterer_options( $atts );

		// Query
		$query = $atts['query'];

		if ( is_string( $query ) ) {
			$query = html_entity_decode( $query );
		}

		unset( $atts['$query'] );

		// Override echo
		$atts['echo'] = false;

		return Pronamic_Google_Maps_Mashup::render( $query, $atts );
	}
}
