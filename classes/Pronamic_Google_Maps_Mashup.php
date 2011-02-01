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
	public static function render($q, $arguments) {
		$defaults = array(
			'width' => 500 ,
			'height' => 300 
		);
	
		$arguments = wp_parse_args($arguments, $defaults);

		$query = new WP_query();
		$query->query($q);

		if($query->have_posts()): ?>
		
		<div class="pgmm">
			<input type="hidden" name="options" value="<?php echo esc_attr(json_encode($options)); ?>" />
		
			<div class="canvas" style="width: 650px; height: 400px;">
				
			</div>

			<ul>

				<?php while($query->have_posts()): $query->the_post(); ?>
		
				<li>
					<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</li>
		
				<?php endwhile; ?>
		
			</ul>
		</div>

		<?php endif;
	}
}
