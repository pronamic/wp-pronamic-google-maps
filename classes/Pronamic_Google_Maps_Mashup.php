<?php

/**
 * Title: Pronamic Google Maps mashup
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_Mashup {
	public static function render($q = array(), $arguments = array()) {
		Pronamic_Google_Maps_Site::$printScripts = true;

		$defaults = array(
			'width' => 500 ,
			'height' => 300 , 
			'zoom' => 8 , 
			'map_type_id' => Pronamic_Google_Maps_MapTypeId::ROADMAP , 
			'hide_list' => true , 
			'fit_founds' => true , 
			'marker_options' => array(
		
			) , 
			'echo' => true
		);
	
		$arguments = wp_parse_args($arguments, $defaults);

		$query = new WP_Query();
		$query->query($q);

		$options = new stdClass();
		$options->width = $arguments['width'];
		$options->height = $arguments['height'];
		$options->zoom = $arguments['zoom'];
		$options->mapTypeId = $arguments['map_type_id'];
		$options->hideList = $arguments['hide_list'];
		$options->fitBounds = $arguments['fit_founds'];
		$options->markerOptions = new stdClass();
		foreach($arguments['marker_options'] as $key => $value) {
			$options->markerOptions->$key = $value;
		}

		if($query->have_posts()) {
			$content = '<div class="pgmm">';

			$content .= sprintf('<input type="hidden" name="pgmm-info" value="%s" />', esc_attr(json_encode($options)));

			$content .= sprintf('<div class="canvas" style="width: %dpx; height: %dpx;">', $options->width, $options->height);
			$content .= sprintf('</div>');

			$content .= '<ul>';

			while($query->have_posts()) { $query->the_post();
				$pgm = Pronamic_Google_Maps::getMetaData();

				if($pgm->active) {
					$info = new Pronamic_Google_Maps_Info();
					$info->title = $pgm->title;
					$info->description = $pgm->description;
					$info->latitude = $pgm->latitude;
					$info->longitude = $pgm->longitude;
					$info->mapType = $pgm->mapType;
					$info->zoom = $pgm->zoom;
					
					$content .= '<li>';
					$content .= sprintf('<input type="hidden" name="pgm-info" value="%s" />', esc_attr(json_encode($info)));

					$itemContent = sprintf(
						'<a href="%s" title="%s" rel="bookmark">%s</a>' , 
						get_permalink() , 
						sprintf(esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' )) , 
						get_the_title()
					);

					$content .= apply_filters(Pronamic_Google_Maps_Filters::FILTER_MASHUP_ITEM, $itemContent);
					$content .= '</li>';
				}
			}

			wp_reset_postdata();

			$content .= '</ul>';
			$content .= '</div>';

			if($arguments['echo']) {
				echo $content;
			} else {
				return $content;
			}
		}
	}
}
