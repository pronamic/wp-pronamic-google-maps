<?php

$pgm = pronamic_get_google_maps_meta();

wp_nonce_field('save-post', Pronamic_Google_Maps::NONCE_NAME);

?>
<div id="pgm">
	<input id="pgm-map-type-field" name="<?php echo Pronamic_Google_Maps::META_KEY_MAP_TYPE; ?>" value="<?php echo esc_attr($pgm->mapType); ?>" type="hidden" />
	<input id="pgm-zoom-field" name="<?php echo Pronamic_Google_Maps::META_KEY_ZOOM; ?>" value="<?php echo esc_attr($pgm->zoom); ?>" type="hidden" />

	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="pgm-active-field"><?php echo _e('Active', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<input id="pgm-active-field" name="<?php echo Pronamic_Google_Maps::META_KEY_ACTIVE; ?>" value="true" type="checkbox" <?php if($pgm->active): ?>checked="checked"<?php endif; ?> /> 
				<label for="pgm-active-field"><?php echo _e('Show Google Maps', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="pgm-title-field"><?php echo _e('Title', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<input id="pgm-title-field" name="<?php echo Pronamic_Google_Maps::META_KEY_TITLE; ?>" value="<?php echo esc_attr($pgm->title); ?>" type="text" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="pgm-description-field"><?php echo _e('Description', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<textarea id="pgm-description-field" name="<?php echo Pronamic_Google_Maps::META_KEY_DESCRIPTION; ?>" rows="3" cols="50"><?php echo esc_attr($pgm->description); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="pgm-lat-field"><?php echo _e('Latitude', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<input id="pgm-lat-field" name="<?php echo Pronamic_Google_Maps::META_KEY_LATITUDE; ?>" value="<?php echo esc_attr($pgm->latitude); ?>" type="text" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="pgm-lng-field"><?php echo _e('Longitude', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<input id="pgm-lng-field" name="<?php echo Pronamic_Google_Maps::META_KEY_LONGITUDE; ?>" value="<?php echo esc_attr($pgm->longitude); ?>" type="text" />
			</td>
		</tr>
	</table>

	<div id="pgm-canvas" style="width: 100%; height: 500px;"></div>
</div>