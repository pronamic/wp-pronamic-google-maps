<?php

/**
 * Title: Pronamic Google Maps Option page
 * Description: 
 * Copyright: Copyright (c) 2005 - 2010
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_OptionPage {
	/**
	 * The page title for the option page
	 *
	 * @var string
	 */
	const PAGE_TITLE = 'Pronamic Google Maps';

	/**
	 * The menu title for the option page
	 *
	 * @var string
	 */
	const MENU_TITLE = 'Google Maps';

	//////////////////////////////////////////////////

	/**
	 * Constructs and initialize the option page
	 */
	public function __construct() {
		add_action('admin_menu', array(&$this, 'initialize'));
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the option page
	 */
	public function initialize() {
		$capability = 'edit_users';
		$slug = 'pronamic-google-maps';
		$function = array($this, 'render');

		add_options_page(self::PAGE_TITLE, self::MENU_TITLE, $capability, $slug, $function);
	}

	//////////////////////////////////////////////////

	/**
	 * Render the option page
	 */
	public function render() {
		include Pronamic_Google_Maps::$pluginPath . 'views/option-page.php';
	}
}
