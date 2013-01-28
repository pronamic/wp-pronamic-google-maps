<?php

/**
 * Title: Pronamic Google Maps shortcodes
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
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

	/**
	 * Shortcode map
	 */
	public static function shortcode_map( $atts ) {
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
			'query' => array()
		) );

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
