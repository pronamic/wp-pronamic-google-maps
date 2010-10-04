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
	 * The option page slug
	 * 
	 * @var string
	 */
	const SLUG = 'pronamic-google-maps';

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
		add_action('admin_menu', array($this, 'initialize'));
		add_action('admin_print_scripts', array($this,'printScripts'));
		add_action('admin_print_styles', array($this,'printStyles'));
	}

	//////////////////////////////////////////////////

	/**
	 * Check if this options page is active
	 * 
	 * @return boolean true if active, false otherwise
	 */
	public function isActive() {
		$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

		return $page == self::SLUG;
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the option page
	 */
	public function initialize() {
		$capability = 'edit_users';
		$function = array($this, 'render');

		add_options_page(self::PAGE_TITLE, self::MENU_TITLE, $capability, self::SLUG, $function);
	}

	//////////////////////////////////////////////////

	/**
	 * Print scripts
	 */
	public function printScripts() {
		if($this->isActive()) {
			wp_enqueue_script('postbox');
			wp_enqueue_script('dashboard');
			wp_enqueue_script('thickbox');
			wp_enqueue_script('media-upload');
		}
	}

	/**
	 * Print styles
	 */
	public function printStyles() {
		if($this->isActive()) {
			wp_enqueue_style('dashboard');
			wp_enqueue_style('thickbox');
			wp_enqueue_style('global');
			wp_enqueue_style('wp-admin');
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Render the option page
	 */
	public function render() {
		include Pronamic_Google_Maps::$pluginPath . 'views/option-page.php';
	}
}
