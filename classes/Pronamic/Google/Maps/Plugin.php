<?php

/**
 * Title: Pronamic Google Maps plugin
 * Description:
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_Plugin {
	/**
	 * Bootstrap
	 */
	public static function bootstrap() {
		$plugin = plugin_basename( Pronamic_Google_Maps_Maps::$file );

		add_filter( 'plugin_action_links_' . $plugin, array( __CLASS__, 'actionLinks' ) );

		add_action( 'save_post', array( __CLASS__, 'savePostTryGeocode' ), 200 );
	}

	//////////////////////////////////////////////////

	/**
	 * Render the option page
	 */
	public static function actionLinks( $links ) {
		$url = admin_url( 'admin.php?page=' . Pronamic_Google_Maps_Maps::SLUG );

		$link = '<a href="' . $url . '">' . __( 'Settings', 'pronamic_google_maps' ) . '</a>';

		array_unshift( $links, $link );

		return $links;
	}

	//////////////////////////////////////////////////

	/**
	 * Save post try geocode
	 */
	public static function savePostTryGeocode( $post_id ) {
		$address = get_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_ADDRESS, true );
		$latitude = get_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_LATITUDE, true );
		$longitude = get_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_LONGITUDE, true );

		if ( ! empty( $address ) ) {
			if ( empty( $latitude) && empty( $longitude ) ) {
				$apiClient = new Pronamic_Google_Maps_ApiClient();

				$data = $apiClient->geocodeAddress( $address );

				foreach ( $data->results as $result ) {
					$location = $result->geometry->location;

					$latitude  = $location->lat;
					$longitude = $location->lng;
					$status    = Pronamic_Google_Maps_GeocoderStatus::OK;

					update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_LATITUDE, $latitude );
					update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_LONGITUDE, $longitude );
					update_post_meta( $post_id, Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS, $status );
				}
			}
		}
	}
}
