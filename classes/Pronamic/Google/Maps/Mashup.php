<?php

/**
 * Title: Pronamic Google Maps mashup
 * Description:
 * Copyright: Copyright (c) 2005 - 2015
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_Google_Maps_Mashup {
	public static function render( $q = [], $arguments = [] ) {
		Pronamic_Google_Maps_Site::require_site_script();

		$defaults = [
			'width'                  => Pronamic_Google_Maps_Maps::$defaultWidth,
			'height'                 => Pronamic_Google_Maps_Maps::$defaultHeight,
			'latitude'               => 0,
			'longitude'              => 0,
			'zoom'                   => Pronamic_Google_Maps_Maps::MAP_ZOOM_DEFAULT,
			'map_type_id'            => Pronamic_Google_Maps_Maps::MAP_TYPE_DEFAULT,
			'hide_list'              => true,
			'fit_bounds'             => true,
			'center_client_location' => false,
			'marker_options'         => [],
			'map_options'            => [],
			'marker_cluster_options' => [],
			'echo'                   => true,
		];

		$arguments = wp_parse_args( $arguments, $defaults );

		if ( $q instanceof WP_Query ) {
			$query = $q;
		} else {
			$query = new WP_Query( $q );
		}

		$options        = new stdClass();
		$options->width = $arguments['width'];
		if ( is_numeric( $options->width ) ) {
			$options->width = '' . $options->width . 'px';
		}
		$options->height = $arguments['height'];
		if ( is_numeric( $options->height ) ) {
			$options->height = '' . $options->height . 'px';
		}
		$options->center               = new stdClass();
		$options->center->latitude     = $arguments['latitude'];
		$options->center->longitude    = $arguments['longitude'];
		$options->hideList             = $arguments['hide_list'];
		$options->fitBounds            = filter_var( $arguments['fit_bounds'], FILTER_VALIDATE_BOOLEAN );
		$options->centerClientLocation = $arguments['center_client_location'];

		// Map options
		$options->mapOptions            = new stdClass();
		$options->mapOptions->mapTypeId = $arguments['map_type_id'];
		$options->mapOptions->zoom      = $arguments['zoom'];
		foreach ( $arguments['map_options'] as $key => $value ) {
			$value = apply_filters( 'pronamic_google_maps_map_options_' . $key, $value );

			$options->mapOptions->$key = $value;
		}

		// Marker cluster options
		if ( ! empty( $arguments['marker_clusterer_options'] ) ) {
			wp_enqueue_script( 'google-maps-marker-clusterer-plus' );

			$options->markerClustererOptions = new stdClass();
			foreach ( $arguments['marker_clusterer_options'] as $key => $value ) {
				$value = apply_filters( 'pronamic_google_maps_marker_clusterer_options_' . $key, $value );

				$options->markerClustererOptions->$key = $value;
			}
		}

		// Overlapping marker spiderfier options
		if ( isset( $arguments['overlapping_marker_spiderfier_options'] ) ) {
			wp_enqueue_script( 'google-maps-overlapping-marker-spiderfier' );

			$options->overlappingMarkerSpiderfierOptions = new stdClass();

			if ( is_array( $arguments['overlapping_marker_spiderfier_options'] ) ) {
				foreach ( $arguments['overlapping_marker_spiderfier_options'] as $key => $value ) {
					$options->overlappingMarkerSpiderfierOptions->$key = $value;
				}
			}
		}

		// Markers
		$options->markers = [];

		// HTML
		$items = '';
		while ( $query->have_posts() ) {
			$query->the_post();

			$pgm = Pronamic_Google_Maps_Maps::get_meta_data();

			if ( $pgm->active ) {
				$description = sprintf(
					'<a href="%s" title="%s" rel="bookmark">%s</a>',
					get_permalink(),
					sprintf(
						/* translators: %s: the title attribute */
						esc_attr__( 'Permalink to %s', 'pronamic-google-maps' ),
						the_title_attribute( 'echo=0' )
					),
					get_the_title()
				);

				$description = apply_filters( 'pronamic_google_maps_mashup_item', $description );

				$info                = new Pronamic_Google_Maps_Info();
				$info->title         = $pgm->title;
				$info->description   = $pgm->description;
				$info->latitude      = $pgm->latitude;
				$info->longitude     = $pgm->longitude;
				$info->markerOptions = new stdClass();

				// Marker options
				$marker_options = $arguments['marker_options'];
				$marker_options = apply_filters( 'pronamic_google_maps_marker_options', $marker_options );

				foreach ( $marker_options as $key => $value ) {
					$value = apply_filters( 'pronamic_google_maps_marker_options_' . $key, $value );

					$info->markerOptions->$key = $value;
				}

				$marker              = new stdClass();
				$marker->options     = $info->markerOptions;
				$marker->lat         = $pgm->latitude;
				$marker->lng         = $pgm->longitude;
				$marker->title       = $pgm->title;
				$marker->description = $description;
				$marker->post_id     = get_the_ID();

				$options->markers[] = $marker;

				$items .= '<li>';
				$items .= sprintf( '<input type="hidden" name="pgm-info" value="%s" />', esc_attr( wp_json_encode( $info ) ) );

				$item = sprintf(
					'<a href="%s" title="%s" rel="bookmark">%s</a>',
					get_permalink(),
					sprintf(
						/* translators: %s: the title attribute */
						esc_attr__( 'Permalink to %s', 'pronamic-google-maps' ),
						the_title_attribute( 'echo=0' )
					),
					get_the_title()
				);

				$items .= apply_filters( 'pronamic_google_maps_mashup_item', $item );
				$items .= '</li>';
			}
		}

		wp_reset_postdata();

		$content  = '<div class="pgmm">';
		$content .= sprintf( '<input type="hidden" name="pgmm-info" value="%s" />', esc_attr( wp_json_encode( $options ) ) );

		$content .= sprintf( '<div class="canvas" style="width: %s; height: %s;">', esc_attr( $options->width ), esc_attr( $options->height ) );
		$content .= sprintf( '</div>' );

		if ( ! empty( $items ) ) {
			$content .= '<noscript>';
			$content .= '<ul>';
			$content .= $items;
			$content .= '</ul>';
			$content .= '</noscript>';
		}

		$content .= '</div>';

		if ( $arguments['echo'] ) {
			// @codingStandardsIgnoreStart
			echo $content;
			// @codingStandardsIgnoreEnd
		} else {
			return $content;
		}
	}
}
