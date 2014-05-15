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

	public static $pronamic_google_maps_settings;

	/**
	 * Bootstrap the Google Maps admin
	 */
	public static function bootstrap() {
		// Actions and hooks
		add_action( 'admin_init',            array( __CLASS__, 'initialize' ) );

		add_action( 'admin_menu',            array( __CLASS__, 'menu' ) );

		add_action( 'save_post',             array( __CLASS__, 'savePost' ) );

		add_action( 'wp_ajax_pgm_geocode',   array( __CLASS__, 'ajaxGeocode' ) );

		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueueScripts' ) );

		// Scripts
		wp_register_script(
			'pronamic_google_maps_admin',
			plugins_url( 'js/admin.js', Pronamic_Google_Maps_Maps::$file ),
			array( 'jquery', 'google-jsapi' )
		);

		// Styles
		wp_register_style(
			'pronamic_google_maps_admin',
			plugins_url( 'css/admin.css', Pronamic_Google_Maps_Maps::$file )
		);

		// Add the localization for giving the settings.
		wp_localize_script( 'pronamic_google_maps_admin', 'pronamic_google_maps_settings', array(
			'visualRefresh' => get_option( 'pronamic_google_maps_visual_refresh' )
		) );

		// Load the Settings Class
		self::$pronamic_google_maps_settings = new Pronamic_Google_Maps_Settings();
	}

	//////////////////////////////////////////////////

	/**
	 * Enqueue scripts
	 */
	public static function enqueueScripts( $hook ) {
		$enqueue = false;

		$enqueue_shooks = array(
			// Pronamic Google Maps
			'toplevel_page_pronamic_google_maps',
			// Geocoder
			'google-maps_page_pronamic_google_maps_geocoder',
			// Widgets
			'widgets.php',
			// Shopp products edit page
			'toplevel_page_shopp-products',
		);

		if ( in_array( $hook, $enqueue_shooks ) ) {
			$enqueue = true;
		} elseif ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) {
			$screen = get_current_screen();

			$types = Pronamic_Google_Maps_Settings::get_active_post_types();

			if ( isset( $types[ $screen->post_type ] ) ) {
				$enqueue = $types[ $screen->post_type ];
			}
		}

		if ( $enqueue ) {
			wp_enqueue_script( 'pronamic_google_maps_admin' );
			wp_enqueue_style( 'pronamic_google_maps_admin' );
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the admin
	 */
	public static function initialize() {
		// Actions and hooks
		add_action( 'add_meta_boxes', array( __CLASS__, 'addMetaBox' ) );
	}

	//////////////////////////////////////////////////

	/**
	 * Admin menu
	 */
	public static function menu() {
		add_menu_page(
			__( 'Google Maps', 'pronamic_google_maps' ), // page title
			__( 'Google Maps', 'pronamic_google_maps' ), // menu title
			'manage_options', // capability
			'pronamic_google_maps', // menu slug
			array( __CLASS__, 'pageGeneral' ), // function
			// http://www.veryicon.com/icons/system/palm/google-maps.html
			plugins_url( 'images/icon-16x16-v2.png', Pronamic_Google_Maps_Maps::$file ) // icon url
		);

		// @see _add_post_type_submenus()
		// @see wp-admin/menu.php
		add_submenu_page(
			'pronamic_google_maps', // parent slug
			__( 'Geocoder', 'pronamic_google_maps' ), // page title
			__( 'Geocoder', 'pronamic_google_maps' ), // menu title
			'manage_options', // capability
			'pronamic_google_maps_geocoder', // menu slug
			array( __CLASS__, 'pageGeocoder' ) // function
		);

		global $submenu;

		if ( isset( $submenu['pronamic_google_maps'] ) ) {
			$submenu['pronamic_google_maps'][0][0] = __( 'General', 'pronamic_google_maps' );
		}
	}

	/**
	 * Render general page
	 */
	public static function pageGeneral() {
		include plugin_dir_path( Pronamic_Google_Maps_Maps::$file ) . 'views/page-general.php';
	}

	/**
	 * Render geocoder page
	 */
	public static function pageGeocoder() {
		include plugin_dir_path( Pronamic_Google_Maps_Maps::$file ) . 'views/page-geocoder.php';
	}

	//////////////////////////////////////////////////

	/**
	 * Add the meta box
	 */
	public static function addMetaBox() {
		$options = Pronamic_Google_Maps_Maps::getOptions();

		if ( isset( $options['active'] ) ) {
			$types = $options['active'];

			if ( is_array( $types ) ) {
				foreach ( $types as $name => $active ) {
					Pronamic_Google_Maps_MetaBox::register( $name );
				}
			}
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Update post meta, only store post meta when there is meta to store
	 * @see http://core.trac.wordpress.org/browser/tags/3.4.2/wp-includes/post.php#L1533
	 *
	 * @param string $post_id
	 * @param string $meta_key
	 * @param string $meta_value
	 * @param string $prev_value
	 */
	public static function update_post_meta( $post_id, $meta_key, $meta_value, $prev_value = '' ) {
		if ( empty( $meta_value ) ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
			update_post_meta( $post_id, $meta_key, $meta_value, $prev_value );
		}
	}

	/**
	 * Save the specified post (ID)
	 *
	 * @param int $postId
	 */
	public static function savePost( $post_id ) {
		$nonce = filter_input( INPUT_POST, Pronamic_Google_Maps_Maps::NONCE_NAME, FILTER_SANITIZE_STRING );

		if ( ! wp_verify_nonce( $nonce, 'save-post' ) ) {
			return $post_id;
		}

		if ( self::doingAutosave() ) {
			return $post_id;
		}

		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		// Original values
		$pgm = pronamic_get_google_maps_meta();

		// Active
		$active = filter_input( INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_ACTIVE, FILTER_VALIDATE_BOOLEAN );
		self::update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_ACTIVE, $active ? 'true' : null );

		// Latitude
		$latitude = filter_input( INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_LATITUDE, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		self::update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_LATITUDE, $latitude );

		// Longitude
		$longitude = filter_input( INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_LONGITUDE, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		self::update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_LONGITUDE, $longitude );

		// Map type
		$map_type = filter_input( INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_MAP_TYPE, FILTER_SANITIZE_STRING );
		self::update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_MAP_TYPE, $map_type == Pronamic_Google_Maps_Maps::MAP_TYPE_DEFAULT ? null : $map_type );

		// Zoom
		$zoom = filter_input( INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_ZOOM, FILTER_SANITIZE_NUMBER_INT );
		self::update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_ZOOM, $zoom == Pronamic_Google_Maps_Maps::MAP_ZOOM_DEFAULT ? null : $zoom );

		// Title
		$title = filter_input( INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_TITLE, FILTER_UNSAFE_RAW );
		$title = wp_kses_post( $title );
		self::update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_TITLE, $title );

		// Description
		$description = filter_input( INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_DESCRIPTION, FILTER_UNSAFE_RAW );
		$description = wp_kses_post( $description );
		self::update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_DESCRIPTION, $description );

		// Description
		$address = filter_input( INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_ADDRESS, FILTER_UNSAFE_RAW );
		$address = wp_kses_post( $address );
		self::update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_ADDRESS, $address );

		// Status
		if ( ! empty( $latitude ) && ! empty( $longitude ) ) {
			$status = Pronamic_Google_Maps_GeocoderStatus::OK;

			self::update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS, $status );
		} else {
			self::update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS, null );
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
			'posts_per_page' => -1,
			'meta_query'     => array(
				// The address should not be empty
				array(
					'key'     => Pronamic_Google_Maps_Post::META_KEY_ADDRESS,
					'value'   => '',
					'compare' => '!=',
				),
				// The geocoder status should not be OK
				array(
					'key'     => Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS,
					'value'   => null,
					'compare' => 'NOT EXISTS',
				),
			),
		);
	}

	//////////////////////////////////////////////////

	/**
	 * AJAX geocode
	 */
	public static function ajaxGeocode() {
		// ID
		$post_id = filter_input( INPUT_POST, 'post_ID', FILTER_SANITIZE_NUMBER_INT );

		// Latitude
		$latitude = filter_input( INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_LATITUDE, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_LATITUDE, $latitude );

		// Longitude
		$longitude = filter_input( INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_LONGITUDE, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_LONGITUDE, $longitude );

		// Status
		$status = filter_input( INPUT_POST, Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS, FILTER_SANITIZE_STRING );
		update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS, $status );

		// Result
		$result = new stdClass();
		$result->success = true;

		// Next post
		$query = new WP_Query();
		$query->query( Pronamic_Google_Maps_Admin::getGeocodeQueryArgs() );

		$result->foundPosts = $query->found_posts;

		while ( $query->have_posts() ) {
			$query->the_post();

			$pgm = pronamic_get_google_maps_meta();

			$result->nextPost = new stdClass();
			$result->nextPost->ID        = get_the_ID();
			$result->nextPost->title     = get_the_title();
			$result->nextPost->address   = $pgm->address;
			$result->nextPost->latitude  = $pgm->latitude;
			$result->nextPost->longitude = $pgm->longitude;
		}

		$response = json_encode( $result );

		header( 'Content-Type: application/json' );

		exit( $response );

		/*
		 Queries to empty latitude, longitude and geocode status meta
		 UPDATE wp_postmeta SET meta_value = '' WHERE meta_key IN ('_pronamic_google_maps_latitude', '_pronamic_google_maps_longitude');
		 UPDATE wp_postmeta SET meta_value = '' WHERE meta_key = '_pronamic_google_maps_geocode_status';
		 */
	}

	//////////////////////////////////////////////////

	/**
	 * Checks if there is autosave in progress
	 *
	 * @return boolean true if autosave is in progress, false otherwise
	 */
	public static function doingAutosave() {
		return defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE;
	}
}
