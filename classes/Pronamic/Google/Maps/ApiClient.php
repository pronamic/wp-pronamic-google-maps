<?php

/**
 * Title: Pronamic Google Maps API client
 * Description:
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_ApiClient {
	const OUTPUT_JSON = 'json';

	const OUTPUT_XML = 'xml';

	const API_END_POINT = 'http://maps.googleapis.com/maps/api/';

	public function __construct() {

	}

	public function geocodeAddress( $address, $sensor = false ) {
		$result = null;

		// URL
		$url = sprintf(
			self::API_END_POINT . '%s/%s?%s',
			'geocode',
			self::OUTPUT_JSON,
			_http_build_query( array(
				'address' => $address,
				'sensor' => $sensor ? 'true' : 'false',
			) )
		);

		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {

		} else {
			$body = $response['body'];

			$result = json_decode( $body );
		}

		return $result;
	}
}
