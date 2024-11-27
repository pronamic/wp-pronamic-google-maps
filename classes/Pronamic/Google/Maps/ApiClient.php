<?php

/**
 * Title: Pronamic Google Maps API client
 * Description:
 * Copyright: Copyright (c) 2005 - 2015
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_Google_Maps_ApiClient {
	const OUTPUT_JSON = 'json';

	const OUTPUT_XML = 'xml';

	const API_END_POINT = 'https://maps.googleapis.com/maps/api/';

	public function __construct() {
	}

	public function geocode_address( $address ) {
		$result = null;

		$key = get_option( 'pronamic_google_maps_key' );
		$key = empty( $key ) ? false : $key;

		// URL
		$url = sprintf(
			self::API_END_POINT . '%s/%s?%s',
			'geocode',
			self::OUTPUT_JSON,
			_http_build_query(
				[
					'address' => $address,
					'key'     => $key,
				]
			)
		);

		$response = wp_remote_get( $url );

		if ( ! is_wp_error( $response ) ) {
			$body = $response['body'];

			$result = json_decode( $body );
		}

		return $result;
	}
}
