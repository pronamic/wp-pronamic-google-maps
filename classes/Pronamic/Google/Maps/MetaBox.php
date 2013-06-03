<?php

/**
 * Title: Pronamic Google Maps meta box
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_MetaBox {
	/**
	 * The id of this meta box
	 * 
	 * @var string
	 */
	const ID = 'pronamic-google-maps-meta-box';

	//////////////////////////////////////////////////

	/**
	 * Register this meta box on the specified page
	 */
	public static function register($page, $context = 'advanced', $priority = 'default') {
		add_meta_box(
			self::ID , 
			__('Google Maps', 'pronamic_google_maps') , 
			array(__CLASS__, 'render') , 
			$page , 
			$context , 
			$priority
		);
	}

	//////////////////////////////////////////////////

	/**
	 * Render the option page
	 */
	public static function render() {
		include plugin_dir_path(Pronamic_Google_Maps_Maps::$file) . 'views/meta-box.php';
	}
}
