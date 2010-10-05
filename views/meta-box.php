<?php

$pgm = pronamic_get_google_maps_meta();

wp_nonce_field('save-post', Pronamic_Google_Maps::NONCE_NAME);

?>
<div id="pronamic-google-maps">
	<input id="pronamic-latitude-field" name="<?php echo Pronamic_Google_Maps::META_KEY_LATITUDE; ?>" value="<?php echo esc_attr($pgm->latitude); ?>" type="hidden" />
	<input id="pronamic-longitude-field" name="<?php echo Pronamic_Google_Maps::META_KEY_LONGITUDE; ?>" value="<?php echo esc_attr($pgm->longitude); ?>" type="hidden" />
	<input id="pronamic-google-maps-map-type" name="<?php echo Pronamic_Google_Maps::META_KEY_MAP_TYPE; ?>" value="<?php echo esc_attr($pgm->mapType); ?>" type="hidden" />
	<input id="pronamic-google-maps-zoom" name="<?php echo Pronamic_Google_Maps::META_KEY_ZOOM; ?>" value="<?php echo esc_attr($pgm->zoom); ?>" type="hidden" />

	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="pronamic-google-maps-active"><?php echo _e('Active', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<input id="pronamic-google-maps-active" name="<?php echo Pronamic_Google_Maps::META_KEY_ACTIVE; ?>" value="true" type="checkbox" <?php if($pgm->active): ?>checked="checked"<?php endif; ?> /> 
				<label for="pronamic-google-maps-active"><?php echo _e('Show Google Maps', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="pronamic-title-field"><?php echo _e('Title', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<input id="pronamic-title-field" name="<?php echo Pronamic_Google_Maps::META_KEY_TITLE; ?>" value="<?php echo esc_attr($pgm->title); ?>" type="text" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="pronamic-description-field"><?php echo _e('Description', Pronamic_Google_Maps::TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<textarea id="pronamic-description-field" name="<?php echo Pronamic_Google_Maps::META_KEY_DESCRIPTION; ?>" rows="3" cols="50"><?php echo esc_attr($pgm->description); ?></textarea>
			</td>
		</tr>
	</table>

	<div id="pronamic-google-maps-canvas" style="width=100%; height:500px;"></div>
</div>