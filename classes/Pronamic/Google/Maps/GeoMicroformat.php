<?php

/**
 * Title: Pronamic Google Maps GEO microformat
 * Description:
 * Copyright: Copyright (c) 2005 - 2015
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_Google_Maps_GeoMicroformat {
	/**
	 * Render an GEO microformat for the specified latitude and longitude
	 *
	 * @param float $latitude
	 * @param float $longitude
	 */
	public static function render( $arguments = [] ) {
		// Arguments
		$defaults = [
			'echo' => true,
		];

		$arguments = wp_parse_args( $arguments, $defaults );

		// Options
		$options = Pronamic_Google_Maps_Maps::get_options();
		$pgm     = Pronamic_Google_Maps_Maps::get_meta_data();

		if ( ! $pgm->active ) {
			return;
		}

		// Active
		$active_types = $options['active'];

		$post_type = get_post_type();

		if ( ! array_key_exists( $post_type, $active_types ) || ! $active_types[ $post_type ] ) {
			return;
		}

		$content = sprintf(
			'
			<div class="geo">
				<abbr class="latitude" title="%.6f">%s</abbr>
				<abbr class="longitude" title="%.6f">%s</abbr>
			</div>',
			$pgm->latitude,
			Pronamic_Google_Maps_LatLng::convert_to_deg_min_sec( $pgm->latitude, Pronamic_Google_Maps_LatLng::DIRECTION_LATITUDE ),
			$pgm->longitude,
			Pronamic_Google_Maps_LatLng::convert_to_deg_min_sec( $pgm->longitude, Pronamic_Google_Maps_LatLng::DIRECTION_LONGITUDE )
		);

		if ( $arguments['echo'] ) {
			// @codingStandardsIgnoreStart
			echo $content;
			// @codingStandardsIgnoreEnd
		} else {
			return $content;
		}
	}
}
