<?php

/**
 * Title: Pronamic Google Maps info
 * Description: 
 * Copyright: Copyright (c) 2005 - 2010
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_Info {
	public $static;

	public $width;

	public $height;

	public $latitude;

	public $longitude;

	public $zoom;

	public $mapType;

	public $label;

	public $color;

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
