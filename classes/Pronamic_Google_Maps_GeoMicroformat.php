<?php

/**
 * Title: Pronamic Google Maps GEO microformat
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_GeoMicroformat {
	/**
	 * Render an GEO microformat for the specified latitude and longitude
	 * 
	 * @param float $latitude
	 * @param float $longitude
	 */
	public static function render($arguments = array()) {
		// Arguments
		$defaults = array(
			'echo' => true
		);
	
		$arguments = wp_parse_args($arguments, $defaults);

		// Options
		$options = Pronamic_Google_Maps::getOptions();
		$pgm = Pronamic_Google_Maps::getMetaData();
	
		$activeTypes = $options['active'];
	
		global $post;
	
		$active = isset($activeTypes[$post->post_type]) && $activeTypes[$post->post_type];

		// Active
		if($active && $pgm->active) {
			$content = sprintf('
				<div class="geo">
					<abbr class="latitude" title="%.6f">%s</abbr> 
					<abbr class="longitude" title="%.6f">%s</abbr>
				</div>' , 
				$pgm->latitude ,
				Pronamic_Google_Maps_LatLng::convertToDegMinSec($pgm->latitude, Pronamic_Google_Maps_LatLng::DIRECTION_LATITUDE) , 
				$pgm->longitude ,
				Pronamic_Google_Maps_LatLng::convertToDegMinSec($pgm->longitude, Pronamic_Google_Maps_LatLng::DIRECTION_LONGITUDE) 
			);

			if($arguments['echo']) {
				echo $content;
			} else {
				return $content;
			}
		}
	}
}
