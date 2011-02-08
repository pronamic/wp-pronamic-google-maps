<?php

$options = Pronamic_Google_Maps::getOptions();

$title = __('Configuration - Pronamic Google Maps', Pronamic_Google_Maps::TEXT_DOMAIN);

$types = get_post_types(array(
	'public' => true
) , 'objects');

$activeTypes = $options['active'];

?>
<div id="pgm" class="wrap">
	<?php screen_icon(); ?>

	<h2><?php echo esc_html($title); ?></h2>

	<form action="" method="post">
		<?php wp_nonce_field('pronamic_google_maps_update_options', Pronamic_Google_Maps::NONCE_NAME); ?>

		<div class="tablenav"></div>

		<table cellspacing="0" class="widefat page fixed">

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
							<?php echo $type->labels->name; ?>
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

		<p class="submit">
			<input type="hidden" name="pronamic_google_maps_action" value="update" />
			<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', Pronamic_Google_Maps::TEXT_DOMAIN) ?>" />
		</p>
	</form>
</div>