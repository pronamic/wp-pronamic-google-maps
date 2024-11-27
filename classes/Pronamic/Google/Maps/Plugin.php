<?php

/**
 * Title: Pronamic Google Maps plugin
 * Description:
 * Copyright: Copyright (c) 2005 - 2015
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_Google_Maps_Plugin {
	/**
	 * Bootstrap
	 */
	public static function bootstrap() {
		$plugin = plugin_basename( Pronamic_Google_Maps_Maps::$file );

		add_filter( 'plugin_action_links_' . $plugin, [ __CLASS__, 'action_links' ] );

		add_action( 'save_post', [ __CLASS__, 'save_post_try_geocode' ], 200 );
	}

	/**
	 * Render the option page
	 */
	public static function action_links( $links ) {
		$url = admin_url( 'admin.php?page=' . Pronamic_Google_Maps_Maps::SLUG );

		$link = '<a href="' . $url . '">' . __( 'Settings', 'pronamic-google-maps' ) . '</a>';

		array_unshift( $links, $link );

		return $links;
	}

	/**
	 * Save post try geocode
	 */
	public static function save_post_try_geocode( $post_id ) {
		$address   = get_post_meta( $post_id, '_pronamic_google_maps_address', true );
		$latitude  = get_post_meta( $post_id, '_pronamic_google_maps_latitude', true );
		$longitude = get_post_meta( $post_id, '_pronamic_google_maps_longitude', true );

		if ( ! empty( $address ) ) {
			if ( empty( $latitude ) && empty( $longitude ) ) {
				$client = new Pronamic_Google_Maps_ApiClient();

				$data = $client->geocode_address( $address );

				if ( $data ) {
					foreach ( $data->results as $result ) {
						$location = $result->geometry->location;

						$latitude  = $location->lat;
						$longitude = $location->lng;
						$status    = Pronamic_Google_Maps_GeocoderStatus::OK;

						update_post_meta( $post_id, '_pronamic_google_maps_latitude', $latitude );
						update_post_meta( $post_id, '_pronamic_google_maps_longitude', $longitude );
						update_post_meta( $post_id, '_pronamic_google_maps_geocode_status', $status );
					}
				}
			}
		}
	}
}
