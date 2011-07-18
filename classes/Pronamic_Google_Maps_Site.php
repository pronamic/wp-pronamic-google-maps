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
	 * @var boolean
	 */
	public static $printScripts = false;

	//////////////////////////////////////////////////

	/**
	 * Constructs and initliaze an Google Maps admin
	 */
	public static function bootstrap() {
		// Actions and hooks
		add_action('wp_footer', array(__CLASS__, 'printScripts'));

		// Scripts
		wp_register_style(
			'pronamic-google-maps-fix' , 
			plugins_url('css/fix.css', Pronamic_Google_Maps::$file) 
		);

		// Scripts
		wp_register_script(
			'pronamic-google-maps-site' , 
			plugins_url('js/site.js', Pronamic_Google_Maps::$file) ,
			array('jquery', 'google-jsapi')
		);
	}

	//////////////////////////////////////////////////
	
	/**
	 * Print scripts
	 */
	public static function printScripts() {
		if(self::$printScripts) {
			wp_print_scripts('pronamic-google-maps-site');
		}
	}
}
