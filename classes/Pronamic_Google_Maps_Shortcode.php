<?php

/**
 * Title: Pronamic Google Maps shortcode
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 * @doc http://codex.wordpress.org/Shortcode_API
 */
class Pronamic_Google_Maps_Shortcode {
	/**
	 * The name of the shortcode
	 * 
	 * @var string
	 */
	const NAME = 'google-maps';

	//////////////////////////////////////////////////

	/**
	 * Bootstrap
	 */
	public static function bootstrap() {
		add_shortcode(self::NAME, array(__CLASS__, 'render'));
	}

	//////////////////////////////////////////////////

	/**
	 * Render
	 */
	public static function render($atts) {
		$atts['echo'] = false;

		return Pronamic_Google_Maps::render($atts);
	}
}
