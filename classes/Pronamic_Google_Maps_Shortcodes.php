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
	 * The name of the shortcode
	 * 
	 * @var string
	 */
	const SHORTCODE_MAP = 'googlemaps';

	/**
	 * The name of the shortcode
	 * 
	 * @var string
	 */
	const SHORTCODE_GEO = 'geo';

	/**
	 * The name of the shortcode
	 * 
	 * @var string
	 */
	const SHORTCODE_MASHUP = 'googlemapsmashup';

	//////////////////////////////////////////////////

	/**
	 * Bootstrap
	 */
	public static function bootstrap() {
		add_shortcode(self::SHORTCODE_MAP, array(__CLASS__, 'shortcodeMap'));
		add_shortcode('google-maps', array(__CLASS__, 'shortcodeMapHyphen'));

		add_shortcode(self::SHORTCODE_GEO, array(__CLASS__, 'shortcodeGeo'));
		add_shortcode(self::SHORTCODE_MASHUP, array(__CLASS__, 'shortcodeMashup'));
	}

	//////////////////////////////////////////////////

	/**
	 * Shortcode map
	 */
	public static function shortcodeMap($atts) {
		$atts['echo'] = false;

		return Pronamic_Google_Maps::render($atts);
	}

	/**
	 * Shortcode map hyphen
	 * 
	 * @deprecated 2.3
	 */
	public static function shortcodeMapHyphen($atts) {
		// _deprecated_function('Pronamic Google Maps shortcode [google-maps]', '2.3', 'Pronamic Google Maps shortcode [googlemaps]');

		return self::shortcodeMap($atts);
	}

	//////////////////////////////////////////////////

	/**
	 * Shortcode map
	 */
	public static function shortcodeGeo($atts) {
		// Override echo
		$atts['echo'] = false;

		return Pronamic_Google_Maps_GeoMicroformat::render($atts);
	}

	//////////////////////////////////////////////////

	/**
	 * Shortcode map
	 */
	public static function shortcodeMashup($atts) {
		$atts = wp_parse_args($atts, array(
			'query' => array()
		));

		// Query
		$query = $atts['query'];
		unset($atts['$query']);

		// Override echo
		$atts['echo'] = false;

		return Pronamic_Google_Maps_Mashup::render($query, $atts);
	}
}
