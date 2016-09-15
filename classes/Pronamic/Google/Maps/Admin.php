<?php

/**
 * Title: Pronamic Google Maps admin
 * Description:
 * Copyright: Copyright (c) 2005 - 2015
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_Google_Maps_Admin {
	public static $pronamic_google_maps_settings;

	/**
	 * Bootstrap the Google Maps admin
	 */
	public static function bootstrap() {
		// Actions and hooks
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );

		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );

		add_action( 'save_post', array( __CLASS__, 'save_post' ) );

		add_action( 'wp_ajax_pgm_geocode',   array( __CLASS__, 'ajax_geocode' ) );

		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue_scripts' ) );

		// Scripts
		wp_register_script(
			'pronamic-google-maps-admin',
			plugins_url( 'js/admin.js', Pronamic_Google_Maps_Maps::$file ),
			array( 'jquery', 'google-maps' ),
			'2.3.0',
			true
		);

		// Styles
		wp_register_style(
			'pronamic-google-maps-admin',
			plugins_url( 'css/admin.css', Pronamic_Google_Maps_Maps::$file ),
			array(),
			'2.3.0'
		);

		// Add the localization for giving the settings.
		wp_localize_script(
			'pronamic-google-maps-admin',
			'pronamic_google_maps_settings',
			array(
				'visualRefresh' => get_option( 'pronamic_google_maps_visual_refresh' ),
			)
		);

		// Load the Settings Class
		self::$pronamic_google_maps_settings = new Pronamic_Google_Maps_Settings();
	}

	//////////////////////////////////////////////////

	/**
	 * Enqueue scripts
	 */
	public static function admin_enqueue_scripts( $hook ) {
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

		if ( in_array( $hook, $enqueue_shooks, true ) ) {
			$enqueue = true;
		} elseif ( in_array( $hook, array( 'post-new.php', 'post.php' ), true ) ) {
			$screen = get_current_screen();

			$types = Pronamic_Google_Maps_Settings::get_active_post_types();

			if ( isset( $types[ $screen->post_type ] ) ) {
				$enqueue = $types[ $screen->post_type ];
			}
		}

		if ( $enqueue ) {
			wp_enqueue_script( 'pronamic-google-maps-admin' );
			wp_enqueue_style( 'pronamic-google-maps-admin' );
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the admin
	 */
	public static function admin_init() {
		// Actions and hooks
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
	}

	//////////////////////////////////////////////////

	/**
	 * Admin menu
	 */
	public static function admin_menu() {
		add_menu_page(
			__( 'Google Maps', 'pronamic-google-maps' ), // page title
			__( 'Google Maps', 'pronamic-google-maps' ), // menu title
			'manage_options', // capability
			'pronamic_google_maps', // menu slug
			array( __CLASS__, 'page_general' ), // function
			// http://www.veryicon.com/icons/system/palm/google-maps.html
			plugins_url( 'images/icon-16x16-v2.png', Pronamic_Google_Maps_Maps::$file ) // icon url
		);

		// @see _add_post_type_submenus()
		// @see wp-admin/menu.php
		add_submenu_page(
			'pronamic_google_maps', // parent slug
			__( 'Geocoder', 'pronamic-google-maps' ), // page title
			__( 'Geocoder', 'pronamic-google-maps' ), // menu title
			'manage_options', // capability
			'pronamic_google_maps_geocoder', // menu slug
			array( __CLASS__, 'page_geocoder' ) // function
		);

		global $submenu;

		if ( isset( $submenu['pronamic_google_maps'] ) ) {
			$submenu['pronamic_google_maps'][0][0] = __( 'Settings', 'pronamic-google-maps' );
		}
	}

	/**
	 * Render general page
	 */
	public static function page_general() {
		include plugin_dir_path( Pronamic_Google_Maps_Maps::$file ) . 'views/page-general.php';
	}

	/**
	 * Render geocoder page
	 */
	public static function page_geocoder() {
		include plugin_dir_path( Pronamic_Google_Maps_Maps::$file ) . 'views/page-geocoder.php';
	}

	//////////////////////////////////////////////////

	/**
	 * Add the meta box
	 */
	public static function add_meta_boxes() {
		$options = Pronamic_Google_Maps_Maps::get_options();

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
	 *
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
	public static function save_post( $post_id ) {
		$nonce = filter_input( INPUT_POST, Pronamic_Google_Maps_Maps::NONCE_NAME, FILTER_SANITIZE_STRING );

		if ( ! wp_verify_nonce( $nonce, 'save-post' ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( 'page' === get_post_type( $post_id ) ) {
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
		$active = filter_input( INPUT_POST, '_pronamic_google_maps_active', FILTER_VALIDATE_BOOLEAN );
		self::update_post_meta( $post_id, '_pronamic_google_maps_active', $active ? 'true' : null );

		// Latitude
		$latitude = filter_input( INPUT_POST, '_pronamic_google_maps_latitude', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		self::update_post_meta( $post_id, '_pronamic_google_maps_latitude', $latitude );

		// Longitude
		$longitude = filter_input( INPUT_POST, '_pronamic_google_maps_longitude', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		self::update_post_meta( $post_id, '_pronamic_google_maps_longitude', $longitude );

		// Map type
		$map_type = filter_input( INPUT_POST, '_pronamic_google_maps_map_type', FILTER_SANITIZE_STRING );
		self::update_post_meta( $post_id, '_pronamic_google_maps_map_type', Pronamic_Google_Maps_Maps::MAP_TYPE_DEFAULT === $map_type ? null : $map_type );

		// Zoom
		$zoom = filter_input( INPUT_POST, '_pronamic_google_maps_zoom', FILTER_SANITIZE_NUMBER_INT );
		self::update_post_meta( $post_id, '_pronamic_google_maps_zoom', Pronamic_Google_Maps_Maps::MAP_ZOOM_DEFAULT === $zoom ? null : $zoom );

		// Title
		$title = filter_input( INPUT_POST, '_pronamic_google_maps_title', FILTER_UNSAFE_RAW );
		$title = wp_kses_post( $title );
		self::update_post_meta( $post_id, '_pronamic_google_maps_title', $title );

		// Description
		$description = filter_input( INPUT_POST, '_pronamic_google_maps_description', FILTER_UNSAFE_RAW );
		$description = wp_kses_post( $description );
		self::update_post_meta( $post_id, '_pronamic_google_maps_description', $description );

		// Description
		$address = filter_input( INPUT_POST, '_pronamic_google_maps_address', FILTER_UNSAFE_RAW );
		$address = wp_kses_post( $address );
		self::update_post_meta( $post_id, '_pronamic_google_maps_address', $address );

		// Status
		if ( ! empty( $latitude ) && ! empty( $longitude ) ) {
			$status = Pronamic_Google_Maps_GeocoderStatus::OK;

			self::update_post_meta( $post_id, '_pronamic_google_maps_geocode_status', $status );
		} else {
			self::update_post_meta( $post_id, '_pronamic_google_maps_geocode_status', null );
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Get the geocode query arguments
	 *
	 * @return array
	 */
	public static function get_geocode_query_args() {
		return array(
			'post_type'      => 'any',
			'posts_per_page' => 1,
			'meta_query'     => array(
				// The address should not be empty
				array(
					'key'     => '_pronamic_google_maps_address',
					'value'   => '',
					'compare' => '!=',
				),
				// The geocoder status should not be OK
				array(
					'key'     => '_pronamic_google_maps_geocode_status',
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
	public static function ajax_geocode() {
		// ID
		$post_id = filter_input( INPUT_POST, 'post_ID', FILTER_SANITIZE_NUMBER_INT );

		// Latitude
		$latitude = filter_input( INPUT_POST, '_pronamic_google_maps_latitude', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		update_post_meta( $post_id, '_pronamic_google_maps_latitude', $latitude );

		// Longitude
		$longitude = filter_input( INPUT_POST, '_pronamic_google_maps_longitude', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		update_post_meta( $post_id, '_pronamic_google_maps_longitude', $longitude );

		// Status
		$status = filter_input( INPUT_POST, '_pronamic_google_maps_geocode_status', FILTER_SANITIZE_STRING );
		update_post_meta( $post_id, '_pronamic_google_maps_geocode_status', $status );

		// Result
		$result = new stdClass();
		$result->success = true;

		// Next post
		$query = new WP_Query();
		$query->query( Pronamic_Google_Maps_Admin::get_geocode_query_args() );

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

		wp_send_json( $result );

		exit;

		/*
		 Queries to empty latitude, longitude and geocode status meta
		 UPDATE wp_postmeta SET meta_value = '' WHERE meta_key IN ('_pronamic_google_maps_latitude', '_pronamic_google_maps_longitude');
		 UPDATE wp_postmeta SET meta_value = '' WHERE meta_key = '_pronamic_google_maps_geocode_status';
		 */
	}
}
