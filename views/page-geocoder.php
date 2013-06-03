<div id="pgm" class="wrap">
	<?php screen_icon(Pronamic_Google_Maps_Maps::SLUG); ?>

	<h2><?php echo esc_html(__('Geocoder - Pronamic Google Maps', 'pronamic_google_maps')); ?></h2>

	<?php 
	
	$query = new WP_Query();
	$query->query(Pronamic_Google_Maps_Admin::getGeocodeQueryArgs());
	
	?>

	<p>
		<?php 

		printf(__('Number posts to geocode: %s', 'pronamic_google_maps') ,
			sprintf('<strong id="pgm-found-posts">%s</strong>', $query->found_posts)
		); 

		?>
	</p>

	<?php if($query->have_posts()): $query->the_post(); ?>

	<form id="pgm-geocoder" action="" method="post">
		<table class="form-table">
			<?php $pgm = pronamic_get_google_maps_meta(); ?>
			<tr>
				<th scope="row">
					<label for="pgm-id-field"><?php _e('ID', 'pronamic_google_maps'); ?></label>
				</th>
				<td>
					<input name="action" value="pgm_geocode" type="hidden"  />

					<input id="pgm-id-field" name="post_ID" value="<?php the_ID(); ?>" type="text" class="readonly" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="pgm-title-field"><?php _e('Title', 'pronamic_google_maps'); ?></label>
				</th>
				<td>
					<input id="pgm-title-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_TITLE; ?>" value="<?php the_title(); ?>" class="regular-text readonly" type="text" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="pgm-address-field"><?php _e('Address', 'pronamic_google_maps'); ?></label>
				</th>
				<td>
					<textarea id="pgm-address-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_ADDRESS; ?>" rows="3" cols="50" class="readonly" readonly="readonly"><?php echo esc_attr($pgm->address); ?></textarea>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="pgm-status-field"><?php _e('Status', 'pronamic_google_maps'); ?></label>
				</th>
				<td>
					<input id="pgm-status-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS; ?>" value="" class="regular-text readonly" type="text" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e('Location', 'pronamic_google_maps'); ?>
				</th>
				<td>
					<input id="pgm-lat-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_LATITUDE; ?>" value="<?php echo esc_attr($pgm->latitude); ?>" type="text" class="readonly" readonly="readonly" />
					&deg; 
					<input id="pgm-lng-field" name="<?php echo Pronamic_Google_Maps_Post::META_KEY_LONGITUDE; ?>" value="<?php echo esc_attr($pgm->longitude); ?>" type="text" class="readonly" readonly="readonly" />
					&deg; 
				</td>
			</tr>
		</table>

		<?php submit_button(__('Geocode', 'pronamic_google_maps')); ?>
	</form>

	<?php endif; 
	
	wp_reset_postdata(); 
	
	$query = new WP_Query();
	$query->query(array(
		'post_type' => 'any', 
		'posts_per_page' => 10 , 
		'meta_query' => array(
			array(
				'key' => Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS ,
				'value' => Pronamic_Google_Maps_GeocoderStatus::ZERO_RESULTS 
			) 
		)
	));
	
	if($query->have_posts()): ?>

	<h2><?php echo esc_html(__('Zero results', 'pronamic_google_maps')); ?></h2>

	<p>
		<?php 

		printf(
			__('We found no geocoding results for the following %s posts, adjust them manually if needed.'), 
			sprintf('<strong>%d</strong>', $query->found_posts)
		); 

		?>
	</p>

	<table cellspacing="0" class="widefat page fixed">

		<?php foreach(array('thead', 'tfoot') as $tag): ?>

		<<?php echo $tag; ?>>
			<tr>
				<th scope="col" class="manage-column"><?php _e('Title', 'pronamic_google_maps'); ?></th>
				<th scope="col" class="manage-column"><?php _e('Address', 'pronamic_google_maps'); ?></th>
			</tr>
		</<?php echo $tag; ?>>

		<?php endforeach; ?>

		<tbody>
	
			<?php while($query->have_posts()): $query->the_post(); ?>
	
			<tr>
				<?php $pgm = pronamic_get_google_maps_meta(); ?>
				<td>
					<a href="<?php echo get_edit_post_link(get_the_ID()); ?>">
						<?php the_title(); ?>
					</a>
				</td>
				<td>
					<?php echo nl2br($pgm->address); ?>
				</td>
			</tr>
	
			<?php endwhile; ?>

		</tbody>
	</table>

	<?php endif; ?>
</div>