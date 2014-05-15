<?php

/**
 * Title: Pronamic Google Maps admin
 * Description:
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_Size {
	/**
	 * The number
	 *
	 * @var int
	 */
	public $number;

	/**
	 * The unit (px, %, em, etc.)
	 *
	 * @var string
	 */
	public $unit;

	//////////////////////////////////////////////////

	/**
	 * Pattern for size
	 *
	 * @see http://www.w3.org/TR/CSS2/syndata.html#value-def-length
	 * @var string
	 */
	const PATTERN = '/(?P<number>\d+)(?P<unit>\D+)?/';

	//////////////////////////////////////////////////

	/**
	 * Construct size
	 *
	 * @param string $value
	 */
	public function __construct( $number, $unit ) {
		$this->number = $number;
		$this->unit   = $unit;
	}

	//////////////////////////////////////////////////

	/**
	 * Get pixels
	 *
	 * @param int $context
	 * @return number
	 */
	public function get_pixels( $context ) {
		$pixels = $this->number;

		if ( $this->unit == '%' ) {
			$ratio = $context / 100;

			$pixels = $ratio * $this->number;
		}

		return $pixels;
	}

	//////////////////////////////////////////////////

	/**
	 * To string
	 *
	 * @return string
	 */
	public function __toString() {
		return '' . $this->number . $this->unit;
	}

	//////////////////////////////////////////////////

	/**
	 * Parse the specified value in to an size object
	 *
	 * @param string $value
	 */
	public static function parse( $value ) {
		$value = trim( $value );

		preg_match( self::PATTERN, $value, $matches );

		$number = 0;
		if ( isset( $matches['number'] ) ) {
			$number = (int) $matches['number'];
		}

		$unit = 'px';
		if ( isset( $matches['unit'] ) ) {
			$unit = $matches['unit'];
		}

		return new self( $number, $unit );
	}
}
