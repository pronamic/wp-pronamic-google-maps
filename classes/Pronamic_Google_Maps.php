<?php

/**
 * Title: Pronamic Google Maps Admin
 * Description: 
 * Copyright: Copyright (c) 2005 - 2010
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps {
	/**
	 * The text domain
	 *
	 * @var string
	 */
	const TEXT_DOMAIN = 'pronamic_google_maps';

	//////////////////////////////////////////////////

	/**
	 * The name of the option
	 *
	 * @var string
	 */
	const OPTION_NAME = 'Pronamic_Google_maps';

	//////////////////////////////////////////////////

	/**
	 * The nonce name
	 *
	 * @var string
	 */
	const NONCE_NAME = 'Pronamic_Google_Maps_Leap_of_faith';

	//////////////////////////////////////////////////

	/**
	 * Meta key for the Google Maps active meta data
	 *
	 * @var string
	 */
	const META_KEY_ACTIVE = '_pronamic_google_maps_active';

	/**
	 * Meta key for the Google Maps latitude meta data
	 *
	 * @var string
	 */
	const META_KEY_LATITUDE = '_pronamic_google_maps_latitude';

	/**
	 * Meta key for the Google Map longitude meta data
	 *
	 * @var string
	 */
	const META_KEY_LONGITUDE = '_pronamic_google_maps_longitude';

	/**
	 * Meta key for the Google Maps title meta data
	 *
	 * @var string
	 */
	const META_KEY_TITLE = '_pronamic_google_maps_title';

	/**
	 * Meta key for the Google Maps info meta data
	 *
	 * @var string
	 */
	const META_KEY_DESCRIPTION = '_pronamic_google_maps_description';

	//////////////////////////////////////////////////

	/**
	 * The path to this plugin
	 * 
	 * @var string
	 */
	public static $pluginPath = '';

	/**
	 * The url to this plugin
	 *
	 * @var string
	 */
	public static $pluginUrl = '';

	//////////////////////////////////////////////////

	/**
	 * Constructs and initializes the Pronamic Google Maps plugin
	 */
	public function __construct() {
		add_action('init', array($this, 'initialize'));
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the plugin
	 */
	public function initialize() {
		$options = Pronamic_Google_Maps::getOptions();
		if($options === false) {
			$this->setDefaultOptions();
		}

		$admin = new Pronamic_Google_Maps_Admin($this);
	}

	//////////////////////////////////////////////////

	/**
	 * Get the options for this plugin
	 *
	 * @return array
	 */
	public static function getOptions() {
		return get_option(self::OPTION_NAME);
	}

	/**
	 * Set the default options
	 *
	 * @return array the default options
	 */
	public function setDefaultOptions() {
		$options = array(
			'installed' => true , 
			'active' => array(
				'page' => true , 
				'post' => true
			)
		);

		update_option(self::OPTION_NAME, $options);

		return $options;
	}
}
