<?php 

$title = strip_tags($instance['title']);
$description = format_to_edit($instance['description']);
$latitude = strip_tags($instance['latitude']);
$longitude = strip_tags($instance['longitude']);
$mapType = $instance['map-type'];
$zoom = $instance['zoom'];
$width = $instance['width'];
$widthUnit = $instance['width-unit'];
$height = $instance['height'];
$heightUnit = $instance['height-unit'];

?>
<div id="<?php echo $this->get_field_id('pgm'); ?>" class="pronamic-google-maps-widget">
	<input class="map-type-field" id="<?php echo $this->get_field_id('map-type'); ?>" name="<?php echo $this->get_field_name('map-type'); ?>" value="<?php echo esc_attr($mapType); ?>" type="hidden" />
	<input class="zoom-field" id="<?php echo $this->get_field_id('zoom'); ?>" name="<?php echo $this->get_field_name('zoom'); ?>" value="<?php echo esc_attr($zoom); ?>" type="hidden" />

	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">
			<?php _e('Title', Pronamic_Google_Maps::TEXT_DOMAIN); ?>:
		</label>
	
		<input class="widefat title-field" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id('description'); ?>">
			<?php _e('Description', Pronamic_Google_Maps::TEXT_DOMAIN); ?>:
		</label>
	
		<textarea class="widefat description-field" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text" rows="3" cols="20"><?php echo $description; ?></textarea>
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id('latitude'); ?>">
			<?php _e('Latitude', Pronamic_Google_Maps::TEXT_DOMAIN); ?>:
		</label>
	
		<input class="latitude-field" id="<?php echo $this->get_field_id('latitude'); ?>" name="<?php echo $this->get_field_name('latitude'); ?>" type="text" value="<?php echo $latitude; ?>" size="8" /> &deg;

		<label for="<?php echo $this->get_field_id('longitude'); ?>">
			<?php _e('Longitude', Pronamic_Google_Maps::TEXT_DOMAIN); ?>:
		</label>
	
		<input class="longitude-field" id="<?php echo $this->get_field_id('longitude'); ?>" name="<?php echo $this->get_field_name('longitude'); ?>" type="text" value="<?php echo $longitude; ?>" size="8" /> &deg;
	</p>

	<div class="google-maps-canvas" style="width: 100%; height: 300px; margin: 1em 0;"></div>

	<p>
		<label for="<?php echo $this->get_field_id('width'); ?>">
			<?php _e('Width', Pronamic_Google_Maps::TEXT_DOMAIN); ?>:
		</label>
	
		<input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" size="3" />
		<?php $this->renderUnitField('width-unit', $widthUnit); ?>

		&times;
		<label for="<?php echo $this->get_field_id('height'); ?>">
			<?php _e('Height', Pronamic_Google_Maps::TEXT_DOMAIN); ?>:
		</label>
	
		<input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" size="3" />
		<?php $this->renderUnitField('height-unit', $heightUnit); ?>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('type'); ?>">
			<?php _e('Type', Pronamic_Google_Maps::TEXT_DOMAIN); ?>:
		</label>

		<select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
			<option value="dynamic"><?php _e('Dynamic', Pronamic_Google_Maps::TEXT_DOMAIN); ?></option>
			<option value="static"><?php _e('Static', Pronamic_Google_Maps::TEXT_DOMAIN); ?></option>
		</select>
	</p>	
</div>

<script type="text/javascript">
	//<![CDATA[
	pronamicGoogleMapsWidget("#<?php echo $this->get_field_id('pgm'); ?>");
	//]]>
</script>