<?php

/**
 * Title: Pronamic Google Maps meta box
 * Description: 
 * Copyright: Copyright (c) 2005 - 2010
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_MetaBox {
	/**
	 * Constructs and initialize the Google Maps meta box
	 */
	public function __construct() {
		
	}

	//////////////////////////////////////////////////

	/**
	 * Render the option page
	 */
	public function render() {
		include Pronamic_Google_Maps::$pluginPath . 'views/meta-box.php';
	}
}
