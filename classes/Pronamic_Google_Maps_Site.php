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
	 * Constructs and initliaze an Google Maps admin
	 */
	public static function bootstrap() {
		// Actions and hooks
		add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueueScripts'));

		// Scripts
		wp_register_script(
			'pronamic-google-maps-site' , 
			plugins_url('js/site.js', Pronamic_Google_Maps::$file) ,
			array('google-maps', 'jquery')
		);

		// Styles
		
	}
	
	/**
	 * Enqueue scripts
	 */
	public static function enqueueScripts() {
		if(is_singular()) {
			if(pronamic_google_maps_is_active()) {
				wp_enqueue_script('pronamic-google-maps-site');
			}
		} else {
			wp_enqueue_script('pronamic-google-maps-site');
		}
	}
}
