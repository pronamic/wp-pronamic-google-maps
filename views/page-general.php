<?php

$options = Pronamic_Google_Maps::getOptions();

$types = get_post_types(array(
	'public' => true
) , 'objects');

$activeTypes = $options['active'];

?>
<div id="pgm" class="wrap">
	<?php screen_icon(Pronamic_Google_Maps::SLUG); ?>

	<h2><?php echo esc_html(__('Configuration - Pronamic Google Maps', Pronamic_Google_Maps::TEXT_DOMAIN)); ?></h2>

	<form action="" method="post">
		<?php wp_nonce_field('pronamic_google_maps_update_options', Pronamic_Google_Maps::NONCE_NAME); ?>

		<table cellspacing="0" class="widefat fixed">

			<?php foreach(array('thead', 'tfoot') as $tag): ?>

			<<?php echo $tag; ?>>
				<tr>
					<th scope="col" class="manage-column"><?php _e('Post type', Pronamic_Google_Maps::TEXT_DOMAIN); ?></th>
					<th scope="col" class="manage-column"><?php _e('Active', Pronamic_Google_Maps::TEXT_DOMAIN); ?></th>
				</tr>
			</<?php echo $tag; ?>>

			<?php endforeach; ?>

			<tbody>

				<?php foreach($types as $name => $type): ?>

				<tr>
					<th scope="row">
						<label for="pronamic-google-maps-type-<?php echo $name; ?>">
							<?php echo $type->labels->singular_name; ?>
						</label>
					</th>
					<td>
						<?php $active = isset($activeTypes[$name]) && $activeTypes[$name]; ?>

						<input id="pronamic-google-maps-type-<?php echo $name; ?>" name="_pronamic_google_maps_active[]" value="<?php echo $name; ?>" type="checkbox" <?php if($active): ?>checked="checked"<?php endif; ?> />

						<label for="pronamic-google-maps-type-<?php echo $name; ?>">
							<?php _e('Activate Google Maps', Pronamic_Google_Maps::TEXT_DOMAIN); ?>
						</label>
					</td>
				</tr>

				<?php endforeach; ?>

			</tbody>
		</table>

		<input type="hidden" name="pronamic_google_maps_action" value="update" />

		<?php submit_button(__('Save Changes', Pronamic_Google_Maps::TEXT_DOMAIN)); ?>
	</form>
</div>