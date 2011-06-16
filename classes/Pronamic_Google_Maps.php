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

	/**
	 * The slug
	 *
	 * @var string
	 */
	const SLUG = 'pronamic-google-maps';

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
		$relPath = dirname(plugin_basename(self::$file)) . '/languages/';

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
		// _deprecated_function( __FUNCTION__, '1.4.1');

		global $post;

		$meta = new stdClass();
		
		$active = get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_ACTIVE, true);
		$meta->active = filter_var($active, FILTER_VALIDATE_BOOLEAN);
		
		$meta->latitude = (float) get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_LATITUDE, true);
		$meta->longitude = (float) get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_LONGITUDE, true);
		
		$meta->mapType = get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_MAP_TYPE, true);
		$meta->zoom = (int) get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_ZOOM, true);
		
		$meta->title = get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_TITLE, true);
		$meta->description = get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_DESCRIPTION, true);

		$meta->address = get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_ADDRESS, true);
		
		return $meta;
	}

	//////////////////////////////////////////////////

	/**
	 * Get an URL to an static Google Maps iamge
	 * 
	 * @param Pronamic_Google_Maps_Info $info
	 * @return string an URL
	 */
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

	//////////////////////////////////////////////////

	/**
	 * Render an Google Maps according the specified info
	 * 
	 * @param Pronamic_Google_Maps_Info $info
	 */
	public static function getMapHtml(Pronamic_Google_Maps_Info $info) {
		$content = '<div class="pgm">';

		if($info->isDynamic()) {
			$content .= sprintf('<input type="hidden" name="pgm-info" value="%s" />', esc_attr(json_encode($info)));

			$content .= sprintf('<div class="canvas" style="width: %dpx; height: %dpx;">', $info->width, $info->height);
			$content .= sprintf('  <img src="%s" alt="" />', self::getStaticMapUrl($info));
			$content .= sprintf('</div>');
		} else {
			$content .= sprintf('<img src="%s" alt="" />', self::getStaticMapUrl($info));
		}

		$content .= '</div>';

		return $content;
	}

	//////////////////////////////////////////////////

	/**
	 * Render an Google Maps for the current global post
	 * 
	 * @param mixed $arguments
	 */
	public static function render($arguments = array()) {
		Pronamic_Google_Maps_Site::$printScripts = true;

		$defaults = array(
			'width' => 500 ,
			'height' => 300 , 
			'static' => false , 
			'label' => null , 
			'color' => null , 
			'echo' => true
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

			$html = self::getMapHtml($info);

			if($arguments['echo']) {
				echo $html;
			} else {
				return $html;
			}
		}
	}
}
