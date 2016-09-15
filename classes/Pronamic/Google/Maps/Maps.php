<?php

/**
 * Title: Pronamic Google Maps
 * Description:
 * Copyright: Copyright (c) 2005 - 2015
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_Google_Maps_Maps {
	/**
	 * The slug
	 *
	 * @var string
	 */
	const SLUG = 'pronamic_google_maps';

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
	 * Default zoom value
	 *
	 * @var int
	 */
	const MAP_ZOOM_DEFAULT = 8;

	/**
	 * Default map type
	 *
	 * @var string
	 */
	const MAP_TYPE_DEFAULT = Pronamic_Google_Maps_MapTypeId::ROADMAP;

	//////////////////////////////////////////////////

	/**
	 * The plugin file
	 *
	 * @var string
	 */
	public static $file;

	//////////////////////////////////////////////////

	/**
	 * The default width
	 *
	 * @var int
	 */
	public static $defaultWidth = 500;

	/**
	 * The default height
	 *
	 * @var int
	 */
	public static $defaultHeight = 375;

	//////////////////////////////////////////////////

	/**
	 * Bootstrap this plugin
	 *
	 * @param string $file
	 */
	public static function bootstrap( $file ) {
		self::$file = $file;

		Pronamic_Google_Maps_Plugin::bootstrap();
		Pronamic_Google_Maps_Widget::bootstrap();
		Pronamic_Google_Maps_Shortcodes::bootstrap();

		// Actions and hooks
		add_action( 'init',        array( __CLASS__, 'init' ) );

		add_filter( 'parse_query', array( __CLASS__, 'parse_query' ), 1000 );

		// Options
		$embed_size = wp_embed_defaults();

		self::$defaultWidth  = $embed_size['width'];
		self::$defaultHeight = $embed_size['height'];
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize the plugin
	 */
	public static function init() {
		if ( ! Pronamic_Google_Maps_Settings::has_settings() ) {
			Pronamic_Google_Maps_Settings::set_default_options();
		}

		// Load plugin text domain
		$rel_path = dirname( plugin_basename( self::$file ) ) . '/languages/';

		load_plugin_textdomain( 'pronamic-google-maps', false, $rel_path );

		// Scripts
		self::register_scripts();

		// Other
		if ( is_admin() ) {
			Pronamic_Google_Maps_Admin::bootstrap();
		} else {
			Pronamic_Google_Maps_Site::bootstrap();
		}
	}

	//////////////////////////////////////////////////

	/**
	 * Pre get posts
	 *
	 * @param WP_Query $query
	 * @see http://core.trac.wordpress.org/browser/tags/3.4/wp-includes/query.php#L0
	 */
	public static function parse_query( $query ) {
		$meta_query_extra = array();

		// Range
		// @see http://en.wikipedia.org/wiki/Decimal_degrees
		$range = 0.3;

		// Latitude
		$latitude = $query->get( 'pronamic_latitude' );

		if ( ! empty( $latitude ) ) {
			$meta_query_extra[] = array(
				'key'     => '_pronamic_google_maps_latitude',
				'compare' => 'BETWEEN',
				'value'   => array( $latitude - $range, $latitude + $range ),
			);
		}

		// Longitude
		$longitude = $query->get( 'pronamic_longitude' );

		if ( ! empty( $longitude ) ) {
			$meta_query_extra[] = array(
				'key'     => '_pronamic_google_maps_longitude',
				'compare' => 'BETWEEN',
				'value'   => array( $longitude - $range, $longitude + $range ),
			);
		}

		// Meta query
		if ( ! empty( $meta_query_extra ) ) {
			$meta_query = $query->get( 'meta_query' );

			$meta_query = wp_parse_args( $meta_query_extra , $meta_query );

			$query->set( 'meta_query' , $meta_query );
		}
	}

	/**
	 * Register scripts
	 */
	public static function register_scripts() {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Register the Google Maps script
		$key = get_option( 'pronamic_google_maps_key' );
		$key = empty( $key ) ? false : $key;

		wp_register_script(
			'google-maps',
			add_query_arg(
				array(
					'sensor' => 'false',
					'key'    => $key,
				),
				'https://maps.googleapis.com/maps/api/js'
			),
			array(),
			null
		);

		// MarkerClustererPlus
		// @see http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclustererplus/2.0.6/
		wp_register_script(
			'google-maps-marker-clusterer-plus',
			plugins_url( 'assets/markerclustererplus/markerclusterer' . $min . '.js', Pronamic_Google_Maps_Maps::$file ),
			array( 'google-maps' ),
			'2.1.1'
		);

		// MarkerManager
		// @see http://google-maps-utility-library-v3.googlecode.com/svn/tags/markermanager/1.0/
		wp_register_script(
			'google-maps-marker-manager',
			plugins_url( 'assets/google-maps-marker-manager/markermanager' . $min . '.js', Pronamic_Google_Maps_Maps::$file ),
			array( 'google-maps' ),
			'1.0'
		);

		// OverlappingMarkerSpiderfier
		// @see https://github.com/jawj/OverlappingMarkerSpiderfier
		wp_register_script(
			'google-maps-overlapping-marker-spiderfier',
			plugins_url( 'assets/google-maps-overlapping-marker-spiderfier/oms.min.js', Pronamic_Google_Maps_Maps::$file ),
			array( 'google-maps' ),
			'0.3.3'
		);
	}

	//////////////////////////////////////////////////

	/**
	 * Get the options for this plugin
	 *
	 * @return array
	 */
	public static function get_options() {
		return Pronamic_Google_Maps_Settings::get_settings();
	}

	/**
	 * Set the default options
	 *
	 * @return array the default options
	 */
	public static function set_default_options() {
		Pronamic_Google_Maps_Settings::set_default_options();
	}

	//////////////////////////////////////////////////

	/**
	 * Get the Google Maps meta data for the current post
	 *
	 * @return stdClass
	 */
	public static function get_meta_data( $post_id = null ) {
		// _deprecated_function( __FUNCTION__, '1.4.1');

		$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;

		$meta = new stdClass();

		$active = get_post_meta( $post_id, '_pronamic_google_maps_active', true );
		$meta->active = filter_var( $active, FILTER_VALIDATE_BOOLEAN );

		$meta->latitude = null;
		$value = get_post_meta( $post_id, '_pronamic_google_maps_latitude', true );
		if ( '' !== $value ) {
			$meta->latitude = (float) $value;
		}
		$meta->longitude = null;
		$value = get_post_meta( $post_id, '_pronamic_google_maps_longitude', true );
		if ( '' !== $value ) {
			$meta->longitude = (float) $value;
		}

		$meta->mapType = self::MAP_TYPE_DEFAULT;
		$value = get_post_meta( $post_id, '_pronamic_google_maps_map_type', true );
		if ( '' !== $value ) {
			$meta->mapType = $value;
		}

		$meta->zoom = self::MAP_ZOOM_DEFAULT;
		$value = get_post_meta( $post_id, '_pronamic_google_maps_zoom', true );
		if ( '' !== $value ) {
			$meta->zoom = (int) $value;
		}

		$meta->title = get_post_meta( $post_id, '_pronamic_google_maps_title', true );

		$description = get_post_meta( $post_id, '_pronamic_google_maps_description', true );
		if ( ! is_admin() ) {
			$description = apply_filters( 'pronamic_google_maps_item_description', $description );
		}
		$meta->description = $description;

		$meta->address = get_post_meta( $post_id, '_pronamic_google_maps_address', true );

		$meta = apply_filters( 'pronamic_google_maps_post_meta', $meta );

		return $meta;
	}

	//////////////////////////////////////////////////

	/**
	 * Get an URL to an static Google Maps iamge
	 *
	 * @param Pronamic_Google_Maps_Info $info
	 * @return string an URL
	 */
	public static function get_static_map_url( Pronamic_Google_Maps_Info $info ) {
		$url = 'https://maps.google.com/maps/api/staticmap?';

		$width  = Pronamic_Google_Maps_Size::parse( $info->width );
		$height = Pronamic_Google_Maps_Size::parse( $info->height );

		$parameters = array();
		$parameters['center']  = $info->latitude . ',' . $info->longitude;
		$parameters['zoom']    = $info->mapOptions->zoom;
		$parameters['size']    = $width->get_pixels( self::$defaultWidth ) . 'x' . $height->get_pixels( self::$defaultHeight );
		$parameters['maptype'] = $info->mapOptions->mapTypeId;
		$parameters['sensor']  = 'false';

		$markers = '';
		if ( null !== $info->color ) {
			$markers .= 'color:' . $info->color . '|';
		}

		if ( null !== $info->label ) {
			$markers .= 'label:' . $info->label . '|';
		}

		if ( ! empty( $info->markerOptions->icon ) ) {
			$markers .= 'icon:' . $info->markerOptions->icon . '|';
		}

		$markers .= $info->latitude . ',' . $info->longitude;

		$parameters['markers'] = $markers;

		$url .= http_build_query( $parameters, '', '&amp;' );

		return $url;
	}

	//////////////////////////////////////////////////

	/**
	 * Render an Google Maps according the specified info
	 *
	 * @param Pronamic_Google_Maps_Info $info
	 */
	public static function get_map_html( Pronamic_Google_Maps_Info $info ) {
		$content = '<div class="pgm">';

		$width  = Pronamic_Google_Maps_Size::parse( $info->width );
		$height = Pronamic_Google_Maps_Size::parse( $info->height );

		if ( $info->is_dynamic() ) {
			$content .= sprintf( '<input type="hidden" name="pgm-info" value="%s" />', esc_attr( json_encode( $info ) ) );

			$content .= sprintf( '<div class="canvas" style="width: %s; height: %s;">', $width, $height );
			$content .= sprintf( '	<noscript><img src="%s" alt="" /></noscript>', self::get_static_map_url( $info ) );
			$content .= sprintf( '</div>' );
		} else {
			$content .= sprintf( '<img src="%s" alt="" />', self::get_static_map_url( $info ) );
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
	public static function render( $arguments = array() ) {
		$defaults = array(
			'width'          => self::$defaultWidth,
			'height'         => self::$defaultHeight,
			'static'         => false,
			'label'          => null,
			'color'          => null,
			'echo'           => true,
			'marker_options' => array(),
			'map_options'    => array(),
			'post_id'        => null,
		);

		$arguments = wp_parse_args( $arguments, $defaults );

		$post_id = $arguments['post_id'];
		$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;

		$options = Pronamic_Google_Maps_Maps::get_options();
		$pgm = Pronamic_Google_Maps_Maps::get_meta_data( $post_id );

		$activeTypes = $options['active'];

		$post_type = get_post_type( $post_id );

		$active = isset( $activeTypes[ $post_type ] ) && $activeTypes[ $post_type ];

		if ( $active && $pgm->active ) {
			$info = new Pronamic_Google_Maps_Info();
			$info->title       = $pgm->title;
			$info->description = $pgm->description;
			$info->latitude    = $pgm->latitude;
			$info->longitude   = $pgm->longitude;
			$info->width       = $arguments['width'];
			$info->height      = $arguments['height'];
			$info->static      = filter_var( $arguments['static'], FILTER_VALIDATE_BOOLEAN );
			$info->label       = $arguments['label'];
			$info->color       = $arguments['color'];

			// Marker options
			$marker_options = $arguments['marker_options'];
			$marker_options = apply_filters( 'pronamic_google_maps_marker_options', $marker_options );

			foreach ( $marker_options as $key => $value ) {
				$value = apply_filters( 'pronamic_google_maps_marker_options_' . $key, $value );

				$info->markerOptions->$key = $value;
			}

			// Map options
			$info->mapOptions->mapTypeId = $pgm->mapType;
			$info->mapOptions->zoom      = $pgm->zoom;
			foreach ( $arguments['map_options'] as $key => $value ) {
				$value = apply_filters( 'pronamic_google_maps_map_options_' . $key, $value );

				$info->mapOptions->$key = $value;
			}

			$html = self::get_map_html( $info );

			if ( $info->is_dynamic() ) {
				Pronamic_Google_Maps_Site::require_site_script();
			}

			if ( $arguments['echo'] ) {
				// @codingStandardsIgnoreStart
				echo $html;
				// @codingStandardsIgnoreEnd
			} else {
				return $html;
			}
		}
	}
}
