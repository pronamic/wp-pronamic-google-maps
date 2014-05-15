<?php

/**
 * Title: Pronamic Google Maps site
 * Description:
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_Site {
	/**
	 * Flag for printing the scripts or not
	 *
	 * @deprecated
	 * @var boolean
	 */
	public static $printScripts = false;

	//////////////////////////////////////////////////

	/**
	 * Constructs and initliaze an Google Maps admin
	 */
	public static function bootstrap() {
		global $wp_version;

		// Actions and hooks
		if ( version_compare( $wp_version, '3.3', '<' ) ) {
			add_action( 'wp_footer', array( __CLASS__, 'printScripts' ) );
		}

		// Scripts
		wp_register_style(
			'pronamic_google_maps_fix' ,
			plugins_url( 'css/fix.css', Pronamic_Google_Maps_Maps::$file )
		);

		// Scripts
		wp_register_script(
			'pronamic_google_maps_site' ,
			plugins_url( 'js/site.js', Pronamic_Google_Maps_Maps::$file ),
			array( 'jquery', 'google-jsapi' )
		);

		// Settings
		$other_params_array = array(
			'sensor' => 'false',
		);

		$other_params_array  = apply_filters( 'pronamic_google_maps_load_other_params_array', $other_params_array );

		$other_params_string = _http_build_query( $other_params_array, null, '&' );

		$other_params_string  = apply_filters( 'pronamic_google_maps_load_other_params_string', $other_params_string );

		wp_localize_script( 'pronamic_google_maps_site', 'pronamic_google_maps_settings', array(
			'visualRefresh' => get_option( 'pronamic_google_maps_visual_refresh' ),
			'other_params'  => $other_params_string,
		) );
	}

	//////////////////////////////////////////////////

	/**
	 * Require site script
	 */
	public static function requireSiteScript() {
		self::$printScripts = true;

		// As of WordPress 3.3 wp_enqueue_script() can be called mid-page (in the HTML body).
		// This will load the script in the footer.
		wp_enqueue_script( 'pronamic_google_maps_site' );
	}

	//////////////////////////////////////////////////

	/**
	 * Print scripts
	 *
	 * @deprecated
	 */
	public static function printScripts() {
		if ( self::$printScripts ) {
			wp_print_scripts( 'pronamic_google_maps_site' );
		}
	}
}
