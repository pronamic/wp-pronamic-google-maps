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
	 * Bootstrap the Google Maps admin
	 */
	public static function bootstrap() {
		// Actions and hooks
		add_action( 'admin_init',            array( __CLASS__, 'initialize' ) );

		add_action( 'admin_menu',            array( __CLASS__, 'menu' ) );

		add_action( 'save_post',             array( __CLASS__, 'savePost' ) );

		add_action( 'wp_ajax_pgm_geocode',   array( __CLASS__, 'ajaxGeocode' ) );

		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueueScripts') );

		// Scripts
		wp_register_script(
			'pronamic-google-maps-admin',
			plugins_url( 'js/admin.js', Pronamic_Google_Maps_Maps::$file ),
			array( 'jquery', 'google-jsapi' )
		);

		// Styles
		wp_register_style(
			'pronamic-google-maps-admin',
			plugins_url( 'css/admin.css', Pronamic_Google_Maps_Maps::$file )
		);
	}

	//////////////////////////////////////////////////

	/**
	 * Enqueue scripts
	 */
	public static function enqueueScripts( $hook ) {
		$enqueue = false;

		if(in_array($hook, array('toplevel_page_pronamic-google-maps', 'google-maps_page_pronamic-google-maps-geocoder', 'widgets.php'))) {
			$enqueue = true;
		} elseif(in_array($hook, array('post-new.php', 'post.php'))) {
			$screen = get_current_screen();
	
			$options = Pronamic_Google_Maps_Maps::getOptions();
			$types = $options['active'];
			
			if(isset($types[$screen->post_type])) {
				$enqueue = $types[$screen->post_type];
			}
		} 

		if($enqueue) {
			wp_enqueue_script('pronamic-google-maps-admin');
			wp_enqueue_style('pronamic-google-maps-admin');
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the admin
	 */
	public static function initialize() {
		// Actions and hooks
		add_action('add_meta_boxes', array(__CLASS__, 'addMetaBox'));

		// Try to save the options if they are posted
		self::saveOptions();
	}

	//////////////////////////////////////////////////

	/**
	 * Admin menu
	 */
	public static function menu() {
		add_menu_page(
			$pageTitle = __('Google Maps', 'pronamic_google_maps') ,
			$menuTitle = __('Google Maps', 'pronamic_google_maps') ,
			$capability = 'manage_options' , 
			$menuSlug = Pronamic_Google_Maps_Maps::SLUG , 
			$function = array(__CLASS__, 'pageGeneral') , 
			// http://www.veryicon.com/icons/system/palm/google-maps.html
			$iconUrl = plugins_url('images/icon-16x16-v2.png', Pronamic_Google_Maps_Maps::$file)
		);

		// @see _add_post_type_submenus()
		// @see wp-admin/menu.php
		add_submenu_page(
			$parentSlug = Pronamic_Google_Maps_Maps::SLUG , 
			$pageTitle = __('Geocoder', 'pronamic_google_maps') , 
			$menuTitle = __('Geocoder', 'pronamic_google_maps') , 
			$capability = 'manage_options' , 
			$menuSlug = Pronamic_Google_Maps_Maps::SLUG . '-geocoder' , 
			$function = array(__CLASS__, 'pageGeocoder')
		);

		global $submenu;

		if(isset($submenu[Pronamic_Google_Maps_Maps::SLUG])) {
			$submenu[Pronamic_Google_Maps_Maps::SLUG][0][0] = __('General', 'pronamic_google_maps');
		}
	}

	/**
	 * Render general page
	 */
	public static function pageGeneral() {
		include plugin_dir_path(Pronamic_Google_Maps_Maps::$file) . 'views/page-general.php';
	}

	/**
	 * Render geocoder page
	 */
	public static function pageGeocoder() {
		include plugin_dir_path(Pronamic_Google_Maps_Maps::$file) . 'views/page-geocoder.php';
	}

	//////////////////////////////////////////////////

	/**
	 * Add the meta box
	 */
	public static function addMetaBox() {
		$options = Pronamic_Google_Maps_Maps::getOptions();

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
		$nonce = filter_input(INPUT_POST, Pronamic_Google_Maps_Maps::NONCE_NAME, FILTER_SANITIZE_STRING);

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
		
		// Original values
		$pgm = pronamic_get_google_maps_meta();

		// Active
		$active = filter_input(INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_ACTIVE, FILTER_VALIDATE_BOOLEAN);
		update_post_meta($postId, Pronamic_Google_Maps_Post::META_KEY_ACTIVE, $active ? 'true' : 'false');

		// Latitude
		$latitude = filter_input(INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_LATITUDE, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
		update_post_meta($postId, Pronamic_Google_Maps_Post::META_KEY_LATITUDE, $latitude);

		// Longitude
		$longitude = filter_input(INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_LONGITUDE, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
		update_post_meta($postId, Pronamic_Google_Maps_Post::META_KEY_LONGITUDE, $longitude);

		// Map type
		$mapType = filter_input(INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_MAP_TYPE, FILTER_SANITIZE_STRING);
		update_post_meta($postId, Pronamic_Google_Maps_Post::META_KEY_MAP_TYPE, $mapType);

		// Zoom
		$zoom = filter_input(INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_ZOOM, FILTER_SANITIZE_NUMBER_INT);
		update_post_meta($postId, Pronamic_Google_Maps_Post::META_KEY_ZOOM, $zoom);

		// Title
		$title = filter_input(INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_TITLE, FILTER_UNSAFE_RAW);
		$title = wp_kses_post($title);
		update_post_meta($postId, Pronamic_Google_Maps_Post::META_KEY_TITLE, $title);

		// Description
		$description = filter_input(INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_DESCRIPTION, FILTER_UNSAFE_RAW);
		$description = wp_kses_post($description);
		update_post_meta($postId, Pronamic_Google_Maps_Post::META_KEY_DESCRIPTION, $description);

		// Description
		$address = filter_input(INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_ADDRESS, FILTER_UNSAFE_RAW);
		$address = wp_kses_post($address);
		update_post_meta($postId, Pronamic_Google_Maps_Post::META_KEY_ADDRESS, $address);

		// Status
		if(!empty($latitude) && !empty($longitude)) {
			$status = Pronamic_Google_Maps_GeocoderStatus::OK;

			update_post_meta($postId, Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS, $status);
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Get the geocode query arguments
	 * 
	 * @return array
	 */
	public static function getGeocodeQueryArgs() {
		return array(
			'post_type'      => 'any', 
			'posts_per_page' => 1,
			'meta_query'     => array(
				// The address should not be empty
				array(
					'key'     => Pronamic_Google_Maps_Post::META_KEY_ADDRESS,
					'value'   => '',
					'compare' => '!='
				) , 
				// The geocoder status should not be OK
				array(
					'key'     => Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS,
					'value'   => array( Pronamic_Google_Maps_GeocoderStatus::OK, Pronamic_Google_Maps_GeocoderStatus::ZERO_RESULTS ),
					'compare' => 'NOT IN'
				) 
			)
		);
	}

	//////////////////////////////////////////////////

	/**
	 * AJAX geocode
	 */
	public static function ajaxGeocode() {
		// ID
		$postId = filter_input(INPUT_POST, 'post_ID', FILTER_SANITIZE_NUMBER_INT);

		// Latitude
		$latitude = filter_input(INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_LATITUDE, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
		update_post_meta($postId, Pronamic_Google_Maps_Post::META_KEY_LATITUDE, $latitude);

		// Longitude
		$longitude = filter_input(INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_LONGITUDE, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
		update_post_meta($postId, Pronamic_Google_Maps_Post::META_KEY_LONGITUDE, $longitude);

		// Status
		$status = filter_input(INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS, FILTER_SANITIZE_STRING);
		update_post_meta($postId, Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS, $status);

		// Result
		$result = new stdClass();
		$result->success = true;

		// Next post
		$query = new WP_Query();
		$query->query(Pronamic_Google_Maps_Admin::getGeocodeQueryArgs());

		$result->foundPosts = $query->found_posts;

		while($query->have_posts()) {
			$query->the_post();

			$pgm = pronamic_get_google_maps_meta();

			$result->nextPost = new stdClass();
			$result->nextPost->ID = get_the_ID();
			$result->nextPost->title = get_the_title();
			$result->nextPost->address = $pgm->address;
			$result->nextPost->latitude = $pgm->latitude;
			$result->nextPost->longitude = $pgm->longitude;
		}

		$response = json_encode($result);

		header('Content-Type: application/json');

		exit($response);
		
		/*
		 Queries to empty latitude, longitude and geocode status meta
		 UPDATE wp_postmeta SET meta_value = '' WHERE meta_key IN ('_pronamic_google_maps_latitude', '_pronamic_google_maps_longitude');
		 UPDATE wp_postmeta SET meta_value = '' WHERE meta_key = '_pronamic_google_maps_geocode_status';
		 */
	}

	//////////////////////////////////////////////////

	/**
	 * Save the options
	 */
	public static function saveOptions() {
		$action = filter_input(INPUT_POST, 'pronamic_google_maps_action', FILTER_SANITIZE_STRING);

		if($action == 'update' && check_admin_referer('pronamic_google_maps_update_options', Pronamic_Google_Maps_Maps::NONCE_NAME)) {
			$options = Pronamic_Google_Maps_Maps::getOptions();

			$active = array();

			$activeTypes = filter_input(INPUT_POST, '_pronamic_google_maps_active', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
			foreach($activeTypes as $type) {
				$active[$type] = true;
			}

			$options['active'] = $active;

			update_option(Pronamic_Google_Maps_Maps::OPTION_NAME, $options);
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
