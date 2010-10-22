<?php

/**
 * Title: Pronamic Google Maps widget
 * Description: 
 * Copyright: Copyright (c) 2005 - 2010
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 * @doc http://codex.wordpress.org/Widgets_API
 *      http://codex.wordpress.org/Function_Reference/wp_enqueue_script
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
				'pronamic-google-maps-widget', 
				Pronamic_Google_Maps::$pluginUrl . 'js/widget.js' ,
				array('jquery') 
			);
		}
	}

	public function widget($arguments, $instance) {
		extract($arguments);

		var_dump($instance);
	} 

	public function update($newInstance, $oldInstance) {
		$instance = $oldInstance;

		$instance['title'] = strip_tags($newInstance['title']);
		$instance['description'] = $newInstance['description'];
		$instance['latitude'] = $newInstance['latitude'];
		$instance['longitude'] = $newInstance['longitude'];
		$instance['map-type'] = $newInstance['map-type'];
		$instance['zoom'] = $newInstance['zoom'];
		$instance['width'] = $newInstance['width'];
		$instance['width-unit'] = $newInstance['width-unit'];
		$instance['height'] = $newInstance['height'];
		$instance['height-unit'] = $newInstance['height-unit'];

        return $instance;		
	}

	public function form($instance) {
		$instance = wp_parse_args((array) $instance, array(
			'title' => '' , 
			'description' => '' , 
			'latitude' => '' , 
			'longitude' => '' , 
			'map-type' => '' , 
			'zoom' => '' , 
			'width' => '100' , 
			'width-unit' => 'pixels' ,  
			'height' => '200' , 
			'height-unit' => 'pixels'
		));

		include Pronamic_Google_Maps::$pluginPath . 'views/widget-form.php';
	}

	public function renderUnitField($name, $value = null) {
		$units = array(
			array('value' => 'pixels', 'label' => __('pixels', Pronamic_Google_Maps::TEXT_DOMAIN)) , 
			array('value' => 'percentages', 'label' => __('percent', Pronamic_Google_Maps::TEXT_DOMAIN)) 
		);

		?>
		<select id="<?php echo $this->get_field_id($name); ?>" name="<?php echo $this->get_field_id($name); ?>">
			<?php foreach($units as $unit): ?>
			<option value="<?php echo $unit['value']; ?>" <?php if($value == $unit['value']): ?>checked="checked"<?php endif?>>
				<?php echo $unit['label']; ?>
			</option>
			<?php endforeach; ?>
		</select>
		<?php
	}
}
