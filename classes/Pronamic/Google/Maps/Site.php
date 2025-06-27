<?php

/**
 * Title: Pronamic Google Maps site
 * Description:
 * Copyright: Copyright (c) 2005 - 2015
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_Google_Maps_Site {
	/**
	 * Constructs and initliaze an Google Maps admin
	 */
	public static function bootstrap() {
		// Scripts
		wp_register_style(
			'pronamic_google_maps_fix',
			plugins_url( 'css/fix.css', Pronamic_Google_Maps_Maps::$file ),
			[],
			\hash_file( 'crc32b', plugin_dir_path( Pronamic_Google_Maps_Maps::$file ) . 'css/fix.css' )
		);

		// Scripts
		wp_register_script(
			'pronamic_google_maps_site',
			plugins_url( 'js/site.js', Pronamic_Google_Maps_Maps::$file ),
			[ 'jquery', 'google-maps' ],
			\hash_file( 'crc32b', plugin_dir_path( Pronamic_Google_Maps_Maps::$file ) . 'js/site.js' ),
			true
		);

		// Settings
		$other_params_array = [];

		$other_params_array = apply_filters( 'pronamic_google_maps_load_other_params_array', $other_params_array );

		$other_params_string = _http_build_query( $other_params_array, null, '&' );

		$other_params_string = apply_filters( 'pronamic_google_maps_load_other_params_string', $other_params_string );

		wp_localize_script(
			'pronamic_google_maps_site',
			'pronamic_google_maps_settings',
			[
				'other_params' => $other_params_string,
			]
		);
	}

	/**
	 * Require site script
	 */
	public static function require_site_script() {
		wp_enqueue_script( 'pronamic_google_maps_site' );
	}
}
