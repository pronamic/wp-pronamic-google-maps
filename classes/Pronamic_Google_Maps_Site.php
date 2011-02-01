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
		

		// Scripts
		wp_enqueue_script(
			'pronamic-google-maps' , 
			plugins_url('js/site.js', Pronamic_Google_Maps::$file) ,
			array('google-maps', 'jquery')
		);

		// Styles
		
	}
}
