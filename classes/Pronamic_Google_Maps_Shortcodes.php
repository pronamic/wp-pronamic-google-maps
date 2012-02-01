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
	const SHORTCODE_MAP = 'google-maps';

	/**
	 * The name of the shortcode
	 * 
	 * @var string
	 */
	const SHORTCODE_GEO = 'geo';

	//////////////////////////////////////////////////

	/**
	 * Bootstrap
	 */
	public static function bootstrap() {
		add_shortcode(self::SHORTCODE_MAP, array(__CLASS__, 'shortcodeMap'));
		add_shortcode(self::SHORTCODE_GEO, array(__CLASS__, 'shortcodeGeo'));
	}

	//////////////////////////////////////////////////

	/**
	 * Shortcode map
	 */
	public static function shortcodeMap($atts) {
		$atts['echo'] = false;

		return Pronamic_Google_Maps::render($atts);
	}

	//////////////////////////////////////////////////

	/**
	 * Shortcode map
	 */
	public static function shortcodeGeo($atts) {
		$atts['echo'] = false;

		return Pronamic_Google_Maps_GeoMicroformat::render($atts);
	}
}
