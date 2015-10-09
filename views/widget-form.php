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
<div id="<?php echo esc_attr( $this->get_field_id( 'pgm' ) ); ?>" class="pronamic-google-maps-widget">
	<input class="map-type-field" id="<?php echo esc_attr( $this->get_field_id( 'map-type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'map-type' ) ); ?>" value="<?php echo esc_attr( $mapType ); ?>" type="hidden" />
	<input class="zoom-field" id="<?php echo esc_attr( $this->get_field_id( 'zoom' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'zoom' ) ); ?>" value="<?php echo esc_attr( $zoom ); ?>" type="hidden" />

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
			<?php esc_html_e( 'Title', 'pronamic-google-maps' ); ?>:
		</label>

		<input class="widefat title-field" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>">
			<?php esc_html_e( 'Description', 'pronamic-google-maps' ); ?>:
		</label>

		<textarea class="widefat description-field" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" rows="3" cols="20"><?php echo esc_textarea( $description ); ?></textarea>
	</p>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'latitude' ) ); ?>">
			<?php esc_html_e( 'Latitude', 'pronamic-google-maps' ); ?>:
		</label>

		<input class="latitude-field" id="<?php echo esc_attr( $this->get_field_id( 'latitude' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'latitude' ) ); ?>" type="text" value="<?php echo esc_attr( $latitude ); ?>" size="16" /> &deg;

		<label for="<?php echo esc_attr( $this->get_field_id( 'longitude' ) ); ?>">
			<?php esc_html_e( 'Longitude', 'pronamic-google-maps' ); ?>:
		</label>

		<input class="longitude-field" id="<?php echo esc_attr( $this->get_field_id( 'longitude' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'longitude' ) ); ?>" type="text" value="<?php echo esc_attr( $longitude ); ?>" size="16" /> &deg;
	</p>

	<div class="google-maps-canvas" style="width: 100%; height: 300px; margin: 1em 0;"></div>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>">
			<?php esc_html_e( 'Width', 'pronamic-google-maps' ); ?>:
		</label>

		<input id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" size="3" />
		pixels

		&times;
		<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>">
			<?php esc_html_e( 'Height', 'pronamic-google-maps' ); ?>:
		</label>

		<input id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="text" value="<?php echo esc_attr( $height ); ?>" size="3" />
		pixels
	</p>

	<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'static-false' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'static' ) ); ?>" value="false" type="radio" <?php if ( ! $static ) : ?>checked="checked"<?php endif; ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'static-false' ) ); ?>"><?php esc_html_e( 'Dynamic', 'pronamic-google-maps' ); ?></label>

		<input id="<?php echo esc_attr( $this->get_field_id( 'static-true' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'static' ) ); ?>" value="true" type="radio" <?php if ( $static ) : ?>checked="checked"<?php endif; ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'static-true' ) ); ?>"><?php esc_html_e( 'Static', 'pronamic-google-maps' ); ?></label>
	</p>
</div>

<?php if ( defined( 'DOING_AJAX' ) ) : ?>

	<script type="text/javascript">
		<!--//--><![CDATA[//><!--
		jQuery( "#<?php echo esc_js( $this->get_field_id( 'pgm' ) ); ?>" ).pronamicGoogleMapsWidget();
		//--><!]]>
	</script>

<?php endif; ?>
