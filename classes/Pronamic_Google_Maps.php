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
	const TEXT_DOMAIN = 'pronamic-google-maps';

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
		add_action('widgets_init', array($this, 'initializeWidgets'));
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

		wp_enqueue_script(
			'google-maps' , 
			'http://maps.google.com/maps/api/js?sensor=true' , 
			false , 
			'3'
		);

		if(is_admin()) {
			$admin = new Pronamic_Google_Maps_Admin($this);
		} else {
			wp_enqueue_script(
				'pronamic-google-maps' , 
				Pronamic_Google_Maps::$pluginUrl . 'js/index.js' , 
				array('google-maps', 'jquery')
			);
		}
	}

	/**
	 * Initialize widgets
	 */
	public function initializeWidgets() {
		register_widget('Pronamic_Google_Maps_Widget');
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
	
	public static function getStaticMapUrl(Pronamic_Google_Maps_Info $info) {
		$url = 'http://maps.google.com/maps/api/staticmap?';

		$parameters = array();
		$parameters['center'] = $info->latitude . ',' . $info->longitude;
		$parameters['zoom'] = $info->zoom;
		$parameters['size'] = $info->width . 'x' . $info->height;
		$parameters['maptype'] = $info->mapType;
		$parameters['sensor'] = 'false';

		$markers = '';
		if($info->color != null) {
			$markers .= 'color:' . $info->color . '|';
		}

		if($info->label != null) {
			$markers .= 'label:' . $info->label . '|';
		}

		$markers .= $info->latitude . ',' . $info->longitude;
		
		$parameters['markers'] = $markers;

		$url .= http_build_query($parameters, '', '&amp;');

		return $url;
	}

	public static function renderHiddenFields(Pronamic_Google_Maps_Info $info) {
		?>
		<input type="hidden" name="lat" value="<?php echo esc_attr($info->latitude); ?>" />
		<input type="hidden" name="lng" value="<?php echo esc_attr($info->longitude); ?>" />
		<input type="hidden" name="map-type" value="<?php echo esc_attr($info->mapType); ?>" />
		<input type="hidden" name="zoom" value="<?php echo esc_attr($info->zoom); ?>" />
		<input type="hidden" name="title" value="<?php echo esc_attr($info->title); ?>" />
		<input type="hidden" name="description" value="<?php echo esc_attr($info->description); ?>" />
		<?php
	}

	public static function renderMetaHiddenField($info) {
		?>
		<input type="hidden" name="pronamic-google-maps-meta" value="<?php echo esc_attr(json_encode($info)); ?>" />
		<?php
	}

	public static function renderMap(Pronamic_Google_Maps_Info $info) {
		?>
		<div class="pgm">

			<?php if($info->isDynamic()):  ?>

			<?php self::renderHiddenFields($info); ?>
		
			<div class="canvas" style="width: <?php echo $info->width; ?>px; height: <?php echo $info->height; ?>px;">
				<img src="<?php echo self::getStaticMapUrl($info); ?>" alt="" />
			</div>

			<?php else: ?>

			<img src="<?php echo self::getStaticMapUrl($info); ?>" alt="" />

			<?php endif; ?>

			<div class="geo">
				<abbr class="latitude" title="<?php printf('%.6f', $info->latitude); ?>"><?php echo Pronamic_Google_Maps_LatLng::convertToDegMinSec($info->latitude, Pronamic_Google_Maps_LatLng::DIRECTION_LATITUDE); ?></abbr> 
				<abbr class="longitude" title="<?php printf('%.6f', $info->longitude); ?>"><?php echo Pronamic_Google_Maps_LatLng::convertToDegMinSec($info->longitude, Pronamic_Google_Maps_LatLng::DIRECTION_LONGITUDE); ?></abbr>
			</div>
		</div>
		<?php 
	}

	public static function render($arguments) {
		$defaults = array(
			'width' => 500 ,
			'height' => 300 , 
			'static' => false , 
			'label' => null , 
			'color' => null
		);
	
		$arguments = wp_parse_args($arguments, $defaults);
		
		$options = Pronamic_Google_Maps::getOptions();
		$pgm = Pronamic_Google_Maps::getMetaData();
	
		$activeTypes = $options['active'];
	
		global $post;
	
		$active = isset($activeTypes[$post->post_type]) && $activeTypes[$post->post_type];
	
		if($active && $pgm->active) {
			$info = new Pronamic_Google_Maps_Info();
			$info->title = $pgm->title;
			$info->description = $pgm->description;
			$info->latitude = $pgm->latitude;
			$info->longitude = $pgm->longitude;
			$info->mapType = $pgm->mapType;
			$info->zoom = $pgm->zoom;
			$info->width = $arguments['width'];
			$info->height = $arguments['height'];
			$info->static = $arguments['static'];
			$info->label = $arguments['label'];
			$info->color = $arguments['color'];

			self::renderMap($info);
		}
	}
}
