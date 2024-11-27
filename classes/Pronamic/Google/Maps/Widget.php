<?php

/**
 * Title: Pronamic Google Maps widget
 * Description:
 * Copyright: Copyright (c) 2005 - 2015
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @doc http://codex.wordpress.org/Widgets_API
 *      http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 */
class Pronamic_Google_Maps_Widget extends WP_Widget {
	/**
	 * Bootstrap this widget
	 */
	public static function bootstrap() {
		add_action( 'widgets_init', [ __CLASS__, 'initialize' ] );
	}

	//////////////////////////////////////////////////

	/**
	 * Initialize
	 */
	public static function initialize() {
		register_widget( __CLASS__ );
	}

	//////////////////////////////////////////////////

	/**
	 * Constructs and initialize the Google Maps meta box
	 */
	public function __construct() {
		$description    = __( 'Use this widget to add an Google Maps as a widget.', 'pronamic-google-maps' );
		$widgetOptions  = [
			'classname'   => 'pronamic_google_maps_widget',
			'description' => $description,
		];
		$controlOptions = [ 'width' => 500 ];

		parent::__construct( 'pronamic_google_maps', __( 'Google Maps', 'pronamic-google-maps' ), $widgetOptions, $controlOptions );
	}

	//////////////////////////////////////////////////

	/**
	 * Render the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		// @codingStandardsIgnoreStart
		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$info = new Pronamic_Google_Maps_Info();
		$info->title       = $instance['title'];
		$info->description = $instance['description'];
		$info->width       = $instance['width'];
		$info->height      = $instance['height'];
		$info->latitude    = (float) $instance['latitude'];
		$info->longitude   = (float) $instance['longitude'];
		$info->static      = $instance['static'];
		$info->mapOptions->mapTypeId = $instance['map-type'];
		$info->mapOptions->zoom      = (int) $instance['zoom'];

		if ( $info->is_dynamic() ) {
			Pronamic_Google_Maps_Site::require_site_script();
		}

		echo Pronamic_Google_Maps_Maps::get_map_html( $info );

		echo $args['after_widget'];
		// @codingStandardsIgnoreEnd
	}

	//////////////////////////////////////////////////

	/**
	 * Update the widget data
	 *
	 * @param array $newInstance
	 * @param array $oldInstance
	 */
	public function update( $newInstance, $oldInstance ) {
		$instance = $oldInstance;

		$instance['title']       = strip_tags( $newInstance['title'] );
		$instance['description'] = $newInstance['description'];
		$instance['latitude']    = $newInstance['latitude'];
		$instance['longitude']   = $newInstance['longitude'];
		$instance['map-type']    = $newInstance['map-type'];
		$instance['zoom']        = $newInstance['zoom'];
		$instance['width']       = $newInstance['width'];
		$instance['height']      = $newInstance['height'];
		$instance['static']      = filter_var( $newInstance['static'], FILTER_VALIDATE_BOOLEAN );

		return $instance;
	}

	//////////////////////////////////////////////////

	/**
	 * Render the widget form
	 *
	 * @param array $instance
	 */
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			[
				'title'       => '',
				'description' => '',
				'latitude'    => 0,
				'longitude'   => 0,
				'map-type'    => '',
				'zoom'        => '',
				'width'       => '100',
				'height'      => '200',
				'static'      => false,
			] 
		);

		include plugin_dir_path( Pronamic_Google_Maps_Maps::$file ) . 'views/widget-form.php';
	}

	//////////////////////////////////////////////////

	/**
	 * Render unit field
	 *
	 * @param string $name
	 * @param string $value
	 */
	public function renderUnitField( $name, $value = null ) {
		$units = [
			[
				'value' => 'px',
				'label' => __( 'pixels', 'pronamic-google-maps' ),
			],
			[
				'value' => '%',
				'label' => __( 'percent', 'pronamic-google-maps' ),
			],
		];

		?>
		<select id="<?php echo esc_attr( $this->get_field_id( $name ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $name ) ); ?>">
			<?php foreach ( $units as $unit ) : ?>
				<option value="<?php echo esc_attr( $unit['value'] ); ?>" <?php selected( $value, $unit['value'] ); ?>>
					<?php echo esc_html( $unit['label'] ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	}
}
