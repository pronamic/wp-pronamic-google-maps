<div class="postbox">
	<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br /></div>

	<h3 class="hndle">
		<span><?php _e('Post Types', Pronamic_Google_Maps::TEXT_DOMAIN); ?></span>
	</h3>

	<div class="inside">

		<table class="form-table">

			<?php foreach($types as $name => $type): ?>

			<tr>
				<?php $active = isset($activeTypes[$name]) && $activeTypes[$name]; ?>

				<th scope="row">
					<label for="pronamic-google-maps-type-<?php echo $name; ?>">
						<?php echo $type->labels->name; ?>
					</label>
				</th>
				<td>
					<input id="pronamic-google-maps-type-<?php echo $name; ?>" name="_pronamic_google_maps_active[]" value="<?php echo $name; ?>" type="checkbox" <?php if($active): ?>checked="checked"<?php endif; ?> />

					<label for="pronamic-google-maps-type-<?php echo $name; ?>">
						<?php _e('Activate Google Maps functionality', Pronamic_Google_Maps::TEXT_DOMAIN); ?>
					</label>
				</td>
			</tr>

			<?php endforeach; ?>

		</table>

		<p class="submit">
			<input type="hidden" name="pronamic_google_maps_action" value="update" />
			<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', Pronamic_Google_Maps::TEXT_DOMAIN) ?>" />
		</p>
	</div>
</div>