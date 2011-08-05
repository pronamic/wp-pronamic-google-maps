<?php

$pgm = pronamic_get_google_maps_meta();

wp_nonce_field('save-post', Pronamic_Google_Maps::NONCE_NAME);

?>
<div id="pgm">
	<input id="pgm-map-type-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_MAP_TYPE; ?>" value="<?php echo esc_attr($pgm->mapType); ?>" type="hidden" />
	<input id="pgm-zoom-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_ZOOM; ?>" value="<?php echo esc_attr($pgm->zoom); ?>" type="hidden" />

	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="pgm-active-field"><?php _e('Active', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<input id="pgm-active-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_ACTIVE; ?>" value="true" type="checkbox" <?php if($pgm->active): ?>checked="checked"<?php endif; ?> /> 
				<label for="pgm-active-field"><?php _e('Show Google Maps', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="pgm-title-field"><?php _e('Title', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<input id="pgm-title-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_TITLE; ?>" value="<?php echo esc_attr($pgm->title); ?>" class="regular-text" type="text" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="pgm-description-field"><?php _e('Description', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<textarea id="pgm-description-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_DESCRIPTION; ?>" rows="3" cols="50"><?php echo esc_attr($pgm->description); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="pgm-address-field"><?php _e('Address', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<textarea id="pgm-address-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_ADDRESS; ?>" rows="3" cols="50"><?php echo esc_attr($pgm->address); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php _e('Geocoder', Pronamic_Google_Maps::TEXT_DOMAIN); ?>
			</th>
			<td>
				<input id="pgm-geocode-button" type="submit" value="<?php _e('Geocode &darr;', Pronamic_Google_Maps::TEXT_DOMAIN); ?>" class="button" name="pgm_geocode" />

				<input id="pgm-reverse-geocode-button" type="submit" value="<?php echo _e('Reverse Geocode &uarr;', Pronamic_Google_Maps::TEXT_DOMAIN); ?>" class="button" name="pgm_reverse_geocode" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php _e('Location', Pronamic_Google_Maps::TEXT_DOMAIN); ?>
			</th>
			<td>
				<input id="pgm-lat-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_LATITUDE; ?>" value="<?php echo esc_attr($pgm->latitude); ?>" type="text" />
				&deg; 
				<input id="pgm-lng-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_LONGITUDE; ?>" value="<?php echo esc_attr($pgm->longitude); ?>" type="text" />
				&deg; 
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<span class="description"><?php _e('Tip: Change the zoom level and map type to your own wishes.', Pronamic_Google_Maps::TEXT_DOMAIN); ?></span>
			</td>
		</tr>
	</table>

	<div id="pgm-canvas" style="width: 100%; height: 500px;"></div>
</div>