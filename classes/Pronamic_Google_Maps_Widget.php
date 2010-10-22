<?php

/**
 * Title: Pronamic Google Maps widget
 * Description: 
 * Copyright: Copyright (c) 2005 - 2010
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 * @doc http://codex.wordpress.org/Widgets_API
 */
class Pronamic_Google_Maps_Widget extends WP_Widget {
	/**
	 * Constructs and initialize the Google Maps meta box
	 */
	public function Pronamic_Google_Maps_Widget() {
		$description = __('Use this widget to add an Google Maps as a widget.', Pronamic_Google_Maps::TEXT_DOMAIN);
		$widgetOptions = array('classname' => 'pronamic_google_maps_widget', 'description' => $description);
		$controlOptions = array('width' => 400);

		parent::WP_Widget('pronamic_google_maps', __('Google Maps', Pronamic_Google_Maps::TEXT_DOMAIN), $widgetOptions, $controlOptions);

		if(is_admin()) {
			wp_enqueue_script(
				'pronamic_google_maps_widget', 
				Pronamic_Google_Maps::$pluginUrl . 'js/widget.js' ,
				array('jquery') 
			);
		}
	}

	public function widget($arguments, $instance) {
		extract($arguments);

		
	} 

	public function update($newInstance, $oldInstance) {
		$instance = $oldInstance;

		$instance['title'] = strip_tags($newInstance['title']);
		$instance['description'] = $newInstance['description'];
		$instance['latitude'] = $newInstance['latitude'];
		$instance['longitude'] = $newInstance['longitude'];
		

        return $instance;		
	}

	public function form($instance) {
		$instance = wp_parse_args((array) $instance, array(
			'title' => '' , 
			'description' => '' , 
			'latitude' => '' , 
			'longitude' => ''
		));

		include Pronamic_Google_Maps::$pluginPath . 'views/widget-form.php';
	}
}
