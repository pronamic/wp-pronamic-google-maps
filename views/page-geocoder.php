<div id="pgm" class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php

	$query = new WP_Query();
	$query->query( Pronamic_Google_Maps_Admin::get_geocode_query_args() );

	?>

	<p>
		<?php

		echo wp_kses( sprintf( __( 'Number posts to geocode: %s', 'pronamic-google-maps' ),
			sprintf( '<strong id="pgm-found-posts">%s</strong>', $query->found_posts )
		), array( 'strong' => array() ) );

		?>
	</p>

	<?php if ( $query->have_posts() ) : $query->the_post(); ?>

		<form id="pgm-geocoder" action="" method="post">
			<table class="form-table">
				<?php $pgm = pronamic_get_google_maps_meta(); ?>
				<tr>
					<th scope="row">
						<label for="pgm-id-field"><?php esc_html_e( 'ID', 'pronamic-google-maps' ); ?></label>
					</th>
					<td>
						<input name="action" value="pgm_geocode" type="hidden"  />

						<input id="pgm-id-field" name="post_ID" value="<?php the_ID(); ?>" type="text" class="readonly" readonly="readonly" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="pgm-title-field"><?php esc_html_e( 'Title', 'pronamic-google-maps' ); ?></label>
					</th>
					<td>
						<input id="pgm-title-field" name="_pronamic_google_maps_title" value="<?php the_title(); ?>" class="regular-text readonly" type="text" readonly="readonly" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="pgm-address-field"><?php esc_html_e( 'Address', 'pronamic-google-maps' ); ?></label>
					</th>
					<td>
						<textarea id="pgm-address-field" name="_pronamic_google_maps_address" rows="3" cols="50" class="readonly" readonly="readonly"><?php echo esc_attr( $pgm->address ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="pgm-status-field"><?php esc_html_e( 'Status', 'pronamic-google-maps' ); ?></label>
					</th>
					<td>
						<input id="pgm-status-field" name="_pronamic_google_maps_geocode_status" value="" class="regular-text readonly" type="text" readonly="readonly" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<?php esc_html_e( 'Location', 'pronamic-google-maps' ); ?>
					</th>
					<td>
						<input id="pgm-lat-field" name="_pronamic_google_maps_latitude" value="<?php echo esc_attr( $pgm->latitude ); ?>" type="text" class="readonly" readonly="readonly" />
						&deg;
						<input id="pgm-lng-field" name="_pronamic_google_maps_longitude" value="<?php echo esc_attr( $pgm->longitude ); ?>" type="text" class="readonly" readonly="readonly" />
						&deg;
					</td>
				</tr>
			</table>

			<?php submit_button( __( 'Geocode', 'pronamic-google-maps' ) ); ?>
		</form>

	<?php endif;

	wp_reset_postdata();

	$query = new WP_Query();
	$query->query( array(
		'post_type'      => 'any',
		'posts_per_page' => 10,
		'meta_query'     => array(
			array(
				'key'   => '_pronamic_google_maps_geocode_status',
				'value' => Pronamic_Google_Maps_GeocoderStatus::ZERO_RESULTS,
			),
		),
	) );

	if ( $query->have_posts() ) : ?>

		<h2><?php echo esc_html( __( 'Zero results', 'pronamic-google-maps' ) ); ?></h2>

		<p>
			<?php

			echo wp_kses( sprintf(
				__( 'We found no geocoding results for the following %s posts, adjust them manually if needed.', 'pronamic-google-maps' ),
				sprintf( '<strong>%d</strong>', $query->found_posts )
			), array( 'strong' => array() ) );

			?>
		</p>

		<table cellspacing="0" class="widefat page fixed">
			<thead>
				<tr>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Title', 'pronamic-google-maps' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Address', 'pronamic-google-maps' ); ?></th>
				</tr>
			</thead>

			<tbody>

				<?php while ( $query->have_posts() ) : $query->the_post(); ?>

					<tr>
						<?php $pgm = pronamic_get_google_maps_meta(); ?>

						<td>
							<a href="<?php echo esc_attr( get_edit_post_link( get_the_ID() ) ); ?>">
								<?php the_title(); ?>
							</a>
						</td>
						<td>
							<?php echo wp_kses( nl2br( $pgm->address ), array( 'br' => array() ) ); ?>
						</td>
					</tr>

				<?php endwhile; ?>

			</tbody>
		</table>

	<?php endif; ?>
</div>
