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
	public static function remder($latitude, $longitude) {
		?>
		<div class="geo">
			<abbr class="latitude" title="<?php printf('%.6f', $latitude); ?>"><?php echo Pronamic_Google_Maps_LatLng::convertToDegMinSec($latitude, Pronamic_Google_Maps_LatLng::DIRECTION_LATITUDE); ?></abbr> 
			<abbr class="longitude" title="<?php printf('%.6f', $longitude); ?>"><?php echo Pronamic_Google_Maps_LatLng::convertToDegMinSec($longitude, Pronamic_Google_Maps_LatLng::DIRECTION_LONGITUDE); ?></abbr>
		</div>
		<?php 
	}
}
