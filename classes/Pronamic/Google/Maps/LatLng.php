<?php

/**
 * Title: Latitude longitude object
 * Description:
 * LatLng is a point in geographical coordinates longitude and latitude.
 * 
 * Notice that although usual map projections associate longitude with the
 * x-coordinate of the map, and latitude with the y-coordinate, the latitude
 * cooridnate is always written first, followed by the longitude, as it is
 * custom in cartography.
 * 
 * Notice also that you cannot modify the coordinates of a PLatLng. If you want
 * to compute another point, you have to create a new one.
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 * @doc
 * http://www.web-max.ca/PHP/misc_6.php
 * http://www.weberdev.com/get_example-3548.html
 * http://microformats.org/wiki/geo
 */
class Pronamic_Google_Maps_LatLng {
	/**
	 * Indicator for the cardinal direction north
	 * 
	 * @var string
	 */
	const CARDINAL_DIRECTION_NORTH = 'N';
	
	/**
	 * Indicator for the cardinal direction east
	 * 
	 * @var string
	 */
	const CARDINAL_DIRECTION_EAST = 'E';

	/**
	 * Indicator for the cardinal direction south
	 * 
	 * @var string
	 */
	const CARDINAL_DIRECTION_SOUTH = 'S';

	/**
	 * Indicator for the cardinal direction west
	 * 
	 * @var string
	 */
	const CARDINAL_DIRECTION_WEST = 'W';

	///////////////////////////////////////////////////////////////////////////

	/**
	 * Indicator for the latitude direction
	 * 
	 * @var string
	 */
	const DIRECTION_LATITUDE = 'lat';

	/**
	 * Indicator for the longitude direction
	 * 
	 * @var string
	 */
	const DIRECTION_LONGITUDE = 'lng';

	///////////////////////////////////////////////////////////////////////////

	/**
	 * The latitude value
	 */
	protected $latitude;

	/**
	 * The longitude value
	 */
	protected $longitude;

	///////////////////////////////////////////////////////////////////////////

	/**
	 * Constructs and initializes an latitude and longitude object
	 *
	 * @param float $latitude
	 * @param float $longitude
	 */
	public function __construct($latitude, $longitude) {
		$this->latitude = $latitude;
		$this->longitude = $longitude;
	}

	///////////////////////////////////////////////////////////////////////////

	/**
	 * Get the latitude value
	 * 
	 * @return float a number
	 */
	public function lat() {
		return $this->latitude;
	}

	///////////////////////////////////////////////////////////////////////////

	/**
	 * Get the longitude value
	 * 
	 * @return float a number
	 */
	public function lng() {
		return $this->longitude;
	}

	///////////////////////////////////////////////////////////////////////////

	/**
	 * Checks if this latitude and longitude object is equal to the specified object
	 * 
	 * @param geo_LatLng $other an other latitude and longitude object
	 * @return boolean true if they are equal, false otherwise
	 */
	public function equals(self $other) {
		return ($this->latitude === $other->latitude && $this->longitude === $other->longitude);
	}

	///////////////////////////////////////////////////////////////////////////

	/**
	 * Determine the distance from another coordinate
	 * 
	 * @param orbis_geo_LatLng $other a coordinate
	 * @return double a distance
	 */
	public function distanceFrom(self $other) {
		return sqrt(sqrt((pow($other->latitude - $this->latitude, 2))
						+ pow($other->longitude - $this->longitude, 2)));
	}

	///////////////////////////////////////////////////////////////////////////

	/**
	 * Determine the mid point to the specified coordinate
	 * 
	 * @param orbis_geo_LatLng $other a coordinate
	 * @return geo_LatLng mid point
	 */
	public function midpointTo(self $other) {
		return new self(
			($other->latitude + $this->latitude) / 2.0, 
			($other->longitude + $this->longitude) / 2.0
		);
	}

	///////////////////////////////////////////////////////////////////////////

	/**
	 * Transform this latitude and longitude object
	 * 
	 * @param orbis_geo_LatLng $delta the delta values
	 */
	public function transform(self $delta) {
		$this->latitude += $delta->latitude;
		$this->longitude += $delta->longitude;
	}

	///////////////////////////////////////////////////////////////////////////

	/**
	 * Create a string representation for this object
	 * 
	 * @return a string representation for this object
	 */
	public function __toString() {
		return '(' + $this->latitude + ', ' + $this->longitude + ')';
	}

	///////////////////////////////////////////////////////////////////////////

	/**
	 * Convert the specified decimail to deg min sec
	 * 
	 * @param float $decimal
	 * @param stromg $direction
	 */
	public static function convertToDegMinSec($decimal, $direction = null) {
		$string = (string) $decimal;

		$degrees = $string;
		$minutes = 0;
		$seconds = 0;
		$cardinalDirection = null;
		
		$position = strpos($string, '.');
		if($position !== false) {
			$integral = (int) substr($string, 0, $position);
			$fractional =  (float) ('0.' . substr($string, $position + 1));

			$s = $fractional * 3600;
			
			$degrees = abs($integral);
			$minutes = floor($s / 60);
			$seconds = $s - ($minutes * 60);
			$seconds = round($seconds); 
		}

		if($direction !== null) {
			switch($direction) {
				case self::DIRECTION_LATITUDE:
					$cardinalDirection = $decimal < 0 ? self::CARDINAL_DIRECTION_SOUTH : self::CARDINAL_DIRECTION_NORTH;
					break;
				case self::DIRECTION_LONGITUDE: 
					$cardinalDirection = $decimal < 0 ? self::CARDINAL_DIRECTION_WEST : self::CARDINAL_DIRECTION_EAST;
					break;
			}
		}

		if($cardinalDirection !== null) {
			return sprintf('%s°%s\' %s" %s', $degrees, $minutes, $seconds, $cardinalDirection);
		} else {
			return sprintf('%s°%s\' %s"', $degrees, $minutes, $seconds);
		} 
	}
}
