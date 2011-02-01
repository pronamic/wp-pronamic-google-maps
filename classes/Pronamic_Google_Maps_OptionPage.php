<?php

/**
 * Title: Pronamic Google Maps option page
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_OptionPage {
	/**
	 * The option page slug
	 * 
	 * @var string
	 */
	const SLUG = 'pronamic-google-maps';

	/**
	 * The required capability for this options page
	 *
	 * @var string
	 */
	const CAPABILITY = 'manage_options';

	//////////////////////////////////////////////////

	/**
	 * Bootstrap the option page
	 */
	public static function bootstrap() {
		// Actions and hooks
		add_action('admin_menu', array(__CLASS__, 'initialize'));
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the option page
	 */
	public static function initialize() {
		add_options_page(
			__('Pronamic Google Maps', Pronamic_Google_Maps::TEXT_DOMAIN) , // page title
			__('Google Maps', Pronamic_Google_Maps::TEXT_DOMAIN) , // menu title
			self::CAPABILITY , 
			self::SLUG , 
			array(__CLASS__, 'render')
		);
	}

	//////////////////////////////////////////////////

	/**
	 * Render the option page
	 */
	public static function render() {
		include plugin_dir_path(Pronamic_Google_Maps::$file) . 'views/option-page.php';
	}
}
