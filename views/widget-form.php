<?php

$title       = strip_tags( $instance['title'] );
$description = format_to_edit( $instance['description'] );
$latitude    = strip_tags( $instance['latitude'] );
$longitude   = strip_tags( $instance['longitude'] );
$mapType     = $instance['map-type'];
$zoom        = $instance['zoom'];
$width       = $instance['width'];
$height      = $instance['height'];
$static      = $instance['static'];

?>
<div id="<?php echo $this->get_field_id( 'pgm' ); ?>" class="pronamic-google-maps-widget">
	<input class="map-type-field" id="<?php echo $this->get_field_id( 'map-type' ); ?>" name="<?php echo $this->get_field_name( 'map-type' ); ?>" value="<?php echo esc_attr( $mapType ); ?>" type="hidden" />
	<input class="zoom-field" id="<?php echo $this->get_field_id( 'zoom' ); ?>" name="<?php echo $this->get_field_name( 'zoom' ); ?>" value="<?php echo esc_attr( $zoom ); ?>" type="hidden" />

	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">
			<?php _e( 'Title', 'pronamic_google_maps' ); ?>:
		</label>

		<input class="widefat title-field" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'description' ); ?>">
			<?php _e( 'Description', 'pronamic_google_maps' ); ?>:
		</label>

		<textarea class="widefat description-field" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" rows="3" cols="20"><?php echo $description; ?></textarea>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'latitude' ); ?>">
			<?php _e( 'Latitude', 'pronamic_google_maps' ); ?>:
		</label>

		<input class="latitude-field" id="<?php echo $this->get_field_id( 'latitude' ); ?>" name="<?php echo $this->get_field_name( 'latitude' ); ?>" type="text" value="<?php echo $latitude; ?>" size="16" /> &deg;

		<label for="<?php echo $this->get_field_id( 'longitude' ); ?>">
			<?php _e( 'Longitude', 'pronamic_google_maps' ); ?>:
		</label>

		<input class="longitude-field" id="<?php echo $this->get_field_id( 'longitude' ); ?>" name="<?php echo $this->get_field_name( 'longitude' ); ?>" type="text" value="<?php echo $longitude; ?>" size="16" /> &deg;
	</p>

	<div class="google-maps-canvas" style="width: 100%; height: 300px; margin: 1em 0;"></div>

	<p>
		<label for="<?php echo $this->get_field_id( 'width' ); ?>">
			<?php _e( 'Width', 'pronamic_google_maps' ); ?>:
		</label>

		<input id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo $width; ?>" size="3" />
		pixels

		&times;
		<label for="<?php echo $this->get_field_id( 'height' ); ?>">
			<?php _e( 'Height', 'pronamic_google_maps' ); ?>:
		</label>

		<input id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo $height; ?>" size="3" />
		pixels
	</p>

	<p>
		<input id="<?php echo $this->get_field_id( 'static-false' ); ?>" name="<?php echo $this->get_field_name( 'static' ); ?>" value="false" type="radio" <?php if ( ! $static ) : ?>checked="checked"<?php endif; ?> />
		<label for="<?php echo $this->get_field_id( 'static-false' ); ?>"><?php _e( 'Dynamic', 'pronamic_google_maps' ); ?></label>

		<input id="<?php echo $this->get_field_id( 'static-true' ); ?>" name="<?php echo $this->get_field_name( 'static' ); ?>" value="true" type="radio" <?php if ( $static ) : ?>checked="checked"<?php endif; ?> />
		<label for="<?php echo $this->get_field_id( 'static-true' ); ?>"><?php _e( 'Static', 'pronamic_google_maps' ); ?></label>
	</p>
</div>

<?php if ( defined( 'DOING_AJAX' ) ) : ?>

	<script type="text/javascript">
		<!--//--><![CDATA[//><!--
		jQuery("#<?php echo $this->get_field_id( 'pgm' ); ?>").pronamicGoogleMapsWidget();
		//--><!]]>
	</script>

<?php endif; ?>
