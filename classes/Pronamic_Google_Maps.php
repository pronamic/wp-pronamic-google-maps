<?php

/**
 * Title: Pronamic Google Maps
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
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
	 * The plugin file
	 * 
	 * @var string
	 */
	public static $file;

	//////////////////////////////////////////////////

	/**
	 * Bootstrap this plugin
	 * 
	 * @param string $file
	 */
	public static function bootstrap($file) {
		self::$file = $file;

		Pronamic_Google_Maps_Plugin::bootstrap();
		Pronamic_Google_Maps_Widget::bootstrap();
		Pronamic_Google_Maps_Magic::bootstrap();

		// Actions and hooks
		add_action('init', array(__CLASS__, 'initialize'));
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the plugin
	 */
	public static function initialize() {
		$options = self::getOptions();
		if($options === false) {
			self::setDefaultOptions();
		}

		// Load plugin text domain
		$relPath = dirname(self::$file) . '/languages';
		load_plugin_textdomain(self::TEXT_DOMAIN, false, $relPath);

		// Register the Google Maps API script
		wp_register_script(
			'google-maps' , 
			'http://maps.google.com/maps/api/js?sensor=true' , 
			false , 
			'3'
		);

		if(is_admin()) {
			Pronamic_Google_Maps_Admin::bootstrap();
		} else {
			Pronamic_Google_Maps_Site::bootstrap();
		}
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
	public static function setDefaultOptions() {
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
		
		$meta->latitude = (float) get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_LATITUDE, true);
		$meta->longitude = (float) get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_LONGITUDE, true);
		
		$meta->mapType = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_MAP_TYPE, true);
		$meta->zoom = (int) get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_ZOOM, true);
		
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

	public static function renderMetaHiddenField($info) {
		?>
		<input type="hidden" name="pronamic-google-maps-meta" value="<?php echo esc_attr(json_encode($info)); ?>" />
		<?php
	}

	public static function renderMap(Pronamic_Google_Maps_Info $info) {
		?>
		<div class="pgm">

			<?php if($info->isDynamic()):  ?>

			<?php self::renderMetaHiddenField($info); ?>

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
