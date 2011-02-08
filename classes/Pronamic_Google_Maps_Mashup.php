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
	/**
	 * Render an Google Maps for the current global post
	 * 
	 * @param mixed $arguments
	 */
	public static function render($q = array(), $arguments = array()) {
		$defaults = array(
			'width' => 500 ,
			'height' => 300 , 
			'zoom' => 8 , 
			'map_type_id' => 'roadmap' , 
			'hide_list' => true
		);
	
		$arguments = wp_parse_args($arguments, $defaults);

		$query = new WP_query();
		$query->query($q);

		$options = new stdClass();
		$options->width = $arguments['width'];
		$options->height = $arguments['height'];
		$options->zoom = $arguments['zoom'];
		$options->mapTypeId = $arguments['map_type_id'];
		$options->hideList = $arguments['hide_list'];

		if($query->have_posts()): ?>
		
		<div class="pgmm">
			<input type="hidden" name="options" value="<?php esc_attr_e(json_encode($options)); ?>" />
		
			<div class="canvas" style="width: 650px; height: 400px;">
				
			</div>

			<ul>

				<?php while($query->have_posts()): $query->the_post(); ?>
		
				<li>
					<?php 

					$pgm = Pronamic_Google_Maps::getMetaData();
		
					$info = new Pronamic_Google_Maps_Info();
					$info->title = $pgm->title;
					$info->description = $pgm->description;
					$info->latitude = $pgm->latitude;
					$info->longitude = $pgm->longitude;
					$info->mapType = $pgm->mapType;
					$info->zoom = $pgm->zoom;
					
					?>
					<input type="hidden" name="pgm-info" value="<?php echo esc_attr(json_encode($info)); ?>" />

					<?php 
					
					$content = sprintf(
						'<a href="%s" title="%s" rel="bookmark">%s</a>' , 
						get_permalink() , 
						sprintf(esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' )) , 
						get_the_title()
					);

					echo apply_filters(Pronamic_Google_Maps_Filters::FILTER_MASHUP_ITEM, $content);
					
					?>
				</li>
		
				<?php endwhile; ?>
		
			</ul>
		</div>

		<?php endif;
	}
}
