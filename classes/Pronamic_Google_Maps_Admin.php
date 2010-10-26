<?php

/**
 * Title: Pronamic Google Maps admin
 * Description: 
 * Copyright: Copyright (c) 2005 - 2010
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_Admin {
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
	 * Constructs and initliaze an Google Maps admin
	 */
	public function __construct() {
		add_action('admin_init', array($this, 'initialize'));
		add_action('save_post', array($this, 'savePost'));
		add_filter('plugin_action_links_' . Pronamic_Google_Maps::$baseName, array($this, 'actionLinks'));

		wp_enqueue_script(
			'pronamic-google-maps-admin' , 
			Pronamic_Google_Maps::$pluginUrl . 'js/admin.js' , 
			array('google-maps', 'jquery')
		);

		wp_register_style(
			'pronamic-google-maps-admin' , 
			Pronamic_Google_Maps::$pluginUrl . 'css/admin.css' 
		);

		add_action('admin_print_styles', array($this, 'printStyles'));
		
		new Pronamic_Google_Maps_OptionPage();
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the admin
	 */
	public function initialize() {
		add_action('add_meta_boxes', array($this, 'addMetaBox'));

		$this->saveOptions();
	}

	//////////////////////////////////////////////////

	/**
	 * Print styles
	 */
	public function printStyles() {
		wp_enqueue_style('pronamic-google-maps-admin');	
	}

	//////////////////////////////////////////////////

	/**
	 * Add the meta box
	 */
	public function addMetaBox() {
		$options = Pronamic_Google_Maps::getOptions();

		$types = $options['active'];
		foreach($types as $name => $active) {
			self::registerType($name);
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Register type
	 *
	 * @var string $type
	 */
	public static function registerType($type) {
		$metaBox = new Pronamic_Google_Maps_MetaBox();

		add_meta_box('pronamic_google_maps', __('Google Maps', Pronamic_Google_Maps::TEXT_DOMAIN), array($metaBox, 'render'), $type);
	}

	//////////////////////////////////////////////////

	/**
	 * Save the specified post (ID)
	 *
	 * @param int $postId
	 */
	public function savePost($postId) {
		$nonce = filter_input(INPUT_POST, Pronamic_Google_Maps::NONCE_NAME, FILTER_SANITIZE_STRING);

		if(!wp_verify_nonce($nonce, 'save-post')) {
			return $postId;
		}

		if($this->doingAutosave()) {
			return $postId;
		}

		if('page' == $_POST['post_type']) {
			if(!current_user_can('edit_page', $postId)) {
				return $postId;
			}
		} else {
			if(!current_user_can('edit_post', $postId)) {
				return $postId;
			}
		}

		$active = filter_input(INPUT_POST, Pronamic_Google_Maps::META_KEY_ACTIVE, FILTER_VALIDATE_BOOLEAN);
		$latitude = filter_input(INPUT_POST, Pronamic_Google_Maps::META_KEY_LATITUDE, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
		$longitude = filter_input(INPUT_POST, Pronamic_Google_Maps::META_KEY_LONGITUDE, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
		$mapType = filter_input(INPUT_POST, Pronamic_Google_Maps::META_KEY_MAP_TYPE, FILTER_SANITIZE_STRING);
		$zoom = filter_input(INPUT_POST, Pronamic_Google_Maps::META_KEY_ZOOM, FILTER_SANITIZE_NUMBER_INT);
		$title = filter_input(INPUT_POST, Pronamic_Google_Maps::META_KEY_TITLE, FILTER_SANITIZE_STRING);
		$description = filter_input(INPUT_POST, Pronamic_Google_Maps::META_KEY_DESCRIPTION, FILTER_SANITIZE_STRING);

		update_post_meta($postId, Pronamic_Google_Maps::META_KEY_ACTIVE, $active ? 'true' : 'false');
		update_post_meta($postId, Pronamic_Google_Maps::META_KEY_LATITUDE, $latitude);
		update_post_meta($postId, Pronamic_Google_Maps::META_KEY_LONGITUDE, $longitude);
		update_post_meta($postId, Pronamic_Google_Maps::META_KEY_MAP_TYPE, $mapType);
		update_post_meta($postId, Pronamic_Google_Maps::META_KEY_ZOOM, $zoom);
		update_post_meta($postId, Pronamic_Google_Maps::META_KEY_TITLE, $title);
		update_post_meta($postId, Pronamic_Google_Maps::META_KEY_DESCRIPTION, $description);
	}

	//////////////////////////////////////////////////

	/**
	 * Save the options
	 */
	public function saveOptions() {
		$action = filter_input(INPUT_POST, 'pronamic_google_maps_action', FILTER_SANITIZE_STRING);

		if($action == 'update' && check_admin_referer('pronamic_google_maps_update_options', Pronamic_Google_Maps::NONCE_NAME)) {
			$options = Pronamic_Google_Maps::getOptions();

			$active = array();

			$activeTypes = filter_input(INPUT_POST, '_pronamic_google_maps_active', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
			foreach($activeTypes as $type) {
				$active[$type] = true;
			}

			$options['active'] = $active;

			update_option(Pronamic_Google_Maps::OPTION_NAME, $options);
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Checks if there is autosave in progress
	 *
	 * @return boolean true if autosave is in progress, false otherwise
	 */
	public function doingAutosave() {
		return defined('DOING_AUTOSAVE') && DOING_AUTOSAVE;
	}

	//////////////////////////////////////////////////

	/**
	 * Action links 
	 * 
	 * @param array $links
	 * @param string $file
	 */
	public function actionLinks($links) {
		$url = admin_url('options-general.php?page=' . Pronamic_Google_Maps_OptionPage::SLUG);

		$link = '<a href="' . $url . '">' . __('Settings') . '</a>';

		array_unshift($links, $link);

		return $links;
	}
}
