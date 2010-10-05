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

	/**
	 * Meta key for the Google Maps map type data
	 *
	 * @var string
	 */
	const META_KEY_MAP_TYPE = '_pronamic_google_maps_map_type';

	/**
	 * Meta key for the Google Maps map zoom level
	 *
	 * @var string
	 */
	const META_KEY_ZOOM = '_pronamic_google_maps_zoom';

	//////////////////////////////////////////////////

	/**
	 * The basename of this plugin
	 * 
	 * @var string
	 */
	public static $baseName = '';

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

		$relPath = dirname(self::$baseName) . '/languages';
		load_plugin_textdomain(self::TEXT_DOMAIN, false, $relPath);

		if(is_admin()) {
			$admin = new Pronamic_Google_Maps_Admin($this);
		} else {
			add_action('wp_head', array($this, 'renderHead'));
		}
	}


	//////////////////////////////////////////////////

	/**
	 * Render the admin head
	 */
	public function renderHead() {
		include Pronamic_Google_Maps::$pluginPath . 'views/head.php';
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

	//////////////////////////////////////////////////

	/**
	 * Get the Google Maps meta data for the current post
	 * 
	 * @return stdClass
	 */
	public static function getMetaData() {
		global $post;
		
		$meta = new stdClass();
		
		$active = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_ACTIVE, true);
		$meta->active = filter_var($active, FILTER_VALIDATE_BOOLEAN);
		
		$meta->latitude = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_LATITUDE, true);
		$meta->longitude = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_LONGITUDE, true);
		
		$meta->mapType = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_MAP_TYPE, true);
		$meta->zoom = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_ZOOM, true);
		
		$meta->title = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_TITLE, true);
		$meta->description = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_DESCRIPTION, true);
		
		return $meta;
	}

	//////////////////////////////////////////////////

	public static function render($arguments) {
		$defaults = array(
			'width' => 500 ,
			'height' => 300 , 
			'static' => false
		);
	
		$arguments = wp_parse_args($arguments, $defaults);
		
		$options = Pronamic_Google_Maps::getOptions();
		$pgm = Pronamic_Google_Maps::getMetaData();
	
		$activeTypes = $options['active'];
	
		global $post;
	
		$active = isset($activeTypes[$post->post_type]) && $activeTypes[$post->post_type];
	
		if($active && $pgm->active): ?>
	
		<div id="pgm-canvas" <?php if(!$arguments['static']): ?>style="width: 290px; height: 200px;"<?php endif; ?>>
			<?php 
	
			$url = 'http://maps.google.com/maps/api/staticmap?';
	
			$parameters = array();
			$parameters['center'] = $pgm->latitude . ',' . $pgm->longitude;
			$parameters['zoom'] = 12;
			$parameters['size'] = $arguments['width'] . 'x' . $arguments['height'];
			$parameters['maptype'] = $pgm->mapType;
			$parameters['sensor'] = 'false';

			$markers = '';
			if(isset($arguments['color'])) {
				$markers .= 'color:' . $arguments['color'] . '|';
			}

			if(isset($arguments['label'])) {
				$markers .= 'label:' . $arguments['label'] . '|';
			}

			$markers .= $pgm->latitude . ',' . $pgm->longitude;
			
			$parameters['markers'] = $markers;
	
			$url .= http_build_query($parameters, '', '&amp;');

			if(!$arguments['static']):  ?>
	
			<input type="hidden" id="pgm-lat-field" name="<?php echo Pronamic_Google_Maps::META_KEY_LATITUDE; ?>" value="<?php echo esc_attr($pgm->latitude); ?>" />
			<input type="hidden" id="pmg-lon-field" name="<?php echo Pronamic_Google_Maps::META_KEY_LONGITUDE; ?>" value="<?php echo esc_attr($pgm->longitude); ?>" />
			<input type="hidden" id="pgm-map-type-id-field" name="<?php echo Pronamic_Google_Maps::META_KEY_MAP_TYPE; ?>" value="<?php echo esc_attr($pgm->mapType); ?>" />
			<input type="hidden" id="pgm-zoom-field" name="<?php echo Pronamic_Google_Maps::META_KEY_ZOOM; ?>" value="<?php echo esc_attr($pgm->zoom); ?>" />
			<input type="hidden" id="pgm-title-field" name="<?php echo Pronamic_Google_Maps::META_KEY_TITLE; ?>" value="<?php echo esc_attr($pgm->title); ?>" />
			<input type="hidden" id="pgm-description-field" name="<?php echo Pronamic_Google_Maps::META_KEY_DESCRIPTION; ?>" value="<?php echo esc_attr($pgm->description); ?>" />

			<?php endif; ?>

			<img src="<?php echo $url; ?>" alt="" />
		</div>
	
		<?php endif; 
	}
}
