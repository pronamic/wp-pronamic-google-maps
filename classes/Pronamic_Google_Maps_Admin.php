<?php

/**
 * Title: Pronamic Google Maps Admin
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
		add_action('admin_head', array($this, 'renderHead'));
		add_action('save_post', array($this, 'savePost'));

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

		add_meta_box('pronamic_google_maps', __('Google Maps', Pronamic_Google_Maps::TEXT_DOMAIN), array($metaBox, 'render'), $name);
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
		$title = filter_input(INPUT_POST, Pronamic_Google_Maps::META_KEY_TITLE, FILTER_SANITIZE_STRING);
		$description = filter_input(INPUT_POST, Pronamic_Google_Maps::META_KEY_DESCRIPTION, FILTER_SANITIZE_STRING);

		update_post_meta($postId, Pronamic_Google_Maps::META_KEY_ACTIVE, $active ? 'true' : 'false');
		update_post_meta($postId, Pronamic_Google_Maps::META_KEY_LATITUDE, $latitude);
		update_post_meta($postId, Pronamic_Google_Maps::META_KEY_LONGITUDE, $longitude);
		update_post_meta($postId, Pronamic_Google_Maps::META_KEY_TITLE, $title);
		update_post_meta($postId, Pronamic_Google_Maps::META_KEY_DESCRIPTION, $description);
	}

	//////////////////////////////////////////////////

	/**
	 * Save the options
	 */
	public function saveOptions() {
		$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

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
	 * Render the admin head
	 */
	public function renderHead() {
		include Pronamic_Google_Maps::$pluginPath . 'views/admin-head.php';
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
}
