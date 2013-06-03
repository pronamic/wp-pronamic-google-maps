<?php

/**
 * Title: Pronamic Google Maps info
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_Info {
	/**
	 * Indicator for an static or dynamic Google Maps
	 * 
	 * @var boolean
	 */
	public $static;

	//////////////////////////////////////////////////
	
	/**
	 * The desired width of the Google Maps
	 * 
	 * @var int
	 */
	public $width;

	/**
	 * The desired height of the Google Maps
	 * 
	 * @var int
	 */
	public $height;

	//////////////////////////////////////////////////

	/**
	 * The latitude
	 * 
	 * @var flaot
	 */
	public $latitude;

	/**
	 * The longitude
	 * 
	 * @var float
	 */
	public $longitude;

	//////////////////////////////////////////////////

	/**
	 * The label
	 * 
	 * @var string
	 */
	public $label;

	/**
	 * The color
	 * 
	 * @var string
	 */
	public $color;

	//////////////////////////////////////////////////

	/**
	 * The map options
	 * 
	 * @var stdClass
	 */
	public $mapOptions;

	//////////////////////////////////////////////////

	/**
	 * The marker options
	 * 
	 * @var stdClass
	 */
	public $markerOptions;

	//////////////////////////////////////////////////

	/**
	 * Constructs and initialize an info object
	 */
	public function __construct() {
		$this->mapOptions = new stdClass();
		$this->markerOptions = new stdClass();
	}

	//////////////////////////////////////////////////

	/**
	 * Is this Google Maps static or not
	 * 
	 * @return boolean true if static, false otherwise
	 */
	public function isStatic() {
		return $this->static;
	}

	/**
	 * Is this Google Maps dynamic or not
	 * 
	 * @return boolean true if dynamic, false otherwise
	 */
	public function isDynamic() {
		return !$this->static;
	}
}
