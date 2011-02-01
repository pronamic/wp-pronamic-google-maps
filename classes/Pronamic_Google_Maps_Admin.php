<?php

/**
 * Title: Pronamic Google Maps admin
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_Admin {
	/**
	 * Constructs and initliaze an Google Maps admin
	 */
	public static function bootstrap() {
		// Actions and hooks
		add_action('admin_init', array(__CLASS__, 'initialize'));

		add_action('save_post', array(__CLASS__, 'savePost'));

		// Scripts
		wp_enqueue_script(
			'pronamic-google-maps-admin' , 
			plugins_url('js/admin.js', Pronamic_Google_Maps::$file) , 
			array('google-maps', 'jquery')
		);

		// Styles
		wp_enqueue_style(
			'pronamic-google-maps-admin' , 
			plugins_url('css/admin.css', Pronamic_Google_Maps::$file)
		);

		// Other
		Pronamic_Google_Maps_OptionPage::bootstrap();
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the admin
	 */
	public static function initialize() {
		add_action('add_meta_boxes', array(__CLASS__, 'addMetaBox'));

		self::saveOptions();
	}

	//////////////////////////////////////////////////

	/**
	 * Add the meta box
	 */
	public static function addMetaBox() {
		$options = Pronamic_Google_Maps::getOptions();

		$types = $options['active'];

		foreach($types as $name => $active) {
			Pronamic_Google_Maps_MetaBox::register($name);
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Save the specified post (ID)
	 *
	 * @param int $postId
	 */
	public static function savePost($postId) {
		$nonce = filter_input(INPUT_POST, Pronamic_Google_Maps::NONCE_NAME, FILTER_SANITIZE_STRING);

		if(!wp_verify_nonce($nonce, 'save-post')) {
			return $postId;
		}

		if(self::doingAutosave()) {
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
	public static function saveOptions() {
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
	public static function doingAutosave() {
		return defined('DOING_AUTOSAVE') && DOING_AUTOSAVE;
	}
}
