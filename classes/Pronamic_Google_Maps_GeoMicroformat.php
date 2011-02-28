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
	public static function render($latitude, $longitude, $arguments = array()) {
		$defaults = array(
			'echo' => true
		);
	
		$arguments = wp_parse_args($arguments, $defaults);

		$content = sprintf('
			<div class="geo">
				<abbr class="latitude" title="%.6f">%s</abbr> 
				<abbr class="longitude" title="%.6f">%s</abbr>
			</div>' , 
			$latitude ,
			Pronamic_Google_Maps_LatLng::convertToDegMinSec($latitude, Pronamic_Google_Maps_LatLng::DIRECTION_LATITUDE) , 
			$longitude ,
			Pronamic_Google_Maps_LatLng::convertToDegMinSec($longitude, Pronamic_Google_Maps_LatLng::DIRECTION_LONGITUDE) 
		);

		if($arguments['echo']) {
			echo $content;
		} else {
			return $content;
		}
	}
}
